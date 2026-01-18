<?php
require_once __DIR__ . "/inc/functions.php";

session_start();
require_admin();

require_once __DIR__ . "/config/db.php";

$pdo = db_conn();

$sqlUsers = "
    SELECT u_id,
        u_name,
        u_login_id,
        u_role_flg,
        u_life_flg
    FROM user_master
    ORDER BY u_id ASC
";

$stmtUsers = $pdo->query($sqlUsers);
$users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);
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
                <h2>ユーザー管理</h2>
                <div class="col-header-buttons">
                    <button class="btn btn-ghost" onclick="location.href='deals_list.php'">
                        案件管理
                    </button>
                </div>
            </div>

            <div class="col-content">
                <!-- list -->
                <div class="table-wrap">
                    <table class="table users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ユーザー名</th>
                                <th>ログインID</th>
                                <th>ロール</th>
                                <th>状態</th>
                                <th>編集</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><?= h($u["u_id"]) ?></td>
                                    <td><?= h($u["u_name"]) ?></td>
                                    <td><?= h($u["u_login_id"]) ?></td>
                                    <td><?= ((int)$u["u_role_flg"] === 1) ? "Admin" : "User" ?></td>
                                    <td><?= ((int)$u["u_life_flg"] === 0) ? "Active" : "Disabled" ?></td>
                                    <td>
                                        <a class="btn btn-ghost btn-table btn-table--icon"
                                            href="admin_user_edit.php?u_id=<?= h($u["u_id"]) ?>">
                                            📝
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</body>

</html>