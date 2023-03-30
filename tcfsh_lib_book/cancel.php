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
<?php
session_start();
if(file_exists("/tmp/tcfsh_lib_book/".session_id()."/bookinfo.json")==0){
    header("Location:/");
}

$outsession=$_SESSION['book_session'];
if($outsession==""){
    header('Location:'.'/');
}
$bookinfo=readjson("/tmp/tcfsh_lib_book/".session_id()."/bookinfo.json");
$checkexist=exec("curl http://210.60.107.235:8080//tchdesk/booking/booking_check.jsp -d \"p=3&c=1&f1=".$bookinfo['ssid']."&f2=".$bookinfo['pass']."&_=\" -b \"JSESSIONID=".$outsession."\" |grep runme");
if($checkexist==""){
    header('Location:'.'/bookingaccountset.php');
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>取消預約頁面</title>
        <?php
        $canceltime=$_POST['canceltime'];
        $cancelcon=$_POST['cancelcon'];
        if($canceltime!=""&&$cancelcon!=""){
            exec("curl 'http://210.60.107.235:8080/tchdesk/booking/cancelme.jsp?x=".$canceltime."&y=".$cancelcon."' -b \"JSESSIONID=".$outsession."\"");
            $_SESSION['cancelsuccess']=1;
            header('Location:'.'/');
        }
        ?>
        <script src="info/discuss2.js"></script>
    </head>
    <body>
        
    </body>
</html>