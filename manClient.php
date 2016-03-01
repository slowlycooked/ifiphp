<?php
include_once 'include/dbcon.php';
include_once 'include/func.php';
sec_session_start();
if (login_check($mysqli) == false) {
    header('Location: index.php');
}
//echo "in";
$soid = $_SESSION['oid'];
$sbid = $_SESSION['bid'];

$sql_getBname = "SELECT BNAME FROM BOOKS WHERE OID='$soid' and BID='$sbid'";
$res_bname = $mysqli->query($sql_getBname);
$row = $res_bname->fetch_array(MYSQLI_ASSOC);
$bname = $row['BNAME'];

$sql = "SELECT CID, NAME FROM CLIENT "
        . "WHERE OID='$soid' AND BID='$sbid'";
$result = $mysqli->query($sql);
?>
<html>
    <title>管理项目（客户）</title>

    <meta http-equiv = 'Content-Type' content = 'text/html; charset=utf-8' />

    <link rel = "stylesheet" type = "text/css" media = "screen" href = "css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/popup.css">

    <script type='text/javascript' src='js/jquery-1.10.2.min.js'></script>
    <script type='text/javascript' src="js/jquery.form.min.js"></script> 
    <script type='text/javascript' src='js/jquery.validate.min.js'></script>
    <script type='text/javascript' src='js/ifi_maintain.js'></script>

    <link rel="stylesheet" href="css/menu.css">
    <script src="js/menu.js"></script>

    <body>
        <div id = "wrapper">
            <p>当前账本： <?php echo $bname; ?></p>
            <div id='cssmenu'>
                <ul>
                    <li><a href='home.php'>主页</a></li>
                    <li class='active'><a href='#'>管理</a>
                        <ul>
                            <li><a href='manBook.php'>添加新账本</a>
                            </li>
                            <li><a href="manClient.php">删除项目（客户）</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>


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
    $cid = $row['CID'];
    $cname = $row['NAME'];
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
