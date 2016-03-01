<?php

include_once '../include/dbcon.php';
include_once '../include/func.php';
sec_session_start();
if (login_check($mysqli) == false) {
    header('Location: index.php');
}

/*
 * for deletion
 */

if (isset($_POST['del'])) {

    $soid = $_SESSION['oid'];
    $sbid = $_SESSION['bid'];

    $sql = "DELETE from CLIENT where" .
            " OID='$soid' AND BID='$sbid' " .
            " AND CID='" . filter_input(INPUT_POST, 'del') . "'";
    if (!$mysqli->query($sql)) {
        echo "删除信息出错！";
        error_log("[App Error] " + $sql);
        error_log("Delete failed: (" . $mysqli->errno . ") " . $mysqli->error);
    } else {
        //delete transactions too
        $sql_trans = "DELETE from TRANSC where" .
                " OID='$soid' AND BID='$sbid' " .
                " AND CID='" . filter_input(INPUT_POST, 'del') . "'";
        if (!$mysqli->query($sql_trans)) {
            echo "删除信息出错！";
            error_log("[App Error] " + $sql_trans);
            error_log("Delete failed: (" . $mysqli->errno . ") " . $mysqli->error);
        }
        echo json_encode(array("location" => "manClient.php"));
    }



    return 0;
}
?>