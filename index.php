<?php
require_once 'config.php';
session_start();

error_reporting(5);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/css_reset.css" type="text/css">
    <link rel="stylesheet" href="src/css/home_page.css" type="text/css">
    <link rel="stylesheet" href="src/css/wrap.css" type="text/css">
    <link rel="stylesheet" href="src/css/top.css" type="text/css">


    <title>index</title>
    <script type="text/javascript" src="src/js/jquery-3.3.1.min.js"></script>
</head>

<body>


<?php require_once Root_Path.'/src/showIMG.php' ?>

<header>
    <nav>
        <!-- logo -->
        <div class="logo">
            <img src="images/icon/nav_logo.png" alt="logo">
        </div>
        <!-- 导航栏 -->
        <div class="navbar">
            <ul>
                <li class="home_nav"><a href="index.php">Home</a></li>
                <li class="browser_nav"><a href="./src/browserpage.php">Browse</a></li>
                <li class="search_nav"><a href="./src/searchpage.php">Search</a></li>
            </ul>
        </div>
        <!-- 个人中心部分 -->
        <?php
        if(isset($_SESSION['uname'])){
            ?>
            <div class="remind" style="  float: left;
">
                <p style=" color: #f7f7f7;
    margin-left: 715px;
    margin-top: 21px;
    font-size: 12px;
    display: block;
    line-height: 12px;
    height: 12px;
    z-index: 99;">
                   <?php
                       echo '欢迎回来，'.$_SESSION['uname'];
                   ?>
                </p>
            </div>
            <div class="personal">
                <ul>
                    <li>
                        <a href="">My account ▼</a>
                        <ul>
                            <li><a href="src/upload.php"><img src="images/icon/upload.gif">Upload</a></li>
                            <li><a href="src/myPhoto.php"><img src="images/icon/picture.png">My photo</a></li>
                            <li><a href="src/myfavor.php"><img src="images/icon/favor.png">My favor</a></li>
                            <li><a href="http://localhost/project2/src/top.php?delete=1"><img src="images/icon/login.png"> Log out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        <?php }else{ ?>
            <div class="remind" style="  float: left;
">
                <p style=" color: #f7f7f7;
    margin-left: 785px;
    margin-top: 21px;
    font-size: 12px;
    display: block;
    line-height: 12px;
    height: 12px;
    z-index: 99;">
                    您还未登录噢
                </p>
            </div>
            <div class="personal" >
                <ul>
                    <li>
                        <a href="http://localhost/project2/src/login.php">Login in  ◀</a>
                    </li>
                </ul>
            </div>
        <?php } ?>
    </nav>

</header>




<!-- 页面头图 -->
<div class="banner" style="margin-top: 18px">
<!--    <img src="../images/homepage/fushishan1.jpg" alt="fushishan">-->

    <div class="container" >
        <div class="wrap" style="left: 0px;">
            <img src="images/homepage/swap1.jpg" alt="1">
            <img src="images/homepage/swap2.png" alt="2">
            <img src="images/homepage/swap3.png" alt="3">
            <img src="images/homepage/swap4.png" alt="4">
            <img src="images/homepage/swap5.png" alt="5">
            <img src="images/homepage/swap1.jpg" alt="1">
        </div>
        <div class="buttons">
            <span class="on">1</span>
            <span>2</span>
            <span>3</span>
            <span>4</span>
            <span>5</span>
        </div>
        <a href="javascript:" class="arrow arrow_left">&lt;</a>
        <a href="javascript:" class="arrow arrow_right">&gt;</a>
    </div>


</div>

<!-- 热门图片 -->

<div class="hotpicture clearfix" id="hotpicture">
    <ul>
        <?php
        if(isset($_GET['refresh'])){
            outputImg();
        }
        else{
            outputImgFirst();
       } ?>
    </ul>
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
                <dt class="img"><img src="images/icon/wechat.png" alt="微信">

                </dt>
                <dt class="img">
                    <img src="images/icon/qq.png" alt="QQ">
                </dt>
            </dl>
            <dl class="image">
                <dt class="img"><img src="images/icon/qq2.png" alt="微信">

                </dt>
                <dt class="img">
                    <img src="images/icon/github.png" alt="github">
                </dt>
            </dl>
        </div>
        <div class="footer-r">
            <img src="images/icon/QRcode.png" alt="二维码">
        </div>

    </div>
    <div class="clear"></div>

    <div class="Copyright">
        <p class="Copyright">Copyright © 2019-2021 Web fundamental. All Rights Reserved. 备案号：luyongyong0001 </p>
    </div>

</footer>
<div id="goToTop"><a href="javascript:void(0)"><img id="upward" src="images/icon/upward.png" alt=""></a></div>
<div id="refresh"><a href="javascript:void(0)" onclick="getUrl('refresh=1')"><img  id="refreshPic" src="images/icon/restore.png"
                                  alt=""></a></div>
<?php
if ($_GET['refresh']==1){
    echo '<script>window.onload=function() {
     
     document.getElementById("hotpicture").scrollIntoView();
    }</script>';
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#goToTop a').click(function () {
            $('html,body').animate({ scrollTop: 0 }, 'slow');
        });
    });

        // $('#goToTop a').click(function () {
        //      $('html,body').animate({ scrollTop: 0 }, 'slow');
        //  });


</script>
<script type="text/javascript">

    var leftArrow = document.querySelector('.arrow_left');
    var rightArrow = document.querySelector('.arrow_right');
    var currentNum = 0;
    var circle = 0;
    var spot = document.querySelectorAll('.buttons>span');
    var wrap = document.querySelector('.wrap');
    leftArrow.addEventListener('click', function () {
        if (currentNum == 0) {
            currentNum = wrap.children.length - 1;
            wrap.style.left = -currentNum * 1200 + 'px';
        }
        currentNum--;
        animate(wrap, -1200 * currentNum);

        circle--;
        if (circle < 0) {
            circle = 4;
        }
        for (var i = 0; i < spot.length; i++) {
            spot[i].className = '';
        }
        spot[circle].className = 'on';
    })

    rightArrow.addEventListener('click', function () {
        if (currentNum == wrap.children.length - 1) {
            currentNum = 0;
            wrap.style.left = 0;
        }
        currentNum++;
        animate(wrap, -1200 * currentNum);

        circle++;
        if (circle == 5) {
            circle = 0;
        }
        for (var i = 0; i < spot.length; i++) {
            spot[i].className = '';
        }
        spot[circle].className = 'on';
    })

    function animate(obj, target) {
        clearInterval(obj.timer);
        obj.timer = setInterval(function () {
            var step = (target - obj.offsetLeft) / 10;
            step = step > 0 ? Math.ceil(step) : Math.floor(step);
            if (obj.offsetLeft == target) {
                clearInterval(obj.timer);
            }
            obj.style.left = obj.offsetLeft + step + 'px';
        }, 30);
    }
    var swapTimer = setInterval(function () {
        rightArrow.click();
    }, 4000)

    var container = document.querySelector('.container');
    container.addEventListener('mouseenter', function () {
        clearInterval(swapTimer);
        swapTimer = null;
    })
    container.addEventListener('mouseleave', function () {
        swapTimer = setInterval(function () {
            rightArrow.click();
        }, 4000)
    })


    for (var i = 0; i < spot.length; i++) {
        spot[i].setAttribute('index', i);
        spot[i].addEventListener('click', function () {
            for (var l = 0; l < spot.length; l++) {
                spot[l].className = '';
            }
            this.className = 'on';
            var index = this.getAttribute('index');
            currentNum = index;
            circle = index;
            animate(wrap, -1200 * index);
        })
    }
</script>
<script>                                          //跳转地址
    function getUrl(target) {
        var a=window.location.href;
        if(a.indexOf("?") != -1){
            a = a.split("?")[0];
        }
        var s =a + '?' + target;
        window.location.href=s;
    }


</script>
</body>

</html>
