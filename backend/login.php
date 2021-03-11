<?php
// http://127.0.0.1/backend/login.php?nick=test1&pass=1234
require_once './Model/twitter.php';

if(isset($_REQUEST["nick"]) && isset($_REQUEST["pass"])){
    $instagram = new Twitter();
    $instagram->login($_REQUEST["nick"],$_REQUEST["pass"]);
}
?>