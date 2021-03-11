<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["id"]) && isset($_REQUEST["api_key"])){
    $instagram = new Twitter();
    $instagram->feed($_REQUEST["id"],$_REQUEST["api_key"]);
}
?>