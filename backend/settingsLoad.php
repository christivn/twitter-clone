<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["api_key"])){
    $instagram = new Twitter();
    $instagram->settingsLoad($_REQUEST["api_key"]);
}
?>