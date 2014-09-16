$(document).ready(function(){ 
	var ID;
	function load_more() 
		{ 			
		 if(ID == $(".as_country_container:last").attr("id")) 
		 	{
				return false;
			}
            ID = $(".as_country_container:last").attr("id");
			$("#loader").html("<img src='"+media+"/img/loading.gif' alt='loading'/>");
			$.get(baseUrl+"/home/bl_get_home_ajax/"+ID,
			function(data){
				if (data != "") {
				$(".as_country_container:last").after(data);			
				}
				$("#loader").html('');
			});
		};  
		
		$(window).scroll(function(){
			
			
			if  ($(window).scrollTop()  == $(document).height() - $(window).height()){
					setTimeout(function() {
					// This is the Ajax function					
					load_more();
							
					}, 500);
			   
			}
		}); 
		
		
		$("#loader").html("<img src='"+media+"/img/loading.gif' alt='loading'/>");
			$.get(baseUrl+"/home/bl_get_home_ajax/tops",
			function(data){
				if (data != "") {
						$("#updates_nt").html(data);
				//$(".as_country_container:last").after(data);			
				}
				$("#loader").html('');
			});
			
});// JavaScript Document