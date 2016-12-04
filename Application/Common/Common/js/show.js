$(window).resize(function(){
    location.reload()
});
$(document).ready(function(){
	//首页产品中心轮播
	SwiperPic();
	$(window).resize(function() {
		SwiperPic();
	});
	
	//导航默认显示
	$("nav li").hover(function(){
		$("nav li").eq($(this).index()).find("a").css({"color":"#b8e40b"});
	});
	
	//移动端导航显示	
	$(".phone_menu").click(function(){
		$(".nav").stop().slideToggle(1000);
	});
	
	//产品中心详情页,选择商品参数类型
	$(".products .pro_right div>img").eq(0).addClass("toblock");
	$(".products .pro_right div ul li img").eq(0).addClass("line")
	$(".products .pro_right div ul li").click(function(){
		$(this).siblings().find("img").removeClass("line");
		$(this).find("img").addClass("line");
		$(".products .pro_right div>img").removeClass("toblock");
		$(".products .pro_right div>img").eq($(this).index()).addClass("toblock");

	});
	$(".products .pro_isize p span").click(function(){
		$(".products .pro_isize p span").removeClass("addBorder").eq($(this).index()).addClass("addBorder");
	});
	$(".products .pro_istyle p").click(function(){
		$(".products .pro_istyle p").find("img").removeClass("addBorder");
		$(".products .pro_istyle p").eq($(this).index()).find("img").addClass("addBorder");
	});
	
	$(".products .pro_imore span").eq(0).addClass("bg");
	$(".products .pro_imore span").click(function(){
		$(".products .pro_imore span").removeClass("bg").eq($(this).index()).addClass("bg")
		$(".products .pro_imore p").eq($(this).index()).css({"display":"block"}).siblings("p").css({"display":"none"})
	});
	
	//会员中心box内标题虚线宽
	var boxW = $(".box").width();
	if(boxW>=700){
		$(".article_title p").css({"width":boxW-100+"px"});
	}else{
		$(".article_title p").css({"width":boxW-80+"px"});
	}
	
	//会员中心显示个人信息
	var winW = $(document).width();
	if(winW<=767){
		$(".vip .inbox .user_img").click(function(){
			$(".vip .inbox .user_img span").css({"display":"none"});
			$(".vip .user_infor").show(1000);
		});
		$(".vip .user_infor").click(function(){
			$(".vip .inbox .user_img span").css({"display":"inline"});
			$(".vip .user_infor").hide(1000);
		});
	}
	//修改默认地址shipping—address
	
	if(winW>=767){
		$(".address>div>div").eq(0).addClass("add_bg");
		$(".address>div>div").eq(0).find("p span").addClass("show");
		$(".address>div>div").eq(0).find("a").addClass("show");
		$(".address>div>div .check").click(function(){
			$(this).parent("div").addClass("add_bg").siblings().removeClass("add_bg");
			$(this).parent("div").find("p span").addClass("show").parents().siblings().find("p span").removeClass("show");
			$(this).parent("div").find("a").addClass("show").parent().siblings().find("a").removeClass("show");
		});
	}else{
		$(".address>div>div").eq(0).addClass("add_bg");
		$(".address>div>div").eq(0).find("p span").addClass("show");
		$(".address>div>div").eq(0).find("a").addClass("show2");
		$(".address>div>div .check").click(function(){
			$(this).parent("div").addClass("add_bg").siblings().removeClass("add_bg");
			$(this).parent("div").find("p span").addClass("show").parents().siblings().find("p span").removeClass("show");
			$(this).parent("div").find("a").addClass("show2").parent().siblings().find("a").removeClass("show2");
		});
	}
	
	//会员中心—确认订单总价
	$(".confirm .row .add").click(function(){
		var num = parseInt($(this).siblings(".num")[0].innerHTML);
		num++;
		$(this).siblings(".num")[0].innerHTML = num;
		$(this).parent(".cart_num").siblings(".money").find("span")[0].innerHTML = "￥"+(788.8*num).toFixed(1);
		document.getElementsByName("total_price")[0].innerHTML = (788.8*num).toFixed(1);
		document.getElementsByName("total_price")[1].innerHTML = (788.8*num).toFixed(1);
	});
	$(".confirm .row .cut").click(function(){
		var num = parseInt($(this).siblings(".num")[0].innerHTML);
		num--;
		if(num<1){num=1;}
		$(this).siblings(".num")[0].innerHTML = num;
		$(this).parent(".cart_num").siblings(".money").find("span")[0].innerHTML = "￥"+(788.8*num).toFixed(1);
		document.getElementsByName("total_price")[0].innerHTML = (788.8*num).toFixed(1);
		document.getElementsByName("total_price")[1].innerHTML = (788.8*num).toFixed(1);
	});
	
	//redio选中时改变背景
	$(".check").find("input").filter(':checked').parent().addClass("oncheck");
	$(".address .check").find("input").filter(':checked').parent().addClass("oncheck");
	$(".sex .check").click(function(){
		$(this).find("input").filter(':checked').parent().addClass("oncheck").siblings().removeClass("oncheck");
	});
	$(".address .check").click(function(){
		$(this).find("input").filter(':checked').parent().addClass("oncheck").parent().siblings().find(".check").removeClass("oncheck");
	});
	$(".pay_way .check").click(function(){
		$(this).find("input").filter(':checked').parent().addClass("oncheck").siblings().removeClass("oncheck");
	});
	$(".pay_bank ul .check").click(function(){
		$(this).find("input").filter(':checked').parent().addClass("oncheck").parent().siblings().find(".check").removeClass("oncheck");
	});
	$(".add_address .check").click(function(){
		$(this).find("input").filter(':checked').parent().addClass("oncheck");
	});
	//checkbox选中时改变背景
	$(".checkbox").click(function(){
		if($(this).find("input").is(':checked')){
			$(this).addClass("onclick");
		}else{
			$(this).removeClass("onclick");
		}
	});
	$(".shopping_cart .all .checkbox").click(function(){
		if($(this).find("input").is(':checked')){
			$(this).addClass("onclick");
		}else{
			$(this).removeClass("onclick");
		}
	});
	$(".shopping_cart .checkbox").eq(0).click(function(){
		if($(this).find("input").is(':checked')){
			$(".checkbox").addClass("onclick");
		}else{
			$(".checkbox").removeClass("onclick");
		}
	});
	$(".shopping_cart .all .checkbox").click(function(){
		if($(this).find("input").is(':checked')){
			$(".shopping_cart .checkbox").addClass("onclick");
		}else{
			$(".checkbox").removeClass("onclick");
		}
	});
});
function SwiperPic() {
	var bodyW = $("body").width();
	var View = 0;
	if(bodyW > 1200) {
		View = 4;
	} else if(bodyW > 992 && bodyW <= 1200) {
		View = 3;
	} else if(bodyW > 768 && bodyW <= 992) {
		View = 2;
	} else if(bodyW <= 760) {
		View = 1;
	}
	var pro_show = new Swiper('.index_content', {
//	        pagination: '.index_banner .hd',
			slidesPerView: View,
//	        autoplay: 5000,
	        paginationClickable: true,
	        effect : 'slide',
	        /*direction : 'vertical',*//* 相当于surper.js里的effect：'top' */
	        nextButton: '.content_index .change .index_next',
	        prevButton: '.content_index .change .index_prev',
	    });
}







