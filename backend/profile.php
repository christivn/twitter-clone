<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["api_key"]) && isset($_REQUEST["id"])){
    $instagram = new Twitter();
    $instagram->profile($_REQUEST["api_key"],$_REQUEST["id"]);
}
?>