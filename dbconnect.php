<?php
error_reporting(~E_DEPRECATED & ~E_NOTICE);
$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO(
        "mysql:host=$servername;dbname=wpm",
        $username,
        $password,
        array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8"
        )
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>