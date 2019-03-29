<?php 
//1.接受从首页传过来的分页id号
// $categoryId = $_GET['categoryId'];
// //2.连接数据库
// $conn = mysqli_connect("localhost","root",'root',"baixiu");
// //3.构造sql语句
// $list_sql= "select p.id,p.title,p.feature,p.created,p.content,p.views,p.likes,u.nickname,c.name,
// (select count(*) from comments where comments.post_id=p.id  ) as commentsCount from posts as p
// left join users as u on u.id = p.user_id
// left join categories as c on c.id = p.category_id
// where p.category_id = $categoryId
// limit 0,10";
// //4.执行sql语句生成数据
// $list_res = mysqli_query($conn,$list_sql);
//   while($row = mysqli_fetch_assoc($list_res)){
//   $list_arr[]= $row;
// }
// print_r($list_arr);

//1.引入封装的 php文件
include_once "common/mysql.php" ;
//2.接收从首页传过来的分类id号
$categoryId = $_GET['categoryId'];
//3.构建sql語句
$list_sql = "select p.id,p.title,p.feature,p.created,p.content,p.views,p.likes,u.nickname,c.name,
(select count(*) from comments where comments.post_id = p.id ) as commentsCount
from posts as p
left join users as u on u.id = p.user_id
left join categories as c on c.id = p.  category_id
where p.category_id = $categoryId
limit 0,10";
//4.调用封装的函数获取数据
$conn = connect();
$list_arr = query($conn,$list_sql);

 ?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>阿里百秀-发现生活，发现美!</title>
  <link rel="stylesheet" href="static/assets/css/style.css">
  <link rel="stylesheet" href="static/assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="wrapper">
    <div class="topnav">
      <ul>
        <li><a href="javascript:;"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="javascript:;"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="javascript:;"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="javascript:;"><i class="fa fa-gift"></i>美奇迹</a></li>
      </ul>
    </div>
    <?php include_once"./common/aside.php" ?>
    </div>
    <div class="content">
      <div class="panel new">
      
        <h3><?php echo $list_arr[0]['name'] ?></h3>

        <?php foreach($list_arr as $key => $value){ ?>
        <div class="entry">
          <div class="head">
            <span class="sort"><?php echo $value['name']; ?></span>
            <a href="detail.php?id=<?=$value['id']?>"><?php echo $value['title']?></a>
          </div>
          <div class="main">
            <p class="info"><?php echo $value['nickname']; ?>发表于 2015-06-29</p>
            <p class="brief"><?php echo $value['content']; ?></p>
            <p class="extra">
              <span class="reading">阅读(<?php echo $value['views']; ?>)</span>
              <span class="comment">评论(<?php echo $value['commentsCount']; ?>)</span>
              <a href="javascript:;" class="like">
                <i class="fa fa-thumbs-up"></i>
                <span>赞(<?php echo $value['likes']; ?>)</span>
              </a>
              <a href="javascript:;" class="tags">
                分类：<span><?php echo $value['name']; ?></span>
              </a>
            </p>
            <a href="javascript:;" class="thumb">
              <img src="static/uploads/hots_2.jpg" alt="">
            </a>
          </div>
        </div>
        <?php } ?>
        <div class="loadmore">
          <span class="btn">加载更多</span>
        </div>
      </div>
    </div>
    
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
  <script src="./static/assets/vendors/jquery/jquery.js"></script>
  <script src="./static/assets/vendors/art-template/template-web.js"></script>
  <script type ="text/template" id="postTpl">
    {{each data value index}}
      <div class="entry">
          <div class="head">
            <span class="sort">{{value.name}}</span>
            <a href="javascript:;">{{value.title}}</a>
          </div>
          <div class="main">
            <p class="info">{{value.nickname}}发表于 2015-06-29</p>
            <p class="brief">{{value.content}}</p>
            <p class="extra">
              <span class="reading">阅读({{value.views}})</span>
              <span class="comment">评论({{value.commentsCount}})</span>
              <a href="javascript:;" class="like">
                <i class="fa fa-thumbs-up"></i>
                <span>赞({{value.likes}})</span>
              </a>
              <a href="javascript:;" class="tags">
                分类：<span>{{value.name}}</span>
              </a>
            </p>
            <a href="javascript:;" class="thumb">
              <img src="static/uploads/hots_2.jpg" alt="">
            </a>
          </div>
        </div>
    {{/each}}
  </script>

  <script>
    $(function(){
      //页面初始化数据
      var categoryId = location.search.split('=')[1];
      var currentPage = 1;
      var pageSize = 40;

      $('.loadmore .btn').click(function(){

        $.ajax({
          type:"post",
          url:"./api/getMorePost.php",
          data:{
            "categoryId":categoryId,
            "currentPage":++currentPage,
            "pageSize":pageSize
          },
          dataType:"json",
          success:function(res){
            console.log(res);

            if(res.code==1){
              var html = template('postTpl',res);
              $(html).insertBefore('.loadmore');

              var maxPage = Math.ceil(res.count/pageSize);
           
              if(currentPage==maxPage){
                $('.loadmore').hide();
              }
            }
          }
        })
      });


    })
  </script>
</body>
</html>