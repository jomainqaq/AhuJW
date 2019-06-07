<?php

session_start();
if (isset($_SESSION['valid_user'])) { } else {
    header('Location: http://localhost/demo/');
}

$q = $_GET["q"];

$nameee = $_SESSION['valid_user'];
//输出学生信息

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "demo01";
//创建连接

// 设置编码，防止中文乱码

$sql = "SELECT Notes_artical from notes WHERE NotesId=$q";


$conn = mysqli_connect($servername, $username, $password, $dbname);
mysqli_query($conn, "set names utf8");
if (!$conn) {
    die('Could not connect database: ' . mysql_error());
}
$retval = mysqli_query($conn, $sql);
if (!$retval) {
    die('无法读取数据: ' . mysqli_error($conn));
}

while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
   
        echo $row['Notes_artical'];
}


mysqli_close($conn);
