<?php 
//接收
$categoryId = $_POST['categoryId'];
$currentPage = $_POST['currentPage'];
$pageSize = $_POST['pageSize'];

//计算页面的偏移量
$offset = ($currentPage-1)*$pageSize;
//连接数据库获取数据
include_once '../common/mysql.php';

$conn = connect();
$sql = "select p.id,p.title,p.feature,p.created,p.content,p.views,p.likes,u.nickname,c.name,
(select count(*) from comments where comments.post_id=p.id  ) as commentsCount from posts as p
left join users as u on u.id = p.user_id
left join categories as c on c.id = p.category_id
where p.category_id = $categoryId
limit $offset,$pageSize";

$arr =query($conn,$sql);

//计算总条数
$countSql = "select count(*) as count from posts where category_id=$categoryId";
$countArr = query($conn,$countSql);
$count = $countArr[0]['count'];

//返回默认值
$res =array("code"=>0,"msg"=>"请求失败");
//请求成功重置返回值
if($arr){
	$res['code']=1;
	$res['msg']="请求成功";
	$res['data'] =$arr;
}
echo json_encode($res);

 ?>