<?php 
//封装连接
function connect(){
	$conn = mysqli_connect("localhost","root","root","baixiu");
	return $conn;
}
//封装请求数据
function query($conn,$sql){
	
	$res = mysqli_query($conn,$sql);
	$arr = [];
	while($row = mysqli_fetch_assoc($res)){
		$arr[]= $row;
	}
	return $arr;

}
 ?>