<?php  App::import("Model", "Statusupdate");
	  $obj = new Statusupdate();?>
<div class="profile-box">
   <div class="profile-box-heading">
	<h1>
	  <div class="heading-text">Your Notifications</div></h1>
    </div>
    <div class="success_msg" id="message_notification" style="display:none;">Your notification has been deleted successfully!</div>
    <div class="clear"></div>
		<ul class="notifications">
        <?php 
			
			foreach ($user_notifications as $notification) {
				$notify_date = $notification['master_activities']['created'];
				$date_created = date('d F Y',strtotime($notify_date));
				$date_no_time = date('Y-m-d',strtotime($notify_date));
				$date_activities = $this->requestAction(array('controller'=>'home','action'=>'date_activity',$date_no_time));
			?>
        	<div class="margintop20">
            	<strong>
					<?php if ($date_no_time == date('Y-m-d')) { echo "Today"; } else { echo $date_created;}?>
            	</strong>
            </div>
           <?php  $flag = false; 
		   		foreach ($date_activities as $notification_row) {
					$activity_type = $notification_row['master_activities']['activity_type'];
					$activity_id = $notification_row['master_activities']['activity_id'];
					$id = $notification_row['master_activities']['id'];
					$post_owner = $notification_row['master_activities']['post_owner'];
					if ($activity_type == "connection") {
						$activity_id = $notification_row['master_activities']['user_id'];
					}
					$activity_record = '';
					if ($post_owner == $uid && ($activity_type == "likes" || $activity_type == "comments" || $activity_type == "connection")) {
							$activity_record = $obj->get_activity($activity_id,$activity_type);
						}
					if ($activity_type == "updates") {
						if (in_array($post_owner,$friends_Lists)) {
							$activity_record = $obj->get_activity($activity_id,$activity_type);
						}
					}
					if ($activity_record) {
						$flag = true;
							if ($activity_type == 'comments') {
								$post_id = $activity_record['comments']['content_id'];
								$class = 'comment-icon';
								$text = ', <a href="'.NETWORKWE_URL.'/home/view/'.$post_id.'/'.$id.'">comment</a>'." on your update";
							} else if ($activity_type == 'likes') {
								$post_id = $activity_record['likes']['content_id'];
								$class = 'like-icon';
								$text = ', <a href="'.NETWORKWE_URL.'/home/view/'.$post_id.'/'.$id.'">like</a>'." your update";
							} else if ($activity_type == 'updates') {
								$class = 'post-icon';
								$post_id = $activity_record['statusupdates']['id']; 
								$text = ', share <a href="'.NETWORKWE_URL.'/home/view/'.$post_id.'/'.$id.'">update</a>'." on NetworkWE";
							} else if ($activity_type == 'connection') {
								 $class = 'connection-icon';
								$text = ", accept ".'<a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$uid.'/'.$id.'">your</a>'." connection request";
								$post_id = $activity_record['users_profiles']['user_id']; 
							}
							$user_name = $activity_record['users_profiles']['firstname']." ".$activity_record['users_profiles']['lastname'];
							
							$created_dt = $notification_row['master_activities']['created'];
							$time = date('h:i A',strtotime($created_dt));
							$toll_tipID = "'".'#user'.$id.''."'";
							$photo = $activity_record['users_profiles']['photo'];
							$u_id = $activity_record['users_profiles']['user_id'];
							
							?>
							<li id="<?php echo $id;?>">
								<div class="<?php echo $class;?>" style="cursor:pointer;"></div>
								<a href="#" onmouseover="tooltip.pop(this, <?php echo $toll_tipID;?>, {position:2, offsetY: -18, calloutPosition: 0.1})">
								<?php echo $user_name;?></a> <?php echo $text;?> <span class="notification-time"><?php echo $time;?></span>
                                <div style="display:none;">
                                    <div id="user<?php echo $id;?>"> 
                                        <div class="userlikes">
                                            <div class="userlikes-pic">
                                                <a href="<?php echo NETWORKWE_URL.'/users_profiles/userprofile/'.$u_id;?>">
                                                	<?php 
													if ($photo && file_exists(MEDIA_PATH.'/files/user/icon/'.$photo)) {
														echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$photo);
													} else {
														echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg');
													}
													?>
                                                </a>
                                            </div>
                                            <div class="userlikes-rgt">
                                                <ul>
                                                    <li>
                                                        <h1><a href="<?php echo NETWORKWE_URL.'/users_profiles/userprofile/'.$u_id;?>"><?php echo $user_name;?></a></h1>
                                                    </li>
                                                    <li><?php echo $activity_record['users_profiles']['tags'];?></li>
                                                </ul>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                
		<!--<a title="Delete" style="cursor:pointer;" alt="Delete " class="del-notification" onclick="delete_notification('<?php //echo $id;?>','<?php //echo $activity_type;?>');"></a>-->                        
							</li>
             		<?php } ?>                      
        <?php }
		   if ($flag == false) {
			 
			 		echo '<li>You have no notification</li>';
		   		}
		}?>
		</ul>
	<div class="clear"></div>
</div>
<div class="clear"></div>
<script>
function delete_notification(notification_id,type) {
	var checkstr =  confirm('Are you want to delete this?');
		if(checkstr == true){
  			$.ajax({
					url     : baseUrl+"/home/delete_notification",
					type    : "GET",
					cache   : false,
					data    : {notification_id: notification_id,type:type},
					success : function(data){
						//if (share == 1) {
					//$("#message_update").slideDown('slow');
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$("#message_notification").slideDown('slow').delay(1000).fadeOut();
					$("#"+notification_id).slideUp('slow');
						//}
					},
					complete: function() {
					$("#"+notification_id).css({ opacity: 0.6 });		
					},
					error : function(data) {
					$("#"+notification_id).html(data);
					}
			});
		}
		else{
		return false;
		}
}
</script>