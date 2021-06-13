<?php
require_once './Model/twitter.php';

$dir_subida = 'img/';
$fichero_subido = $dir_subida . $_COOKIE['id']."_avatar.jpg";;

echo '<pre>';
if (move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $fichero_subido)) {
    echo "El fichero es válido y se subió con éxito.\n";
} else {
    echo "¡Posible ataque de subida de ficheros!\n";
}

echo 'Más información de depuración:';
print_r($_FILES);

echo "</pre>";

$twitter = new Twitter();
$twitter->uploadAvatarSQL($_COOKIE["api_key"]);
?>