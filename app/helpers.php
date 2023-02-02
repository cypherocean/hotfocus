<?php

use App\Models\FriendList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

if (!function_exists('_site_title')) {
    function _site_title() {
        return 'hotFocus';
    }
}

if (!function_exists('_site_title_sf')) {
    function _site_title_sf() {
        return 'AE';
    }
}

if (!function_exists('_mail_from')) {
    function _mail_from() {
        return 'info@hotfocus.com';
    }
}

if (!function_exists('_post_path')) {
    function _post_path() {
        return asset('/uploads/posts/') . '/';
    }
}

if (!function_exists('_image_path')) {
    function _image_path() {
        return asset('/uploads/') . '/';
    }
}

if (!function_exists('_get_friends')) {
    function _get_friends($id) {
        $friend_list = FriendList::select(DB::raw("CASE WHEN `user_id` = " . $id . " THEN `friend_id` ELSE `user_id` END AS `friend_ids`"))->where('user_id', $id)->orWhere('friend_id', $id)->where('status', 'accepted')->get();
        return $friend_list;
    }
}

if (!function_exists('_is_follower')) {
    function _is_follower($id) {
        $friend_list = FriendList::select('status')->where('status', '!=', 'pending')->where(['user_id' => Auth::user()->id, 'friend_id' => $id])->first();
        if (!$friend_list) {
            return false;
        } else {
            return $friend_list->status;
        }
    }
}

if (!function_exists('_is_friend')) {
    function _is_friend($id) {
        $friend_to_user = $user_to_friend = null;
        $following = FriendList::select('status')->where(['user_id' => Auth::user()->id, 'friend_id' => $id])->first();
        if (!$following) {
            $user_to_friend = 'follow';
        } else {
            if ($following->status == 'accepted') {
                $user_to_friend = 'following';
            } else if ($following->status == 'rejected') {
                $user_to_friend = 'follow';
            } else if ($following->status == 'blocked') {
                $user_to_friend = 'blocked';
            } else {
                $user_to_friend = $following->status;
            }
        }
        $follower = FriendList::select('status')->where(['user_id' => $id, 'friend_id' => Auth::user()->id])->first();
        if (!$follower) {
            $friend_to_user = 'not_follower';
        } else {
            if ($follower->status == 'accepted') {
                $friend_to_user = 'follower';
            } else if ($follower->status == 'rejected') {
                $friend_to_user = 'rejected';
            } else if ($follower->status == 'blocked') {
                $friend_to_user = 'blocked';
            } else {
                $friend_to_user = $follower->status;
            }
        }
        $data = [
            'user_to_friend' => $user_to_friend,
            'friend_to_user' => $friend_to_user
        ];
        return $data;
    }
}
