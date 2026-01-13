<?php
require_once __DIR__ . "/inc/functions.php";
session_start();

if (isset($_SESSION["chk_ssid"]) && $_SESSION["chk_ssid"] === session_id()) {
    redirect("deals_list.php");
    exit();
}

require __DIR__ . "/login.php";