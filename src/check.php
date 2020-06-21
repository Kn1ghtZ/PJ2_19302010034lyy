<?php
session_start();
require dirname(dirname(__FILE__)).'/config.php';
error_reporting(5);


$uname = $_POST['username'];
$pword = $_POST['password'];


if ($uname == null || $pword == null) {
    die("不能为空！");
}
// 将form表单中的email、username、pword、pword2进行赋值

//$pword = md5($pword);                                        //

// 将注册的密码进行md5加密并插入进users数据表中
//$query = "SELECT * FROM traveluser WHERE `UserName`='$uname' AND `Pass`='$pword'";//
$query = "SELECT * FROM traveluser WHERE `UserName`='$uname' ";//

$result=mysqli_query($config,$query);

//$result = mysql_query($query);
if ($result) {
    $row = mysqli_fetch_array($result);
    $truepass=$row['Pass'];
    $salt=$row['salt'];

    $pword=md5($pword).$salt;  //把密码进行md5加密然后和salt连接
    $pword=md5($pword);  //执行MD5散列

    if ($pword==$truepass) {
        // 获取并返回登陆之前访问的页面地址$_SESSION['userurl'
        echo('<script type="text/javascript">
	window.location.href = "./../index.php";             //以后还要改地址

						</script>');

//        $_SESSION['login'] = $email;

        $_SESSION['uname'] = $row['UserName'];
        exit;
    } else {
        $sql="SELECT count(*) as sum FROM traveluser WHERE UserName='$uname'";
        $result1=mysqli_query($config,$sql);
        $row1 = mysqli_fetch_row($result1);
        $rowcount = $row1[0];

        if ($rowcount > 0){
            echo('<script type="text/javascript">alert("密码错误");
		window.history.back(-1);
		</script>');
        }else{
            echo('<script type="text/javascript">alert("用户名不存在");
		window.history.back(-1);
		</script>');
        }

    }
}
?>
<!--
echo('<script type="text/javascript">
window.location.href = "http://localhost/school/index.php";

        </script>');
 -->
<!--

 if (isset ($_SESSION['userurl']))
	{$url = $_SESSION['userurl']; header("location: $url");}
    else{echo('<script type="text/javascript">
	window.location.href = "http://localhost/school/index.php";
						</script>');}

-->

<!-- window.history.back(-1); -->