<?php
include_once 'include/dbcon.php';
include_once 'include/func.php';
sec_session_start();
if (login_check($mysqli) == false) {
    header('Location: index.php');
}

include_once '../include/dbcon.php';


?>
<html>
    <title>添加新账本</title>

    <meta http-equiv = 'Content-Type' content = 'text/html; charset=utf-8' />

    <link rel = "stylesheet" type = "text/css" media = "screen" href = "css/style.css">
    <link rel = "stylesheet" type = "text/css" media = "screen" href = "css/popup.css">

    <script type = 'text/javascript' src = 'js/jquery-1.10.2.min.js'></script>
    <script type='text/javascript' src="js/jquery.form.min.js"></script> 
    <script type='text/javascript' src='js/jquery.validate.min.js'></script>
    <script type='text/javascript' src='js/ifi_book.js'></script>

    <link rel="stylesheet" href="css/menu.css">
    <script src="js/menu.js"></script>

    <body>
        <div id = "wrapper">

            <div id='cssmenu'>
                <ul>
                    <li><a href='home.php'>主页</a></li>
                    <li class='active'><a href='#'>管理</a>
                        <ul>
                            <li><a href='manBook.php'>添加新账本</a>
                            </li>
                            <li><a href="manClient.php">删除项目（客户）</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div align = "center">                 
                <form id = "newBookForm" method = 'post' action = 'php/newBook.php'>

                    <table style = 'color:black; font-size:18px'>
                        <tr>
                            <td style="font-size:20;font-weight: bolder">账本名称:</td>
                            <td><input id = "name" type = 'text' name = 'name'
                                       value = '' size = "30" style="height:40px"/></td>
                            <td>
                                <input class = "css_btn_class" type = 'Submit' name = "submitBtn" value = '添加账本'/>
                                <!--input type = 'Submit' name = "submitBtn" value = 'Cancel'/ -->
                            </td>
                        </tr>

                    </table>
                </form>
                <div id = "newBookOutput"></div>
            </div>


            <h3>已有账本：</h3>
            <table class="sum">
                <thead>
                    <tr>
                        <th scope="col" >账本序号</th>
                        <th scope="col" >账本名称</th>
                        <th scope="col" >记录数</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
//echo "in";
                        $sql = "SELECT B.BID, B.BNAME, COUNT(C.CID) CNT FROM BOOKS AS B LEFT OUTER JOIN CLIENT AS C ON"
                                . " B.OID=C.OID AND B.BID=C.BID "
                                . " WHERE B.OID='" . $_SESSION['OID'] . "'"
                                . " GROUP BY B.BID, B.BNAME";
//echo $sql;
                        $result = $mysqli->query($sql);

                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                            $bid = $row['bid'];
                            $bname = $row['BNAME'];
                            $cnt = $row['CNT'];
                            echo "<tr>";
                            echo "<td class =''>$bid</td>";
                            echo "<td class =''>$bname</td>";
                            echo "<td class =''>$cnt</td>";
                            // echo "<td class =''><a href='javascript:void(0)' onclick=\"deleteBook('$bid')\">删除</a>
                            //                         &nbsp <a href='' onclick=\"edit('$bid')\">编辑</a></td>";
                        }
                        /* free result set */
                        $result->free();
                        ?>
                    </tr>

                </tbody>
            </table>
        </div>
    </body>
</html>
