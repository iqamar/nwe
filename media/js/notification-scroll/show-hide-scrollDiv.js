   $(window).load(function () {
        $(".demo").customScrollbar({preventDefaultScroll: true});
        $("#fixed-thumb-size-demo").customScrollbar({fixedThumbHeight: 50, fixedThumbWidth: 60});
 });
$(document).ready(function(){
	$(window).load(function(){
	$("#notification .has-sub ul").css("display", "none");
	$("#notification").mouseover(function(){
            /*
             * Fix for notificatoin when empty, display:none not suitable.
             */
            $("#notification ul li.has-sub ul").css("visibility","visible");
		$("#notification .has-sub ul").show();
                
		});
	$("#notification .has-sub ul, #notification").mouseleave(function(){
		$("#notification .has-sub ul").hide();
	});
});
});