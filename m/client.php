<?php
session_start();
/*
 * 
 * 
 * do session check here too
 * 
 * 
 */
include_once '../include/config.php';

if (!isset($_GET['cid'])) {
    error_log("[App Error] client.php no cid passing in!", 0);
    header('Location: ./index.php');
    return 1;
}
$cid = $_GET['cid'];
$_SESSION['cid'] = $cid;

$mysqli = new mysqli($db_server, $db_username, $db_pswd, $db_database);
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
$sql = "SELECT c.name, sum(t.credit) as cr, sum(t.debit) as de,
            sum(t.bad) as bad
            FROM   CLIENT as c inner join TRANSC as t
                on c.oid=t.oid and c.cid=t.cid
            WHERE c.oid='" . $_SESSION['oid'] . "' and c.cid='$cid'";

$result_total = $mysqli->query($sql);

$row = $result_total->fetch_array(MYSQLI_ASSOC);
$cname = $row['name'];
$de = number_format((float) $row['de'], 2, '.', '');
$cr = number_format((float) $row['cr'], 2, '.', '');

$bad = number_format((float) $row['bad'], 2, '.', '');
$bala = number_format((float) ($row['de'] - $row['cr'] - $row['bad']), 2, '.', ''); //balance
/* free result set */
$result_total->free();
?>



<html>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css">
    <script src="../js/jquery-1.11.3.min.js"></script>
    <script src="js/jquery.mobile-1.4.5.min.js"></script>
    <link rel="stylesheet" href="css/mstyle.css"/>
    <script src="js/mclient.js" type="text/javascript"></script>
    <link href="css/popup.css" rel="stylesheet" type="text/css"/>


    <body>
        <div data-role="page" id="pageone">
            <div data-role="header">
                <h1><?php
                    echo $cname;
                    echo " 未收:$bala"
                    ?></h1>
            </div>
            <div data-role="main"  class="ui-content">
                <table id="detail" data-role="table" class="ui-responsive ui-shadow">
                    <thead>
                        <tr>
                            <th></th>
                            <th >应收</th>
                            <th data-priority="2">已收</th>
                            <th data-priority="3">坏账</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="sum_row">
                            <td class="client">合计</td>
                            <td class="data1"><?php echo $de ?></td>
                            <td class = "data1"><?php echo $cr ?></td>


                            <td class = "data1"><?php echo $bad ?></td>

                        </tr>
                        <?php
                        $sql_client = "SELECT t.tid, t.date, t.credit as cr, t.debit as de,
                                    t.bad as bad
                                    FROM CLIENT as c inner join TRANSC as t on  
                                    c.oid=t.oid and c.cid=t.cid 
                                    WHERE c.oid='" . $_SESSION['oid'] . "' 
                                    and c.cid='$cid' 
                                    Order by t.date asc";
                        $result_c = $mysqli->query($sql_client);


                        while ($row = $result_c->fetch_array(MYSQLI_ASSOC)) {

                            $tid = $row['tid'];
                            $t_date = $row['date'];
                            $de_c = number_format((float) $row['de'], 2, '.', '');
                            $cr_c = number_format((float) $row['cr'], 2, '.', '');

                            $bad_c = number_format((float) $row['bad'], 2, '.', '');
                            $bala_c = number_format((float) ($row['de'] - $row['cr'] - $row['bad']), 2, '.', ''); //balance
                            echo "<tr id='row$tid'>";
                            echo "<td class ='date data'>$t_date</td>";
                            echo "<td class='data' id='de$tid'  >$de_c</td>";
                            echo "<td class='data' id='cr$tid'  >$cr_c</td>";
                            echo "<td class='data' id='bd$tid'  > $bad_c</td>";
                            echo "</tr>";
                            //echo "&nbsp<a  href='javascript:void(0)' onClick=\"addRow('$tid')\">添加</a></td>";
                        }

                        /* free result set */
                        $result_c->free();
                        ?>
                    </tbody>
                </table>
            </div>
            <div  class="center-wrapper">
                <a href="#myPopup" data-rel="popup" 
                   class="ui-btn ui-btn-inline ui-corner-all"
                   style="background: #1adb34;color:white"
                   data-position-to="window">记一笔</a>
            </div>
            <div data-role="popup" id="myPopup" class="">

                <label for="de" >应收:</label>
                <input type="number" name="de" id="deNew">
                <label for="cr" >已收:</label>
                <input type="number" name="cr" id="crNew">
                <label for="bad" >坏账:</label>
                <input type="number" name="bad" id="badNew">
                <div  class="center-wrapper">
                    <a href='javascript:void(0)' onClick="saveNewRecd()"
                       class="ui-btn ui-btn-inline ui-corner-all"
                       style="background: #1adb34;color:white"
                       >保存</a>
                </div>
            </div>
            <div data-role="footer">
                <h1 id='date'>  <?php echo date("Y-m-d H:i:s"); ?> </h1>
            </div>
        </div>


        <div id="waitpopup">
            <div id="waitpopup-wrapper">
                正在保存,请等待... 
            </div>
            <div id="loader"></div>
            <div id="backgroundPopup"></div>

        </div> 
    </body>
</html>


<?php
/* close connection */
$mysqli->close();
?>

