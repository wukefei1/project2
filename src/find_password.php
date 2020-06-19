<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/login.css">
    <title>find_password</title>
    <script src="js/jquery.js"></script>
    <script src="js/common.js"></script>
</head>

<body>
    <div class='box'>
        <section>
            <img src="../img/common/default.png" width="80" height="80">
            <div>——找回密码——</div>
            <form name="find_password" action="./sendmail.php" method="POST" onsubmit="">
                <label>
                    <p>用户名</p>
                    <input class="normal" type="text" name="username" id="username" pattern="^[\w]{6,12}$" autocomplete="off" required><br>
                </label>
                <br>
                <label>
                    <p>注册时的邮箱</p>
                    <input class="normal" type="email" name="email" id="email" autocomplete="off" pattern="^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*(\.\w{2,})+$" required><br>
                </label>
                <br>
                <input type="submit" value="发送验证邮件" name="submit" id="submit" style="height: 40px;">
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

    $(function() {
        $("#submit").click(function() {
            var email = $("#email").val();
            var preg = /^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*(\.\w{2,})+$/; //匹配Email 
            if (email != '' && !preg.test(email)) {
                $("#submit").attr("disabled", "disabled").val('发送中..').css("cursor", "default");
                $.post("sendmail.php", {
                    email: email
                }, function(msg) {
                    if (msg == "noreg") {
                        alert("该邮箱尚未注册！");
                        $("#submit").removeAttr("disabled").val('发送验证邮件').css("cursor", "pointer");
                    } else {
                        $(".demo").html("<h3>" + msg + "</h3>");
                    }
                });
            }
        });
    })
</script>

</html>