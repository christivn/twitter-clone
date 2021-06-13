<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["api_key"]) && isset($_REQUEST["tweet_id"]) && isset($_REQUEST["page"])){
    $twitter = new Twitter();
    $twitter->tweetComments($_REQUEST["api_key"], $_REQUEST["tweet_id"], intval($_REQUEST["page"]));
}
?>