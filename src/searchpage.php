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


        <title>searchpage</title>
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    </head>

<body>

<?php require "top.php" ?>
<link rel="stylesheet" href="./css/search_page.css" type="text/css">
<?php require "showIMG.php"; ?>
<!-- 页面头部 -->

<div class="container">
    <!-- search -->
    <div class="search">
        <h4>
            Search
        </h4>
        <div class="searchForm">
            <form action="" method="get">
                <label>
                    <input type="radio" name="filt" checked="true" onclick="document.getElementById('T2').disabled='disabled';
                document.getElementById('T1').removeAttribute('disabled');
                document.getElementById('T2').value=''">
                    Filt by Title
                </label>
                <br>
                <input type="text" name="Title" id="T1" placeholder="请输入相关标题">
                <br>
                <label>
                    <input type="radio" name='filt' onclick="document.getElementById('T1').disabled='disabled';
                document.getElementById('T2').removeAttribute('disabled');
                document.getElementById('T1').value=''"> Filt by Description
                </label>
                <textarea name="Description" id="T2" disabled="disabled" placeholder="请输入相关描述"></textarea>
                <br>
                <input type="submit"  id="filterbt" value="Filter"  >
            </form>
        </div>
    </div>
    <?php
    if(!isset($_GET['page'])){
        if(isset($_GET['Title'])||isset($_GET['Description'])){
            if($_GET['Title']!=''||$_GET['Description']!=''){
//                echo"<script>alert('图片已刷新');</script>";
            }else{
                echo"<script>alert('请输入相关内容');
var s = window.location.href;
a = s.split('?')[0];
window.location.href=a;</script>";
            }
        }
    }


    ?>
    <!-- result -->
    <div class="result" style="display: none">
        <h4>
            Result
        </h4>
        <ul>
            <?php
            $needPage = 5;
            $currentPage =1;
            if(isset($_GET['page'])){
                $currentPage=$_GET['page'];
            }

            if(isset($_GET['Title'])&&$_GET['Title']!=''){
                echo "<script>
                                var result = document.querySelector('.result');
                                result.style.display='block';
                        </script>";
                   img_Search($_GET['Title'],$currentPage,$needPage,0);
            }

            if(isset($_GET['Description'])&&$_GET['Description']!=''){
                echo "<script>
                                var result = document.querySelector('.result');
                                result.style.display='block';
                        </script>";
                img_Search($_GET['Description'],$currentPage,$needPage,1);
            }
            echo "<script> var NeedPage = \"$needPage\";</script>";
            ?>
            <?php
            if($needPage==0){
                echo '<p style="text-align: center;
    margin-top: 20px;">没有查询到相关图片噢~</p>';
            }

            ?>
        </ul>
        <div class="pageNumber">
                <p>
                    <?php
                    if($needPage==1)
                        echo "
                        <a href=\"javascript:void(0)\" onclick=\"toPre();\"><span>《</span></a>
                        <a class=\"on\" href=\"javascript:void(0)\" onclick=\"getUrl('page=1');\"><span>1</span></a>
                        <a href=\"javascript:void(0)\" onclick=\"toNext();\"><span>》</span></a>
                     ";
                    if($needPage==2)
                        echo "
                        <a href=\"javascript:void(0)\" onclick=\"toPre();\"><span>《</span></a>
                        <a class=\"on\" href=\"javascript:void(0)\" onclick=\"getUrl('page=1');\"><span>1</span></a>
                        <a href=\"javascript:void(0)\" onclick=\"getUrl('page=2');\"><span>2</span></a>
                        <a href=\"javascript:void(0)\" onclick=\"toNext();\"><span>》</span></a>
                     ";
                    if($needPage==3)
                        echo "
                        <a href=\"javascript:void(0)\" onclick=\"toPre();\"><span>《</span></a>
                        <a class=\"on\" href=\"javascript:void(0)\" onclick=\"getUrl('page=1');\"><span>1</span></a>
                        <a href=\"javascript:void(0)\" onclick=\"getUrl('page=2');\"><span>2</span></a>
                        <a href=\"javascript:void(0)\" onclick=\"getUrl('page=3');\"><span>3</span></a>
                        <a href=\"javascript:void(0)\" onclick=\"toNext();\"><span>》</span></a>
                     ";
                    if($needPage==4)
                        echo "
                        <a href=\"javascript:void(0)\" onclick=\"toPre();\"><span>《</span></a>
                        <a class=\"on\" href=\"javascript:void(0)\" onclick=\"getUrl('page=1');\"><span>1</span></a>
                        <a href=\"javascript:void(0)\" onclick=\"getUrl('page=2');\"><span>2</span></a>
                        <a href=\"javascript:void(0)\" onclick=\"getUrl('page=3');\"><span>3</span></a>
                        <a href=\"javascript:void(0)\" onclick=\"getUrl('page=4');\"><span>4</span></a>
                        <a href=\"javascript:void(0)\" onclick=\"toNext();\"><span>》</span></a>
                     ";
                    if($needPage==5)
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
    <script>

        function toPre() {
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
                var a = document.querySelectorAll('.pageNumber > p > a');
                for(var l =0;l<a.length;l++){
                    a[l].className='';
                }
                a[1].className='on'
            }
            if(re>=1&&re<=5){
                var a = document.querySelectorAll('.pageNumber > p > a');
                for(var l =0;l<a.length;l++){
                    a[l].className='';
                }
                a[re].className='on';
            }
        }
        queryGet('page');

    </script>
</html>
