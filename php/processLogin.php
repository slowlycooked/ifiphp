<?php

//登录
//包含数据库连接文件
include_once '../include/dbcon.php';
include_once '../include/func.php';

sec_session_start(); // Our custom secure way of starting a PHP session.
if (isset($_POST['username'], $_POST['p'])) {
    $username = $_POST['username'];
    $password = $_POST['p']; // The hashed password.

    if (login($username, $password, $mysqli) == true) {
        // Login success 
        debug("Login Successful!");
        header('Location: ../home.php');
    } else {
        // Login failed 
        //header('Location: ../home.php?error=1');
        debug("login failed");
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}


/*
 *  Functions for login procedures
 *  
 */

function login($username_in, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT USERNAME, PASSWORD, SALT, OID
        FROM USER
       WHERE USERNAME = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $username_in);  // Bind "$username" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($username, $db_password, $salt, $oid);
        $stmt->fetch();

        // hash the password with the unique salt.
        debug("password b4 salt $password");
        $password = hash('sha512', $password . $salt);
        debug("username:$username_in" . " <br /> password:" . $password);
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 

            if (checkbrute($username, $mysqli) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked
                debug("brute force attack");
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted.
                if ($db_password == $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    //$user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    //$_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);

                    $_SESSION['username'] = $username;
                    $_SESSION['mm'] = hash('sha512', $password . $user_browser);
                    $_SESSION['oid'] = $oid;

                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                    debug("[Session]username:" . $_SESSION['username']);
                    // Login successful.
                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = date('Y-m-d H:i:s', time());
                    debug("incorrect login: INSERT INTO LOGINLOG(USERNAME,TIME)
                                    VALUES ('$username', '$now')");

                    if (!$mysqli->query("INSERT INTO LOGINLOG(USERNAME,TIME)
                                    VALUES ('$username', '$now')")) {
                        error_log("Insert loginlog failed: (" . $mysqli->errno . ") " . $mysqli->error);
                    }
                    return false;
                }
            }
        } else {
            // No user exists.
            $now = date('Y-m-d H:i:s', time());

            if (!$mysqli->query("INSERT INTO LOGINLOG(USERNAME,TIME)
                                    VALUES ('$username_in', '$now')")) {
                error_log("Insert loginlog failed: (" . $mysqli->errno . ") " . $mysqli->error);
            }
            return false;
        }
    }
}

function checkbrute($username, $mysqli) {
    // Get timestamp of current time 
    $now = date('Y-m-d H:i:s', time());

    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = date('Y-m-d H:i:s', $now - (2 * 60 * 60));

    if ($stmt = $mysqli->prepare("SELECT TIME 
                             FROM LOGINLOG 
                             WHERE USERNAME = ? 
                            AND TIME > '$valid_attempts'")) {
        $stmt->bind_param('s', $username);

        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 5 failed logins 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}
