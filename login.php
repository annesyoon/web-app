<?php

include('connection/connect.php');
session_start();

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = mysqli_real_escape_string($con, md5($_POST['password']));

    $select = mysqli_query($con, "SELECT * FROM `info` WHERE email = '$email' AND password = '$pass'") or die('query failed');


    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        $_SESSION['my_id'] = $row['id'];
        $my_id = $_SESSION['my_id'];
        header('location:index.php');
    } else {
        $message[] = 'incorrect password or email!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/light.png" type="image/x-icon">
    <title>Login | Tourista</title>
    <link rel="stylesheet" href="css/common.css?<?php echo time(); ?>">
</head>

<body data-bs-theme="light" class="signup d-flex justify-content-center align-items-center">
    <section class="d-flex justify-content-center align-items-center">
        <form action="" method="post">
            <img src="assets/login.png" alt="">
            <div class="text-start">
                <h5>JOIN YOUR FELLOW TOURISTAS FOR FREE</h5>
                <h3>CREATE A NEW ACCOUNT</h3>
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            </div>
            <div class="row">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" id="email" required autocomplete="email" type="text" class="form-control" placeholder="Email" aria-label="Email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" id="password" required autocomplete="current-password" type="password" class="form-control" placeholder="Password" aria-label="Password">
                </div>
            </div>
            <input class="btn btn-primary d-block text-center my-4 mx-auto" type="submit" name="submit" value="Login">
            <hr>
        </form>
    </section>
</body>

</html>