<?php 
 $strstr ="";
	foreach ($comments_this_post as $comment__row) {
				$full_name = $comment__row['users_profiles']['firstname']." ".$comment__row['users_profiles']['lastname'];
				$created_date = $comment__row['Comment']['created'];
				$year = date("Y", strtotime($created_date));
				$month = date("M", strtotime($created_date));
				$day = date("d", strtotime($created_date));
				$commentid = $comment__row['Comment']['id'];
				$user_id = $comment__row['Comment']['user_id'];
				$time = date("H:i:s", strtotime($created_date));
			
$strstr .='<div class="as_country_container" id="'.$commentid.'">
			<div class="comment-listing" id="commentsbox">
				<div class="comment-listing-pic">'; 
						
						 if ($comment__row['users_profiles']['photo']) {
							 if (file_exists(MEDIA_PATH.'/files/user/icon/'.$comment__row['users_profiles']['photo'])) {
								$strstr .= $this->Html->image(MEDIA_URL.'/files/user/icon/'.$comment__row['users_profiles']['photo'],array('style'=>'width:40px; height:40px;'));
							 }
							 else {
								 $strstr .= $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>'width:40px; height:40px;'));
							 }
						}
						else {
							$strstr .= $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>'width:40px; height:40px;'));
						}
  $strstr .='</div>
				
				
				<div class="comment-listing-rgt">
					<ul>
						<li> <a href="#">'.$full_name.'</a> '.$comment__row['Comment']['comment_text'];
                        if ($user_id == $uid || $admin_id == $uid) {
                  			$strstr .= '<a href="javascript:" onclick="delete_comment('.$commentid.','.$content_id.');" class="comment-close" title="Delete Update"></a>';
                    		} 
             $strstr .= '</li>
						<li class="posttime">'.$day." ".$month.", ".$year."  @ ".$time.'</li>
					</ul>
					
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>';
 }
  echo $total_blogs_comments."::::".$strstr;
 ?>