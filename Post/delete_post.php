<?php

include('../connection/connect.php');


// $get_id = $_GET['id'];
// sending query
// mysqli_query($con, "DELETE FROM `post` WHERE postid = '$get_id'");
// header("Location: ../index.php");

$get_id = ($_GET['id']);
$that = ($_GET['that']);
$get_user = ($_GET['user']);

if ($that == $get_user) {
    // sending query
    mysqli_query($con, "DELETE FROM `post` WHERE postid = '$get_id'");
    header("Location: ../index.php");
} else {
    header("Location: ../index.php");
    $message[] = "not user";
}
