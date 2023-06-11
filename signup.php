<?php

include('connection/connect.php');

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($con, $_POST['first']);
    $lname = mysqli_real_escape_string($con, $_POST['last']);
    $uname = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = mysqli_real_escape_string($con, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($con, md5($_POST['confirmpass']));



    if ($cpass === $pass) {
        $select = mysqli_query($con, "SELECT * FROM `info` WHERE email = '$email' AND password = '$pass'") or die('query failed');

        if (mysqli_num_rows($select) > 0) {
            $message[] = 'This user exists';
        } else {
            mysqli_query($con, "INSERT INTO `info`(first,last,username,email, password) VALUES('$name','$lname','$uname', '$email', '$pass')") or die('failed');
            mysqli_query($con, "INSERT INTO `profimg`(userid,status) VALUES(@@IDENTITY,1 )") or die('err');
            $message[] = 'Account registered';
            header('location:login.php');
        }
    } else {
        $message[] = 'error';
        header('location:signup.php');
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/common.css?<?php echo time(); ?>">
</head>

<body data-bs-theme="light" class="signup d-flex flex-row justify-content-between align-items-center offset-md-5">
   
    <section class="d-flex ms-auto align-items-center">
        <form action="" method="post">
            <img src="assets/logo.png" alt="">
            <div class="text-start">
                <h5>JOIN YOUR FELLOW TOURISTAS FOR FREE</h5>
                <h3>CREATE A NEW ACCOUNT</h3>
                <p>Already have an account? <a href="login.php">Log In</a></p>
            </div>
            <!-- form -->
            <div class="row g-3">
                <div class="col-md-4 mb-3">
                    <input name="first" id="name" required autocomplete="given-name" type="text" class="form-control" placeholder="First name" aria-label="First name">
                </div>
                <div class="col-md-4 mb-3">
                    <input name="last" id="name" required autocomplete="family-name" type="text" class="form-control" placeholder="Last name" aria-label="Last name">
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-8">
                    <label for="formGroupExampleInput" class="form-label">Username</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon">@</span>
                        <input class="form-control" type="text" name="username" required autocomplete="username" placeholder="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="mb-3 col-md-8">
                    <label for="formGroupExampleInput" class="form-label">Email</label>
                    <input name="email" id="email" required autocomplete="email" type="text" class="form-control" placeholder="Email" aria-label="Email">
                </div>
                <div class="mb-3 col-md-8">
                    <label for="formGroupExampleInput" class="form-label">Password</label>
                    <input name="password" id="inputPassword4" required autocomplete="new-password" type="password" class="form-control" placeholder="Password" aria-label="Password">
                </div>
                <div class="mb-3 col-md-8">
                    <label for="formGroupExampleInput" class="form-label">Confirm Password</label>
                    <input name="confirmpass" id="password" autocomplete="new-password" required type="password" class="form-control" placeholder="Confirm Password" aria-label="Confirm Password">
                </div>

            </div>
            <input class="btn btn-primary d-block text-center col-8" type="submit" name="submit" value="Sign Up">
        </form>
    </section>
</body>

</html>