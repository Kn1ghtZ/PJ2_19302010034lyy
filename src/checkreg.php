<?php
session_start();
require dirname(dirname(__FILE__)).'/config.php';
error_reporting(5);



$email=$_POST['email'];
$pword=$_POST['pword1'];
$name=$_POST['Username'];


$query="SELECT * FROM traveluser WHERE `Email`='$email' ";
$query2="SELECT * FROM traveluser WHERE `UserName`='$name' ";
$result = mysqli_query($config,$query);
$result2 = mysqli_query($config,$query2);

if ($result || $result2) {echo "a";
    $row=mysqli_fetch_array($result);
    $row2 = mysqli_fetch_array($result2);
    if ($row || $row2){
        if($row){
            echo('<script type="text/javascript">alert("邮箱已被注册！请重新注册");
								window.location.href = "register.php";

		</script>');
        }
        if($row2){
            echo('<script type="text/javascript">alert("用户名已被注册！请重新注册");
								window.location.href = "register.php";

		</script>');
        }

    }
    else{
        echo 'b';
        // 将form表单中的email、username、pword、pword2进行赋值
//        $pword=md5($pword);
        // 将注册的密码进行md5加密并插入进users数据表中

        $intermediateSalt = md5(uniqid(rand(), true));
        $salt = substr($intermediateSalt, 0, 6);
        $salt = md5($salt);

        $pword=md5($pword).$salt;  //把密码进行md5加密然后和salt连接
        $pword=md5($pword);  //执行MD5散列

        $query="INSERT INTO traveluser(`UserName`,`Email`,`Pass`,`salt`) VALUES('$name','$email','$pword','$salt')";
        $result = mysqli_query($config,$query)or die("error:".mysqli_error());

        if ($result){
            $_SESSION['uname']=$name;
            echo('<script type="text/javascript">alert("注册成功");
							window.location.href = "../index.php";
						</script>');
        }else {
            echo('<script type="text/javascript">alert("注册失败");
							
						</script>');

        }

    }

}









?>


<!-- header("location: http://localhost/school/login/register.php"); -->


<!-- $query="SELECT * FROM users WHERE `uemail`='$email' ";
                $result = mysql_query($query);
                if ($result) {
                    $row=mysql_fetch_array($result);
                    if ($row){

                        echo('<script type="text/javascript">alert("邮箱已被注册！请重新注册");
                            window.location.href = "register.php";

    </script>');

                    }
                } -->

<!-- window.history.back(-1); -->