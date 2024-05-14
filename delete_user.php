<?php

include "Utils/Util.php";
include "Database.php";
include "Models/User.php";
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    Util::redirect("login.php", "error", "Please log in first");
}

if (!isset($_GET['id'])) {
    Util::redirect("list_users.php", "error", "User ID not provided");
}

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $user_id = $_GET['id'];
    $db = new Database();
    $db_conn = $db->connect();
    $user = new User($db_conn);
    $success = $user->deleteUser($user_id);

    if ($success) {
        Util::redirect("list_users.php", "success", "User deleted successfully");
    } else {
        Util::redirect("list_users.php", "error", "Failed to delete user");
    }
}

