<?php
require __DIR__ . '/vendor/autoload.php';
require_once './Model/connection.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

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

function sendRefreshNotification($api_key){
 $options = array(
   'cluster' => 'eu',
   'useTLS' => true
 );
 $pusher = new Pusher\Pusher(
   '702efbe44c87a754783e',
   'd2dbdcab3821874ff87a',
   '1217133',
   $options
 );

 $data['api_key'] = $_COOKIE["api_key"];
 $pusher->trigger('my-channel', 'my-event', $data);
}


////////////////////////////////////////////////////////////////////////////////////////////////////

class Twitter {

    function __construct() {
    }
    

    // Función para descargar una imagen al servidor desde una URL
    public function downloadURL($url, $type) {
        if(file_put_contents( "api/img/".$_COOKIE["id"]."_".$type.".jpg",file_get_contents($url))) {
            echo "Imagen subida correctamente";
        } else {
            echo "Error en la subida de la imagen";
        }
    }


    // Función para chekear si existe ya un usuario con ese nick
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
        $conexion = DB::connectDB();
        $sql = "SELECT api_key FROM user WHERE api_key='".$api_key."' and id=".$_COOKIE["id"];
        $result = $conexion->query($sql);
        $conexion->close();

        if ($result->num_rows>0) {
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

        $this->updateKEY($nick);
        $sql = "SELECT nick,pass_hash,id,api_key FROM user WHERE nick='".$nick."' and pass_hash='".$passHash."' LIMIT 1";
        $result = $conexion->query($sql);
        $conexion->close();

        if ($result->num_rows>0) {
            while($row = $result->fetch_assoc()) {
                echo json_encode(Array("code"=>200, "id"=>$row["id"], "api_key"=> $row["api_key"],"msg"=>"Se ha completado la peticion correctamente"));
                $_SESSION["api_key"]=$row["id"];
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

            $sql = "INSERT INTO user_bio (bio, avatar_url, banner_url) VALUES ('".$bio."', 'img/default.png', 'img/banner.jpg')";
            if ($conexion->query($sql) != TRUE) {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
            $conexion->close();

            $this->login($nick, $pass);
        } else {
            echo json_encode(Array("code"=>400, "msg"=>"El usuario ya existe"));
        }
    }


    // Función para devolver el perfil de un usuario (Devolver si se sigue a ese usuario, numero de seguidores, y seguidos)
    public function profile($api_key, $id) {
        if($this->checkApiKey($api_key)){
            $my_id = $_COOKIE["id"];

            $conexion = DB::connectDB();
            $sql = "SELECT bio,avatar_url,banner_url FROM user_bio WHERE user_id=".$id;
            $result = $conexion->query($sql);
            $conexion->close();

            $bio = "";
            $avatar_url = "";
            $banner_url = "";
            if ($result->num_rows>0) {
                while($row = $result->fetch_assoc()) {
                    $bio = $row["bio"];
                    $avatar_url = $row["avatar_url"];
                    $banner_url = $row["banner_url"];
                }
            }


            $conexion = DB::connectDB();
            $sql = "SELECT following_user_id,followed_user_id FROM follows WHERE following_user_id=".$my_id." and followed_user_id=".$id;
            $result = $conexion->query($sql);
            $conexion->close();

            $my_follow = false;
            if ($result->num_rows>0) {
                $my_follow = true;
            }


            $conexion = DB::connectDB();
            $sql = "SELECT * FROM follows WHERE followed_user_id=".$id;
            $result = $conexion->query($sql);
            $conexion->close();
            $followers = $result->num_rows;


            $conexion = DB::connectDB();
            $sql = "SELECT * FROM follows WHERE following_user_id=".$id;
            $result = $conexion->query($sql);
            $conexion->close();
            $following = $result->num_rows;


            $conexion = DB::connectDB();
            $sql = "SELECT id,nick,name_twitter,api_key,reg_date FROM user WHERE id=".$id;
            $result = $conexion->query($sql);
            $conexion->close();

            if ($result->num_rows>0) {
                while($row = $result->fetch_assoc()) {
                    $edit=false;
                    if($_COOKIE["api_key"]==$row["api_key"]){
                        $edit=true;
                    }

                    echo json_encode(Array("code"=>200, 
                    "id"=>$row["id"], 
                    "nick"=> $row["nick"],
                    "bio"=> $bio,
                    "avatar_url"=> $avatar_url,
                    "banner_url"=> $banner_url,
                    "name_twitter"=> $row["name_twitter"],
                    "reg_date"=> $row["reg_date"],
                    "edit"=> $edit,
                    "my_follow"=> $my_follow,
                    "followers"=> $followers,
                    "following"=> $following));
                }
            } else {
                echo json_encode(Array("code"=>400, "msg"=>"No existe usuario con ese ID"));
            }
        } else {
            echo json_encode(Array("code"=>400, "msg"=>"La api_key no es válida"));
        }
    }


    // Función para obtener 6 perfiles aleatorios para la seccion "A quién seguir"
    public function randomUsers($api_key) {
        if($this->checkApiKey($api_key)){

            $conexion = DB::connectDB();
            $sql = "SELECT user.id,user.nick,user.name_twitter,user_bio.avatar_url FROM user INNER JOIN user_bio ON user.id=user_bio.user_id ORDER BY RAND() LIMIT 6";
            $result = $conexion->query($sql);
            $conexion->close();

            if ($result->num_rows>0) {
                $arr = Array();
                while($row = $result->fetch_assoc()) {
                    $arr[]=Array("id"=>$row["id"], "nick"=> $row["nick"], "name_twitter"=>$row["name_twitter"], "avatar_url"=>$row["avatar_url"]);
                }
                echo json_encode($arr);
            }
        }
    }


    // Función para hacer follow
    public function follow($api_key, $followed_id) {
        if($this->checkApiKey($api_key)){
            $id = $_COOKIE["id"];
            $date = date('Y-m-d H:i:s');

            if($id!=$followed_id){
                $conexion = DB::connectDB();
                $sql = "INSERT INTO follows (following_user_id,followed_user_id,date) VALUES (".$id.",".$followed_id.", '".$date."')";
                if ($conexion->query($sql) != TRUE) {
                    echo "Error: " . $sql . "<br>" . $conexion->error;
                }
                $conexion->close();
            }

        }
    }

    // Función para hacer unfollow
    public function unfollow($api_key, $followed_id) {
        if($this->checkApiKey($api_key)) {
            $id = $_COOKIE["id"];

            if($id!=$followed_id){
                $conexion = DB::connectDB();
                $sql = "DELETE FROM follows WHERE following_user_id=".$id." and followed_user_id=".$followed_id;
                if ($conexion->query($sql) != TRUE) {
                    echo "Error: " . $sql . "<br>" . $conexion->error;
                }
                $conexion->close();
            }

        }
    }


    // Función para escribir un tweet
    public function tweet($content, $api_key, $img_url) {
        if(!isset($img_url)){
            $img_url="";
        }

        if($this->checkApiKey($api_key)) {
            $id = $_COOKIE["id"];
            $date = date('Y-m-d H:i:s');
            $tweet_id = generateRandomString();

            $conexion = DB::connectDB();
            $sql = "INSERT INTO tweets (user_id,tweet_id,date,content,img_url) VALUES (".$id.",'".$tweet_id."','".$date."','".$content."','".$img_url."')";
            if ($conexion->query($sql) != TRUE) {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
            $conexion->close();
            sendRefreshNotification($api_key);
        }
    }


    // Función para dar fav a un tweet
    public function fav($api_key, $tweet_id) {
        if($this->checkApiKey($api_key)){
            $id = $_COOKIE["id"];
            $date = date('Y-m-d H:i:s');

            $conexion = DB::connectDB();
            $sql = "INSERT INTO favs (tweet_id,user_fav_id,date) VALUES ('".$tweet_id."',".$id.",'".$date."')";
            if ($conexion->query($sql) != TRUE) {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
            $conexion->close();
        }
    }


    // Función para dar rt a un tweet
    public function rt($api_key, $tweet_id) {
        if($this->checkApiKey($api_key)){
            $id = $_COOKIE["id"];
            $date = date('Y-m-d H:i:s');

            $conexion = DB::connectDB();
            $sql = "INSERT INTO rt (tweet_id,user_rt_id,date) VALUES ('".$tweet_id."',".$id.",'".$date."')";
            if ($conexion->query($sql) != TRUE) {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
            $conexion->close();
            sendRefreshNotification($api_key);
        }
    }


    // Función para quitar fav a un tweet
    public function fav_remove($api_key, $tweet_id) {
        if($this->checkApiKey($api_key)){
            $id = $_COOKIE["id"];

            $conexion = DB::connectDB();
            $sql = "DELETE FROM favs WHERE tweet_id='".$tweet_id."' and user_fav_id=".$id;
            if ($conexion->query($sql) != TRUE) {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
            $conexion->close();
        }
    }


    // Función para quitar rt a un tweet
    public function rt_remove($api_key, $tweet_id) {
        if($this->checkApiKey($api_key)){
            $id = $_COOKIE["id"];

            $conexion = DB::connectDB();
            $sql = "DELETE FROM rt WHERE tweet_id='".$tweet_id."' and user_rt_id=".$id;
            if ($conexion->query($sql) != TRUE) {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
            $conexion->close();
        }
    }


    // Función para devolver el feed de un usuario (Tweets, y si le ha dado a RT o FAV, y numero de comentarios)
    public function feedExplore($api_key, $page) {
        if($this->checkApiKey($api_key)) {
            $pagina_inicial = ($page-1)*20;
            $pagina_final = $page+20;

            $conexion = DB::connectDB();
            $sql = "SELECT user_id,tweet_id,date,content,img_url FROM tweets ORDER BY date desc LIMIT {$pagina_inicial},{$pagina_final}";
            $result = $conexion->query($sql);
            $conexion->close();

            if ($result->num_rows>0) {
                $arr = Array();
                while($row = $result->fetch_assoc()) {
                    $user_id=$row["user_id"];
                    $tweet_id=$row["tweet_id"];
                    $date=$row["date"]; 
                    $content=$row["content"];
                    $img_url=$row["img_url"];

                    $conexion = DB::connectDB();
                    $sql = "SELECT user.nick as nick,user.name_twitter as name_twitter,user_bio.avatar_url as avatar_url FROM user INNER JOIN user_bio ON user.id=user_bio.user_id WHERE user.id=".$user_id;
                    $result2 = $conexion->query($sql);
                    $conexion->close();

                    $nick="";
                    $name_twitter="";
                    $avatar_url="";
                    if ($result2->num_rows>0) {
                        while($row = $result2->fetch_assoc()) {
                            $nick=$row["nick"];
                            $name_twitter=$row["name_twitter"];
                            $avatar_url=$row["avatar_url"]; 
                        }
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT count(tweet_id) as fav FROM favs WHERE tweet_id='".$tweet_id."'";
                    $result3 = $conexion->query($sql);
                    $conexion->close();

                    $fav=0;
                    if ($result3->num_rows>0) {
                        while($row = $result3->fetch_assoc()) {
                            $fav=intval($row["fav"]);
                        }
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT count(tweet_id) as rt FROM rt WHERE tweet_id='".$tweet_id."'";
                    $result03 = $conexion->query($sql);
                    $conexion->close();

                    $rt=0;
                    if ($result03->num_rows>0) {
                        while($row = $result03->fetch_assoc()) {
                            $rt=intval($row["rt"]);
                        }
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT count(tweet_id) as comments FROM comments WHERE tweet_id='".$tweet_id."'";
                    $result4 = $conexion->query($sql);
                    $conexion->close();

                    $comments=0;
                    if ($result4->num_rows>0) {
                        while($row = $result4->fetch_assoc()) {
                            $comments=intval($row["comments"]);
                        }
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT tweet_id FROM favs WHERE tweet_id='".$tweet_id."' and user_fav_id=".$_COOKIE["id"];
                    $result5 = $conexion->query($sql);
                    $conexion->close();

                    $you_fav=false;
                    if ($result5->num_rows>0) {
                        $you_fav=true;
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT tweet_id FROM rt WHERE tweet_id='".$tweet_id."' and user_rt_id=".$_COOKIE["id"];
                    $result6 = $conexion->query($sql);
                    $conexion->close();

                    $you_rt=false;
                    if ($result6->num_rows>0) {
                        $you_rt=true;
                    }

                    $arr[]=Array(
                        "user_id"=>$user_id,
                        "nick"=>$nick,
                        "name_twitter"=>$name_twitter,
                        "avatar_url"=>$avatar_url,
                        "tweet_id"=> $tweet_id, 
                        "date"=>$date, 
                        "content"=>$content, 
                        "img_url"=>$img_url,
                        "fav"=>$fav,
                        "rt"=>$rt,
                        "comments"=>$comments,
                        "you_fav"=>$you_fav,
                        "you_rt"=>$you_rt
                    );
                }

                echo json_encode($arr);
            }
        }
    }


    // Función para devolver el feed de los tweets de un perfil
    public function profileFeed($api_key, $id, $page) {
        if($this->checkApiKey($api_key)) {
            $userID=$id;

            $pagina_inicial = ($page-1)*20;
            $pagina_final = $page+20;

            $conexion = DB::connectDB();
            $sql = "SELECT user_id,tweet_id,date,content,img_url FROM tweets WHERE user_id=".$userID." ORDER BY date desc LIMIT {$pagina_inicial},{$pagina_final}";
            $result = $conexion->query($sql);
            $conexion->close();

            if ($result->num_rows>0) {
                $arr = Array();
                while($row = $result->fetch_assoc()) {
                    $user_id=$row["user_id"];
                    $tweet_id=$row["tweet_id"];
                    $date=$row["date"]; 
                    $content=$row["content"];
                    $img_url=$row["img_url"];

                    $conexion = DB::connectDB();
                    $sql = "SELECT count(tweet_id) as fav FROM favs WHERE tweet_id='".$tweet_id."'";
                    $result3 = $conexion->query($sql);
                    $conexion->close();

                    $fav=0;
                    if ($result3->num_rows>0) {
                        while($row = $result3->fetch_assoc()) {
                            $fav=intval($row["fav"]);
                        }
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT count(tweet_id) as rt FROM rt WHERE tweet_id='".$tweet_id."'";
                    $result03 = $conexion->query($sql);
                    $conexion->close();

                    $rt=0;
                    if ($result03->num_rows>0) {
                        while($row = $result03->fetch_assoc()) {
                            $rt=intval($row["rt"]);
                        }
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT count(tweet_id) as comments FROM comments WHERE tweet_id='".$tweet_id."'";
                    $result4 = $conexion->query($sql);
                    $conexion->close();

                    $comments=0;
                    if ($result4->num_rows>0) {
                        while($row = $result4->fetch_assoc()) {
                            $comments=intval($row["comments"]);
                        }
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT tweet_id FROM favs WHERE tweet_id='".$tweet_id."' and user_fav_id=".$_COOKIE["id"];
                    $result5 = $conexion->query($sql);
                    $conexion->close();

                    $you_fav=false;
                    if ($result5->num_rows>0) {
                        $you_fav=true;
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT tweet_id FROM rt WHERE tweet_id='".$tweet_id."' and user_rt_id=".$_COOKIE["id"];
                    $result6 = $conexion->query($sql);
                    $conexion->close();

                    $you_rt=false;
                    if ($result6->num_rows>0) {
                        $you_rt=true;
                    }

                    $arr[]=Array(
                        "tweet_id"=> $tweet_id, 
                        "date"=>$date, 
                        "content"=>$content, 
                        "img_url"=>$img_url,
                        "fav"=>$fav,
                        "rt"=>$rt,
                        "comments"=>$comments,
                        "you_fav"=>$you_fav,
                        "you_rt"=>$you_rt
                    );
                }

                echo json_encode($arr);
            }
        }
    }


    // Función para obtener información de un tweet y sus comentarios
    public function tweetPage($api_key, $tweet_id) {
        if($this->checkApiKey($api_key)) {
            $conexion = DB::connectDB();
            $sql = "SELECT user_id,tweet_id,date,content,img_url FROM tweets WHERE tweet_id='".$tweet_id."' LIMIT 1";
            $result = $conexion->query($sql);
            $conexion->close();

            if ($result->num_rows>0) {
                $arr = Array();
                while($row = $result->fetch_assoc()) {
                    $user_id=$row["user_id"];
                    $tweet_id=$row["tweet_id"];
                    $date=$row["date"]; 
                    $content=$row["content"];
                    $img_url=$row["img_url"];

                    $conexion = DB::connectDB();
                    $sql = "SELECT user.nick as nick,user.name_twitter as name_twitter,user_bio.avatar_url as avatar_url FROM user INNER JOIN user_bio ON user.id=user_bio.user_id WHERE user.id=".$user_id;
                    $result2 = $conexion->query($sql);
                    $conexion->close();

                    $nick="";
                    $name_twitter="";
                    $avatar_url="";
                    if ($result2->num_rows>0) {
                        while($row = $result2->fetch_assoc()) {
                            $nick=$row["nick"];
                            $name_twitter=$row["name_twitter"];
                            $avatar_url=$row["avatar_url"]; 
                        }
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT count(tweet_id) as fav FROM favs WHERE tweet_id='".$tweet_id."'";
                    $result3 = $conexion->query($sql);
                    $conexion->close();

                    $fav=0;
                    if ($result3->num_rows>0) {
                        while($row = $result3->fetch_assoc()) {
                            $fav=intval($row["fav"]);
                        }
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT count(tweet_id) as rt FROM rt WHERE tweet_id='".$tweet_id."'";
                    $result03 = $conexion->query($sql);
                    $conexion->close();

                    $rt=0;
                    if ($result03->num_rows>0) {
                        while($row = $result03->fetch_assoc()) {
                            $rt=intval($row["rt"]);
                        }
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT count(tweet_id) as comments FROM comments WHERE tweet_id='".$tweet_id."'";
                    $result4 = $conexion->query($sql);
                    $conexion->close();

                    $comments=0;
                    if ($result4->num_rows>0) {
                        while($row = $result4->fetch_assoc()) {
                            $comments=intval($row["comments"]);
                        }
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT tweet_id FROM favs WHERE tweet_id='".$tweet_id."' and user_fav_id=".$_COOKIE["id"];
                    $result5 = $conexion->query($sql);
                    $conexion->close();

                    $you_fav=false;
                    if ($result5->num_rows>0) {
                        $you_fav=true;
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT tweet_id FROM rt WHERE tweet_id='".$tweet_id."' and user_rt_id=".$_COOKIE["id"];
                    $result6 = $conexion->query($sql);
                    $conexion->close();

                    $you_rt=false;
                    if ($result6->num_rows>0) {
                        $you_rt=true;
                    }

                    $arr[]=Array(
                        "user_id"=>$user_id,
                        "nick"=>$nick,
                        "name_twitter"=>$name_twitter,
                        "avatar_url"=>$avatar_url,
                        "tweet_id"=> $tweet_id, 
                        "date"=>$date, 
                        "content"=>$content, 
                        "img_url"=>$img_url,
                        "fav"=>$fav,
                        "rt"=>$rt,
                        "comments"=>$comments,
                        "you_fav"=>$you_fav,
                        "you_rt"=>$you_rt,
                        "comments"=>Array()
                    );
                }

                echo json_encode($arr);
            }
        }
    }


    // Función que devuelve los ajuestes de la cuenta del usuario
    public function settingsLoad($api_key) {
        if($this->checkApiKey($api_key)) {
            $id = $_COOKIE["id"];

            $conexion = DB::connectDB();
            $sql = "SELECT user.id,user.nick,user.name_twitter,user_bio.avatar_url,user_bio.bio,user_bio.banner_url FROM user INNER JOIN user_bio ON user.id=user_bio.user_id WHERE user.id=".$id;
            $result = $conexion->query($sql);
            $conexion->close();

            if ($result->num_rows>0) {
                $arr = Array();
                while($row = $result->fetch_assoc()) {
                    $arr[]=Array(
                        "id"=>$row["id"], 
                        "nick"=> $row["nick"], 
                        "name_twitter"=>$row["name_twitter"], 
                        "bio"=> $row["bio"], 
                        "avatar_url"=>$row["avatar_url"], 
                        "banner_url"=>$row["banner_url"]
                    );
                }
                echo json_encode($arr);
            }

        }
    }


    // Función para actualizar ajustes de la cuenta (nombre, biografía, banner, avatar...)
    public function settings($api_key, $avatar_url, $banner_url, $name, $bio) {
        if($this->checkApiKey($api_key)) {
            $id = $_COOKIE["id"];

            $avatar=$avatar_url;
            if($avatar_url!="img/default.png" && strpos($avatar_url, '_avatar.jpg')==false){
                $this->downloadURL($avatar_url, "avatar");
                $avatar="/api/img/".$_COOKIE['id']."_avatar.jpg";
            }

            $banner=$banner_url;
            if($banner_url!="img/banner.jpg" && strpos($banner_url, '_banner.jpg')==false){
                $this->downloadURL($banner_url, "banner");
                $banner="/api/img/".$_COOKIE['id']."_banner.jpg";
            }

            $conexion = DB::connectDB();
            $sql = "UPDATE user SET name_twitter='".$name."' WHERE id=".$id;
            $conexion->query($sql);
            $conexion->close();

            $conexion = DB::connectDB();
            $sql = "UPDATE user_bio SET bio='".$bio."', avatar_url='".$avatar."', banner_url='".$banner."' WHERE user_id=".$id;
            $conexion->query($sql);
            $conexion->close();
        }
    }


    // Función que devuelve los followers de un usuario
    public function followers($api_key, $user_id, $page) {
        if($this->checkApiKey($api_key)) {
            $pagina_inicial = ($page-1)*20;
            $pagina_final = $page+20;

            $conexion = DB::connectDB();
            $sql = "SELECT user.id,user.nick,user.name_twitter FROM user INNER JOIN follows ON user.id=follows.following_user_id WHERE follows.followed_user_id=".$user_id." LIMIT {$pagina_inicial},{$pagina_final}";
            $result = $conexion->query($sql);
            $conexion->close();

            if ($result->num_rows>0) {
                $arr = Array();
                while($row = $result->fetch_assoc()) {
                    $arr[]=Array(
                        "id"=>$row["id"],
                        "nick"=> $row["nick"], 
                        "name_twitter"=>$row["name_twitter"]
                    );
                }
                echo json_encode($arr);
            }
        }
    }


        // Función que devuelve los perfiles seguidos de un usuario
        public function followings($api_key, $user_id, $page) {
            if($this->checkApiKey($api_key)) {
                $pagina_inicial = ($page-1)*20;
                $pagina_final = $page+20;
    
                $conexion = DB::connectDB();
                $sql = "SELECT user.id,user.nick,user.name_twitter FROM user INNER JOIN follows ON user.id=follows.followed_user_id WHERE follows.following_user_id=".$user_id." LIMIT {$pagina_inicial},{$pagina_final}";
                $result = $conexion->query($sql);
                $conexion->close();
    
                if ($result->num_rows>0) {
                    $arr = Array();
                    while($row = $result->fetch_assoc()) {
                        $arr[]=Array(
                            "id"=>$row["id"],
                            "nick"=> $row["nick"], 
                            "name_twitter"=>$row["name_twitter"]
                        );
                    }
                    echo json_encode($arr);
                }
            }
        }


    // Función para hacer un comentario en un tweet
    public function search($api_key, $name_twitter) {
        if($this->checkApiKey($api_key)) {
            $conexion = DB::connectDB();
            $sql = "SELECT id FROM user WHERE nick='".$name_twitter."'";
            $result = $conexion->query($sql);
            $conexion->close();

            if ($result->num_rows>0) {
                $arr = Array();
                while($row = $result->fetch_assoc()) {
                    $arr[]=Array(
                        "id"=>$row["id"]
                    );
                }
                echo json_encode($arr);
            }
        }
    }


    // Función para hacer un comentario en un tweet
    public function comment($api_key, $tweet_id, $content) {
        if($this->checkApiKey($api_key)) {
            $id = $_COOKIE["id"];
            $date = date('Y-m-d H:i:s');

            $conexion = DB::connectDB();
            $sql = "INSERT INTO comments (tweet_id,user_id,content,date) VALUES ('".$tweet_id."',".$id.",'".$content."','".$date."')";
            if ($conexion->query($sql) != TRUE) {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
            $conexion->close();
        }
    }


    // Función que devuelve los comentarios de un tweet
    public function tweetComments($api_key, $tweet_id, $page) {
        if($this->checkApiKey($api_key)) {
            $pagina_inicial = ($page-1)*10;
            $pagina_final = $page+10;

            $conexion = DB::connectDB();
            $sql = "SELECT comments.user_id as user_id,comments.content as content,comments.date as date,user.nick as nick,user.name_twitter as name_twitter FROM comments INNER JOIN user ON comments.user_id=user.id WHERE comments.tweet_id='".$tweet_id."' ORDER BY date desc LIMIT {$pagina_inicial},{$pagina_final}";
            $result = $conexion->query($sql);
            $conexion->close();

            if ($result->num_rows>0) {
                $arr = Array();
                while($row = $result->fetch_assoc()) {
                    $arr[]=Array(
                        "user_id"=>$row["user_id"],
                        "name_twitter"=>$row["name_twitter"],
                        "nick"=>$row["nick"],
                        "content"=>$row["content"],
                        "date"=>$row["date"]
                    );
                }
                echo json_encode($arr);
            }
        }
    }


    // Función para devolver el feed de los tweets de un perfil
    // SELECT user.id as id,user.nick as nick,user.name_twitter as name_twitter,tweets.tweet_id as tweet_id,tweets.content as content,tweets.img_url as img_url,tweets.date as date FROM user  INNER JOIN follows ON user.id=follows.followed_user_id INNER JOIN tweets ON follows.followed_user_id=tweets.user_id WHERE follows.following_user_id=4
    public function followsFeed($api_key, $page) {
        if($this->checkApiKey($api_key)) {

            $arr[]=Array();
            $pagina_inicial = ($page-1)*20;
            $pagina_final = $page+20;
            
            $conexion = DB::connectDB();
            $sql = "SELECT id,nick,name_twitter,tweet_id,content,img_url,date,type_feed,rt_id,rt_name FROM ( SELECT user.id as id,user.nick as nick,user.name_twitter as name_twitter,tweets.tweet_id as tweet_id,tweets.content as content,tweets.img_url as img_url,tweets.date as date, 'follow' as type_feed, null as rt_id, null as rt_name FROM user INNER JOIN follows ON user.id=follows.followed_user_id INNER JOIN tweets ON follows.followed_user_id=tweets.user_id INNER JOIN (SELECT id as user_id from user where api_key='".$api_key."') as idtable ON follows.following_user_id=idtable.user_id UNION ALL SELECT distinct nombre.id as id, nombre.nick as nick, nombre.name_twitter as name_twitter, rt.tweet_id as tweet_id, tweets.content as content, tweets.img_url as img_url, tweets.date as date, 'rt' as type_feed, rt.user_rt_id as rt_id, name.name_twitter as rt_name FROM user INNER JOIN (SELECT id as user_id from user where api_key='".$api_key."') as idtable ON user.id=idtable.user_id INNER JOIN follows ON idtable.user_id=follows.following_user_id INNER JOIN user as usuario ON usuario.id=follows.followed_user_id INNER JOIN rt ON usuario.id=rt.user_rt_id INNER JOIN tweets ON rt.tweet_id=tweets.tweet_id INNER JOIN user as name ON name.id=usuario.id INNER JOIN user as nombre ON nombre.id=tweets.user_id ) feed group by tweet_id Order by date desc LIMIT {$pagina_inicial},{$pagina_final}";
            $result2 = $conexion->query($sql);
            $conexion->close();

            if ($result2->num_rows>0) {
                while($row = $result2->fetch_assoc()) {
                    $user_id=$row["id"];
                    $nick=$row["nick"];
                    $name_twitter=$row["name_twitter"];
                    $tweet_id=$row["tweet_id"];
                    $date=$row["date"];
                    $content=$row["content"];
                    $img_url=$row["img_url"];
                    $type_feed=$row["type_feed"];
                    $rt_name=$row["rt_name"];

                    $conexion = DB::connectDB();
                    $sql = "SELECT count(tweet_id) as fav FROM favs WHERE tweet_id='".$tweet_id."'";
                    $result3 = $conexion->query($sql);
                    $conexion->close();

                    $fav=0;
                    if ($result3->num_rows>0) {
                        while($row = $result3->fetch_assoc()) {
                            $fav=intval($row["fav"]);
                        }
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT count(tweet_id) as rt FROM rt WHERE tweet_id='".$tweet_id."'";
                    $result03 = $conexion->query($sql);
                    $conexion->close();

                    $rt=0;
                    if ($result03->num_rows>0) {
                        while($row = $result03->fetch_assoc()) {
                            $rt=intval($row["rt"]);
                        }
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT count(tweet_id) as comments FROM comments WHERE tweet_id='".$tweet_id."'";
                    $result4 = $conexion->query($sql);
                    $conexion->close();

                    $comments=0;
                    if ($result4->num_rows>0) {
                        while($row = $result4->fetch_assoc()) {
                            $comments=intval($row["comments"]);
                        }
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT tweet_id FROM favs WHERE tweet_id='".$tweet_id."' and user_fav_id=".$_COOKIE["id"];
                    $result5 = $conexion->query($sql);
                    $conexion->close();

                    $you_fav=false;
                    if ($result5->num_rows>0) {
                        $you_fav=true;
                    }

                    $conexion = DB::connectDB();
                    $sql = "SELECT tweet_id FROM rt WHERE tweet_id='".$tweet_id."' and user_rt_id=".$_COOKIE["id"];
                    $result6 = $conexion->query($sql);
                    $conexion->close();

                    $you_rt=false;
                    if ($result6->num_rows>0) {
                        $you_rt=true;
                    }

                    $arr[]=Array(
                        "user_id"=>$user_id,
                        "nick"=>$nick,
                        "name_twitter"=>$name_twitter,
                        "tweet_id"=> $tweet_id, 
                        "date"=>$date, 
                        "content"=>$content, 
                        "img_url"=>$img_url,
                        "type_feed"=>$type_feed,
                        "rt_name"=>$rt_name,
                        "fav"=>$fav,
                        "rt"=>$rt,
                        "comments"=>$comments,
                        "you_fav"=>$you_fav,
                        "you_rt"=>$you_rt,
                    );
                }
            }

            echo json_encode($arr);
        }
    }


    // Función que devuelve las notificaciones de un usuario
    //--------------------------------------------------------------------------------------
    // FAVS
    // SELECT DISTINCT favs.user_fav_id as user_id, favs.tweet_id as tweet_id, favs.date as date  FROM favs INNER JOIN (SELECT tweets.user_id as user_id,tweets.tweet_id as tweet_id from tweets where tweets.user_id=4) tweets ON favs.tweet_id=tweets.tweet_id and favs.user_fav_id!=4

    // RT
    // SELECT DISTINCT rt.user_rt_id as user_id, rt.tweet_id as tweet_id, rt.date as date FROM rt INNER JOIN (SELECT tweets.user_id as user_id,tweets.tweet_id as tweet_id from tweets where tweets.user_id=4) tweets ON rt.tweet_id=tweets.tweet_id and rt.user_rt_id!=4

    // COMMENTS
    // SELECT DISTINCT comments.user_id as user_id, comments.tweet_id as tweet_id, comments.date as date FROM comments INNER JOIN (SELECT tweets.user_id as user_id,tweets.tweet_id as tweet_id from tweets where tweets.user_id=4) tweets ON comments.tweet_id=tweets.tweet_id and comments.user_id!=4

    // FOLLOWS
    // SELECT follows.following_user_id as following_user_id, follows.date as date  FROM user INNER JOIN follows ON user.id=follows.followed_user_id WHERE user.id=4
    public function notificationFeed($api_key, $page) {
        if($this->checkApiKey($api_key)) {
            $id = $_COOKIE["id"];

            $pagina_inicial = ($page-1)*10;
            $pagina_final = $page+10;

            $arr=[];


            $conexion = DB::connectDB();
            $sql = "SELECT DISTINCT favs.user_fav_id as user_id, favs.tweet_id as tweet_id, favs.date as date FROM favs INNER JOIN (SELECT tweets.user_id as user_id,tweets.tweet_id as tweet_id from tweets where tweets.user_id=".$id.") tweets ON favs.tweet_id=tweets.tweet_id and favs.user_fav_id!=".$id." LIMIT {$pagina_inicial},{$pagina_final}";
            $result1 = $conexion->query($sql);
            $conexion->close();

            if ($result1->num_rows>0) {
                while($row = $result1->fetch_assoc()) {
                    $user_id=$row["user_id"];
                    $tweet_id=$row["tweet_id"];
                    $date=$row["date"];

                    $conexion = DB::connectDB();
                    $sql = "SELECT nick as nick,name_twitter as name_twitter FROM user WHERE id=".$row["user_id"]."";
                    $result2 = $conexion->query($sql);
                    $conexion->close();

                    if ($result2->num_rows>0) {
                        while($row = $result2->fetch_assoc()) {
                            $arr[]=Array(
                                "type"=>"fav",
                                "user_id"=>$user_id,
                                "nick"=>$row["nick"],
                                "name_twitter"=>$row["name_twitter"],
                                "tweet_id"=>$tweet_id,
                                "date"=>$date
                            );
                        }
                    }
                }
            }


            $conexion = DB::connectDB();
            $sql = "SELECT DISTINCT rt.user_rt_id as user_id, rt.tweet_id as tweet_id, rt.date as date FROM rt INNER JOIN (SELECT tweets.user_id as user_id,tweets.tweet_id as tweet_id from tweets where tweets.user_id=".$id.") tweets ON rt.tweet_id=tweets.tweet_id and rt.user_rt_id!=".$id." LIMIT {$pagina_inicial},{$pagina_final}";
            $result1 = $conexion->query($sql);
            $conexion->close();

            if ($result1->num_rows>0) {
                while($row = $result1->fetch_assoc()) {
                    $user_id=$row["user_id"];
                    $tweet_id=$row["tweet_id"];
                    $date=$row["date"];

                    $conexion = DB::connectDB();
                    $sql = "SELECT nick as nick,name_twitter as name_twitter FROM user WHERE id='".$row["user_id"]."'";
                    $result2 = $conexion->query($sql);
                    $conexion->close();

                    if ($result2->num_rows>0) {
                        while($row = $result2->fetch_assoc()) {
                            $arr[]=Array(
                                "type"=>"rt",
                                "user_id"=>$user_id,
                                "nick"=>$row["nick"],
                                "name_twitter"=>$row["name_twitter"],
                                "tweet_id"=>$tweet_id,
                                "date"=>$date
                            );
                        }
                    }
                }
            }


            $conexion = DB::connectDB();
            $sql = "SELECT DISTINCT comments.user_id as user_id, comments.tweet_id as tweet_id, comments.date as date FROM comments INNER JOIN (SELECT tweets.user_id as user_id,tweets.tweet_id as tweet_id from tweets where tweets.user_id=".$id.") tweets ON comments.tweet_id=tweets.tweet_id and comments.user_id!=".$id." LIMIT {$pagina_inicial},{$pagina_final}";
            $result1 = $conexion->query($sql);
            $conexion->close();

            if ($result1->num_rows>0) {
                while($row = $result1->fetch_assoc()) {
                    $user_id=$row["user_id"];
                    $tweet_id=$row["tweet_id"];
                    $date=$row["date"];

                    $conexion = DB::connectDB();
                    $sql = "SELECT nick as nick,name_twitter as name_twitter FROM user WHERE id='".$row["user_id"]."'";
                    $result2 = $conexion->query($sql);
                    $conexion->close();

                    if ($result2->num_rows>0) {
                        while($row = $result2->fetch_assoc()) {
                            $arr[]=Array(
                                "type"=>"comment",
                                "user_id"=>$user_id,
                                "nick"=>$row["nick"],
                                "name_twitter"=>$row["name_twitter"],
                                "tweet_id"=>$tweet_id,
                                "date"=>$date
                            );
                        }
                    }
                }
            }


            $conexion = DB::connectDB();
            $sql = "SELECT follows.following_user_id as following_user_id, follows.date as date  FROM user INNER JOIN follows ON user.id=follows.followed_user_id WHERE user.id=".$id." LIMIT {$pagina_inicial},{$pagina_final}";
            $result1 = $conexion->query($sql);
            $conexion->close();

            if ($result1->num_rows>0) {
                while($row = $result1->fetch_assoc()) {
                    $user_id=$row["following_user_id"];
                    $date=$row["date"];

                    $conexion = DB::connectDB();
                    $sql = "SELECT nick as nick,name_twitter as name_twitter FROM user WHERE id='".$row["following_user_id"]."'";
                    $result2 = $conexion->query($sql);
                    $conexion->close();

                    if ($result2->num_rows>0) {
                        while($row = $result2->fetch_assoc()) {
                            $arr[]=Array(
                                "type"=>"follow",
                                "user_id"=>$user_id,
                                "nick"=>$row["nick"],
                                "name_twitter"=>$row["name_twitter"],
                                "date"=>$date
                            );
                        }
                    }
                }
            }

            usort($arr, function($a1, $a2) {
                $v1 = strtotime($a1['date']);
                $v2 = strtotime($a2['date']);
                return $v1 - $v2;
             });

            echo json_encode(array_reverse($arr));
        }
    }


    // Función para eliminar uno de tus tweets
    public function deleteTweet($api_key, $tweet_id) {
        if($this->checkApiKey($api_key)) {
            $id = $_COOKIE["id"];

            $conexion = DB::connectDB();
            $sql = "DELETE FROM tweets WHERE tweet_id='".$tweet_id."' and user_id=".$id;
            if ($conexion->query($sql) != TRUE) {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
            $conexion->close();
        }
    }

    // Función para subir archivo del Avatar
    public function uploadAvatarSQL($api_key) {
        if($this->checkApiKey($api_key)) {
            $id = $_COOKIE["id"];

            $avatar_url="/api/img/".$_COOKIE['id']."_avatar.jpg";

            $conexion = DB::connectDB();
            $sql = "UPDATE user_bio SET avatar_url='".$avatar_url."' WHERE user_id=".$id;
            $conexion->query($sql);
            $conexion->close();
        }
    }


    // Función para subir archivo del Banner
    public function uploadBannerSQL($api_key) {
        if($this->checkApiKey($api_key)) {
            $id = $_COOKIE["id"];

            $avatar_url="/api/img/".$_COOKIE['id']."_banner.jpg";

            $conexion = DB::connectDB();
            $sql = "UPDATE user_bio SET banner_url='".$avatar_url."' WHERE user_id=".$id;
            $conexion->query($sql);
            $conexion->close();
        }
    }

}