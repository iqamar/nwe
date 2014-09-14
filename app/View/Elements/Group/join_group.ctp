<div class="ttle-bar effectX">Latest Activity</div>
<ul>
		<?php 
		foreach ($users_following_group as $group__follow_Row) {
			 $fullname = $group__follow_Row['users_profiles']['firstname']." ".$group__follow_Row['users_profiles']['lastname'];
			 $handler = $group__follow_Row['users_profiles']['handler'];
			 if ($group__follow_Row['Users_following']['user_id'] != $group__follow_Row['groups']['user_id'] && $group__follow_Row['Users_following']['user_id'] != $uid) {
			?>
	<li>
 		<div class="relat-jobmain-div">
		  <div class="relat-job-div" style="border-bottom:1px dotted gray;">
		    <div class="relat-jobcolm">
		      	<div class="relat-jobtxt">
        			<h1 style="color: #086A87;width: 270px;">
					<?php echo $this->Html->link($fullname,array('controller'=>'pub','action'=>$handler),
																				  array('style'=>'text-decoration:none; color:#006AD5;'));?>
                       <span style="color:#c1c1c1;font-size:0.8em;"><?php echo $group__follow_Row['users_profiles']['tags'];?></span>                                                           
					</h1>
                   <?php echo "have joined the group";?>
                   <p style="color:#A4A4A4;">
				   <?php 
						$today = strtotime(date('Y-m-d H:i:s'));
						$distination = strtotime($group__follow_Row['Users_following']['start_date']);
						$difference = ($today - $distination);
						$days = floor($difference/(60*60*24));
						$hours = floor($difference/(60*60));
						if ($days >= 1)
						echo "$days days ago";
						else
						echo "$hours hours ago";
						?>
                   </p> 
 				</div>
		   	</div>
  		</div>
 	  	<div class="relat-job-pht" style="background:none;">
        <?php if ($group__follow_Row['users_profiles']['photo']) {
			echo $this->Html->image('/files/users/'.$group__follow_Row['users_profiles']['photo'],array('style'=>'width:50px; height:50px;'));
		}
		else {
			
			echo $this->Html->image('no-image.png',array('style'=>'width:50px; height:50px;'));
		}
		?>
        </div>
		<!--<div style="float:right;padding-right:10px;margin-top:-70px"><a onclick="">x</a></div>-->
		</div>  
	</li>
   <?php }}?> 
   <?php foreach ($user_comments as $group_dis_Row) {
	   $fullname = $group_dis_Row['users_profiles']['firstname'];
	   $handler = $group_dis_Row['users_profiles']['handler'];
	   ?>
   <li>
 		<div class="relat-jobmain-div">
		  <div class="relat-job-div" style="border-bottom:1px dotted gray;">
		    <div class="relat-jobcolm">
		      	<div class="relat-jobtxt">
        			<h1 style="color: #086A87;width: 270px;">
					<?php echo $this->Html->link($fullname,array('controller'=>'pub','action'=>$handler),
																				  array('style'=>'text-decoration:none; color:#006AD5;'));?>                                     
					</h1>
                   <?php echo " commented in the group on ";?>
                   <?php echo $this->Html->link($group_dis_Row['entity_updates']['group_title'],array('controller'=>'pub','action'=>$handler),
																				  array('style'=>'text-decoration:none; color:#006AD5;'));?> 
                   <p style="color:#A4A4A4;">
				   <?php 
						$today = strtotime(date('Y-m-d H:i:s'));
						$distination = strtotime($group_dis_Row['entity_comments']['created']);
						$difference = ($today - $distination);
						$days = floor($difference/(60*60*24));
						$hours = floor($difference/(60*60));
						if ($days >= 1)
						echo "$days days ago";
						else
						echo "$hours hours ago";
						?>
                   </p> 
 				</div>
		   	</div>
  		</div>
 	  	<div class="relat-job-pht" style="background:none;">
        <?php if ($group_dis_Row['users_profiles']['photo']) {
			echo $this->Html->image('/files/users/'.$group_dis_Row['users_profiles']['photo'],array('style'=>'width:50px; height:50px;'));
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