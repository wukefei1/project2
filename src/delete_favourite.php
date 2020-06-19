<?php
include('connect.php');

$uid = $_GET['uid'];
$ImageID = $_GET['ImageID'];

$sql = "delete from travelimagefavor where UID='$uid' and ImageID='$ImageID'";
$result = mysqli_query($mysqli, $sql); //执行sql

if (!$result) {
    echo "<script type='text/javascript'>alert('非法的参数！');</script>";
} else {
    echo "<script type='text/javascript'>alert('图片已从收藏中删除！');</script>";
}
header("refresh:0;url=./my_favourite.php");

mysqli_close($mysqli);
