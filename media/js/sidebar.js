// JavaScript Document
/* Profile sidebar JS*/
 	$(document).ready(function(){ 
		$("#profile_loader").html("<img src='"+media+"/img/loading.gif' alt='loading'/>");
				$.get(baseUrl+"/sidebars/user_activities/birthday",
				function(data){
					if (data != "") {
						$("#profile_activities").html(data);
						//$(".as_country_container:last").after(data);
					}
					
		});					   
	}); 
	
	$(document).ready(function(){ 
				$.get(baseUrl+"/sidebars/related_jobs/job",
				function(data){
					if (data != "") {
						$("#net_jobs").html(data);
						//$(".as_country_container:last").after(data);
					}
					
		});					   
	}); 
	$(document).ready(function(){ 
				
				$.get(baseUrl+"/sidebars/get_users_news/news",
				function(data){
					if (data != "") {
						$("#net_news").html(data);
						//$(".as_country_container:last").after(data);
					}
					
		});					   
	}); 
	
	$(document).ready(function(){ 
				$.get(baseUrl+"/sidebars/known_people/2ndlevel",
				function(data){
					if (data != "") {
						$("#net_known_people").html(data);
						//$(".as_country_container:last").after(data);
					}
					
		});					   
	});
	
   $(document).ready(function(){ 
				$.get(baseUrl+"/sidebars/view_profile/viewprofile",
				function(data){
					if (data != "") {
						$("#net_viewprofile").html(data);
						//$(".as_country_container:last").after(data);
					}
					
		});					   
	});
   
   $(document).ready(function(){ 
				$.get(baseUrl+"/sidebars/profile_strength/strenght",
				function(data){
					if (data != "") {
						$("#net_strength").html(data);
						//$(".as_country_container:last").after(data);
					}
					
		});					   
	});
   
      $(document).ready(function(){ 
				$.get(baseUrl+"/sidebars/profile_performance/performance",
				function(data){
					if (data != "") {
						$("#net_performance").html(data);
						//$(".as_country_container:last").after(data);
					}
					
		});					   
	});
	  
	 $(document).ready(function(){ 
				$.get(baseUrl+"/sidebars/want_to_follow_company/companies",
				function(data){
					if (data != "") {
						$("#net_companies").html(data);
						//$(".as_country_container:last").after(data);
					}
					
		});					   
	});
	 
	$(document).ready(function(){ 
				$.get(baseUrl+"/sidebars/may_like_groups/groups",
				function(data){
					if (data != "") {
						$("#net_groups").html(data);
						//$(".as_country_container:last").after(data);
						$("#profile_loader").html('');
					}
					
		});					   
	});
	