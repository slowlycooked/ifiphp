<?php

include_once '../include/dbcon.php';
include_once '../include/func.php';
sec_session_start();
if (login_check($mysqli) == false) {
    header('Location: index.php');
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (!isset($_SESSION['oid'])) {
     header('Location: ../home.php');
     return 1;
}

$oid = $_SESSION['oid'];

require_once '../include/config.php';
$mysqli = new mysqli($db_server, $db_username, $db_pswd, $db_database);
/* check connection */
if (mysqli_connect_errno()) {
    printf("错误： Connect failed: %s\n", mysqli_connect_error());
    exit();
}

/* change character set to utf8 */
if (!$mysqli->set_charset("utf8")) {
    printf("错误： loading character set utf8: %s\n", $mysqli->error);
    exit();
} 
$sql_name ="SELECT BID FROM BOOKS WHERE OID='$oid' AND BNAME='".test_input($_POST['name'])."'";
//echo $sql_name."<br>";
$stmt_name = $mysqli->query($sql_name);
if ($stmt_name->num_rows>0){
    echo "<span class='msgErr' >已经存在相同的客户[".$_POST['name']."]</span>";
    $mysqli->close();
    $stmt_name->free();
    exit();
}


$sql_bid = "SELECT MAX(BID) AS MBID FROM BOOKS WHERE OID ='$oid' ";
$r_bid = $mysqli->query($sql_bid);

$row = $r_bid->fetch_array(MYSQLI_ASSOC);
echo "mcid:".$row['MBID']."<br>";
$mbid = sprintf("%03X", intval("0x".$row['MBID'],0) + 1);
echo "new mcid:".$mbid."<br>";
$r_bid->free();

$sql = "INSERT INTO BOOKS (OID,BID,BNAME) 
           VALUES('".sprintf("%03X",$oid)."','".$mbid."','".test_input($_POST['name'])."')";

//echo $sql."<br>";

if (!$stmt = $mysqli->query($sql)) {
    error_log("Query failed: (" . $mysqli->errno . ") " . $mysqli->error);
    echo "<p class='error'>创建错误！</p>";
    debug("Query failed: (" . $mysqli->errno . ") " . $mysqli->error);
    
}else{
     echo "<span class='msgSucc' >账本[".$_POST['name'] ."]添加成功！</span>";
}

$mysqli->close();

//header( 'Location: ../manBook.php' ) ; 


