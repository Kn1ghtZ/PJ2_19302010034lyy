<?php
require dirname(dirname(__FILE__)).'/config.php';
session_start();

global $pagesize;

$pagesize = 12;
$pages = 5;
$currentPage =1;

//if([isset($_GET['page'])]){
//    $currentPage=$_GET['page'];
//}
//global $start;
//$start = ($currentPage-1) * $pagesize;

function all($page){
    $config=mysqli_connect(HOST,USER,PWD,NAME)or die("数据库平台连接错误，错误的类型是：".mysqli_error());
    $sql = "SELECT count(*) as 'count' from travelimage";
    $result = mysqli_query($config,$sql);
    $arr = mysqli_fetch_array($result);
    $count = $arr['count'];
    $start = ($page-1)*$GLOBALS['pagesize'];
    $sql1 = "SELECT * FROM travelimage LIMIT ".$start.",".$GLOBALS['pagesize'];

    if($result1 = mysqli_query($config,$sql1)) {
        while($row=mysqli_fetch_assoc($result1)){
            showImg($row,'browser');
        }
    }
}
function outputImgFirst(){
    $config=mysqli_connect(HOST,USER,PWD,NAME)or die("数据库平台连接错误，错误的类型是：".mysqli_error());
    $query='SELECT * FROM travelimage ORDER BY favorNum DESC LIMIT 6' ;
    if( $result=mysqli_query($config,$query)) {

        while($row=mysqli_fetch_assoc($result)){

            showImg($row,'home');
        }

    }

}
function outputImg(){
    $config=mysqli_connect(HOST,USER,PWD,NAME)or die("数据库平台连接错误，错误的类型是：".mysqli_error());
    $query='SELECT * FROM travelimage ORDER BY RAND() LIMIT 6' ;
    if( $result=mysqli_query($config,$query)) {

        while($row=mysqli_fetch_assoc($result)){

            showImg($row,'home');
        }

    }
}
function outImg($target,$page,&$needPage){
    $start = ($page-1)*$GLOBALS['pagesize'];
    $config=mysqli_connect(HOST,USER,PWD,NAME)or die("数据库平台连接错误，错误的类型是：".mysqli_error());

    $queryPage ='SELECT count(*) as "count" FROM travelimage WHERE CountryCodeISO = "'.$target.'" OR CityCode = "'.$target.'" OR Content = "'.$target.'" ';
    $resultPage = mysqli_query($config,$queryPage);
    $arr = mysqli_fetch_array($resultPage);
    $count = $arr['count'];
    $needPage= ceil($count/12);
    if ($needPage>=5){$needPage = 5 ;}

    $query='SELECT * FROM travelimage WHERE CountryCodeISO = "'.$target.'" OR CityCode = "'.$target.'" OR Content = "'.$target.'" LIMIT '.$start.','.$GLOBALS['pagesize'] ;
    if( $result=mysqli_query($config,$query)) {
        while($row=mysqli_fetch_assoc($result)){
            showImg($row,'browser');
        }
    }
}

function filterImg($content,$country,$city,$page,&$needPage){
    $start = ($page-1)*$GLOBALS['pagesize'];
    $config=mysqli_connect(HOST,USER,PWD,NAME)or die("数据库平台连接错误，错误的类型是：".mysqli_error());

if($city!=''){
    $query='SELECT * FROM geocities WHERE AsciiName = "'.$city.'"' ;
    $result = mysqli_query($config,$query);
    if($country != ''){
        while ($row=mysqli_fetch_assoc($result)){
            if ($row['CountryCodeISO'] == $country){
                $citycode = $row['GeoNameID'];
            }
        }
    }else{
        $row=mysqli_fetch_assoc($result);
        $citycode=$row['GeoNameID'];
    }
}

if($city == '' && $country == ''){              //筛选的五种情况
    $queryContent ='SELECT * FROM travelimage WHERE Content = "'.$content.'" LIMIT '.$start.','.$GLOBALS['pagesize'];

    $queryPage ='SELECT count(*) as "count" FROM travelimage WHERE Content = "'.$content.'"';
    $resultPage = mysqli_query($config,$queryPage);
    $arr = mysqli_fetch_array($resultPage);
    $count = $arr['count'];
    $needPage= ceil($count/12);
    if ($needPage>=5){$needPage = 5 ;}
    $resultContent = mysqli_query($config,$queryContent);
    while ($rowContent=mysqli_fetch_assoc($resultContent)){
          showImg($rowContent,'browser');
    }
}
if($city!='' && $country == ''){
    if($content == ''){
        $queryCity ='SELECT * FROM travelimage WHERE CityCode = "'.$citycode.'" LIMIT '.$start.','.$GLOBALS['pagesize'];

        $queryPage ='SELECT count(*) as "count" FROM travelimage WHERE CityCode = "'.$citycode.'"';
        $resultPage = mysqli_query($config,$queryPage);
        $arr = mysqli_fetch_array($resultPage);
        $count = $arr['count'];
        $needPage= ceil($count/12);
        if ($needPage>=5){$needPage = 5 ;}
        $resultCity = mysqli_query($config,$queryCity);
        while ($rowCity=mysqli_fetch_assoc($resultCity)){
            showImg($rowCity,'browser');
        }
    }else{
        $queryConCi ='SELECT * FROM travelimage WHERE CityCode = "'.$citycode.'" AND Content = "'.$content.'" LIMIT '.$start.','.$GLOBALS['pagesize'] ;

        $queryPage ='SELECT count(*) as "count" FROM travelimage WHERE CityCode = "'.$citycode.'" AND Content = "'.$content.'"' ;
        $resultPage = mysqli_query($config,$queryPage);
        $arr = mysqli_fetch_array($resultPage);
        $count = $arr['count'];
        $needPage= ceil($count/12);
        if ($needPage>=5){$needPage = 5 ;}
        $resultConCi = mysqli_query($config,$queryConCi);
        while ($rowConCi=mysqli_fetch_assoc($resultConCi)){
            showImg($rowConCi,'browser');
        }
    }
}

if($city !='' && $country !=''){
    if($content == ''){
        $queryCityCou ='SELECT * FROM travelimage WHERE CityCode = "'.$citycode.'" AND CountryCodeISO = "'.$country.'" LIMIT '.$start.','.$GLOBALS['pagesize'];

        $queryPage ='SELECT count(*) as "count" FROM travelimage WHERE CityCode = "'.$citycode.'" AND CountryCodeISO = "'.$country.'"';
        $resultPage = mysqli_query($config,$queryPage);
        $arr = mysqli_fetch_array($resultPage);
        $count = $arr['count'];
        $needPage= ceil($count/12);
        if ($needPage>=5){$needPage = 5 ;}
        $resultCityCou = mysqli_query($config,$queryCityCou);
        while ($rowCityCou=mysqli_fetch_assoc($resultCityCou)){
            showImg($rowCityCou,'browser');
        }
    }
    if ($content !=''){
        $queryCiCouCon ='SELECT * FROM travelimage WHERE CityCode = "'.$citycode.'" AND Content = "'.$content.'" AND CountryCodeISO = "'.$country.'" LIMIT '.$start.','.$GLOBALS['pagesize'] ;

        $queryPage ='SELECT count(*) as "count" FROM travelimage WHERE CityCode = "'.$citycode.'" AND Content = "'.$content.'" AND CountryCodeISO = "'.$country.'"';
        $resultPage = mysqli_query($config,$queryPage);
        $arr = mysqli_fetch_array($resultPage);
        $count = $arr['count'];
        $needPage= ceil($count/12);
        if ($needPage>=5){$needPage = 5 ;}
        $resultCiCouCon = mysqli_query($config,$queryCiCouCon);
        while ($rowCiCouCon=mysqli_fetch_assoc($resultCiCouCon)){
            showImg($rowCiCouCon,'browser');
        }
    }
}
}
function img_Search($target,$page,&$needPage,$mark){                   //用于searchpage   $mark表明0:title还是1:description
    $start= ($page-1)*4;
    $config=mysqli_connect(HOST,USER,PWD,NAME)or die("数据库平台连接错误，错误的类型是：".mysqli_error());
    if($mark==0){
        $queryPage ='SELECT count(*) as "count" FROM travelimage WHERE Title LIKE "%'.$target.'%"';
    }
    if($mark==1){
        $queryPage ='SELECT count(*) as "count" FROM travelimage WHERE Description LIKE "%'.$target.'%"';
    }
    $resultPage = mysqli_query($config,$queryPage);
    $arr = mysqli_fetch_array($resultPage);
    $count = $arr['count'];
    $needPage= ceil($count/4);
    if ($needPage>=5){$needPage = 5 ;}

    if($mark==0){
        $query='SELECT * FROM travelimage WHERE Title LIKE "%'.$target.'%" LIMIT '.$start.','.'4' ;
    }
    if ($mark==1){
        $query='SELECT * FROM travelimage WHERE Description LIKE "%'.$target.'%" LIMIT '.$start.','.'4' ;
    }
    if( $result=mysqli_query($config,$query)) {
        while($row=mysqli_fetch_assoc($result)){
            showImgSearch($row);
        }
    }

}

function outImg_search($target,$page,&$needPage){                                  //用于browserpage
    $start = ($page-1)*$GLOBALS['pagesize'];
    $config=mysqli_connect(HOST,USER,PWD,NAME)or die("数据库平台连接错误，错误的类型是：".mysqli_error());

    $queryPage ='SELECT count(*) as "count" FROM travelimage WHERE Description LIKE "%'.$target.'%" OR Title LIKE "%'.$target.'%"OR CountryCodeISO LIKE "%'.$target.'%"';
    $resultPage = mysqli_query($config,$queryPage);
    $arr = mysqli_fetch_array($resultPage);
    $count = $arr['count'];
    $needPage= ceil($count/12);
    if ($needPage>=5){$needPage = 5 ;}

    $query='SELECT * FROM travelimage WHERE Description LIKE "%'.$target.'%" OR Title LIKE "%'.$target.'%"OR CountryCodeISO LIKE "%'.$target.'%" LIMIT '.$start.','.$GLOBALS['pagesize'] ;
    if( $result=mysqli_query($config,$query)) {
        while($row=mysqli_fetch_assoc($result)){
            showImg($row,'browser');
        }
    }
}

function showImg($row,$mark) {                                       //用于homepage，browserpage
    echo '<li>';
    if ($mark!='browser'){
        $img = '<img src="images/travel-images/normal/small/' .$row['PATH'] .'">';
    }else{
        $img = '<img src="../images/travel-images/normal/small/' .$row['PATH'] .'">';
    }
    if ($mark!='browser'){
        echo constructLinkIndex($row['PATH'] , $img);

    }else{
        echo constructLink($row['PATH'] , $img);
    }

    if($mark!='browser'){
        echo '<h5>'.$row['Title'].'</h5>';
        echo '<p>'.$row['Description'].'</p>';
    }
    echo '</li>';

}
function showImgSearch($row){                                         //用于searchpage
    echo '<li>';
    echo '<div class="picShow clearfix">
                        <div class="pic">';
    $img = '<img src="../images/travel-images/normal/small/' .$row['PATH'] .'">';
    echo constructLink($row['PATH'] , $img);
    echo '              </div>
                        <div class="description">';
    echo '<h1>'.$row['Title'].'</h1>';
    echo '<p>'.$row['Description'].'</p>';
    echo '              </div>
          </div>';
    echo '</li>';
}
function showImgMypic($row){                          //用于myphoto
    echo '<li>
            <div class="picShow">
                <div class="pic">';
    $img = '<img src="../images/travel-images/normal/small/' .$row['PATH'] .'">';
    echo constructLink($row['PATH'] , $img);
    echo ' </div>
                <div class="description">';
    echo '<h1>'.$row['Title'].'</h1>';
    echo '<p >'.$row['Description'].'</p>';

   echo '<a href="javascript:void(0)" onclick=getUrlMod("'.$row['PATH'].'");>';
    

//    echo '<a href="javascript:void(0)" onclick="getUrlMod('$row['PATH']');">';

    echo '<input type="button" value="Modify" id="Mod" >
                    </a>';
    echo '<a href="javascript:void(0)" onclick=DelUrlMod("'.$row['PATH'].'");>';
    echo ' 
           <input type="button" value="Delete"  id="Del">
           </a>
           </div>
          </div>
        </li>';

}
function showImgMyfav($row){               //用于myfavor
    echo '<li>
            <div class="picShow">
                <div class="pic">';
    $img = '<img src="../images/travel-images/normal/small/' .$row['PATH'] .'">';
    echo constructLink($row['PATH'] , $img);
    echo ' </div>
                <div class="description">';
    echo '<h1>'.$row['Title'].'</h1>';
    echo '<p >'.$row['Description'].'</p>';
    echo '<a href="javascript:void(0)" onclick=DelUrlMod("'.$row['PATH'].'");>';
    echo ' 
           <input type="button" value="Delete"  id="Del">
           </a>
           </div>
          </div>
        </li>';
}
function constructLink($id, $label) {
    $link = '<a href="details.php?img=' . $id . '">';           //详情页面
    $link .= $label;
    $link .= '</a>';
    return $link;
}
function constructLinkIndex($id, $label) {                          //用于index
    $link = '<a href="src/details.php?img=' . $id . '">';           //详情页面
    $link .= $label;
    $link .= '</a>';
    return $link;
}
?>