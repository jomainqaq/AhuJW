<?php
session_start();
if (isset($_SESSION['valid_user'])) {
    $usid = $_SESSION['valid_user'];
} else {
    header('Location: http://localhost/demo/');
}


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "demo01";

$stuID = $_POST['stu']; //学号
$scnoo = $_POST['scno']; //课程号
$stuGrade = $_POST['mark']; //分数



$arryLongth = count($scnoo);



$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die('Could not connect database: ' . mysql_error());
}

// $sql = "UPDATE sc SET grade = '40' WHERE sno='201216121' and cno ='1'; 
// ";
// if (mysqli_query($conn, $sql)) {
//     echo "success";
// }
for ($i = 0; $i < $arryLongth; $i++) {
    $sql = "UPDATE sc SET grade = $stuGrade[$i] WHERE sno=$stuID[$i] and cno =$scnoo[$i];";
    if(mysqli_query($conn,$sql)){
        echo "succed";
       // header('Location: http://localhost/demo/teacher.php');
    }

 }
 //输出写入成功并且返回教师页面
 echo'
 <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="student_files\student_css.css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.12.5/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <title>教务系统</title>
    <style>
        html {
            position: relative;
            min-height: 100%;
        }

        body {
            /* Margin bottom by footer height */
            margin-bottom: 60px;
        }
    </style>
</head>
<body>
 <script >
      alert("成绩录入成功") 
      </script>
      </body>
      <script type="text/javascript">

        setTimeout("window.location.href=\'../teacher.php\'",0);
        
      
      </script>';
?>