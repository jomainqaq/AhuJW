<?php
session_start();
if (isset($_SESSION['valid_user'])) {
    $usid = $_SESSION['valid_user'];
} else {
    header('Location: http://localhost/demo/');
}
header('Content-Type:text/html; charset=utf-8');

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "demo01";

$title=$_POST['title'];
$author=$_POST['author'];
$notes=$_POST['notes'];



echo $title.$author.$notes;


$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die('Could not connect database: ' . mysql_error());
}

mysqli_query($conn , "set names utf8");
//当前日期
$dayNow= date("Ymd");

$sql = "INSERT INTO notes (Notes_title,Notes_author,Notes_date,Notes_artical)
values('$title','$author','$dayNow','$notes');";

if(mysqli_query($conn,$sql)){
    echo "succed";
   // header('Location: http://localhost/demo/teacher.php');
}
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
     alert("公告发布成功") 
     </script>
     </body>
     <script type="text/javascript">

       setTimeout("window.location.href=\'../admin.php\'",0);
       
     
     </script>';