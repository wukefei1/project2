<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/register.css">
    <title>register</title>
    <script src="js/register.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/common.js"></script>
</head>

<body>
    <div class='box'>
        <section>
            <img src="../img/common/default.png" width="80" height="80">
            <div>———注册———</div>
            <form name="register" action="./register_judge.php" method="POST">
                <label>
                    <p>请设置用户名</p>
                    <input class="normal" type="text" name="username" id="username" placeholder="4-16位字符" autocomplete="off" pattern="^[a-zA-Z0-9_-.]{4,16}$"
                        required><br>
                </label>
                <br>
                <label>
                    <p>请设置邮箱</p>
                    <input class="normal" type="text" name="email" id="email" placeholder="" autocomplete="off" pattern="^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*(\.\w{2,})+$"
                        required><br>
                </label>
                <br>
                <label>
                    <p>请设置密码</p>
                    <input class="normal" type="password" name="pw1" id="pw1" placeholder="6-20位数字、字母"
                        pattern="^[[a-zA-z0-9]{6,20}" required><br>
                </label>
                <br>
                <label>
                    <p>请确认密码</p>
                    <input class="normal" type="password" name="pw2" id="pw2" placeholder="6-20位数字、字母"
                        pattern="^[[a-zA-z0-9]{6,20}" required><br>
                </label>
                <br>
                <input type="submit" value="注册" name="submit" style="height: 40px;">
            </form>
            <small>已有账户？<a href="login.php">点击这里登录</a></small>
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


    InvalidInputHelper(document.getElementById("email"), {
        defaultText: "请输入邮箱地址！",
        emptyText: "请输入邮箱地址！",
        invalidText: function(input) {
            return '这个邮箱地址"' + input.value + '"是不合法的！';
        }
    });

    InvalidInputHelper(document.getElementById("username"), {
        defaultText: "请输入用户名！",
        emptyText: "请输入用户名！",
        invalidText: function(input) {
            return '这个用户名"' + input.value + '"是不合法的或已被注册！';
        }
    });

    InvalidInputHelper(document.getElementById("pw1"), {
        defaultText: "请输入密码！",
        emptyText: "请输入密码！",
        invalidText: function(input) {
            return "不合法的密码！";
        }
    });

    InvalidInputHelper(document.getElementById("pw2"), {
        defaultText: "请再次输入密码！",
        emptyText: "请再次输入密码！",
        invalidText: function(input) {
            return "不合法的密码！";
        }
    });
</script>

</html>