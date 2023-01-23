<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Mail\ForgetPassword;
use App\Mail\ConfirmEmail;
use stdClass;

class AuthController extends Controller {
    private $successCode;
    private $databaseNodataCode;
    private $databaseErrorCode;
    private $errorCode;
    private $validationErrorCode;

    public function __construct() {
        $this->successCode = 200;
        $this->databaseNodataCode = 404;
        $this->databaseErrorCode = 201;
        $this->errorCode = 422;
        $this->validationErrorCode = 422;
    }

    /* SignUp */
        public function signup(Request $request) {
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => $this->validationErrorCode, 'message' => $validator->errors()]);
            }

            $crud = [
                'name' => $request->name ?? null,
                'email' => $request->email,
                'phone' => $request->phone ?? null,
                'dob' => Date("Y-m-d", strtotime($request->dob)) ?? null,
                'password' => bcrypt($request->password),
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $folder_to_upload = public_path() . '/uploads/users/';

            if (!empty($request->file('display_image'))) {
                $file = $request->file('display_image');
                $filenameWithExtension = $request->file('display_image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
                $extension = $request->file('display_image')->getClientOriginalExtension();
                $filenameToStore = time() . "dp_" . $filename . '.' . $extension;

                if (!File::exists($folder_to_upload))
                    File::makeDirectory($folder_to_upload, 0777, true, true);

                $crud['display_image'] = $filenameToStore;
            }

            if (!empty($request->file('cover_image'))) {
                $file1 = $request->file('cover_image');
                $filenameWithExtension1 = $request->file('cover_image')->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExtension1, PATHINFO_FILENAME);
                $extension1 = $request->file('cover_image')->getClientOriginalExtension();
                $filenameToStore1 = time() . "cp_" . $filename1 . '.' . $extension1;

                if (!File::exists($folder_to_upload)) {
                    File::makeDirectory($folder_to_upload, 0777, true, true);
                }

                $crud['cover_image'] = $filenameToStore1;
            }

            DB::beginTransaction();
            try {
                $user = User::insertGetId($crud);
                if ($user) {
                    if (!empty($request->file('display_image'))) {
                        $file->move($folder_to_upload, $filenameToStore);
                    }
                    if (!empty($request->file('cover_image'))) {
                        $file1->move($folder_to_upload, $filenameToStore1);
                    }
                    $randomNumber = random_int(1000, 9999);
                    $mailData = array('from_email' => _mail_from(), 'email' => $request->email, 'otp' => $randomNumber);
                    Mail::to($request->email)->send(new ConfirmEmail($mailData));
                    DB::table('password_resets')->insert([
                        'email' => $request->email,
                        'otp' => $randomNumber,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    DB::commit();
                    return response()->json(['status' => $this->successCode, 'message' => 'User inserted successfully.']);  
                }
            } catch (\Throwable $th) {
                DB::rollback();
                return response()->json(['status' => $this->errorCode, 'message' => 'Somthing went wrong!']);
            }
        }
    /* SignUp */

    /* Verify OTP */
        public function verifyEmail(Request $request) {
            $rules = [
                'email' => 'required',
                'otp' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => $this->validationErrorCode, 'message' => $validator->errors()]);
            }
            $verify_otp = DB::table('password_resets')->where(['email' => $request->email, 'otp' => $request->otp])->first();
            if ($verify_otp) {
                User::where('email', $request->email)->update(['status' => 'active']);
                DB::table('password_resets')->where(['email' => $request->email, 'otp' => $request->otp])->delete();
                return response()->json(['status' => $this->successCode, 'message' => 'OTP verified successfully.']);
            } else {
                return response()->json(['status' => $this->errorCode, 'message' => 'Invalid email or OTP!']);
            }
        }
    /* Verify OTP */

    /** login */
        public function login(Request $request) {
            $rules = ['email' => 'required', 'password' => 'required'];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails())
                return response()->json(['status' => 422, 'message' => 'Invalid Username or Password']);

            $auth = auth()->attempt(['email' => $request->email, 'password' => $request->password]);

            if (!$auth) {
                return response()->json(['status' => 401, 'message' => 'Invalid login details']);
            } else {
                $user = User::select(DB::raw("COALESCE(id,'') AS id"), DB::raw("COALESCE(name,'') AS name"), DB::raw("COALESCE(uid,'') AS uid"), DB::raw("COALESCE(phone,'') AS phone"), DB::raw("COALESCE(display_image,'') AS display_image"), DB::raw("COALESCE(cover_image,'') AS cover_image"), DB::raw("COALESCE(email,'') AS email"), DB::raw("COALESCE(status,'') AS status"), DB::raw("COALESCE(profile_type,'') AS profile_type"))->where('email', $request->email)->firstOrFail();

                if ($user->status == 'active') {
                    $token = $user->createToken('auth_token')->plainTextToken;
                    return response()->json(['status' => 200, 'message' => 'Login Successfully', 'token_type' => 'Bearer', 'access_token' => $token, 'data' => $user]);
                } else {
                    return response()->json(['status' => 201, 'message' => 'This account has been inactive or deleted, please contact admin']);
                }
            }
        }
    /** login */

    /* Social Login */
        public function socialAuth(Request $request) {
            $rules = ['uid' => 'required', 'email' => 'required'];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => 422, 'message' => 'Social login fail!']);
            }

            $x = false;

            $message = 'Login Successfully';

            $user = User::where(['uid' => $request->uid, 'email' => $request->email])->first();
            if ($user) {
                $x = true;
                $message = 'Social Login Successfully';
            }
            if (!$user) {
                $user = new stdClass();
                $curd = [
                    'email' => $request->email,
                    'uid' => $request->uid,
                    'status' => 'active',
                ];
                $user->id = User::insertGetId($curd);
                $message = 'Social Login Successfully';
                $x = true;
            }

            if ($x) {
                // dd($user);
                $auth = auth()->loginUsingId(['id' => $user->id]);
                if (!$auth) {
                    return response()->json(['status' => 401, 'message' => 'Invalid login details']);
                } else {
                    $user = User::select(DB::raw("COALESCE(id,'') AS id"), DB::raw("COALESCE(name,'') AS name"), DB::raw("COALESCE(uid,'') AS uid"), DB::raw("COALESCE(phone,'') AS phone"), DB::raw("COALESCE(display_image,'') AS display_image"), DB::raw("COALESCE(cover_image,'') AS cover_image"), DB::raw("COALESCE(email,'') AS email"), DB::raw("COALESCE(status,'') AS status"), DB::raw("COALESCE(profile_type,'') AS profile_type"))->where('email', $request->email)->firstOrFail();

                    if ($user->status == 'active') {
                        $token = $user->createToken('auth_token')->plainTextToken;
                        return response()->json(['status' => 200, 'message' => $message, 'token_type' => 'Bearer', 'access_token' => $token, 'data' => $user]);
                    } else {
                        return response()->json(['status' => 201, 'message' => 'This account has been inactive or deleted, please contact admin']);
                    }
                }
            } else {
                return response()->json(['status' => 201, 'message' => 'Somthing went wrong!']);
            }
        }
    /* Social Login */

    /** logout */
        public function logout(Request $request) {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['status' => 200, 'message' => 'Logout Successfully']);
        }
    /** logout */

    /* Forget Password */
        public function password_forget(Request $request) {
            $user = DB::table('users')->where(['email' => $request->email])->first();

            if (!isset($user) && $user == null) {
                return response()->json(['email' => 'Entered email address does not exists in records, please check email address']);
            }

            $token = Str::random(60);
            $randomNumber = random_int(1000, 9999);

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'otp' => $randomNumber,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $mailData = array('from_email' => _mail_from(), 'email' => $request->email, 'otp' => $randomNumber);

            try {
                Mail::to($request->email)->send(new ForgetPassword($mailData));

                return response()->json(['status' => 200, 'message' => 'please check your email and follow steps for reset password', 'token' => $token]);
            } catch (\Exception $e) {
                DB::table('password_resets')->where(['email' => $request->email])->delete();
                return response()->json(['status' => 422, 'message' => 'something went wrong, please try again later']);
            }
        }
    /* Forget Password */

    /* Validate OTP */
        public function validate_otp(Request $request) {
            $validator = Validator::make($request->all(), [
                'otp' => 'required',
                'email' => 'required',
                'token' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 422, 'message' => $validator->errors()]);
            }
            $otp_verify = DB::table('password_resets')->where(['token' => $request->token, 'otp' => $request->otp])->first();
            if ($otp_verify) {
                return response()->json(['status' => 200, 'message' => 'OTP verified successfully please enter new password', 'token' => $request->token]);
            } else {
                return response()->json(['status' => 422, 'message' => 'OTP varification failed please enter valid OTP']);
            }
        }
    /* Validate OTP */

    /* Recover Password */
        public function reset_password(Request $request) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 422, 'message' => $validator->errors()]);
            }

            $user = \DB::table('users')->where('email', $request->email)->first();

            if (!isset($user) && $user == null) {
                return response()->json(['status' => 404, 'message' => 'User not found']);
            }

            $crud = array(
                'password' => bcrypt($request->password),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $token_verify = DB::table('password_resets')->where(['token' => $request->token, 'email' => $request->email])->first();
            if ($token_verify) {
                DB::table('password_resets')->where('email', $request->email)->delete();
                DB::table('users')->where('email', $request->email)->limit(1)->update($crud);
                return response()->json(['status' => 200, 'message' => 'Password changed successfully.']);
            }
        }
    /* Recover Password */
}
