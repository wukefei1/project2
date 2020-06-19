<?php
header("Content-Type: text/html; charset=utf8");

// if (!isset($_POST['submit'])) {
//     exit("错误执行");
// } //判断是否有submit操作

$name = $_POST['username']; //post获取表单里的name
$password1 = $_POST['pw1']; //post获取表单里的password
$password2 = $_POST['pw2'];
$salt = base64_encode(random_bytes(32));
$password = sha1($password1 . $salt);
$email = $_POST['email'];

include('connect.php'); //链接数据库
$sql = "select UserName from traveluser where UserName='$name' or Email='$email'";
$result = mysqli_query($mysqli, $sql);
$rows = mysqli_num_rows($result);

if ($rows > 0) {
    echo "<script type='text/javascript'>alert('用户名或邮箱已存在！');location='javascript:history.back()';</script>";
    exit;
} else if ($password1 != $password2) {
    echo "<script type='text/javascript'>alert('两次输入的密码不一致！');location='javascript:history.back()';</script>";
    exit;
} else {
    $q = "insert into traveluser(UserName,Pass,Email,salt,State) values ('$name','$password','$email','$salt',1)"; //向数据库插入表单传来的值的sql
    $result = mysqli_query($mysqli, $q); //执行sql

    if (!$result) {
        die('Error: ' . mysqli_error($mysqli)); //如果sql执行失败输出错误
    } else {
        echo "<script type='text/javascript'>alert('注册成功！即将跳往登录界面');</script>"; //成功输出注册成功
        header("refresh:0;url=./login.php"); //如果成功跳转至login.html页面
        exit;
    }
}



mysqli_close($mysqli);//关闭数据库
