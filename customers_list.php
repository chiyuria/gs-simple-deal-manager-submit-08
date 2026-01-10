<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/inc/functions.php";

$pdo = db_conn();

$sql = "
    SELECT 
        c_id, 
        c_code, 
        c_name 
    FROM customer_master 
    ORDER BY c_id ASC
    ";
$stmt = $pdo->query($sql);
$customers = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Deal Manager</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/buttons.css">
    <link rel="stylesheet" href="./assets/css/scroll.css">
    <link rel="stylesheet" href="./assets/css/form.css">
    <link rel="stylesheet" href="./assets/css/table.css">
    <link rel="stylesheet" href="./assets/css/responsive.css">
</head>

<body>
    <?php include "./inc/header.html"; ?>

    <main class="main-wrapper single-column">
        <div class="col col-single">

            <div class="col-header">
                <h2>顧客管理</h2>
                <button class="btn btn-ghost" onclick="location.href='index.php'">案件管理</button>
            </div>

            <div class="col-content">
                <!-- error message -->
                <?php if (($_GET['error'] ?? '') === 'blank'): ?>
                    <p style="color:red">There are some fields left blank.</p>
                <?php endif; ?>

                <?php if (($_GET['error'] ?? '') === 'code'): ?>
                    <p style="color:red">The customer code must be 10 digits long.</p>
                <?php endif; ?>

                <?php if (($_GET['error'] ?? '') === 'duplicate'): ?>
                    <p style="color:red">Customer code already exists.</p>
                <?php endif; ?>

                <form action="customer_create_action.php" method="post">
                    <fieldset class="customer-form">

                        <legend class="form-legend">顧客登録</legend>

                        <div class="form-row">
                            <label class="form-label" for="c_code">顧客コード（数字10桁）</label>
                            <input type="text" name="c_code" id="c_code">
                        </div>

                        <div class="form-row">
                            <label class="form-label" for="c_name">顧客名</label>
                            <input type="text" name="c_name" id="c_name">
                        </div>

                        <button type="submit" class="btn btn-primary customer-submit">
                            登録
                        </button>

                    </fieldset>
                </form>

                <table class="table">
                    <tr>
                        <th>ID</th>
                        <th>顧客コード</th>
                        <th>顧客名</th>
                    </tr>
                    <?php foreach ($customers as $c): ?>
                        <tr>
                            <td><?= h($c["c_id"]) ?></td>
                            <td><?= h($c["c_code"]) ?></td>
                            <td><?= h($c["c_name"]) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

        </div>

    </main>
</body>

</html>