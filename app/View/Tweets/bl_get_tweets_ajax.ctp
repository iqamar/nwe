<?php 
 foreach ($user_tweets as $tweet__Row) { 
 		$tweet_id = $tweet__Row['tweets']['id'];
		$u_id = $tweet__Row['users_profiles']['user_id'];
		$tweet_admin = $tweet__Row['tweets']['user_id'];
 ?>

    	<div class="tweets tweets_loadings" id="<?php echo $tweet_id;?>"> 
            <div class="tweetuser-pic">
            
                <?php  
				echo '<a href="Javascript:loadSharePopup('.$tweet_id.',0)">';
				if ($tweet__Row['users_profiles']['photo']) {
					echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$tweet__Row['users_profiles']['photo']);
				}
				else {
					echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg');	
				}
				echo '</a>';
				?>
            </div>
            <div class="tweets-rgt">
                <ul>
                	 
                    
                    <li>
                    	<span class="tweettime">
                            <?php if ($tweet_admin == $uid) {?>
                        <a href="#" class="comment-close" data-toggle="modal" data-target="#deleteupdatebox<?php echo $tweet_id;?>"></a>
                        </a>
                    <?php }?>
                         </span>
                    	<a href="Javascript:loadSharePopup('<?php echo $tweet_id;?>','0');" class="postwall-name">
							<?php echo $tweet__Row['users_profiles']['firstname']." ".$tweet__Row['users_profiles']['lastname']?>
                    	</a> 
                    	<?php if($tweet__Row['users_profiles']['handler']){
							echo '<a href="Javascript:loadSharePopup('.$tweet_id.',0)">'.'@'.$tweet__Row['users_profiles']['handler'].'</a>';
						}
						?>
                    </li>
                    <li style="word-wrap:break-word;">
					<?php
						if(filter_var($tweet__Row['tweets']['tweet'], FILTER_VALIDATE_URL)){
							?>
							<a href="<?php echo $tweet__Row['../../webroot/js/tweets']['tweet'];?>"><?php echo $tweet__Row['tweets']['tweet'];?></a>
						<?php }
						else {
								echo $tweet__Row['tweets']['tweet'];
						}
					?> 
                    
                    </li>
                    <li>
					<div class="post-bttns">
                        <ul>
                            <?php 
                            if ($tweet__Row['tweets']['photo']) {?>
                                <li><a href="javascript:viewPhoto('<?php echo $tweet_id;?>');" id="view_photo_<?php echo $tweet_id;?>" class="current reply" >View Photo </a></li>
                                <li><a href="javascript:hidePhoto('<?php echo $tweet_id;?>');" class="current reply" id="hide_photo_<?php echo $tweet_id;?>" style="display:none;">Hide photo</a></li>
                            <?php }?>
                            <li>
                                <a href="Javascript:loadSharePopup('<?php echo $tweet_id;?>','0');" class="reply" >Reply 
                                <span class="redcolor">
								<?php 
                                        $chk_comments = 0;
                                        foreach ($tweets_comments_count as $comments_total_row) {
                                                if ($comments_total_row['Tweet_comment']['content_id'] == $tweet_id) {
                                                    echo '(<span id="total_comment_'.$tweet_id.'">'.$comments_total_row[0]['commenttotal'].'</span>'.')';
                                                    $chk_comments = 1;
                                                }
                                            }
                                            if ($chk_comments == 0) {
                                                    echo "(".'<span id="total_comment_'.$tweet_id.'">0</span>'.")";
                                            }
                                 ?>
								</span>
                                </a>
                            </li>
                            
                            <li><a href="Javascript:loadSharePopup('<?php echo $tweet_id;?>','0');" class="poplight retweet">Retweet</a></li>
                            <li><a href="Javascript:loadSharePopup('<?php echo $tweet_id;?>','0');" class="favorite">Favourite</a></li>
                           <li>
                           		<span class="posttime">
						   			<?php 
                            						$today = strtotime(date('Y-m-d H:i:s'));
                            						$distination = strtotime($tweet__Row['tweets']['created']);
                            						$difference = ($today - $distination);
                            						$days = floor($difference/(60*60*24));
                           							$hours = floor($difference/(60*60));
													$minutes = floor($difference/(60));
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
                              </span>
                           </li>   
                       </ul>
      				  <div class="clear"></div>
      			</div>
      				<div id="expand_tweet_photo_<?php echo $tweet_id;?>" style="width:100%; margin-top:5px; height:auto; display:none; clear:both;">
            				<?php echo $this->Html->image(MEDIA_URL.'/files/tweet/original/'.$tweet__Row['tweets']['photo'],array('style'=>'max-width:580px;'));?>
     				</div>
                       
                        <!--- Main Comment Box for Post ----->
                        <div id="commentsDiv<?php echo $tweet_id;?>" style="display:none" class="replytweet">
                            <div class="writecomment">
                                <div class="comment-listing-pic">
                                	<?php
        							if ($imgname) {
								echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$imgname,array('url'=>array('controller'=>'tweets','action'=>'profile'),'style'=>''));
									}
								else {
									echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'tweets','action'=>'profile'),'style'=>''));
									}
									?>    
                                </div>
                                <div class="writecomment-rgt">
                                    <textarea id="tweet_reply_<?php echo $tweet_id;?>" name="data[Tweet][tweet_text]" onkeyup="countReply('<?php echo $tweet_id;?>');" cols="" rows="" class="tweettextfield"  onkeydown="checkField('<?php echo $tweet_id;?>')" placeholder="Post your reply"></textarea><br />
                                    <input type="hidden" id="user_id" value="<?php echo $uid;?>" />
                                    <input type="hidden" id="tweet_admin<?php echo $tweet_id;?>" value="<?php echo $tweet_admin;?>" />
                        			<input type="hidden" id="comment_type" value="tweets" />
                        			<input type="hidden" id="created_<?php echo $tweet_id;?>" value="<?php echo $created = date("Y-m-d H:i:s");?>" />
                                <a href="javascript:tweet_replay('<?php echo $tweet_id;?>');" style="display:none;" id="send<?php echo $tweet_id;?>" class="buttonsmall comment_bttn">Tweet</a>
                       
                                    <span id="Reply_tweet_count<?php echo $tweet_id;?>" style="float:right;">113 characters</span>
                                </div>
                                <div class="clear"></div>
                            </div>
                        	<div class="clear"></div>
                            <div id="comments_loadings<?php echo $tweet_id;?>" style="text-align:center; display:none;"> 
            					<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif',array('style'=>''));?>
        					</div>
                            <div id="span_<?php echo $tweet_id;?>">
                                <!--- Comment Box ---->
                                <?php 
                                    foreach ($user_tweet_comments as $comms) {
										if ($comms['Tweet_comment']['content_id'] == $tweet__Row['tweets']['id']) {
											$tweet_comment_id = $comms['Tweet_comment']['id'];
											$tweet_comment_user = $comms['Tweet_comment']['user_id'];
											$created_date = $comms['Tweet_comment']['created'];
											$day = date("d",strtotime($created_date));
											$month = date("m",strtotime($created_date));
											$year = date("Y",strtotime($created_date));
											$time = date("H:i:s",strtotime($created_date));
                                    ?>
                                <div class="comment-listing" id="commentsbox<?php echo $tweet_comment_id;?>">
                                    <div class="comment-listing-pic">
                                        <a href="/users_profiles/userprofile/<?php echo $comms['users_profiles']['user_id'];?>">
                                        <?php if ($comms['users_profiles']['photo']) {
											
											echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$comms['users_profiles']['photo'],array('style'=>''));
										}
										else {
											echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>''));
										}
											?>
                                        </a> 
                                    </div>
                                    <div class="comment-listing-rgt">
                                    <ul>
                                        <li>
                                        <a href="/users_profiles/userprofile/<?php echo $comms['users_profiles']['user_id'];?>">
										<?php echo $comms['users_profiles']['firstname']." ".$comms['users_profiles']['lastname'];?></a> 
                                        <?php echo substr($comms['Tweet_comment']['tweet_comment'],0,350);?>
                                        <?php if ($tweet_comment_user == $uid || $tweet_admin == $uid) {?>
                                        <a href="#" class="comment-close" data-toggle="modal" data-target="#deletebox<?php echo $tweet_comment_id;?>"></a>
                                        </a>
                                        <?php }?>
                                         </li>
                                         <li><span class="posttime"><?php echo $day." ".$month.", ".$year."  @ ".$time; ?></span></li>
                                    </ul>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <!--- Delete Box Starts Here --->
                                <div class="modal fade middlepopup" id="deletebox<?php echo $tweet_comment_id;?>" tabindex="-1" role="dialog" aria-labelledby="deletebox" aria-hidden="true">
                                      <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <a class="popupclose" data-dismiss="modal" aria-hidden="true"></a>
                                            <h1 class="modal-title" id="myModalLabel">Delete</h1>
                                          </div>
                                          <div class="modal-body">
                                            <h2>Are You sure want to delete ?</h2>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" onclick="delete_comment('<?php echo $tweet_comment_id;?>','<?php echo $tweet_id;?>');" class="btn submitbttn" data-dismiss="modal">Yes</button>
                                            <button type="button" class="btn canclebttn" data-dismiss="modal">No</button>
                                          </div>
                                        </div>
                                      </div>
                                </div>
                               <!--- Delete Box Ends Here ---> 
                                <?php }}?>
                                <!--- End Comments Box --->
                            </div>
                        </div>
                   <!--- End of Main Comment Box for Post ----->
                   </li>
                </ul>
            </div>
            <div class="clear"></div>
		</div>
        
        <!--- Tweet Box Starts Here --->
		<div id="retweet_ajax<?php echo $tweet_id;?>"  class="share_popup_ajax" style="width:500px;">
			<!--your content start-->
            <div class="close" onclick="disablePopup('<?php echo $tweet_id;?>')"></div>
  			<div class="heading"><h1>Retweet this to your followers</h1></div>
			<div class="tweets" style="border:0px;">
						<div class="tweetuser-pic">
						<?php if ($tweet__Row['users_profiles']['photo']){
								$user_id = $tweet__Row['users_profiles']['user_id'];
								echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$tweet__Row['users_profiles']['photo'],
																						  array('url'=>array('controller'=>'connections','action'=>'connection_profile',$user_id),
																											 'style'=>''));
								}	
								else {
 									echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>'/pub/'.$tweet__Row['users_profiles']['handler']),array(
																											 'style'=>''));
			 					 }?>
              </div>
						<div class="tweets-rgt" style="width:88%;">
							<ul>
								<li>
                                <input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
             					<input type="hidden" name="photo" id="photo_<?php echo $tweet_id;?>" value="<?php echo $tweet__Row['tweets']['photo'];?>" />
              					<input type="hidden" name="tweet" id="tweet_<?php echo $tweet_id;?>" value="<?php echo $tweet__Row['tweets']['tweet'];?>" />
                                <span class="tweettime">
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
								</span>
                                <a href="#">
								<?php echo $tweet__Row['users_profiles']['firstname']." ".$tweet__Row['users_profiles']['lastname'];?>
                                </a>	</li>
                                <li><?php echo $tweet__Row['tweets']['tweet']?></li>
							</ul>
                            <div class="rgt">
                                    <a href="javascript:retweet_byajax('<?php echo $tweet_id;?>');" class="button">Retweet</a>
                            </div>
					   </div>
		</div>
		<!--your content end-->
	</div>
	<!--- Tweet Box Ends Here --->
    
    <div class="modal fade middlepopup" id="deleteupdatebox<?php echo $tweet_id;?>" tabindex="-1" role="dialog" aria-labelledby="deletebox" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <a class="popupclose" data-dismiss="modal" aria-hidden="true"></a>
                    <h1 class="modal-title" id="myModalLabel">Delete</h1>
                  </div>
                  <div class="modal-body">
                    <h2>Are You sure want to delete ?</h2>
                  </div>
                  <div class="modal-footer">
                   <button type="button" onclick="delete_tweet('<?php echo $tweet_id;?>','<?php echo $total_tweets?>');" class="btn submitbttn" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn canclebttn" data-dismiss="modal">No</button>
                  </div>
                </div>
              </div>
        </div>
       <!--- Delete Box Ends Here ---> 
<?php }?>