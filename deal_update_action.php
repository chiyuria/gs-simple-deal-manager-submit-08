<?php
require_once(__DIR__ . "/inc/functions.php");

$d_id = $_POST["d_id"];
$c_id = $_POST["c_id"];
$d_code = $_POST["d_code"];
$d_name = $_POST["d_name"];
$d_sales = $_POST["d_sales"];

// validation: blank fields prohibited
if ($d_id === "" || $c_id === "" || $d_code === "" || $d_name === "" || $d_sales === "") {
    redirect("deal_edit.php?d_id=" . urlencode($d_id) . "&error=blank");
}

// connect to DB
$pdo = db_conn();

// create SQL
$sql = "
    UPDATE deal_master
    SET
        c_id = :c_id,
        d_code = :d_code,
        d_name = :d_name,
        d_sales = :d_sales
    WHERE d_id = :d_id
";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":c_id", $c_id, PDO::PARAM_INT);
$stmt->bindValue(":d_code", $d_code, PDO::PARAM_STR);
$stmt->bindValue(":d_name", $d_name, PDO::PARAM_STR);
$stmt->bindValue(":d_sales", (int)$d_sales, PDO::PARAM_INT);
$stmt->bindValue(":d_id", $d_id, PDO::PARAM_INT);
$stmt->execute();

// back to top
redirect("index.php");
