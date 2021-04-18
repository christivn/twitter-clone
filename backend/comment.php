<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["api_key"]) && isset($_REQUEST["tweet_id"]) && isset($_REQUEST["content"])){
    $instagram = new Twitter();
    $instagram->comment($_REQUEST["api_key"], $_REQUEST["tweet_id"], $_REQUEST["content"]);
}
?>