// 入口函数
window.onload = function() {
    //轮播图函数调用
    // bannerEffect();
    //顶部js效果调用
    searchEffect();
    //倒计时效果调用
    timeBack();
}
//轮播图
function bannerEffect() {
    //1.修改轮播图样式结果
    var banner = document.querySelector('.jd_banner');
    //获取图片容器
    var imgBox = banner.querySelector('ul:first-of-type');
    //获取原始第一张图片
    var first = imgBox.querySelector('li:first-of-type');
    //获取原始最后一张图片
    var last = imgBox.querySelector('li:last-of-type');
    //在首位插入图片 coneNode 复制一个dom元素
    imgBox.appendChild(first.cloneNode(true));
    imgBox.insertBefore(last.cloneNode(true), imgBox.firstChild);

    //2.设置对应的样式
    //获取所有的li元素
    var lis = imgBox.querySelectorAll('li');
    //获取li元素的数量
    var count = lis.length;
    //获取banner的宽度
    var bannerWidth = banner.offsetWidth;
    //设置图片盒子的宽度
    imgBox.style.width = count * bannerWidth + 'px';
    //设置每一个li元素(图片)的宽度
    for (var i = 0; i < lis.length; i++) {
        lis[i].style.width = bannerWidth + 'px';
    }

    //3.实现默认位置偏移
    var index = 1;
    //设置默认的偏移
    imgBox.style.left = -bannerWidth + 'px';

    var timerId;
    //4.自动轮播
    var startTime = function(){
        timerId = setInterval(function() {
            index++;
            //移动ul
            imgBox.style.left = -(index * bannerWidth) + 'px';
            //添加过渡
            imgBox.style.transition = "left .5s linear";
            //判断
            // console.log(index);
            if (index == count - 1) {
                // console.log(index);
                setTimeout(function() {
                    index = 1;
                    imgBox.style.left = -(index * bannerWidth) + 'px';
                    //关闭过渡效果
                    imgBox.style.transition = "none";
                }, 500)
    
            }
        }, 2000);
    }
    startTime();
    //5.手动滑动
    var startX,moveX,distanecX;
    // 标记当前过渡效果是否已经执行完毕
    var isEnd = true;
    imgBox.addEventListener("touchstart",function(e){
        clearInterval(timerId);
        //获取当前手指的起始位置
        startX = e.targetTouches[0].clientX;
        // console.log(startX); 
    });
    
    imgBox.addEventListener("touchmove",function(e){
        if(isEnd ==true){
            moveX = e.targetTouches[0].clientX;
            distanecX = moveX-startX;
            // console.log(distanecX);
            //保证效果,清除之前添加的过渡效果
            imgBox.style.transition ='none';
            //实现元素的偏移,left参照最原始的坐标,本次的滑动应该基于之前轮播图已经偏离的距离
            imgBox.style.left =(-index*bannerWidth+distanecX)+"px";
        }
    })

    imgBox.addEventListener("touchend",function(){
        //松开手指到过渡执行完成之前将标记状态设置为false
        isEnd = false;
        //判断当前滑动的距离是否超过指定的范围
        if(Math.abs(distanecX)>100){
            // console.log(distanecX);
            
            //判断滑动方向
            if(distanecX >0){
                index--;//上一张
            }else{
                index++;//下一张
            }
            //翻页
            imgBox.style.transition = "left .5s linear";
            imgBox.style.left = -index*bannerWidth+"px";
        }else if(Math.abs(distanecX)>0){
            //回弹
            imgBox.style.transition = "left .2s linear";
            imgBox.style.left = -index*bannerWidth+"px";
        }
        startX = 0;
        moveX = 0;
        distanecX = 0;
        //重新开启定时器
        startTime();
    })

    //webkitTransitionEnd: 可以监听当前元素的过渡效果执行完毕,当一个元素的过渡效果执行完毕时触发这个事件
    imgBox.addEventListener("webkitTransitionEnd",function(){
        //如果到了最后一张(count-1),就回到索引1
        //如果到了第一张(0),就回到索引count-2
        if(index ==count-1){
            index = 1;
            imgBox.style.transition= 'none';
            imgBox.style.left = -index*bannerWidth+"px";
        }else if(index==0){
            index =count-2;
            imgBox.style.transition= 'none';
            imgBox.style.left = -index*bannerWidth+"px";
        }
        isEnd = true;
        dian(index);
        
    })
    //实现焦点移动
    function dian(index){
        var uls = banner.querySelector("div:last-of-type");   
        var lis =uls.querySelectorAll("li");
        
        //先清除其它li元素的active样式
        for(var i= 0;i<lis.length;i++){
            lis[i].classList.remove('active');
        }
        //为当前元素添加active样式
        lis[index-1].classList.add('active');
    }
}

//头部js效果
function searchEffect(){
    //1.获取当前banner的高度
    var banner = document.querySelector('.jd_banner');
    //1.2获取当前banner的高度
    var bannerHeight= banner.offsetHeight;
    // console.log(bannerHeight);
    var search = document.querySelector('.jd_search');
    //2.获取当前屏幕滚动时,banner滚出屏幕j额距离(屏幕滚动事件)
    window.onscroll = function(){
        var offsetTop = document.body.scrollTop || document.documentElement.scrollTop;
         //3.计算比例值,获取透明度,设置背景颜色样式
        //  console.log(offsetTop);
         var opacity=0;
         //判断
         if(offsetTop< bannerHeight){
            opacity = offsetTop/bannerHeight;
            search.style.backgroundColor = "rgba(233,35,34,"+opacity+")";
         }

         
        
    }
   
}
//倒计时效果
function timeBack(){
    //1.获取用于展示的时间的span
    var span = document.querySelector('.jd_sk_time');
    var spans =span.querySelectorAll('span');
    //设置初始化时间
    var totalTime = 3700;//1*60*60
    //开启定时器
    var timerId = setInterval(function(){
        totalTime--; 
        //判断时间小于0时
        if(totalTime<0){
            clearInterval(timerId)
            return;
        }  
        //得到剩余时间的 时 分 秒
        //获取时
        var hour = Math.floor(totalTime/3600);
        //获取分
        var minute = Math.floor(totalTime%3600/60);
        //获取秒
        var second = Math.floor(totalTime%60);
        //将时间填充到span中
        spans[0].innerHTML = Math.floor(hour/10);
        spans[1].innerHTML = Math.floor(hour%10);

        spans[3].innerHTML = Math.floor(minute/10);
        spans[4].innerHTML = Math.floor(minute%10);

        spans[6].innerHTML = Math.floor(second/10);
        spans[7].innerHTML = Math.floor(second%10);
 
    },1000);
    
    
}