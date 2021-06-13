<?php
require_once './Model/twitter.php';

header("Content-type: text/html; charset=utf-8");
echo "<center><img style='margin-top:20px;' src='http://christivn.es/demo/twitter-clone/img/spinner.gif'></center>";

$dir_subida = 'img/';
$fichero_subido = $dir_subida . $_COOKIE['id']."_banner.jpg";
move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $fichero_subido);

$twitter = new Twitter();
$twitter->uploadBannerSQL($_COOKIE["api_key"]);

echo "<script>window.location.replace('http://christivn.es/demo/twitter-clone/profile');</script>";
?>