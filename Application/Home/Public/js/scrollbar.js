$(document).ready(function(){
	//滚动条
	$("#box").niceScroll({
		cursorcolor:"#B8E40B",// 设置光标颜色
		cursoropacitymin:1, // 设置非活动状态光标透明度，取值范围0-1，默认为0。 
		cursoropacitymax:1, //设置活动状态光标透明度，取值范围0-1，默认为1。
		cursorwidth:"3px", //设置光标宽度 
		cursorborderradius:"0px", //设置光标圆角，默认5px
		zindex:"auto", // 设置滚动条的层数值
		scrollspeed:60, //滚动速度，单位秒
		mousescrollstep:40, //每次滚动距离
		touchbehavior:false, //设置触摸滑动。默认值false
		hwacceleration:true, //使用硬件加速滚动支持
		boxzoom:false, // 设置是否可以放大容器，默认值false
		dblclickzoom:true, //双击放大/缩小容器（当boxzoom为true有效）。默认值为true 
		gesturezoom:true, // 是否支持手指缩进或放大容器（当boxzoom为true并且在touch设备上）
		grabcursorenabled:true,//设置是否显示为grab（手掌）状态(当touchbehavior=true生效)
		autohidemode:false, // 怎样隐藏滚动条，可能的值有： 
		//true |  当不滚动隐藏   "cursor" | //仅光标隐藏   false | // 不隐藏   "leave" | // 当光标离开容器时隐藏    "hidden" | // 总是隐藏  "scroll", //仅滚动时显示
		background:"#000", // 设置滚动条背景颜色
		iframeautoresize:true, // 当框架载入时自动设置大小 
		cursorminheight:30, // 设置光标最小大小
		preservenativescrolling:true, //设置是否可以使用鼠标滚动, 冒泡鼠标滚动事件
		railoffset:false, //添加滚动位移
		bouncescroll:false, // 设置是否显示反弹（需要硬件支持） 
		spacebarenabled:true, // 设置是否支持空格键滚动
		railpadding: { top:0, right:0, left:0, bottom:0 }, // 设置滚动条距离边框的距离
		disableoutline:true, // for chrome browser, disable outline (orange highlight) when selecting a div with nicescroll禁用nicesroll容器选中时chrome浏览器默认产生轮廓线（黄 色高亮
		horizrailenabled:true, //设置nicescroll是否美化水平滚动条 
		//railalign: right, //滚动条水平对齐方式 
		//railvalign: bottom, // 滚动条垂直对齐方式   
		enabletranslate3d:true, // 设置nicescroll是否可以使用CSS translate属性滚动内容 
		enablemousewheel:true, // 设置nicescroll是否可以管理鼠标事件 
		enablekeyboard:true, //设置nicescroll是否可以管理键盘事件 
		smoothscroll:true, //平滑滚动
		sensitiverail:true, // 点击滚动条，滚动到指定位置
		enablemouselockapi:true, // 可以使用鼠标扑捉API（在对象拽托存在一些问题）*这一句蒙的can use mouse caption lock API (same issue on object dragging)
		cursorfixedheight:30, //设置固定高度游标
		hidecursordelay:400, //设置光标隐藏延迟时间
		directionlockdeadzone:6, //不懂 dead zone in pixels for direction lock activation 
		nativeparentscrolling:true, // 不懂detect bottom of content and let parent to scroll, as  native scroll does
		enablescrollonselection:true, // 设置选择文本时是否自动滚动
		cursordragspeed:0.3, // 设置选中文本时光标滚动速度 
		rtlmode:"auto", //水平滚动条从左方开始
		cursordragontouch:false, // touch设备上鼠标展现拽托状态drag cursor in touch /touchbehavior mode also
		oneaxismousemode:"auto", // it permits horizontal scrolling with mousewheel on horizontal only content, if false (vertical-only) mousewheel don't scroll horizontally, if value is auto detects two-axis mouse
		scriptpath:""// define custom path for boxmode icons ("" => same script path)
	});

	var winW = $(document).width();
	if(winW<=767){
		$(".phone_scro").niceScroll({
			cursorcolor:"#B8E40B",// 设置光标颜色
			cursoropacitymin:1, // 设置非活动状态光标透明度，取值范围0-1，默认为0。 
			cursoropacitymax:1, //设置活动状态光标透明度，取值范围0-1，默认为1。
			cursorwidth:"3px", //设置光标宽度 
			cursorborderradius:"0px", //设置光标圆角，默认5px
			zindex:"auto", // 设置滚动条的层数值
			scrollspeed:60, //滚动速度，单位秒
			mousescrollstep:40, //每次滚动距离
			touchbehavior:false, //设置触摸滑动。默认值false
			hwacceleration:true, //使用硬件加速滚动支持
			boxzoom:false, // 设置是否可以放大容器，默认值false
			dblclickzoom:true, //双击放大/缩小容器（当boxzoom为true有效）。默认值为true 
			gesturezoom:true, // 是否支持手指缩进或放大容器（当boxzoom为true并且在touch设备上）
			grabcursorenabled:true,//设置是否显示为grab（手掌）状态(当touchbehavior=true生效)
			autohidemode:false, // 怎样隐藏滚动条，可能的值有： 
			//true |  当不滚动隐藏   "cursor" | //仅光标隐藏   false | // 不隐藏   "leave" | // 当光标离开容器时隐藏    "hidden" | // 总是隐藏  "scroll", //仅滚动时显示
			background:"#000", // 设置滚动条背景颜色
			iframeautoresize:true, // 当框架载入时自动设置大小 
			cursorminheight:30, // 设置光标最小大小
			preservenativescrolling:true, //设置是否可以使用鼠标滚动, 冒泡鼠标滚动事件
			railoffset:false, //添加滚动位移
			bouncescroll:false, // 设置是否显示反弹（需要硬件支持） 
			spacebarenabled:true, // 设置是否支持空格键滚动
			railpadding: { top:0, right:0, left:0, bottom:0 }, // 设置滚动条距离边框的距离
			disableoutline:true, // for chrome browser, disable outline (orange highlight) when selecting a div with nicescroll禁用nicesroll容器选中时chrome浏览器默认产生轮廓线（黄 色高亮
			horizrailenabled:true, //设置nicescroll是否美化水平滚动条 
			//railalign: right, //滚动条水平对齐方式 
			//railvalign: bottom, // 滚动条垂直对齐方式   
			enabletranslate3d:true, // 设置nicescroll是否可以使用CSS translate属性滚动内容 
			enablemousewheel:true, // 设置nicescroll是否可以管理鼠标事件 
			enablekeyboard:true, //设置nicescroll是否可以管理键盘事件 
			smoothscroll:true, //平滑滚动
			sensitiverail:true, // 点击滚动条，滚动到指定位置
			enablemouselockapi:true, // 可以使用鼠标扑捉API（在对象拽托存在一些问题）*这一句蒙的can use mouse caption lock API (same issue on object dragging)
			cursorfixedheight:30, //设置固定高度游标
			hidecursordelay:400, //设置光标隐藏延迟时间
			directionlockdeadzone:6, //不懂 dead zone in pixels for direction lock activation 
			nativeparentscrolling:true, // 不懂detect bottom of content and let parent to scroll, as  native scroll does
			enablescrollonselection:true, // 设置选择文本时是否自动滚动
			cursordragspeed:0.3, // 设置选中文本时光标滚动速度 
			rtlmode:"auto", //水平滚动条从左方开始
			cursordragontouch:false, // touch设备上鼠标展现拽托状态drag cursor in touch /touchbehavior mode also
			oneaxismousemode:"auto", // it permits horizontal scrolling with mousewheel on horizontal only content, if false (vertical-only) mousewheel don't scroll horizontally, if value is auto detects two-axis mouse
			scriptpath:""// define custom path for boxmode icons ("" => same script path)
		});
	}
});








