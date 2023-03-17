<?php
session_start();
require_once 'dbconnect.php';

if (!isset($_SESSION['user_session'])) {
    header("Location: login.php");
    exit;
}

if (isset($_SESSION['user_session'])) {
    unset($_SESSION['user_session']);
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

?>