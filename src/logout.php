<?php
setcookie("Username", "", -1, '/');
echo "登出成功！即将返回首页";
echo "
<script>
    setTimeout(function(){window.location.href='./home.php';},1000);
</script>";
