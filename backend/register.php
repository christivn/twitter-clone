<?php
require_once './Model/twitter.php';

if(isset($_REQUEST["nick"]) && isset($_REQUEST["pass"]) || isset($_REQUEST["nameic"])){
    
    $bio = "";
    if(isset($_REQUEST["bio"])){
        $bio=$_REQUEST["bio"];
    }

    $nameic = "";
    if(isset($_REQUEST["nameic"])){
        $nameic = $_REQUEST["nameic"];
    }

    $instagram = new Twitter();
    $instagram->register($_REQUEST["nick"],$_REQUEST["pass"],$bio,$nameic);
}
?>