<?php 
if ($get_view_profile) {

?>
	<div class="greybox">
	    <div class="greybox-div-heading">
				<h1>Who Visited Your Profile</h1>
		 </div>
         <?php 
		 foreach ($get_view_profile as $user_your_profile) {
				$user_id = $user_your_profile['users_profiles']['user_id'];
				$full_name = $user_your_profile['users_profiles']['firstname']." ".$user_your_profile['users_profiles']['lastname'];
				$created_date = $user_your_profile['users_viewings']['start_date'];
				$today = strtotime(date('Y-m-d H:i:s'));
				$distination = strtotime($created_date);
				$difference = ($today - $distination);
				$days = floor($difference/(60*60*24));
				$hours = floor($difference/(60*60));
				$fid = $user_your_profile['users_profiles']['user_id'];
				if ($user_id != $uid) {
			?>
         <div class="rgtwidget-listing2">
				<div class="rgtwidget-listing2-logo">
					<?php 
					
					if($user_your_profile['users_profiles']['photo']){
						if(file_exists(MEDIA_PATH.'/files/user/icon/'.$user_your_profile['users_profiles']['photo'])){
							$user_pic=MEDIA_URL.'/files/user/icon/'.$user_your_profile['users_profiles']['photo'];
						}else{
							$user_pic=MEDIA_URL.'/img/nophoto.jpg';
						}
					}else{
						$user_pic=MEDIA_URL.'/img/nophoto.jpg';
					}
					echo $this->Html->image($user_pic,array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$user_id)));
					?>
				</div>
				<div class="rgtwidget-listing2-rgt">
				<ul> 
					<li>
						<h1>
                        	<?php echo $this->Html->link(substr($full_name,0,20),
														 array('controller'=>'users_profiles',
															   'action'=>'userprofile',
															   $user_id),array('style'=>''));?>
                        </h1>
					</li>
					<li><?php echo substr($user_your_profile['users_profiles']['tags'],0,35);?></li>
							<li>
								<?php 
									if ($days >= 1) echo "$days days ago"; else echo "$hours hours ago"; ?> 
                            </li>
				</ul> 
			</div>
        <div class="clear"></div>
        </div>
        <?php }}?>
    </div>
 <?php }?>  