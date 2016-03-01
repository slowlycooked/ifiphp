<?php
include_once 'include/dbcon.php';
include_once 'include/func.php';
sec_session_start();
if (login_check($mysqli) == false) {
    header('Location: index.php');
}

include_once 'config/config.php';

$mysqli = new mysqli($server, $user_name, $password, $database);
/* check connection */
if (mysqli_connect_errno()) {
    printf("错误：Connect failed: %s\n", mysqli_connect_error());
    exit();
}
/* change character set to utf8 */
if (!$mysqli->set_charset("utf8")) {
    printf("错误： loading character set utf8: %s\n", $mysqli->error);
    exit();
} 

//echo "in";
$sql = "SELECT cid, name from CLIENT where oid=".$_SESSION['oid'];

$result = $mysqli->query($sql);


?>
<html>
 <meta http-equiv = 'Content-Type' content = 'text/html; charset=utf-8' />

    <link rel = "stylesheet" type = "text/css" media = "screen" href = "css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/popup.css">

    <script type='text/javascript' src='js/jquery-1.10.2.min.js'></script>
    <script type='text/javascript' src="js/jquery.form.min.js"></script> 
    <script type='text/javascript' src='js/jquery.validate.min.js'></script>
    <script type='text/javascript' src='js/ifi_maintain.js'></script>
    
   

    <body>
        <div id = "wrapper">
            <p id="date"><?php echo date('Y年m月d日');?> </p>
                
            <a class="css_btn_class" style="float:right" href="home.php"> 返回主页</a>
            <br />
            <br />

            <table class="sum">
                <thead>
                    <tr>
                        <th scope="col" >CID</th>
                        <th scope="col" >客户名</th>
                        <th scope="col" >管理</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                   <?php
                   while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                        $cid =$row['cid'];
                        $cname = $row['name'];
                        echo "<tr>";
                        echo "<td class =''>$cid</td>";
                        echo "<td class =''>$cname</td>";
                        echo "<td class =''><a href='javascript:void(0)' onclick=\"deleteClient('$cid')\">删除</a>
                            &nbsp <a href='' onclick=\"edit('$cid')\">编辑</a></td>";
                    }
                    /* free result set */
                   $result->free();
                    
                    ?>
                    </tr>
                  
                </tbody>
            </table>
            
            
    
        </div>
    </body>
</html>
