<?php
require_once __DIR__ . "/inc/functions.php";

session_start();
require_login();

// deal registration
$c_id = $_POST["c_id"];
$d_code = $_POST["d_code"];
$d_name = $_POST["d_name"];
$d_sales = $_POST["d_sales"];

// validation: blank fields prohibited
if ($c_id === '' || $d_code === '' || $d_name === '' || $d_sales === '') {
    redirect("deals_list.php?error=blank");
}

// validation: d_code is not 10 digits
if (!preg_match('/^\d{10}$/', $d_code)) {
    redirect("deals_list.php?error=code");
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
    redirect("deals_list.php");

    // Duplicate (UNIQUE) error
    //SQLSTATE: 23000 (+ MySQL error number: 1062)
} catch (PDOException $e) {
    if ($e->getCode() === '23000') {
        redirect("deals_list.php?error=duplicate");
    }

    exit('error: SQL execution' . $e->getMessage());
}
