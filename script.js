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

$(function(){
	var cut = $("input[name=cut]").val();
	if(cut == '') return;
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
	if(lang == ''){
		lang = 'ru';
	}
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