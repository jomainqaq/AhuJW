<?php
//学生界面总表
//确认session
session_start();
if (isset($_SESSION['valid_user'])) { }
// else{
//     header('Location: http://localhost/demo/');
// }


?>

<?php

//输出公告
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

?>

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


    <div class="header" style="height:80px">
        <img src="http://localhost/demo/index_files/logo.png" class="img-rounded" style="border:none;float: left;" height="50">
        <img src="http://localhost/demo/student_files/logo_jw.png" class="img-rounded" style="border:none;float: left;" height="50">



        <p style="float:right"><i class="fa fa-user" aria-hidden="true"></i> 用户:<?php echo $_SESSION['valid_user'] ?>
        </p>


    </div>
    <nav class="navbar navbar-expand-sm bg-secondary navbar-dark  ">
        <!-- Brand -->
        <a class="navbar-brand active " href="http://localhost/demo/">安徽大学</a>

        <!-- Links -->
        <ul class="navbar-nav">

            <a class="nav-link" href="javascript:void(0);" onclick="showHint(1)">公告</a>


            <!-- Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle " href="#" id="navbardrop" data-toggle="dropdown">
                    网上选课
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item " href="javascript:void(0);" onclick="showHint(1)">学生选课</a>
                    <a class="dropdown-item " href="#">辅修选课</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle " href="#" id="navbardrop" data-toggle="dropdown">
                    学生成绩
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item " href="javascript:void(0);" onclick="showHint(6)">成绩录入</a>
                    <a class="dropdown-item " href="#">缓考申请</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle " href="#" id="navbardrop" data-toggle="dropdown">
                    信息维护
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item " href="javascript:void(0);" onclick="showHint(7)">个人信息修改</a>
                    <a class="dropdown-item " href="javascript:void(0);" onclick="showHint(2)">密码修改</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle " href="#" id="navbardrop" data-toggle="dropdown">
                    信息查询
                </a>
                <div class="dropdown-menu">

                    <a class="dropdown-item " href="javascript:void(0);" onclick="showHint(9)">课程学生查询</a>

                    <a class="dropdown-item " href="javascript:void(0);" onclick="showHint(10)">学生成绩查询</a>





                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle " href="#" id="navbardrop" data-toggle="dro pdown">
                    毕业论文管理
                </a>

            </li>

        </ul>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav" style="float:right">
                <li><a href="javascript:void(0);" onclick="showHint(0)" class="nav-link"><i class="fa fa-sign-out " aria-hidden="true"></i> 登出</a></li>
            </ul>
        </div>
        <p class="color:red"></p>
    </nav>



    <div id="bodysss">

        <?php
        outPutNOtes();

        ?>




    </div>









    <footer class="footer">
        <div class="container">
            <div style='clear:both;text-align:center;'>
                版权 © ahu.edu.cn</div>
        </div>
    </footer>

    <script>
        //检查两次密码是否相同，因颜色问题，暂时放在这里
        function checkpwd() {
            var new1 = document.getElementById("pwd").value;
            var new2 = document.getElementById("npwd").value;
            if (new1 == new2) {
                document.getElementById("tishi").innerHTML = "<p style='color:green'> 两次密码相同</p>";
                document.getElementById("submit").disabled = false;
            } else {
                document.getElementById("tishi").innerHTML = "<p style='color:red'>两次密码不同 </p>";
                document.getElementById("submit").disabled = true;
            }
        }
    </script>
    <script>
        function showHint(str) {

            //ajax 调用php
            if (window.XMLHttpRequest) {
                // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行的代码
                xmlhttp = new XMLHttpRequest();
            } else {
                //IE6, IE5 浏览器执行的代码
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("bodysss").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "public/notes.php?q=" + str, true);
            xmlhttp.send()

        }

        function showNotesDetal(str) {

            //ajax 调用php
            if (window.XMLHttpRequest) {
                // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行的代码
                xmlhttp = new XMLHttpRequest();
            } else {
                //IE6, IE5 浏览器执行的代码
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    //document.getElementById("bodysss").innerHTML=xmlhttp.responseText;
                    alert(xmlhttp.responseText);
                }
            }
            xmlhttp.open("GET", "public/showNotesDetal.php?q=" + str, true);
            xmlhttp.send()

        }
    </script>

</body>

</html>