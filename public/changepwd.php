<?php 
session_start();
if(isset($_SESSION['valid_user']))
{
    $usid=$_SESSION['valid_user'];
}
else{
    header('Location: http://localhost/demo/');
}


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "demo01";

$OldPwd=$_POST['opwd'];
$Pwd=$_POST['pwd'];
$NewPwd=$_POST['npwd'];

if($OldPwd == null or $Pwd == null or $NewPwd==null){
	exit('不能为空');
}

$conn = mysqli_connect($servername,$username,$password,$dbname);

if (!$conn) 
	{ 
		die('Could not connect database: ' . mysql_error()); 
    } 

    $check_query = mysqli_query($conn,"select User_id from Users where User_Name ='$usid' and User_Passwd ='$OldPwd' limit 1");     
    if($result = mysqli_num_rows($check_query)){
       
       mysqli_query($conn,"UPDATE Users SET User_Passwd = '$Pwd' WHERE User_Name='$usid'");
        echo'<script type="text/javascript">

        setTimeout("window.location.href=\'../index.htm\'",3000);
        
      
      </script>';
      echo"<script >
      alert('密码修改成功') 
      </script>
      ";
     
        session_destroy();

    
    }else {  
    
        //header('Location: http://localhost/demo/index.htm');
        exit('登录失败！请重试');  
    
    }  


?>


