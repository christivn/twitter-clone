<?php
abstract class DB {
    private static $servername = "localhost";
    private static $username = "";
    private static $password = "";
    private static $dbname = "";

    public static function connectDB() {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
        if ($conn->connect_error) {
            die("Error: " . $conn->connect_error);
        }
        return $conn;
    }
}
?>