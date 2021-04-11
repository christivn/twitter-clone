<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["api_key"]) && isset($_REQUEST["followed_id"])){
    $instagram = new Twitter();
    $instagram->unfollow($_REQUEST["api_key"],$_REQUEST["followed_id"]);
}
?>