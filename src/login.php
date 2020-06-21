<?php
require dirname(dirname(__FILE__)).'/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/css_reset.css" type="text/css">
    <link rel="stylesheet" href="css/login_page.css" type="text/css">

</head>

<body>
<div class="login">
    <!-- logo栏 -->
    <img class="logoimg" src="../images/icon/logo_cat.png" alt="logo">
    <p class="slogan">Sign in for <span style="color: #4285f4;">C</span><span style="color: #ea4335;">a</span><span
            style="color: #fbbc05;">t</span><span style="color: #4285f4">c</span><span
            style="color: #34a853;">h</span><span style="color: #ea4335;">e</span><span
            style="color: #fbbc05;">r</span> </p>
    <!-- 输入栏 -->
    <div class="formbox">
        <form action="check.php" method="POST" class="form">
            <p>Username/E-mail:</p>
            <input type="text" name="username" id="username" required>
            <p>Password:</p>
            <input type="password" name="password" id="password" required>
            <button type="submit" id="bt" style="  margin-top: 20px;
         border: 1px solid #808080;
    border-radius: 3px;
    height: 34px;
    width: 310px;
    font-size: 16px;
    font-weight: bolder;
    background-color:#6bcf59 ;" >Sign in</button>
            <!--            <input type="submit" name="button" value="Sign in" class="button">-->
<!--            <a href="./src/home_page.html"><input type="button" name="button" value="Sign in" class="button"></a>-->
        </form>
    </div>
    <!-- 注册栏 -->
    <div class="register">
        <p><span>New to Catcher? </span><a href="register.php">Create a new account?</a></p>
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
</body>

</html>
