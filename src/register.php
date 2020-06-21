
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>register</title>
    <link rel="stylesheet" href="./css/css_reset.css" type="text/css">
    <link rel="stylesheet" href="./css/register.css" type="text/css">
</head>

<body>
    <div class="login">
        <!-- logo栏 -->
        <img class="logoimg" src="../images/icon/logo_cat.png" alt="">
        <p class="slogan">Sign up for <span style="color: #4285f4;">C</span><span style="color: #ea4335;">a</span><span
                style="color: #fbbc05;">t</span><span style="color: #4285f4">c</span><span
                style="color: #34a853;">h</span><span style="color: #ea4335;">e</span><span
                style="color: #fbbc05;">r</span></p>
        <!-- 输入栏 -->
        <div class="formbox">
            <form action="checkreg.php" method="POST" class="form form_reg" name="form_reg">
                <p>Username:</p>
                <input type="text" name="Username" id="Username" required>
                <p>E-mail:</p>
                <input type="email" name="email" id="email" required>
                <p>Password:</p>
                <input type="password" name="pword1" id="pword1" required>
                <p>Confirm Your Password:</p>
                <input type="password" name="pword2" id="pword2" required>
             <input type="submit" name="button" value="Sign up" class="button"
                    style="
                     margin-top: 20px;
         border: 1px solid #808080;
    border-radius: 3px;
    height: 34px;
    width: 310px;
    font-size: 16px;
    font-weight: bolder;
    background-color:#6bcf59 ;
"
                    onclick="return check();"
             >
            </form>
        </div>
    </div>
    <!-- 页脚 -->
    <footer>
        <div class="comtainer footer-in">
            <div class="footer-l">
                <dl>
                    <dt><a href="http://www.baidu.com">使用条款</a></dt>
                    <dt><a href="http://www.baidu.com">隐私保护</a></dt>
                    <dt><a href="http://www.baidu.com">cookie</a></dt>
                </dl>
                <dl>
                    <dt><a href="http://www.baidu.com">关于</a></dt>
                    <dt><a href="http://www.baidu.com">联系我们</a></dt>
                </dl>

                <dl class="image">
                    <dt class="img"><img src="../images/icon/wechat.png" alt="微信">

                    </dt>
                    <dt class="img">
                        <img src="../images/icon/qq.png" alt="QQ">
                    </dt>
                </dl>
                <dl class="image">
                    <dt class="img"><img src="../images/icon/qq2.png" alt="微信">

                    </dt>
                    <dt class="img">
                        <img src="../images/icon/github.png" alt="github">
                    </dt>
                </dl>
            </div>
            <div class="footer-r">
                <img src="../images/icon/QRcode.png" alt="二维码">
            </div>

        </div>
        <div class="clear"></div>

        <div class="Copyright">
            <p class="Copyright">Copyright © 2019-2021 Web fundamental. All Rights Reserved. 备案号：luyongyong0001 </p>
        </div>

    </footer>


    <script src="js/jquery-3.3.1.min.js"></script>

    <script type="text/javascript">

        function check() {
            // 检查用户名
            if(document.form_reg.Username.value=="")
            {
                alert("请输入用户名");
                document.form_reg.Username.focus();
                return false;
            }
            var uname = document.form_reg.Username.value;
            var b=/^.*(?=.{4,16})(?=.*\d)(?=.*[A-Za-z]).*$/;
            if(!(b.test(uname))){
                alert("用户名格式错误！请输入4-16位由数字，字母组成的名称！");
                document.getElementById("Username").value="";
                document.form_reg.Username.focus();
                return false;
            }
//邮箱
            if(document.form_reg.email.value=="")
            {
                alert("请输入邮箱");
                document.form_reg.email.focus();
                return false;
            }
            var uemail = document.form_reg.email.value;
            var c=/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
            if(!(c.test(uemail))){
                alert("邮箱格式错误！");
                document.getElementById("email").value="";
                document.form_reg.email.focus();
                return false;
            }
            // 检查密码
            if(document.form_reg.pword1.value=="")
            {
                alert("请输入密码");
                document.form_reg.pword1.focus();
                return false;
            }
            var upword1 = document.form_reg.pword1.value;
            var a=/^.*(?=.{6,16})(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*$/;    //6-16位 数字大小写字母
            if(!(a.test(upword1))){
                alert("密码格式错误！请输入6-16位由数字，大写字母，小写字母组成的密码！");
                document.getElementById("pword1").value="";
                document.form_reg.pword1.focus();
                return false;
            }
// 检查确认密码
            if(document.form_reg.pword2.value=="")
            {
                alert("请确认密码");
                document.form_reg.pword2.focus();
                return false;
            }

            if(document.form_reg.pword1.value!=document.form_reg.pword2.value)
            {
                alert("密码不一致，请重试");

                document.getElementById("pword2").value="";
                document.form_reg.pword2.focus();

                return false;
            }




        }

    </script>


</body>

</html>