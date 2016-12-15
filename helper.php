<?php
getBaseInfo();
function getBaseInfo()
    {
        $appid = "wx3f358123b685e01a";
        //$redirect_uri = urlencode("http://www.buptparty.cn/server/oauth4.php");
        //$redirect_uri = urlencode("http://www.buptparty.cn/server/weui-master/weui-master/dist/example/room.html");
	///var/www/html/back-end/weui-master/dist/example
        //$redirect_uri = urlencode("http://www.buptparty.cn/back-end/weui-master/dist/example/roommaker.html");
        $redirect_uri = urlencode("http://www.buptparty.cn/back-end/weui-master/dist/example/roommaker_ssr.php");
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
	//$u = "http://www.baidu.com";
        //$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_base&state=123&component_appid=component_appid#wechat_redirect";
        header('location:'.$url);
	//header('location:'.%u);
	//echo $appid;
    }
