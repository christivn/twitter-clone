<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["nick"]) && isset($_REQUEST["pass"])){
    $instagram = new Twitter();
    $instagram->login($_REQUEST["nick"],$_REQUEST["pass"]);
}
?>