<?php 
foreach ($updates_added_by_ajax as $ajax__Row) {
	
		$post_id = $ajax__Row['statusupdates']['id']; 
		$today = strtotime(date('Y-m-d H:i:s'));
		$distination = strtotime($ajax__Row['statusupdates']['created']);
		$difference = ($today - $distination);
		$days = floor($difference/(60*60*24));
		$hours = floor($difference/(60*60));
		$minutes = floor($difference/(60));
		$user_idd = $ajax__Row['statusupdates']['user_id']; 
		?>

	<div id="<?php echo $ajax__Row['statusupdates']['id'];?>" class="post-wall as_country_container">
    	<?php if ($ajax__Row['statusupdates']['user_id'] == $uid) {?>
            <a href="javascript:void(o)" onclick="delete_update('<?php echo $post_id;?>');" class="comment-close" title="Delete Update"></a>
            <?php }?>
		<div class="userpic-post">
			<?php 
			if(!empty($ajax__Row['users_profiles']['photo'])&& file_exists(MEDIA_PATH.'/files/user/icon/'.$ajax__Row['users_profiles']['photo'])){ 
				echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$ajax__Row['users_profiles']['photo'],array('url'=>array('controller'=>'users_profiles','action'=>'myprofile',$ajax__Row['users_profiles']['user_id'])));
				
			}else{ 
				echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'users_profiles','action'=>'myprofile',$ajax__Row['users_profiles']['user_id'])));
			} 
             
             ?>
        </div>
		<div class="post-wall-rgt">
        	<ul>
				<li><?php echo $this->Html->link($ajax__Row['users_profiles']['firstname']." ".$ajax__Row['users_profiles']['lastname'],
																														array('controller'=>'users_profiles',
																															  'action'=>'userprofile',
																															  $ajax__Row['users_profiles']['user_id']
																															  ));
					?>
				</li>
                <li>
					<div class="post-wall-subcontent">
						<?php if ($ajax__Row['statusupdates']['photo']) { ?>
                            <div class="post-wall-subcontent-rgt2">
                                <ul>
                                    <li>
                                        <div class="subcontent2-pic">
											<a data-toggle="modal" data-target="#popup-bigimg<?php echo $ajax__Row['statusupdates']['id']; ?>" href="#">
												<?php echo $this->Html->image(MEDIA_URL.'/files/update/original/'.$ajax__Row['statusupdates']['photo'],array('style'=>'height:auto; width:auto; max-width:250px; max-height:250px;'));	?>
											</a>
                                        </div>
										<!--- Pop up Big Image Starts Here --->
										<div class="modal fade middlepopup-bigimg" id="popup-bigimg<?php echo $ajax__Row['statusupdates']['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="popup-bigimg" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header">
														<a class="popupclose" data-dismiss="modal" aria-hidden="true"></a>	
														<h1 class="modal-title" id="myModalLabel"><?php echo $ajax__Row['users_profiles']['firstname']." ".$ajax__Row['users_profiles']['lastname']; ?></h1>
													</div>
													<div class="modal-body">
														<div class="popup-bigpic">
														<?php echo $this->Html->image(MEDIA_URL.'/files/update/original/'.$ajax__Row['statusupdates']['photo'],array('alt'=>'banner'));	?>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--- Pop up Big Image Ends Here --->
                                    </li>
                                    <li>
									<?php
									  if ($ajax__Row['statusupdates']['update_type'] == 0) {
										echo substr($ajax__Row['statusupdates']['user_text'],0,250);
										$str_len = strlen($ajax__Row['statusupdates']['user_text']);
										if ($str_len > 250 && $ajax__Row['statusupdates']['user_text'] != '') {?>
											<a href="<?php echo NETWORKWE_URL;?>/home/view/<?php echo $post_id;?>"> More..</a>
									<?php	}
									  }
									  else {
										  echo $ajax__Row['statusupdates']['user_text'];
									  }
									?>
                                    </li>
                                </ul>
                            </div>
                            <?php } 
                             else {?>
                                <?php
									  if ($ajax__Row['statusupdates']['update_type'] == 0) {
										echo substr($ajax__Row['statusupdates']['user_text'],0,250);
										$str_len = strlen($ajax__Row['statusupdates']['user_text']);
										if ($str_len > 250 && $ajax__Row['statusupdates']['user_text'] != '') {?>
											<a href="<?php echo NETWORKWE_URL;?>/home/view/<?php echo $post_id;?>"> More..</a>
									<?php	}
									  }
									  else {
										  echo $ajax__Row['statusupdates']['user_text'];
									  }
									?>
                            <?php }?>
                    <div class="clear"></div>
                    </div>
                    <div>
						<div class="post-bttns">
                            <ul>
                            	<li>
                                	<div id="user_like_update_<?php echo $ajax__Row['statusupdates']['id'];?>" style="float:left;">
                                    	<div class="likedText" style="float:left;">
                                        <a href="Javascript:showLikes('<?php echo $ajax__Row['statusupdates']['id'];?>','1');" id="alike" class="like<?php echo $ajax__Row['statusupdates']['id'];?>">Like <?php echo "(0)";?></a>
                                            <div class="likedText" style="display:none;" id="likediv<?php echo $ustatus['likes']['content_id'];?>">
                                              <a href="Javascript:showLikes('<?php echo $post_id;?>','0');" class="like">Liked <?php echo "(".$ustatus[0]['total'].")";?></a>
                                           </div>   
                                        </div>
                                    </div>
                                </li>
                                <li>
                                	<a href="#" onClick="showhide('commentsDiv<?php echo $ajax__Row['statusupdates']['id'];?>', 'block'); return false" >Comments
                                   	<span class="redcolor"><?php echo "(".'<span id="total_comment_'.$post_id.'">0</span>'.")"; ?></span>
                                    </a>
                                </li>
                                <li>
                             		<a href="javascript:loadPopup('<?php echo $post_id;?>')" class="sharecontent">Share
                            		 <span class="redcolor"></span> </a>
                              	</li>   
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
                            
                           </div>
                           
                        <!--- Main Comment Box for Post ----->
						<div id="commentsDiv<?php echo $ajax__Row['statusupdates']['id'];?>" style="display:block;" class="commentsbox">
                            <div class="writecomment">
                                <div class="comment-listing-pic">
                                    <?php
                                    //echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$imgname,array('alt'=>'user-pic'));
									
									if(!empty($imgname)&& file_exists(MEDIA_PATH.'/files/user/icon/'.$imgname)){ 
											echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$imgname);
											
										}else{ 
											echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg');
										} 
                                    ?> 
                                </div>
                                <div class="writecomment-rgt">
                                	<input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
                                    <input type="hidden" name="admin_id" id="admin_id<?php echo $post_id;?>" value="<?php echo $user_idd;?>" />
                                    <input type="hidden" name="parent" id="parent" value="0" />
                                    <input type="hidden" name="share" id="share" value="0" />
                                    <input type="hidden" name="id" id="id_<?php echo $ajax__Row['statusupdates']['id'];?>" value="<?php echo $ajax__Row['likes']['id'];?>" />
                                    <input type="hidden" name="comment_type" id="comment_type" value="updates" />
                                    <input type="hidden" name="content_id" id="content_id_<?php echo $ajax__Row['statusupdates']['id'];?>" value="<?php echo $ajax__Row['statusupdates']['id'];?>" />
                                    <input type="hidden" name="comment_date" id="comment_date_<?php echo $ajax__Row['statusupdates']['id'];?>" value="<?php echo $date = date("Y-m-d");?>" />
                                    <input name="postcomment" type="text"  onfocus="if(this.value=='Write Comment') this.value='';" onblur="if(this.value=='') this.value='Write Comment';" value="Write Comment" id="comment_text_<?php echo $ajax__Row['statusupdates']['id'];?>" onkeydown="checkField('<?php echo $post_id;?>')" />
                                     <input name="send" type="submit" id="send<?php echo $post_id;?>" onclick="saveComment('<?php echo $post_id;?>');" value="comment" style="display:none;" class="comment_bttn" />
                                </div>
                                <div class="clear"></div>
                            </div>
							<div class="clear"></div>
                            
                            <!---Comment Box for Post start----->
                            <div id="span_<?php echo $ajax__Row['statusupdates']['id'];?>">
                             <div id="comment_loader_<?php echo $ustatus['statusupdates']['id'];?>" style="display:none; text-align:center;">
					 		<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
                            </div>
                            <!--- Comment Box ---->
                           <?php 
								//$i = sizeof($user_comments);
								foreach ($user_comments as $comm) {
									$comments_id = $comm['comments']['id'];
									$created_date = $comm['comments']['created'];
									$year = date("Y", strtotime($created_date));
									$month = date("M", strtotime($created_date));
									$day = date("d", strtotime($created_date));
									$time = date("H:i:s", strtotime($created_date));
									if ($comm['comments']['content_id'] == $ajax__Row['statusupdates']['id']) {
								?>
                            <div class="comment-listing" id="commentsbox<?php echo $comments_id;?>">
                                <div class="comment-listing-pic">
                                    <?php 
										if(!empty($comm['users_profiles']['photo'])&& file_exists(MEDIA_PATH.'/files/user/icon/'.$comm['users_profiles']['photo'])){ 
											echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$comm['users_profiles']['photo'],array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$comm['users_profiles']['user_id'])));
											
										}else{ 
											echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$comm['users_profiles']['user_id'])));
										} 
										
										
									?> 
                                </div>
                                <div class="comment-listing-rgt">
                                <ul>
                                    <li>
                                    
                                    
									
									<?php echo $this->Html->link($comm['users_profiles']['firstname']." ".$comm['users_profiles']['lastname'],
																														array('controller'=>'users_profiles',
																															  'action'=>'userprofile',
																															  $comm['users_profiles']['user_id']
																															  ));
					?>
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
                            <?php }}?>
                            <!--- Comment Box end ---->
                            </div>
                            <!---Comment Box for Post end----->
                        </div>
                        <!--- End of Main Comment Box for Post ----->
                    </div>
                 </li>
               </ul>
             </div>
             <div class="clear"></div>
          </div>
          <!--End of update post -->
          
          	<!--- Like Box Starts Here --->
			<div id="wholikebox<?php echo $post_id;?>"  class="share_popup_ajax" style="width:500px;">
    			<div class="close" onclick="disableLikesPopup('<?php echo $post_id;?>')"></div>
		<!--your content start-->
      		<div class="heading"><h1>People Who Like This</h1></div>
        	<div class="scroller">
        <?php foreach ($likesOnUpdates as $like_row) {
                if ($like_row['likes']['content_id'] == $post_id) {
                    $fullname = $like_row['users_profiles']['firstname']." ".$like_row['users_profiles']['lastname'];
            ?>
            	<div class="wholike">
              		<div class="wholike-pic">
                	<?php 
                    							
						if(!empty($like_row['users_profiles']['photo'])&& file_exists(MEDIA_PATH.'/files/user/icon/'.$like_row['users_profiles']['photo'])){ 
							echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$like_row['users_profiles']['photo'],array('url'=>
                                                                                                 array('controller'=>'users_profiles',
                                                                                                         'action'=>'userprofile',$like_row['users_profiles']['user_id']),
                                                                                            'style'=>''));
							
						}else{ 
							echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>
                                                                                                 array('controller'=>'users_profiles',
                                                                                                         'action'=>'userprofile',$like_row['users_profiles']['user_id']),
                                                                                            'style'=>''));
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
          
          <!--update sharing -->
         <div id="share_popup_ajax1<?php echo $ajax__Row['statusupdates']['id'];?>" class="share_popup_ajax" style="width:500px;">
         	<div class="close" onclick="disablePopup('<?php echo $ajax__Row['statusupdates']['id'];?>')"></div>
         	<div class="greybox-div-heading"><h1>Share</h1></div>
            
            <!--your content start-->
                <div class="userprofile-box">
                    
                    <?php 
                    if ($ajax__Row['statusupdates']['photo']){
					?>
						<div class="userprofile-box-pic">
							<?php echo $this->Html->image(MEDIA_URL.'/files/update/original/'.$ajax__Row['statusupdates']['photo'],array('alt'=>'banner')); ?>
						</div>
					<?php }	?>  
                    
                    <div class="userprofile-box-rgt">
                        <ul>
                            <li>
                                <h1>
                                <?php 
                                    echo $this->Html->link($ajax__Row['users_profiles']['firstname']." ".$ajax__Row['users_profiles']['lastname'],array('controller'=>'users_profile',
                                                                                                                                                    'action'=>'userprofile',
                                                                                                                                                    $ajax__Row['users_profiles']['user_id']
                                                                                                                                                    ));
                                    ?>
                               </h1>
                            </li>
                            <li><span class="postedon">Posted on  : <?php echo $ajax__Row['statusupdates']['created']?></span></li>
                            <li><?php echo $ajax__Row['statusupdates']['user_text'];?> </li>
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
                                <input type="hidden" name="photo" id="photo" value="<?php echo $ajax__Row['statusupdates']['photo']?>" />
                                <input type="hidden" name="user_text" style="display:none;" id="user_text" value="<?php echo $ajax__Row['statusupdates']['user_text']?>" />
                                <input type="hidden" name="share_with" id="share_with" value="<?php echo strip_tags($ajax__Row['statusupdates']['share_with']);?>" />
                                <input type="hidden" name="user_share" id="user_share" value="<?php echo $ajax__Row['statusupdates']['id'];?>" />
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
     <div id="backgroundPopup"></div>
          	
<?php }?> 
<script>
function loadPopup(ID) {
	//if(popupStatus == 0) { // if value is 0, show popup
	//closeloading(); // fadeout loading
	$("#share_popup_ajax1"+ID).fadeIn(0500); // fadein popup div
	$("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
	$("#backgroundPopup").fadeIn(0001);
	//popupStatus = 1; // and set value to 1
	//}
	}
	function disablePopup(ID) {
	//if(popupStatus == 1) { // if value is 1, close popup
	$("#share_popup_ajax1"+ID).fadeOut("normal");
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
/************** end: functions. **************/
</script>                                 