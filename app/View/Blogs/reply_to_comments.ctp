<?php foreach ($reply_to_comments as $comment__row) {
				$full_name = $comment__row['users_profiles']['firstname']." ".$comment__row['users_profiles']['lastname'];
				$created_date = $comment__row['Comment']['created'];
				$year = date("Y", strtotime($created_date));
				$month = date("M", strtotime($created_date));
				$day = date("d", strtotime($created_date));
				$time = date("H:i:s", strtotime($created_date));
				$commentid = $comment__row['Comment']['id'];
			?>
			<div class="reply_container" id="<?php echo $commentid;?>" style="display:none1;">
				<div class="comment-listing-pic2"> 
					<?php if ($comment__row['users_profiles']['photo']) {
							 if (file_exists(MEDIA_PATH.'/files/user/icon/'.$comment__row['users_profiles']['photo'])) {
								echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$comment__row['users_profiles']['photo'],array('style'=>'width:40px; height:40px;'));
							 }
							 else {
								 echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>'width:40px; height:40px;'));
							 }
						}
						else {
							echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>'width:40px; height:40px;'));
						}?>
					
				</div>
				<div class="writecomment-rgt">
					<ul>
                    	<li>
                        	<a href="#"><?php echo $full_name; ?></a> <?php echo $comment__row['Comment']['comment_text'];?>
                            <a href="javascript:" onclick="delete_reply('<?php echo $commentid;?>','<?php echo $content_id;?>');" class="comment-close" title="Delete Update"></a>
                    	</li>
                    </ul>
					<ul><li><?php echo $day." ".$month.", ".$year."  @ ".$time; ?></li></ul>
				</div>
				<div class="clear"></div>
			</div>
			
 <?php }?>