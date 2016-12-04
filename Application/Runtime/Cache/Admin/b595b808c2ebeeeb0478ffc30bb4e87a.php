<?php if (!defined('THINK_PATH')) exit();?><html class="off">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/Jimson/Application/Admin/Common/css/style.css">
    <title>管理中心</title>
</head>
<body>
<div id="header">
    <div class="logo"><a href="#" title="管理中心"></a></div>
    <div class="fr">
        <div class="cut_line admin_info tr">
            <a href="<?php echo U('Index/goback');?>" target="_blank">网站首页</a>
            <span class="cut">|</span><?php echo ($id); ?>：<span class="mr10"><?php echo ($user); ?></span>
            <a href="<?php echo U('Index/reset');?>">[注销]</a>
        </div>
    </div>
</div>
<div id="content">
    <div class="left_menu fl">
        <div id="J_lmenu" class="J_lmenu">
        <?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><h3 class="f14"><span class="J_switchs cu on" title="展开或关闭"></span><?php echo ($vo["name"]); ?></h3>
            <ul>
             <?php if(is_array($vo["son"])): foreach($vo["son"] as $key=>$vo1): if(in_array($vo1['id'],$p)): ?><li class="sub_menu" onclick="change_url('<?php echo U($vo1['link']);?>',this)"><a><?php echo ($vo1["name"]); ?></a></li><?php endif; endforeach; endif; ?>
            </ul><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <div class="right_main">
        <div id="J_rframe" class="rframe_b">
            <iframe id="rframe_0" src="http://dota.178.com/video/.com" frameborder="0" scrolling="auto" style="height:100%;width:100%;"></iframe>
        </div>
    </div>
</div>
<script src="/Jimson/Application/Admin/Common/js/jquery.js"></script>
<script>
    $(".J_switchs").click(function(){
        if($(this).hasClass("on")){
            $(this).removeClass("on");
            $(this).parent().next().css("display","none");
        }else{
            $(this).addClass("on");
            $(this).parent().next().css("display","block");
        }
    })
    function change_url(url,o){
        $("#rframe_0").attr("src",url);
        $(".sub_menu.on").removeClass("on");
        $(".sub_menu.fb").removeClass("fb");
        $(".sub_menu.blue").removeClass("blue");
        $(o).addClass("on fb blue");
    }
</script>
</body>
</html>