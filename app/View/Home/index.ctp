<?php echo $this->Html->css(MEDIA_URL.'/css/content-grab.css'); ?>
<div id="tab-container1" class='tab-container1'>
	<ul class='etabs'>
		<li class='tab1'><a href="#share">Share Updates</a></li>
		<li class='tab1'><a href="#tweet">Write Tweet</a></li>
		<div class="tab1 postarticle-tab"><a href="/news/add_article">Post Articles</a></div>
	</ul>
	<div class='panel-container1'>
		<div id="share">
			<div class="sharepost-user">
				<div class="sharepost-user-pic">
				<?php 
					if(!empty($imgname)&& file_exists(MEDIA_PATH.'/files/user/icon/'.$imgname)){ 
						echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$imgname,array('url'=>array('controller'=>'users_profiles','action'=>'myprofile')));
					}else{ 
						echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'users_profiles','action'=>'myprofile')));
					} 
				?>
				</div>
				<div class="sharepost-textarea">
					<?php 
						
						if($userInfo['users']['id']) {
							$uid = $userInfo['users']['id'];
							
						?>
					

					<?php echo $this->Form->create('Statusupdate', array('url'=>'/home/ajax_add/','enctype'=>'multipart/form-data','onsubmit'=>'return validateForms();','id'=>'updateUploader','class'=>'sharepost'));?>
					
						<div class="attach-file-tweet">
							<?php echo $this->Html->image(MEDIA_URL.'/img/attachefile.png',array('alt'=>'uploading','class'=>'uploadimg'));?>
							<?php echo $this->Form->file('photo',array('required'=>false,'class'=>'attachedfile-style','id'=>'newAvatar'));?>
						</div>
					<label>
						<?php echo $this->Form->input('user_id' , array('type' => 'hidden', 'value' => $uid)); ?>
						<?php echo $this->Form->input('share_with' , array('type' => 'hidden', 'id' => 'share_with')); ?>
						<?php echo $this->Form->textarea('user_text',array('required'=>false,'placeholder'=>'Share Update','id'=>'get_url','class'=>'shareupdate-field')); ?>
					</label>
					
					<div class="div-for-share" id="div-for-share" style="display:none;">
						<a href="javascript:void(0)" onclick="clearUpdate();" class="comment-close"></a>
						<div id="results"></div>
						<img class='preview_img' src="" alt="No Image Found" width="150" height="100" style="display:none;" id="preimg"/>
						<div class='result_txt' style="display:none;"></div>
						<div class="clear"></div>
						<?php echo $this->Form->textarea('link_content',array('required'=>false,'id'=>'link_content','style'=>'display:none;')); ?>
						
					</div>
					<div id="output" style="display:none; text-align:center;">
						<?php echo $this->Html->image(MEDIA_URL.'/img/ajax-loader.gif',array());?>
					</div>
					<div id="share-bttns" style="display:none;">
						<?php echo $this->Form->submit('Share',array('div'=>false,'id'=>'uploadButton','class'=>'sharepostbttn_fix')); ?>
						<select name="data[Statusupdate][share_with]" class="default" tabindex="3" style="width:410px;">
                            <option value="0" class="" selected>Public</option>
                            <option value="1" class="">Connection</option>
                            <option value="2" class="">Only Me</option>
						</select>
					</div>
					
					<?php echo $this->Form->end();?>
					<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div id="tweet">
			<div class="sharepost-user">
				<div class="sharepost-user-pic">
					<?php 
					if(!empty($imgname)&& file_exists(MEDIA_PATH.'/files/user/thumbnail/'.$imgname)){ 
						echo $this->Html->Image(MEDIA_URL.'/files/user/thumbnail/'.$imgname,array('url'=>array('controller'=>'users_profiles','action'=>'myprofile')));
					}else{ 
						echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'users_profiles','action'=>'myprofile')));
					} 
					?>
				</div>
				<div class="sharepost-textarea">
					<?php 
						if($userInfo['users']['id']) {
							$uid = $userInfo['users']['id'];
							
						?>
					<form name="Tweet" method="post" enctype="multipart/form-data" action="<?php echo NETWORKWE_URL;?>/tweets/add_tweet/" class="writetweet">
						<fieldset>
							<input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
							<input type="hidden" name="status" id="status" value="2" />
							
								<div class="attach-file-tweet">
									<?php echo $this->Html->image(MEDIA_URL.'/img/attachefile.png',array('alt'=>'uploading','class'=>'uploadimg'));?>
									
									
									<input type="file" name="photo" id="newAvatar1" class="attachedfile-style" />
								</div>
							<label> 
								<textarea id="twetarea" placeholder="Write Your Tweet..."  name="tweet" class="tweettextfield"></textarea>
							</label><br />
							<div class="div-for-share" id="div-for-share1" style="display:none;">
								<a href="javascript:void(0)" onclick="clearUpdateTW();" class="comment-close"></a>
								<img class='preview_img' src="" alt="No Image Found" width="150" height="100" style="display:none;" id="preimgTW"/>
								<div class='result_txt' style="display:none;"></div>
								<div class="clear"></div>
							</div>
							<div id="tweetbttn">
								<span class="note-text" ><em id="tweet_count"></em> characters</span>
																
									<input type="submit" class="submitbttn"  value="Tweet" id="TW" />
									<input type="button" class="canclebttn"  value="Cancel" />
									
							</div>
						</fieldset>
					</form>
					<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div>		
<div class="success_msg" id="message_update" style="display:none;">Your Post has been deleted successfully!</div>
<div class="clear"></div>

<!-- News/Articles slider start-->
<?php
	echo $this->element('Widgets/articles_slider'); 
?>
<!-- News/Articles slider end-->

<!-- Updates listing start-->
<div class="box">
	<div class="sharepost-user">
		<?php if(count($recentlyJoinArray)>0){ ?>
		<div class="post-wall">
			<div class="userpic-post">
				<?php echo $this->Html->image(MEDIA_URL.'/img/connection_pic.jpg',array('width'=>65,'height'=>57)); ?>
				
			</div>
			<div class="post-wall-rgt">
				<div class="connections-text"><?php echo count($recentlyJoinArray); ?> people have new connections </div>
				<div class="postwall_connections-div">
				<ul>
					
					<li>
						<div class="post-wall-subcontent">
							<?php 
								foreach ($recentlyJoinArray as $new_con_row) {
								$newArrayParent = $new_con_row[0]['users_profiles'];
								$u_id = $newArrayParent['user_id'];
								$parentName= $newArrayParent['firstname'].' '.$newArrayParent['lastname'];
								$toll_tipID = "'".'#user'.$u_id.''."'";
								$user_tags = '';
								$user_tags = $newArrayParent['tags'];
								
							?>
							<ul class="postwall_connections">
								<li>
									<?php 
										if ($newArrayParent['photo']){
											if(file_exists(MEDIA_PATH.'/files/user/icon/'.$newArrayParent['photo'])){
												$user_photo=MEDIA_URL.'/files/user/icon/'.$newArrayParent['photo'];
											}else{
												$user_photo=MEDIA_URL.'/img/nophoto.jpg';
											}
										 }
										 else { 	
												$user_photo=MEDIA_URL.'/img/nophoto.jpg'; 
										 }
										 // echo $this->Html->image($user_photo,array('width'=>30,'height'=>30,'class'=>'toolid','id'=>$newArrayParent['user_id'],'data-toggle'=>'tooltip','data-placement'=>'bottom','data-original-title'=>$parentName,'url'=>array('controller'=>'users_profiles','action'=>'userprofile',$newArrayParent['user_id'])));
										 echo '<a href="#" onmouseover="tooltip.pop(this,'.$toll_tipID.')">';
										echo $this->Html->image($user_photo,array('width'=>30,'height'=>30));
										echo '</a>';
										
										echo '<div style="display:none;">
										<div id="user'.$u_id.'"> 
											<div class="userlikes">
												<div class="userlikes-pic">
													<a href="/users_profiles/userprofile/'.$u_id.'"><img src="'.$user_photo.'" alt=""/></a>
												</div>
												<div class="userlikes-rgt">
													<ul>
														<li>
															<h1><a href="/users_profiles/userprofile/'.$u_id.'">'.$parentName.'</a></h1>
														</li>
														<li>'.$user_tags.'</li>
													</ul>
												</div>
												<div class="clear"></div>
											</div>
										</div>
									</div>'; 
									?>
									
								</li>
								<li><span class="connection_arrow"></span></li>
								<?php 
						foreach ($recentlyFriendsJoin as $key=>$friend_con_Row) {
								$newFriendsArray = $friend_con_Row[0]['users_profiles']; 
								$connection_date = $friend_con_Row[0]['connections'];
								$today = strtotime(date('Y-m-d H:i:s'));
								$distination = strtotime($connection_date['created']);
								$difference = ($today - $distination);
								$days = floor($difference/(60*60*24));
								$hours = floor($difference/(60*60));
								
								$friend_tags = '';
								$friend_id = $newFriendsArray['user_id'];
								$toll_tip_friendId = "'".'#user'.$friend_id.''."'";
								$friend_tags = $newFriendsArray['tags'];
								$friendName = $newFriendsArray['firstname'].' '.$newFriendsArray['lastname'];
								if ($u_id == $uid) {
									$connection_id = $friend_id;
								}
								else if($friend_id == $uid) {
									$connection_id = $u_id;
								}
								else {
									if(in_array($u_id,$friends_Lists)) {
										$connection_id = $friend_id;
									}
									else {
										$connection_id = $u_id;
									}
								}
								
								
						?>
								<li>
								<?php 
									if ($newFriendsArray['photo']){
										if(file_exists(MEDIA_PATH.'/files/user/icon/'.$newFriendsArray['photo'])){
											$newfriend_photo=MEDIA_URL.'/files/user/icon/'.$newFriendsArray['photo'];
										}else{
											$newfriend_photo=MEDIA_URL.'/img/nophoto.jpg';
										}
									 }
									 else { 	
											$newfriend_photo=MEDIA_URL.'/img/nophoto.jpg'; 
									 }
									 echo '<a href="#" onmouseover="tooltip.pop(this,'.$toll_tip_friendId.', {position:2, offsetY: -18, calloutPosition: 0.1})">';
									  echo $this->Html->image($newfriend_photo,array('class'=>''));
									  echo '</a>';
									  
									 //echo $this->Html->image($newfriend_photo,array('class'=>'toolid','data-toggle'=>'tooltip','data-placement'=>'bottom','id'=>$newFriendsArray['user_id'],'data-original-title'=>$friendName,'url'=>array('controller'=>'users_profiles','action'=>'userprofile',$newFriendsArray['user_id'])));
									
									
									echo '<div style="display:none;">
										<div id="user'.$friend_id.'"> 
											<div class="userlikes">
												<div class="userlikes-pic">
													<a href="/users_profiles/userprofile/'.$friend_id.'"><img src="'.$newfriend_photo.'" alt=""/></a>
												</div>
												<div class="userlikes-rgt">
													<ul>
														<li>
															<h1><a href="/users_profiles/userprofile/'.$friend_id.'">'.$friendName.'</a></h1>
														</li>
														<li>'.$friend_tags.'</li>
													</ul>
												</div>
												<div class="clear"></div>
											</div>
										</div>
									</div>'; 
							    ?>
								
									
								</li>
								<?php 
									unset($recentlyFriendsJoin[$key]);
									break;
								  }
								?>
							</ul>
							<?php } ?>
						</div> 
					</li>
				</ul>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<?php } ?>
     <!-- User Connection End-->
     
     
  <!-- User congrates messages getting on new job listing Start-->
  <?php 
	foreach ($uers_get_new_job_messgae as $new_job_congrate_mesg) {
				$friend_id = $new_job_congrate_mesg['users_profiles']['user_id'];
				
				$fullname =	$new_job_congrate_mesg['users_profiles']['firstname']." ".$new_job_congrate_mesg['users_profiles']['lastname'];
				$cong_id = $new_job_congrate_mesg['users_messages']['user_id'];	
				$exp_id = $new_job_congrate_mesg['users_experiences']['id'];
				$today = strtotime(date('Y-m-d H:i:s'));
				$distination = strtotime($new_job_congrate_mesg['users_experiences']['start_date']);
				$difference = ($today - $distination);
				$days = floor($difference/(60*60*24));
				$hours = floor($difference/(60*60));
				$minutes = floor($difference/(60));
				?>
            <div class="post-wall" id="result_Divs_<?php echo $exp_id;?>">
            	<div class="userpic-post">
					<?php 
					if(!empty($imgname)&& file_exists(MEDIA_PATH.'/files/user/icon/'.$imgname)){ 
						echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$imgname,array('url'=>array('controller'=>'users_profiles','action'=>'myprofile')));
					}else{ 
						echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'users_profiles','action'=>'myprofile')));
					}
					
					?>
                </div>
                <div class="post-wall-rgt">
					<ul>
                    	<li>	 
                           <strong><?php echo " Say Congrats on the new job";?></strong>
                         </li>
                        <li>
            				<div class="post-wall-subcontent">
                            	<div class="userpic-post">
								<?php if ($new_job_congrate_mesg['users_profiles']['photo']){
											if(file_exists(MEDIA_PATH.'/files/user/icon/'.$new_job_congrate_mesg['users_profiles']['photo'])){
												$newjob_photo=MEDIA_URL.'/files/user/icon/'.$new_job_congrate_mesg['users_profiles']['photo'];
											}else{
												$newjob_photo=MEDIA_URL.'/img/nophoto.jpg';
											}
									 }
									 else { 	
											$newjob_photo=MEDIA_URL.'/img/nophoto.jpg'; 
									 }
									 echo $this->Html->image($newjob_photo);
								
								
							    ?>
                                </div>
                              	<div class="post-wall-subcontent-rgt">
                                	<ul>
                                    	<li>
										<?php echo $this->Html->link($fullname,array(
																					 'controller'=>'users_profiles',
																					 'action'=>'userprofile',
																					  $cong_id));?> 
                                        </li>
                                        <li><?php echo $new_job_congrate_mesg['users_profiles']['tags'];?></li>
                                    </ul>
                                </div>
                                <div class="clear"></div>
                           </div>
                           
                           <div>
                           		<div class="post-bttns">
                                    	<ul>
											<li><a href="#" onClick="showhide('congrateDiv<?php echo $exp_id;?>', 'block'); return false" >Say Congrats 
											<span class="redcolor"></span>
												</a>
                                            </li>
                                            <li>
                                            	<a href="#" class="poplight">	
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
                                                </a>
                                           </li>
                                        </ul>
									 <div class="clear"></div>
                                </div>
                                
                                <!--- Main Comment Box for Post ----->
								<div id="congrateDiv<?php echo $exp_id;?>" style="display:none" class="commentsbox">
                                <div id="congrate_loader_<?php echo $exp_id;?>" style="display:none; text-align:center;">
					 				<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
                            	</div>
                                	<div class="writecomment">
											<div class="comment-listing-pic">
												<?php 
												if(!empty($imgname)&& file_exists(MEDIA_PATH.'/files/user/icon/'.$imgname)){ 
													echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$imgname);
												}else{ 
													echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg');
												}
												?>
                                            </div>
											<div class="writecomment-rgt">
												<input name="postcomment" type="text"  onfocus="if(this.value=='Write Message') this.value='';" onblur="if(this.value=='') this.value='Write Message';" value="Write Message" id="user_message_<?php echo $exp_id;?>" />
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
 					<input type="hidden" name="friend_id" id="friend_id_<?php echo $exp_id;?>" value="<?php echo $new_job_congrate_mesg['users_profiles']['user_id'];?>" />
 					<input type="hidden" name="subject_id" id="subject_id_<?php echo $exp_id;?>" value="<?php echo $exp_id;?>" />
 					<input type="hidden" name="subject_type" id="subject_type_<?php echo $exp_id;?>" value="<?php echo "Congrats";?>" />
                                                <input name="send" type="submit" id="send" onclick="send_Congrate_Message('<?php echo $exp_id;?>');" value="send" />
											</div>
											<div class="clear"></div>
									</div>
									<div class="clear"></div>
                                    <!-- AJAX Response div start-->
                                   <div id="congrateDIV_<?php echo $exp_id;?>"> 
                                    <!--- Comment LISTING Start ---->
                                    <?php 
									foreach ($whoSendYouCongrats as $cong_Row) {
										if ($cong_Row['users_messages']['subject_id'] == $exp_id) {?>
										<div class="comment-listing" id="commentsbox">
											<div class="comment-listing-pic">
												<a href="#">
                                                	<?php 													
														if ($cong_Row['users_profiles']['photo']){
															if(file_exists(MEDIA_PATH.'/files/user/icon/'.$cong_Row['users_profiles']['photo'])){
																$newjobcong_photo=MEDIA_URL.'/files/user/icon/'.$cong_Row['users_profiles']['photo'];
															}else{
																$newjobcong_photo=MEDIA_URL.'/img/nophoto.jpg';
															}
														}
														else { 	
															$newjobcong_photo=MEDIA_URL.'/img/nophoto.jpg'; 
														}
														echo $this->Html->image($newjobcong_photo);
													?>
                                                </a> 
                                            </div>
											<div class="comment-listing-rgt">
                                                <ul>
                                                    <li>
                                                    <a href="#" class="postwall-name">
													<?php echo $cong_Row['users_profiles']['firstname']." ".$cong_Row['users_profiles']['lastname'];?>
                                                    </a> 
                                                    <?php echo substr($cong_Row['users_messages']['user_message'],0,350);?>
                                                     </li>
                                                </ul>
											</div>
											<div class="clear"></div>
										</div>
                                     <?php }}?>
										<!--- End Comments Box --->
                                   </div> <!-- AJAX Response div end-->
                                </div>
                                <!--- Main Comment Box for Post END----->
                                
                           </div> 
		  			</li>	
               </ul>
        	</div>
            <div class="clear"></div>
        </div>
       <?php }?>         

   <!-- User congrates messages getting on new job listing End--> 
   
   <!-- User Updates Start-->
   <div id="updates_nt">
		
 
   </div>
	<div id="loader" style="text-align:center;"></div>


	</div>
</div> 
<!-- Updates listing end-->


<style>
.over{background-color:#5E5E5E !important;border:1px solid #000000 !important;}
</style>