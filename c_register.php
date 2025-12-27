<?php
ini_set("display_errors", 1);

require_once __DIR__ . '/config/db.php';

// customer registration
$c_code = $_POST["c_code"];
$c_name = $_POST["c_name"];

// validation: blank fields prohibited
if ($c_code === '' || $c_name === '') {
    header('Location: c_manage.php?error=blank');
    exit;
}

// validation: c_code is not 10 digits
if (!preg_match('/^\d{10}$/', $c_code)) {
    header('Location: c_manage.php?error=code');
    exit;
}

// connect to DB
try {
    $server_info = 'mysql:dbname=' . DB_NAME . ';charset=utf8;host=' . DB_HOST;
    $pdo = new PDO($server_info, DB_USER, DB_PASS);
} catch (PDOException $e) {
    exit('Error: DB connection:' . $e->getMessage());
}

// switch to exception mode
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    header('Location: c_manage.php');
    exit;

// Duplicate (UNIQUE) error
//SQLSTATE: 23000 (+ MySQL error number: 1062)
} catch (PDOException $e) {
    if ($e->getCode() === '23000') {
        header('Location: c_manage.php?error=duplicate');
        exit;
    }

    exit('error: SQL execution' . $e->getMessage());
}
