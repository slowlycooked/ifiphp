<?php

include_once '../include/dbcon.php';
include_once '../include/func.php';
sec_session_start();
if (login_check($mysqli) == false) {
    header('Location: index.php');
}


$soid = $_SESSION['oid'];
$sbid = $_SESSION['bid'];

$name = test_input(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
$contact = test_input(filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_STRING));
$phone = test_input(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING));
//echo "session value: $soid  $sbid";

$sql_name = "SELECT CID FROM CLIENT "
        . " WHERE OID='$soid' "
        . " AND BID='$sbid'"
        . " AND NAME='" . $name . "'";
//echo $sql_name."<br>";

$stmt_name = $mysqli->query($sql_name);
if ($stmt_name->num_rows > 0) {
    echo "<span class='msgErr' >已经存在相同的客户[" . $name . "]</span>";
    $mysqli->close();
    $stmt_name->free();
    exit();
}


$sql_cid = "SELECT MAX(CID) AS MCID FROM CLIENT WHERE OID=? AND BID=?";
if ($r_cid = $mysqli->prepare($sql_cid)) {
    $r_cid->bind_param('ss', $soid,$sbid);  // Bind "$username" to parameter.
    $r_cid->execute();    // Execute the prepared query.
    $r_cid->store_result();

    // get variables from result.
    $r_cid->bind_result($mcid);
    $r_cid->fetch();
    debug("mcid:$mcid");
    $mcid = sprintf("%04X", intval("0x" . $mcid, 0) + 1);
    $r_cid->close();
    debug("mcid after:$mcid");
    $sql = "INSERT INTO CLIENT (OID,BID,CID,NAME,CONTACT,PHONE) 
           VALUES('" . sprintf("%03X", $soid) . "','$sbid','" . $mcid . "',?,?,?)";
    
    
    if (!$stmt = $mysqli->prepare($sql)) {
        error_log("错误： Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
        header("Location: error.php?err=错误： Prepare failed:" . $mysqli->errno);
    }

    if (!$stmt->bind_param("sss", $name, $contact, $phone)) {
        debug("错误： Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
    }


    if (!$stmt->execute()) {
        debug("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        echo "<p class='error'> 创建客户错误！</p>";
    } else {
        //header("Location: ../home.php?s=1");
        echo("<span class='msgSucc' >客户[" . $name . "]添加成功！</span>");
        $_SESSION['redirect'] = '1';
    }
} else {
    //show_error("系统错误！");
    header("Location: error.php?err=错误： Prepare failed:" . $mysqli->errno);
    header("Location: error.php?err=错误： Prepare failed:" . $mysqli->errno);
}
