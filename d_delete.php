<?php
require_once(__DIR__ . "/inc/functions.php");

$d_ids = $_POST["d_ids"] ?? [];

if(empty($d_ids)) {
    header("Location: index.php");
    exit;
}

// connect to DB
$pdo = db_conn();

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