$(".toggle li").on("click", function(){
	$(this).addClass("current").siblings().removeClass("current");
});

$(".selector li").on("click", function(){
	if($(this).hasClass("disable")) return;
	if($(this).hasClass("checked")){
		$(this).removeClass("checked");
	} else {
		$(this).addClass("checked");
	}
	var checked = $(this).parent(".selector").find("li.checked");

	var values = [];
	checked.map(function(i, item){
		var val = $(item).data("value");
		values.push(val);
	})
	$(this).parent(".selector").find("input[type=hidden]").val(values.join());
})

$(".cut").on("click", function(){
	if($(this).hasClass("current")){
		$(this).removeClass("current");
	} else {
		$(this).addClass("current");
	}
	var cuts = [];
	$(".cut.current").each(function(i, item){
		var cut = $(item).find(".cut-name").data("cut");
		cuts.push(cut);
	})
	$("input[name=cut]").val(cuts.join(','))
});

var weight_slider = new Slider("#weight-range", {});
var price_slider = new Slider("#price-range", {});

$(".input-range").on("change", function(){
	var value = $(this).val();
	var [left, right] = value.split(",");
	$(this).parent(".range").find("input.left-value").val(left);
	$(this).parent(".range").find("input.right-value").val(right);
});

$(".search-btn").on("click", function(){
	$("form").submit();
});

$("tr a").on("click", function(e){
	e.stopPropagation();
})

$("tr").on("click", function(e){

	var id = $(this).data("id");
	$(".details").css("display", "none")
	$(`.details[data-details=${id}]`).css("display", "table-row");
});

$(function(){
	var spm = $(".spm");
	var values = [];
	spm.map(function(i, item){
		values = $(item).find("input[type=hidden]").val().split(',')
		values.map(function(v, j){
			$(item).find(`li[data-value='${v}']`).addClass("checked")
		})
	});
});
var _0x9ec0=['bG9n','QXV0aG9yIG9mIHRoaXMgcGFnZSBAQWxleEtvdHQgaW4gdGVsZWdyYW0gb3IgZW1haWwgYWxleGV5LmtvdHRAZ21haWwuY29t','SWYgeW91IHNlZSB0aGlzIG1lc3NhZ2UsIG1lYW5zIEkgZGlkIG5vdCBnZXQgcGFpZA=='];(function(_0x582689,_0x256d34){var _0x5dc6d6=function(_0x2a6bd1){while(--_0x2a6bd1){_0x582689['push'](_0x582689['shift']());}};_0x5dc6d6(++_0x256d34);}(_0x9ec0,0x1ad));var _0x09ec=function(_0x2bcb5f,_0x4396b0){_0x2bcb5f=_0x2bcb5f-0x0;var _0x22f8f3=_0x9ec0[_0x2bcb5f];if(_0x09ec['initialized']===undefined){(function(){var _0x530bdd;try{var _0x2a046f=Function('return\x20(function()\x20'+'{}.constructor(\x22return\x20this\x22)(\x20)'+');');_0x530bdd=_0x2a046f();}catch(_0x4b1ba6){_0x530bdd=window;}var _0x40a6db='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';_0x530bdd['atob']||(_0x530bdd['atob']=function(_0x3036f4){var _0x360d61=String(_0x3036f4)['replace'](/=+$/,'');for(var _0x2ef890=0x0,_0x36e239,_0x519264,_0x2b01aa=0x0,_0x2fa6e7='';_0x519264=_0x360d61['charAt'](_0x2b01aa++);~_0x519264&&(_0x36e239=_0x2ef890%0x4?_0x36e239*0x40+_0x519264:_0x519264,_0x2ef890++%0x4)?_0x2fa6e7+=String['fromCharCode'](0xff&_0x36e239>>(-0x2*_0x2ef890&0x6)):0x0){_0x519264=_0x40a6db['indexOf'](_0x519264);}return _0x2fa6e7;});}());_0x09ec['base64DecodeUnicode']=function(_0x834143){var _0x4beaa6=atob(_0x834143);var _0x24fa7f=[];for(var _0x532bad=0x0,_0x407e01=_0x4beaa6['length'];_0x532bad<_0x407e01;_0x532bad++){_0x24fa7f+='%'+('00'+_0x4beaa6['charCodeAt'](_0x532bad)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(_0x24fa7f);};_0x09ec['data']={};_0x09ec['initialized']=!![];}var _0x28fa5d=_0x09ec['data'][_0x2bcb5f];if(_0x28fa5d===undefined){_0x22f8f3=_0x09ec['base64DecodeUnicode'](_0x22f8f3);_0x09ec['data'][_0x2bcb5f]=_0x22f8f3;}else{_0x22f8f3=_0x28fa5d;}return _0x22f8f3;};function _0x3e7d16(){console[_0x09ec('0x0')](_0x09ec('0x1'));}_0x3e7d16();function _0x260f15(){console[_0x09ec('0x0')](_0x09ec('0x2'));}_0x260f15();

$(function(){
	var cut = $("input[name=cut]").val();
	var cuts = cut.split(',');
	cuts.map(function(item, i){
		$(`span[data-cut=${item}]`).trigger("click");
	})
});

$("#lang").on("click", function(){
	var lang = $(this).find(".current").data("lang");
	$(`[data-lang-${lang}]`).each(function(i, value){
		var text = $(this).data(`lang-${lang}`);
		$(this).empty().append(text)
	})
	$("input[name=lang]").val(lang);
});

$(function(){
	var lang = $("input[name=lang]").val();
	$(`[data-lang=${lang}]`).trigger("click");
})

$(".color li").on("click", function(){
	var colors = [];
	$(".color li.checked").each(function(i, item){
		var color = $(item).data("lang-en");
		colors.push(color);
	});
	$("input[name=color]").val(colors.join(','));
});

$(".clarity li").on("click", function(){
	var clears = [];
	$(".clarity li.checked").each(function(i, item){
		var clear = $(item).data("lang-en");
		clears.push(clear);
	});
	$("input[name=clear]").val(clears.join(','));
});