<?php 
	//print_r($updates_by_ajax);
	
	foreach ($updates_by_ajax as $ustatus) { 
	$post_id = $ustatus['statusupdates']['id'];
	$today = strtotime(date('Y-m-d H:i:s'));
	$distination = strtotime($ustatus['statusupdates']['created']);
	$difference = ($today - $distination);
	$days = floor($difference/(60*60*24));
	$hours = floor($difference/(60*60));
	$minutes = floor($difference/(60));
	$share_with = $ustatus['statusupdates']['share_with'];
	$user_idd = $ustatus['statusupdates']['user_id'];
	
	if ($share_with == 0) {
	?>
	<div id="<?php echo $ustatus['statusupdates']['id'];?>" class="post-wall as_country_container">
		<div class="userpic-post">
			<?php 
				 
			 if ($ustatus['users_profiles']['photo']){
				if(file_exists(MEDIA_PATH.'/files/user/icon/'.$ustatus['users_profiles']['photo'])){
					$ustatus_photo=MEDIA_URL.'/files/user/icon/'.$ustatus['users_profiles']['photo'];
				}else{
					$ustatus_photo=MEDIA_URL.'/img/nophoto.jpg';
				}
			 }
			 else { 	
					$ustatus_photo=MEDIA_URL.'/img/nophoto.jpg'; 
			 }
			 echo $this->Html->image($ustatus_photo,array('url'=>'#','onclick'=>'loadSharePopup();'));
			 
		   ?>
		   
		 
		</div>
		<div class="post-wall-rgt">
			<ul>
				<li><?php echo $this->Html->link($ustatus['users_profiles']['firstname']." ".$ustatus['users_profiles']['lastname'],'#',array('onclick'=>'loadSharePopup();'));
					?>
				</li>
				<li>
					<div class="post-wall-subcontent">
					<?php 
					if ($ustatus['statusupdates']['content_type'] == "updates" || $ustatus['statusupdates']['content_type'] == "jobs") { ?>
						<?php if ($ustatus['statusupdates']['photo']) { ?>
							<div class="post-wall-subcontent-rgt2">
								<ul>
									<li>
										<div class="subcontent2-pic">
											<a href="#" data-toggle="modal" data-target="#popup-bigimg<?php echo $post_id;?>">
											<?php 
												echo $this->Html->image(MEDIA_URL.'/files/update/original/'.$ustatus['statusupdates']['photo'],array('style'=>'height:auto; width:auto; max-width:250px; max-height:250px;'));							
											?>
											</a>
										</div>
									</li>
									<li>
									<?php
									  if ($ustatus['statusupdates']['update_type'] == 0) {
										echo substr($ustatus['statusupdates']['user_text'],0,250);
										$str_len = strlen($ustatus['statusupdates']['user_text']);
										if ($str_len > 250 && $ustatus['statusupdates']['user_text'] != '') {?>
											<a href="#" onclick="loadSharePopup()"> More..</a>
									<?php	}
									  }
									  else {
										  echo $ustatus['statusupdates']['user_text'];
									  }
									?>
									</li>
								</ul>
							</div>
							<?php } 
							 else {?>
								<?php
									  if ($ustatus['statusupdates']['update_type'] == 0) {
										echo substr($ustatus['statusupdates']['user_text'],0,250);
										$str_len = strlen($ustatus['statusupdates']['user_text']);
										if ($str_len > 250 && $ustatus['statusupdates']['user_text'] != '') {?>
											<a href="#" onclick="loadSharePopup()"> More..</a>
									<?php	}
									  }
									  else {
										  echo $ustatus['statusupdates']['user_text'];
									  }
									?>
							<?php }?>
					<?php }
					else if ($ustatus['statusupdates']['content_type'] == "blog") {
								$title_url = str_replace(" ", "-", strtolower($ustatus['statusupdates']['photo']));
								echo " shared a blog on NetworkWe ".'&nbsp;';
								echo $this->Html->link(substr($ustatus['statusupdates']['photo'],0,200),
															array('controller'=>'blogs','action'=>'view',$ustatus['statusupdates']['share'],$title_url));
															
					}
					if ($ustatus['statusupdates']['content_type'] == "news") {
						echo " shared news on NetworkWe ".'&nbsp;';
						$title_url = str_replace(" ", "-", strtolower($ustatus['statusupdates']['user_text']));
						echo $this->Html->link($ustatus['statusupdates']['user_text'],
															array('controller'=>'news','action'=>'view',$ustatus['statusupdates']['share'],$title_url));
					}
					?>
					<div class="clear"></div>
					</div>
					
					<div>
						<div class="post-bttns">
							<ul>
								 <li>
									 <div id="user_like_update_<?php echo $ustatus['statusupdates']['id'];?>">
									<?php 
											$flage = false;
											foreach ($likes_on_Update as $like_update_row)  {
												$user_id = $like_update_row['likes']['user_id'];
												$content_id = $like_update_row['likes']['content_id'];
												if ($ustatus['likes']['like'] == 1 && $user_id == $uid && $ustatus['likes']['content_id'] == $content_id) {?>
													<div class="likedText" style="float:left;"><a href="Javascript:loadSharePopup('<?php echo $post_id;?>','0');" class="like">Liked
														<?php echo "(".$ustatus[0]['total'].")";?></a>
													</div> 
													<?php $flage = true;
												 }
											}
											if ($flage == false) {  ?>
												<a href="Javascript:loadSharePopup('<?php echo $ustatus['statusupdates']['id'];?>','1');" id="alike<?php echo $ustatus['likes']['content_id'];?>" class="like">Like <?php echo "(".$ustatus[0]['total'].")";?></a>
												<div class="likedText" style="display:none;" id="likediv<?php echo $ustatus['likes']['content_id'];?>">
												<a href="Javascript:loadSharePopup('<?php echo $post_id;?>','0');" class="like">Liked<?php echo "(".$ustatus[0]['total'].")";?></a>
												</div>     
										<?php } ?>
									</div>
								</li>
								<li><a href="#" onClick="loadSharePopup('commentsDiv<?php echo $ustatus['statusupdates']['id'];?>', 'block'); return false" >Comments 
								<span class="redcolor">
								<?php 
										$chk_comments = 0;
										foreach ($updates_comments_count as $comments_total_row) {
												if ($comments_total_row['comments']['content_id'] == $post_id) {
													echo '(<span id="total_comment_'.$post_id.'">'.$comments_total_row[0]['commenttotal'].'</span>'.')';
													$chk_comments = 1;
												}
											}
											if ($chk_comments == 0) {
													echo "(".'<span id="total_comment_'.$post_id.'">0</span>'.")";
											}
								 ?>
										</span>
									</a>
								</li>
								
								<?php if ($ustatus['statusupdates']['content_type'] != "blog") { 
									$count_share = 0;
									foreach ($share_on_Update as $share_row) {
											$shared_content_id = $share_row['statusupdates']['share'];
										if ($shared_content_id == $post_id) {
											$count_share++;
										}
									}
								?>
								<li>
							 <a href="javascript:loadSharePopup('<?php echo $ustatus['statusupdates']['id'];?>')" class="sharecontent">Share</a>
							 <a href="javascript:loadSharePopup('<?php echo $post_id;?>')" class="poplight totalnumber"><span class="redcolor"><?php echo "(".$count_share.")";?></span> </a>
								</li>  
								<?php }?>
							   <li>
								<?php 
									if ($days >= 1){
										echo "$days days ago";
									}else{
										if($hours >=1){
											echo "$hours hours ago";
										}else{
											echo "$minutes minutes ago";
										}
									}
									?>
							   </li>
							</ul>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
						           
						
						
					</div>
				</li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
	<?php }
     } ?>
	