<?php

include('connection/connect.php');
include('functions/functions.php');
session_start();

$my_id = $_SESSION['my_id'];
$there = ($_GET['id']);
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/light.png" type="image/x-icon">
    <title>Tourista</title>
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
                <li class="breadcrumb-item active" aria-current="page">Comments</li>
            </ol>
        </nav>

        <div class="col-md-5 mx-auto">

            <div class="py-4 px-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0">All Posts</h5>
                </div>


                <div class="row user-posts sticky-top overflow-hidden">


                    <?php echo getPost(); ?>


                </div>


                <div class=" row comment shadow rounded overflow-hidden p-3 mb-5">
                    <form action="" method="post">
                        <div class="input-group">
                            <input type="text" name="comms" class="form-control" placeholder="Comment..." aria-label="comment here" aria-describedby="button-addon2">
                            <button class="btn btn-outline-secondary" type="submit" name="enter" id="button-addon2">Button</button>
                        </div>
                    </form>
                </div>

                <?php echo Showcom(); ?>

            </div>


        </div>

    </div>
</body>

</html>

<?php

if (isset($_POST['enter'])) {
    $post = ($_GET['id']);
    $com = mysqli_real_escape_string($con, $_POST['comms']);
    if (!empty($com)) {
        mysqli_query($con, "INSERT INTO `comments`(postid, text,userid) VALUES( '$post', '$com','$my_id') ") or die('query failed');
        header('location:index.php');
    }
} else $message = "Failed";

function getPost()
{
    global $there, $con;
    $getposts = "SELECT * from post JOIN info on info.id = post.userid JOIN profimg on profimg.userid = post.userid  WHERE postid='$there' ORDER BY `post`.`time` DESC";
    $r_post = mysqli_query($con, $getposts);
    while ($row = mySQLi_fetch_array($r_post)) {
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
    }

    if (!empty($image)) {
        echo
        " <div class='p-4 rounded shadow-sm gedf-card overflow-scroll'>
        <div class='card-header'>
            <div class='d-flex justify-content-between align-items-center'>
                  <div class='d-flex justify-content-between align-items-center'>
                    <div class='mr-2'>" . Image() . "
                    </div>
                    <div class='ml-2'> 
                    $user
                        <div class='h7 text-muted text-capitalize'> $name $last</div>
                    </div>
                </div>
                <div>
                    <div class='dropdown'>
                        <button class='btn btn-link dropdown-toggle' type='button' id='gedf-drop1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'></button>
                       <div class='dropdown-menu dropdown-menu-right' aria-labelledby='gedf-drop1'>
                            <div class='h6 dropdown-header'>Action</div>
                            <a class='dropdown-item' href='Post/delete_post.php?id=$thispost'>Delete</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class='card-body'>
            <div class='text-muted h7 mb-2'> <i class='bi bi-clock-history'></i> $time</div>
        <h5 class='card-title'>$post_title</h5>
            <p class='card-text'>
               $post_content
            </p>
        </div>
        <div class='post-img'>
    <img src='$image' class='card-img-top' alt='...'>
</div>
        <div class='card-footer d-flex'>
                       <div class='ms-auto d-flex align-items-center'>
                 <span class='text-center text-secondary'>$post_tag</span>
            </div>
        </div>
    </div>";
    } else {
        echo "
             <div class='p-4 rounded shadow-sm bg-light gedf-card'>
        <div class='card-header'>
            <div class='d-flex justify-content-between align-items-center'>
                <div class='d-flex justify-content-between align-items-center'>
                    <div class='mr-2'>" . Image() . "
                    </div>
                    <div class='ml-2'> 
                    $user
                        <div class='h7 text-muted text-capitalize'> $name $last</div>
                    </div>
                </div>
                <div>
                    <div class='dropdown'>
                       <button class='btn btn-link dropdown-toggle' type='button' id='gedf-drop1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'></button>
                        </button>
                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='gedf-drop1'>
                             <div class='h6 dropdown-header'>Action</div>
                            <a class='dropdown-item' href='Post/delete_post.php?id=$thispost'>Delete</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class='card-body'>
        <div class='text-muted h7 mb-2'> <i class='bi bi-clock-history'></i> $time</div>
           <h5 class='card-title'>$post_title</h5>

            <p class='card-text'>
               $post_content
            </p>
        </div>
        <div class='card-footer d-flex'>
                      <div class='ms-auto d-flex align-items-center'>
                <span class='text-center text-secondary'>$post_tag</span>
            </div>
        </div>
      

    </div>";
    }
}

function Showcom()
{
    global $there, $con;
    $getcom = "SELECT * FROM comments JOIN info on info.id = comments.userid LEFT JOIN post on post.postid = comments.postid WHERE post.postid='$there' ORDER BY `comments`.`time` DESC;";
    $result = mysqli_query($con, $getcom);
    while ($row = mySQLi_fetch_array($result)) {
        global $my_id;
        $text = $row['text'];
        $time = $row['time'];
        $name = $row['first'];
        $last = $row['last'];
        $user = $row['username'];

        echo "      <div class='row' mb-3>
                    <div class='p-4 rounded shadow-sm bg-light gedf-card'>
                        <div class='card-header mb-3'>
                          <div class='ml-2'> 
                    $user
                        <div class='h7 text-muted text-capitalize'> $name $last</div>
                    </div>
                        </div>
                        <hr>
                        <div class='card-body'>

                            <p class='card-text'>
                                $text
                            </p>
                        </div>
                        <div class='card-footer d-flex'>
                            <div class='ms-auto d-flex align-items-center'>
                                <span class='text-center text-secondary'>
                                    <div class='text-muted h7 mb-2'> <i class='bi bi-clock-history'></i> $time</div>
                                </span>
                            </div>
                        </div>


                    </div>
                </div>";
    }
}

?>