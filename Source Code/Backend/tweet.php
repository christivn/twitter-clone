<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["api_key"]) && isset($_REQUEST["content"])){
    $twitter = new Twitter();
    
    if(isset($_REQUEST["img_url"])){
        $twitter->tweet($_REQUEST["content"],$_REQUEST["api_key"],$_REQUEST["img_url"]);
    } else {
        $twitter->tweet($_REQUEST["content"],$_REQUEST["api_key"], "");
    }
}
?>