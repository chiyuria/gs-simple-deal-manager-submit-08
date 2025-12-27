<?php
require_once __DIR__ . "/config/db.php";

$d_ids = $_POST["d_ids"] ?? [];

if(empty($d_ids)) {
    header("Location: index.php");
    exit;
}

// connect to DB
try {
    $server_info = "mysql:dbname=" . DB_NAME . ";charset=utf8;host=" . DB_HOST;
    $pdo = new PDO($server_info, DB_USER, DB_PASS);
} catch (PDOException $e) {
    exit("Error: DB connection:" . $e->getMessage());
}

// create placeholder
$placeholders = implode(",", array_fill(0, count($d_ids), "?"));

$sql = "
    DELETE FROM deal_master
    WHERE d_id
        IN ($placeholders)
";
$stmt = $pdo->prepare($sql);

$stmt->execute($d_ids);

header("Location: index.php");
exit;