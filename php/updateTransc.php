<?php

include_once '../include/dbcon.php';
include_once '../include/func.php';
sec_session_start();
if (login_check($mysqli) == false) {
    header('Location: index.php');
}

/*
 * for sum records
 */
if (isset($_POST['action']) && $_POST['action'] == 'sum') {

    $cid = $_SESSION['cid'];

   

//echo "in";
    $sql = "SELECT C.NAME, SUM(T.CREDIT) AS CR, SUM(T.DEBIT) AS DE,
            SUM(T.BAD) AS BAD
            FROM   CLIENT AS C INNER JOIN TRANSC AS T
                ON C.OID=T.OID AND C.CID=T.CID
            WHERE C.OID='" . $_SESSION['oid'] 
            . "' AND C.BID='".$_SESSION['bid']   
            . "' AND C.CID='$cid'";

    $result_total = $mysqli->query($sql);

    $row = $result_total->fetch_array(MYSQLI_ASSOC);
    $cname = $row['NAME'];
    $de = number_format((float) $row['DE'], 2, '.', '');
    $cr = number_format((float) $row['CR'], 2, '.', '');

    $bad = number_format((float) $row['BAD'], 2, '.', '');
    $bala = number_format((float) ($row['DE'] - $row['CR'] - $row['BAD']), 2, '.', ''); //balance
    /* free result set */
    $result_total->free();

    echo "
        <td class='client'>合计</td>
          <td class='data'>$de</td>
          <td class = 'data'>$cr </td>
          <td class = 'data'>$bad</td>
            <td class = 'data'>$bala</td>
         ";
    return 0;
}

/*
 * for deletion
 */

if (isset($_POST['del'])) {

    
    $var_oid = $_SESSION['oid'];
    $var_bid =$_SESSION['bid'];
    $var_cid = $_SESSION['cid'];

    $sql = "DELETE from TRANSC where" .
            " oid='" . $_SESSION['oid'] . "'" .
            " and bid='".$_SESSION['bid'] ."'".  
            " and cid='" . $_SESSION['cid'] . "'" .
            " and tid='" . $_POST['del'] . "'";
    if (!$mysqli->query($sql)) {
        echo "删除信息出错！";
        error_log("[App Error] " + $sql);
        error_log("Delete failed: (" . $mysqli->errno . ") " . $mysqli->error);
    } else {
        //echo '1';
        if (updateClientTimestamp($mysqli, $var_oid, $var_bid, $var_cid) == 0) {
            echo '1';
        }
    }
    return 0;
}

/*
 * ajax action for add new record
 */
if (isset($_POST['action']) && $_POST['action'] == 'add') {

    $sql = "INSERT INTO TRANSC (OID, BID, CID,  TID,DATE,DEBIT,CREDIT,BAD) VALUES(?,?,?,?,?,?,?,?)";

    if (!$stmt = $mysqli->prepare($sql)) {
        echo "添加新数据出错！";
        error_log("[App Error] sql: " + $sql);
        error_log("[App Error] Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
        return 1;
    }

    $var_oid = $_SESSION['oid'];
    $var_bid =$_SESSION['bid'];
    $var_cid = $_SESSION['cid'];
    $var_uid = strtoupper(uniqid());
    $var_date = test_input(filter_input(INPUT_POST, 'date'));
    $var_de = floatval(test_input(filter_input(INPUT_POST, 'de')));
    $var_cr = floatval(test_input(filter_input(INPUT_POST, 'cr')));
    $var_bad = floatval(test_input(filter_input(INPUT_POST, 'bad')));
    if (!$stmt->bind_param("sssssddd", $var_oid, $var_bid, $var_cid, $var_uid,
            $var_date, $var_de, $var_cr, $var_bad
            )) {
        echo "添加新数据出错！";
        error_log("[App Error] sql: " + $sql);
        error_log("[App Error] Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        return 1;
    }

    if (!$stmt->execute()) {
        //failed
        echo "添加新数据出错";
        error_log("[App Error] sql: " + $sql);
        error_log("[App Error] Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        return 1;
    } else {
        //echo '1';
        if (updateClientTimestamp($mysqli, $var_oid, $var_bid, $var_cid) == 0) {
            echo json_encode(array("location" => "client.php?cid=" . $_SESSION['cid']));
        }
    }
    $mysqli->close();
    return 0;
}



/*
 * for cell update
 */
//echo "id".$_POST['id']."<br />";
if (!isset($_POST['id']) && !isset($_POST['value'])) {
    error_log("[App Error] updateTransc.php no id or value passing in to update !", 0);
    header('Location: ../home.php');
    return 1;
}

$colname = substr($_POST['id'], 0, 2);
$tid = substr($_POST['id'], 2, strlen($_POST['id']) - 2);


$sql = "UPDATE TRANSC SET ";
switch ($colname) {
    case 'cr':
        $sql .= "CREDIT=? ";
        break;
    case 'de':
        $sql .="DEBIT=? ";
        break;
    case 'bd':
        $sql .="BAD=? ";
        break;
}
$var_oid = $_SESSION['oid'];
$var_bid = $_SESSION['bid'];
$var_cid = $_SESSION['cid'];

$sql .= " WHERE OID='$var_oid' and " .
        "BID='$var_bid' and ".
        "CID='$var_cid' and " .
        "TID='$tid'";

if (!$stmt = $mysqli->prepare($sql)) {
    echo "更新出错";
    error_log("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
    return 1;
}

if (!$stmt->bind_param("d", floatval(test_input($_POST['value'])))) {
    echo "更新出错";
    error_log("[App Error] " + $sql);
    error_log("[App Error] Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    return 1;
}

if (!$stmt->execute()) {
    //failed
    echo "更新出错";
    error_log("[App Error] " + $sql);
    error_log("[App Error] Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    return 1;
} else {
    if (updateClientTimestamp($mysqli, $var_oid, $var_bid, $var_cid) == 0) {

        echo number_format((float) $_POST['value'], 2, '.', '');
    }
}
$mysqli->close();
return 0;



function updateClientTimestamp($mysqli, $oid, $bid, $cid) {


    $sql = "UPDATE CLIENT SET LASTUP=? WHERE OID=? AND BID=? AND CID=?";
    $var_now = date("Y-m-d H:i:s");
    //echo $var_now;
    if (!$stmt = $mysqli->prepare($sql)) {
        echo "updateClientTimestamp Error！1";
        error_log("[App Error] sql: " + $sql);
        error_log("[App Error] Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
        return 1;
    }



    if (!$stmt->bind_param("ssss", $var_now, $oid, $bid, $cid)) {
        echo "updateClientTimestamp Error！2";
        error_log("[App Error] sql: " + $sql);
        error_log("[App Error] Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        return 1;
    }

    if (!$stmt->execute()) {
        //failed
        echo "updateClientTimestamp Error！3";
        error_log("[App Error] sql: " + $sql);
        error_log("[App Error] Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        return 1;
    }
    return 0;
}
?>


