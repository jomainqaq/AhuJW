<?php


session_start();
if (isset($_SESSION['valid_user'])) { } else {
    header('Location: http://localhost/demo/');
}

$q = $_GET["q"];
// 将姓名填充到数组中
switch ($q) {
    case 0:
        logOut(); //返回初始页面，销毁session
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
        showGradeStu(); //显示学生成绩
        break;
    case 6:
        gradeInputTeacher(); //录入成绩
        break;
    case 7:
        outPutTeacherDetail(); //输出教师信息
        break;
    case 8:
        outPutSelectCourse(); //学生选课
        break;
    case 9:
        outPutCourseStu(); //输出选课学生
        break;
    case 10:
        outPutCourseStuGrade(); //输出学生成绩
        break;
    case 11:
        inputNotes(); //输入公告
        break;
    case 12:
        changePWDAdmin(); //管理员修改密码
        break;
    case 13:
        inputSourse();
        break;
    default:
        break;
}

function logOut()
{
    echo "
    <meta http-equiv=\"refresh\" content=\"0;url='index.htm'\"> 
";

    session_destroy();
    //header('Location: http://localhost/demo/index.htm ');
}



//输出公告
function outPutNOtes()
{
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "demo01";
    //创建连接

    // 设置编码，防止中文乱码

    $sql = 'SELECT NotesId,Notes_title, Notes_author, 
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
        echo "<tr><td> <a  href=\"javascript:void(0);\" onclick=\"showNotesDetal({$row['NotesId']})\">{$row['Notes_title']}</a>
   </td> " .
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

//输出学生详细信息
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

//录入成绩
function gradeInputTeacher()
{
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "demo01";
    //创建连接
    $nameee = $_SESSION['valid_user'];
    // 设置编码，防止中文乱码

    $sql = "   SELECT student.sno,sname, course.cno,course.cname , cteacher,ccredit, grade
     from student,sc,course,teacher 
     where teacher.tno =$nameee and teacher.tno=sc.tno and course.cno=sc.cno and student.sno=sc.sno;
    ";
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
<form action="teacher_files\inputGrade.php"  method="POST" >
<div class="container">
<h2 style="text-align: center">成绩录入</h2>      
<table class="table table-hover table-bordered">
  <thead>
    <tr>
      <th>学号</th>
      <th>姓名</th>
      <th>课程号</th>
      <th>课程名</th>
      <th>授课教师</th>
      <th>学分</th>
      <th>分数</th>
    </tr>
  </thead>
  <tbody>';
    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        echo "<tr><td width=\"200px\"> <input type=\"text\" class=\"input-small\" name=\"stu[]\" value= {$row['sno']} readonly=\"true\"></td> " .
            "<td>{$row['sname']} </td> " .
            "<td width=\"200px\"> <input type=\"text\" class=\"input-small\" name=\"scno[]\" value= {$row['cno']} readonly=\"true\"></td>" .
            "<td>{$row['cname']} </td> " .
            "<td>{$row['cteacher']} </td> " .
            "<td>{$row['ccredit']} </td> " .
            "<td width=\"200px\"> <input type=\"text\" class=\"input-small\" name=\"mark[]\" placeholder=\"成绩\"> </td> " .
            "</tr>";
    }
    echo '</tbody>
</table>
<button style="float:right" type="submit" id="submit" class="btn btn-sm">Submit</button>
</div>
</form>';

    mysqli_close($conn);
}

//输出教师详细信息
function outPutTeacherDetail()
{
    $nameee = $_SESSION['valid_user'];
    //输出学生信息

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "demo01";
    //创建连接

    // 设置编码，防止中文乱码

    $sql = "SELECT tno, tname, tsex,tage
            FROM teacher WHERE tno=$nameee";
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
      <th>工号</th>
      <th>姓名</th>
      <th>性别</th>
      <th>年龄</th>
    </tr>
  </thead>
  <tbody>';
    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        echo "<tr><td> {$row['tno']}</td> " .
            "<td>{$row['tname']} </td> " .
            "<td>{$row['tsex']} </td> " .
            "<td>{$row['tage']} </td> " .
            "</tr>";
    }
    echo '</tbody>
</table>
</div>';

    mysqli_close($conn);
}

//输出选课
function outPutSelectCourse()
{
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "demo01";
    //创建连接


    $nameee = $_SESSION['valid_user'];
    // 设置编码，防止中文乱码

    $sql = "  SELECT cno , cname, cteacher,ccredit from course;";
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
    <h2 style="text-align: center">选课</h2>      
    <table class="table table-hover table-bordered">
    <thead>
    <tr>
      <th>课程编号</th>
      <th>课程名</th>
      <th>授课教师</th>
      <th>学分</th>
      <th>选课</th>
    </tr>
    </thead>
    <tbody>';
    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        $sqll = "SELECT  sc.cno from  sc,course  WHERE course.cno=sc.cno and sc.cno={$row['cno']}";
        $check_query = mysqli_query($conn, $sqll);
        if ($result = mysqli_num_rows($check_query)) {
            echo "<tr><td> {$row['cno']}</td> " .
                "<td>{$row['cname']} </td> " .
                "<td>{$row['cteacher']} </td> " .
                "<td>{$row['ccredit']} </td> " .
                "<td width=\"200px\"> 
                    <button  type=\"button\" onclick=\"CourseDelete({$row['cno']})\" class=\"btn\">退课</button>
                    </td> 
                    " .
                "</tr>";
        } else {
            echo "<tr><td> {$row['cno']}</td> " .
                "<td>{$row['cname']} </td> " .
                "<td>{$row['cteacher']} </td> " .
                "<td>{$row['ccredit']} </td> " .
                "<td width=\"200px\"> <button type=\"button\" onclick=\"CourseSelect({$row['cno']}) \" class=\"btn\">选课</button>
                
                </td> 
                " .
                "</tr>";
        }
    }
    echo '</tbody>
    </table>
    </div>';

    mysqli_close($conn);
}

function outPutCourseStu()
{
    $nameee = $_SESSION['valid_user'];
    //输出学生信息

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "demo01";
    //创建连接

    // 设置编码，防止中文乱码

    $sql = "SELECT sc.sno,student.sname, sc.cno, course.cname
            FROM sc,course,student WHERE sc.tno=$nameee and sc.cno=course.cno and sc.sno=student.sno ";
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
<h2 style="text-align: center">学生信息</h2>      
<table class="table table-hover table-bordered">
  <thead>
    <tr>
      <th>学号</th>
      <th>姓名</th>
      <th>课程号</th>
      <th>课程</th>
    </tr>
  </thead>
  <tbody>';
    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        echo "<tr><td> {$row['sno']}</td> " .
            "<td>{$row['sname']} </td> " .
            "<td>{$row['cno']} </td> " .
            "<td>{$row['cname']} </td> " .
            "</tr>";
    }
    echo '</tbody>
</table>
</div>';

    mysqli_close($conn);
}

//输入公告页面
function outPutCourseStuGrade()
{
    $nameee = $_SESSION['valid_user'];
    //输出学生信息

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "demo01";
    //创建连接

    // 设置编码，防止中文乱码

    $sql = "SELECT sc.sno,student.sname, sc.cno, course.cname,sc.grade
            FROM sc,course,student WHERE sc.tno=$nameee and sc.cno=course.cno and sc.sno=student.sno ";
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
<h2 style="text-align: center">学生信息</h2>      
<table class="table table-hover table-bordered">
  <thead>
    <tr>
      <th>学号</th>
      <th>姓名</th>
      <th>课程号</th>
      <th>课程</th>
      <th>成绩</th>
    </tr>
  </thead>
  <tbody>';
    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        echo "<tr><td> {$row['sno']}</td> " .
            "<td>{$row['sname']} </td> " .
            "<td>{$row['cno']} </td> " .
            "<td>{$row['cname']} </td> " .
            "<td>{$row['grade']} </td> " .
            "</tr>";
    }
    echo '</tbody>
</table>
</div>';

    mysqli_close($conn);
}

//输入公告
function inputNotes()
{
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "demo01";
    //创建连接
    $nameee = $_SESSION['valid_user'];
    // 设置编码，防止中文乱码

    $sql = "   SELECT student.sno,sname, course.cno,course.cname , cteacher,ccredit, grade
     from student,sc,course,teacher 
     where teacher.tno ='1001' and teacher.tno=sc.tno and course.cno=sc.cno and student.sno=sc.sno;
    ";
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
<div class="container mt-3">
  <h3>输入框组</h3>
  
  
  <form action="admin_files/inputNotes.php" method="POST">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">标题</span>
      </div>
      <input type="text" class="form-control" placeholder="标题" id="usr" name="title">
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">单位</span>
      </div>
      <input type="text" class="form-control" placeholder="单位" id="usr" name="author">
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">内容</span>
      </div>
      <textarea style="height:150px;" type="text" class="form-control" placeholder="内容" id="usr" name="notes"></textarea>
    </div>

   
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
';

    mysqli_close($conn);
}
//管理员修改密码
function changePWDAdmin()
{
    echo '

    <div class="container">
    <h2>修改密码</h2>
    <form name="changepwd" action="admin_files/changePwd.php" method="POST">
        <div class="form-group">
            <label for="pwd">User Name:</label>
            <input type="text" class="form-control" id="opwd" name="usernames" placeholder="User Name">
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

function inputSourse()
{
    echo '
    <div class="container">
    <h2>课程录入</h2>
    <form action="admin_files/inputSourse.php"  method="POST">
        <div class="form-group">
            <label for="text">课程编号:</label>
            <input type="text" class="form-control" id="cno" name="cno" placeholder="Enter 课程编号">
        </div>
        <div class="form-group">
            <label for="text">课程名:</label>
            <input type="text" class="form-control" id="cname" name="cname" placeholder="Enter 课程名">
        </div>
        <div class="form-group">
            <label for="text">教师名:</label>
            <input type="text" class="form-control" id="cteacher" name="cteacher" placeholder="Enter 教师名">
        </div>
        <div class="form-group">
            <label for="text">学分:</label>
            <input type="text" class="form-control" id="ccredit"  name="ccredit" placeholder="Enter 学分">
        </div>
       
           
      
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

';
}
