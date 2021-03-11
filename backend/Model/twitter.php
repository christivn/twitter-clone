<?php
require_once './Model/connection.php';

header("Content-type: application/json; charset=utf-8");
session_start();

function generateRandomString($length = 16) {
    $characters = '01GV9Jm2u7rmsCe65wKzPTw5jtS38n2tVEGiABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

////////////////////////////////////////////////////////////////////////////////////////////////////

class Twitter {

    function __construct() {
    }
    

    // Función para chekear si existe ya un usuario con ese nikc
    public function checkUser($nick) {
        $conexion = DB::connectDB();

        $sql = "SELECT nick FROM user WHERE nick='".$nick."'";
        $result = $conexion->query($sql);
        $conexion->close();

        if ($result->num_rows>0) {
            return true;
        } else {
            return false;
        }
    }


    // Función para chekear que la api_key sea válida
    public function checkApiKey($api_key) {
        if(isset($_SESSION[$api_key])){
            return true;
        } else {
            return false;
        }
    }
    

    // Función para hacer update a la API_KEY
    public function updateKEY($nick) {
        $conexion = DB::connectDB();
        $api_key = generateRandomString();

        $sql = "UPDATE user SET api_key='".$api_key."' WHERE nick='".$nick."'";
        if ($conexion->query($sql) != TRUE) {
            echo "Error: " . $sql . "<br>" . $conexion->error;
        }
        $conexion->close();
    }


    // Función para comprobar el login del usuario
    public function login($nick, $pass) {
        $conexion = DB::connectDB();

        $nick = trim($nick);
        $passHash = md5($pass);

        $sql = "SELECT nick,pass_hash,id,api_key FROM user WHERE nick='".$nick."' and pass_hash='".$passHash."' LIMIT 1";
        $result = $conexion->query($sql);
        $conexion->close();

        if ($result->num_rows>0) {
            while($row = $result->fetch_assoc()) {
                $this->updateKEY($nick);
                echo json_encode(Array("code"=>200, "id"=>$row["id"], "api_key"=> $row["api_key"],"msg"=>"Se ha completado la peticion correctamente"));
                $_SESSION[$row["api_key"]]=true;
                return true;
            }
        } else {
            echo json_encode(Array("code"=>400, "msg"=>"Datos de session incorrectos"));
            return false;
        }
    }


    // Función para el registro de usuarios
    public function register($nick, $pass, $bio, $nameic) {
        $conexion = DB::connectDB();
        
        $nick = trim($nick);
        if(!isset($nameic)){ $nameic=""; }
        if(!isset($bio)){ $nameic=""; }
        $date = date('Y-m-d H:i:s');
        $passHash = md5($pass);
        $api_key = generateRandomString();

        if($this->checkUser($nick)!=true){
            $sql = "INSERT INTO user (nick, name_twitter, pass_hash, api_key, reg_date, name_ic) VALUES ('".$nick."', '".$nick."', '".$passHash."', '".$api_key."', '".$date."', '".$nameic."')";
            if ($conexion->query($sql) != TRUE) {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }

            $sql = "INSERT INTO user_bio (bio, avatar_url) VALUES ('".$bio."', '/img/default.png')";
            if ($conexion->query($sql) != TRUE) {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }

            $conexion->close();
            echo json_encode(Array("code"=>200, "msg"=>"Se ha completado la peticion correctamente"));
        } else {
            echo json_encode(Array("code"=>400, "msg"=>"El usuario ya existe"));
        }
    }


    // Función para devolver el perfil de un usuario
    public function profile($id, $api_key) {
        return false;
    }


    // Función para devolver el feed de un usuario
    public function feed($id, $api_key) {
        return false;
    }

    
    // Función para escribir un tweet
    public function tweet($id, $content, $img_src, $api_key) {
        return false;
    }
}
