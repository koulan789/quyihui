<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link href="/Jimson/Application/Admin/Common/css/css.css" rel="stylesheet"/>
<title>管理中心</title>
<style>
body {
	background-color:#f6f8f9;
	background-image:none;
}
.login h1 img{ vertical-align:bottom;}
</style>
</head>
<body>
<div class="login"  >
	<form id="myform" action="<?php echo U('Login/login');?>" method="post" onsubmit="return check()">
		<div style="height:23px;"><img src="/Jimson/Application/Admin/Common/image/login-top.jpg" /></div>
		<div class="login-center">
			<ul>
				<li> 用户名:<br /><input name="name" type="text" class="input-text1" value="<?php echo $user?>" style="width:320px;padding:0px 8px;"/></li>
				<li> 密 码:<br /><input name="pass" type="password" class="input-text1" value="<?php echo $pass?>" style="width:320px;padding:0px 8px;"/></li>
				<li> 验证码:<br /><input name="verify_code" type="text" class="input-text1" style="width:140px;padding:0px 8px;"/><img src="<?php echo U('Login/verify');?>"  onclick="this.src=this.src+'?'" class="verify_img" id="verify"  style="cursor:pointer; vertical-align:bottom; margin-left:5px;">点击切换下一张</li>
				<li><input name="remember" type="checkbox" value="1" class="remember-me"/><span class="fz12 fc999 remember-me2">&nbsp;记住我的登录信息</span></li>
			</ul>
		</div>
		<div><img src="/Jimson/Application/Admin/Common/image/login_bottom.jpg" /></div>
		<input type="button" id="btn" value="  " name="do" class="login-button" style="cursor:pointer;"/>
	</form>
</div>
<script language="javascript" type="text/javascript" src="/Jimson/Application/Admin/Common/js/jquery.js"></script>
<script>
$('#btn').click(function(){
	var pass=$("input[name='pass']").val();
	var username=$("input[name='name']").val();
	var verify=$("input[name='verify_code']").val();
	var re=$("input[name='remember']:checked");//是对象类型要循环出来
	var str='';
	re.each(function(){
		str+=$(this).val();
	})
	if($.trim(username)==''){
		 alert ("请输入用户名");
		 return false;
	 }

	 if($.trim(pass)==''){
		 alert ("请输入登录密码");
		 return false;
	 }
	 if(verify==''){
		 alert ("请填写验证码");
		 return false;
	 }
	  $.post("<?php echo U('Login/login');?>",{name:username,pass:pass,verify:verify,remember:str},function(data){
		if(data == 0){
			alert("恭喜您！！登陆成功");
			window.location.assign("<?php echo U('Index/index');?>");
		}else if(data == 1){
			alert("对不起，输入的信息有误");
		}else if(data == 2){
			alert("验证码填写错误！！");
		}
	  },'json');
})
</script>
</body>
</html>