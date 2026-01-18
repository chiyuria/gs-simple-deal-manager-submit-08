<header class="app-header">
  <h1 class="header-title">Simple Deal Manager</h1>

  <nav class="header-nav">
    <?php if (($_SESSION["u_role_flg"] ?? 0) === 1): ?>
      <button class="btn btn-ghost" onclick="location.href='customers_list.php'">
        顧客管理
      </button>
      <button class="btn btn-ghost" onclick="location.href='admin_users.php'">
        ユーザー管理
      </button>
    <?php endif; ?>
  </nav>

  <form action="logout_action.php" method="post" class="header-actions">
    <button type="submit" class="btn btn-ghost">Logout</button>
  </form>
  
</header>
