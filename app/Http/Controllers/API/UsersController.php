<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlockUserRequest;
use App\Http\Requests\ChangeRequestStatusRequest;
use App\Http\Requests\FindFriendRequest;
use App\Http\Requests\GetFollowerRequest;
use App\Http\Requests\GetRequestListRequest;
use App\Http\Requests\GetUserProfileRequest;
use App\Http\Requests\MyProfileRequest;
use App\Http\Requests\SendFriendRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\FriendList;


class UsersController extends Controller {

    /* Get My Profile */
        public function myProfile(MyProfileRequest $request) {
            $data = User::select(DB::raw("COALESCE(id,'') AS id"), DB::raw("COALESCE(name,'') AS name"), DB::raw("COALESCE(uid,'') AS uid"), DB::raw("COALESCE(phone,'') AS phone"), DB::raw("COALESCE(display_image,'') AS display_image"), DB::raw("COALESCE(cover_image,'') AS cover_image"), DB::raw("COALESCE(email,'') AS email"), DB::raw("COALESCE(status,'') AS status"), DB::raw("COALESCE(profile_type,'') AS profile_type"))->with('posts')->where(['id' => $request->id])->first();
            if (!$data) {
                return response()->json(['status' => $this->databaseNodataCode, 'message' => 'No users found']);
            }
            return response()->json(['status' => $this->successCode, 'message' => 'User found', 'data' => $data]);
        }
    /* Get My Profile */

    /* Update User Profile */
        public function updateProfile(UpdateProfileRequest $request) {
            $id = $request->id;
            $exst_rec = User::where(['id' => $id])->first();

            $data = [
                'name' => $request->name ?? null,
                'email' => $request->email,
                'phone' => $request->phone ?? null,
                'display_image' => $exst_rec->display_image ?? null,
                'cover_image' => $exst_rec->cover_image ?? null,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id
            ];

            $folder_to_upload = public_path() . '/uploads/users/';

            if (!empty($request->file('display_image'))) {
                $file = $request->file('display_image');
                $filenameWithExtension = $request->file('display_image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
                $extension = $request->file('display_image')->getClientOriginalExtension();
                $filenameToStore = time() . "dp_" . $filename . '.' . $extension;

                if (!\File::exists($folder_to_upload))
                    \File::makeDirectory($folder_to_upload, 0777, true, true);

                $data['display_image'] = $filenameToStore;
            }

            if (!empty($request->file('cover_image'))) {
                $file1 = $request->file('cover_image');
                $filenameWithExtension1 = $request->file('cover_image')->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExtension1, PATHINFO_FILENAME);
                $extension1 = $request->file('cover_image')->getClientOriginalExtension();
                $filenameToStore1 = time() . "cp_" . $filename1 . '.' . $extension1;

                if (!\File::exists($folder_to_upload))
                    \File::makeDirectory($folder_to_upload, 0777, true, true);

                $data['cover_image'] = $filenameToStore1;
            }

            $update = User::where(['id' => $id])->update($data);

            if ($update) {
                if (!empty($request->file('display_image'))) {
                    $file->move($folder_to_upload, $filenameToStore);

                    $file_path = public_path() . '/uploads/users/' . $exst_rec->display_image;

                    if (File::exists($file_path) && $file_path != '') {
                        if ($exst_rec->display_image != 'user-icon.jpg') {
                            @unlink($file_path);
                        }
                    }
                }
                if (!empty($request->file('cover_image'))) {
                    $file1->move($folder_to_upload, $filenameToStore1);

                    $file_path1 = public_path() . '/uploads/users/' . $exst_rec->cover_image;

                    if (File::exists($file_path1) && $file_path1 != '') {
                        if ($exst_rec->cover_image != 'user-icon.jpg') {
                            @unlink($file_path1);
                        }
                    }
                }
                $user = User::select(DB::raw("COALESCE(id,'') AS id"), DB::raw("COALESCE(name,'') AS name"), DB::raw("COALESCE(uid,'') AS uid"), DB::raw("COALESCE(phone,'') AS phone"), DB::raw("COALESCE(display_image,'') AS display_image"), DB::raw("COALESCE(cover_image,'') AS cover_image"), DB::raw("COALESCE(email,'') AS email"), DB::raw("COALESCE(status,'') AS status"), DB::raw("COALESCE(profile_type,'') AS profile_type"))->where('id', $id)->first();
                return response()->json(['status' => $this->successCode, 'message' => 'Profile updated successfully.', 'data' => $user]);
            } else {
                return response()->json(['status' => $this->databaseErrorCode, 'message' => 'Failed to update profile!']);
            }
        }
    /* Update User Profile */

    /* Fiend Friend */
        public function findFriend(FindFriendRequest $request) {
            $find_user = User::where('name', 'LIKE', '%' . $request->search_name . '%')->where('status', 'active')->get(['id', 'name', 'display_image']);
            if ($find_user->isNotEmpty()) {
                return response()->json(['status' => $this->successCode, 'message' => 'user found', 'data' => $find_user]);
            } else {
                return response()->json(['status' => $this->databaseNodataCode, 'message' => 'No user found!']);
            }
        }
    /* Fiend Friend */

    /** Get User Profile */
        public function getUserProfile(GetUserProfileRequest $request) {
            $data = User::select(DB::raw("COALESCE(id,'') AS id"), DB::raw("COALESCE(name,'') AS name"), DB::raw("COALESCE(uid,'') AS uid"), DB::raw("COALESCE(phone,'') AS phone"), DB::raw("COALESCE(display_image,'') AS display_image"), DB::raw("COALESCE(cover_image,'') AS cover_image"), DB::raw("COALESCE(email,'') AS email"), DB::raw("COALESCE(status,'') AS status"), DB::raw("COALESCE(profile_type,'') AS profile_type"))->withCount('followers', 'following', 'posts')->with('posts')->where(['id' => $request->user_id])->first();
            if ($data) {
                $is_follower = _is_follower($request->user_id);
                $is_follower = _is_friend($request->user_id);
                $user['user_to_friend'] = $is_follower['user_to_friend'];
                $user['friend_to_user'] = $is_follower['friend_to_user'];
                if ($is_follower && $is_follower == 'accepted') {
                    $user = [
                        'id' => $data->id,
                        'name' => $data->name,
                        'uid' => $data->uid,
                        'phone' => $data->phone,
                        'display_image' => $data->display_image,
                        'cover_image' => $data->cover_image,
                        'email' => $data->email,
                        'status' => $data->status,
                        'profile_type' => $data->profile_type,
                        'follower_count' => $data->followers_count,
                        'following_count' => $data->following_count,
                        'posts_count' => $data->posts_count,
                        'posts' => $data->posts,
                    ];
                } else if ($is_follower && $is_follower == 'blocked') {
                    $user = [
                        'id' => $data->id,
                        'name' => 'HotFocus User',
                        'uid' => '',
                        'phone' => '',
                        'display_image' => _image_path().'default_dp.png',
                        'cover_image' => _image_path().'default_ci.jpg',
                        'email' => '',
                        'status' => '',
                        'profile_type' => $data->profile_type,
                        'follower_count' => 0,
                        'following_count' => 0,
                        'posts_count' => 0,
                        'posts' => [],
                    ];
                } else {
                    if ($data->profile_type == 'private') {
                        $user = [
                            'id' => $data->id,
                            'name' => $data->name,
                            'uid' => '',
                            'phone' => '',
                            'display_image' => $data->display_image,
                            'cover_image' => $data->cover_image,
                            'email' => '',
                            'status' => $data->status,
                            'profile_type' => $data->profile_type,
                            'follower_count' => $data->followers_count,
                            'following_count' => $data->following_count,
                            'posts_count' => $data->posts_count,
                            'posts' => array(),
                        ];
                    } else if ($data->profile_type == 'public') {
                        $user = [
                            'id' => $data->id,
                            'name' => $data->name,
                            'uid' => $data->uid,
                            'phone' => $data->phone,
                            'display_image' => $data->display_image,
                            'cover_image' => $data->cover_image,
                            'email' => $data->email,
                            'status' => $data->status,
                            'profile_type' => $data->profile_type,
                            'follower_count' => $data->followers_count,
                            'following_count' => $data->following_count,
                            'posts_count' => $data->posts_count,
                            'posts' => $data->posts,
                        ];
                    }
                }
                return response()->json(['status' => $this->successCode, 'message' => 'User found', 'data' => $user]);
            } else {
                return response()->json(['status' => $this->databaseNodataCode, 'message' => 'No users found']);
            }
        }
    /** Get User Profile */

    /* Get Follower */
        public function getFollower(GetFollowerRequest $request) {
            $find_user = FriendList::select(DB::raw("CASE WHEN `display_image` IS NULL THEN CONCAT('localhost/hotfocus/public/uploads/', 'defaultUser.jpg') ELSE CONCAT('localhost/hotfocus/public/uploads/', `display_image` ) END AS `display_image`"), 'name')->leftjoin('users', 'friend_lists.user_id', 'users.id')->get();
            if ($find_user->isNotEmpty()) {
                return response()->json(['status' => $this->successCode, 'message' => 'data found.', 'data' => $find_user]);
            } else {
                return response()->json(['status' => $this->databaseNodataCode, 'message' => 'no data found!']);
            }
        }
    /* Get Follower */

    /* Send Friend Request */
        public function sendFriendRequest(SendFriendRequest $request) {
            $get_user = User::find($request->user_id);
            $get_friend = User::find($request->friend_id);
            if (!$get_user || !$get_friend) {
                return response()->json(['status' => $this->databaseNodataCode, 'message' => 'User not found!']);
            }
            $crud = [
                'user_id' => $request->user_id,
                'friend_id' => $request->friend_id,
                'created_at' => Carbon::now()->format("Y-m-d H:i:s")
            ];
            $friend_request = FriendList::insertGetId($crud);

            if ($friend_request) {
                return response()->json(['status' => $this->successCode, 'message' => 'Request send success.']);
            } else {
                return response()->json(['status' => $this->databaseErrorCode, 'message' => 'Faild to send request!']);
            }
        }
    /* Send Friend Request */

    /* Get Friend Request List */
        public function getRequestList(GetRequestListRequest $request) {
            $path = _image_path();
            $get_request = FriendList::select(
                    'friend_lists.id',
                    'friend_lists.user_id',
                    'friend_lists.friend_id',
                    'friend_lists.status',
                    DB::raw("CASE WHEN `users`.`display_image` IS NOT NULL THEN CONCAT('".$path."', `users`.`display_image`) ELSE CONCAT('".$path."', 'default_dp.png') END AS `display_image`"),
                    DB::raw("CASE WHEN `friend_lists`.`user_id` =" . $request->id . " THEN 'send' WHEN `friend_lists`.`friend_id` =" . $request->id . " THEN 'received' ELSE NULL END AS `type`"),
                    DB::raw("CASE WHEN `friend_lists`.`user_id` =" . $request->id . " THEN `users`.`name` WHEN `friend_lists`.`friend_id` =" . $request->id . " THEN `friend`.`name` ELSE NULL END AS `user_name`")
                )
                ->leftjoin('users', 'friend_lists.friend_id', 'users.id')
                ->leftjoin('users AS friend', 'friend_lists.user_id', 'friend.id')
                ->where(['friend_lists.status' => 'pending'])
                ->where(['friend_lists.user_id' => $request->id])
                ->orWhere(['friend_lists.friend_id' => $request->id])
                ->get();

            if ($get_request->isNotEmpty()) {
                return response()->json(['status' => $this->successCode, 'message' => 'Data found.', 'data' => $get_request]);
            } else {
                return response()->json(['status' => $this->databaseErrorCode, 'message' => 'No data found.']);
            }
        }
    /* Get Friend Request List */

    /* Change Friend Request Status */
        public function changeFriendRequestStatus(ChangeRequestStatusRequest $request) {
            $crud = [
                'status' => $request->status,
                'updated_at' => Carbon::now()->format("Y-m-d H:i:s"),
            ];
            $change_status = FriendList::where(['id' => $request->id])->update($crud);
            if ($change_status) {
                return response()->json(['status' => $this->successCode, 'message' => "Status changed successfully."]);
            } else {
                return response()->json(['status' => $this->databaseErrorCode, 'message' => "Faild to change status!"]);
            }
        }
    /* Change Friend Request Status */
    
    /* Block User */
        public function blockUser(BlockUserRequest $request) {
            $crud = [
                'status' => 'blocked',
                'updated_at' => Carbon::now()->format("Y-m-d H:i:s"),
            ];
            $change_status = FriendList::where(['user_id' => $request->user_id, 'friend_id' => $request->friend_id])->update($crud);
            if ($change_status) {
                return response()->json(['status' => $this->successCode, 'message' => "Status changed successfully."]);
            } else {
                return response()->json(['status' => $this->databaseErrorCode, 'message' => "Faild to change status!"]);
            }
        }
    /* Block User */
}
