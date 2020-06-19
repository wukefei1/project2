<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/login.css">
    <title>reset_password</title>
    <script src="js/jquery.js"></script>
    <script src="js/common.js"></script>
</head>

<body>
    <div class='box'>
        <section>
            <img src="../img/common/default.png" width="80" height="80">
            <div>——修改密码——</div>
            <form name="find_password" action="./reset_password_judge.php" method="POST" onsubmit="">
                <label>
                    <p>请输入修改后的密码</p>
                    <input class="normal" type="password" name="pw1" id="pw1" placeholder="6-20位数字、字母"
                        pattern="^[[a-zA-z0-9]{6,20}" required><br>
                </label>
                <br>
                <label>
                    <p>请确认修改后的密码</p>
                    <input class="normal" type="password" name="pw2" id="pw2" placeholder="6-20位数字、字母"
                        pattern="^[[a-zA-z0-9]{6,20}" required><br>
                </label>
                <br>
                <input type="submit" value="确定" name="submit" id="submit" style="height: 40px;">
            </form>
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