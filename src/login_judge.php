<?PHP
header("Content-Type: text/html; charset=utf8");
// if (!isset($_POST["submit"])) {
//     exit("错误执行");
// } //检测是否有submit操作 

include('connect.php'); //链接数据库
$name = $_POST['username']; //post获得用户名表单值
$password = $_POST['password']; //post获得用户密码单值

if ($name && $password) { //如果用户名和密码都不为空
    $sql = "select * from traveluser where UserName = '$name'"; //检测数据库是否有对应的username的sql
    $result = mysqli_query($mysqli, $sql); //执行sql
    $rows = mysqli_num_rows($result); //返回一个数值
    if ($rows) { //0 false 1 true
        $array = mysqli_fetch_array($result);
        if (sha1($password . $array['salt']) == $array['Pass']) {
            echo "登录成功！即将跳往首页";
            $expiryTime = time() + 60 * 60 * 24;
            setcookie("Username", $array['UID'], $expiryTime, "/");
            echo "
                <script>
                    setTimeout(function(){window.location.href='./home.php';},1000);
                </script>";
            exit;
        } else {
            echo "密码错误！";
            echo "
                <script>
                    setTimeout(function(){window.location.href='./login.php';},1000);
                </script>"; //如果错误使用js 1秒后跳转到登录页面重试，让其从新进行输入         
        }
    } else {
        echo "用户名不存在！";
        echo "
            <script>
                setTimeout(function(){window.location.href='./login.php';},1000);
            </script>"; //如果错误使用js 1秒后跳转到登录页面重试，让其从新进行输入    
    }
} else { //如果用户名或密码有空
    echo "表单填写不完整";
    echo "
        <script>
            setTimeout(function(){window.location.href='./login.php';},1000);
        </script>";
    //如果错误使用js 1秒后跳转到登录页面重试，让其从新进行输入
}

mysqli_close($mysqli); //关闭数据库
