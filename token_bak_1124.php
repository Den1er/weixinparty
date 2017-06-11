<?php

//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
if(isset($_GET['echostr']))
{
	$wechatObj->valid();
}
else
{

    if(isset($_POST['room']))
    {
	//echo $_POST;
        $room = $_POST['room'];
        $i = $_POST['i'];
        $num = $_POST['num'];
        $servername = "123.206.16.59";
        $username = "root";
        $password = "qwerasdf";
        $dbname = "WX_User";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error)
        {
            die("连接失败: " . $conn->connect_error);
        }
        $qry = "select alias,spot,theme from content where room = ".$room;
        $result = $conn->query($qry);

        $out_time=array("周一8:00~12:00","周一12:00~17:00","周一17:00~21:00","周二8:00~12:00","周二12:00~17:00","周二17:00~21:00",
    "周三8:00~12:00","周三12:00~17:00","周三17:00~21:00", "周四8:00~12:00","周四12:00~17:00","周四17:00~21:00",
    "周五8:00~12:00","周五12:00~17:00","周五17:00~21:00","周六8:00~12:00","周六12:00~17:00","周六17:00~21:00",
    "周日8:00~12:00","周日12:00~17:00","周日17:00~21:00",);
        while($row = $result->fetch_array(MYSQLI_BOTH))
        {
            $openid = $row['alias'];
            $theme = $row['theme'];
            $spot = $row['spot'];
		//echo $openid,$theme,$spot;
		//echo $openid;
            $wechatObj->SendTemplateMsg($openid, $out_time[$i], $num, $theme, $spot);
        }

        $conn->close();

    }
    else
    {
        $wechatObj->responseMsg();
    }
}

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    /**
     *
     */
    public function responseMsg()
    {
		//get post data, May be due to the differenxt environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
				$this->CreateMenu();
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
				if(!empty( $keyword ))
                {
					//if(is_int($keyword) && $keyword > 999 && $keyword < 10000)
                    //if(is_numeric($keyword) && int($keyword) > 999 && int($keyword) < 10000)
                    if(is_numeric($keyword))
             {
                        $servername = "123.206.16.59";
                        $username = "root";
                        $password = "qwerasdf";
                        $dbname = "WX_User";
                        $conn = new mysqli($servername, $username, $password, $dbname);

            $contentStr = "";

                        if ($conn->connect_error) {
                            die("连接失败: " . $conn->connect_error);
                        }
            //echo "hello";
                        $qry = "select alias,Max_Peo from content where room = " . $keyword;
                        $result = $conn->query($qry);
                        $maxpeople = 0;
                        $openid_count = 0;
                        $alreadyin = 0;
                        while($row = $result->fetch_array(MYSQLI_BOTH))
                        {
                            $maxpeople = $row["Max_Peo"];
                            ++$openid_count;
                if($row["alias"] == $fromUsername)
                {
                $alreadyin = 1;

                }
                //echo $alreadyin;
                //echo </br>;
                            //$contentStr += $row;
                //var_dump($row["alias"]);
                //var_dump($row["Max_Peo"]);
                        }
            //echo $fromUsername;
            if(($openid_count < $maxpeople) && ($alreadyin == 0) )
            {
                $contentStr = "<a href='http://www.buptparty.cn/back-end/weui-master/dist/example/ssr_front.php?room=".$keyword."&openid=".$fromUsername."'>welcome to this room</a>";
            }
            else if($alreadyin ==1)
            {
                //echo "2";
                $contentStr = "You've already in this room";
/*
            $openid = $fromUsername;
            $theme = "ball";
            $spot = "beijing";
		$num = 4;
		//echo $openid,$theme,$spot;
            $this->SendTemplateMsg($openid, "morning", $num, $theme, $spot);
*/		
            }
            else
            {
                //echo "3";
                $contentStr = "The room is full";
            }
                        //$contentStr += $openid_count;
            $msgType = "text";
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;
                    }
					else
					{
						$msgType = "text";
						$contentStr = "----Party Notice----


*Press the 'Let's Party' button to create a room;

*If you have a room num already , then input the num and have fun;


-------------------";
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						echo $resultStr;
					}
                }

        }
		else
		{
        	echo "";
        	exit;
        }
    }

	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	private function Get_Access_Token()
	{
        if($_SESSION['access_token'] && $_SESSION['expired_time'] > time())
        {
	    //var_dump($_SESSION['access_token']);
            return $_SESSION['access_token'];
        }
        else
        {
            $appid = "wx3f358123b685e01a";
            $appsecret = "65cb7d0adb5fafc3944f46565eb3fc8c";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $jsoninfo = json_decode($output, true);
            $access_token = $jsoninfo["access_token"];
            $_SESSION['access_token'] = $access_token;
            $_SESSION['expired_time'] = time() + 7000;
	    //var_dump($_SESSION['access_token']);
            return $access_token;
        }

	}
	public function CreateMenu()
	{
		$jsonmenu = '{
			"button":[
				{
					"name":"发起聚会",
					"type":"view",
					"url":"http://www.buptparty.cn/helper.php"
				}
			]
		}';
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->Get_Access_Token();
		$result = $this->https_request($url, $jsonmenu);
		//var_dump($result);
	}
	private function https_request($url, $data = NULL)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if(!empty($data))
		{
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}
	public function getBaseInfo()
    {
        $appid = "wx3f358123b685e01a";
        $redirect_uri = urlencode("http://www.buptparty.cn/server/oauth2.php");
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=123&component_appid=component_appid#wechat_redirect";
	$u = "http://www.baidu.com";
        //header('location:'.$url);
	header('location:'.$u);
    }
    public function SendTemplateMsg($openid, $time, $num, $theme, $spot)
    {
        $access_token = $this->Get_Access_Token();
	echo $openid,$time,$num,$theme,$spot;
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
        $data=array(
            'touser'=>urlencode($openid),

            'template_id'=>'2KHulnHJOWroFRY3a_7nGG4MW-fTEtpKKvInSyLHPKM',

            //'url'=>"http://www.buptparty.cn",
            'data'=>array(
                'time'=>array(
			      'value'=>$time,
			      'color'=>"#00008B"
			     ),
                'num'=>array(
		             'value'=>urlencode($num),
			     'color'=>"#00008B"
			    ),
                'theme'=>array(
			       'value'=>$theme,
			       'color'=>"#00008B",
			      ),
                'spot'=>array(
			      'value'=>$spot,
			      'color'=>"#00008B",
			     ),
            )
        );
	//var_dump($data);
        $postjson = json_encode($data);
        $output = $this->https_request($url,$postjson);
	var_dump($output);
	echo "\n";
    }
}

?>
