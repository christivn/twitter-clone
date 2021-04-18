<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["api_key"]) && isset($_REQUEST["tweet_id"])){
    $instagram = new Twitter();
    $instagram->rt($_REQUEST["api_key"],$_REQUEST["tweet_id"]);
}
?>