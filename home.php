<?php
include_once 'include/dbcon.php';
include_once 'include/func.php';
sec_session_start();
if (login_check($mysqli) == false) {
    //header('Location: index.php?error=1');
}

// Add your protected page content here!
//header('Location: login.php');
if (!isset($_SESSION['bid'])) {
    $_SESSION['bid'] = '001';
}

$sql = "SELECT SUM(CREDIT) AS CR, SUM(DEBIT) AS DE,
            SUM(BAD) AS BAD
            FROM CLIENT AS C INNER JOIN TRANSC AS T 
            ON C.OID=T.OID AND C.BID=T.BID AND C.CID=T.CID
            WHERE T.OID='" . $_SESSION['oid']
        . "' AND C.BID='" . $_SESSION['bid']
        . "' GROUP BY T.OID";

if ($result_total = $mysqli->query($sql)) {

    $row = $result_total->fetch_array(MYSQLI_ASSOC);
    $de = number_format((float) $row['DE'], 2, '.', '');
    $cr = number_format((float) $row['CR'], 2, '.', '');

    $bad = number_format((float) $row['BAD'], 2, '.', '');
    $bala = number_format((float) ($row['DE'] - $row['CR'] - $row['BAD']), 2, '.', ''); //balance
//free result set
    $result_total->free();
} else {
    debug("Query error. " . $sql);
}





/*
  $prep_stmt = "SELECT sum(credit) as cr, sum(debit) as de,
  sum(bad) as bad
  FROM CLIENT as c inner join TRANSC as t on c.cid = t.cid
  and c.oid=t.oid
  WHERE t.oid=? and c.bid=? GROUP BY t.oid";

  $stmt = $mysqli->prepare($prep_stmt);

  $stmt->bind_param('ss', $_SESSION['oid'], $_SESSION['bid']);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($cr, $de, $bad, $bala);
  $stmt->fetch();

  $de = number_format((float) $de, 2, '.', '');
  $cr = number_format((float) $cr, 2, '.', '');

  $bad = number_format((float) $bad, 2, '.', '');
  $bala = number_format((float) ($de - $cr - $bad), 2, '.', ''); //balance

  debug($de ." ".$cr." ".$bad." ".$bala);
 */
?>



<html>
    <title>账本合计</title>

    <meta http-equiv = 'Content-Type' content = 'text/html; charset=utf-8' />

    <link rel = "stylesheet" type = "text/css" media = "screen" href = "css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/popup.css">

    <script type='text/javascript' src='js/jquery-1.10.2.min.js'></script>
    <!--script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script-->

    <script type='text/javascript' src="js/jquery.form.min.js"></script> 
    <!--script type='text/javascript' src='js/jquery.validate.min.js'></script!-->
    <script type='text/javascript' src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script> 
    <script type='text/javascript' src='js/ifi_index.js'></script>

    <link rel="stylesheet" href="css/menu.css">
    <script src="js/menu.js"></script>

    <body>
        <div id = "wrapper">
            <div id='cssmenu'>
                <ul>
                    <li><a href='home.php'>主页</a></li>
                    <li class='active'><a href='#'>管理</a>
                        <ul>
                            <li><a id="newClient" href='#'>添加新项目（客户）</a>
                            </li>
                            <li><a href="manClient.php">删除项目（客户）</a>
                            </li>
                            <li><a href='manBook.php'>添加新账本</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href='logout.php'>退出</a></li>
                </ul>

            </div>
            <div id="statusBar">
                <!--div id="date"><?php echo date('Y年m月d日'); ?> </div-->
                <div id="bookSelect">

                    <form id="bookSelectForm" method="post" action="php/storeBookSession.php">
                        <label for="bookSelect">选择账本:</label>
                        <select style="height: 50px;" name="bookSelect" id="bookSelect" onchange="submit();">
                            <?php
                            $sqlGetBook = "SELECT BID,BNAME FROM BOOKS "
                                    . " WHERE OID =" . $_SESSION['oid'];
                            $resBooks = $mysqli->query($sqlGetBook);
                            while ($row = $resBooks->fetch_array(MYSQLI_ASSOC)) {
                                $bid = $row['BID'];
                                $bname = $row['BNAME'];
                                echo "<option value='$bid' ";
                                if ($_SESSION["bid"] == $bid) {
                                    echo " selected ";
                                }

                                echo ">$bname</option>";

                                //echo "&nbsp<a  href='javascript:void(0)' onClick=\"addRow('$tid')\">添加</a></td>";
                            }
                            ?>
                        </select>
                    </form>
                </div>
            </div>
            <!--span id="newclient" class="css_btn_class" style="float:right"> 添加新客户</span -->
            <table class="sum">
                <thead>
                    <tr>
                        <th scope="col" ></th>
                        <th scope="col" >应收</th>
                        <th scope="col" >已收</th>
                        <th scope="col" >坏账</th>
                        <th scope="col" >未收</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="client">合计</td>
                        <td class="data"><?php echo $de ?></td>
                        <td class = "data"><?php echo $cr ?></td>
                        <td class = "data"><?php echo $bad ?></td>
                        <td class = "data" 
                        <?php
                        if ($bala > 0.00) {
                            echo " style='color:red'";
                        }
                        ?>
                            >
                            <?php echo $bala ?></td>
                    </tr>
                </tbody>
            </table>

            <table class = "sum">
                <thead>
                    <tr>
                        <th scope = "col" style="width:30px" >序号</th>
                        <th scope = "col" style="width:132px" >客户</th>
                        <th scope = "col" >应收</th>
                        <th scope = "col" >已收</th>
                        <th scope = "col" >坏账</th>
                        <th scope = "col">未收</th>
                    </tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                    <tr>

                        <?php
                        $sql_client = "SELECT C.CID, C.NAME, SUM(T.CREDIT) AS CR,"
                                . " SUM(T.DEBIT) AS DE, SUM(T.BAD) AS BAD "
                                . " FROM  CLIENT AS C LEFT OUTER JOIN TRANSC AS T  
                                   ON C.OID=T.OID AND C.BID=T.BID AND C.CID=T.CID
                             
                              WHERE C.OID='" . $_SESSION['oid']
                                . "' AND C.BID ='" . $_SESSION['bid'] . "'
                                GROUP BY C.NAME
                                ORDER BY C.LASTUP DESC, C.CID ASC";
                        $result_c = $mysqli->query($sql_client);

                        while ($row = $result_c->fetch_array(MYSQLI_ASSOC)) {
                            $cid = $row['CID'];
                            $name_c = $row['NAME'];
                            $de_c = number_format((float) $row['DE'], 2, '.', '');
                            $cr_c = number_format((float) $row['CR'], 2, '.', '');

                            $bad_c = number_format((float) $row['BAD'], 2, '.', '');
                            $bala_c = number_format((float) ($row['DE'] - $row['CR'] - $row['BAD']), 2, '.', ''); //balance
                            echo "<tr>";
                            echo "<td>" . intval("0x" . $cid, 0) . "</td>";
                            echo "<td class='client'><a href='client.php?cid=$cid'> $name_c</a></td>";
                            echo "<td class ='data'>$de_c</td>";
                            echo "<td class ='data'>$cr_c</td>";
                            echo "<td class ='data'>$bad_c</td>";
                            echo "<td class ='data' ";
                            if ($bala_c > 0.00) {
                                echo " style='color:red'";
                            }
                            echo ">$bala_c</td>";
                        }
                        /* free result set */
                        $result_c->free();
                        ?>
                    </tr>
                </tbody>
            </table>
            <br><br><br>

        </div>


        <div id="popup">
            <div id="popup-wrapper">
                <div class="close"></div>
                <span class="esc_tooltip">关闭</span>
                <div align="center">
                    <h3> 添加新项目(客户) </h3>

                    <form id="newClientForm" method='post' action='php/newClient.php'>

                        <table style='color:black; font-size:18px'>
                            <tr><td>客户名称:</td><td><input id="name" type='text' name='name' value=''  minlength="2"  size="10"/></td>
                            </tr> 
                            <tr><td>客户联系人: </td><td><input id="contact" type='text' name='contact' value=''  size="10"/></td>
                            </tr> 
                            <tr><td>联系电话: </td><td><input id="phone" type='text' name='phone' value=''  size="15"/></td>
                            </tr> 

                        </table>

                        <br/>
                        <input class="css_btn_class" type='Submit' name="submitBtn" value='添加客户'/>
                        <!--input type='Submit' name="submitBtn" value='Cancel'/ -->
                    </form>
                    <div id="newClientOutput"></div>
                </div>


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

