<?php echo $this->Html->css(MEDIA_URL.'/css/content-grab.css'); ?>
<div class="tab-container" id="tab-container" data-easytabs="true">
	<ul class="etabs">
		<li class="tab active"><a href="#" class="active">Company Page</a></li>
		<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/">Following</a></li>
		<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/search/">Search Company</a></li>
		<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/home/">Companies Updates</a></li>
		<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/validity/">Add Company</a></li>
	</ul>
	<div class="panel-container">
		<div id="tabs1" style="display: block;" class="active"> 
        <div class="success_msg" id="message_update" style="display:none;">Your Update has been deleted successfully!</div>
        <div class="success_msg" id="message_comment" style="display:none;">Your Comment has been deleted successfully!</div>  
        <?php echo $this->Session->flash();?>
			<?php 
			//echo "<pre>";
			//print_r($companyDetail);
				if ($companyDetail) {
					$companyID = $companyDetail['companies']['id'];
					$companytitle = strtolower($companyDetail['companies']['title']);
					$companytitle = str_replace(' ', '-', $companytitle);
					$company_user = $companyDetail['companies']['user_id'];
			?>
			<!--- company header start -->
			<div>
				<div class="com-rgt">
					<div class="companypage-logo">
					<?php
						if(!empty($companyDetail['companies']['logo'])){
							$file = MEDIA_URL.'/files/company/logo/'.$companyDetail['companies']['logo'];
							$file_headers = @get_headers($file);
							if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
								echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array());
							}else {
								echo $this->Html->image($file,array());
							}
						}else{
							echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array());
						}
					?>		
					</div> 
					<div class="button-in-middle">
					
						<span id="company_follow_by_user">
							<?php if($company_user != $uid){
								  if ($users_following_thisCompany !=0){
									if ($status == 2) {?>
									<a class="button" href="javascript:unfollow('<?php echo $user_company_id ?>','<?php echo $uid?>','0','<?php echo $companyID?>')">Following</a> 
									<?php } else {?>
									<a class="button" href="javascript:unfollow('<?php echo $user_company_id ?>','<?php echo $uid?>','2','<?php echo $companyID?>')">Follow</a>
									<?php }} else {?>
									<a class="button" href="javascript:unfollow('<?php echo $user_company_id ?>','<?php echo $uid?>','2','<?php echo $companyID?>')">Follow</a>
							<?php 	}
							     }
							?>
						</span>
						<div class="clear"></div>
					</div>
					<div class="totalfollowers">
							<span id="total_following"><?php  echo $count_following_thisCompany;?> </span> followers </span>						
							
					</div>
					<div class="clear"></div>
				</div>
			 
				<div class="com-lft">
					<div class="com-left-details">
						<ul>
							<li>
								<h1><?php echo $companyDetail['companies']['title'];?></h1>
							</li>
							<li><?php echo $companyDetail['companies']['city']; if ($companyDetail['countries']['name'] && $companyDetail['companies']['city']) { echo ", ";} 
								echo $companyDetail['countries']['name']; ?>
                           </li>
							<li>									
								<a target="_blank" href="<?php echo $companyDetail['companies']['weburl'];?>"><?php echo $companyDetail['companies']['weburl'];?></a>
							</li>
							<li>
								<strong>Industry:</strong> <?php echo $companyDetail['industries']['title'];?>
							</li>
							<li>
								<strong>Founded:</strong> <?php echo $companyDetail['companies']['established'];?> | <strong>Company size:</strong> <?php echo $companyDetail['companies']['company_size'];?> | <strong>Type:</strong> <?php echo $companyDetail['companies_types']['title'];?>
							</li>
							<li>
								<strong>Public URL:</strong> <?php echo $this->Html->link(NETWORKWE_URL.'/company/page/'.$companyID,NETWORKWE_URL.'/company/page/'.$companyID,array('escape'=>false)); ?>
							</li>
                            <li><strong>Company Page Admin:</strong>
								<?php echo '<a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$company_user.'">'.$admin_info['users_profiles']['firstname']." ".$admin_info['users_profiles']['lastname'].'</a>';?>
                                </li>
						</ul> 
					</div>
					<div class="companypage-nav">
						<?php echo '<a class="selected" href="'.NETWORKWE_URL.'/companies/view/'.$companyID.'/'.$companytitle.'">Home</a>';?>
						<?php echo '<a  href="'.NETWORKWE_URL.'/companies/jobs/'.$companyID.'/'.$companytitle.'">Jobs</a>';?>
                        <?php echo '<a  href="'.NETWORKWE_URL.'/companies/followers/'.$companyID.'/'.$companytitle.'">Followers</a>';?>
                        <?php if ($company_user == $uid) {?>
						<?php echo '<a href="'.NETWORKWE_URL.'/companies/add/'.$companyID.'/'.$companytitle.'">Edit Page</a>';?>
                        <?php echo '<a href="'.NETWORKWE_URL.'/companies/delete/'.$companyID.'/'.$companytitle.'">Delete Page</a>';?>
                        <?php }?>
						
						<div class="clear"></div>    
					</div>   
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			<!--- company header end -->
			
			<?php if ($company_user == $uid) {?>
			
			<!--- company shareupdate start -->	
			<div class="companypage-mainbox" id="company_upt_form">
				<div class="company-shareupdate">
					<div id="output" style="display:none; text-align:center;">
						<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif',array());?>
					</div>
					<?php echo $this->Form->create('Entity_update', array('url'=>'/companies/home/','enctype'=>'multipart/form-data','id'=>'updateUploader'));?>
					
					
						<div class="attach-file-tweet">
							<?php echo $this->Html->image(MEDIA_URL.'/img/attachefile.png',array('alt'=>'uploading','class'=>'uploadimg'));?>
							<?php echo $this->Form->file('image',array('required'=>false,'class'=>'attachedfile-style','id'=>'myfile'));?>
						</div>
					<label>
							<?php echo $this->Form->input('user_id' , array('type' => 'hidden', 'value' => $uid)); ?>
							<?php echo $this->Form->input('entity_id' , array('type' => 'hidden', 'value' => $companyID)); ?>
					<?php echo $this->Form->textarea('update_text',array('required'=>false,'placeholder'=>'Share updates ...','id'=>'get_url','class'=>'shareupdate-field')); ?>
				
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
                            <option value="followers" class="" selected>Followers</option>
						</select>
						
					</div>
					<?php echo $this->Form->end();?>
					
					
		  
				</div>
				<div class="clear"></div>
			</div>          
		<!--- company shareupdate end -->	
		<?php } ?>
		<?php if ($companyDetail['companies']['image']) {
			
			?>
        <div class="coverphoto-holder">
                <div class="com-coverphoto">
                     <?php echo $this->Html->image(MEDIA_URL.'/files/company/cover/'.$companyDetail['companies']['image'],array('style'=>'width:653px; height:237px;'));?>
                </div>
        </div>
        <?php }?> 
<?php }?>
			<div style="padding:10px;">
			<div class="marginbottom10">
				<h1><?php echo "Recent Updates ";?></h1>
			</div>

			<?php 
				if ($company_Updates) { 
				foreach ($company_Updates as $company_update_row) { 
				$companyID = $company_update_row['companies']['id'];
				$entityID = $company_update_row['Entity_update']['id'];
				$user_liked_ID = $company_update_row['likes']['user_id'];
				$liked_ID = $company_update_row['likes']['id'];
				$companytitle = strtolower($company_update_row['companies']['title']);
				$companytitle = str_replace(' ', '-', $companytitle);
				$update_title = strtolower($company_update_row['Entity_update']['group_title']);
				$update_title = str_replace(' ', '-', $update_title);
				$month = date('F',strtotime($company_update_row['Entity_update']['created']));
				$day = date('d',strtotime($company_update_row['Entity_update']['created']));
				$year = date('Y',strtotime($company_update_row['Entity_update']['created']));
				?>
                <div class="post-wall" id="<?php echo $entityID;?>">
            	<?php if ($company_update_row['Entity_update']['user_id'] == $uid || $company_user == $uid) {?>
    					<a href="javascript:void(o)" onclick="delete_update('<?php echo $entityID;?>');" class="comment-close" title="Delete Update"></a>
        		<?php }?>
						<div class="userpic-post">
                        	<a href="/companies/view/<?php echo $companyID;?>/<?php echo $companytitle;?>">
                            	<?php 
									if (!empty($company_update_row['companies']['logo'])) {
										if (file_exists(MEDIA_PATH.'/files/company/logo/'.$company_update_row['companies']['logo'])) {
											echo $this->Html->image(MEDIA_URL.'/files/company/logo/'.$company_update_row['companies']['logo'],array('alt'=>'no-img'));
										}
										else {
											echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array('alt'=>'no-img'));
										}
									}
									else{
										echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array('alt'=>'no-img'));
									}
								?>
                            </a>
                        </div>
						<div class="post-wall-rgt">
							<ul>
								<li>
                                	<a href="/companies/view/<?php echo $companyID;?>/<?php echo $companytitle;?>" class="postwall-name">
										<?php echo $company_update_row['companies']['title'];?>
                                    </a>	
                                </li>
								<li>
								<div class="post-wall-subcontent">
                                	<div class="post-wall-subcontent-rgt2">
                                    	<ul>
                                        	<li>								
										<?php if ($company_update_row['Entity_update']['image']) {
                                                        //echo $company_update_row['Entity_update']['image'];
                                                    if ($company_update_row['Entity_update']['entity_type'] == "company") {
														echo '<div class="subcontent2-pic">';
                                                        echo $this->Html->image(MEDIA_URL.'/files/update/original/'.$company_update_row['Entity_update']['image'],
                                                                                                                                                         array('alt'=>'no-img'));
														echo '</div>';
                                                    }
                                                    else if($company_update_row['Entity_update']['entity_type'] == "news"){
														echo '<div class="subcontent2-pic">';
                                                        echo $this->Html->image(MEDIA_URL.'/files/news/original/'.$company_update_row['Entity_update']['image'],array('alt'=>'no-img'));													echo '</div>';
                                                    }
                                                    echo $company_update_row['Entity_update']['update_text'];
                                                    //echo $this->Html>link('More..',array('controller'=>'groups','action'=>'view_',$diss_id,$title));
                                            }
                                            else {
                                                if ($company_update_row['Entity_update']['update_text']) {
                                                    echo $company_update_row['Entity_update']['update_text'];
                                                }
                                                //echo $this->Html>link('More..',array('controller'=>'groups','action'=>'view_',$diss_id,$title));
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
											<input type="hidden" name="like_date" id="like_date_<?php echo $entityID;?>" value="<?php echo $date = date("Y-m-d H:i:s");?>" />
                                        	<!-- LIKE START -->
											<li id="user_like_update_<?php echo $entityID;?>">
											<?php 
												$flage = false;
												$total_likes_this = '';
												$total_likes_unmatched = '';
												foreach ($likes_on_Update as $like_update_row)  {
													$user_id = $like_update_row['likes']['user_id'];
													$content_id = $like_update_row['likes']['content_id'];
													$like = $like_update_row['likes']['like'];
													if ($entityID == $content_id && $user_id == $uid && $like == 1) {
														$flage = true;
													}
													if ($entityID == $content_id) {
														$total_likes_unmatched += $like_update_row['likes']['like'];
					
													}
												}
							 					if ($flage == true) { ?>
							 						<a id="alike<?php echo $entityID;?>" href="Javascript:showLikes('<?php echo $entityID;?>','0');">Liked 
													  <?php  if ($total_likes_unmatched) { echo "<span class='redcolor'>(".$total_likes_unmatched.")</span>"; }?>
                                                    </a>
											 <?php }?>
											<?php if ($flage == false) {  ?>
													 <span style="display:block;">
                                                     <a id="alike<?php echo $entityID;?>" href="Javascript:showLikes('<?php echo $entityID;?>','1');">Like&nbsp;
													 	<?php echo "<span class='redcolor'>(".$total_likes_unmatched.")</span>";?>
                                                     </a>
                                                     </span>
													<span style="display:none;" id="likediv<?php echo $company_update_row['likes']['content_id'];?>"><a>Liked</a>
													<?php 
													if ($total_likes_unmatched) { echo "<a class='totalnumber'>(".$total_likes_unmatched.")</a>"; }?></span>
                                                         
										<?php } ?>

                                            </li>
                                            <!-- LIKE end -->
                                            
											<li>
                                            	<a href="#" onClick="showhide('commentsDiv<?php echo $entityID;?>', 'block'); return false" >Comments
													<?php $chk_comments = 0;
													foreach ($updates_comments_count as $comments_total_row) {
														if ($comments_total_row['entity_comments']['content_id'] == $entityID) {
															echo "<a class='totalnumber'>(".'<span id="total_following_'.$entityID.'">'.$comments_total_row[0]['commenttotal'].'</span>'.")</a>";
															$chk_comments = 1;
														}
													}
													if ($chk_comments == 0) {
														echo "<a class='totalnumber'>(".'<span id="total_following_'.$entityID.'">0</span>'.")</a>";
													}
													?>
                                            	</a>
                                          </li>
                                          <li>
                                            <?php $share_count = 0;
											 	foreach ($shareOnUpdates as $share_row) {
												 	if ($share_row['Entity_update']['share'] == $entityID) {
														$share_count++;
													}
												}
										    ?>
                                          		<a href="#?w=500" rel="share_popup<?php echo $entityID;?>" class="poplight sharecontent">Share</a>
                                                <a href="#?w=500" rel="whosharebox<?php echo $entityID;?>" class="poplight sharecontent">
                                            	  <span class="redcolor">(<?php echo $share_count;?>)</span>
                                                </a>
                                          </li>
                                          <li><span class="posttime"><?php if ($company_update_row['Entity_update']['created']) { echo $month." ".$day.", ".$year; }?></span></li>
                                        </ul>
									 <div class="clear"></div>
                                    </div>
                                   
                              <div class="clear"></div>
                       		  <div id="ajax_res<?php echo $entityID;?>">
								<?php if ($total_likes_unmatched != 0) {?>
                                <div class="wholike-div">
                                    <div class="icon-like"></div>
                                        <ul>
                                        <?php  $i = 1; $str = ''; $flag_set = false; $you = ''; $andcont = ''; $toltip = '';
                                        foreach ($likesOnUpdates as $like_row) {
                                            if ($like_row['likes']['content_id'] == $entityID && $i<=6) {
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
                                            <li><a href="javascript:loadLikesPopup('<?php echo $entityID;?>')" class="poplight totalnumber">
                                            <strong><?php echo "+".$total_likes_unmatched;?></strong></a></li>
                                            <?php } $i = 1; $andcont = ''; ?>
                                        </ul>
        
                                        <div class="clear"></div>
                                    </div>
                                 <?php }?>
                               </div>
                           			
                             <div class="clear"></div>
									<!--- Main Comment Box for Post ----->
									<div id="commentsDiv<?php echo $entityID;?>" style="display:none" class="commentsbox">
                                    
										<!--- Comment Box ---->
                                        <div id="group_loader<?php echo $entityID?>" style="display:none; text-align:center;">
												<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
										</div>
                                        <span id="commentDiv_<?php echo $entityID;?>">
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
                                                    if ($content_id == $entityID) {?>
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
                                                    <?php if ($comment__row['entity_comments']['user_id'] == $uid || $company_user == $uid) {?>
    												<a href="javascript:" onclick="delete_comment('<?php echo $commentid;?>','<?php echo $entityID;?>');" class="comment-close" title="Delete Update">
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
															if(MEDIA_PATH.'/files/user/icon/'.$imgname) {
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
                                                <?php echo $this->Form->input('company_admin_id' , array('type' => 'hidden', 'id'=>'admin_id', 'value' => $company_user)); ?>
            									<?php echo $this->Form->input('content_id' , array('type' => 'hidden', 'id'=>'content_id_'.$entityID, 'value' => $entityID)); ?>
											<?php echo $this->Form->input('comments',array('required'=>false,'div'=>false, 'label'=>false,'id'=>'comment_text_'.$entityID,'placeholder'=>"add comments..",'onkeydown'=>'checkField('.$entityID.');')); ?>
                                   <input type="hidden" name="lcontent_date" id="content_date_<?php echo $entityID;?>" value="<?php echo $date = date("Y-m-d H:i:s");?>" />
                                           <input name="send" type="button" id="send<?php echo $entityID;?>" value="Comment" style="display:none; margin-right:60px;" onclick="saveComment('<?php echo $entityID;?>');" class="comment_bttn" />
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
            <div id="whosharebox<?php echo $entityID;?>"  class="popup_block">
        <!--your content start-->
              <div class="heading"><h1>People Who Share This Update</h1></div>
                <div class="scroller">
                <?php foreach ($shareOnUpdates as $sharerow) {
                        if ($sharerow['Entity_update']['share'] == $entityID) {
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
                	
     			<div id="share_popup<?php echo $entityID;?>" class="popup_block">
                    <div class="greybox-div-heading"><h1>Share</h1></div>
                <!--your content start-->
                    
                    <div class="userprofile-box">
                        <?php if ($company_update_row['Entity_update']['image']){ ?>
                        <div class="userprofile-box-pic">
                            <?php 
                            if ($company_update_row['Entity_update']['image']){
                                if (file_exists(MEDIA_PATH.'/files/update/icon/'.$company_update_row['Entity_update']['image'])) {
                                    echo $this->Html->image(MEDIA_URL.'/files/update/icon/'.$company_update_row['Entity_update']['image'],
                                                                                                                                array('alt'=>'banner'));
                                }
                                else {
                                    echo $this->Html->image(MEDIA_URL.'/imag/nologo.jpg',
                                                                                      array('alt'=>'banner'));
                                }
                            }
                            else {
                                 echo $this->Html->image(MEDIA_URL.'/imag/nologo.jpg',
                                                                                      array('alt'=>'banner'));
                            }
                              ?>  
                        </div>
                        <div class="userprofile-box-rgt">
                            <ul>
                                <li>
                                    <h1>
                                    <?php 
                                        echo $this->Html->link($company_update_row['users_profiles']['firstname']." ".$company_update_row['users_profiles']['lastname'],
                                                                                                                                                            array('controller'=>'users_profile',
                                                                                                                                                        'action'=>'userprofile',
                                                                                                                                            $company_update_row['users_profiles']['user_id']
                                                                                                                                                        ));
                                        ?>
                                   </h1>
                                </li>
                                <li><span class="postedon">Posted on  : <?php echo $company_update_row['Entity_update']['created']?></span></li>
                                <li><?php echo strip_tags($company_update_row['Entity_update']['update_text']); ?> </li>
                            </ul>
                        </div>
		<div class="clear"></div>
		<?php } else{
			
			echo $company_update_row['Entity_update']['update_text'];
		}?>
		<div class="clear"></div>
	  </div>
		<form action="/companies/share/" method="post" class="userprofile-form">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><strong>Add to share</strong></td>
			    </tr>
				<tr>
					<td>
                    	 <input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
       					  <input type="hidden" name="content_type" id="content_type" value="company" />
                         <input type="hidden" name="photo" id="photo" value="<?php echo $company_update_row['Entity_update']['image']?>" />
                          <input type="hidden" name="user_share" id="user_share" value="<?php echo $entityID;?>" />
                          <input type="hidden" name="entity_id" id="entity_id" value="<?php echo $companyID;?>" />
						<textarea name="update_text" style="display:none;" id="update_text"><?php echo $company_update_row['Entity_update']['update_text']; ?></textarea>
     					<input type="hidden" name="share_with" id="share_with" value="company" />
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
				<div id="wholikebox<?php echo $entityID;?>"  class="share_popup_ajax" style="width:500px;">
                    <div class="close" onclick="disableLikesPopup('<?php echo $entityID;?>')"></div>
            		<!--your content start-->
                  <div class="heading"><h1>People Who Like This</h1></div>
                    <div class="scroller">
                    <?php foreach ($likesOnUpdates as $like_row) {
                            if ($like_row['likes']['content_id'] == $entityID) {
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
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<div id="backgroundPopup"></div>
<style>
.over{background-color:#5E5E5E !important;border:1px solid #000000 !important;}
</style>
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