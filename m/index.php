<?php
session_start();
$_SESSION['oid'] = '001';

include_once '../include/config.php';

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

?>
<html>
    <head>
        <title> 流水总览 </title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css">
        <script src="../js/jquery-1.11.3.min.js"></script>
        <script src="js/jquery.mobile-1.4.5.min.js"></script>
        <link rel="stylesheet" href="css/mstyle.css"/>
        <script src="js/mclient.js" type="text/javascript"></script>
        <link href="css/popup.css" rel="stylesheet" type="text/css"/>
        
    </head>

    <body>

        <div data-role="page" id="clientSum">
            <div data-role="main" class="ui-content">
                <h2>客户清单</h2>
                <ul data-role="listview">
                    <?php
                    $sql_client = "SELECT b.cid, b.name, sum(a.credit) as cr, sum(a.debit) as de,
                                    sum(a.bad) as bad
                                    FROM  CLIENT as b left outer join TRANSC as a  on  
                                    b.oid=a.oid and b.cid=a.cid 
                                    WHERE b.oid='" . $_SESSION['oid'] . "'
                                    GROUP BY b.name
                                    Order by b.cid asc";
                    $result_c = $mysqli->query($sql_client);

                    while ($row = $result_c->fetch_array(MYSQLI_ASSOC)) {
                        $cid = $row['cid'];
                        $name_c = $row['name'];
                        $de_c = number_format((float) $row['de'], 2, '.', '');
                        $cr_c = number_format((float) $row['cr'], 2, '.', '');

                        $bad_c = number_format((float) $row['bad'], 2, '.', '');
                        $bala_c = number_format((float) ($row['de'] - $row['cr'] - $row['bad']), 2, '.', ''); //balance
                        echo "<li>";
                       # echo "<td>" . intval("0x" . $cid, 0) . "</td>";
                        echo "<a href='client.php?cid=$cid' data-transition='slide'>"
                                . "$name_c "
                                . "$bala_c</a></li>";
                        
                    }
                    /* free result set */
                    $result_c->free();
                    ?>
                </ul><br>    
            </div>
        </div> 
    </div> 

</body>
</html>