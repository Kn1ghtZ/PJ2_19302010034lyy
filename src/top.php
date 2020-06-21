<?php
require_once dirname(dirname(__FILE__)).'/config.php';
session_start();

error_reporting(5);
if(isset($_GET['delete'])){
    unset($_SESSION['uname']);
    header("location: http://localhost/project2/src/login.php"); }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/css_reset.css" type="text/css">
    <link rel="stylesheet" href="./css/top.css" type="text/css">

</head>

<body>
<!-- 页面头部 -->
<header>
    <nav>
        <!-- logo -->
        <div class="logo">
            <img src="../images/icon/nav_logo.png" alt="logo">
        </div>
        <!-- 导航栏 -->
        <div class="navbar">
            <ul>
                <li class="home_nav"><a href="../index.php">Home</a></li>
                <li class="browser_nav"><a href="./browserpage.php">Browse</a></li>
                <li class="search_nav"><a href="./searchpage.php">Search</a></li>
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
                        <li><a href="upload.php"><img src="../images/icon/upload.gif">Upload</a></li>
                        <li><a href="myPhoto.php"><img src="../images/icon/picture.png">My photo</a></li>
                        <li><a href="myfavor.php"><img src="../images/icon/favor.png">My favor</a></li>
                        <li><a href="http://localhost/project2/src/top.php?delete=1"><img src="../images/icon/login.png"> Log out</a></li>
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
        <div class="personal">
            <ul>
                <li>
                    <a href="http://localhost/project2/src/login.php">Login in  ◀</a>
                </li>
            </ul>
        </div>
<?php } ?>
    </nav>

</header>
</body>

</html>
　