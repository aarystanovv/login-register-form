<?php
session_start();
include "Utils/Util.php";
if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])){
    include "Controller/User.php";
    $user->init($_SESSION['user_id']);
    $user_data = $user->getUser();
?>
<!doctype html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="wrapper">
    <div class="form-holder">
        <h2>Welcome <?=$user_data['full_name']?> !</h2>
        <form class="form"
              action="logout.php"
              method="GET">
            <h4>Username: <?=$user_data['user_name']?></h4>
            <h4>Email: <?=$user_data['user_email']?></h4>
            <div class="form-group">
                <button type="submit">Logout</button>
            </div>
        </form>
        <a href="list_users.php">All Users</a>
    </div>
</div>
</body>
</html>
<?php }else {
    $em = "First login";
    Util::redirect("login.php", "error", $em);
} ?>