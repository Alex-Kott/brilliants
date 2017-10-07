$(".toggle li").on("click", function(){
	$(this).addClass("current").siblings().removeClass("current");
});

$(".cut").on("click", function(){
	var cut = $(this).find(".cut-name").data("cut");
	$("input[name=cut]").val(cut);
});

$(".selector li").on("click", function(){
	console.log(this)
	if($(this).hasClass("checked")){
		$(this).removeClass("checked");
	} else {
		$(this).addClass("checked");
	}
})

$(".cut").on("click", function(){
	$(this).addClass("current").siblings().removeClass("current");
});

var weight_slider = new Slider("#weight-range", {});
var price_slider = new Slider("#price-range", {});

$(".input-range").on("change", function(){
	var value = $(this).val();
	var [left, right] = value.split(",");
	$(this).parent(".range").find("input[name=left-value]").val(left);
	$(this).parent(".range").find("input[name=right-value]").val(right);
});

$(".search-btn").on("click", function(){
	$("form").submit();
})