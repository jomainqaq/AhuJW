<?php  

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "demo01";

$LogName = $_POST['username'];
$LogPasswd = $_POST['password'];
//$LogName = "jomain";
//$LogPasswd ="lmy1998";
if($LogName == null or $LogPasswd == null){
	exit('不能为空');
}

//创建连接
$conn = mysqli_connect($servername,$username,$password,$dbname);

if (!$conn) 
	{ 
		die('Could not connect database: ' . mysql_error()); 
	} 
echo"success";
// $userIdenty = mysqli_query($conn,"select Identity from Users where User_Name='$LogName' limit 1");
// $hello =mysqli_fetch_assoc($userIdenty);
// echo $hello["Identity"];
//检测用户密码
$check_query = mysqli_query($conn,"select User_id from Users where User_Name ='$LogName' and User_Passwd ='$LogPasswd' limit 1");     
if($result = mysqli_num_rows($check_query)){
	echo"login success";
	$userIdenty = mysqli_query($conn,"select Identity from Users where User_Name='$LogName' ");
	$userIdenty = mysqli_fetch_assoc($userIdenty);
	echo $userIdenty["Identity"];
	switch($userIdenty["Identity"]){
		case 0:

		break;
		case 1:

		break;
		case 2:
		header('Location: http://localhost/demo/student.php');
		session_start();
		$_SESSION['valid_user']=$LogName;
		break;
		default:
		break;
		
	}	
}else {  

	//header('Location: http://localhost/demo/index.htm');
    exit('登录失败！请重试');  

	
}  
mysqli_close($conn);
//echo($_SESSION['valid_user']);
?>