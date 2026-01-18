<?php
require_once __DIR__ . "/inc/functions.php";

session_start();
require_admin();

require_once __DIR__ . "/config/db.php";
$pdo = db_conn();

// ===== Get POST values =====
$u_id = isset($_POST["u_id"]) ? (int)$_POST["u_id"] : 0;
$u_role_flg = isset($_POST["u_role_flg"]) ? (int)$_POST["u_role_flg"] : -1;
$u_life_flg = isset($_POST["u_life_flg"]) ? (int)$_POST["u_life_flg"] : -1;

// ===== Basic validation =====
if ($u_id <= 0) {
    redirect("admin_user_edit.php?u_id=" . $u_id . "&error=invalid");
    exit;
}

if (!in_array($u_role_flg, [0, 1], true) || !in_array($u_life_flg, [0, 1], true)) {
    redirect("admin_user_edit.php?u_id=" . $u_id . "&error=invalid");
    exit;
}

// ===== Safety check: prevent updating yourself =====
if (isset($_SESSION["u_id"]) && (int)$_SESSION["u_id"] === $u_id) {
    redirect("admin_user_edit.php?u_id=" . $u_id . "&error=self");
    exit;
}

// ===== Update user role & status =====
$sql = "
    UPDATE user_master
    SET u_role_flg = :u_role_flg,
        u_life_flg = :u_life_flg
    WHERE u_id = :u_id
";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":u_role_flg", $u_role_flg, PDO::PARAM_INT);
$stmt->bindValue(":u_life_flg", $u_life_flg, PDO::PARAM_INT);
$stmt->bindValue(":u_id", $u_id, PDO::PARAM_INT);

try {
    $stmt->execute();
    redirect("admin_users.php");
    exit;
} catch (Exception $e) {
    redirect("admin_user_edit.php?u_id=" . $u_id . "&error=fail");
    exit;
}
