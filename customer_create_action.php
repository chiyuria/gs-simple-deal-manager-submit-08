<?php
require_once __DIR__ . "/inc/functions.php";

session_start();
require_admin();

// customer registration
$c_code = $_POST["c_code"];
$c_name = $_POST["c_name"];

// validation: blank fields prohibited
if ($c_code === '' || $c_name === '') {
    redirect("customers_list.php?error=blank");
}

// validation: c_code is not 10 digits
if (!preg_match('/^\d{10}$/', $c_code)) {
    redirect("customers_list.php?error=code");
}

// connect to DB
$pdo = db_conn();

// create SQL
$sql = "
    INSERT INTO customer_master(
        c_code, 
        c_name, 
        c_created_at
    ) VALUES (
        :c_code, 
        :c_name, 
        sysdate()
    )
";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':c_code', $c_code, PDO::PARAM_STR);
$stmt->bindValue(':c_name', $c_name, PDO::PARAM_STR);

try {
    $stmt->execute();
    redirect("customers_list.php");

// Duplicate (UNIQUE) error
//SQLSTATE: 23000 (+ MySQL error number: 1062)
} catch (PDOException $e) {
    if ($e->getCode() === '23000') {
        redirect("customers_list.php?error=duplicate");
    }

    exit('error: SQL execution' . $e->getMessage());
}
