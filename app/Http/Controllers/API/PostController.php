<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Http\Requests\CommentPostRequest;
use App\Http\Requests\EditPostRequest;
use App\Http\Requests\GetPostRequest;
use App\Http\Requests\LikePostRequest;
use App\Http\Requests\MakePostRequest;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PostController extends Controller {

    /* Make a Post */
        public function makePost(MakePostRequest $request) {
            $folder_to_upload = public_path() . '/uploads/posts/';
            $crud = [
                'user_id' => $request->id,
                'post_type' => $request->post_type,
                'media_type' => $request->media_type,
                'caption' => $request->caption ?? null,
                'created_by' => auth()->user()->id,
                'created_at' => Carbon::now()->format("Y-m-d H:i:s")
            ];

            $file = $request->file('file');
            $filenameWithExtension = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $filenameToStore = time() . "post_" . $filename . '.' . $extension;

            if (!File::exists($folder_to_upload))
                File::makeDirectory($folder_to_upload, 0777, true, true);

            $crud['file_name'] = $filenameToStore;

            if (!File::exists($folder_to_upload))
                File::makeDirectory($folder_to_upload, 0777, true, true);

            DB::beginTransaction();
            try {
                $makePost = Post::insertGetId($crud);

                if ($makePost) {
                    if (!empty($request->file('file'))) {
                        $file->move($folder_to_upload, $filenameToStore);
                    }
                    DB::commit();
                    return response()->json(['status' => $this->successCode, 'message' => 'Post created successfully.']);
                }
            } catch (\Throwable $th) {
                DB::rollback();
                return response()->json(['status' => $this->errorCode, 'message' => 'Somthing went wrong!']);
            }
        }
    /* Make a Post */

    /* Get Post */
        public function getPost(GetPostRequest $request) {
            $path = _post_path();

            $post = Post::
                    select('id', 'user_id', 'caption', 'post_type', 'media_type', 'status',  DB::Raw("CASE WHEN " . 'file_name' . " != '' THEN CONCAT(" . "'" . $path . "'" . ", " . 'file_name' . ") ELSE CONCAT(" . "'" . $path . "'" . ", null) END as file_name"))
                    ->where('user_id', $request->id)
                    ->get();
            if($post->isNotEmpty()){
                return response()->json(['status' => $this->successCode, 'message' => 'Data found.', 'data' => $post]);
            }else{
                return response()->json(['status' => $this->databaseNodataCode, 'message' => 'No data found!']);
            }
        }
    /* Get Post */

    /* Edit Post */
        public function editPost(EditPostRequest $request) {
            $crud = [
                'caption' => $request->caption,
                'updated_at' => Carbon::now()->format("Y-m-d H:i:s"),
                'updated_by' => $request->caption,
            ];

            $post = Post::where(['id' => $request->id])->update($crud);
            if($post){
                return response()->json(['status' => $this->successCode, 'message' => 'Post updated successfully.']);
            }else{
                return response()->json(['status' => $this->databaseErrorCode, 'message' => 'Faild to update post']);
            }

        }
    /* Edit Post */

    /* Like Post */
        public function likePost(LikePostRequest $request) {
            if($request->status == true){
                $crud = [
                    'post_id' => $request->post_id,
                    'user_id' => $request->id,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ];
                $like = Like::insertGetId($crud);
                if($like){
                    return response()->json(['status' => $this->successCode, 'message' => 'Post liked successfully.']);
                }else{
                    return response()->json(['status' => $this->databaseErrorCode, 'message' => 'Failed to like post']);
                }
            }else{
                $like = Like::where(['post_id', 'user_id'])->delete();
                if($like){
                    return response()->json(['status' => $this->successCode, 'message' => 'Post unliked successfully.']);
                }else{
                    return response()->json(['status' => $this->databaseErrorCode, 'message' => 'Failed to unlike post']);
                }
            }


        }
    /* Like Post */

    /* Comment Post */
        public function commentPost(CommentPostRequest $request) {
            if($request->comment != '' || $request->comment != null) {
                $crud = [
                    'user_id' => $request->id,
                    'post_id' => $request->post_id,
                    'comment' => $request->comment,
                    'created_at' => Carbon::now()->format("Y-m-d H:i:s"),
                ];
                $comment = Comment::insertGetId($crud);
                if($comment){
                    return response()->json(['status' => $this->successCode, 'message' => 'Comment inserted successfully.']);    
                }else{
                    return response()->json(['status' => $this->databaseErrorCode, 'message' => 'Failed to insert comment!']);    
                }
            }else{
                return response()->json(['status' => $this->validationErrorCode, 'message' => 'Comment Field is required!']);
            }

        }
    /* Comment Post */
}
