<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/login.css">
    <title>change_password</title>
    <script src="js/jquery.js"></script>
    <script src="js/common.js"></script>
</head>

<body>
    <div class='box'>
        <section>
            <img src="../img/common/default.png" width="80" height="80">
            <div>——修改密码——</div>
            <form name="change_password" action="./change_password_judge.php" method="POST" onsubmit="">
                <label>
                    <p>请输入用户名</p>
                    <input class="normal" type="text" name="username" id="username" pattern="^[a-zA-Z0-9_-.]{4,16}$" autocomplete="off" required><br>
                </label>
                <br>
                <label>
                    <p>请输入密码</p>
                    <input class="normal" type="password" name="password" id="password" autocomplete="off" pattern="^[[a-zA-z0-9]{6,20}" required><br>
                </label>
                <small style="right: 0px;">忘记密码了？<a href="find_password.php">点击这里找回</a></small>
                <br>
                <input type="submit" value="登录" name="submit" style="height: 40px;">
            </form>
            <small><a href="login.php">点击这里返回登录界面</a></small>
        </section>
    </div>
    <footer>
        <br><br>Copyright © 2019-2021 Web fundamental. All Rights Reserved. 备案号：19302010012
    </footer>
</body>

<script type="text/javascript">
    (function(exports) {
        function valOrFunction(val, ctx, args) {
            if (typeof val == "function") {
                return val.apply(ctx, args);
            } else {
                return val;
            }
        }

        function InvalidInputHelper(input, options) {
            input.setCustomValidity(valOrFunction(options.defaultText, window, [input]));

            function changeOrInput() {
                if (input.value == "") {
                    input.setCustomValidity(valOrFunction(options.emptyText, window, [input]));
                } else {
                    input.setCustomValidity("");
                }
            }

            function invalid() {
                if (input.value == "") {
                    input.setCustomValidity(valOrFunction(options.emptyText, window, [input]));
                } else {
                    input.setCustomValidity(valOrFunction(options.invalidText, window, [input]));
                }
            }

            input.addEventListener("change", changeOrInput);
            input.addEventListener("input", changeOrInput);
            input.addEventListener("invalid", invalid);
        }
        exports.InvalidInputHelper = InvalidInputHelper;
    })(window);


    InvalidInputHelper(document.getElementById("username"), {
        defaultText: "请输入用户名！",
        emptyText: "请输入用户名！",
        invalidText: function(input) {
            return '这个用户名"' + input.value + '"是不合法的或未被注册！';
        }
    });
    InvalidInputHelper(document.getElementById("password"), {
        defaultText: "请输入密码！",
        emptyText: "请输入密码！",
        invalidText: function(input) {
            return "不合法的密码！";
        }
    });
</script>

</html>