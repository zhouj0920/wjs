<?php 
	$currentPage = $_POST['currentPage'];//接收从客户端请求的数据
	$pageSize = $_POST['pageSize'];
	$offset=($currentPage-1)*$pageSize;

	include_once "../../common/mysql.php";//引入数据库中的数据
	$conn = connect();
	$sql = "select c.id,c.author,c.created,c.content,c.status,p.title from comments as c 
	left join posts as p on c.post_id = p.id
	limit $offset,$pageSize";

	$arr = query($conn,$sql);

	$countSql = "select count(*) as count from comments as c";
	$count = query($conn,$countSql)[0]['count'];

	//验证数据合法性
	$res = array("code"=>0,"msg"=>"请求分类数据失败");
	if($arr){
		$res['code']=1;
		$res['msg']="请求分类数据成功";
		$res['data'] = $arr;
		$res['count'] = $count;
	}
	//返回数据 
	echo json_encode($res);



 ?>