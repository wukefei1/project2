<?php
include("connect.php"); //连接数据库
date_default_timezone_set("PRC");

$email = stripslashes(trim($_POST['email']));
$username = stripslashes(trim($_POST['username']));

$sql = "select * from traveluser where Email = '$email' and UserName = '$username'";
$query = mysqli_query($mysqli, $sql);
$num = mysqli_num_rows($query);

if ($num) {
    $row = mysqli_fetch_array($query);
    $getpasstime = time();
    $uid = $row['UID'];
    $token = md5($row['UserName'] . $row['Pass']); //组合验证码 
    $url = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset.php?email=" . $email . " &token=" . $token; //构造URL 
    $time = date('Y-m-d H:i');
    $result = sendmail($time, $email, $url);
    if ($result == 1) { //邮件发送成功 
        $msg = '系统已向您的邮箱发送了一封邮件<br/>请登录到您的邮箱及时重置您的密码！';
        //更新数据发送时间 
        mysqli_query($mysqli, "update traveluser set getpasstime = '$getpasstime' where UID='$uid'");
    } else {
        $msg = $result;
    }
    echo $msg;
} else { //该邮箱尚未注册！ 
    echo '该邮箱或用户名尚未注册！';
    echo "
<script>
    setTimeout(function(){location='javascript:history.back()';},1000);
</script>";
    exit;
}

mysqli_close($mysqli);

//发送邮件 
function sendmail($time, $email, $url)
{
    include_once("smtp.class.php");
    $smtpserver = "smtp.qq.com"; //SMTP服务器，如smtp.163.com 
    $smtpserverport = 25; //SMTP服务器端口 
    $smtpusermail = "3457447530@qq.com"; //SMTP服务器的用户邮箱 
    $smtpuser = "3457447530@qq.com"; //SMTP服务器的用户帐号 
    $smtppass = "vnlkwyuzaujgdajd"; //SMTP服务器的用户密码 
    $smtp = new Smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
    //这里面的一个true是表示使用身份验证,否则不使用身份验证. 
    $emailtype = "HTML"; //信件类型，文本:text；网页：HTML 
    $smtpemailto = $email;
    $smtpemailfrom = $smtpusermail;
    $emailsubject = "wukefei.xyz - 找回密码";
    $emailbody = "亲爱的" . $email . "：<br/>您在" . $time . "提交了找回密码请求。请在浏览器中打开下面的链接重置密码 
（链接24小时内有效）。<br/><a href='" . $url . "'target='_blank'>" . $url . "</a>";
    $rs = $smtp->sendmail($smtpemailto, $smtpemailfrom, $emailsubject, $emailbody, $emailtype);

    return $rs;
}
