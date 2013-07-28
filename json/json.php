<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<?php
//函数试用
echo "json_encode<hr/>";
$arr = array ('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5);
echo json_encode($arr);
echo "<hr/>";
$obj->body = 'another post';
$obj->id = 21;
$obj->approved = true;
$obj->favorite_count = 1;
$obj->status = NULL;
echo json_encode($obj);

echo "<hr/>json_decode<hr/>";

$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
var_dump(json_decode($json));
echo "<hr/>";
var_dump(json_decode($json,true));
echo "<hr/>";


//调用百度地图API
$url='http://api.map.baidu.com/geocoder?output=json&location=39.983424,116.322987&key=ebad1e950d1f95a2656ffe633662659f';
$location_json=file_get_contents($url);
echo $location_json;
echo "<hr/>";
$object = json_decode($location_json,true);
var_dump($object);

echo "<hr/>";

print_r($object);
echo "<hr/>";
echo $object['status'];
echo "<hr/>";
echo $object['result']['addressComponent']['city'];
