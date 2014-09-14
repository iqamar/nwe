<?php 
		foreach ($moreComments as $comms) {
			$created_date = $comms['comments']['created'];
			$year = date("Y", strtotime($created_date));
			$month = date("M", strtotime($created_date));
			$day = date("d", strtotime($created_date));
			$time = date("H:i:s", strtotime($created_date));
			$user_id = $comms['comments']['user_id'];
			$commentid = $comms['comments']['id'];
			
?>
 <div class="comment-listing" id="commentsbox'.$commentid.'">
            <div class="comment-listing-pic">
			<?php	 
			if(!empty($comms['users_profiles']['photo'])&& file_exists(MEDIA_PATH.'/files/user/icon/'.$comms['users_profiles']['photo'])){ 
				echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$comms['users_profiles']['photo'],array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$comms['users_profiles']['user_id'])));
				
			}else{ 
				echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$comms['users_profiles']['user_id'])));
			}
			?>
 
			</div>
            <div class="comment-listing-rgt">
            <ul>
                <li>
                <?php echo $this->Html->link($comms['users_profiles']['firstname']." ".$comms['users_profiles']['lastname'],
																														array('controller'=>'users_profiles',
																															  'action'=>'userprofile',
																															  $comms['users_profiles']['user_id']
																															  ));
					?>
                
				<?php echo $comms['comments']['comment_text'];
				if ($user_id == $uid || $post_admin == $uid) { ?>
                <a href="#" onclick="delete_comment('<?php echo $commentid; ?>','<?php echo $content_id;?>');" class="comment-close" title="Delete Update"></a>
                  <?php   } ?>
               </li>
                <li>
                    <a  class="replycomment"><?php echo $day." ".$month.", ".$year."  @ ".$time;?></a><div class="clear"></div>	
                </li>
            </ul>
            </div>
            <div class="clear"></div>
       </div>
       <?php
		}
 ?>