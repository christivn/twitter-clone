<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["api_key"]) && isset($_REQUEST["tweet_id"])){
    $twitter = new Twitter();
    $twitter->rt_remove($_REQUEST["api_key"],$_REQUEST["tweet_id"]);
}
?>