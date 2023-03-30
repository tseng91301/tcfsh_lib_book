<!DOCTYPE html>
<?php
session_start();
if(file_exists("/tmp/tcfsh_lib_book/".session_id()."/bookinfo.json")==0){
    header("Location:/");
}

$outsession=$_SESSION['book_session'];
$a=$_POST['a'];
$b=$_POST['b'];
$c=$_POST['c'];
$d=$_POST['d'];
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>tcfsh lib book</title>
        
    </head>
    <body>
        <div style="width: 1920px; height: 1080px;  top:150px;">
            <?php
            //echo(date("YmdHisu")."<br/>");
            $time=exec("date");
            $ssid=$_SESSION['ssid'];
            $rr=exec("curl \"http://210.60.107.235:8080/tchdesk/booking/step1_4.jsp?a=".$a."&b=".$b."&c=".$c."&d=".$d."\" -b \"JSESSIONID=".$outsession."\" |grep 'info_name.png' ");
            
            if($rr!=""){
                $_SESSION['booksuccess']=1;
            }else{
                $_SESSION['booksuccess']=2;
            }
            header('Location:'.'/');
            ?>
            
        </div>
         
    </body>
</html>