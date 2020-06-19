<?php
include("connect.php"); //连接数据库 

$token = stripslashes(trim($_GET['token']));
$email = stripslashes(trim($_GET['email']));
$sql = "select * from traveluser where Email = '$email'";

$query = mysqli_query($mysqli, $sql);
$array = mysqli_fetch_array($query);
if ($array) {
    $mt = md5($array['UserName'] . $array['Pass']);
    if ($mt == $token) {
        if (time() - $array['getpasstime'] > 24 * 60 * 60) {
            $msg = '该链接已过期！';
        } else {
            //重置密码...
            $expiryTime = time() + 60 * 60 * 24;
            setcookie("Username_temp", $array['username'], $expiryTime, "/");
            header("refresh:0;url=./reset_password.php");
        }
    } else {
        $msg = '无效的链接';
    }
} else {
    $msg = '错误的链接！';
}
echo $msg;
mysqli_close($mysqli);//关闭数据库
