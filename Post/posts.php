<?php include('connection/connect.php');


global $my_id, $con, $thisName, $thisLast, $thisUser;


$content = mysqli_real_escape_string($con, $_POST['content']);
$tag = mysqli_real_escape_string($con, $_POST['tagged']);
$title = mysqli_real_escape_string($con, $_POST['title']);


if (!empty($content) && empty($_FILES["posted"]["tmp_name"])) {
    mysqli_query($con, "INSERT INTO `post` (userid,content,title,tag) VALUES ('$my_id','$content','$title','$tag') ");
    header('location:index.php');
}

$target = "assets/public/";
$target_path = $target . basename($_FILES["posted"]["name"]);
$uploadOk = 1;
$imgType = strtolower(pathinfo($target_path, PATHINFO_EXTENSION));
// set file path and change the name with user id and random number to handle duplicates
$target_path = $target . $my_id . uniqid() . "." . $imgType;

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["posted"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_path)) {
    $uploadOk = 0;
}

// Check file size
if ($_FILES["posted"]["size"] > 500000) {
    $uploadOk = 0;
}

// Allow certain file formats
if (
    $imgType != "jpg" && $imgType != "png" && $imgType != "jpeg"
    && $imgType != "gif"
) {
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["posted"]["tmp_name"], $target_path)) {
        mysqli_query($con, "INSERT INTO `post` (userid,content,title,tag,img) VALUES ('$my_id','$content','$title','$tag','$target_path') ");
        header('location:index.php');
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}



?>







<section class="container-fluid">


    <!--  create post -->
    <div class="card col-md-9 col-auto mt-5 gedf-card">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Post</button>
            </li>
        </ul>


        <div class="tab-content" id="myTabContent">
            <!-- first tab -->
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <div class="form-group">
                    <form action="" method="post" id="post" name="post" enctype="multipart/form-data">
                        <div class="m-3">
                            <input type="text" class="form-control" required id="title" name="title" placeholder="Capture the Audience with a Title!">
                        </div>
                        <div class="m-3">
                            <input class="form-control" list="data" name="tagged" id="taglist" autocomplete="off" placeholder="#Tags">
                            <datalist id="data">
                                <option value="#MustSee!">
                                <option value="#TouristSpots">
                                <option value="#myThoughts">
                                <option value="#Dubai">
                                <option value="#Chicago">
                            </datalist>

                        </div>
                        <div class="m-3">
                            <textarea class="form-control" name="content" id="message" rows="3" placeholder="Create a post"></textarea>
                            <input class="form-control mt-2" type="file" name="posted" id="postimg">
                        </div>

                    </form>

                </div>
            </div>
            <!-- first tab -->

         
                <div class="py-2"></div>
           


            <!-- footer -->
            <div class="btn-toolbar justify-content-between">
                <!-- submit -->
                <div class="btn-group">
                    <button type="submit" name="post" form="post" class="btn btn-primary m-1">Share</button>
                </div>
            </div>
            <!-- footer -->

        </div>

    </div>
    <!-- end of create post -->
    <div class="scroll">


        <!-- get all user posts -->
        <?php

        $postquery = "SELECT * from post JOIN info on info.id = post.userid JOIN profimg on profimg.userid = post.userid ORDER BY `post`.`time` DES";
        $result_post = mysqli_query($con, $postquery);
        function Profilepics()
        {
            global  $profile_img;
            if (file_exists($profile_img)) {
                return " 
                <div class='d-flex justify-content-center'>
                     <img src='$profile_img' class='text-center profile-pic rounded-circle m-2'>
                 </div>";
            } else {
                return  "
                <div class='d-flex justify-content-center'>
                     <img src='assets/default.jpg' class='text-center profile-pic rounded-circle m-2'>
                 </div>";
            }
        };

        while ($row = mySQLi_fetch_array($result_post)) {
            global $my_id;
            $post_tag = $row['tag'];
            $post_title = $row['title'];
            $post_content = $row['content'];
            $image = $row['img'];
            $time = $row['time'];
            $thispost = $row['postid'];
            $profile_img = $row['link'];
            $name = $row['first'];
            $last = $row['last'];
            $user = $row['username'];
            $id = $row['userid'];
            if (!empty($image)) {
                echo "
        <div class='col-md-9 col-auto card gedf-card '>
        <div class='card-header'>
            <div class='d-flex justify-content-between align-items-center'>
                <div class='d-flex justify-content-between align-items-center'>
                    <div class='mr-2'>" .
                    Profilepics() . "
                    </div>
                    <div class='ml-2'>$user
                        <div class='h7 text-muted text-capitalize'> $name $last</div>
                    </div>
                </div>
                <div>
                    <div class='dropdown'>
                        <button class='btn btn-link dropdown-toggle' type='button' id='gedf-drop1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'></button>
                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='gedf-drop1'>
                            <div class='h6 dropdown-header'>Action</div>
                            <a class='dropdown-item' href='Post/delete_post.php?id=" . rawurlencode($thispost) . "&that=" . rawurlencode($id) . "&user=" . urlencode($my_id) . "'>Delete</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class='card-body'>
            <div class='text-muted h7 mb-2'> <i class='bi bi-clock-history'></i> $time</div>
            <h5 class='card-title text-capitalize'>$post_title</h5>
            <p class='card-text'>
                $post_content
            </p>
        </div>
        <img src='$image' class='card-img-top post-img' alt='...'>
        <div class='card-footer d-flex'>
            <div>
                <a href='#' class='card-link'> <i class='bi bi-chat-heart-fill'></i></a>
              <a id='coms' class='card-link' href='comment.php?id=" . $thispost . "&user=" . urlencode($id) . " '> <i class='bi bi-chat-fill'></i></a>
            </div>
            <div class='ms-auto d-flex align-items-center'>
                <span class='text-center text-secondary'>$post_tag</span>
            </div>
        </div>
    </div>";
            } else {
                echo "
           
    <div class='col-md-9 col-auto card gedf-card'>
        <div class='card-header'>
            <div class='d-flex justify-content-between align-items-center'>
                <div class='d-flex justify-content-between align-items-center'>
                    <div class='d-flex justify-content-center'>
                        <div class='mr-2'>" .
                    Profilepics() . "
                        </div>
                    </div>
                    <div class='ml-2'>$user
                        <div class='h7 text-muted text-capitalize'>$name $last</div>
                    </div>
                </div>
                <div>
                    <div class='dropdown z-3'>
                       <button class='btn btn-link dropdown-toggle' type='button' id='gedf-drop' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'></button>
                        </button>
                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='gedf-drop'>
                             <div class='h6 dropdown-header'>Action</div>
                            <a class='dropdown-item' href='Post/delete_post.php?id=" . rawurlencode($thispost) . "&that=" . rawurlencode($id) . "&user=" . urlencode($my_id) . "'>Delete</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class='card-body'>
            <div class='text-muted h7 mb-2'> <i class='bi bi-clock-history'></i> $time</div>
            <h5 class='card-title text-capitalize'>$post_title</h5>

            <p class='card-text'>
                $post_content
            </p>
        </div>
        <div class='card-footer d-flex'>
            <div>
                <a href='#' class='card-link'> <i class='bi bi-chat-heart-fill'></i></a>
                <a id='coms' class='card-link' href='comment.php?id=" . $thispost . "'> <i class='bi bi-chat-fill'></i></a>
            </div>
            <div class='ms-auto d-flex align-items-center'>
                <span class='text-center text-secondary'>$post_tag</span>
                    </div>
                </div>
            </div>";
            }
        }


        ?>

        <div class="col-md-9 col-auto card gedf-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mr-2">
                            <img src="assets/light.png" class="rounded-circle profile-pic" alt="" srcset="">
                        </div>
                        <div class="ml-2">
                            Tourista
                            <div class="h7 text-muted text-capitalize">Tourista</div>
                        </div>
                    </div>
                    <div>
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                <div class="h6 dropdown-header">Configuration</div>
                                <a class="dropdown-item" href="#">Save</a>
                                <a class="dropdown-item" href="#">Hide</a>
                                <a class="dropdown-item" href="#">Report</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-body">
                <div class="text-muted h7 mb-2"> <i class="bi bi-clock-history"></i> Forever</div>
                <h5 class="card-title text-body-primary">Welcome to Tourista</h5>


                <p class="card-text">
                    Make a post and join your fellow travelers around the globe!
                </p>
            </div>
            <img src="https://source.unsplash.com/random?beach" class="card-img-top post-img" alt="...">
            <div class="card-footer d-flex">
                <div>
                    <a href="#" class="card-link"> <i class="bi bi-chat-heart-fill"></i></a>
                    <a href="#" class="card-link" data-bs-toggle="modal" data-bs-target="#comment"> <i class="bi bi-chat-fill"></i></a>
                </div>
                <div class="ms-auto d-flex align-items-center">
                    <span class="text-center text-secondary">#Tourista</span>
                </div>
            </div>
        </div>



    </div>



</section>