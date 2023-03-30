<!DOCTYPE html>
<html lang="en">
<?php
if(exec("ls /tmp|grep tcfsh_lib_book")==""){
    exec("mkdir /tmp/tcfsh_lib_book");
}
?>
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
exec("mkdir /tmp/tcfsh_lib_book/".session_id());
exec("touch /tmp/tcfsh_lib_book/".session_id()."/bookinfo.json");

$inpsession=exec("curl -I http://210.60.107.235:8080//tchdesk/booking/booking_check.jsp  |grep \"Set-Cookie: JSESSIONID=\"");
$b1=23;
$outsession="";
while($inpsession[$b1]!=";"){
    $outsession=$outsession.$inpsession[$b1];
    $b1++;
}
$_SESSION['book_session']=$outsession;
$bookinfo=readjson("/tmp/tcfsh_lib_book/".session_id()."/bookinfo.json");
if($bookinfo['ssid']==""||$bookinfo['pass']==""){
    header('Location:'.'/bookingaccountset.php');
}
$checkexist=exec("curl http://210.60.107.235:8080//tchdesk/booking/booking_check.jsp -d \"p=3&c=1&f1=".$bookinfo['ssid']."&f2=".$bookinfo['pass']."&_=\" -b  \"JSESSIONID=".$outsession."\" |grep runme");
if($checkexist==""){
    header('Location:'.'/bookingaccountset.php');
}

?>
<?php if($_SESSION['datebefore']==1){echo("<script>alert('Error:使用當天之前或當天晚上十點後之時間預約當天將會被記點!')</script>"); $_SESSION['datebefore']=0;}?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script id="applicationScript" type="text/javascript" src="info/discuss2.js"></script>
    <link href="info/index.css" rel="stylesheet">
    <title>閱覽室Hacker選位系統</title>
</head>
<body>
    <div id="page_i">
        <div id="tcfsh_lib_book-top">
            <h1>一中閱覽室選位系統 - 精簡版</h1>
            <h2>現在時間：<?php echo(date("Y/m/d G:i:s"));?></h2>
        </div>
        <div id="tcfsh_lib_book-book_session">
            <h2>閱覽室定位區</h2>
            <form method="post" action="step2.php">
                <h3>請選擇預約日期：</h3>
                <input type="date" name="datein" required>
                <h3>請選擇預約樓層：<a href="javascript:alert(111)">說明</a></h3>
                <select name="floor">
                    <option value="a">B1</option>
                    <option value="b">1F</option>
                    <option value="c">2F</option>
                </select>
                <br/>
                <h3>當天是否為假日？<a href="javascript:alert(222)">說明</a></h3>
                <input type="radio" name="is_hol" value="2" checked>系統自動選擇<br/>
                <input type="radio" name="is_hol" value="0">非假日<br/>
                <input type="radio" name="is_hol" value="1">假日<br/>
                <button type="submit">查看座位</button>
            </form>
        </div>
        <div id="tcfsh_lib_book-check_session">
            <h2>檢查/取消座位</h2>
            
            <?php
                if($_SESSION['booksuccess']==1){
                    echo("<script>alert('Success!');</script>");
                    $_SESSION['booksuccess']=0;
                }else if($_SESSION['booksuccess']==2){
                    echo("<script>alert('Failed...');</script>");
                    $_SESSION['booksuccess']=0;
                }
                if($_SESSION['cancelsuccess']==1){
                    echo("<script>alert('Cancel SUCCESS!!')</script>");
                    $_SESSION['cancelsuccess']=0;
                }
                //echo("<pre>");
                $nonebooking=exec("curl http://210.60.107.235:8080/tchdesk/booking/step3_2.jsp -b \"JSESSIONID=".$outsession."\" |grep '<input type=\"button\" name=\"button\" id=\"button\" value=\"'");
                $booking_info=shell_exec("curl http://210.60.107.235:8080/tchdesk/booking/step3_2.jsp -b \"JSESSIONID=".$outsession."\" |grep -A4 -B8 '<input type=\"button\" name=\"button\" id=\"button\" value=\"'");
                $booking_info=str_replace("</label>","</label><br/>",$booking_info);
                $booking_info=str_replace("--","",$booking_info);
                if($nonebooking==NULL){
                    echo("<tr><td>No booking scheduals yet!</td></tr>");
                }else{
                    echo($booking_info);
                }
                
                
                //echo("</pre>");
            ?>
            
        </div>
    </div>
    
    
</body>
</html>