<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["api_key"]) && isset($_REQUEST["id"]) && isset($_REQUEST["page"])){
    $twitter = new Twitter();
    $twitter->followings($_REQUEST["api_key"], $_REQUEST["id"], intval($_REQUEST["page"]));
}
?>