init_pager();
var total_pages = $("#pager-wrapper a.pager").length;

// set up pagination
function init_pager(){
	$("#pager-first, #pager-prev").hide();
	if(total_pages <= 7) { $("#pager-last, #pager-next").hide(); }
    var count = 0;
    $("#chall-pager-wrapper a.pager").each(function(){
    	count++;
    	if(count > 7) {
    		$(this).hide();
    	}
    });
    
    $("#pager-next").click(function(evt){
    	evt.preventDefault();
    	if($("a.pager.selected").next().length > 0){
    		$("a.pager.selected").next().trigger("click");
    	}
    });
    
    $("#pager-last").click(function(evt){
    	evt.preventDefault();
    	$("a.pager").last().trigger("click");
    });
    
    $("#pager-prev").click(function(evt){
    	evt.preventDefault();
    	if($("a.pager.selected").prev().length > 0){
    		$("a.pager.selected").prev().trigger("click");
    	}
    });
    
    $("#pager-first").click(function(evt){
    	evt.preventDefault();
    	$("a.pager").first().trigger("click");
    });
}
    
function set_pager(min,max) {
	var count = 0;
	$("#chall-pager-wrapper a.pager").each(function(){
    	count++;
    	if(count >= min && count <= max) {
    		$(this).show();
    	} else {
    		$(this).hide();
    	}
    });
}

function update_pager(page){
	$("a.pager.selected").removeClass("selected");
	$("a.pager[data-page="+page+"]").addClass("selected");
	if(page > 4 && page < (total_pages - 4)) {
			$("#pager-first, #pager-prev").show();
		$("#pager-last, #pager-next").show();
		var max = parseInt(page) + 3;
		var min = parseInt(page) - 3;
		set_pager(min,max);
	} else if(page == 1) {
		$("#pager-first, #pager-prev").hide();
		$("#pager-last, #pager-next").show();
		set_pager(1,7);
	} else if(page == total_pages) {
   		$("#pager-first, #pager-prev").show();
		$("#pager-last, #pager-next").hide();
		set_pager(total_pages - 7, total_pages);
	} else if(page <= 4) {
		$("#pager-first").hide();
		$("#pager-last, #pager-next, #pager-prev").show();
		set_pager(1,7);
	} else if(page >= (total_pages - 4)) {
		$("#pager-first, #pager-prev, #pager-next").show();
		$("#pager-last").hide();
		set_pager(total_pages - 7, total_pages);
	}
}