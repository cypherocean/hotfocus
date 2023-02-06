<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Events\chatEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetChatRequest;
use App\Http\Requests\MakeChatRequest;
use App\Models\Chat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller {

    public function getChat(GetChatRequest $request) {
        $id = $request->id;
        $data = Chat::select('chats.id', 'chats.sender_id', 'chats.receiver_id', 'chats.message', 'sender.name AS sender_name', 'receiver.name AS receiver_name')->leftjoin('users AS sender', 'chats.sender_id', 'sender.id')->leftjoin('users AS receiver', 'chats.receiver_id', 'receiver.id')
            ->where(['chats.sender_id' => Auth::user()->id, 'chats.receiver_id' => $id])
            ->orWhereRaw('(chats.receiver_id = ' . Auth::user()->id . ' AND chats.sender_id = ' . $id . ')')
            ->get();
        if ($data->isEmpty()) {
            return response()->json(['status' => 200, 'message' => 'message found.', 'data' => $data]);
        } else {
            return response()->json(['status' => 200, 'message' => 'no message found!']);
        }
    }

    public function makeChat(MakeChatRequest $request) {
        $sender_id = Auth::user()->id;
        $receiver_id  = $request->receiver_id;
        $user = User::find($receiver_id);

        $folder_to_upload = public_path() . '/uploads/chats/';
        
        $crud = [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message' => $request->message,
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

        if (!File::exists($folder_to_upload)){
            File::makeDirectory($folder_to_upload, 0777, true, true);
        }

        DB::beginTransaction();
        try {
            $insertChat = Chat::insertGetId($crud);

            if ($insertChat) {
                if (!empty($request->file('file'))) {
                    $file->move($folder_to_upload, $filenameToStore);
                }
                DB::commit();
                broadcast(new chatEvent($user, $request->message));
                return response()->json(['status' => $this->successCode, 'message' => 'Post created successfully.']);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['status' => $this->errorCode, 'message' => 'Somthing went wrong!']);
        }
    }
}
