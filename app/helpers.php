<?php

use App\Models\FriendList;
use Illuminate\Support\Facades\DB;

    if(!function_exists('_site_title')){
        function _site_title(){
            return 'hotFocus';
        }
    }

    if(!function_exists('_site_title_sf')){
        function _site_title_sf(){
            return 'AE';
        }
    }

    if(!function_exists('_mail_from')){
        function _mail_from(){
            return 'info@hotfocus.com';
        }
    }
    
    if(!function_exists('_post_path')){
        function _post_path(){
            return asset('/uploads/posts/').'/';
        }
    }
    
    if(!function_exists('_get_friends')){
        function _get_friends($id){
            $friend_list = FriendList::select(DB::raw("CASE WHEN `user_id` = ".$id." THEN `friend_id` ELSE `user_id` END AS `friend_ids`"))->where('user_id', $id)->orWhere('friend_id', $id)->get();
            return $friend_list;
        }
    }
?>