<?php
  //获取微信access_token
$room = $_GET["room"];
    $openid = $_GET["openid"];

    $servername = "123.206.16.59";
    $username = "root";
    $password = "qwerasdf";
    $dbname = "WX_User";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
    $qry = "select spot,theme,max_peo from content where room = " . $room;
    $result = $conn->query($qry);
//  var_dump($result);
    $row = $result->fetch_array(MYSQLI_BOTH);
    $spot = $row["spot"];
    $theme = $row["theme"];
    $maxpeople = $row["max_peo"];
    //$spot = $row[]
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

                 聚会制定小程序使用指南：您现在为参与者身份，请选择空闲时间哟 </p>

                <br>
                <p>房间号：<?php echo         $room;?></p>
                <br>
                <p>主题:
                    <?php echo $theme;
//var_dump($row);
 ?>

                </p>
                <br>
                <p>地点:
                    <?php echo $spot; ?>

                </p>

            </div>
            <div class="page__bd page__bd_spacing">
                <ul>



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
                            <a id="create" href="#msg_success" class="weui-btn weui-btn_default">我填好啦</a>
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

        <script type="text/html" id="tpl_msg_success">
            <div class="page">
                <div class="weui-msg">
                    <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
                    <div class="weui-msg__text-area">

                        <p class="weui-msg__desc">您已经成功输入信息，请耐心等候结果</p>
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

        function addData_time() {
            var selectItem = new Array();
            $("input[name='checkbox1']:checked").each(function() {
                selectItem.push($(this).val());// 在数组中追加元素
            });
            data.selectItem = selectItem;
		//alert("ddasdasf");
            console.log(data);

        };

        function sql_insert(){
                        //alert("sssssss");
                        data.room = <?php echo $room ?>;
			data.openid = '<?php echo $openid ?>';
			data.maxpeople = <?php echo $maxpeople ?>;
			data.theme = '<?php echo $theme ?>';
			data.spot = '<?php echo $spot ?>';
			data.ishost = 0;
            //alert(data.room);
                        //data.room = 1230;
                        //console.log(data);
                        //data.openid = <?php echo $o ?>;
            //alert(data.openid);
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
                            time:data.selectItem,
		            ishost:data.ishost
                        },
                        //dataType : "json",
                        error : function(msg) {
                            alert("error");
                        },
                        success : function(msg) {
                            //alert(msg);
                        }
                        });
    }
    </script>
    <script src="./zepto.min.js"></script>

    <script src="./example.js"></script>
</body>
</html>
