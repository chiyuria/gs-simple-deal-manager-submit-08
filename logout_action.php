<?php
require_once __DIR__ . "/inc/functions.php";

session_start();
require_login();

$_SESSION = [];

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

session_destroy();
redirect("index.php");
exit();
