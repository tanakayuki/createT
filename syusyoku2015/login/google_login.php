<?php
/**
 * Created by PhpStorm.
 * User: tanakayuuki
 * Date: 2014/12/14
 * Time: 22:36
 */
session_start();
require_once('./login_dif.php');

$app_id = GG_app_id;
$app_secret = GG_app_secret;
$my_url = GG_my_url;

if(empty ($code))
{
    $_SESSION['google']="ok";
    $dialog_url = "https://accounts.google.com/o/oauth2/auth?"
        . "scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile&"
        . "client_id=" . $app_id . "&redirect_uri=" . urlencode ($my_url) . "&response_type=code";
    echo("<script> top.location.href='" . $dialog_url . "'</script>");
}

