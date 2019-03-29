
<?php 

include_once"./common/checkLogin.php";

 ?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    
    <?php include_once './common/nav.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select name="" id="category" class="form-control input-sm">
            <!-- <option value="">所有分类</option>
            <option value="">潮科技</option> -->
            
          </select>
          <select id = "status" name="" class="form-control input-sm">
            <option value="all">所有状态</option>
            <option value="drafted">草稿</option>
            <option value="published">已发布</option>
            <option value="trashed">已删除</option>
          </select>
          <input type="button" id="btn-filter" class="btn btn-default btn-sm" value="筛选">
        </form>
        <ul class="pagination pagination-sm pull-right">
          <!-- <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li> -->
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          -->
        </tbody>
      </table>
    </div>
  </div>

  <?php include_once './common/aside.php' ?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script src="../static/assets/vendors/art-template/template-web.js"></script>
  <!-- 模板引擎 -->
  <script type="text/template" id="postTpl">
    {{each data}}
      <tr>
        <td class="text-center"><input type="checkbox"></td>
        <td>{{$value.title}}</td>
        <td>{{$value.nickname}}</td>
        <td>{{$value.name}}</td>
        <td class="text-center">{{$value.created}}</td>
        <td class="text-center">
        {{if($value.status=="drafted")}}
        草稿
        {{else if($value.status=="published")}}
        已发布
        {{else if($value.status=="trashed")}}
        已作废
        {{/if}}
        </td>
        <td class="text-center">
          <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
          <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
        </td>
      </tr>
    {{/each}}
  </script>

  <!-- 模板引擎 -->
  <script type = "text./template" id="paginationTpl">
    <li {{if(currentPage-1<1)}} style ="display:none;"{{/if}} data-page="{{currentPage-1}}"> <a href="#">上一页</a></li>
    <li {{if(currentPage-2<1)}} style ="display:none;"{{/if}} data-page="{{currentPage-2}}"><a href="#">{{currentPage-2}}</a></li>
    <li {{if(currentPage-1<1)}} style ="display:none;"{{/if}} data-page="{{currentPage-1}}"><a href="#">{{currentPage-1}}</a></li>

    <li class ="active"><a href="#">{{currentPage}}</a></li>

    <li {{if(currentPage+1>maxPage)}}style="display:none"{{/if}} data-page="{{currentPage+1}}"><a href="#">{{currentPage+1}}</a></li>
    <li {{if(currentPage+2>maxPage)}}style="display:none"{{/if}} data-page="{{currentPage+2}}"><a href="#">{{currentPage+2}}</a></li>
    <li {{if(currentPage+1>maxPage)}}style="display:none"{{/if}} data-page="{{currentPage+1}}"><a href="#">下一页</a></li>
  </script>
  
  <script>
    $(function(){
      //获取分页的数据
      var currentPage = 1;
      var pageSize = 20;
      var category = "all";
      var status = "all";
      //封装
      
      function getPosts(currentPage,pageSize,category,status){
        $.ajax({
          type:'post',
          url:'./api/getPosts.php',
          data:{"currentPage":currentPage,"pageSize":pageSize,"category":category,"status":status},
          dataType:'json',
          success:function(res){
            if(res.code ==1){
              var html = template('postTpl',res);
              $('tbody').html(html);
              //计算分页最大值并渲染分页列表
              var maxPage =Math.ceil(res.count/pageSize);
              var pagenationHtml = template("paginationTpl",{"currentPage":currentPage,"maxPage":maxPage});
              $(".pagination").html(pagenationHtml);
            }
          }
        });
      }
      getPosts(currentPage,pageSize,category,status);
      //分页列表点击功能
      $(".pagination").on("click","li",function(){
        // alert(11)
        currentPage = parseInt($(this).attr("data-page"));
        getPosts(currentPage,pageSize,category,status);
      })

      //加载所有分类
        $.ajax({
        type:'get',
        url:'./api/getCategories.php',
        dataType:'json',
        success:function(res){
         if(res.code==1){
          var html ='<option value="all">所有分类</option>';
          res.data.forEach(function(value,index){
            html += '<option value="'+value.id+'">'+value.name+'</option>'
          })
          $('#category').html(html);
         } 
        }
      });

      //筛选功能
      $('#btn-filter').click(function(){
        category = $('#category').val();
        status = $('#status').val();
        currentPage = 1;
        getPosts(currentPage,pageSize,category,status);
      })

    })
  </script>
</body>
</html>
