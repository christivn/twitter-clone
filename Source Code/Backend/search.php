<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["api_key"]) && isset($_REQUEST["name_twitter"])){
    $twitter = new Twitter();
    $twitter->search($_REQUEST["api_key"],$_REQUEST["name_twitter"]);
}
?>