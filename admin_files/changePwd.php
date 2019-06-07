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

$usernameid=$_POST['usernames'];
$Pwd=$_POST['pwd'];
$NewPwd=$_POST['npwd'];

if($usernameid == null or $Pwd == null or $NewPwd==null){
	exit('不能为空');
}

$conn = mysqli_connect($servername,$username,$password,$dbname);

if (!$conn) 
	{ 
		die('Could not connect database: ' . mysql_error()); 
    } 


    $sql ="UPDATE Users SET User_Passwd = '$Pwd' WHERE User_Name='$usernameid'";
    $check_query = mysqli_query($conn,$sql);     
    if($check_query){
       
        echo'<script type="text/javascript">

        setTimeout("window.location.href=\'../admin.php\'",0);
        
      
      </script>';
      echo"<script >
      alert('密码修改成功') 
      </script>
      ";
     
       

    
    }else {  
    
        //header('Location: http://localhost/demo/index.htm');
        exit('登录失败！请重试');  
    
    }  


?>

