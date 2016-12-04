<?php
namespace Home\Controller;
class SubmitController extends PublicController{
    public function submit_success(){
        if(IS_POST){
            $order_num=I('post.order_num','','htmlspecialchars');
            $price=I('post.price','','htmlspecialchars');
        /*
         * 支付宝支付
         */
       
        //加载支付宝核心文件
        //import('Vendor.Alipay.alipay',dirname(__FILE__),'.config.php');
        $alipay_config=C('Alipay');
        import('Vendor.Alipay.lib.alipay_submit');
        /**************************请求参数**************************/
        
        //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = "http://127.0.0.1/Jimson/index.php/Home/Submit/submit_fail";
        //需http://格式的完整路径，不能加?id=123这类自定义参数
        
        //页面跳转同步通知页面路径
        $return_url = "http://127.0.0.1/create_direct_pay_by_user-PHP-UTF-8/return_url.php";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
        //实例化订单表
        $order=M('order');
        $data=$order->where('order_num="'.$order_num.'"')->find();
        //商户订单号
        
        $out_trade_no = $data['order_num'];
        //商户网站订单系统中唯一订单号，必填
        
        //订单名称
        $subject = "这是我的名称:".date('ymd');
        //必填
        
        //付款金额
        $total_fee = $price+'10';
        //必填
        
        //订单描述
        
        $body = "我的淘宝订单";
        //商品展示地址
        $show_url = 'http://127.0.0.1/Jimson/index.php/Home/Pay/pay.html';
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
        
        //防钓鱼时间戳
        $anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数
        
        //客户端的IP地址
        $exter_invoke_ip = "";
        //非局域网的外网IP地址，如：221.0.0.1
        
        
        /************************************************************/
        
        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($alipay_config['partner']),
            "seller_email" => trim($alipay_config['seller_email']),
            "payment_type"	=> $payment_type,
            "notify_url"	=> $notify_url,
            "return_url"	=> $return_url,
            "out_trade_no"	=> $out_trade_no,
            "subject"	=> $subject,
            "total_fee"	=> $total_fee,
            "body"	=> $body,
            "show_url"	=> $show_url,
            "anti_phishing_key"	=> $anti_phishing_key,
            "exter_invoke_ip"	=> $exter_invoke_ip,
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
        );
        
        //建立请求
        $alipaySubmit = new \AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
     }
   }
   public function submit_fail(){
/* *
 * 功能：支付宝服务器异步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。


 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
 */

require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代

	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	
    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
	
	//商户订单号

	$out_trade_no = $_POST['out_trade_no'];

	//支付宝交易号

	$trade_no = $_POST['trade_no'];

	//交易状态
	$trade_status = $_POST['trade_status'];


    if($_POST['trade_status'] == 'TRADE_FINISHED') {
		//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
				
		//注意：
		//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        $order_num=$_POST['tade_no'];
        $res=M('order');
        $res->where('order_num='.$order_num)->setField('status',1);
        }
	
        }
   }
}