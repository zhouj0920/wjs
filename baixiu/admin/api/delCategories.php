<?php 
	//接收数据
	$ids = $_POST['ids'];

	include_once '../../common/mysql.php';
	$conn = connect();
	$sql = "delete from categories where id in($ids)";
	$bool = mysqli_query($conn,$sql);
	$res = ["code"=>0,"msg"=>"批量删除失败"];

	if($bool){
		$res['code']=1;
		$res['msg']="批量删除成功";
	}
	// var_dump($bool);
	echo json_encode($res);

?>