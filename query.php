<?php
$servername = "123.206.16.59";
$username = "root";
$password = "qwerasdf";
$dbname = "WX_User";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
    die("连接失败: " . $conn->connect_error);
}

$sql="select Cur_Time,Room from content where ishost=1;";
//$sql="select * from content where ishost=1;";
$result = $conn->query($sql);
while($row = $result->fetch_array(MYSQLI_BOTH))
{
    $cur_time = $row['Cur_Time'];
    $room = $row['Room'];
echo	$room;
echo $cur_time;
    if( (time()-$cur_time) > 300 )
    {
	//echo $time();
        $url = "http://www.buptparty.cn/back-end/weui-master/dist/example/select.php";
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

	$sql_update = "update content set ishost=0 where Room=$room;";
	$conn_res = $conn->query($sql_update);

    }
}




?>
