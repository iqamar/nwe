<?php //print_r($siteusers);
$strstr = "";
if ($this->Session->read(@$userid)) {
	$uidd = $this->Session->read(@$userid); $uid = $uidd['userid'];}
	foreach ($siteusers as $users) {
		if ($users['users_profiles']['user_id'] != $uid) {
			$firstname = $users['users_profiles']['firstname'];
			$lastname = $users['users_profiles']['lastname'];
			$id = $users['users_profiles']['user_id'];
			$pic = $users['users_profiles']['photo'];
			//$strstr .= '"'.$firstname .' '.$lastname.'-'.$id.'",';
			$strstr .= '"'.$firstname .' '.$lastname.'-'.$id.'",';
		}
	}
	$stsstr = trim($stsstr, ",");
?>
<script type="text/javascript"> 

function showPeopleUser(search_str) {
var search_str = document.getElementById('search_str').value;
$.ajax({
              url     : baseUrl+"/home/search_people",
              type    : "GET",
              cache   : false,
              data    : {search_str: search_str},
              success : function(data){
				  if (search_str !='') {
			  $("#result_user").html(data);
				  }
				  else {
					$("#result_user").html("");  
				  }
              },
			  error : function(data) {
           $("#result_user").html("there is error");
        }
          });
		  
}
</script>
<div class="grid_8" style="margin:0px;">
<div id="span_user">		                              
   <?php echo $this->fetch('content'); ?> 
     </div>                      
 </div>               
 
 
