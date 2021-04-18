<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["api_key"]) && isset($_REQUEST["content"])){
    $instagram = new Twitter();
    
    if(isset($_REQUEST["img_url"])){
        $instagram->tweet($_REQUEST["content"],$_REQUEST["api_key"],$_REQUEST["img_url"]);
    } else {
        $instagram->tweet($_REQUEST["content"],$_REQUEST["api_key"], "");
    }
}
?>