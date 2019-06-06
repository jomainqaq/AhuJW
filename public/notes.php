<?php


session_start();
if (isset($_SESSION['valid_user'])) { } else {
    header('Location: http://localhost/demo/');
}

$q = $_GET["q"];
// 将姓名填充到数组中
switch ($q) {
    case 0:
        logOut();//返回初始页面，销毁session
        break;
    case 1:
        outPutNotes(); //出现公告
        break;
    case 2:
        outPutChange(); //修改密码
        break;
    case 3:
        outPutDetailStu(); //输出学生信息
        break;
    case 4:
        outPutSouceStu(); //显示学生已选课程
        break;
    case 5:
        showGradeStu();
        break;
}

function logOut()
{
    echo"
    <meta http-equiv=\"refresh\" content=\"0;url='index.htm'\"> 
";
  
    session_destroy();
    //header('Location: http://localhost/demo/index.htm ');
}


function outPutNotes()
{
    //输出公告

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "demo01";
    //创建连接

    //$q=$_GET["q"];


    // 设置编码，防止中文乱码

    $sql = 'SELECT Notes_title, Notes_author, 
        Notes_date
        FROM Notes';
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    mysqli_query($conn, "set names utf8");
    if (!$conn) {
        die('Could not connect database: ' . mysql_error());
    }
    $retval = mysqli_query($conn, $sql);
    if (!$retval) {
        die('无法读取数据: ' . mysqli_error($conn));
    }
    echo '
<div class="container">
<h2 style="text-align: center">公告</h2>      
<table class="table table-hover table-bordered">
<thead>
<tr>
  <th>公告标题</th>
  <th>发布单位</th>
  <th>时间</th>
</tr>
</thead>
<tbody>';
    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        echo "<tr><td> {$row['Notes_title']}</td> " .
            "<td>{$row['Notes_author']} </td> " .
            "<td>{$row['Notes_date']} </td> " .
            "</tr>";
    }
    echo '</tbody>
</table>
</div>';

    mysqli_close($conn);
}

function outPutChange()
{

    echo '

<div class="container">
    <h2>修改密码</h2>
    <form name="changepwd" action="public/changepwd.php"  method="POST">
        <div class="form-group">
            <label for="pwd">Old Password:</label>
            <input type="text" class="form-control" id="opwd" name="opwd" placeholder="Old Password">
        </div>
        <div class="form-group">
            <label for="pwd">New Password:</label>
            <input type="password" class="form-control" id="pwd" name="pwd" placeholder="New Password" onkeyup="checkpwd()">
        </div>
        <div class="form-group">
            <label for="pwd">Confirm Password:</label>
            <input type="password" class="form-control" id="npwd" name="npwd" placeholder="Confirm Password" onkeyup="checkpwd()">
            <span id="tishi"></span>
        </div>
        <button type="submit" id="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
';
}


function outPutDetailStu()
{
    $nameee = $_SESSION['valid_user'];
    //输出学生信息

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "demo01";
    //创建连接

    // 设置编码，防止中文乱码

    $sql = "SELECT sno, sname, ssex,sage,
            sdept
            FROM student WHERE sno=$nameee";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    mysqli_query($conn, "set names utf8");
    if (!$conn) {
        die('Could not connect database: ' . mysql_error());
    }
    $retval = mysqli_query($conn, $sql);
    if (!$retval) {
        die('无法读取数据: ' . mysqli_error($conn));
    }
    echo '
<div class="container">
<h2 style="text-align: center">个人信息</h2>      
<table class="table table-hover table-bordered">
  <thead>
    <tr>
      <th>学号</th>
      <th>姓名</th>
      <th>性别</th>
      <th>年龄</th>
      <th>专业</th>
    </tr>
  </thead>
  <tbody>';
    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        echo "<tr><td> {$row['sno']}</td> " .
            "<td>{$row['sname']} </td> " .
            "<td>{$row['ssex']} </td> " .
            "<td>{$row['sage']} </td> " .
            "<td>{$row['sdept']} </td> " .
            "</tr>";
    }
    echo '</tbody>
</table>
</div>';

    mysqli_close($conn);
}

//显示学生已选课程
function outPutSouceStu()
{
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "demo01";
    //创建连接


    $nameee = $_SESSION['valid_user'];
    // 设置编码，防止中文乱码

    $sql = "  SELECT sc.sno,sname,cno,tname FROM sc,student,teacher where student.sno=sc. sno and sc.sno = $nameee  and teacher.tno=sc.tno;";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    mysqli_query($conn, "set names utf8");
    if (!$conn) {
        die('Could not connect database: ' . mysql_error());
    }
    $retval = mysqli_query($conn, $sql);
    if (!$retval) {
        die('无法读取数据: ' . mysqli_error($conn));
    }
    echo '
<div class="container">
<h2 style="text-align: center">已选课程</h2>      
<table class="table table-hover table-bordered">
  <thead>
    <tr>
      <th>学号</th>
      <th>学生姓名</th>
      <th>课程号</th>
      <th>授课教师</th>
    </tr>
  </thead>
  <tbody>';
    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        echo "<tr><td> {$row['sno']}</td> " .
            "<td>{$row['sname']} </td> " .
            "<td>{$row['cno']} </td> " .
            "<td>{$row['tname']} </td> " .
            "</tr>";
    }
    echo '</tbody>
</table>
</div>';

    mysqli_close($conn);
}

//显示学生成绩
function showGradeStu()
{
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "demo01";
    //创建连接


    $nameee = $_SESSION['valid_user'];
    // 设置编码，防止中文乱码

    $sql = "  SELECT sc.sno,sname,cno,tname,grade FROM sc,student,teacher where student.sno=sc. sno and sc.sno = $nameee  and teacher.tno=sc.tno;";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    mysqli_query($conn, "set names utf8");
    if (!$conn) {
        die('Could not connect database: ' . mysql_error());
    }
    $retval = mysqli_query($conn, $sql);
    if (!$retval) {
        die('无法读取数据: ' . mysqli_error($conn));
    }
    echo '
<div class="container">
<h2 style="text-align: center">已选课程</h2>      
<table class="table table-hover table-bordered">
<thead>
<tr>
  <th>学号</th>
  <th>学生姓名</th>
  <th>课程号</th>
  <th>授课教师</th>
  <th>成绩</th>
</tr>
</thead>
<tbody>';
    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        echo "<tr><td> {$row['sno']}</td> " .
            "<td>{$row['sname']} </td> " .
            "<td>{$row['cno']} </td> " .
            "<td>{$row['tname']} </td> " .
            "<td>{$row['grade']} </td> " .
            "</tr>";
    }
    echo '</tbody>
</table>
</div>';

    mysqli_close($conn);
}
