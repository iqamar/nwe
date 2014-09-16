// JavaScript Document
	$(document).ready(function(){ 
					$.get(baseUrl+"/sidebars/related_jobs/job",
					function(data){
						if (data != "") {
								$("#net_jobs").html(data);
						//$(".as_country_container:last").after(data);			
						}
						
			});					   
	});// JavaScript Document
	
	$(document).ready(function(){ 
					$.get(baseUrl+"/sidebars/get_latest_posts/blogs",
					function(data){
						if (data != "") {
							
								$("#net_blogs").html(data);
						//$(".as_country_container:last").after(data);	
						$("#sidebar_loader").html('');
						}

			});					   
	});// JavaScript Document