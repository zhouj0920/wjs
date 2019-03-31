$(function(){
    // 初始化工具提示
    $('[data-toggle="tooltip"]').tooltip();

    // 计算产品块导航项的原始宽度
    var ul = $('.wjs_product .nav-tabs');
    var lis = ul.find('li');
    //因为ul没有宽度
    var totalWidth = 0;//总宽度
    lis.each(function(index,value){
        totalWidth = totalWidth+$(value).innerWidth();
        console.log($(value).innerWidth());
    })
    ul.width(totalWidth);
    //使用插件,实现滑动效果
    var myScroll = new IScroll('.tabs_parent',{
        //设置水平滑动,不允许垂直滑动
        scrollX:true, scrollY:false
    })
})
