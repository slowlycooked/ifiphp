<?php

include_once '../include/dbcon.php';
include_once '../include/func.php';
sec_session_start();
if (login_check($mysqli) == false) {
    header('Location: index.php');
}


if (isset($_POST['bookSelect'])) {
    $_SESSION['bid'] = $_POST['bookSelect'];
} else {
    $_SESSION['bid'] = '001';
}

header( 'Location: ../home.php' ) ; 