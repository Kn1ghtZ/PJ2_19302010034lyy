<?php
require '../config.php';
session_start();

error_reporting(5);

?>
<?php

//获取到临时文件
//$file=$_FILES['file'];
//
////获取文件名
//$fileName=$file['name'];
////移动文件到当前目录
//move_uploaded_file($file['tmp_name'],"./../images/travel-images/normal/small/" . $_FILES["file"]["name"]);
//echo "Upload: " . $_FILES["file"]["name"] . "<br />";
//echo "Type: " . $_FILES["file"]["type"] . "<br />";
//echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
//echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
////显示文件
//echo "<img src='$fileName'>";
//
//
//var_dump($result);
////                INSERT INTO `travelimage` (`ImageID`, `Title`, `Description`, `Latitude`, `Longitude`, `CityCode`, `CountryCodeISO`, `UID`, `PATH`, `Content`) VALUES (NULL, '312', '13', NULL, NULL, '12', '21', '0', '132', '132');
//$path='../images/travel-images/normal/small/';
//$filename='1.txt';
//if(file_exists($path)){
//    $res=unlink($path.'/'.$filename);
//    if ($res){
//        echo 'succ';
//
//    }else{
//        echo 'fa';
//    }
//}
//$str='aaaabbbbb';
//$find='a';
//var_dump(3==4);
//if(strpos($str,$find)!==false){
//    echo 'yes';
//}else{
//    echo 'no';
//}

//echo password_hash("r", PASSWORD_DEFAULT);

//$hashed_password = password_hash($password,PASSWORD_DEFAULT);
//
//$nowPass='123456';

$password ='123456';

    $intermediateSalt = md5(uniqid(rand(), true));
    $salt = substr($intermediateSalt, 0, 6);
    $salt = md5($salt);

    echo $salt;
    echo '<br>';
    $password=md5($password).$salt;  //把密码进行md5加密然后和salt连接
    $password=md5($password);  //执行MD5散列

echo $password;
echo '<br>';
$newPass ='123456';
$newPass=md5($newPass).$salt;
$newPass=md5($newPass);
echo $newPass;
echo '<br>';
var_dump($newPass==$password);
//var_dump(password_verify($nowPass,$hashed_password));
?>





    <!DOCTYPE html>
<html>
<head lang="en">
 <meta charset="UTF-8">
 <title>上传文件</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
 <input type="file" name="file"/>
 <input type="submit" value="提交">
</form>
</body>
</html>
