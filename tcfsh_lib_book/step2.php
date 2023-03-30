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

$bookinfo=readjson("/tmp/tcfsh_lib_book/".session_id()."/bookinfo.json");
$checkexist=exec("curl http://210.60.107.235:8080//tchdesk/booking/booking_check.jsp -d \"p=3&c=1&f1=".$bookinfo['ssid']."&f2=".$bookinfo['pass']."&_=\" -b \"JSESSIONID=".$outsession."\" |grep runme");
if($checkexist==""){
    header('Location:'.'/bookingaccountset.php');
}
$datein=$_POST['datein'];
$serverdate=date("Y-m-d");
//echo($datein."<br/>");
//$out=date("w","2011-11-11");


$timearr=explode("-",$datein);
$y2=$timearr[0];
$m2=$timearr[1];
$d2=$timearr[2];
$S2=date("S");
$S2=intval($S2);

$timearr2=explode("-",$serverdate);
$servery=$timearr2[0];
$serverm=$timearr2[1];
$serverd=$timearr2[2];


if($y2<$servery){
    $_SESSION['datebefore']=1;
    header('Location:'.'index.php');
}else if($y2==$servery){
    if($m2<$serverm){
        $_SESSION['datebefore']=1;
        header('Location:'.'index.php');
    }else if($m2==$serverm){
        if($d2<$serverd){
            $_SESSION['datebefore']=1;
            header('Location:'.'index.php');
        }else if($d2==$serverd){
            if($S2>22){
                $_SESSION['datebefore']=1;
                header('Location:'.'index.php');
            }
        }
        
    }
}


$strap=mktime("00","00","00",$m2,$d2,$y2);
//$strap=mktime($y2,$m2,$d2);
$out=date("w",$strap);
//echo($out);
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>tcfsh lib book</title>
        <link href="info/study_01.css" type="text/css" rel="stylesheet" media="screen">
        <link href="info/layout.css" rel="stylesheet">  
        <script type="text/javascript" src="info/discuss2.js"></script> 
    </head>
</html>
<body>
    <h1><a href="index.php">返回</a></h1>
    <script src="info/discuss.js"></script>
    <h1>請選擇位置</h1>
    <h2>日期：<?php
        $bo="1";
        if($out==0||$out==6){
            $bo="2";
            
        }else{
            $bo="1";
            
        }
        if($_POST['is_hol']=='0'){
            $bo="1";
        }else if($_POST['is_hol']=='1'){
            $bo="2";
        }
        echo($datein);
        /*echo("(");
        switch (intval($out)){
            case 0:
                echo("日");
            case 1:
                echo("一");
            case 2:
                echo("二");
            case 3:
                echo("三");
            case 4:
                echo("四");
            case 5:
                echo("五");
            case 6:
                echo("六");
        }
        echo(") ");
        */
        echo(" ");
        if($bo=="1"){
            echo("16:00-22:00");
        }else{
            echo("8:00-22:00");
        }
    ?>
    <div style="width: 1920px; height: 1080px; top:150px;" onload="deleteele();">
        <?php
        $floor=$_POST['floor'];
        $ao=$floor;
        echo("
            <div class=\"wrap pages pag-seat\">
            <header>
               <div class=\"container\">
               <div class=\"row\">
               </div>
               </div>
             </header>
             <main>
             <div class=\"seat-list\">
        <ul class=\"clearfix\">");
        //echo(htmlentities("curl \"http://210.60.107.235:8080/tchdesk/booking/step1_3".$ao.".jsp?a=".$ao."&b=".$bo."&c=".$datein."\" -b \"JSESSIONID=".$outsession."\" |grep -e '<li class=\"mode-' -e '<a class=\"info\" href=' -e '<div class=\"seat-id\">'"));
        passthru("curl \"http://210.60.107.235:8080/tchdesk/booking/step1_3".$ao.".jsp?a=".$ao."&b=".$bo."&c=".$datein."\" -b \"JSESSIONID=".$outsession."\" |grep -e '<li class=\"mode-' -e '<a class=\"info\" href=' -e '<div class=\"seat-id\">'");
        if($ao=="b"||$ao=="c"){
            passthru("curl \"http://210.60.107.235:8080/tchdesk/booking/step1_3".$ao.".jsp?page=2&a=".$ao."&b=".$bo."&c=".$datein."\" -b \"JSESSIONID=".$outsession."\" |grep -e '<li class=\"mode-' -e '<a class=\"info\" href=' -e '<div class=\"seat-id\">'");
            passthru("curl \"http://210.60.107.235:8080/tchdesk/booking/step1_3".$ao.".jsp?page=3&a=".$ao."&b=".$bo."&c=".$datein."\" -b \"JSESSIONID=".$outsession."\" |grep -e '<li class=\"mode-' -e '<a class=\"info\" href=' -e '<div class=\"seat-id\">'");
            passthru("curl \"http://210.60.107.235:8080/tchdesk/booking/step1_3".$ao.".jsp?page=4&a=".$ao."&b=".$bo."&c=".$datein."\" -b \"JSESSIONID=".$outsession."\" |grep -e '<li class=\"mode-' -e '<a class=\"info\" href=' -e '<div class=\"seat-id\">'");
        }
        echo("</ul></div></main>");
        //exec("curl \"http://210.60.107.235:8080/tchdesk/booking/step1_3a.jsp?a=a&b=1&c=".$datein."\" -b \"JSESSIONID=".$outsession."\"");
        ?>
    </div>

</body>
