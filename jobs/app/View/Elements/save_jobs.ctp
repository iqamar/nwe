<?php 


echo $this->Form->hidden('hidden',array('value'=>$jobDetail['Job']['id'],'name'=>'job_id','id'=>'job_id'));
echo $this->Form->hidden('hidden',array('value'=>$userInfo['Users_profile']['user_id'],'name'=>'user_id','id'=>'user_id'));
?>


<script>
	$(function() {
	
	  $('#saveJob').click(function(event){
		//event.preventDefault();
		 
		var job_id = document.getElementById("job_id").value;
		var user_id = document.getElementById("user_id").value;
		
		$("#savedJob").hide();
		 $("#saveJobload").html("<img src='../../ajax-paginator.gif' />&nbsp;&nbsp;<br/>Saving...");
		 $.post('/search/saveJob/',{job_id: job_id,user_id: user_id,status:1},function(result){
			$("#savedJob").show();
			$("#savedJob").html(result);
			$("#saveJobload").html(" ");
			});
			
       
    
    
     });
	 
	 });

</script>


