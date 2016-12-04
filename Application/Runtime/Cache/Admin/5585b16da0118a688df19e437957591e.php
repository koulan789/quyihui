<?php if (!defined('THINK_PATH')) exit();?><html class="off">
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="/Jimson/Application/Admin/Common/css/style.css">
<title>产品中心</title>
 <style>
        .pager{
            text-align:center;
            padding-bottom:10px;
        }
        .pager a{
            display: inline-block;
            width: 30px;
            height: 30px;
            border: 1px solid blue;
            line-height: 30px;
            margin-right: 5px;
            font-size:16px;
        }
        .pager span{
            display: inline-block;
            width: 30px;
            height: 30px;
        	background-color:gray;
        	border: 1px solid ;
            line-height: 30px;
            margin-right: 5px;
            font-size:16px;
        }
    </style>
</head>
<body scroll="no" style="overflow: hidden;">
<div id="content">
	<div class="right_main">
		<div id="J_rframe" class="rframe_b" style="height: 1000px;">
			<div class="subnav">
				<div class="content_menu ib_a blue line_x"><a class="add fb J_showdialog" href="<?php echo U('Product/add');?>"><em>添加产品</em></a></div>
			</div>
		<form action="<?php echo U('Product/prodcut');?>" method="post">
			<div class="pad_lr_10">
				<div class="J_tablelist table_list">
					<table width="100%" cellspacing="0" border=1>
						<thead>
							<tr>
								<th width="5%"><span tdtype="order_by" fieldname="id">ID</span></th>
								<th  width="8%">产品名称</th>
								<th  width="8%">产品类型</th>
								<th  width="8%">产品尺码</th>
								<th  width="10%">产品颜色</th>
								<th  width="3%">产品价格</th>
								<th  width="3%">产品运费</th>
								<th  width="3%">产品折扣</th>
								<th  width="10%">产品图片</th>
								<th  width="15%">产品描述</th>
								<th  width="15%">产品原料</th>
								<th width="5%">操作</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td align="5%"><?php echo ($vo["id"]); ?></span></td>
								<td  width="5%"><?php echo ($vo["name"]); ?></td>
								<td  width="8%"><?php echo ($vo["cate"]); ?></td>
								<td  width="8%">
								<?php if(is_array($vo["size"])): foreach($vo["size"] as $key=>$v): ?>[<?php echo ($v); ?>]<br/><?php endforeach; endif; ?>
								</td>
								<td  width="10%"><?php echo ($vo["p_color1"]); ?><br/><img src="<?php echo ($vo["color_img1"]); ?>" width='80px' height='60px'><br/><?php echo ($vo["p_color2"]); ?><br/><img src="<?php echo ($vo["color_img2"]); ?>" width='80px' height='60px'></td>
								<th  width="3%">￥<?php echo ($vo["pro_price"]); ?></th>
								<th  width="3%">￥<?php echo ($vo["sendprice"]); ?></th>
								<th  width="3%"><?php echo ($vo['pro_off']*10); ?>折</th>
								<td  width="14%"><img src="<?php echo ($vo["img1"]); ?>" width='80px' height='60px'>&nbsp;<img src="<?php echo ($vo["img2"]); ?>" width='80px' height='60px'>&nbsp;&nbsp;<img src="<?php echo ($vo["img3"]); ?>" width='80px' height='60px'>
								</td>
								<td  width="15%"><?php echo ($vo["p_introduce"]); ?></td>
								<td  width="15%"><?php echo ($vo["p_source"]); ?></td>
								<td width="5%" align="center"><a class="J_showdialog" href="<?php echo U('Product/edit',array('id'=>$vo['id']));?>" >编辑</a> |<a href="javascript:del(<?php echo ($vo['id']); ?>)">删除</a></td>	
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
			</div>
			</form>
			<div class="pager">
				<?php $__FOR_START_25035__=1;$__FOR_END_25035__=$totalpage;for($i=$__FOR_START_25035__;$i < $__FOR_END_25035__;$i+=1){ if($page == $i): ?><span><?php echo ($i); ?></span>
				<?php else: ?>
					<a href="<?php echo U('Product/product',array('page'=>$i));?>"><?php echo ($i); ?></a><?php endif; } ?>
			</div>
		</div>
	</div>
</div>
<script src="/Jimson/Application/Admin/Common/js/jquery.js"></script>
<script>
function del(id){
	if(confirm('你确定要删除该产品的信息吗？')){
		$.post("<?php echo U('Product/del');?>",{id:id},function(data){
			if(data == 0){
				alert("删除成功!!");
				location.reload();
				}
			else if(data ==1){
				alert("删除失败!!");
				location.reload();
			}else if(data ==2){
				alert("请求操作失败，请刷新重试");
			}
				
		},'json')
	}
}
</script>
</body>
</html>