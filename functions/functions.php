<?php
include('./connection/connect.php');

// function getInfo()
// {
//     global $con, $my_id;
//     $select_user = mysqli_query($con, "SELECT * FROM `info` WHERE id = '$my_id'") or die('query failed');
//     if (mysqli_num_rows($select_user) > 0) {
//         $fetch_user = mysqli_fetch_assoc($select_user);
//     };
//     $_SESSION['ThisUser'] = $fetch_user['username'];
//     $ThisUser = $_SESSION['ThisUser'];
//     $_SESSION['ThisUser'] = $fetch_user['username'];
//     $ThisUser = $_SESSION['ThisUser'];
//     $_SESSION['thisName'] = $fetch_user['first'];
//     $thisName = $_SESSION['thisName'];
//     $_SESSION['thisLast'] = $fetch_user['last'];
//     $thisLast = $_SESSION['thisLast'];
// }

// connect
function Image()
{
    global $my_id, $con;

    $thisImg = mysqli_query($con, "SELECT * FROM `profimg` WHERE userid = '$my_id'");

    while ($imgrow = mysqli_fetch_assoc($thisImg)) {
        $link = $imgrow['link'];
        if ($imgrow['status'] == 0 && file_exists($link)) {

            return " <div class='d-flex justify-content-center'>
                     <img src='$link' class='text-center profile-pic rounded-circle m-2'>
                 </div>";
        } else {
            return  " <div class='d-flex justify-content-center'>
                     <img src='assets/default.jpg' class='text-center profile-pic rounded-circle m-2'>
                 </div>";
        }
    }
}

function HeaderImg()
{
    global $my_id, $con;

    $thisImg = mysqli_query($con, "SELECT * FROM `profimg` WHERE userid = '$my_id'");

    while ($imgrow = mysqli_fetch_assoc($thisImg)) {
        $headlink = $imgrow['headlink'];
        if (file_exists($headlink)) {

            return $headlink;
        } else {
            return  "https://source.unsplash.com/random?beach";
        }
    }
}

