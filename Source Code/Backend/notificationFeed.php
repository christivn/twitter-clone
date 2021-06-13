<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["api_key"]) && isset($_REQUEST["page"])){
    $twitter = new Twitter();
    $twitter->notificationFeed($_REQUEST["api_key"], intval($_REQUEST["page"]));
}
?>