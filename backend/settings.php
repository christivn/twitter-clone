<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["api_key"]) && isset($_REQUEST["avatar_url"]) && isset($_REQUEST["banner_url"]) && isset($_REQUEST["name"]) && isset($_REQUEST["bio"])){
    $instagram = new Twitter();
    $instagram->settings($_REQUEST["api_key"], $_REQUEST["avatar_url"], $_REQUEST["banner_url"], $_REQUEST["name"], $_REQUEST["bio"]);
}
?>