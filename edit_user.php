<?php
include "Utils/Util.php";
include "Utils/Validation.php";
include "Database.php";
include "Models/User.php";
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    Util::redirect("login.php", "error", "Please log in first");
}

if (!isset($_GET['id'])) {
    Util::redirect("list_users.php", "error", "User ID not provided");
}

$user_id = $_GET['id'];
$db = new Database();
$db_conn = $db->connect();
$user = new User($db_conn);
$user->init($user_id);
$user_data = $user->getUser();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = Validation::clean($_POST["username"]);
    $email = Validation::clean($_POST["email"]);

    if (!Validation::username($username)) {
        $error = "Invalid username";
    } elseif (!Validation::email($email)) {
        $error = "Invalid email";
    } else {
        $updated_user_data = array(
            "user_name" => $username,
            "user_email" => $email,
        );
        $success = $user->updateUser($updated_user_data);

        if ($success) {
            Util::redirect("list_users.php", "success", "User information updated successfully");
        } else {
            $error = "Error updating user information";
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="wrapper">
    <div class="form-holder">
        <h2>Edit User</h2>
        <?php if (isset($error)) { ?>
            <p class="error"><?= $error ?></p>
        <?php } ?>
        <form class="form" action="" method="post">
            <div class="form-group">
                <input type="text" name="username" value="<?= $user_data['user_name'] ?>" placeholder="Username">
            </div>
            <div class="form-group">
                <input type="text" name="email" value="<?= $user_data['user_email'] ?>" placeholder="Email">
            </div>
            <div class="form-group">
                <button type="submit">Update</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
