<?php
require dirname(dirname(__FILE__)).'/config.php';
session_start();

error_reporting(5);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/css_reset.css" type="text/css">


    <title>details</title>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>

        </head>
<body>

<?php require "top.php" ?>
<link rel="stylesheet" href="./css/details.css" type="text/css">
<?php require "showIMG.php"; ?>

<?php
$config=mysqli_connect(HOST,USER,PWD,NAME)or die("数据库平台连接错误，错误的类型是：".mysqli_error());
$queryUser='SELECT * FROM traveluser WHERE UserName="'.$_SESSION['uname'].'"';
$resultUser=mysqli_query($config,$queryUser);
$rowUser = mysqli_fetch_assoc($resultUser);
$favorPath=$rowUser['favor'];
if ($_GET['befavor']==1){

    if (strpos($favorPath,$_GET['img'])==false){
        $favorPath = $favorPath.'^&'.$_GET['img'];
        $queryChangePath='UPDATE traveluser SET favor ="'.$favorPath.'" WHERE UserName="'.$_SESSION['uname'].'"';
        $resultChangePath=mysqli_query($config,$queryChangePath);

        $query='SELECT * FROM travelimage WHERE PATH = "'.$_GET['img'].'"' ;
        $result=mysqli_query($config,$query);
        $row=mysqli_fetch_assoc($result);
        $favor=$row['favorNum'];
        $NewFavor = $favor+1;
        $queryNewFavor = 'UPDATE travelimage SET favorNum= '.$NewFavor.' WHERE PATH="'.$_GET['img'].'"';
        $resultNewFavor=mysqli_query($config,$queryNewFavor);

        echo "<script>alert('图片已收藏！');</script>";
    }
}
if ($_GET['cancel']==1){
    if (strpos($favorPath,$_GET['img'])!==false){

    $changePath='^&'.$_GET['img'];
    $favorPath=str_replace($changePath,"",$favorPath);
    $queryChangePath='UPDATE traveluser SET favor ="'.$favorPath.'" WHERE UserName="'.$_SESSION['uname'].'"';
    $resultChangePath=mysqli_query($config,$queryChangePath);

        $query='SELECT * FROM travelimage WHERE PATH = "'.$_GET['img'].'"' ;
        $result=mysqli_query($config,$query);
        $row=mysqli_fetch_assoc($result);
        $favor=$row['favorNum'];
        $NewFavor = $favor-1;
        $queryNewFavor = 'UPDATE travelimage SET favorNum= '.$NewFavor.' WHERE PATH="'.$_GET['img'].'"';
        $resultNewFavor=mysqli_query($config,$queryNewFavor);

        echo "<script>alert('图片已取消收藏！');</script>";
   }
}

$query='SELECT * FROM travelimage WHERE PATH = "'.$_GET['img'].'"' ;
$result=mysqli_query($config,$query);
$row=mysqli_fetch_assoc($result);
$Title=$row['Title'];
$Des=$row['Description'];
$Citycode=$row['CityCode'];
$CountryCode=$row['CountryCodeISO'];
$UID=$row['UID'];
$Content=$row['Content'];
$favor=$row['favorNum'];


$queryCountry='SELECT * FROM geocountries WHERE ISO = "'.$CountryCode.'"' ;
$resultCountry = mysqli_query($config,$queryCountry);
$rowCountry=mysqli_fetch_assoc($resultCountry);
$country=$rowCountry['CountryName'];


$queryCity='SELECT * FROM geocities WHERE GeoNameID = "'.$Citycode.'"' ;
$resultCity = mysqli_query($config,$queryCity);
while ($rowCity=mysqli_fetch_assoc($resultCity)){
    if ($rowCity['CountryCodeISO'] == $CountryCode){
        $city = $rowCity['AsciiName'];
    }
}

$queryName='SELECT * FROM traveluser WHERE UID="'.$UID.'"';
$resultName=mysqli_query($config,$queryName);
$rowName = mysqli_fetch_assoc($resultName);
$Name = $rowName['UserName'];

?>

<div class="container">
    <h4>
        Details
    </h4>
    <div class="title">
        <h1>
            <?php
            echo $Title;
            echo '<span>By  '.$Name.'</span>';
            ?>

        </h1>

    </div>
    <div class="picShow clearfix">
        <div class="leftImg">
            <?php
            echo '<img src="../images/travel-images/normal/small/' .$_GET['img'] .'">'
            ?>

        </div>
        <div class="rightForm">
            <div class="likeNum">
                <h4>
                    Like Number
                </h4>
                <p class="Num">
                    <?php
                    echo $favor;
                    ?>
                </p>
            </div>
            <div class="imgDetails">
                <h4>
                    Image Details
                </h4>
                <p class="Details">Content:      <span style="margin-left: 151px;color: #667ac6;"><?php
                        echo $Content;
                        ?></span> </p>
                <p class="Details">Country:<span style="color: #667ac6;margin-left: 151px;"> <?php
                        echo $country;
                        ?></span></p>
                <p class="Details">City:<span style="color: #667ac6;margin-left: 184px;"> <?php
                        echo $city;
                        ?></span></p>
            </div>
            <a href="javascript:void(0)">
                <?php
                if ($_SESSION['uname']!=''){
                    if (strpos($favorPath,$_GET['img'])!==false||$_GET['befavor']){
                        echo '<input style="background-color:#d7c0c0" type="button" name="" id="bt" value="❤ 取消收藏" onclick=getUrl("cancel=1");>'; //已收藏
                    }else{
                        echo '<input type="button" name="" id="bt" value="❤ 收藏" onclick=getUrl("befavor=1");>'; //未收藏
                    }
                }else{
                    echo '<input type="button" name="" id="bt" value="❤ 收藏" onclick=alert("登陆就可以收藏啦");>'; //未收藏
                }

                ?>

            </a>

        </div>
    </div>
    <div class="description">
        <p>
            <?php
            echo $Des;
            ?>
        </p>
    </div>
</div>
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
<script>
    function getUrl(target) {

        var a=window.location.href;
        if(a.indexOf("&") != -1){                                     //有& 即有cancel 或者befavor
            var s=a.split('&')[0];

       console.log(s+'&'+target);
            window.location.href=s+'&'+target
        }else{
            var s=a+'&'+target;

            console.log(s);
            window.location.href=s;
        }

    }
</script>
</html>