<?php
include('connect.php');
include('ergodic.php');

$uid = $_GET['uid'];
$ImageID = $_GET['ImageID'];
$path = $_GET['path'];

$sql = "delete from travelimage where UID='$uid' and ImageID='$ImageID'";
$result = mysqli_query($mysqli, $sql); //执行sql

if (!$result) {
    echo "<script type='text/javascript'>alert('非法的参数！');</script>";
} else {
    echo "<script type='text/javascript'>alert('图片已从图片库中删除！');</script>";
}

$file = my_dir("../img/travel-images");

foreach ($file as $key => $value) {
    $temp = "../img/travel-images/" . $key . "/" . $path;
    @unlink($temp);
}

$sql = "delete from travelimagefavor where ImageID='$ImageID'";
$result = mysqli_query($mysqli, $sql); //执行sql

header("refresh:0;url=./my_photos.php");

mysqli_close($mysqli);
