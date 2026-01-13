<?php
require_once(__DIR__ . '/../config/db.php');

function h(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

function db_conn() {
    try {
        $server_info = 'mysql:dbname=' . DB_NAME . ';charset=utf8;host=' . DB_HOST;
        $pdo = new PDO($server_info, DB_USER, DB_PASS);

        // switch to exception mode
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo; //important
    } catch (PDOException $e) {
        exit('Error: DB connection:' . $e->getMessage());
    }
}

function sql_error($stmt) {
    $error = $stmt->errorInfo();
    exit("SQLError:" . $error[2]);
}

function redirect($path) {
    header("Location: " . $path);
    exit;
}

function login_success($user) {
    session_regenerate_id(true);

    $_SESSION["chk_ssid"] = session_id();

    $_SESSION["u_id"] = $user["u_id"] ?? null;
    $_SESSION["u_name"] = $user["u_name"] ?? null;
    $_SESSION["u_role_flg"] = $user["u_role_flg"] ?? null;
}

function require_login() {
    if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] !== session_id()) {
        redirect("login.php");
        exit();
    }
}
