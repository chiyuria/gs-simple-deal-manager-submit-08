<?php
require_once __DIR__ . "/inc/functions.php";

session_start();

require_once __DIR__ . "/config/db.php";

$u_login_id = $_POST["u_login_id"];
$u_login_pw = $_POST["u_login_pw"];

$pdo = db_conn();

// Fetch active user by login ID (password is verified later)
$stmt = $pdo->prepare("
    SELECT *
    FROM user_master
    WHERE u_login_id=:u_login_id
    AND u_life_flg=0
");
$stmt->bindValue(":u_login_id", $u_login_id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status === false) {
    sql_error($stmt);
}

// Get user record as associative array
$val = $stmt->fetch(PDO::FETCH_ASSOC);

// If no user found, redirect back to login
if (!$val) {
    redirect("login.php");
    exit();
}

// Verify input password against hashed password
$pw = password_verify($u_login_pw, $val["u_login_pw"]);

if ($pw) {
    login_success($val);
    redirect("deals_list.php");
} else {
    redirect("login.php");
}

exit();
