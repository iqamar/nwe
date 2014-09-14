<div class="ttle-bar effectX">Your created groups</div>
<h1 style="padding:5px 28px; color:#333; font-size:13px; text-align:right; font-weight:bold;">
<?php echo $this->Html->link('Add Group >>',array('controller'=>'groups','action'=>'add'),array('style'=>'text-decoration:none; color:#333;'));?>
</h1>
<ul>
		<?php foreach ($user_added_groups as $group__Row) {
			 $groupID = $group__Row['groups']['id'];
			$grouptitle = strtolower($group__Row['groups']['title']);
			$grouptitle = str_replace(' ', '-', $grouptitle);
			?>
	<li>
 		<div class="relat-jobmain-div">
		  <div class="relat-job-div" style="border-bottom:1px dotted gray;">
		    <div class="relat-jobcolm">
		      	<div class="relat-jobtxt">
        			<h1 style="color: #086A87;width: 270px;">
					<?php echo $this->Html->link($group__Row['groups']['title'],array('controller'=>'groups','action'=>'view',$groupID,$grouptitle),
																				  array('style'=>'text-decoration:none; color:#006AD5;'));?>
						<span style="color:#c1c1c1;font-size:0.8em;"><?php echo $group__Row['groups_types']['title'];?></span>
					</h1>
                   
 				</div>
		   	</div>
  		</div>
 	  	<div class="relat-job-pht" style="background:none;">
        <?php if ($group__Row['groups']['logo']) {
			echo $this->Html->image('/files/groups_logo/'.$group__Row['groups']['logo'],array('style'=>'width:50px; height:50px;'));
		}
		else {
			
			echo $this->Html->image('no-image.png',array('style'=>'width:50px; height:50px;'));
		}
		?>
        </div>
		<!--<div style="float:right;padding-right:10px;margin-top:-70px"><a onclick="">x</a></div>-->
		</div>  
	</li>
   <?php }?> 

</ul>	
<script type="text/javascript">
	function searchCompanies(country_id) {

$.ajax({
              url     : baseUrl+"/companies/resultant_companies/",
              type    : "GET",
              cache   : false,
              data    : {country_id: country_id},
              success : function(data){
			  $("#search_result").html(data);
              },
			  error : function(data) {
           $("#search_result").html("there is error");
        }
          });
		  
}
</script>