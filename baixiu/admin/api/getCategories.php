<?php 
include_once "../../common/mysql.php";
$conn = connect();
$sql = "select * from categories";
$arr = query($conn,$sql);
//验证数据合法性
$res = array("code"=>0,"msg"=>"请求分类数据失败");
if($arr){
	$res['code']=1;
	$res['msg']="请求分类数据成功";
	$res['data'] = $arr;
}
//返回数据 
echo json_encode($res);

 ?>