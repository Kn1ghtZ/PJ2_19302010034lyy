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


    <title>upload</title>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script>

        function loadFile(a) {
            document.getElementById('namelabel').innerHTML = a.name;
        }

        //1.创建一个二维数组用于存储省份和城市
        var cities = new Array(4);
        cities[0] = new Array("---Select or Enter---","Shanghai", "Kunming", "Beijing", "Yantai");
        cities[1] = new Array("---Select or Enter---","Tokyo", "Yuki", "Kamakura", "Masuda");
        cities[2] = new Array("---Select or Enter---","Roma", "Verona", "Venezia", "Firenze");
        cities[3] = new Array("---Select or Enter---","Koeln", "Darmstadt", "Frankfurt am Main", "Berlin");

        function changeCity(val) {

            var cityEle = document.getElementById("city");
            cityEle.options.length = 0;
            if(val == 'clear'){
                var clearcity = new Array('---Select or Enter---','Shanghai','Paris','London','Tokyo');
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
            document.getElementById('gghh').value="Select or Enter";
            document.getElementById('city').firstElementChild.style.color='#c2c2c2';
        }

    </script>
</head>

<?php
if ($_SESSION['uname']==''){

    echo '请先登录再进行操作,即将为您跳转至登录页面...';
    header("refresh:2;url=login.php");
//    print('正在加载，请稍等...<br>五秒后自动跳转。');
    exit();
}

if ($_GET['modify']!=''){
    $config=mysqli_connect(HOST,USER,PWD,NAME)or die("数据库平台连接错误，错误的类型是：".mysqli_error());
    $queryMod='SELECT * FROM travelimage WHERE PATH="'.$_GET['modify'].'"';
    $resultMod=mysqli_query($config,$queryMod);
    $rowMod=mysqli_fetch_assoc($resultMod);
    $imgpath = $rowMod['PATH'];
    $imgcontent=$rowMod['Content'];
    $imgtitle = $rowMod['Title'];
    $imgdes= $rowMod['Description'];
    $imgcitycode=$rowMod['CityCode'];
    $imgcoucode=$rowMod['CountryCodeISO'];

    $queryModCountry='SELECT * FROM geocountries WHERE ISO = "'.$imgcoucode.'"';
    $resultModCountry =mysqli_query($config,$queryModCountry);
    $rowModCountry = mysqli_fetch_assoc($resultModCountry);
    $imgcou=$rowModCountry['CountryName'];

    $queryModCity='SELECT * FROM geocities WHERE GeoNameID = "'.$imgcitycode.'"';
    $resultModCity =mysqli_query($config,$queryModCity);
    $rowModCity = mysqli_fetch_assoc($resultModCity);
    $imgcity=$rowModCity['AsciiName'];

    echo '<script>
   window.onload=function(){
   let aa = document.querySelector("#content0");
   aa.innerText="'.$imgcontent.'"
    aa.value="'.$imgcontent.'";

let bb =document.querySelector("#title");
bb.value ="'.$imgtitle.'";     
 let cc =document.querySelector("#description");
 cc.value ="'.$imgdes.'";
 let dd=document.querySelector("#ccdd");
 dd.value="'.$imgcou.'";
 let ee = document.querySelector("#gghh");
 ee.value="'.$imgcity.'";
 document.getElementById("namelabel").innerHTML = "'.$imgpath.'";
 let ff = document.querySelector("#img0");
 ff.src="../images/travel-images/normal/small/' .$imgpath .'"
 }
        </script>';


}

    $judge = ((isset($_FILES['file0'][name])&&$_FILES['file0'][name]!='')||$_GET['modify'])&&(isset($_POST['content']) && _POST['content']!='0' )&& (isset($_POST['ccdd'])&& $_POST['ccdd']!='Select or Enter')&& (isset($_POST['gghh']) && ($_POST['gghh']!='Select or Enter'&&$_POST['gghh']!='---Select or Enter---'));

        if($judge){
            if (file_exists("./../images/travel-images/normal/small/" . $_FILES["file0"]["name"]))
            {
                if ($_GET['modify']!=''){
                    if (($_GET['modify']!=$_FILES['file0']['name'])&&($_FILES['file0']['name']!='')){
                        //echo "<script>alert('退出成功!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";    //返回不存在图片
                        echo "<script>alert('图片已存在!请选择其他图片！');history.back();</script>";
                        //返回存在图片
                    }else{
                        $config=mysqli_connect(HOST,USER,PWD,NAME)or die("数据库平台连接错误，错误的类型是：".mysqli_error());
                        $queryCountry='SELECT * FROM geocountries WHERE CountryName = "'.$_POST['ccdd'].'"' ;
                        $resultCountry = mysqli_query($config,$queryCountry);
                        $rowCountry=mysqli_fetch_assoc($resultCountry);
                        $country=$rowCountry['ISO'];
                        if($country==''){
                            echo "<script>alert('请检查国家名称是否正确！');history.back();</script>";
                            exit();
                        }

                        $queryCity='SELECT * FROM geocities WHERE AsciiName = "'.$_POST['gghh'].'"' ;
                        $resultCity = mysqli_query($config,$queryCity);
                        while ($rowCity=mysqli_fetch_assoc($resultCity)){
                            if ($rowCity['CountryCodeISO'] == $country){
                                $city = $rowCity['GeoNameID'];
                            }
                        }
                        if($city==''){
                            echo "<script>alert('请检查城市名称是否正确！');history.back();</script>";

                            exit();
                        }


                        $sqlMod='UPDATE travelimage SET Title="'.$_POST['title'].'",Description="'.$_POST['description'].'",CityCode="'.$city.'",CountryCodeISO="'.$country.'",Content="'.$_POST['content'].'" WHERE PATH="'.$_GET['modify'].'"';
                        $result = mysqli_query($config,$sqlMod);

                        echo "<script>alert('修改成功！');window.location.href='myPhoto.php'</script>";
                    }
                }else{
                    //echo "<script>alert('退出成功!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";    //返回不存在图片
                    echo "<script>alert('图片已存在!请选择其他图片！');history.back();</script>";
                    //返回存在图片
                }
            }
            else
            {
                if ($_GET['modify']!=''){
                    $config=mysqli_connect(HOST,USER,PWD,NAME)or die("数据库平台连接错误，错误的类型是：".mysqli_error());
                    $queryCountry='SELECT * FROM geocountries WHERE CountryName = "'.$_POST['ccdd'].'"' ;
                    $resultCountry = mysqli_query($config,$queryCountry);
                    $rowCountry=mysqli_fetch_assoc($resultCountry);
                    $country=$rowCountry['ISO'];
                    if($country==''){
                        echo "<script>alert('请检查国家名称是否正确！');history.back();</script>";
                        exit();
                    }

                    $queryCity='SELECT * FROM geocities WHERE AsciiName = "'.$_POST['gghh'].'"' ;
                    $resultCity = mysqli_query($config,$queryCity);
                    while ($rowCity=mysqli_fetch_assoc($resultCity)){
                        if ($rowCity['CountryCodeISO'] == $country){
                            $city = $rowCity['GeoNameID'];
                        }
                    }
                    if($city==''){
                        echo "<script>alert('请检查城市名称是否正确！');history.back();</script>";
                        exit();
                    }
                    $sqlMod='UPDATE travelimage SET Title="'.$_POST['title'].'",Description="'.$_POST['description'].'",CityCode="'.$city.'",CountryCodeISO="'.$country.'",Content="'.$_POST['content'].'",PATH="'.$_FILES['file0']['name'].'" WHERE PATH="'.$_GET['modify'].'"';
                    $result = mysqli_query($config,$sqlMod);

                    $queryMyPath='SELECT * FROM traveluser WHERE UserName="'.$_SESSION['uname'].'"';
                    $resultPath =mysqli_query($config,$queryMyPath);
                    $rowPath = mysqli_fetch_assoc($resultPath);
                    $Path=$rowPath['imgpath'];
                    $changePath='^&'.$_GET['modify'];
                    $replacePath='^&'.$_FILES['file0']['name'];
                    $newPath=str_replace($changePath,$replacePath,$Path);
                    $queryChangePath='UPDATE traveluser SET imgpath ="'.$newPath.'"WHERE traveluser.UserName="'.$_SESSION['uname'].'"';
                    $resultChangePath=mysqli_query($config,$queryChangePath);

                    $path='../images/travel-images/normal/small/';
                    $filename=$_GET['modify'];
                    if(file_exists($path)){
                        $res=unlink($path.'/'.$filename);
                    }

                    move_uploaded_file($_FILES["file0"]["tmp_name"],
                        "./../images/travel-images/normal/small/".$_FILES["file0"]["name"]);

                    echo "<script>alert('修改成功！');window.location.href='myPhoto.php'</script>";
                }else{
                    $config=mysqli_connect(HOST,USER,PWD,NAME)or die("数据库平台连接错误，错误的类型是：".mysqli_error());

                    $queryCountry='SELECT * FROM geocountries WHERE CountryName = "'.$_POST['ccdd'].'"' ;
                    $resultCountry = mysqli_query($config,$queryCountry);
                    $rowCountry=mysqli_fetch_assoc($resultCountry);
                    $country=$rowCountry['ISO'];
                    if($country==''){
                        echo "<script>alert('请检查国家名称是否正确！');history.back();</script>";
                        exit();
                    }


                    $queryCity='SELECT * FROM geocities WHERE AsciiName = "'.$_POST['gghh'].'"' ;
                    $resultCity = mysqli_query($config,$queryCity);
                    while ($rowCity=mysqli_fetch_assoc($resultCity)){
                        if ($rowCity['CountryCodeISO'] == $country){
                            $city = $rowCity['GeoNameID'];
                        }
                    }
                    if($city==''){
                        echo "<script>alert('请检查城市名称是否正确！');history.back();</script>";
                        exit();
                    }

                    $queryID='SELECT * FROM traveluser WHERE UserName="'.$_SESSION['uname'].'"';
                    $resultID=mysqli_query($config,$queryID);
                    $rowID=mysqli_fetch_assoc($resultID);
                    $ID=$rowID['UID'];

                    $sql ="INSERT INTO travelimage (ImageID,Title,Description,Latitude,Longitude,CityCode,CountryCodeISO,UID,PATH,Content,favorNum) VALUES (NULL,'".$_POST['title']."','".$_POST['description']."',NULL,NUll, '".$city."','".$country."','".$ID."','".$_FILES['file0']['name']."','".$_POST['content']."','0')";
                    $result = mysqli_query($config,$sql);
//                INSERT INTO `travelimage` (`ImageID`, `Title`, `Description`, `Latitude`, `Longitude`, `CityCode`, `CountryCodeISO`, `UID`, `PATH`, `Content`) VALUES (NULL, '312', '13', NULL, NULL, '12', '21', '0', '132', '132');

                    $queryPath = 'SELECT * FROM traveluser WHERE UserName="'.$_SESSION['uname'].'"';
                    $resultPath =mysqli_query($config,$queryPath);
                    $rowPath = mysqli_fetch_assoc($resultPath);
                    $Path=$rowPath['imgpath'];
                    $Path = $Path.'^&'.$_FILES["file0"]["name"];
                    $queryChangePath='UPDATE traveluser SET imgpath ="'.$Path.'"WHERE traveluser.UserName="'.$_SESSION['uname'].'"';
                    $resultChangePath=mysqli_query($config,$queryChangePath);
//                UPDATE `users` SET `imgpath` = '11111.jpg' WHERE `users`.`uname` = 'lyy';

                    move_uploaded_file($_FILES["file0"]["tmp_name"],
                        "./../images/travel-images/normal/small/".$_FILES["file0"]["name"]);
                    echo "<script>alert('上传成功！');</script>";

//            echo "Stored in: " . "./../images/travel-images/normal/small/" . $_FILES["file0"]["name"];
                }

            }

        }
        elseif($_POST['content'] =='0' ){
            echo "<script>alert('请选择主题！');history.back();</script>";
        }elseif ($_POST['ccdd'] =='Select or Enter' ){
            echo "<script>alert('请选择国家！');history.back();</script>";
        }elseif ($_POST['gghh'] =='Select or Enter' ||$_POST['gghh'] =='---Select or Enter---' ){
            echo "<script>alert('请选择城市！');history.back();</script>";
        }elseif (isset($_FILES['file0'][name])&& $_FILES['file0']['name']==''){
            echo "<script>alert('请选择图片！');history.back();</script>";
        }


?>
<body>

<?php require "top.php" ?>
<link rel="stylesheet" href="./css/upload.css" type="text/css">
<?php require "showIMG.php"; ?>
<div class="container">
    <h4>
        Upload
    </h4>
    <div class="upload">

        <div class="picShow" id="picshow">

            <img src="" id="img0" alt="图片未上传">
        </div>

        <div id="namelabel"> No files selected... </div>
        <div class="fileLabel">

        <?php
        if($_GET['modify']!=''){
            echo '<label for="file0" class="filelabel">Modify</label>';
        }else{
            echo '<label for="file0" class="filelabel">Upload</label>';
        }

        ?>




        </div>

        <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="file0" id="file0" onchange="loadFile(this.files[0])" ; style="display: none;"
               accept="image/gif,image/jpeg,image/jpg,image/png" /><br>

    </div>
    <div class="description">

            <p style="display: inline">
                图片主题：
            </p>
            <select name="content" id="content" style="display: inline;height: 26px;width: 88px">
                <option id="content0" value="0">--Select--</option>
                <option value="Scenery">Scenery</option>
                <option value="City">City</option>
                <option value="Building">Building</option>
                <option value="People">People</option>
                <option value="Animal">Animal</option>
                <option value="Wonder">Wonder</option>
                <option value="Other">Other</option>
            </select>

            <p style="display: inline;margin-left: 150px;">
                拍摄国家：
            </p>
            <!--select标签和input外面的span标签的格式是为了使两个位置在同一位置，控制位置-->
                <span style="margin-top:9px;position:absolute;border:1pt solid #c1c1c1;overflow:hidden;width:188px;height:22px;clip:rect(-1px 190px 190px 170px);">
                    <select name="aabb" id="aabb" style="width:190px;height:25px;margin:-2px;"
                            onChange="javascript:document.getElementById('ccdd').value=document.getElementById('aabb').options[document.getElementById('aabb').selectedIndex].value;
                            var a =selectNum(this);changeCity(a);
                             ">
                <!--下面的option的样式是为了使字体为灰色，只是视觉问题，看起来像是注释一样-->
                            <option num="clear" value="Select or Enter" style="color:#c2c2c2;">---Select or Enter---</option>
                            <option num="0" value="China">China</option>
                            <option num="1" value="Japan">Japan</option>
                            <option num="2" value="Italy">Italy</option>
                            <option num="3" value="Germany">Germany</option>
                    </select>
                </span>
                <span style="margin-top:9px;position:absolute;border-top:1pt solid #c1c1c1;border-left:1pt solid #c1c1c1;border-bottom:1pt solid #c1c1c1;width:170px;height:22px;">
                    <input type="text" name="ccdd" id="ccdd" value="Select or Enter" style="width:170px;height:22px;border:0pt;">
                </span>

            <p style="display: inline;margin-left: 315px;">
                拍摄城市：
            </p>
            <!--select标签和input外面的span标签的格式是为了使两个位置在同一位置，控制位置-->
                <span style="margin-top:9px;position:absolute;border:1pt solid #c1c1c1;overflow:hidden;width:188px;height:22px;clip:rect(-1px 190px 190px 170px);">
                        <select name="eeff" id="city" style="width:190px;height:25px;margin:-2px;"
                                onChange="javascript:document.getElementById('gghh').value=document.getElementById('city').options[document.getElementById('city').selectedIndex].value;">
                                <!--下面的option的样式是为了使字体为灰色，只是视觉问题，看起来像是注释一样-->
                                <option value="Select or Enter" style="color:#c2c2c2;">---Select or Enter---</option>
                                <option value="shanghai">Shanghai</option>
                                <option value="paris">Paris</option>
                                <option value="london">London</option>
                                <option value="tokyo">Tokyo</option>
                        </select>
                </span>
                <span style="margin-top:9px;position:absolute;border-top:1pt solid #c1c1c1;border-left:1pt solid #c1c1c1;border-bottom:1pt solid #c1c1c1;width:170px;height:22px;">
                        <input type="text" name="gghh" id="gghh" value="Select or Enter" style="width:170px;height:22px;border:0pt;">
                </span>

            <p>
                图片标题：
            </p>
            <input id='title' name="title" type="text" placeholder="Enter your picture title" style="    padding-left: 20px;" required>
            <p>
                图片描述：
            </p>
            <textarea name="description" id="description" cols="30" rows="10" placeholder="Enter your picture decription" style="    padding-left: 20px;padding-right: 20px;
    padding-top: 5px;
    font: 400 13.3333px Arial;" required></textarea>


                <input type="submit" value="Submit" >

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
<script>
    $("#file0").change(function () {
        var objUrl = getObjectURL(this.files[0]);//获取文件信息
        console.log("objUrl = " + objUrl);
        if (objUrl) {
            $("#img0").attr("src", objUrl);
        }
    });
    function getObjectURL(file) {
        var url = null;
        if (window.createObjectURL != undefined) {
            url = window.createObjectURL(file);
        } else if (window.URL != undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file);
        } else if (window.webkitURL != undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file);
        }
        return url;
    }

    function selectNum(sobj)
    {
        var num = $(sobj).find("option:selected").attr("num");//获取select的option中的自定义属性num
return num;
    }

</script>
</body>

</html>
