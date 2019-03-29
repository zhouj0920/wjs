<?php 
// 接收数据
$name = $_POST['name'];
$slug = $_POST['slug'];
$classname = $_POST['classname'];
// 连接数据库获取数据
include_once '../../common/mysql.php';
$conn = connect();
$sql = "select count(*) as count from categories where name='$name'";
$arr = query($conn,$sql);

$res = array("code"=>0,"msg"=>"插入分类信息错误");
// 验证是否重名
if($arr[0]['count']>0){
	// 重名
    $res['msg'] = "插入分类名称已存在";
}else{
   // 不重名插入数据
   $addSql = "insert into categories values(null,'$slug','$name','$classname')";
   $bool = mysqli_query($conn,$addSql);
   
   if($bool){
   	 $res['code'] = 1;
   	 $res['msg'] = "分类名称插入成功";
   }
}

echo json_encode($res);

?>