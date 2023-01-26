<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use DB;
use stdClass;

class DashboardController extends Controller {
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
    public function dashboard(Request $request) {
        $rules = [
            'id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => $this->validationErrorCode, 'message' => $validator->errors()]);
        }
        $get_user_friend_list = _get_friends($request->id);
        $path = _post_path();
        $per_page = 50;
        $page = $request->input(key: 'page', default: 1);
        $get_post = new stdClass();
        $get_post = Post::
                        select('posts.id', 'user_id', 'caption', 'post_type', 'media_type', 'status', DB::Raw("CASE WHEN " . 'file_name' . " != '' THEN CONCAT(" . "'" . $path . "'" . ", " . 'file_name' . ") ELSE CONCAT(" . "'" . $path . "'" . ", null) END as file_name"))
                        ->with(['likes' => function ($query) {
                            $query->select('users.name AS user_name', 'post_id');
                        }, 'comments' => function ($query) {
                            $query->select('users.id', 'users.name', 'comments.comment', 'post_id');
                        }])
                        ->withCount('likes', 'comments')
                        ->whereIn('user_id' , $get_user_friend_list)
                        ->offset(($page - 1) * $per_page)
                        ->limit($per_page)
                        ->get();
        if ($get_post->isNotEmpty()) {
            $get_post[0]->page = $page;
            return response()->json(['status' => $this->successCode, 'message' => 'Data found.', 'data' => $get_post]);
        } else {
            return response()->json(['status' => $this->databaseNodataCode, 'message' => 'No data found!']);
        }
    }
}
