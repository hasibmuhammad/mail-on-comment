<?php
/*
Plugin Name: Mail-On-Comment
PLugin URI: https://github.com/hasibmuhammad
Description: This plugin will show the qrcode below the post.
Version: 1.0
Author: Hasib Muhammad
Author URI: https://github.comm/hasibmuhammad
License: GPLv2 or later
Text Domain: mail-on-comment
Doomain Path: /languages/
 */

function moc_comment_post($commentID, $commentApproved)
{
    if (1 == $commentApproved) {
        $mocComment = get_comment($commentID);
        // var_dump($mocComment);die;

        $mocCurrentPostUrl = get_the_permalink($mocComment->comment_post_ID);
        $mocAuthorID       = get_post_field("post_author", $mocComment->comment_post_ID);
        $mocAuthorObject   = get_userdata($mocAuthorID);
        $mocAuthorEmail    = $mocAuthorObject->data->user_email;
        // var_dump($mocAuthorEmail);die;
        // $mocCommentTo      = $mocComment->comment_author_email;
        // $mocAdminEmail     = get_option("admin_email");
        $mocUserName       = $mocComment->comment_author;
        $headers           = array('Content-Type: text/html; charset=UTF-8');
        $message           = sprintf(__("Hi there,<br><br>%s has commented on your post!<br>Have a look on your post: %s<br><br>Thanks<br>", "mail-on-comment"), strtoupper($mocUserName), $mocCurrentPostUrl);
        if (true == wp_mail($mocAuthorEmail, __("New Comment!", "mail-on-comment"), $message, $headers)) {
            die("Sent mail,check inbox");
        } else {
            die("Not sent");
        }
    }
}
add_action("comment_post", "moc_comment_post", 10, 2);
