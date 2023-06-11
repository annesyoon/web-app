<?php

include('connection/connect.php');
include('functions/functions.php');
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/light.png" type="image/x-icon">
    <title>Home</title>
    <link rel="stylesheet" href="css/common.css?<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="theme.js"></script>
</head>

<body>
    <div><?php
            include('nav.php'); ?></div>

    <div class="row py-5 px-2 profile-page mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>

        <div class="col-md-5 mx-auto"> <!-- Profile widget -->
            <div class="shadow rounded overflow-hidden">
                <div class="px-4 pt-0 pb-4 cover">
                    <img src="<?php echo HeaderImg(); ?>" class="card-img-top header-img img-fluid" alt="...">
                    <div class="media align-items-end profile-head">
                        <?php echo Image(); ?>
                        <div class="media-body mb-5">
                            <h4 class="text-capitalize text-center"><?php echo $thisName . " " . $thisLast ?></h4>
                            <p class="card-text d-flex justify-content-around">
                                <small class="text-body-secondary">Following</small>
                                <small class="text-body-secondary">Followers</small>
                            </p>
                        </div>


                    </div>
                </div>
    
                <!-- posts -->
                <div class="py-4 px-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0">All Posts</h5>
                    </div>
                    <div class="row user-posts ">
                        <?php Posts() ?>
                    </div>
                </div>
                <!-- [posts] -->

            </div>
        </div>
    </div>
</body>

</html>

<?php
function Posts()
{
    global $my_id, $con, $thisName, $thisLast, $thisUser;
    $select_query = "SELECT * from `post` where userid = $my_id";
    $result_query = mysqli_query($con, $select_query);

    while ($row = mysqli_fetch_assoc($result_query)) {
        $tag = $row['tag'];
        $title = $row['title'];
        $content = $row['content'];
        $image = $row['img'];
        $time = $row['time'];
        $postid = $row['postid'];
        if (!empty($image)) {
            echo "
             <div class='p-4 rounded shadow-sm gedf-card'>
        <div class='card-header'>
            <div class='d-flex justify-content-between align-items-center'>
                <div class='d-flex justify-content-between align-items-center'>
                    <div class='mr-2'>" .
                Image() . "
                    </div>
                    <div class='ml-2'>$thisUser
                        <div class='h7 text-muted text-capitalize'><?php echo $thisName . ' ' . $thisLast ?></div>
                    </div>
                </div>
                <div>
                    <div class='dropdown'>
                        <button class='btn btn-link dropdown-toggle' type='button' id='gedf-drop1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'></button>
                       <div class='dropdown-menu dropdown-menu-right' aria-labelledby='gedf-drop1'>
                            <div class='h6 dropdown-header'>Action</div>
                            <a class='dropdown-item' href='Post/delete_post.php?id=$postid'>Delete</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class='card-body'>
            <div class='text-muted h7 mb-2'> <i class='bi bi-clock-history'></i> $time</div>
        <h5 class='card-title'>$title</h5>
            <p class='card-text'>
               $content
            </p>
        </div>
        <img src='$image' class='card-img-top post-img' alt='...'>
        <div class='card-footer d-flex'>
            <div>
                <a href='#' class='card-link'> <i class='bi bi-chat-heart-fill'></i></a>
                <a href='#' class='card-link' data-bs-toggle='modal' data-bs-target='#comment'> <i class='bi bi-chat-fill'></i></a>
            </div>
            <div class='ms-auto d-flex align-items-center'>
                 <span class='text-center text-secondary'>$tag</span>
            </div>
        </div>
    </div>";
        } else {
            echo "
             <div class='p-4 rounded shadow-sm gedf-card'>
        <div class='card-header'>
            <div class='d-flex justify-content-between align-items-center'>
                <div class='d-flex justify-content-between align-items-center'>
                    <div class='mr-2'>" . Image() . "
                    </div>
                    <div class='ml-2'> 
                    $thisUser
                        <div class='h7 text-muted text-capitalize'> $thisName $thisLast</div>
                    </div>
                </div>
                <div>
                    <div class='dropdown'>
                       <button class='btn btn-link dropdown-toggle' type='button' id='gedf-drop1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'></button>
                        </button>
                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='gedf-drop1'>
                             <div class='h6 dropdown-header'>Action</div>
                            <a class='dropdown-item' href='Post/delete_post.php?id=$postid'>Delete</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class='card-body'>
        <div class='text-muted h7 mb-2'> <i class='bi bi-clock-history'></i> $time</div>
           <h5 class='card-title'>$title</h5>

            <p class='card-text'>
               $content
            </p>
        </div>
        <div class='card-footer d-flex'>
            <div>
                <a href='#' class='card-link'> <i class='bi bi-chat-heart-fill'></i></a>
                <a href='#' class='card-link' data-bs-toggle='modal' data-bs-target='#comment'> <i class='bi bi-chat-fill'></i></a>
            </div>
            <div class='ms-auto d-flex align-items-center'>
                <span class='text-center text-secondary'>$tag</span>
            </div>
        </div>
      

    </div>";
        }
    }
}

?>