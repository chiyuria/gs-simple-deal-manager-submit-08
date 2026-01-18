<?php
require_once __DIR__ . "/inc/functions.php";

session_start();
require_admin();

require_once __DIR__ . "/config/db.php";
$pdo = db_conn();

// edit target ID
$u_id = $_GET["u_id"] ?? "";
if ($u_id === "") {
    exit("u_id is required");
}

$sqlUser = "
    SELECT u_id,
        u_name,
        u_login_id,
        u_role_flg,
        u_life_flg
    FROM user_master
    WHERE u_id = :u_id
";

$stmtUser = $pdo->prepare($sqlUser);
$stmtUser->bindValue(":u_id", $u_id, PDO::PARAM_INT);
$stmtUser->execute();
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    exit("User not found");
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
                <h2>ユーザー編集</h2>
                <button class="btn btn-ghost" onclick="location.href='admin_users.php'">
                    戻る
                </button>
            </div>

            <div class="col-content">

                <?php if (($_GET['error'] ?? '') === 'invalid'): ?>
                    <p style="color:red">Invalid request.</p>
                <?php endif; ?>

                <?php if (($_GET['error'] ?? '') === 'self'): ?>
                    <p style="color:red">You cannot update your own role/status.</p>
                <?php endif; ?>

                <?php if (($_GET['error'] ?? '') === 'fail'): ?>
                    <p style="color:red">Update failed.</p>
                <?php endif; ?>

                <form action="admin_user_update_action.php" method="post">
                    <fieldset>
                        <legend class="form-legend">ユーザー編集</legend>

                        <div class="deal-form">
                            <div class="form-row">
                                <label class="form-label">ユーザーID</label>
                                <input type="text" value="<?= h($user["u_id"]) ?>" disabled>
                            </div>

                            <div class="form-row">
                                <label class="form-label">ユーザー名</label>
                                <input type="text" value="<?= h($user["u_name"]) ?>" disabled>
                            </div>

                            <div class="form-row">
                                <label class="form-label">ログインID</label>
                                <input type="text" value="<?= h($user["u_login_id"]) ?>" disabled>
                            </div>

                            <div class="form-row">
                                <label class="form-label" for="u_role_flg">ロール</label>
                                <select name="u_role_flg" id="u_role_flg">
                                    <option value="0" <?= ((int)$user["u_role_flg"] === 0) ? "selected" : "" ?>>User</option>
                                    <option value="1" <?= ((int)$user["u_role_flg"] === 1) ? "selected" : "" ?>>Admin</option>
                                </select>
                            </div>

                            <div class="form-row">
                                <label class="form-label" for="u_life_flg">状態</label>
                                <select name="u_life_flg" id="u_life_flg">
                                    <option value="0" <?= ((int)$user["u_life_flg"] === 0) ? "selected" : "" ?>>Active</option>
                                    <option value="1" <?= ((int)$user["u_life_flg"] === 1) ? "selected" : "" ?>>Disabled</option>
                                </select>
                            </div>

                            <input type="hidden" name="u_id" value="<?= h($user["u_id"]) ?>">

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