 <?php

    include('connection/connect.php');
    include('functions/functions.php');
    session_start();
    ?>
 <?php
    $my_id = $_SESSION['my_id'];

    global $my_id, $con, $thisUser, $thisName, $thisLast;
    // Upload The Image
    $target_dir = "assets/public/";
    $target_file = $target_dir . basename($_FILES["profilePic"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $target_file = $target_dir . "profile" . $my_id . uniqid() . "." . $imageFileType;

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["profilePic"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["profilePic"]["size"] > 500000) {
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file)) {
            $newimg = mysqli_query($con, "UPDATE `profimg` SET status= 0, link='$target_file' WHERE userid = '$my_id'") or die('query failed');
            header("location:index.php");
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    ?>




 <section class="container-fluid user-area">
     <div class="col-lg-6 col-auto m-lg-5 m-0">
         <div class="card mb-2 ">
             <img src="<?php echo HeaderImg(); ?>" class="card-img-top header-img img-fluid" alt="...">
             <div class="card-body d-flex flex-column">
                 <!-- NAME AND PCITURE -->
                 <a href="profile.php"><?php echo Image(); ?></a>
                 <h5 class="card-title text-center fw-bold">@<?php echo $thisUser; ?></h5>
                 <small class="h7 text-body-primary text-capitalize text-center"><?php echo $thisName . " " . $thisLast ?></small>
                 <p class="card-text d-flex justify-content-around">
                     <small class="text-body-secondary">Following</small>
                     <small class="text-body-secondary">Followers</small>
                 </p>
             </div>
         </div>

         <!-- tools -->
         <div class="card tools">

             <ul class="list-group list-group-flush ">
                 <!-- settings -->
                 <li class="list-group-item">
                     <a href="http" type="button" data-bs-toggle="modal" data-bs-target="#ProfilePic">
                         <i class="bi bi-image"></i> Change Image
                     </a>
                 </li>
                 <!-- second item -->
                 <li class="list-group-item">
                     <a href="http" type="button" data-bs-toggle="modal" data-bs-target="#headerPic">
                         <i class="bi bi-image"></i> Change Header Image
                     </a>
                 </li>
                 <li class="list-group-item">
                     <a href="http" type="button" data-bs-toggle="modal" data-bs-target="#changeForm">
                         <i class="bi bi-person-gear"></i> Edit profile
                     </a>
                 </li>


             </ul>

             <div class="card-footer text-body-secondary">
                 <a href="index.php?logout=<?php echo $my_id; ?>" onclick="return confirm(' are your sure you want to logout?')" ;><i class="bi me-2 opacity-50 theme-icon bi-box-arrow-left"></i>Logout</a>
             </div>
         </div>
     </div>



     <!-- EDIT USER PREFERENCE -->
     <div class="modal fade" id="ProfilePic" tabindex="-1" aria-labelledby="profilePicLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">

                 <!-- HEADER -->
                 <div class="modal-header">
                     <h1 class="modal-title fs-5" id="profilePicLabel">Customize Profile</h1>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>



                 <div class="modal-body">

                     <form method="POST" enctype="multipart/form-data">
                         <div class="mb-3 input-group body-bg-primary">
                             <input class="form-control" type="file" id="pp" name="profilePic" class="form-control form-control-sm">
                             <button type="submit" class="btn btn-primary" name="submit" value="Upload Image">Save Changes</button>
                         </div>
                     </form>

                 </div>

             </div>

         </div>

     </div>


     <div class="modal fade" id="headerPic" tabindex="-1" aria-labelledby="headerPicLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">

                 <!-- HEADER -->
                 <div class="modal-header">
                     <h1 class="modal-title fs-5" id="headerPicLabel">Customize Profile</h1>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>



                 <div class="modal-body">

                     <form method="POST" enctype="multipart/form-data">
                         <div class="mb-3 input-group body-bg-primary">
                             <input class="form-control" type="file" id="prp" name="header" class="form-control form-control-sm">
                             <button type="submit" class="btn btn-primary" name="head" value="Upload">Save Changes</button>
                         </div>
                     </form>

                 </div>

             </div>
         </div>
     </div>

     <div class="modal fade" id="changeForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <form method="post">
                         <div class="mb-3">
                             <label for="recipient-name" class="col-form-label">Change Username</label>
                             <input type="username" autocomplete=false class="form-control" name="newuname" id="newuname">
                         </div>
                         <div class="mb-3">
                             <label for="message-text" class="col-form-label">Change Password</label>
                             <input type="password" class="form-control" id="newpass" name="newpass">
                         </div>
                         <div class="mb-3">
                             <label for="message-text" class="col-form-label">Enter old password to confirm</label>
                             <input type="password" required class="form-control" id="conf" name="conf">
                         </div>
                         <input class="btn btn-primary d-block text-center my-4 mx-auto" type="submit" name="edit" value="edit">
                     </form>
                 </div>
             </div>
         </div>
     </div>
     <?php
        if (isset($_POST['edit'])) {

     
            $newuser = mysqli_real_escape_string($con, ($_POST['newuname']));
            $confirm = mysqli_real_escape_string($con, md5($_POST['conf']));


            $select = mysqli_query($con, "SELECT * FROM `info` WHERE id='$my_id'") or die('query failed');
            if (mysqli_num_rows($select) > 0) {
                $row = mysqli_fetch_assoc($select);
                $thisPass = $row['password'];
                while ($confirm === $thisPass) {
                    mysqli_query($con, "UPDATE `info` SET username='$newuser' WHERE id = '$my_id'") or die('error');
                    $message[] = 'Account registered';
                    header('location:login.php');
                }
            } else {
                $message[] = 'error';
            }
        }

        ?>

     <?php
        // Upload The Image
        $target_dir = "assets/public/";
        $target_header = $target_dir . basename($_FILES["header"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_header, PATHINFO_EXTENSION));
        $target_header = $target_dir . "profile" . $my_id . uniqid() . "." . $imageFileType;

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["header"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_header)) {
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["header"]["size"] > 500000) {
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["header"]["tmp_name"], $target_header)) {
                $newimg = mysqli_query($con, "UPDATE `profimg` SET status= 0, headlink='$target_header' WHERE userid = '$my_id'") or die('query failed');
                header("location:index.php");
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }



        ?>

 </section>