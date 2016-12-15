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
	$wechatObj->responseMsg();
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

    public function responseMsg()
    {
		//get post data, May be due to the different environments
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
              		$msgType = "text";
                	$contentStr = "----Party Notice----


*Press the 'Let's Party' button to create a room;

*If you have a room num already , then input the num and have fun;


-------------------";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
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
}

?>
