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
$customers = $stmtCustomers->fetchAll();

$c_id = $_GET["c_id"] ?? "";

if ($c_id === "") {
    $sql = "
        SELECT 
            d.d_id,
            d.d_code, 
            d.d_name, 
            d.d_sales, 
            c.c_code, 
            c.c_name 
        FROM deal_master d 
        JOIN customer_master c 
            ON d.c_id = c.c_id 
        ORDER BY d.d_id ASC
    ";
    $stmt = $pdo->query($sql);
} else {
    $sql = "
        SELECT 
            d.d_id,
            d.d_code, 
            d.d_name, 
            d.d_sales, 
            c.c_code, 
            c.c_name 
        FROM deal_master d 
        JOIN customer_master c 
            ON d.c_id = c.c_id 
        WHERE d.c_id = :c_id
        ORDER BY d.d_id ASC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindvalue(":c_id", $c_id, PDO::PARAM_INT);
    $stmt->execute();
}
$deals = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <h2>案件管理</h2>
                <div class="col-header-buttons">
                    <button class="btn btn-ghost" onclick="location.href='sales_chart.php'">
                        顧客別売上
                    </button>
                </div>
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
                <form action="deal_create_action.php" method="post">
                    <fieldset>
                        <legend class="form-legend">案件登録</legend>
                        <div class="deal-form">
                            <div class="form-row">
                                <label class="form-label" for="c_id">顧客名</label>
                                <select name="c_id" id="c_id">
                                    <option value="">--- SELECT CUSTOMER ---</option>
                                    <?php foreach ($customers as $c): ?>
                                        <option value="<?= h($c["c_id"]) ?>">
                                            <?= h($c["c_code"]) ?>｜<?= h($c["c_name"]) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-row">
                                <label class="form-label" for="d_code">案件コード</label>
                                <input type="text" name="d_code" id="d_code">
                            </div>

                            <div class="form-row">
                                <label class="form-label" for="d_name">案件名</label>
                                <input type="text" name="d_name" id="d_name">
                            </div>

                            <div class="form-row">
                                <label class="form-label" for="d_sales">売上</label>
                                <input type="text" name="d_sales" id="d_sales">
                            </div>
                            <button type="submit" class="btn btn-primary deal-submit">
                                登録
                            </button>
                        </div>
                    </fieldset>
                </form>


                <!-- filter -->
                <form method="get">
                    <fieldset>
                        <legend class="form-legend">フィルター検索</legend>

                        <div class="form-row filter-form">
                            <div class="form-row">
                                <label class="form-label" for="filter_c_id">顧客名</label>
                                <select name="c_id" id="filter_c_id">
                                    <option value="">--- ALL ---</option>
                                    <?php foreach ($customers as $c): ?>
                                        <option value="<?= $c["c_id"] ?>"
                                            <?= ($_GET["c_id"] ?? "") === $c["c_id"] ? "selected" : "" ?>>
                                            <?= h($c["c_name"]) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary filter-submit">
                                実行
                            </button>

                        </div>
                    </fieldset>
                </form>


                <!-- list -->
                <form action="deal_delete_action.php" method="post" class="deal-list-form">
                    <div class="table-wrap">
                        <table class="table deal-table">
                            <thead>
                                <tr>
                                    <th>案件コード</th>
                                    <th>顧客名</th>
                                    <th>案件名</th>
                                    <th>売上</th>
                                    <th>編集</th>
                                    <th>削除</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($deals as $d): ?>
                                    <tr>
                                        <td><?= h($d["d_code"]) ?></td>
                                        <td><?= h($d["c_name"]) ?></td>
                                        <td><?= h($d["d_name"]) ?></td>
                                        <td><?= number_format($d["d_sales"]) ?></td>
                                        <td>
                                            <a class="btn btn-ghost btn-table btn-table--icon" href="deal_edit.php?d_id=<?= h($d["d_id"]) ?>">
                                                📝
                                            </a>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="d_ids[]" value="<?= h($d["d_id"]) ?>">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="deal-form-actions">
                        <button type="submit" class="btn btn-danger">
                            選択した案件を削除
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </main>
</body>

</html>