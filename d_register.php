<?php
ini_set("display_errors", 1);

require_once(__DIR__ . "/inc/functions.php");

// deal registration
$c_id = $_POST["c_id"];
$d_code = $_POST["d_code"];
$d_name = $_POST["d_name"];
$d_sales = $_POST["d_sales"];

// validation: blank fields prohibited
if ($c_id === '' || $d_code === '' || $d_name === '' || $d_sales === '') {
    header('Location: index.php?error=blank');
    exit;
}

// validation: d_code is not 10 digits
if (!preg_match('/^\d{10}$/', $d_code)) {
    header('Location: index.php?error=code');
    exit;
}

// connect to DB
$pdo = db_conn();

// create SQL
$sql = "
    INSERT INTO deal_master(
        c_id, 
        d_code, 
        d_name, 
        d_sales, 
        d_created_at
    ) VALUES (
        :c_id, 
        :d_code, 
        :d_name, 
        :d_sales, 
        sysdate()
    )
";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':c_id', $c_id, PDO::PARAM_INT);
$stmt->bindValue(':d_code', $d_code, PDO::PARAM_STR);
$stmt->bindValue(':d_name', $d_name, PDO::PARAM_STR);
$stmt->bindValue(':d_sales', $d_sales, PDO::PARAM_INT);

try {
    $stmt->execute();
    header('Location: index.php');
    exit;

    // Duplicate (UNIQUE) error
    //SQLSTATE: 23000 (+ MySQL error number: 1062)
} catch (PDOException $e) {
    if ($e->getCode() === '23000') {
        header('Location: index.php?error=duplicate');
        exit;
    }

    exit('error: SQL execution' . $e->getMessage());
}
