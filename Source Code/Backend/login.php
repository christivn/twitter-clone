<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["nick"]) && isset($_REQUEST["pass"])){
    $twitter = new Twitter();
    $twitter->login($_REQUEST["nick"],$_REQUEST["pass"]);
}
?>