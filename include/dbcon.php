<?php

include_once 'config.php';

//$mysqli = new mysqli($db_server, $db_username, $db_pswd, $db_database);
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PSWD, DB_DB);
/* check connection */
if (mysqli_connect_errno()) {
    debug("错误：Connect failed: %s\n", mysqli_connect_error());
    error_log("错误：Connect failed: %s\n", mysqli_connect_error());
    exit();
}
/* change character set to utf8 */
if (!$mysqli->set_charset("utf8")) {
    debug("错误： loading character set utf8: %s\n", $mysqli->error);
    error_log("错误： loading character set utf8: %s\n", $mysqli->error);
    exit();
}


?>