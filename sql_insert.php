<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$servername = "123.206.16.59";
$username = "root";
$password = "qwerasdf";
$dbname = "WX_User";
//var_dump($_POST);

//$alias = "sssss";
$alias = $_POST['alias'];
$spot = $_POST['spot'];
$theme = $_POST['theme'];
$maxpeo =$_POST['maxpeo'];
$room=$_POST['room'];
$items = $_POST['time'];
$ishost = $_POST['ishost'];
echo $ishost;
//   $curtime=$_POST['curtime'];
//     $xlabel=$_POST['xlabel'];
//    $ylabel=$_POST['ylabel'];

$curtime=time();
$xlabel=0;
$ylabel=0;
$time = array("time1", "time2", "time3", "time4", "time5", "time6", "time7", "time8", "time9", "time10", "time11", "time12",
        "time13", "time14", "time15", "time16", "time17", "time18", "time19", "time20", "time21");
$ct = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
for ($i = 0; $i < count($items); $i++) {
    for ($j = $i + 1; $j <= 21; $j++) {
        if ($items[$i] == $j) {
            $ct[$j - 1] = 1;
            break;
        }
    }
}
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error){
    die("连接失败: " . $conn->connect_error);
}

$sql1 = "insert into content (Alias,Spot,Theme,Max_Peo,Room,Cur_Time,x_label,y_label,ishost)
      values('$alias','$spot','$theme','$maxpeo','$room','$curtime','$xlabel','$ylabel','$ishost');";
$sql2 = "insert into time_table(Alias,Room,time1,time2,time3,time4,time5,time6,time7,time8,time9,time10,time11,time12,time13,time14,time15,time16,time17,time18,time19,time20,time21)
        values('$alias','$room',$ct[0],$ct[1],$ct[2],$ct[3],$ct[4],$ct[5],$ct[6],$ct[7],$ct[8],$ct[9],$ct[10],$ct[11],$ct[12],$ct[13],$ct[14],$ct[15],$ct[16],$ct[17],$ct[18],$ct[19],$ct[20]);";

if ($conn->query($sql1) && $conn->query($sql2) === TRUE)
//if ($conn->query($sql1)  === TRUE)
{
	//var_dump($time);
	//echo $items['0'];
} else {
  echo "Error: " . $sql1 . "<br>" . $conn->error;
}

$sql3="select count(*) as c from time_table where Room=$room;";
$result1 = $conn->query($sql3);
$row1 = $result1->fetch_assoc();
$N=$row1["c"];
echo $N;

if($N == $maxpeo)
{
    //$url = "http://www.buptparty.cn/back-end/weui-master/dist/example/select.php?room=".$room;
    $url = "http://www.buptparty.cn/back-end/weui-master/dist/example/select.php?room=";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch,CURLOPT_POST,1);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch,CURLOPT_POSTFIELDS,"room=$room");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    echo $output;
}
$conn->close();
?>

