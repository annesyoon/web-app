<?php

include('connection/connect.php');

session_start();

$my_id = $_SESSION['my_id'];

if (!isset($my_id)) {
    header('location:signup.php');
};

if (isset($_GET['logout'])) {
    unset($my_id);
    session_destroy();
    header('location:login.php');
};


$select_user = mysqli_query($con, "SELECT * FROM `info` WHERE id = '$my_id'") or die('query failed');
if (mysqli_num_rows($select_user) > 0) {
    $fetch_user = mysqli_fetch_assoc($select_user);
};
$thisName = $fetch_user['first'];
$thisLast = $fetch_user['last'];
$thisUser = $fetch_user['username'];



?>



<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/light.png" type="image/x-icon">
    <title>Home</title>
    <link rel="stylesheet" href="css/common.css?<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="theme.js"></script>
</head>

<body>
    <div><?php
            include('nav.php'); ?></div>
    <section class="main d-flex">
        <!-- user profile area -->
        <div class="my-5"><?php
                            include('./User/user.php'); ?></div>

        <!-- POST SECTION -->

        <div class="my-5"><?php
                            include('./Post/posts.php'); ?></div>


    </section>
  
</body>

</html>