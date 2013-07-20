<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>新浪发微博</title>
<script type="text/javascript">
</script>
</head>
<body>
	<?php
	$filename = "info.xml";
	#获取余额宝收益数据
	$url='http://www.thfund.com.cn/website/funds/fundnet.jsp?fundcode=000198';
	$lines_string=file_get_contents($url);
	preg_match_all("|<td height=\"34\" [^>]+>(.*)</[^>]+>|U",
	$lines_string,
	$out, PREG_SET_ORDER);
	$date = $out[0][1];
	$profit = $out[1][1];
	$rate = $out[2][1];
	

	#比较是否是当天的数据
	echo $today=date("Y-m-d");

	if (strcmp($date, $today)){
		echo "数据未更新";
	}
	else
	{		
		echo "相等,当天的数据";
		if(is_first($filename)){		
			#发微博
			//2.002ah_TDjNEc2B8aec74d914ELKBvB kuaibao
			//2.00wJm9pBMRLwZEa34f8a3ea3kJTKoD  ieason8			
			$formattoday = date ("Y/m/d");
			$post_data = array(
					'access_token' => '2.002ah_TDjNEc2B8aec74d914ELKBvB',
					'status' => '#余额宝收益快报# '.$formattoday.' 万份收益'.$profit.' , 七日年化收益率'.$rate.'%'
			);
			$res = send_post('https://api.weibo.com/2/statuses/update.json', $post_data);
			#添加记录			
			$record = array();
			$record['date'] = $today;
			$record['code'] = '000198';
			$record['profit'] = $profit;
			$record['rate'] = $rate;
			add_record($filename,$record);
		}
	}
	/**
	 * 判断是否是第一次发微博
	 * @param string $url 请求地址
	 * @param array $post_data post键值对数据
	 * @return string
	 */
	function add_record($filename,$record) {
		$doc = new DOMDocument("1.0","utf-8");
		$doc->load($filename);
		$root = $doc->documentElement;

		$info=$doc->createElement("info");  #创建节点对象实体
		$info=$root->appendChild($info);    #把节点添加到root节点的子节点

		$date=$doc->createAttribute("date");  #创建节点属性对象实体
		$date=$info->appendChild($date);  #把属性添加到节点info中
			
		$code=$doc->createElement("code");    #创建节点对象实体
		$code=$info->appendChild($code);
			
		$profit=$doc->createElement("profit");
		$profit=$info->appendChild($profit);
			
		$rate=$doc->createElement("rate");
		$rate=$info->appendChild($rate);
			
		$date->appendChild($doc->createTextNode($record['date']));  #createTextNode创建内容的子节点，然后把内容添加到节点中来
		$code->appendChild($doc->createTextNode($record['code']));
		$profit->appendChild($doc->createTextNode($record['profit'])); #注意要转码对于中文，因为XML默认为UTF-8格式
		$rate->appendChild($doc->createTextNode($record['rate']));
		$doc->saveXML();
		$doc->save($filename); #保存路径
	}

/**
 * 判断是否是第一次发微博
 * @param string $url 请求地址
 * @param array $post_data post键值对数据
 * @return string
 */
function is_first($filename) {

	$doc = new DOMDocument("1.0","utf-8");
	$doc->load($filename);
	$infos = $doc->getElementsByTagName("info");
	$today = date ("Y-m-d");
	echo $today;
	$array  = array();
	foreach ($infos as $info){
		$date = $info->getAttribute("date");
		$array[] =$date;
	}
	if(in_array($today,$array))
	{
		return 0;  #当天记录已经更新
	}else
	{
		return 1; #当天记录未更新
	}
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
