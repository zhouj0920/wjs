<?php 

// 接收数据
$id = $_POST['id'];
$name = $_POST['name'];
$slug = $_POST['slug'];
$classname = $_POST['classname'];
// 连接数据库获取数据
include_once '../../common/mysql.php';
$conn = connect();
$sql = "update categories set name='$name',slug='$slug',classname='$classname' where id='$id'";

$res = array("code"=>0,"msg"=>"更新分类信息失败");

$bool = mysqli_query($conn,$sql); 
if($bool){
	 $res['code'] = 1;
	 $res['msg'] = "更新分类信息成功";

}

echo json_encode($res);

 ?>