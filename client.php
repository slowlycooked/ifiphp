<?php
include_once 'include/dbcon.php';
include_once 'include/func.php';
sec_session_start();


if (login_check($mysqli) == true) {
    if (!isset($_GET['cid'])) {
        error_log("[App Error] client.php no cid passing in!", 0);
        header('Location: ./home.php');
        return 1;
    }
    $cid = filter_input(INPUT_GET, 'cid');
    $_SESSION['cid'] = $cid;
    
#    debug("OID:".$_SESSION['oid']." BID:".$_SESSION['bid']." CID:".$cid);
//echo "in";
    $sql = "SELECT C.NAME, SUM(T.CREDIT) AS CR, SUM(T.DEBIT) AS DE,
            SUM(T.BAD) AS BAD
            FROM   CLIENT AS C INNER JOIN TRANSC AS T
                ON C.OID=T.OID AND C.BID=T.BID AND C.CID=T.CID
            WHERE C.OID='" . $_SESSION['oid'] . "' "
            . " AND C.BID='" . $_SESSION['bid'] . "' "
            . " AND C.CID='$cid'";

#    debug($sql);
    $result_total = $mysqli->query($sql);

    $row = $result_total->fetch_array(MYSQLI_ASSOC);
    $cname = $row['NAME'];
    $de = number_format((float) $row['DE'], 2, '.', '');
    $cr = number_format((float) $row['CR'], 2, '.', '');

    $bad = number_format((float) $row['BAD'], 2, '.', '');
    $bala = number_format((float) ($row['DE'] - $row['CR'] - $row['BAD']), 2, '.', ''); //balance
    /* free result set */
    $result_total->free();
} else {
    header('Location: index.php');
}
?>



<html>
    <meta http-equiv = 'Content-Type' content = 'text/html; charset=utf-8' />
    <link rel="stylesheet" type="text/css" media="screen" href="css/popup.css">
    <link rel = "stylesheet" type = "text/css" media = "screen" href = "css/style.css">

    <script type='text/javascript' src='js/jquery-1.10.2.min.js'></script>
    <script type='text/javascript' src='js/jquery.jeditable.js'></script>
    <script type='text/javascript' src="js/jquery.form.min.js"></script> 
    <script type='text/javascript' src='js/jquery.validate.min.js'></script>
    <script type='text/javascript' src='js/jquery-dateFormat.js'></script>
    <script type='text/javascript' src='js/ifi_client.js'></script>
    <link rel="stylesheet" href="css/menu.css">
    <script src="js/menu.js"></script>


    <body>
        <div id = "wrapper">
            <div id='cssmenu'>
                <ul>
                    <li><a href='home.php'>主页</a></li>
                    <li class='active'><a href='#'>管理</a>
                        <ul>
                            <li><a href="manClient.php">删除项目（客户）</a>
                            </li>
                            <li><a href='manBook.php'>添加新账本</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>



            <table class="sum">
                <thead>
                    <tr>
                        <th id='clientname' scope="col" ><?php echo $cname; ?>

                        </th>
                        <th scope="col" >应收</th>
                        <th scope="col" >已收</th>

                        <th scope="col" >坏账</th>
                        <th scope="col" >未收</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="sum_row">
                        <td class="client">合计</td>
                        <td class="data"><?php echo $de ?></td>
                        <td class = "data"><?php echo $cr ?></td>


                        <td class = "data"><?php echo $bad ?></td>
                        <td class = "data"><?php echo $bala ?></td>
                    </tr>
                </tbody>
            </table>
            <span id="errMsg" class='msgErr'></span>
            <table class="sum" id="transcTable">
                <thead>
                    <tr>
                        <th scope = "col" class = "date" >日期</th>
                        <th scope = "col" class ='editable data'>应收</th>
                        <th scope = "col" class ='editable data'>已收</th>
                        <th scope = "col" class ='editable data'>坏账</th>
                        <th scope = "col" class ='data'>处理</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan = "5" class = "rounded-foot-left">双击数据格可以修改。</td>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>

                        <?php
                        $sql_client = "SELECT T.TID, T.DATE, T.CREDIT AS CR, T.DEBIT AS DE,
                                    T.BAD AS BAD
                                    FROM CLIENT AS C INNER JOIN TRANSC AS T   
                                    ON C.OID=T.OID AND C.BID=T.BID AND C.CID=T.CID
                                    WHERE C.OID='" . $_SESSION['oid']
                                . "' AND C.BID='" . $_SESSION['bid'] . "'                                         
                                    AND C.CID='$cid' 
                                    ORDER BY T.DATE ASC";
                        $result_c = $mysqli->query($sql_client);


                        while ($row = $result_c->fetch_array(MYSQLI_ASSOC)) {
                            $tid = $row['TID'];
                            $t_date = $row['DATE'];
                            $de_c = number_format((float) $row['DE'], 2, '.', '');
                            $cr_c = number_format((float) $row['CR'], 2, '.', '');

                            $bad_c = number_format((float) $row['BAD'], 2, '.', '');
                            $bala_c = number_format((float) ($row['DE'] - $row['CR'] - $row['BAD']), 2, '.', ''); //balance
                            echo "<tr id='row$tid'>";
                            echo "<td class ='date'>$t_date</td>";
                            echo "<td id='de$tid' class ='editable data' >$de_c</td>";
                            echo "<td id='cr$tid' class ='editable data' >$cr_c</td>";
                            echo "<td id='bd$tid' class ='editable data' > $bad_c</td>";
                            echo "<td id='' class ='data'><a href='javascript:void(0)' onClick=\"confirmDel('$tid')\">删除</a>";
                            //echo "&nbsp<a  href='javascript:void(0)' onClick=\"addRow('$tid')\">添加</a></td>";
                        }

                        /* free result set */
                        $result_c->free();
                        ?>
                    </tr>
                    <?php
                    //new row for adding a new record

                    $rid = 'newRecd' + time();

                    $datetime = date("Y-m-d H:i:s");
                    echo "<tr id='$rid'><td class ='date' id='date$rid'>$datetime
                    </td><td><input id='de$rid' type='text' class='newRecd'></input>
                    </td><td><input id='cr$rid' type='text' class='newRecd'></input>
                    </td><td><input id='bad$rid' type='text' class='newRecd'></input>
                    </td><td><a href='javascript:void(0)' onClick=\"saveNewRecd('$rid')\">保存</a>";
                    //echo "&nbsp<a href='javascript:void(0)' onClick=\"cancelNewRecd(' $rid ')\">取消</a>";
                    echo "</td></tr>";
                    ?>
                </tbody>
            </table>
            <br><br><br>

            <div id="waitpopup">
                <div id="waitpopup-wrapper">
                    正在保存,请等待... 
                </div>
                <div id="loader"></div>
                <div id="backgroundPopup"></div>

            </div> 
        </div>


    </body>
</html>


