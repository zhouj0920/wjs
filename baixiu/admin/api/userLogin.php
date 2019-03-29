<?php 
// 接收数据
$email = $_POST['email'];
$pwd = $_POST['pwd'];


// 连接数据库获取数据
include_once '../../common/mysql.php';
$conn = connect();
$sql="select * from users where email='$email' and password='$pwd'";
$arr = query($conn,$sql);


// 返回数据
$res = array('code'=>0,"msg"=>"登录失败");
if($arr){
    // 验证成功后在服务器端保存用户信息
	session_start();
	$_SESSION['userInfo'] = $arr[0];

	$res['code'] = 1;
	$res['msg'] = "登录成功";
}

echo json_encode($res);







 ?>