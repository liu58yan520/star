$(function(){
var MusicPlay=true;
autoMusic();

var swiper_master = new Swiper('.swiper_master', {
    pagination: '.swiper-pagination', //加载侧边小圆点
    paginationClickable: false, //点小圆点可切换页数
    direction: 'vertical',   	//滑动方向 垂直
   // initialSlide :4,

	onInit: function(swiper){ //swiper.activeIndex 是当前页索引
	    swiperAnimateCache(swiper); //隐藏动画元素 
	  	swiperAnimate(swiper); //初始化完成开始动画
	  }, 
	onSlideChangeEnd: function(swiper){ 
	    swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画
	  } 
});

var swiper_sub = new Swiper('.swiper-sub', {
    direction: 'horizontal',   	//滑动方向 
    spaceBetween: 0,
    autoplay:2500,
    autoplayDisableOnInteraction : true,
    loop : true,
});


$('#music').tap(function(){
	if(MusicPlay){
		$(this).css({'animation':'none'});
		MusicPlay=false;
		autoMusic()
	}else{
		$(this).css({'animation':'music 2s linear infinite'});
		MusicPlay=true;
		autoMusic()
	}

});
function autoMusic(){
	var audio = document.getElementById('audio');
	if(MusicPlay){
		audio.play();
	    document.addEventListener("WeixinJSBridgeReady", function () {
	        audio.play();
	    }, false);
	    document.addEventListener('YixinJSBridgeReady', function() {
	        audio.play();
	    }, false);
    }else{
    	audio.pause();
	    document.addEventListener("WeixinJSBridgeReady", function () {
	        audio.pause();
	    }, false);
	    document.addEventListener('YixinJSBridgeReady', function() {
	        audio.pause();
	    }, false);
    }
}
})