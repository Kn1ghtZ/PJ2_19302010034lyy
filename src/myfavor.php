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


        <title>myfavor</title>
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    </head>
<body>
<?php
if ($_SESSION['uname']==''){

    echo '请先登录再进行操作,即将为您跳转至登录页面...';
    header("refresh:2;url=login.php");
//    print('正在加载，请稍等...<br>五秒后自动跳转。');
    exit();
}
?>
<?php require "top.php" ?>
    <link rel="stylesheet" href="./css/favor_page.css" type="text/css">
<?php require "showIMG.php"; ?>

<div class="container" style="position: relative;">
    <h4>
        My Favorite
    </h4>
    <ul>
        <?php
        $needPage = 5;
        $currentPage =1;
        $isNone=0;
        if(isset($_GET['page'])){
            $currentPage=$_GET['page'];
        }
        if ($_GET['del']!=''){
            $config=mysqli_connect(HOST,USER,PWD,NAME)or die("数据库平台连接错误，错误的类型是：".mysqli_error());
//            $queryDel='DELETE FROM travelimage WHERE PATH="'.$_GET['del'].'"';
            $queryDel='SELECT * FROM travelimage WHERE PATH="'.$_GET['del'].'"';
            $resultDel =mysqli_query($config,$queryDel);
$rowDel=mysqli_fetch_assoc($resultDel);
$favorNum=$rowDel['favorNum'];
$newfavorNum=$favorNum-1;
            $queryNewFavor = 'UPDATE travelimage SET favorNum= '.$newfavorNum.' WHERE PATH="'.$_GET['del'].'"';
            $resultNewFavor=mysqli_query($config,$queryNewFavor);

            $queryMyPath='SELECT * FROM traveluser WHERE UserName="'.$_SESSION['uname'].'"';
            $resultPath =mysqli_query($config,$queryMyPath);
            $rowPath = mysqli_fetch_assoc($resultPath);
            $Path=$rowPath['favor'];
            $changePath='^&'.$_GET['del'];
            $newPath=str_replace($changePath,"",$Path);
            $queryChangePath='UPDATE traveluser SET favor ="'.$newPath.'"WHERE traveluser.UserName="'.$_SESSION['uname'].'"';
            $resultChangePath=mysqli_query($config,$queryChangePath);
       
            echo "<script>alert('图片已移出收藏！');window.location.href='./myfavor.php?page=$currentPage'</script>";
        }
        $config=mysqli_connect(HOST,USER,PWD,NAME)or die("数据库平台连接错误，错误的类型是：".mysqli_error());
        $queryMypic='SELECT * FROM traveluser WHERE UserName = "'.$_SESSION['uname'].'"' ;
        $resultMypic = mysqli_query($config,$queryMypic);
        $rowMypic=mysqli_fetch_assoc($resultMypic);
        $PicPath = $rowMypic['favor'];
        if($PicPath==''){
            $isNone=1;
            echo '<p style="text-align: center;
    margin-top: 30px;
    font-size: 30px;">您还没有收藏照片，去收藏一
张吧！</p>';
        }else{

            $arr=explode('^&',$PicPath);
            $i=($currentPage-1)*4+1;
            if(count($arr)>=(($currentPage-1)*4+5)){
                $num = ($currentPage-1)*4+5;
            }else{
                $num=count($arr);
            }
//    echo $num;
//    echo '0'.$arr[0].'1'.$arr[1].'2'.$arr[2];
            for ($i ;$i<$num;$i++){
                if ($arr[$i]!=''){

                    $query='SELECT * FROM travelimage WHERE PATH = "'.$arr[$i].'"';

                    $result=mysqli_query($config,$query);

                    $row=mysqli_fetch_assoc($result);

                    showImgMyfav($row);
                }

            }

        }
        if ((($currentPage-1)*4+1)>=$num&&$isNone==0){

            echo '<p style="text-align: center;
    margin-top: 30px;
    font-size: 30px;">赶紧去收藏更多的图片吧！</p>';
        }
        ?>


        <?php
        echo "<script> var NeedPage = \"$needPage\";</script>";
        ?>

    </ul>
    <div class="pageNumber" style="    position: absolute;
    top: 1016px;
    text-align: center;
    width: 100%;">
        <div class="fontPage">
            <p>

                <?php
                echo "
                        <a href=\"javascript:void(0)\" onclick=\"toPre();\"><span>《</span></a>
                        <a class=\"on\" href=\"javascript:void(0)\" onclick=\"getUrl('page=1');\"><span>1</span></a>
                        <a href=\"javascript:void(0)\" onclick=\"getUrl('page=2');\"><span>2</span></a>
                        <a href=\"javascript:void(0)\" onclick=\"getUrl('page=3');\"><span>3</span></a>
                        <a href=\"javascript:void(0)\" onclick=\"getUrl('page=4');\"><span>4</span></a>
                        <a href=\"javascript:void(0)\" onclick=\"getUrl('page=5');\"><span>5</span></a>
                        <a href=\"javascript:void(0)\" onclick=\"toNext();\"><span>》</span></a>
                     ";
                ?>
            </p>
        </div>
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
    <script>    function toPre() {
            var s = window.location.href;

            if(s.indexOf('page=')!= -1){
                var page = s.substr(s.length-1,1);
                if(page==1){
                    getUrl('page=1');
                }else {
                    var s = page -1 ;
                    toPage = 'page='+s;
                    getUrl(toPage);
                }
            }
            else{
                getUrl('page=1');
            }
        }
        function toNext() {
            var s = window.location.href;
            if(s.indexOf('page=')!= -1){
                var page = s.substr(s.length-1,1);
                if(page==5){
                    getUrl('page=5');
                }else {
                    var s = parseInt(page) +1 ;
                    if(s>NeedPage){
                        s= s-1;
                    }
                    toPage = 'page='+s;
                    getUrl(toPage);
                }
            }
            else{
                if (NeedPage==1){
                    getUrl('page=1');
                }else{
                    getUrl('page=2');
                }

            }

        }
        function getUrl(target) {
            var isPage = 0;
            var connect = '';
            var a=window.location.href;
            if(a.indexOf("?") != -1){                                     //有问号
                if (a.split("?")[1].indexOf('page') != -1){                          //有page
                    isPage =1 ;
                    for(var m =0; m<a.split("?")[1].split("&").length-1;m++){
                        connect +=a.split("?")[1].split("&")[m] + "&";
                    }
                }
                if (isPage==1){
                    if(a.split('?')[1] == 'page=1' || a.split('?')[1] == 'page=2'||a.split('?')[1] == 'page=3'||a.split('?')[1] == 'page=4'||a.split('?')[1] == 'page=5' ){
                        var w = a.split('?')[0]+'?'+connect+target;
                        window.location.href=w;
                    }else {
                        var s= a.split('?')[0]+'?'+connect+target;

                        window.location.href =s;
                    }
                }else {
                    var n=a+'&'+target;
                    window.location.href = n;
                }
            }else{                                                          //没问号
                var q =a+'?'+target;
                window.location.href =q;
            }

        }

        function queryGet(qs){
            var s = location.href;
            s=s.replace("?","?&").split("&");
            var re="";
            for(i=1;i<s.length;i++){
                if(s[i].indexOf(qs+"=")==0){
                    re=s[i].replace(qs+"=","");
                }
            }
            if(re==''){
                var a = document.querySelectorAll('.fontPage > p > a');
                for(var l =0;l<a.length;l++){
                    a[l].className='';
                }
                a[1].className='on'
            }
            if(re>=1&&re<=5){
                var a = document.querySelectorAll('.fontPage > p > a');
                for(var l =0;l<a.length;l++){
                    a[l].className='';
                }
                a[re].className='on';
            }
        }
        queryGet('page');
        function DelUrlMod(a){
            var s=window.location.href;
            if(s.indexOf("?") != -1){                                     //有问号
                window.location.href=s+'&del='+a;
            }else{                                                          //没问号
                window.location.href =s.split('?')[0]+'?del='+a;
            }
        }
    </script>
</html>