<?php
setcookie("Username", "", -1, '/');
echo "登出成功！即将返回登录界面";
echo "
<script>
    setTimeout(function(){window.location.href='./login.php';},1000);
</script>";
