<?php echo $this->Html->css(MEDIA_URL.'/css/content-grab.css'); ?>

<div class="box">
  <div class="tab-container" id="tab-container" data-easytabs="true">
	<ul class="etabs">
		<li class="tab active"><a href="#" class="active">Your Groups</a></li>
		<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/">Following</a></li>	
        <li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/search">Search Group</a></li>	
		<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/add/">Add Group</a></li>
	</ul>
	<div class="panel-container">
		<div id="tabs1" style="display: block;" class="active"> 
        <div class="success_msg" id="message_update" style="display:none;">Your Update has been deleted successfully!</div> 
        <div class="success_msg" id="message_comment" style="display:none;">Your Comment has been deleted successfully!</div> 
			<?php echo $this->Session->flash();?>
			<?php 
			if ($groupDetail) {
					$groupID = $groupDetail['groups']['id'];
					$grouptitle = strtolower($groupDetail['groups']['title']);
					$grouptitle = str_replace(' ', '-', $grouptitle);
					$groupAdmin= $groupDetail['groups']['user_id'];
			?>
			<!--- group header start -->
			<div>
				<div class="com-rgt">
					<div class="companypage-logo">
					<?php
						if(!empty($groupDetail['groups']['logo'])){
							$file = MEDIA_URL.'/files/group/logo/'.$groupDetail['groups']['logo'];
							$file_headers = @get_headers($file);
							if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
								echo $this->Html->image(MEDIA_URL.'/img/no_group_photo.jpg',array());
							}else {
								echo $this->Html->image($file,array());
							}
						}else{
							echo $this->Html->image(MEDIA_URL.'/img/no_group_photo.jpg',array());
						}
					?>		
					</div> 
					<div class="button-in-middle">					
						<?php if ($groupDetail['groups']['user_id'] != $uid) {?>
							<span id="group_follow_by_user">            
								<?php 
									if ($users_following_thisGroup !=0){
										if ($status == 2) {?>
											<a href="javascript:unfollow('<?php echo $user_group_id ?>','<?php echo $uid?>','0','<?php echo $groupID?>')" class="button" >Leave</a> 
										<?php } else if ($status == 1) { ?>
										
								<a style="width:97px;" class="waiting_approval" >Pending Request</a>
										<?php } else {?>
										<a href="javascript:unfollow('<?php echo $user_group_id ?>','<?php echo $uid?>','2','<?php echo $groupID?>')" class="button" >Member</a>
										<?php }
									} else {?>
										<a href="javascript:unfollow('<?php echo $user_group_id ?>','<?php echo $uid?>','2','<?php echo $groupID?>')" class="button">Member</a>
									<?php }?>
								</span>
						<?php } ?>						   						
						
						<div class="clear"></div>
					</div>
					<div class="totalfollowers">
							<span id="total_following"><?php  echo $count_following_thisGroup;?> </span> members </span>							
					</div>
					<div class="clear"></div>
				</div>
		 
				<div class="com-lft">
					<div class="com-left-details">
						<ul>
							<li>
								<h1><?php echo $groupDetail['groups']['title'];?></h1>
							</li>
							<li><?php echo $groupDetail['countries']['name'];?></li>
							<li>									
								<a target="_blank" href="<?php echo $groupDetail['groups']['weburl'];?>"><?php echo $groupDetail['groups']['weburl'];?></a>
							</li>
							<li>
								<strong>Type:</strong> <?php echo $groupDetail['groups_types']['title'];?>
							</li>
							<li>
								<strong>Created:</strong> <?php echo date("M d, Y", strtotime($groupDetail['groups']['created']));?> | <strong>Group Mode:</strong> <?php echo $groupDetail['groups']['group_mode'];?> | <strong>Joining Mode:</strong> <?php echo $groupDetail['groups']['joining_mode'];?>
							</li>
						</ul> 
					</div>
					<div class="companypage-nav">
						
                        <?php echo $this->Html->link('Home',array('controller'=>'groups','action'=>'view',$groupID,$grouptitle),array('class'=>'selected'));?>
						<?php echo '<a  href="'.NETWORKWE_URL.'/groups/jobs/'.$groupID.'/'.$grouptitle.'">Jobs</a>';?>
						<?php echo $this->Html->link('Members',array('controller'=>'groups','action'=>'members',$groupID,$grouptitle));?>
						<?php if ($groupDetail['groups']['user_id'] == $uid){?>
						<?php echo '<a href="'.NETWORKWE_URL.'/groups/add/'.$groupID.'/'.$grouptitle.'">Edit Group</a>';?>
                        <?php echo '<a href="'.NETWORKWE_URL.'/groups/delete/'.$groupID.'/'.$grouptitle.'">Delete Group</a>';?>
                        
						<?php }?>		
						<div class="clear"></div>    
					</div>   
					<div class="clear"></div>
				</div>
			<div class="clear"></div>
		</div>
		<!--- group header end -->
		
        
        <div  id="group_follow_update">
		<?php if ($user_group_id) {
				
				if ($check_user_ToGroup != 0) {?>  
					<!--- company shareupdate start -->	
					<div class="companypage-mainbox">
						<div class="company-shareupdate">
							<div id="output" style="display:none; text-align:center;">
								<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif',array());?>
							</div>
							<?php echo $this->Form->create('Entity_update', array('url'=>'/groups/view/','enctype'=>'multipart/form-data','id'=>'updateUploader'));?>
							
							<div class="attach-file-tweet">
								<?php echo $this->Html->image(MEDIA_URL.'/img/attachefile.png',array('alt'=>'uploading','class'=>'uploadimg'));?>
								<?php echo $this->Form->file('image',array('required'=>false,'class'=>'attachedfile-style','id'=>'myfile'));?>
							</div>							
							<label>
								<?php echo $this->Form->input('user_id' , array('type' => 'hidden', 'value' => $uid)); ?>
								<?php echo $this->Form->input('entity_id' , array('type' => 'hidden', 'value' => $groupID)); ?>
								<?php echo $this->Form->input('group_title' , array('type' => 'hidden', 'value' => $grouptitle)); ?>
								<?php echo $this->Form->textarea('update_text',array('required'=>false,'placeholder'=>'Share updates ...','id'=>'get_url','class'=>'shareupdate-field','style'=>'width:635px; height:32px;')); ?>
						
							</label>
							<div class="div-for-share" id="div-for-share" style="display:none;">
								<a href="javascript:void(0)" onclick="clearUpdate();" class="comment-close"></a>
								<div id="results"></div>
								<img class='preview_img' src="" alt="No Image Found" width="150" height="100" style="display:none;" id="preimg"/>
								<div class='result_txt' style="display:none;"></div>
								<div class="clear"></div>
								<?php echo $this->Form->textarea('link_content',array('required'=>false,'id'=>'link_content','style'=>'display:none;')); ?>
							</div>
							<div id="share-bttns" style="display:none;">
								<?php echo $this->Form->submit('Share',array('div'=>false,'id'=>'uploadButton','class'=>'sharepostbttn_fix')); ?>
								<select name="data[Entity_update][share_with]" class="default" tabindex="1" id="Entity_updateShareWith" style="width:475px;">
                            		<option value="groups" class="" selected>Group</option>
								</select>

							</div>
							<?php echo $this->Form->end();?>
							
						</div>
						<div class="clear"></div>
					</div>          
				<!--- company shareupdate end -->	
		<?php }?>
	<?php } ?>
    	</div>
    
    
		<?php if ($groupDetail['groups']['image']) {
			
			?>
        <div class="coverphoto-holder">
                <div class="com-coverphoto">
                     <?php echo $this->Html->image(MEDIA_URL.'/files/group/cover/'.$groupDetail['groups']['image'],array('style'=>'width:653px; height:237px;'));?>
                </div>
        </div>
        <?php }?>
         <div class="companypage-mainbox">
               	 <?php echo $groupDetail['groups']['summary']; ?>                 
         </div>
        
        
			<div style="padding:10px;">
                <div class="marginbottom10">
                    <h1><?php echo "Recent Updates ";?></h1>
                </div>
			</div>
			
			<?php foreach ($group_updates as $group_update_Row) {
				
				$full_name = $group_update_Row['users_profiles']['firstname']." ".$group_update_Row['users_profiles']['lastname'];
				$user_handler = $group_update_Row['users_profiles']['handler'];
				$current_status = $group_update_Row['users_profiles']['tags'];
				$diss_id = $group_update_Row['Entity_update']['id'];
				$url_title = str_replace(" ", "-", strtolower($group_update_Row['Entity_update']['group_title']));
				$title = $group_update_Row['Entity_update']['group_title'];
				$update_date = $group_update_Row['Entity_update']['created'];
				$update_year = date("Y", strtotime($update_date));
                $update_month = date("M", strtotime($update_date));
                $update_day = date("d", strtotime($update_date));
				?>
			
            <div class="post-wall" id="<?php echo $diss_id;?>">
            	<?php if ($group_update_Row['Entity_update']['user_id'] == $uid || $groupAdmin == $uid) {?>
    					<a href="javascript:void(o)" onclick="delete_update('<?php echo $diss_id;?>');" class="comment-close" title="Delete Update"></a>
        		<?php }?>
						<div class="userpic-post">
                        	<a href="#">
                            	<?php 
									if (!empty($group_update_Row['users_profiles']['photo'])) {
										if (file_exists(MEDIA_PATH.'/files/user/thumbnail/'.$group_update_Row['users_profiles']['photo'])) {
										  echo $this->Html->image(MEDIA_URL.'/files/user/thumbnail/'.$group_update_Row['users_profiles']['photo'],
																																		 array('url'=>array('controller'=>'pub',
																																						'action'=>$user_handler),
																																				'alt'=>'no-img'));
										}
										else {
										  echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',
																								array('url'=>array('controller'=>'pub',
																													'action'=>$user_handler),
																									  'alt'=>'no-img'));
										}
									}
									else{
										echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',
																							array('url'=>array('controller'=>'pub',
																											   'action'=>$user_handler),
																									  'alt'=>'no-img'));
									}
								?>
                            </a>
                        </div>
						<div class="post-wall-rgt">
							<ul>
								<li>
                                	<a href="/users_profiles/pub/<?php echo $user_handler;?>" class="postwall-name"><?php echo $full_name;?></a>	
                                </li>
								<li>
								<div class="post-wall-subcontent">
                                	<div class="post-wall-subcontent-rgt2">	
                                    	<ul>
                                        	<li>							
										<?php if (!empty($group_update_Row['Entity_update']['image'])) {
                                                    if ($group_update_Row['Entity_update']['entity_type'] == "groups") {
														echo '<div class="subcontent2-pic">';
                                                    echo $this->Html->image(MEDIA_URL.'/files/update/original/'.$group_update_Row['Entity_update']['image'],array('alt'=>'no-img'));
													echo '</div>';
                                                    }
                                                    else if($group_update_Row['Entity_update']['entity_type'] == "news"){
														echo '<div class="subcontent2-pic">';
                                                       echo $this->Html->image(MEDIA_URL.'/files/news/original'.$group_update_Row['Entity_update']['image'],array('alt'=>'no-img'));
													   echo '</div>';
                                                    }
                                                    echo $group_update_Row['Entity_update']['update_text'];
                                                    echo $this->Html>link('More..',array('controller'=>'groups','action'=>'view_',$diss_id,$title));
                                            }
                                            else {
                                                if ($group_update_Row['Entity_update']['update_text']) {
                                                    echo $group_update_Row['Entity_update']['update_text'];
                                                }
                                                //echo $this->Html->link('More..',array('controller'=>'groups','action'=>'view_',$diss_id,$title),array('escape'=>false));
                                            }?>
                                       </li>
                                     </ul>
                                    </div>
								<div class="clear"></div>
								</div>

                                <!-- Button comments, like start -->
                                <div>
								    <div class="post-bttns">
                                    	<ul>
                                        	<input type="hidden" name="like_type" id="like_type" value="groups" />
                                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
											<input type="hidden" name="like_date" id="like_date_<?php echo $diss_id;?>" value="<?php echo $date = date("Y-m-d H:i:s");?>" />
                                        	<!-- LIKE START -->
											<li id="user_like_update_<?php echo $diss_id;?>">
											<?php 
												$flage = false;
												$total_likes_this = '';
												$total_likes_unmatched = '';
												foreach ($likes_on_Update as $like_update_row)  {
													$user_id = $like_update_row['likes']['user_id'];
													$content_id = $like_update_row['likes']['content_id'];
													$like = $like_update_row['likes']['like'];
													if ($diss_id == $content_id && $user_id == $uid && $like == 1) {
														$flage = true;
													}
													if ($diss_id == $content_id) {
														$total_likes_unmatched += $like_update_row['likes']['like'];
					
													}
												}
							 					if ($flage == true) { ?>
							 						<a id="alike<?php echo $diss_id;?>" href="Javascript:showLikes('<?php echo $diss_id;?>','0');">Liked 
													  <?php  if ($total_likes_unmatched) { echo "<span class='redcolor'>(".$total_likes_unmatched.")</span>"; }?>
                                                    </a>
											 <?php }?>
											<?php if ($flage == false) { ?>
													 <span style="display:block;">
                                                     	<a id="alike<?php echo $diss_id;?>" href="Javascript:showLikes('<?php echo $diss_id;?>','1');">Like
													 		<?php echo "&nbsp;<span class='redcolor'>(".$total_likes_unmatched.")</span>";?>
                                                        </a>
                                                     </span>
										    <?php } ?>

                                            </li>
                                            <!-- LIKE end -->
                                            
											<li><a href="#" onClick="showhide('commentsDiv<?php echo $diss_id;?>', 'block'); return false" >Comments
                                            		<?php $chk_comments =0;
													foreach ($updates_comments_count as $comments_total_row) {
														if ($comments_total_row['entity_comments']['content_id'] == $diss_id) {
															echo "<a class='totalnumber'>(".'<span id="total_following_'.$diss_id.'">'.$comments_total_row[0]['commenttotal'].'</span>'.")</a>";
															$chk_comments =1;
														}
													}
													if ($chk_comments == 0) {
														echo "<a class='totalnumber'>(".'<span id="total_following_'.$diss_id.'">0</span>'.")</a>";
													}
													?>
                                            	</a>
                                            </li>
                                            <li>
                                            <?php $share_count = 0;
											 	foreach ($shareOnUpdates as $share_row) {
												 	if ($share_row['Entity_update']['share'] == $diss_id) {
														$share_count++;
													}
												}
										    ?>
                                          		<a href="#?w=500" rel="share_popup<?php echo $diss_id;?>" class="poplight sharecontent">Share</a>
                                                <a href="#?w=500" rel="whosharebox<?php echo $diss_id;?>" class="poplight sharecontent">
                                            	  <span class="redcolor">(<?php echo $share_count;?>)</span>
                                                </a>
                                          </li>
                                          <li><span class="posttime"><?php echo $update_day." ".$update_month.", ".$update_year; ?></span></li>
                                        </ul>
									 <div class="clear"></div>
                                    </div>
                                   <div class="clear"></div>
                       		 <div id="ajax_res<?php echo $diss_id;?>">
								<?php if ($total_likes_unmatched != 0) {?>
                                <div class="wholike-div">
                                    <div class="icon-like"></div>
                                        <ul>
                                        <?php  $i = 1; $str = ''; $flag_set = false; $you = ''; $andcont = ''; $toltip = '';
                                        foreach ($likesOnUpdates as $like_row) {
                                            if ($like_row['likes']['content_id'] == $diss_id && $i<=6) {
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
                                                     $you = '<li><div class="youtext"><a class="you-text" href="#user'.$user_id.'" onmouseover="tooltip.pop(this, '.$toll_tipID.')">You</a></div></li>';
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
                                            <li><a href="javascript:loadLikesPopup('<?php echo $diss_id;?>')" class="poplight totalnumber">
                                            <strong><?php echo "+".$total_likes_unmatched;?></strong></a></li>
                                            <?php } $i = 1; $andcont = ''; ?>
                                        </ul>
        
                                        <div class="clear"></div>
                                    </div>
                                 <?php }?>
                               </div>
                           			
                            		 <div class="clear"></div>
									<!--- Main Comment Box for Post ----->
									<div id="commentsDiv<?php echo $diss_id;?>" style="display:none" class="commentsbox">
                                    
										<!--- Comment Box ---->
                                        <div id="group_loader<?php echo $diss_id?>" style="display:none; text-align:center;">
												<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
										</div>
                                        <span id="group_comments_<?php echo $diss_id;?>">
											<?php foreach ($user_comments as $comment__row) {
                                                    $full_name = $comment__row['users_profiles']['firstname']." ".$comment__row['users_profiles']['lastname'];
                                                    $created_date = $comment__row['entity_comments']['created'];
                                                    $year = date("Y", strtotime($created_date));
                                                    $month = date("M", strtotime($created_date));
                                                    $day = date("d", strtotime($created_date));
                                                    $commentid = $comment__row['entity_comments']['id'];
                                                    $time = date("H:i:s", strtotime($created_date));
                                                    $handler = $comment__row['users_profiles']['handler'];
                                                    $user_photo = $comment__row['users_profiles']['photo'];
													$content_id = $comment__row['entity_comments']['content_id'];
                                                    if ($content_id == $diss_id) {?>
                                            <div class="comment-listing" id="commentsbox<?php echo $commentid;?>">
                                                <div class="comment-listing-pic">
                                                    <a href="/pub/<?php echo $handler; ?>">
                                                    <?php 
                                                        if ($user_photo) {
															if (file_exists(MEDIA_PATH.'/files/user/icon/'.$user_photo)) {
                                                            	echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$user_photo,array('alt'=>'no photo'));
															}
															else {
																 echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'no photo'));
															}
                                                        }
                                                        else {
                                                            echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'no photo'));
                                                        }
                                                    ?>
                                                    </a> 
                                                </div>
                                                <div class="comment-listing-rgt">
                                                <ul>
                                                    <li>
                                                    <a href="/pub/<?php echo $handler; ?>"><?php echo $full_name;?></a> <?php echo $comment__row['entity_comments']['comments'];?>
                                                    <?php if ($comment__row['entity_comments']['user_id'] == $uid || $groupAdmin == $uid) {?>
    													<a href="javascript:" onclick="delete_comment('<?php echo $commentid;?>','<?php echo $diss_id;?>');" class="comment-close" title="Delete Update">
                                                    	</a>
        											<?php }?>
                                                    
                                                    </li>
                                                    <li><span class="posttime"><?php echo $day." ".$month.", ".$year."  @ ".$time; ?></span></li>
                                                </ul>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                            
                                            <?php }}?>
                                            <!--- End Comments Box --->
                                    </span>
                                    	<div class="clear"></div>
										<div class="writecomment">
											<div class="comment-listing-pic">
												<a href="/pub/<?php echo $user_handler; ?>">
                                                	<?php 
														if ($imgname) {
															if (file_exists(MEDIA_PATH.'/files/user/icon/'.$imgname)) {
																echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$imgname,array('alt'=>'no photo'));
															}
															else {
																echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'no photo'));	
															}
														}
														else {
															echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'no photo'));
														}
													?>
                                                 </a>
                                            </div>
											<div class="writecomment-rgt">
                                                <?php echo $this->Form->input('user_id' , array('type' => 'hidden', 'id'=>'user_id', 'value' => $uid)); ?>
                                                <?php echo $this->Form->input('company_admin_id' , array('type' => 'hidden', 'id'=>'admin_id', 'value' => $groupAdmin)); ?>
            									<?php echo $this->Form->input('content_id' , array('type' => 'hidden', 'id'=>'content_id_'.$diss_id, 'value' => $diss_id)); ?>
											<?php echo $this->Form->input('comments',array('required'=>false,'div'=>false, 'label'=>false,'id'=>'comments_'.$diss_id,'placeholder'=>"add comments..",'onkeydown'=>'checkField('.$diss_id.');')); ?>
                                                <input name="send" type="button" id="send<?php echo $diss_id;?>" value="send" class="comment_bttn" style="display:none;" onclick="add_group_comment('<?php echo $diss_id;?>');" />
											</div>
											<div class="clear"></div>
										</div>

									</div>
									<!--- End of Main Comment Box for Post ----->	
								</div>
                               <!-- Button comments, like End -->
                                
							   </li>
							</ul>
						</div>
						<div class="clear"></div>
					</div>
       <!---who share update Box Starts Here --->
      <div id="whosharebox<?php echo $diss_id;?>" class="popup_block">
        <!--your content start-->
              <div class="heading"><h1>People Who Share This Update</h1></div>
                <div class="scroller">
                <?php foreach ($shareOnUpdates as $sharerow) {
                        if ($sharerow['Entity_update']['share'] == $diss_id) {
                            $fullname = $sharerow['users_profiles']['firstname']." ".$sharerow['users_profiles']['lastname'];
                    ?>
                    <div class="wholike">
                      <div class="wholike-pic">
                        <?php 
                           
                            if(!empty($sharerow['users_profiles']['photo'])&& file_exists(MEDIA_PATH.'/files/user/icon/'.$sharerow['users_profiles']['photo'])){ 
                                echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$sharerow['users_profiles']['photo'],array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$sharerow['users_profiles']['user_id'])));
                            }else{ 
                                echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$sharerow['users_profiles']['user_id'])));
                            }   
                        ?>
                      
                      </div>
                      <div class="wholike-rgt">
                          <ul>
                              <li>
                                  <h1>
                                <?php echo $this->Html->link($fullname,array('controller'=>'users_profile','action'=>'userprofile',$sharerow['users_profiles']['user_id']));?>
                                  </h1>
                              </li>
                              <li><?php echo $sharerow['users_profiles']['tags']?></li>
                          </ul>
                      </div>
                      
                    <div class="clear"></div>
                  </div>
             <?php }}?> 
          </div>
            <!--your content end-->
        </div>
            <!---who share update Box Starts Here --->              
     <div id="share_popup<?php echo $diss_id;?>" class="popup_block">
    	<div class="greybox-div-heading"><h1>Share</h1></div>
    <!--your content start-->
		
		<div class="userprofile-box">
			<?php if ($group_update_Row['users_profiles']['photo']){ ?>
			<div class="userprofile-box-pic">
            	<?php 
				if ($group_update_Row['users_profiles']['photo']){
					if (file_exists(MEDIA_PATH.'/files/user/icon/'.$group_update_Row['users_profiles']['photo'])) {
                	 echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$group_update_Row['users_profiles']['photo'],array('url'=>array('controller'=>'pub',
																																			'action'=>$user_handler)
                                                                                                                    ,'alt'=>'banner'));
					}
					else {
					echo $this->Html->image(MEDIA_URL.'/imag/nophoto.jpg',
                                                                          array('alt'=>'banner'));
					}
				}
				else {
					 echo $this->Html->image(MEDIA_URL.'/imag/nophoto.jpg',
                                                                          array('alt'=>'banner'));
				}
                  ?>  
            </div>
			<div class="userprofile-box-rgt">
				<ul>
					<li>
						<h1>
						<?php 
							echo $this->Html->link($group_update_Row['users_profiles']['firstname']." ".$group_update_Row['users_profiles']['lastname'],
																																				array('controller'=>'pub',
																																			'action'=>$user_handler));
																																			
							?>
                       </h1>
				    </li>
                    <li><span class="postedon">Posted on  : <?php echo $group_update_Row['Entity_update']['created']?></span></li>
					<li><?php echo strip_tags($group_update_Row['Entity_update']['update_text']); ?> </li>
			    </ul>
		    </div>
		<div class="clear"></div>
		<?php } else{
			
			echo $group_update_Row['Entity_update']['update_text'];
		}?>
		<div class="clear"></div>
	  </div>
		<form action="/groups/share/" method="post" class="userprofile-form">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><strong>Add to share</strong></td>
			    </tr>
				<tr>
					<td>
                    	 <input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
       					  <input type="hidden" name="content_type" id="content_type" value="groups" />
                         <input type="hidden" name="photo" id="photo" value="<?php echo $group_update_Row['Entity_update']['image']?>" />
                          <input type="hidden" name="user_share" id="user_share" value="<?php echo $diss_id;?>" />
                          <input type="hidden" name="entity_id" id="entity_id" value="<?php echo $groupID;?>" />
						<textarea name="update_text" style="display:none;" id="update_text"><?php echo $group_update_Row['Entity_update']['update_text']; ?></textarea>
     					<input type="hidden" name="share_with" id="share_with" value="groups" />
                        <input type="hidden" name="comment_date" id="comment_date" value="<?php echo $date = date('Y-m-d H:i:s');?>" />
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
            
      <!--- Like Box Starts Here --->
		<div id="wholikebox<?php echo $diss_id;?>"  class="share_popup_ajax" style="width:500px;">
            <div class="close" onclick="disableLikesPopup('<?php echo $diss_id;?>')"></div>
            <!--your content start-->
          <div class="heading"><h1>People Who Like This</h1></div>
            <div class="scroller">
            <?php foreach ($likesOnUpdates as $like_row) {
                    if ($like_row['likes']['content_id'] == $diss_id) {
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
	<?php }}?>
    <div class="clear"></div>      
	</div>
   </div>
  </div>
 </div>
 <div id="backgroundPopup"></div>
 <script>
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
<style>
.over{background-color:#5E5E5E !important;border:1px solid #000000 !important;}
</style>