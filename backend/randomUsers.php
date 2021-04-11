<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["api_key"])){
    $instagram = new Twitter();
    $instagram->randomUsers($_REQUEST["api_key"]);
}
?>