<?php
require_once __DIR__ . "/inc/functions.php";

session_start();
require_login();

require_once __DIR__ . "/config/db.php";

$pdo = db_conn();

$sqlCustomers = "
    SELECT c_id, 
        c_code, 
        c_name 
    FROM customer_master 
    ORDER BY c_id ASC
";
$stmtCustomers = $pdo->query($sqlCustomers);
$customers = $stmtCustomers->fetchAll(PDO::FETCH_ASSOC);

// edit target ID
$d_id = $_GET["d_id"] ?? "";
if ($d_id === "") {
    exit("d_id is required");
}

$sqlDeal = "
    SELECT d_id,
        c_id,
        d_code,
        d_name,
        d_sales
    FROM deal_master
    WHERE d_id = :d_id
";

$stmtDeal = $pdo->prepare($sqlDeal);
$stmtDeal->bindValue(":d_id", $d_id, PDO::PARAM_INT);
$stmtDeal->execute();
$deal = $stmtDeal->fetch(PDO::FETCH_ASSOC);

if (!$deal) {
    exit("Deal not found");
}
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
    <?php include "./inc/header.php"; ?>

    <main class="main-wrapper single-column">
        <div class="col col-single">

            <div class="col-header">
                <h2>案件編集</h2>
                <button class="btn btn-ghost" onclick="location.href='deals_list.php'">
                    戻る
                </button>
            </div>

            <div class="col-content">

                <?php if (($_GET['error'] ?? '') === 'blank'): ?>
                    <p style="color:red">There are some fields left blank.</p>
                <?php endif; ?>

                <?php if (($_GET['error'] ?? '') === 'code'): ?>
                    <p style="color:red">The deal code must be 10 digits long.</p>
                <?php endif; ?>

                <?php if (($_GET['error'] ?? '') === 'duplicate'): ?>
                    <p style="color:red">Deal code already exists.</p>
                <?php endif; ?>

                <!-- register -->
                <form action="deal_update_action.php" method="post">
                    <fieldset>
                        <legend class="form-legend">案件編集</legend>
                        <div class="deal-form">
                            <div class="form-row">
                                <label class="form-label" for="c_id">顧客名</label>
                                <select name="c_id" id="c_id">

                                    <option value="">--- SELECT CUSTOMER ---</option>
                                    <?php foreach ($customers as $c): ?>
                                        <option value="<?= h($c["c_id"]) ?>"
                                            <?= ((string)$deal["c_id"] === (string)$c["c_id"]) ? "selected" : "" ?>>
                                            <?= h($c["c_code"]) ?>｜<?= h($c["c_name"]) ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <div class="form-row">
                                <label class="form-label" for="d_code">案件コード</label>
                                <input type="text" name="d_code" id="d_code" value="<?= h($deal["d_code"]) ?>">
                            </div>

                            <div class="form-row">
                                <label class="form-label" for="d_name">案件名</label>
                                <input type="text" name="d_name" id="d_name" value="<?= h($deal["d_name"]) ?>">
                            </div>

                            <div class="form-row">
                                <label class="form-label" for="d_sales">売上</label>
                                <input type="text" name="d_sales" id="d_sales" value="<?= h($deal["d_sales"]) ?>">
                            </div>

                            <input type="hidden" name="d_id" value="<?= h($deal["d_id"]) ?>">

                            <button type="submit" class="btn btn-primary deal-submit">
                                更新
                            </button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </main>
</body>

</html>