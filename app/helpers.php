<?php
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
?>