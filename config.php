<?php
header('Content-Type:text/html;charset=utf-8');
//error_reporting(0);
@define('HOST','localhost');
@define('USER','root');
@define('PWD','331234567qwe');
@define('NAME','project2');
@define('Root_Path',dirname(__FILE__));

$config=mysqli_connect(HOST,USER,PWD,NAME)or die("数据库平台连接错误，错误的类型是：".mysqli_error()); ;

//mysql_select_db(NAME,$config) or die("数据库匹配错误，错误的类型是：".mysqli_error());
mysqli_query($config,'SET NAMES UTF8') or die("编码格式/字符集错误，错误的类型是：".mysqli_error());





?>


