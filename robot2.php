<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>新浪发微博</title>
<script  type="text/javascript">
</script>
</head>
<body>
<?php
//获取余额宝收益数据 
$url='http://www.thfund.com.cn/website/funds/fundnet.jsp?fundcode=000198'; 
$lines_string=file_get_contents($url); 
preg_match_all("|<td height=\"34\" [^>]+>(.*)</[^>]+>|U",
    $lines_string,
    $out, PREG_SET_ORDER);
	$date = $out[0][1];
	$profit = $out[1][1];
	$rate = $out[2][1];
echo $date."\n";
echo $profit."\n";
echo $rate."\n";

//比较是否是当天的数据
 echo $today=date("Y-m-d");

 if (strcmp($date, $today)){
     echo "数据未更新"; 
 }
 else
 {
	echo "相等,当天的数据";	
	//判断是否是第一次发微博	
	 echo $formattoday = date ("Y/m/d");
	
	//2.002ah_TDjNEc2B8aec74d914ELKBvB kuaibao
	//2.00wJm9pBMRLwZEa34f8a3ea3kJTKoD  ieason8
	$post_data = array(
		'access_token' => '2.002ah_TDjNEc2B8aec74d914ELKBvB',
		'status' => '#余额宝收益快报# '.$formattoday.' 万份收益'.$profit.' , 七日年化收益率'.$rate.'%'
	);
	$res = send_post('https://api.weibo.com/2/statuses/update.json', $post_data);
	echo $res;
 }
	


 /**
 * 发送post请求
 * @param string $url 请求地址
 * @param array $post_data post键值对数据
 * @return string
 */
function send_post($url, $post_data) {

    $postdata = http_build_query($post_data);
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' => $postdata,
            'timeout' => 15 * 60 // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
	//echo $context;
    $result = file_get_contents($url, false, $context);
 
    return $result;
}
 /*
 sendWeibo($name,$password,$content);

function sendWeibo ($name,$password,$content)
{
 echo $name ;
 echo $password ;
 echo $content ;

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL,"https://api.weibo.com/2/statuses/update.json");
	// 设置是否显示header信息 0是不显示，1是显示  默认为0
	curl_setopt($curl, CURLOPT_HEADER, 0);
	// 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。0显示在屏幕上，1不显示在屏幕上，默认为0
	curl_setopt($curl,CURLOPT_TIMEOUT,10);
	curl_setopt($curl,CURLOPT_HEADER,1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	// 要验证的用户名密码
	curl_setopt($curl, CURLOPT_USERPWD, "{$name}:{$password}");
	curl_setopt($curl,CURLOPT_POST,1);
	curl_setopt($curl,CURLOPT_POSTFIELDS,'status='.urlencode($content));
	$data = curl_exec($curl);
	curl_close($curl);
}
*/