<?php
ob_start();
session_start();
require_once 'dbconnect.php';

date_default_timezone_set("Asia/Kolkata");

if (isset($_SESSION['user_session']) && $payload["function"] != "login") {
    exit;
}

$payload = $_POST["data"];

switch ($payload["function"]) {
    case "login":
        global $conn;
        $result = array(
            "status" => "success",
            "data" => "",
            "message" => "Login Successfully"
        );

        $email = $payload["email"];
        $pass = $payload["password"];

        $sql = "SELECT * FROM `userDetails` WHERE `userEmail`='$email'";
        $res = $conn->prepare($sql);
        $res->execute();
        $row = $res->fetch();

        $password = hash('sha256', $pass);
        if ($res->rowCount() == 1 && $row['userPassword'] == $password) {
            $_SESSION['user_session'] = $row['userId'];
            $result["status"] = "success";
            $result["message"] = "Logged in successfully";
        } else {
            $result["status"] = "failure";
            $result["message"] = "Incorrect Credentials, Try again...";
        }
        echo json_encode($result);
        exit;
    default:
        $formData = $payload["data"];
        echo $formData;
        exit;
}
?>