<?php if (!defined('THINK_PATH')) exit();?><html class="off">
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="/Jimson/Application/Admin/Common/css/style.css">
<title>产品管理中心</title>
		<link rel="stylesheet" href="/Jimson/Application/Admin/Common/kindeditor/themes/default/default.css" />
		<script src="/Jimson/Application/Admin/Common/kindeditor/kindeditor.js"></script>
		<script src="/Jimson/Application/Admin/Common/kindeditor/lang/zh_CN.js"></script>
		<script charset="utf-8" src="/Jimson/Application/Admin/Common/kindeditor/kindeditor-min.js"></script>
		<!--
		必须引入jquery,后面的循环和赋值需要用到
		1.循环上传按钮、
		2.每个上传按钮的点击事件
		建议点击按钮的class有upload_img
		注意：点击按钮之前要用一个input来存放文件的路径
			input之前需要一个img来显示图片
		-->
		<script src="/Jimson/Application/Admin/Common/jquery.js"></script>
		<script>
			KindEditor.ready(function(K) {
				var editor = K.editor({
					allowFileManager : true
				});
				$(".upload_img").each(function(k,v){ //循环上传按钮、
					$(v).click(function(){ //每个上传按钮的点击事件
						editor.loadPlugin('image', function() {
							editor.plugin.imageDialog({
								imageUrl:$(v).prev().val(),
								clickFn : function(url, title, width, height, border, align) {
									$(v).prev().val(url); //为他之前的input赋值
									$(v).prev().prev().attr("src",url); //为他之前的之前的img赋值
									editor.hideDialog();
								}
							});
						});
					});
				})
			});
		</script>
<link rel="stylesheet" type="text/css" href="<?php echo __CSS ;?>content.css"/>	
</head>
<body scroll="no">
	<div class="right_main">
		<div id="J_rframe" class="rframe_b">
			<div class="subnav"><h1 class="title_2 line_x">修改产品</h1></div>
			<form id="info_form" action="<?php echo U('Product/edit');?>" method="post" onsubmit="check()">
				<div class="pad_lr_10">
					<div class="col_tab">
						<div class="J_panes">
							<div class="content_list pad_10" style="display: block;">
								<table width="100%" cellpadding="2" cellspacing="1" class="table_form">
									<input type="hidden" name="id" value="<?php echo ($res["id"]); ?>">
									<tbody>
										<tr>
											<th width="120">产品所属分类 :</th>
											<td>
												<select class="J_cate_select mr10" id="select1" onchange="change_cate()">
													
													<?php if(is_array($data)): foreach($data as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo['id'] == $res['p_id']): ?>selected<?php endif; ?> >--<?php echo ($vo["name"]); ?>--</option><?php endforeach; endif; ?>
												</select>
												<select class="J_cate_select mr10" name="po_id" id="select2">
												
												</select>
												
											</td>
										</tr>
										<tr>
											<th>产品图片 :</th>
											<td>
													<p>
											            <img src="<?php echo ($res["img1"]); ?>" style="max-width:100px;">
											            <input type="hidden" name="img1" value="<?php echo ($res["img1"]); ?>" />
											            <input type="button" class="upload_img" value="选择图片1" />
											        </p>
											        <br/>
													<p>
														<img src="<?php echo ($res["img2"]); ?>" style="max-width:100px;">
														<input type="hidden" name="img2" value="<?php echo ($res["img2"]); ?>" /> 
														<input type="button" class="upload_img" value="选择图片2" />
													</p>
													<br/>
													<p>
														<img src="<?php echo ($res["img3"]); ?>" style="max-width:100px;">
														<input type="hidden" name="img3" value="<?php echo ($res["img3"]); ?>" /> 
														<input type="button" class="upload_img" value="选择图片3" />
													</p>
											</td>
										</tr>
										<tr>
											<th>产品名称 :</th>
											<td>
												<input type="text" name="name" id="J_title" placeholder="请填写产品名称" value="<?php echo ($res["name"]); ?>" class="input-text" size="40">
											</td>
										</tr>
										<tr>
											<th>产品价格 :</th>
											<td>
												<input type="text" name="pro_price" id="J_title" placeholder="请填写产品价格" value="<?php echo ($res["pro_price"]); ?>" class="input-text" size="40">
											</td>
										</tr>
										<tr>
											<th>产品运费 :</th>
											<td>
												<input type="text" name="sendprice" id="J_title" placeholder="请填写产品运费" value="<?php echo ($res["sendprice"]); ?>" class="input-text" size="40">
											</td>
										</tr>
										<tr>
											<th>产品折扣 :</th>
											<td>
												<input type="text" name="pro_off" id="J_title" placeholder="请填写产品折扣  例如：0.8（8折）" value="<?php echo ($res["pro_off"]); ?>" class="input-text" size="40">
											</td>
										</tr>
										<tr>
											<th>产品尺码 :</th>
											<td>
												<div class="pro_isize">
													<p>
													<?php if(is_array($size)): $i = 0; $__LIST__ = $size;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><span><?php echo ($val["name"]); ?></span><input type="checkbox" <?php if(in_array($val['id'],$p_size)): ?>checked<?php endif; ?> value="<?php echo ($val["id"]); ?>" name="p_size[]">&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
													</p>
												</div>
											</td>
										</tr>
										<tr>
											<th>产品颜色名称1:</th>
											<td>
												<input type="text" name="p_color1" value="<?php echo ($res["p_color1"]); ?>" id="J_title" placeholder="请填写产品颜色名称" class="input-text" size="30">
											</td>
										</tr>
										<tr>
											<th>产品颜色图片1 :</th>
											<td>
													<p>
											            <img src="<?php echo ($res["color_img1"]); ?>" style="max-width:100px;">
											            <input type="hidden" name="color_img1" value="<?php echo ($res["color_img1"]); ?>" />
											            <input type="button" class="upload_img" value="选择图片1" />
											        </p>
											</td>
										</tr>
											<tr>
											<th>产品颜色名称2:</th>
											<td>
												<input type="text" name="p_color2" value="<?php echo ($res["p_color2"]); ?>" id="J_title" placeholder="请填写产品颜色名称" class="input-text" size="30">
											</td>
										</tr>
										<tr>
											<th>产品颜色图片2 :</th>
											<td>
													<p>
											            <img src="<?php echo ($res["color_img2"]); ?>" style="max-width:100px;">
											            <input type="hidden" name="color_img2" value="<?php echo ($res["color_img2"]); ?>" />
											            <input type="button" class="upload_img" value="选择图片2" />
											        </p>
											</td>
										</tr>
										<tr>
											<th>产品描述:</th>
											<td>
												<textarea name="p_introduce" id="text1" style="width:300px;  height:100px;"><?php echo ($res["p_introduce"]); ?></textarea>											</td>
										</tr>
										<tr>
											<th>产品所采用的原料 :</th>
											<td>
												<textarea name="p_source" id="text2" style="width:300px;  height:100px;"><?php echo ($res["p_source"]); ?></textarea>											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="mt10">
							<input type="submit" value="提&nbsp;&nbsp;交" class="btn btn_submit" id="btn">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<script src="/Jimson/Application/Admin/Common/js/jquery.js"></script>
<script>
$('#btn').click(function(){
	var select1=$('#select1').val();
	var select2=$('#select2').val();
	if(select1=='-1'){
		alert("请选择产品的一级分类");
		return false;
	}
	if(select2=='-1'){
		alert("请选择产品的二级分类");
		return false;
	}
	var name=$('input[name="name"]').val();
	if($.trim(name)==''){
		alert ("请输入产品名称");
		return false;
	}
	var pro_price=$('input[name="pro_price"]').val();
	if(pro_price==''){
		alert ('产品价格不能为空');
		return false;
	}
})
//ajax查询分类的方法
    var po_id=<?php echo ($res['po_id']); ?>;
	function change_cate() {
		//获取父级id,ajax传递到php页面,查询出父级下面子分类
		var p_id = $('#select1').val();
		$.post("<?php echo U('Product/change_cate');?>",{p_id:p_id},function(data) {
			if(data.error == 2) {
				alert(data.msg);
			}else {
				//声明一个变量接受返回的结果
				$str = '';
				//each遍历所有相同元素
				$.each(data,function(k,v) {
					//查询出所有子分类
					if(v.id==po_id){
						$str+='<option value="'+v.id+'" selected>'+v.name+'</option>';
					}else{
						$str+='<option value="'+v.id+'">'+v.name+'</option>';
					}
				})
				$('select[name="po_id"]').html($str);
			}
		},'json')
	}
	change_cate(); //每次页面加载后 重新调用一次
</script>
</body>
</html>