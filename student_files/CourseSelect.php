<?php
session_start();
if (isset($_SESSION['valid_user'])) { } else {
    header('Location: http://localhost/demo/');
}

$q = $_GET["q"];

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "demo01";
//创建连接
$nameee = $_SESSION['valid_user'];
// 设置编码，防止中文乱码
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die('Could not connect database: ' . mysql_error());
}

$sqll = "SELECT tno from teacher,course where course.cteacher = teacher.tname and course.cno = $q;
";

$result = mysqli_query($conn, $sqll);
while ($row = mysqli_fetch_assoc($result)) {
    //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    $tnoo = $row['tno'];
}


$sql = "  INSERT INTO sc (sno,cno,tno) values($nameee,$q,$tnoo);
    ";

$check_query = mysqli_query($conn, $sql);
if ($check_query) {
echo"
<div class=\"container\">
<div class=\"card\"   >
    <div class=\"card-body\"> <p style=\"text-align:center;\">选课成功</p></div>
    <button  type=\"button\" class=\"btn\" onclick=\"showHint(8)\">确定</button>
  </div>
  </div>



";

}else
{
echo"选课失败";
}
   

    mysqli_close($conn);
?>