window.onload = function(){
    //获取左侧栏
    var ct_left = document.querySelector('.ct_left');
    var leftHeight = ct_left.offsetHeight;

    var ulBox = ct_left.querySelector('ul');
    var ulBoxHeight = ulBox.offsetHeight;
    // console.log(ulBox);
    
    //记录初始化数据
    var startY,moveY,distanceY,currentY = 0;

    //设置滑动区间的最大值与最小值
    //1.静止状态下的最大top值和最小top值
    var maxTop= 0;
    var minTop= leftHeight -ulBoxHeight;

    //2.滑动状态下的最大top值和最小top值
    var maxBounceTop = maxTop+100;
    var minBounceTop = minTop-100;
    console.log(maxBounceTop+":"+minBounceTop);
    

    //添加滑动事件
    ulBox.addEventListener("touchstart",function(e){
        startY = e.targetTouches[0].clientY;
        
    })
    ulBox.addEventListener("touchmove",function(e){
        moveY = e.targetTouches[0].clientY;
        distanceY = moveY-startY;
        
        //判断滑动的时候是否超出当前指定的滑动区间
        if(currentY+distanceY >maxBounceTop || currentY+distanceY <minBounceTop){
            console.log("不能再滑动了哦");
            return;
        }

        // 先将之前可能添加的过渡效果清除
        ulBox.style.transition = "none";
        ulBox.style.top = (currentY+distanceY)+"px";
        
    })
    ulBox.addEventListener("touchend",function(){
        //判断当前滑动的距离是否在静止状态和滑动状态下的最小top值
        if(currentY+distanceY < minTop){
            currentY = minTop;
            ulBox.style.transition = "top .5s";
            ulBox.style.top = minTop+"px";
        }else if(currentY+distanceY > maxTop){
            currentY=maxTop;
            ulBox.style.transition = "top .5s";
            ulBox.style.top = maxTop+"px";
        }else{
            //记录当前滑动的距离
            currentY += distanceY;
        }   
    })

    //点击业务
    var lis = ulBox.querySelectorAll('li');

    for(var i= 0;i< lis.length;i++){
        lis[i].index = i;
        // lis[i].setAttribute('index',i)
        
    }
    ulBox.addEventListener("click",function(e){
        //1.修改li的样式
        for(var i = 0; i<lis.length;i++){
            lis[i].classList.remove('active');
        }
        e.target.parentNode.classList.add('active');
        
        //2.设置ulbox的top
        var index = e.target.parentNode.index;
        var liHeight = e.target.parentNode.offsetHeight;
        
        //判断
        if(-index * liHeight < minTop){
            ulBox.style.transition  = "top .5s"
            ulBox.style.top = minTop+ "px";
            currentY = minTop;
        } else{
            ulBox.style.transition  = "top .5s"
            ulBox.style.top = -index * liHeight+ "px";
            currentY = -index * liHeight;
        }
    })
}