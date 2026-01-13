<?php
require_once __DIR__ . "/inc/functions.php";

session_start();
require_login();

require_once __DIR__ . "/config/db.php";

$pdo = db_conn();

$sql = "
    SELECT
        c.c_name,
        COALESCE(SUM(d.d_sales), 0) AS total_sales
    FROM customer_master c
    LEFT JOIN deal_master d
        ON d.c_id = c.c_id
    GROUP BY c.c_id, c.c_name
    ORDER BY total_sales DESC;
";

// Execute SQL and receive the results as an "array" 
$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Create an array for the graph
$labels = [];
$data = [];

foreach ($rows as $r) {
    $labels[] = $r["c_name"];
    $data[] = (int)$r["total_sales"];
}

// Convert to JSON
$labels_json = json_encode($labels, JSON_UNESCAPED_UNICODE);
$data_json = json_encode($data, JSON_UNESCAPED_UNICODE);
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
    <link rel="stylesheet" href="./assets/css/chart.css">
</head>

<body>
    <?php include "./inc/header.html"; ?>

    <main class="main-wrapper single-column">
        <div class="col col-single">

            <div class="col-header">
                <h2>顧客別売上</h2>
                <button class="btn btn-ghost" onclick="location.href='deals_list.php'">
                    案件管理
                </button>
            </div>

            <div class="col-content">
                <section class="sales-chart">
                    <div class="chart-wrap">
                        <canvas id="customerSalesChart"></canvas>
                    </div>
                </section>
            </div>

        </div>
    </main>

    <!-- render chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        window.salesChartData = {
            labels: <?= $labels_json ?>,
            data: <?= $data_json ?>
        };
    </script>

    <script type="module">
        import { renderSalesChart } from "./assets/js/renderSalesChart.js";
        renderSalesChart();
    </script>

</body>

</html>