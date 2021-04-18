<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["api_key"]) && isset($_REQUEST["page"])){
    $instagram = new Twitter();
    $instagram->feedExplore($_REQUEST["api_key"], intval($_REQUEST["page"]));
}
?>