<div class="box">
	<div id="loadings" style="text-align:center; display:none;"> 
            <?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif',array('style'=>''));?>	
    </div>
	<div class="sharepost-user" id="result_from_ajax"> 
    
    	 <?php foreach ($user_tweets as $tweet__Row) {
				$tweet_id = $tweet__Row['tweets']['id'];
				$u_id = $tweet__Row['users_profiles']['user_id'];
				$tweet_admin = $tweet__Row['tweets']['user_id'];
	?>
    	<div class="tweets tweets_loadings" id="<?php echo $tweet_id;?>"> 
            <div class="tweetuser-pic">
                <?php  if ($tweet__Row['users_profiles']['photo']) {
					echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$tweet__Row['users_profiles']['photo'],array('url'=>'/tweets/profile/'.$u_id));
				}
				else {
					echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>'/tweets/profile/'.$u_id));	
				}
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
                    	<a href="/tweets/profile/<?php echo $u_id;?>" class="postwall-name">
							<?php echo $tweet__Row['users_profiles']['firstname']." ".$tweet__Row['users_profiles']['lastname']?>
                    	</a> 
                    	<?php if($tweet__Row['users_profiles']['handler']){
								echo $this->Html->link("@".$tweet__Row['users_profiles']['handler'],array('controller'=>'tweets',
																										  'action'=>'profile',$u_id),
																									  array('style'=>''));	
						}
						?>
                    </li>
                    
                    
                    <li style="word-wrap:break-word;">
					<?php
						if(filter_var($tweet__Row['tweets']['tweet'], FILTER_VALIDATE_URL)){
							?>
							<a href="<?php echo $tweet__Row['tweets']['tweet'];?>"><?php echo $tweet__Row['tweets']['tweet'];?></a>
						<?php }
						else {
							
							$content_array = explode(" ", $tweet__Row['tweets']['tweet']);
							$output = '';
							
							foreach($content_array as $content)
							{
							//starts with http://
							if(substr($content, 0, 7) == "http://" || substr($content, 0, 8) == "https://")
							$content = '<a href="' . $content . '" target="_blank">' . $content . '</a>';
							
							//starts with www.
							if(substr($content, 0, 4) == "www.")
							$content = '<a href="http://' . $content . '" target="_blank">' . $content . '</a>';
							
							$output .= " " . $content;
							}
							
							$output = trim($output);
							echo $output;
								//echo $tweet__Row['tweets']['tweet'];
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
                                <a href="#" class="reply" >Reply 
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
                            <li><a href="#"class="poplight retweet">Retweet</a></li>
                            <li><a href="#" class="favorite">Favourite</a></li>
                            
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
                                    <textarea id="tweet_reply_<?php echo $tweet_id;?>" name="data[Tweet][tweet_text]" onkeyup="countReply(<?php echo $tweet_id;?>);" cols="" rows="" class="tweettextfield"  onkeydown="checkField('<?php echo $tweet_id;?>')" placeholder="Post your reply"></textarea><br />
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
    
    	<?php }?>
    <div id="loader" style="text-align:center;"></div>
    </div>
</div> 
<script>
$(document).ready(function(){ 
	var ID;
	function load_more() 
		{ 
		 if(ID == $(".tweets_loadings:last").attr("id")) 
		 	{
				return false;
			}
            ID = $(".tweets_loadings:last").attr("id");
			$("#loader").html("<img src='"+media+"/img/loading.gif' alt='loading'/>");
			$.post(baseUrl+"/tweets/get_tweets_ajax/"+ID,
			function(data){
				if (data != "") {
				$(".tweets_loadings:last").after(data);			
				}
				$("#loader").html('');
			});
		};  
		
		$(window).scroll(function(){
			if  ($(window).scrollTop() == $(document).height() - $(window).height()){
					setTimeout(function() {
					// This is the Ajax function					
					load_more();
							
					}, 500);
			   
			}
		}); 
			
});

function viewPhoto(tweet_id) {
	$('#view_photo_'+tweet_id).css({
            'display' : 'none'
        });
		$('#hide_photo_'+tweet_id).css({
            'display' : 'block'
        });
	$("#expand_tweet_photo_"+tweet_id).slideToggle('slow');
}

function hidePhoto(tweet_id) {
	$('#view_photo_'+tweet_id).css({
            'display' : 'block'
        });
		$('#hide_photo_'+tweet_id).css({
            'display' : 'none'
        });
	$("#expand_tweet_photo_"+tweet_id).slideToggle('slow');
}
</script>
                     