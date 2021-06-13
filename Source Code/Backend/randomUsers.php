<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["api_key"])){
    $twitter = new Twitter();
    $twitter->randomUsers($_REQUEST["api_key"]);
}
?>