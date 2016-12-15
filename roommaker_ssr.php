<?php
  //获取微信access_token
 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 function getaccess_token(){
    $code = $_GET['code'];
    $appid = 'wx3f358123b685e01a';
    $appsecret = '65cb7d0adb5fafc3944f46565eb3fc8c';
    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
    $data = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($data,true);
    return $data;
 }
//获取用户详细信息
 function getinfo(){
   $data =  getaccess_token();
   $access_token = $data['access_token'];
   $openid = $data['openid'];
    $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
    $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
 }
//getinfo();
		$inf = getinfo();
                $jsoninfo = json_decode($inf,true);
                $o = $jsoninfo["openid"];
?>

<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>聚会制定</title>
    <link rel="stylesheet" href="../style/weui.css"/>
    <link rel="stylesheet" href="./example.css"/>
    <script type="text/javascript">
    	var data = {};
    </script>
</head>
<body ontouchstart>
    <div class="weui-toptips weui-toptips_warn js_tooltips">错误提示</div>
    <div class="container" id="container"></div>
    <script type="text/html" id="tpl_home">
        <div class="page">
            <div class="page__hd">
                <h1 class="page__title">
                    <img src="./images/timu.png" alt="weui" height="63px" />
                </h1>
                <p class="page__desc">聚会制定小程序使用指南：
                <?php
                //$inf = getinfo();
                //$jsoninfo = json_decode($inf,true);
		//$o = $jsoninfo["openid"];
		//$openif = $jsoninfo["openid"];
		//var_dump($jsoninfo);
                echo $jsoninfo["nickname"];
                //echo $inf[nickname];
		//echo $o;

                ?> 您好，您现在为房主身份，可以通过填写聚会主题、地点、日期、时间创建房间，其他参与聚会人员可通过房间号进入相应房间并选择空闲时间 </p>
            </div>
            <div class="page__bd page__bd_spacing">
                <ul>
                    <li>
                        <div class="weui-flex js_category">
                            <a class="weui-cell weui-cell_access js_item" data-id="maxpeople" href="javascript:;">
                                <div class="weui-cell__bd">
                                   <p>最大人数</p>
                                </div>
                                <div class="weui-cell__ft"></div>
                            </a>
                        </div>
                    </li>
                    <li>

                        <div class="weui-flex js_category">
                            <a class="weui-cell weui-cell_access js_item" data-id="subject" href="javascript:;">
                                <div class="weui-cell__bd">
                                   <p>主题</p>
                                </div>
                                <div class="weui-cell__ft"></div>
                            </a>
                        </div>
                    </li>
                    <li>

                        <div class="weui-flex js_category">
                            <a class="weui-cell weui-cell_access js_item" data-id="place" href="javascript:;">
                                <div class="weui-cell__bd">
                                   <p>地点</p>
                                </div>
                                <div class="weui-cell__ft"></div>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="weui-flex js_category">
                            <a class="weui-cell weui-cell_access js_item" data-id="time" href="javascript:;">
                                <div class="weui-cell__bd">
                                   <p>时间</p>
                                </div>
                                <div class="weui-cell__ft"></div>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="page__bd page__bd_spacing">
                            <a id="create" href="#msg_success" class="weui-btn weui-btn_default">创建房间</a>
                        </div>
                    </li>

                </ul>
            </div>
            <div class="page__ft">
                <a href="javascript:home()"><img src="./images/icon_footer.png"></a>
            </div>
        </div>
        <script type="text/javascript">
            $(function(){
                var winH = $(window).height();
                var categorySpace = 10;

                $('.js_item').on('click', function(){
                    var id = $(this).data('id');
                    window.pageManager.go(id);
                });
                $('.js_category').on('click', function(){
                    var $this = $(this),
                    $inner = $this.next('.js_categoryInner'),
                    $page = $this.parents('.page'),
                    $parent = $(this).parent('li');
                    var innerH = $inner.data('height');
                    bear = $page;
                    if (!innerH) {
                        $inner.css('height', 'auto');
                        innerH = $inner.height();
                        $inner.removeAttr('style');
                        $inner.data('height', innerH);
                    }
                    if ($parent.hasClass('js_show')) {
                        $parent.removeClass('js_show');
                    }
                    else{
                        $parent.siblings().removeClass('js_show');
                        $parent.addClass('js_show');
                        if (this.offsetTop + this.offsetHeight + innerH > $page.scrollTop() + winH) {
                            var scrollTop = this.offsetTop + this.offsetHeight + innerH - winH + categorySpace;
                            if (scrollTop > this.offsetTop) {
                                scrollTop = this.offsetTop - categorySpace;
                            }
                            $page.scrollTop(scrollTop);
                        }
                    }
                });

                $(function(){
                    var $tooltips = $('.js_tooltips');
                    $('.showTooltips').on('click', function(){
                        if ($tooltips.css('display') != 'none') return;
                        // toptips的fixed, 如果有`animation`, `position: fixed`不生效
                        $('.page.cell').removeClass('slideIn');
                        $tooltips.css('display', 'block');
                        setTimeout(function(){
                            $tooltips.css('display', 'none');
                        },2000);
                    });
                });
            });
        </script>
        <script type="text/html" id="tpl_maxpeople">
            <div class="page">
                <div class="page__hd">
                    <h1 class="page__title">最大人数</h1>
                </div>
                <div class="page__bd">
                    <div class="weui-cells__title">最大人数</div>
                    <div class="weui-cells">
                        <div class="weui-cell">
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" placeholder="请输入最大人数" id="max_people"/>
                            </div>
                        </div>
                    </div>
                    <div class="weui-btn-area">
                        <a class="weui-btn weui-btn_primary showTooltips" href="javascript:history.back();" onclick="addData_people()">确定</a>
                    </div>
                </div>
            </div>
        </script>
        <script type="text/html" id="tpl_place">
            <div class="page">
                <div class="page__hd">
                    <h1 class="page__title">聚会地点</h1>
                </div>
                <div class="page__bd">
       <!--注释国家 begin
                <div class="weui-cells__title">国家</div>
                    <div class="weui-cells">
                        <div class="weui-cell">
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" placeholder="请输入国家"/>
                            </div>
                        </div>
                    </div>
      -->

                    <div class="weui-cells__title">聚会地点</div>
                    <div class="weui-cells">
                        <div class="weui-cell">
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" placeholder="请输入聚会地点" id="spot"/>
                            </div>
                        </div>
                    </div>
                    <div class="weui-btn-area">
                        <a class="weui-btn weui-btn_primary showTooltips" href="javascript:history.back();" onclick="addData_spot()">确定</a>
                    </div>
                </div>
            </div>
        </script>
        <script type="text/html" id="tpl_time">
            <div class="page">
                <div class="page__hd">
                    <h1 class="page__title">空闲时间</h1>
                </div>
                <div class="page__bd">
                    <div class="weui-cells__title">选择空闲时间（可多选）</div>
                    <div class="weui-cells weui-cells_checkbox">
                        <label class="weui-cell weui-check__label" for="s11">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s11" checked="checked" value="1">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周一8:00~12:00</p>
                            </div>
                        </label>
                        <label class="weui-cell weui-check__label" for="s12">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s12" checked="checked" value="2">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周一12:00~17:00</p>
                            </div>
                        </label>
                        <label class="weui-cell weui-check__label" for="s13">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s13" checked="checked" value="3">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周一17:00~21:00</p>
                            </div>
                        </label>
                       <label class="weui-cell weui-check__label" for="s21">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s21" checked="checked" value="4">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周二8:00~12:00</p>
                            </div>
                        </label>
                        <label class="weui-cell weui-check__label" for="s22">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s22" checked="checked" value="5">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周二12:00~17:00</p>
                            </div>
                        </label>
                        <label class="weui-cell weui-check__label" for="s23">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s23" checked="checked" value="6">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周二17:00~21:00</p>
                            </div>
                        </label>
                         <label class="weui-cell weui-check__label" for="s31">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s31" checked="checked" value="7">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周三8:00~12:00</p>
                            </div>
                        </label>
                        <label class="weui-cell weui-check__label" for="s32">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s32" checked="checked" value="8">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周三12:00~17:00</p>
                            </div>
                        </label>
                        <label class="weui-cell weui-check__label" for="s33">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s33" checked="checked" value="9">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周三17:00~21:00</p>
                            </div>
                        </label>
                         <label class="weui-cell weui-check__label" for="s41">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s41" checked="checked" value="10">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周四8:00~12:00</p>
                            </div>
                        </label>
                        <label class="weui-cell weui-check__label" for="s42">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s42" checked="checked" value="11">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周四12:00~17:00</p>
                            </div>
                        </label>
                        <label class="weui-cell weui-check__label" for="s43">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s43" checked="checked" value="12">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周四17:00~21:00</p>
                            </div>
                        </label>
                         <label class="weui-cell weui-check__label" for="s51">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s51" checked="checked" value="13">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周五8:00~12:00</p>
                            </div>
                        </label>
                        <label class="weui-cell weui-check__label" for="s52">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s52" checked="checked" value="14">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周五12:00~17:00</p>
                            </div>
                        </label>
                        <label class="weui-cell weui-check__label" for="s53">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s53" checked="checked" value="15">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周五17:00~21:00</p>
                            </div>
                        </label>
                         <label class="weui-cell weui-check__label" for="s61">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s61" checked="checked" value="16">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周六8:00~12:00</p>
                            </div>
                        </label>
                        <label class="weui-cell weui-check__label" for="s62">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s62" checked="checked" value="17">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周六12:00~17:00</p>
                            </div>
                        </label>
                        <label class="weui-cell weui-check__label" for="s63">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s63" checked="checked" value="18">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周六17:00~21:00</p>
                            </div>
                        </label>
                         <label class="weui-cell weui-check__label" for="s71">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s71" checked="checked" value="19">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周日8:00~12:00</p>
                            </div>
                        </label>
                        <label class="weui-cell weui-check__label" for="s72">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s72" checked="checked" value="20">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周日12:00~17:00</p>
                            </div>
                        </label>
                        <label class="weui-cell weui-check__label" for="s73">
                            <div class="weui-cell__hd">
                                <input type="checkbox" class="weui-check" name="checkbox1" id="s73" checked="checked" value="21">
                                <i class="weui-icon-checked"></i>
                            </div>
                            <div class="weui-cell__bd">
                                <p>周日17:00~21:00</p>
                            </div>
                        </label>
                    </div>
                    <div class="weui-btn-area">
                        <a class="weui-btn weui-btn_primary showTooltips" href="javascript:history.back();" onclick="addData_time();">确定</a>
                    </div>
                </div>
            </div>
        </script>
        <script type="text/html" id="tpl_subject">
            <div class="page">
                <div class="page__hd">
                    <h1 class="page__title">聚会主题</h1>
                </div>
                <div class="page__bd">
                    <div class="weui-cells">
                        <div class="weui-cell">
                            <div class="weui-cell__bd">
                                <input id="theme" class="weui-input" type="text" placeholder="请输入聚会主题"/>
                            </div>
                        </div>
                    </div>
                    <div class="weui-btn-area">
                        <a class="weui-btn weui-btn_primary showTooltips" href="javascript:history.back();" onclick="addData();">确定</a>
                    </div>
                </div>
            </div>
        </script>
        <script type="text/html" id="tpl_msg_success">
            <div class="page">
                <div class="weui-msg">
                    <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
                    <div class="weui-msg__text-area">
                        <h2 class="weui-msg__title">您的房间号为：</h2>
                        <h1>
                            <?php
                            $room = mt_rand(1000,9999);
                            echo $room;
                            ?>
                        </h1>
                        <p class="weui-msg__desc">您已经成功创建房间，快分享房间号码给小伙伴吧！</p>
                    </div>
                    <div class="weui-msg__opr-area">
                        <p class="weui-btn-area">
                            <a href="javascript:history.back();" class="weui-btn weui-btn_primary" onclick="sql_insert()">确定</a>

                        </p>
                    </div>
                </div>
            </div>
        </script>
    </script>
    <script type="text/html" id="tpl_grid"></script>
    <script type="text/javascript">
    	var data = {};
		function addData() {
			data.theme = document.getElementById("theme").value;
                        data.openid = '<?php echo $o ?>';
			console.log(data);
		};
        function addData_time() {
            var selectItem = new Array();
            $("input[name='checkbox1']:checked").each(function() {
                selectItem.push($(this).val());// 在数组中追加元素
            });
            data.selectItem = selectItem;
            console.log(data);

        };
        function addData_spot() {
            data.spot = document.getElementById("spot").value;
            console.log(data);
        };
        function addData_people() {
            data.maxpeople = document.getElementById("max_people").value;
            console.log(data);
        }
        function sql_insert(){
                        //alert("sssssss");
                        data.room = <?php echo $room ?>;
			//alert(data.room);
                        //data.room = 1230;
                        //console.log(data);
                        //data.openid = <?php echo $o ?>;
			alert(data.openid);
                        //data.openid = 11111111111111111111;
			//alert(data.openid);
                        $.ajax({
                        type : "post",
                        url : "http://www.buptparty.cn/back-end/weui-master/dist/example/sql_insert.php",
                        data : {
                            alias:data.openid,
                            maxpeo:data.maxpeople,
                            spot:data.spot,
                            theme:data.theme,
                            room:data.room,
                            time:data.selectItem
                        },
                        //dataType : "json",
                        error : function(msg) {
                            alert("error");
                        },
                        success : function(msg) {
                            alert(msg);
                        }
                        });
    }
    </script>
    <script src="./zepto.min.js"></script>

    <script src="./example.js"></script>
</body>
</html>
