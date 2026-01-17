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
    <link rel="stylesheet" href="./assets/css/login.css">
    <link rel="stylesheet" href="./assets/css/responsive.css">
</head>

<body class="page-login">
    <header class="app-header">
        <h1 class="header-title">Simple Deal Manager</h1>
    </header>

    <main class="main-wrapper single-column">
        <div class="col col-single">

            <div class="col-header">
                <h2>ユーザー認証</h2>
            </div>

            <div class="col-content">

                <form action="login_action.php" method="post">
                    <fieldset>
                        <div class="form-row">
                            <label class="form-label" for="u_login_id">ID</label>
                            <input type="text" name="u_login_id" id="u_login_id">
                        </div>

                        <div class="form-row">
                            <label class="form-label" for="u_login_pw">PW</label>
                            <input type="password" name="u_login_pw" id="u_login_pw">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>
                    </fieldset>
                </form>

            </div>

        </div>
    </main>

</body>

</html>