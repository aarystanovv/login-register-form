<?php
include "Utils/Util.php";
include "Database.php";
include "Models/User.php";
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    Util::redirect("login.php", "error", "Please log in first");
}

$db = new Database();
$db_conn = $db->connect();
$user = new User($db_conn);
$users = $user->getAllUsers();

?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="css/list_users.css">
</head>
<body>
    <h2>User List</h2>
    <table>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?= $user['user_id'] ?></td>
                <td><?= $user['user_name'] ?></td>
                <td><?= $user['user_email'] ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $user['user_id'] ?>">Edit</a>
                    <a href="delete_user.php?id=<?= $user['user_id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <div class="back_wrapper">
        <a href="index.php" class="back">Back</a>
    </div>
</body>
</html>
