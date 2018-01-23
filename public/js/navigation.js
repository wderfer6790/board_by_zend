/**
 * navigation
 */
$(document).ready(function(){
	$("ul.navi > li > ul > li[class*='active']").each(function(){
		$(this).parent().css("display", "block");
	});
	$("ul.navi > li > a").on("click", function(e){
		var ul = $(this).next('ul');
		if (ul.length > 0) {
			e.preventDefault();
			ul.toggle();
		}
	});
});
