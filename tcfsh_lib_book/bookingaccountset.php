<!DOCTYPE html>
<?php
    function readjson($path){
        $json_data=file_get_contents($path);
        $data_array=json_decode($json_data,true);
        return $data_array;
    }
    function writejson($info,$path){
        $json_data=json_encode($info);
        file_put_contents($path,$json_data);
        return 1;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="info/bookingaccountset.css" rel="stylesheet">
    <title>tcfsh lib book</title>
</head>
<?php
    session_start();
    if(file_exists("/tmp/tcfsh_lib_book/".session_id()."/bookinfo.json")==0){
        header("Location:/");
    }

    if($_SESSION['book_session']==''){
        header('Location:/');
    }
    $outsession=$_SESSION['book_session'];
    $bookinfo['ssid']=$_POST['bookssid'];
    $bookinfo['pass']=$_POST['bookpass'];
    if($bookinfo['ssid']!=""&&$bookinfo['pass']!=""){
        $checkexist=exec("curl http://210.60.107.235:8080//tchdesk/booking/booking_check.jsp -d \"p=3&c=1&f1=".$bookinfo['ssid']."&f2=".$bookinfo['pass']."&_=\" -b \"JSESSIONID=".$outsession."\" |grep 'runme'");
        if($checkexist!=""){
            echo("success");
            writejson($bookinfo,"/tmp/tcfsh_lib_book/".session_id()."/bookinfo.json");
            header("Location:/");
        }
        else{
            echo("<script>alert(\"Error: 輸入的帳密驗證失敗\")</script>");
        }
    }

    //echo($outsession);
    ?>
<body>
    <div id="page_i">
        <h1>閱覽室帳號密碼設定頁</h1>
        <form method="post" action="bookingaccountset.php" id="login_f">
            <table id="form_t">
                <tbody>
                    <tr>
                        <td>
                            <h3 class="outputh3">閱覽室帳號：
                            <input type="text" name="bookssid" id="ssidin" required></h3><br/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3 class="outputh3">閱覽室密碼：
                            <input type="password" name="bookpass" id="passin" required></h3><br/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="submit">提交閱覽室帳號資訊</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            
            
        </form>
    </div>
    
</body>
</html>
