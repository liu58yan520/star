var url=encodeURIComponent(window.location.href);
$.ajax({ 
	type : "get", 
	url : "http://vote.didifc.com/web/star/jssdk.php?url="+url,//替换网址，xxx根据自己jssdk文件位置修改 
	dataType : "jsonp", 
	jsonp: "callback", 
	jsonpCallback:"success_jsonpCallback", 
	success : function(data){ 
		wx.config({ 
			debug:false,
			appId: data.appId, 
			timestamp: data.timestamp, 
			nonceStr: data.nonceStr, 
			signature: data.signature, 
			jsApiList: [ 
			  "onMenuShareTimeline", //分享给好友 
			  "onMenuShareAppMessage", //分享到朋友圈 
			] 
		}); 
	}, 
});


wx.ready(function (){ 
var shareData = { 
	title: '星耀中国 梦想启航', 
	desc: '2017 “星耀中国”少儿明星艺术大赛 镇江赛区火热招募中，助才艺宝贝荣登江苏综艺“超级小达人” ',
	link: 'http://vote.didifc.com/web/star/index.html', 
	imgUrl: 'http://vote.didifc.com/web/star/img/share.jpg'
}; 
	wx.onMenuShareAppMessage(shareData); 
	wx.onMenuShareTimeline(shareData); 
}); 