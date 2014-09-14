<?php echo $this->Html->css(MEDIA_URL.'/css/content-grab.css'); ?>
<div id="tab-container1" class='tab-container1'>
	<ul class='etabs'>
		<li class='tab1'><a href="#share">Share Updates</a></li>
		<li class='tab1'><a href="#tweet">Write Tweet</a></li>
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
						if ($this->Session->read(@$userid)) {
							$cuser = $this->Session->read(@$userid);
							$logged_user = $cuser['Auth']['User'];
							$uid = $cuser['userid'];
							
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
						if ($this->Session->read(@$userid)) {
							$cuser = $this->Session->read(@$userid);
							$logged_user = $cuser['Auth']['User'];
							$uid = $cuser['userid'];
							
						?>
					<form name="Tweet" method="post" enctype="multipart/form-data" action="/tweets/add_tweet/" class="writetweet">
						<fieldset>
							<input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
							<input type="hidden" name="status" id="status" value="2" />
							
								<div class="attach-file-tweet">
									<?php echo $this->Html->image(MEDIA_URL.'/img/attachefile.png',array('alt'=>'uploading','class'=>'uploadimg'));?>
									<input type="file" name="photo" id="newAvatar" class="attachedfile-style" />
								</div>
							<label> 
								<textarea id="twetarea" placeholder="Write Your Tweet..."  name="tweet" class="tweettextfield"></textarea>
							</label><br />
													
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


<!-- Updates listing start-->
<div class="box">
	<div class="sharepost-user">
	<?php 
 	foreach ($my_updates_row as $ustatus) { 
		$post_id = $ustatus['statusupdates']['id'];
		$today = strtotime(date('Y-m-d H:i:s'));
		$distination = strtotime($ustatus['statusupdates']['created']);
		$difference = ($today - $distination);
		$days = floor($difference/(60*60*24));
		$hours = floor($difference/(60*60));
		$minutes = floor($difference/(60));
		$share_with = $ustatus['statusupdates']['share_with'];
		$user_idd = $ustatus['statusupdates']['user_id'];
		
		
	?>
    <div id="<?php echo $ustatus['statusupdates']['id'];?>" class="post-wall as_country_container">
    	<?php if ($user_idd == $uid) {?>
            <a href="javascript:void(o)" onclick="delete_update('<?php echo $post_id;?>');" class="comment-close" title="Delete Update"></a>
            <?php }?>
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
			 echo $this->Html->image($ustatus_photo,array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$ustatus['users_profiles']['user_id'])));
			 
		   ?>
        </div>
        <div class="post-wall-rgt">
        	<ul>
				<li><?php echo $this->Html->link($ustatus['users_profiles']['firstname']." ".$ustatus['users_profiles']['lastname'],
																														array('controller'=>'users_profiles',
																															  'action'=>'userprofile',
																															  $ustatus['users_profiles']['user_id']
																															  ));
					?>
				</li>
                <li>
					<div class="post-wall-subcontent">
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
											<a href="<?php echo NETWORKWE_URL;?>/home/view/<?php echo $post_id;?>"> More..</a>
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
											<a href="<?php echo NETWORKWE_URL;?>/home/view/<?php echo $post_id;?>"> More..</a>
									<?php	}
									  }
									  else {
										  echo $ustatus['statusupdates']['user_text'];
									  }
									?>
                            <?php }?>
                    <div class="clear"></div>
                    </div>
                    <div>
						<div class="post-bttns">
                            <ul>
                                <li>
                               		 <div id="user_like_update_<?php echo $ustatus['statusupdates']['id'];?>">
                                	<?php 
											$flage = false;
	 										foreach ($update_likes as $like_update_row)  {
												$user_id = $like_update_row['likes']['user_id'];
												$content_id = $like_update_row['likes']['content_id'];
												if ($ustatus['likes']['like'] == 1 && $user_id == $uid && $ustatus['likes']['content_id'] == $content_id) {?>
													<div class="likedText" style="float:left;">
                                                   <a href="Javascript:showLikes('<?php echo $post_id;?>','0');" class="like">Liked <?php echo "(".$ustatus[0]['total'].")";?></a>
                                                    </div> 
													<?php $flage = true;
												 }
											}
											if ($flage == false) {  ?>
                                				<a href="Javascript:showLikes('<?php echo $ustatus['statusupdates']['id'];?>','1');" class="like">Like <?php echo "(".$ustatus[0]['total'].")";?></a>
                                               <div class="likedText" style="display:none;" id="likediv<?php echo $ustatus['likes']['content_id'];?>">
                                               	<a href="Javascript:showLikes('<?php echo $post_id;?>','0');" class="like">Liked <?php echo "(".$ustatus[0]['total'].")";?></a>
                                                </div>     
										<?php } ?>
                                	</div>
                                </li>
                                <li><a href="#" onClick="showhide('commentsDiv<?php echo $ustatus['statusupdates']['id'];?>', 'block'); return false" >Comments 
                                <span class="redcolor">
								<?php 
                                        $chk_comments = 0;
                                        foreach ($get_count_comments as $comments_total_row) {
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
                                
                                <?php if ($ustatus['statusupdates']['content_type'] != "blog") { ?>
                                <li>
                             <a href="javascript:loadPopup('<?php echo $ustatus['statusupdates']['id'];?>')" class="sharecontent">Share
                             <span class="redcolor"></span> </a>
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
                        <div id="ajax_res<?php echo $post_id;?>">
							<?php if ($ustatus[0]['total'] != 0) {?>
                            <div class="wholike-div">
                                <div class="icon-like"></div>
                                    <ul>
                                    <?php  $i = 1; $str = ''; $flag_set = false; $you = ''; $andcont = ''; $toltip = '';
                                    foreach ($update_likes as $like_row) {
                                        if ($like_row['likes']['content_id'] == $post_id && $i<=6) {
                                            $fullname = $like_row['users_profiles']['firstname']." ".$like_row['users_profiles']['lastname'];
											$tag = $like_row['users_profiles']['tags'];
                                            $like_photo = $like_row['users_profiles']['photo'];
											if ($like_photo && file_exists(MEDIA_PATH.'/files/user/icon/'.$like_photo)) {
                                            	$like_user_photo=MEDIA_URL.'/files/user/icon/'.$like_photo;
											}
											else {
												$like_user_photo=MEDIA_URL.'/img/nophoto.jpg';
											}
                                            $user_id = $like_row['likes']['user_id'];
											$toll_tipID = "'".'#user'.$user_id.''."'";
                                            if ($user_id == $uid) {
                                       			 $you = '<li><a class="you-text" href="#user'.$user_id.'" onmouseover="tooltip.pop(this, '.$toll_tipID.')">You</a></li>';
                                        		 $andcont = 'and';
												 $flag_set = true;
											} else { 
                                       $str .= '<li>';
										$str .= '<a href="/users_profiles/userprofile/'.$user_id.'">
										<img src="'.$like_user_photo.'" href="#user'.$user_id.'" onmouseover="tooltip.pop(this, '.$toll_tipID.')" /></a>';
                                		// $str .= $this->Html->image($like_user_photo,array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$user_id)));
                                       $str .= '</li>';
                                         $andcont = '';
										 } 
										$toltip .= '<div style="display:none;">
										<div id="user'.$user_id.'"> 
											<div class="userlikes">
												<div class="userlikes-pic">
													<a href="/users_profiles/userprofile/'.$user_id.'"><img src="'.$like_user_photo.'" alt=""/></a>
												</div>
												<div class="userlikes-rgt">
													<ul>
														<li>
															<h1><a href="/users_profiles/userprofile/'.$user_id.'">'.$fullname.'</a></h1>
														</li>
														<li>'.$tag.'</li>
													</ul>
												</div>
												<div class="clear"></div>
											</div>
										</div>
									</div>'; 
										 $i++;}}
										 if ($flag_set == true && $str == '') {
										 	echo $you.$toltip;
										 }
										 else if ($flag_set == true && $str != '') {
											echo $you.'<li style="margin-top:5px;">and</li>'.$str.$toltip;
										 }
										 else {
											echo $str.$toltip; 
										 }
										 ?> 
                                        <?php if ($i>=6) {?>   	
                                        <li><a href="javascript:loadLikesPopup('<?php echo $post_id;?>')" class="poplight totalnumber">
                                        <strong><?php echo "+".$ustatus[0]['total'];?></strong></a></li>
                                        <?php } $i = 1; $andcont = ''; ?>
                                    </ul>
    
                                    <div class="clear"></div>
                                </div>
                             <?php }?>
                           </div>
                        <!--- Main Comment Box for Post ----->
						<div id="commentsDiv<?php echo $ustatus['statusupdates']['id'];?>" style="display:block;" class="commentsbox">
                            <div class="writecomment">
                                <div class="comment-listing-pic">
                                    <?php
									if ($imgname){
										if(file_exists(MEDIA_PATH.'/files/user/icon/'.$imgname)){
											$comm_photo=MEDIA_URL.'/files/user/icon/'.$imgname;
										}else{
											$comm_photo=MEDIA_URL.'/img/nophoto.jpg';
										}
									}
									else { 	
										$comm_photo=MEDIA_URL.'/img/nophoto.jpg'; 
									}
									echo $this->Html->image($comm_photo);
										
										
                                    ?> 
                                </div>
                                <div class="writecomment-rgt">
                                	<input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
                                    <input type="hidden" name="admin_id" id="admin_id<?php echo $post_id;?>" value="<?php echo $user_idd;?>" />
                                    <input type="hidden" name="parent" id="parent" value="0" />
                                    <input type="hidden" name="share" id="share" value="0" />
                                    <input type="hidden" name="id" id="id_<?php echo $ustatus['statusupdates']['id'];?>" value="<?php echo $ustatus['likes']['id'];?>" />
                                    <input type="hidden" name="comment_type" id="comment_type" value="updates" />
                                    <input type="hidden" name="content_id" id="content_id_<?php echo $ustatus['statusupdates']['id'];?>" value="<?php echo $ustatus['statusupdates']['id'];?>" />
                                    <input type="hidden" name="comment_date" id="comment_date_<?php echo $ustatus['statusupdates']['id'];?>" value="<?php echo $date = date("Y-m-d");?>" />
                                     <input name="postcomment" type="text"  onfocus="if(this.value=='Write Comment') this.value='';" onblur="if(this.value=='') this.value='Write Comment';" value="Write Comment" id="comment_text_<?php echo $ustatus['statusupdates']['id'];?>" onkeydown="checkField('<?php echo $post_id;?>')" />
                                     <input name="send" type="submit" id="send<?php echo $post_id;?>" onclick="saveComment('<?php echo $ustatus['statusupdates']['id'];?>');" value="comment" style="display:none;" class="comment_bttn" />
                                    
                                </div>
                                <div class="clear"></div>
                            </div>
							<div class="clear"></div>
                             <div id="span_<?php echo $ustatus['statusupdates']['id'];?>">
                             <div id="comment_loader_<?php echo $ustatus['statusupdates']['id'];?>" style="display:none; text-align:center;">
					 		<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
                            </div>
                            <!--- Comment Box ---->
                             <?php 
								$countComments = sizeof($get_comments);
								$k = 1;
								?>
                           <?php 
								//$i = sizeof($user_comments);
								foreach ($get_comments as $comm) {
									$comments_id = $comm['comments']['id'];
									$created_date = $comm['comments']['created'];
									$year = date("Y", strtotime($created_date));
									$month = date("M", strtotime($created_date));
									$day = date("d", strtotime($created_date));
									$time = date("H:i:s", strtotime($created_date));
									if ($comm['comments']['content_id'] == $ustatus['statusupdates']['id']) {
										if ($k >3) {
											break;
										}
										if ($k <=2 ) {
								?>
                            <div class="comment-listing" id="commentsbox<?php echo $comments_id;?>">
                                <div class="comment-listing-pic">
                                     <?php 
									if ($comm['users_profiles']['photo']){
										if(file_exists(MEDIA_PATH.'/files/user/icon/'.$comm['users_profiles']['photo'])){
											$comm_photo=MEDIA_URL.'/files/user/icon/'.$comm['users_profiles']['photo'];
										}else{
											$comm_photo=MEDIA_URL.'/img/nophoto.jpg';
										}
									}
									else { 	
										$comm_photo=MEDIA_URL.'/img/nophoto.jpg'; 
									}
									echo $this->Html->image($comm_photo,array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$comm['users_profiles']['user_id'])));
																		
									?>  
                                </div>
                                <div class="comment-listing-rgt">
                                <ul>
                                    <li>
                                    
                                    
									<?php echo $this->Html->link($comm['users_profiles']['firstname']." ".$comm['users_profiles']['lastname'],
																														array('controller'=>'users_profiles',
																															  'action'=>'userprofile',
																															  $comm['users_profiles']['user_id']
																															  )); ?>
                                    <?php echo $comm['comments']['comment_text'];?> 
                                    <?php if ($comm['comments']['user_id'] == $uid || $user_idd == $uid) {?>
                                 <a href="javascript:" onclick="delete_comment('<?php echo $comments_id;?>','<?php echo $post_id;?>');" class="comment-close" title="Delete Update">
                                        </a>
                                    <?php }?>
                                    </li>
                                    <li>
                                        <a  class="replycomment"><?php echo $day." ".$month.", ".$year."  @ ".$time; ?></a>																	                                        <div class="clear"></div>	
                                    </li>
                                </ul>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <?php }
							$k++;
							 
						  }
						  }

						   ?>
                              <?php if ($k > 3) {?>
                                <div class="more">
                                	<a href="javascript:more_comments('<?php echo $post_id;?>','<?php echo $user_idd;?>')">more comments</a>
                                </div>
                             <?php } ?>
                            <!--- Comment Box end ---->
                            </div>
						</div>
						<!--- End of Main Comment Box for Post ----->	
                        
                    </div>
                </li>
            </ul>
        </div>
        <div class="clear"></div>
   </div>
    <!--- Pop up Big Image Starts Here --->
	<div class="modal fade middlepopup-bigimg" id="popup-bigimg<?php echo $post_id;?>" tabindex="-1" role="dialog" aria-labelledby="popup-bigimg" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <a class="popupclose" data-dismiss="modal" aria-hidden="true"></a>
            <h1 class="modal-title" id="myModalLabel"><?php echo $ustatus['users_profiles']['firstname']." ".$ustatus['users_profiles']['lastname'];?>'s Update</h1>
          </div>
          <div class="modal-body">
              <div class="popup-bigpic">
                   <?php echo $this->Html->image(MEDIA_URL.'/files/update/original/'.$ustatus['statusupdates']['photo'],
                                                                                                                    array('alt'=>'banner'));?>
              </div>
       	  </div>
        </div>
      </div>
    </div>
    <!--- Pop up Big Image Ends Here --->
    
    
   <!--- Like Box Starts Here --->
        <div id="wholikebox<?php echo $post_id;?>"  class="share_popup_ajax" style="width:500px;">
            <div class="close" onclick="disableLikesPopup('<?php echo $post_id;?>')"></div>
    <!--your content start-->
          <div class="heading"><h1>People Who Like This</h1></div>
            <div class="scroller">
            <?php foreach ($update_likes as $like_row) {
                    if ($like_row['likes']['content_id'] == $post_id) {
                        $fullname = $like_row['users_profiles']['firstname']." ".$like_row['users_profiles']['lastname'];
                ?>
                <div class="wholike">
                  <div class="wholike-pic">
                    <?php 
                       
                        if(!empty($like_row['users_profiles']['photo'])&& file_exists(MEDIA_PATH.'/files/user/icon/'.$like_row['users_profiles']['photo'])){ 
                            echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$like_row['users_profiles']['photo'],array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$like_row['users_profiles']['user_id'])));
                        }else{ 
                            echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$like_row['users_profiles']['user_id'])));
                        }
                        
                        
                    ?>
                  
                  </div>
                  <div class="wholike-rgt">
                      <ul>
                          <li>
                              <h1><?php echo $this->Html->link($fullname,array('controller'=>'users_profile','action'=>'userprofile',$like_row['users_profiles']['user_id']));?></h1>
                          </li>
                          <li><?php echo $like_row['users_profiles']['tags']?></li>
                      </ul>
                  </div>
                  
                <div class="clear"></div>
              </div>
         <?php }}?> 
      	</div>
        <!--your content end-->
    	</div>
	<!--- Like Box Ends Here --->
    
    <!-- --share form for updates post start-->

	<div id="share_popup_ajax<?php echo $ustatus['statusupdates']['id'];?>" class="share_popup_ajax" style="width:500px;">
    <div class="close" onclick="disablePopup('<?php echo $ustatus['statusupdates']['id'];?>')"></div>
    <div class="greybox-div-heading"><h1>Share</h1></div>
    <!--your content start-->
		<div class="userprofile-box">
			
			<?php 

			if ($ustatus['statusupdates']['photo']){
			?>
			<div class="userprofile-box-pic">
			<?php
				 echo $this->Html->image(MEDIA_URL.'/files/update/original/'.$ustatus['statusupdates']['photo'],array('alt'=>'banner'));
			?>
			</div>
			<?php } ?>
			<div class="userprofile-box-rgt">
				<ul>
					<li>
						<h1>
						<?php 
							echo $this->Html->link($ustatus['users_profiles']['firstname']." ".$ustatus['users_profiles']['lastname'],array('controller'=>'users_profile',
																																			'action'=>'userprofile',
																																			$ustatus['users_profiles']['user_id']
																																			));
							?>
                       </h1>
				    </li>
                    <li><span class="postedon">Posted on  : <?php echo $ustatus['statusupdates']['created']?></span></li>
					<li><?php echo $ustatus['statusupdates']['user_text'];?> </li>
			    </ul>
		    </div>
		<div class="clear"></div>
	  </div>
		<form action="/home/share/" method="post" class="userprofile-form">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><strong>Add to share</strong></td>
			    </tr>
				<tr>
					<td>
                    	<input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
     					<input type="hidden" name="content_type" id="content_type" value="updates" />
     					<input type="hidden" name="photo" id="photo" value="<?php echo $ustatus['statusupdates']['photo']?>" />
     					<input type="hidden" name="user_text" style="display:none;" id="user_text" value="<?php echo strip_tags($ustatus['statusupdates']['user_text']);?>" />
     					<input type="hidden" name="share_with" id="share_with" value="<?php echo $ustatus['statusupdates']['share_with']?>" />
      					<input type="hidden" name="user_share" id="user_share" value="<?php echo $ustatus['statusupdates']['id'];?>" />
                    	<textarea name="share_text" cols="58" rows="7" class="textfield" placeholder="Share updates" ></textarea>
                    </td>
			    </tr>
				<tr>
					<td></td>
			    </tr>
				<tr>
					<td><input type="submit" name="Submit" value="Share" class="red-bttn" /></td>
			    </tr>
		    </table>
	    </form>
	   <!--your content end-->
      
	</div>
    <?php }?>
	</div>
</div> 
<!-- Updates listing end-->
<div id="backgroundPopup"></div>
<style>
.over{background-color:#5E5E5E !important;border:1px solid #000000 !important;}
</style>
<script>
function loadPopup(ID) {
//if(popupStatus == 0) { // if value is 0, show popup
//closeloading(); // fadeout loading
$("#share_popup_ajax"+ID).fadeIn(0500); // fadein popup div
$("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
$("#backgroundPopup").fadeIn(0001);
//popupStatus = 1; // and set value to 1
//}
}
function disablePopup(ID) {
//if(popupStatus == 1) { // if value is 1, close popup
$("#share_popup_ajax"+ID).fadeOut("normal");
$("#backgroundPopup").fadeOut("normal");
//popupStatus = 0; // and set value to 0
//}
}


function loadLikesPopup(ID) {
//if(popupStatus == 0) { // if value is 0, show popup
//closeloading(); // fadeout loading
$("#wholikebox"+ID).fadeIn(0500); // fadein popup div
$("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
$("#backgroundPopup").fadeIn(0001);
//popupStatus = 1; // and set value to 1
//}
}
function disableLikesPopup(ID) {
//if(popupStatus == 1) { // if value is 1, close popup
$("#wholikebox"+ID).fadeOut("normal");
$("#backgroundPopup").fadeOut("normal");
//popupStatus = 0; // and set value to 0
//}
}
</script>