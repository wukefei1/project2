<?php
header("Content-Type: text/html; charset=utf8");

// if (!isset($_POST['submit'])) {
//     exit("错误执行");
// } //判断是否有submit操作
$name = $_COOKIE['Username_temp'];

$password1 = $_POST['pw1']; //post获取表单里的password
$password2 = $_POST['pw2'];
$salt = base64_encode(random_bytes(32));
$password = sha1($password1 . $salt);

include('connect.php'); //链接数据库

if ($password1 != $password2) {
    echo "<script type='text/javascript'>alert('两次输入的密码不一致！');location='javascript:history.back()';</script>";
} else {
    $q1 = "update traveluser set Pass = '$password' where UserName = '$name'";
    $result1 = mysqli_query($mysqli, $q1); //执行sql
    $q2 = "update traveluser set salt = '$salt' where UserName = '$name'";
    $result2 = mysqli_query($mysqli, $q2); //执行sql

    if (!$result1 || !$result2) {
        die('Error: ' . mysqli_error($mysqli)); //如果sql执行失败输出错误
    } else {
        setcookie("Username_temp", "", -1, "/");
        echo "<script type='text/javascript'>alert('重置密码成功！即将跳往登录界面');</script>";
        header("refresh:0;url=./login.php");
        exit;
    }
}


mysqli_close($mysqli);//关闭数据库
