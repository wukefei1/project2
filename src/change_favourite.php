<?php
include('connect.php');

$uid = $_GET['uid'];
$ImageID = $_GET['ImageID'];
$isFavorite = $_GET['isFavorite'];

if (!$uid) {
    echo "<script type='text/javascript'>alert('您尚未登录！');</script>";
    header("refresh:0;url=./login.php");
    exit;
}

if ($isFavorite) {
    $sql = "delete from travelimagefavor where UID='$uid' and ImageID='$ImageID'";
    $result = mysqli_query($mysqli, $sql);
    if (!$result) {
        echo "<script type='text/javascript'>alert('非法的参数！');</script>";
    } else {
        echo "<script type='text/javascript'>alert('图片已从收藏中删除！');</script>";
    }
    header("refresh:0;url=./details.php?id=$ImageID");
} else {
    $sql = "insert into travelimagefavor(UID,ImageID) values('$uid','$ImageID')";
    $result = mysqli_query($mysqli, $sql);
    if (!$result) {
        echo "<script type='text/javascript'>alert('非法的参数！');</script>";
    } else {
        echo "<script type='text/javascript'>alert('图片已收藏！');</script>";
    }
    header("refresh:0;url=./details.php?id=$ImageID");
}



mysqli_close($mysqli);
