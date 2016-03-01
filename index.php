<?php
include_once 'include/func.php';
include_once 'include/dbcon.php';

sec_session_start();

//$error_msg = '';
//if(isset($_GET('error'))){
//    $err_numb = filter_input(INPUT_GET, 'error', FILTER_SANITIZE_STRING);
//    switch ($err_numb){
//        case '1':
//            $error_msg ="登录信息有误请重新输入！";
//            break;
//        default:
//            break;        
//    }
//        
//}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>登录界面</title>
        <meta http-equiv = 'Content-Type' content = 'text/html; charset=utf-8' />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel = "stylesheet" type = "text/css" media = "screen" href = "css/style.css">

        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script> 
        
        <script type="text/JavaScript" src="js/bootstrap.3.3.5.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="css/bootstrap.3.3.5.min.css">

        <!-- Optional theme -->
        <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" -->

        <!-- Latest compiled and minified JavaScript -->
        <!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script-->
    </head>
    <body>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">登录信息有误请重新输入！</p>';
        }
        ?> 

        <div class="container">

            <form action="php/processLogin.php" method="post" name="login_form" role="form">  
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-10">
                        <input type="text" name="username" class="form-control"  />
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">密码:</label>
                    <div class="col-sm-10">
                        <input type="password" 
                               name="mm" 
                               id="password" class="form-control" />
                    </div>
                </div>
                <input type="button" 
                       value="登录" 
                       onclick="formhash(this.form, this.form.password);" /> 
            </form>
        </div> 
    </div>   
</body>
</html>