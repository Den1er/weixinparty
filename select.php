<?php
/**
 * Created by PhpStorm.
 * User: jianjian
 * Date: 2016/12/10
 * Time: 10:56
 */
$servername = "123.206.16.59";
$username = "root";
$password = "qwerasdf";
$dbname = "WX_User";
//$room=_GET["room"];
$room = $_POST["room"];

$time=array("time1","time2","time3","time4","time5","time6","time7","time8","time9","time10","time11","time12",
"time13","time14","time15","time16","time17","time18","time19","time20","time21");

$out_time=array("周一8:00~12:00","周一12:00~17:00","周一17:00~21:00","周二8:00~12:00","周二12:00~17:00","周二17:00~21:00",
    "周三8:00~12:00","周三12:00~17:00","周三17:00~21:00", "周四8:00~12:00","周四12:00~17:00","周四17:00~21:00",
    "周五8:00~12:00","周五12:00~17:00","周五17:00~21:00","周六8:00~12:00","周六12:00~17:00","周六17:00~21:00",
    "周日8:00~12:00","周日12:00~17:00","周日17:00~21:00",);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
    die("连接失败: " . $conn->connect_error);
}

$sql1="select count(*) as c from time_table where Room=$room;";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();
$N=$row1["c"];

for($i=0;$i<=20;$i++) {
    $sql = "select sum($time[$i]) as s from time_table where Room=$room;";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($row["s"] ==$N) {
        echo "There are ".$N." people going to the party.";
        echo "The time is ".$out_time[$i];
        break;
    }
}

$url = "http://www.buptparty.cn/token_bak_1124.php";
echo $url;
$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_POSTFIELDS,"room=$room&i=$i&num=$N");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);
echo $output;

/*    $sql="select sum(time1),sum(time2),sum(time3),sum(time4),sum(time5),sum(time6),sum(time7),sum(time8),sum(time9),
         sum(time10),sum(time11),sum(time12),sum(time13),sum(time14),sum(time15),sum(time16),sum(time17),sum(time18),sum(time19),
        sum(time20),sum(time21)from time_table;";*/

$conn->close();
?>
