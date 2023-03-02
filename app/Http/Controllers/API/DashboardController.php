<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardRequest;
use App\Http\Requests\DiscoverRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use DB;
use stdClass;

class DashboardController extends Controller {
 
    public function dashboard(DashboardRequest $request) {
        $get_user_friend_list = _get_friends($request->id);
        $path = _post_path();
        $per_page = 50;
        $page = $request->input(key: 'page', default: 1);
        $get_post = new stdClass();
        $get_post = Post::select('posts.id', 'user_id', 'caption', 'post_type', 'media_type', 'status', DB::Raw("CASE WHEN " . 'file_name' . " != '' THEN CONCAT(" . "'" . $path . "'" . ", " . 'file_name' . ") ELSE CONCAT(" . "'" . $path . "'" . ", null) END as file_name"))
            ->with(['likes' => function ($query) {
                $query->select('users.name AS user_name', 'post_id');
            }, 'comments' => function ($query) {
                $query->select('comments.id', 'users.id AS user_id', 'users.name', 'comments.comment', 'post_id');
            }])
            ->withCount('likes', 'comments')
            ->whereIn('user_id', $get_user_friend_list)
            ->offset(($page - 1) * $per_page)
            ->limit($per_page)
            ->get();
        if ($get_post->isNotEmpty()) {
            $get_post[0]->page = $page;
            return response()->json(['status' => $this->successCode, 'message' => 'Data found.', 'data' => $get_post]);
        } else {
            return response()->json(['status' => $this->databaseNodataCode, 'message' => 'No data found!', 'data' => array()]);
        }
    }

    public function discover(DiscoverRequest $request) {
        $path = _post_path();
        $per_page = 50;
        $page = $request->input(key: 'page', default: 1);
        $get_post = new stdClass();
        $get_post = Post::select('posts.id', 'user_id', 'caption', 'post_type', 'media_type', 'status', DB::Raw("CASE WHEN " . 'file_name' . " != '' THEN CONCAT(" . "'" . $path . "'" . ", " . 'file_name' . ") ELSE CONCAT(" . "'" . $path . "'" . ", null) END as file_name"))
            ->with(['likes' => function ($query) {
                $query->select('users.name AS user_name', 'post_id');
            }, 'comments' => function ($query) {
                $query->select('comments.id', 'users.id AS user_id', 'users.name', 'comments.comment', 'post_id');
            }])
            ->withCount('likes', 'comments')
            ->offset(($page - 1) * $per_page)
            ->limit($per_page)
            ->get();
        if ($get_post->isNotEmpty()) {
            $get_post[0]->page = $page;
            return response()->json(['status' => $this->successCode, 'message' => 'Data found.', 'data' => $get_post]);
        } else {
            return response()->json(['status' => $this->databaseNodataCode, 'message' => 'No data found!', 'data' => array()]);
        }
    }
}
