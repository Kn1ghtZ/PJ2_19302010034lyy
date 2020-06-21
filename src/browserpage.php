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
    <link rel="stylesheet" href="./css/browser_page.css" type="text/css">
        <!-- js二级联动 -->
        <script>
            //1.创建一个二维数组用于存储省份和城市
            var cities = new Array(3);
            cities[0] = new Array("Shanghai", "Kunming", "Beijing", "Yantai");
            cities[1] = new Array("Calgary", "Banff", "Lunenburg", "Huntsville");
            cities[2] = new Array("Roma", "Milan", "Venice", "Florence");
            cities[3] = new Array("Koeln", "Darmstadt", "Frankfurt am Main", "Berlin");

            function changeCity(val) {
                var cityEle = document.getElementById("city");
                cityEle.options.length = 0;
                if(val == 'clear'){
                    var clearcity = new Array('Filter By City','Shanghai','Paris','London','Tokyo');
                    for(var m =0; m<clearcity.length;m++){
                        var textNode = document.createTextNode(clearcity[m]);
                        var opEle = document.createElement("option");
                        opEle.appendChild(textNode);
                        cityEle.appendChild(opEle);
                    }
                }
                for (var i = 0; i < cities.length; i++) {
                    if (val == i) {
                        for (var j = 0; j < cities[i].length; j++) {
                            var textNode = document.createTextNode(cities[i][j]);
                            var opEle = document.createElement("option");
                            opEle.appendChild(textNode);
                            cityEle.appendChild(opEle);
                        }
                    }
                }
            }
        </script>

        <title>browser</title>
</head>
<body>
<?php require "top.php" ?>

<?php require "showIMG.php"; ?>

<!-- 主要内容部分 -->
<div class="container clearfix">
    <!-- 左侧 -->
    <div class="left">
        <div class="search">
            <h4>Search by Title</h4>
            <div class="searchForm">
                <form action="" method="get">
                    <input type="text" name="text" id="text"
                           <?php
                           if(isset($_GET[text])!=''){

                               echo 'value='.$_GET[text];
                           }
                           else{
                               echo 'placeholder="请输入关键词"';
                           }
                           ?>


                           >
                    <input type="submit" name="submit"  id="submit" value="" >
                </form>
            </div>
        </div>
        <div class="hotCity hotContent">
            <dl>
                <dt>Hot Content</dt>
                <dd><a href="javascript:void(0)" onclick="getUrl1('search=scenery');">Scenery</a> </dd>
                <dd><a href="javascript:void(0)" onclick="getUrl1('search=people');">People</a> </dd>
                <dd><a href="javascript:void(0)" onclick="getUrl1('search=animal');">Animal</a></dd>
                <dd><a href="javascript:void(0)" onclick="getUrl1('search=wonder');">Wonder</a></dd>
            </dl>
        </div>
        <!-- 热门国家栏 -->
        <div class="hotCountry">
            <dl>
                <dt>Hot Country</dt>
                <dd><a href="javascript:void(0)" onclick="getUrl1('search=CA');">Canada</a> </dd>
                <dd><a href="javascript:void(0)" onclick="getUrl1('search=US');">America</a> </dd>
                <dd><a href="javascript:void(0)" onclick="getUrl1('search=GB');">England</a></dd>
                <dd><a href="javascript:void(0)" onclick="getUrl1('search=IT');">Italy</a></dd>
                <dd><a href="javascript:void(0)" onclick="getUrl1('search=GR');">Greece</a> </dd>
                <dd><a href="javascript:void(0)" onclick="getUrl1('search=GH');">Ghana</a> </dd>
            </dl>
        </div>
        <!-- 热门城市栏 -->
        <div class="hotCity">
            <dl>
                <dt>Hot City</dt>
                <dd><a href="javascript:void(0)" onclick="getUrl1('search=1796236');">Shanghai</a> </dd>
                <dd><a href="javascript:void(0)" onclick="getUrl1('search=2988507');">Paris</a> </dd>
                <dd><a href="javascript:void(0)" onclick="getUrl1('search=2643743');">London</a></dd>
                <dd><a href="javascript:void(0)" onclick="getUrl1('search=5913490');">Calgary</a></dd>
            </dl>
        </div>
    </div>
    <!-- 右侧 -->
    <div class="right">
        <h4>Filter</h4>
        <div class="filter">
            <form action="" method="get">

                <select name="content" id="content">
                    <option value="">
                   Filter By Content
                    </option>
                    <option value="Scenery">Scenery</option>
                    <option value="People">People</option>
                    <option value="Animal">Animal</option>
                    <option value="Wonder">Wonder</option>
                </select>
                <select name="country" onchange="changeCity(this.value)">
                    <option value="clear">
                       Filter By Country
                    </option>
                    <option value="0">China</option>
                    <option value="1">Canada</option>
                    <option value="2">Italy</option>
                    <option value="3">Germany</option>
                </select>
                <select name="city" id="city">
                    <option value="">
                       Filter By City
                       </option>
                    <option value="shanghai">Shanghai</option>
                    <option value="paris">Paris</option>
                    <option value="london">London</option>
                    <option value="calgary">Calgary</option>

                </select>
                <input type="submit"  value="Filter">
            </form>
        </div>

        <div class="pictureShow">
            <ul>
                <?php
                $needPage = 5;
                $all = 0;
                $currentPage =1;
                if(isset($_GET['page'])){
                    $currentPage=$_GET['page'];
                }

                if(isset($_GET['text'])){                              //左侧搜索功能
                    outImg_search($_GET['text'],$currentPage,$needPage);
                }

                if(isset($_GET['search'])){                            //左侧侧边栏热门
                    outImg($_GET['search'],$currentPage,$needPage);
                }

                if(isset($_GET['country'])){                          //右侧筛选功能
                    if($_GET['country']!='clear'){
                        $country=change($_GET['country']);
                    }else{
                        $country='';
                    }
                }

                if (isset($_GET['content'] )|| isset($_GET['country']) || isset($_GET['city']) ){
                    if($_GET['content']!='' ||  $_GET['country']!='clear' || $_GET['city']!=''){
                        $all =1 ;
                        filterImg($_GET['content'],$country,$_GET['city'],$currentPage,$needPage);
                    }
                }

                if(!isset($_GET['text']) && !isset($_GET['search'])&& $all==0 ){     //正常显示
                    all($currentPage);
                ?>

                <?php }
                echo "<script> var NeedPage = \"$needPage\";</script>";
                ?>
                <?php
                if($needPage==0){
                    echo '<p>没有查询到相关图片噢~</p>';
                }

                ?>
            </ul>
        </div>
        <div class="fontPage">
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

<!--                <a href="javascript:void(0)" onclick="toPre();"><span>《</span></a>-->
<!--                <a class="on" href="javascript:void(0)" onclick="getUrl('page=1');"><span>1</span></a>-->
<!--                <a href="javascript:void(0)" onclick="getUrl('page=2');"><span>2</span></a>-->
<!--                <a href="javascript:void(0)" onclick="getUrl('page=3');"><span>3</span></a>-->
<!--                <a href="javascript:void(0)" onclick="getUrl('page=4');"><span>4</span></a>-->
<!--                <a href="javascript:void(0)" onclick="getUrl('page=5');"><span>5</span></a>-->
<!--                <a href="javascript:void(0)" onclick="toNext();"><span>》</span></a>-->
                
            </p>

        </div>
    </div>
</div>
<!-- 页脚 -->
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
<?php
if ($all==1 && $_GET['page']==''){
    echo '<script>window.onload=function() {
     
     alert("图片已刷新");
    }</script>';
}
?>
</body>
<script>
// console.log(NeedPage);
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
    function getUrl1(target) {
        var a=window.location.href;
        if(a.indexOf("?") != -1){
          a=a.split('?')[0];
        }
        var s =a+'?'+target;
        window.location.href = s;
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

</script>
<?php
function change($num){
    if($num==0){
        return 'CN';
    }
    if($num==1){
        return 'CA';
    }
    if($num==2){
        return 'IT';
    }
    if($num==3){
        return 'DE';
    }
}
?>
</html>


