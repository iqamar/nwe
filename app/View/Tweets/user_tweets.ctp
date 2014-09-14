<div class="success_msg" id="message_user_tweet" style="display:none;">Your Tweet has been deleted successfully!</div>
<div class="heading"><h1>Tweets</h1></div>
	<?php foreach ($curent_user_added_tweets as $tweet__Row) {
			$tweet_id = $tweet__Row['tweets']['id'];
			$u_id = $tweet__Row['users_profiles']['user_id'];
			$tweet_admin = $tweet__Row['tweets']['user_id'];
			?>
       <div id="<?php echo $tweet_id;?>">
		<div class="tweets" id="user_<?php echo $tweet_id;?>">
            <div class="tweetuser-pic">
                <?php  if ($tweet__Row['users_profiles']['photo']) {
					echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$tweet__Row['users_profiles']['photo'],array('url'=>'/users_profiles/userprofile/'.$u_id));
				}
				else {
					echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>''));	
				}
				?>
            </div>
            <div class="tweets-rgt">
                <ul>
                    <li>
                    	<?php if ($u_id == $uid) {?>
							<a href="javascript:void(o)" onclick="delete_user_tweet('<?php echo $tweet_id;?>');" class="comment-close" title="Delete Tweet"></a>
                      <?php }?>
                    	<a href="/users_profiles/userprofile/<?php echo $u_id;?>" class="postwall-name">
							<?php echo $tweet__Row['users_profiles']['firstname']." ".$tweet__Row['users_profiles']['lastname']?>
                    	</a> 
                    	<?php if($tweet__Row['users_profiles']['handler']){
								echo $this->Html->link("@".$tweet__Row['users_profiles']['handler'],array('controller'=>'tweets',
																										  'action'=>'profile',$u_id),
																									  array('style'=>''));	
						}
						?>
                    </li>
                    <li>
					<?php 
							$content_array = explode(" ", $tweet__Row['tweets']['tweet']);
							$output = '';
							
							foreach($content_array as $content)
							{
							if(substr($content, 0, 7) == "http://" || substr($content, 0, 8) == "https://")
							$content = '<a href="' . $content . '" target="_blank">' . $content . '</a>';
							
							//starts with www.
							if(substr($content, 0, 4) == "www.")
							$content = '<a href="http://' . $content . '" target="_blank">' . $content . '</a>';
							
							$output .= " " . $content;
							}
							
							$output = trim($output);
							echo $output;
					//echo $tweet__Row['tweets']['tweet']?> 
                    </li>
                    <li>
					<div class="post-bttns">
                        <ul>
                            <?php 
                            if ($tweet__Row['tweets']['photo']) {?>
                                <li><a href="javascript:viewPhoto('<?php echo $tweet_id;?>');" id="view_photo_<?php echo $tweet_id;?>" class="reply" >View Photo </a></li>
                                <li><a href="javascript:hidePhoto('<?php echo $tweet_id;?>');" class="reply" id="hide_photo_<?php echo $tweet_id;?>" style="display:none;">Hide photo</a></li>
                            <?php }?>
                            <li>
                                <a href="#" onClick="showhide('commentsDiv<?php echo $tweet_id;?>', 'block'); return false" class="reply" >Reply 
                                
                                <?php  // reply count
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
                                
                                </a>
                            </li>
                            
                             <?php 
							 	if ($tweet_admin != $uid) {
								?>
                                        <li><a href="javascript:backto_tweet('<?php echo $tweet_id;?>')" id="retweeted_<?php echo $tweet_id;?>" class="retweet">Retweeted</a></li>
                                        
                            			<li><a id="retweet_<?php echo $tweet_id;?>" href="javascript:loadPopup('<?php echo $tweet_id;?>')" style="display:none;" class="retweet">Retweet</a></li>
                            <?php }?>
                            <div id="user_like_update_<?php echo $tweet_id;?>">
                            <?php $flage = false;
                                foreach ($favorites_on_Tweet as $favorite_tweet_row)  {
                                    $user_id = $favorite_tweet_row['favorites']['user_id'];
                                    $content_id = $favorite_tweet_row['favorites']['content_id'];
                                    if ($tweet__Row['favorites']['favorite']==1 && $user_id == $uid && $tweet__Row['favorites']['content_id'] == $content_id){?>
                                       <li> <a href="javascript:favoriteTweet('<?php echo $tweet_id;?>','0');" class="favorite" style="color:#C70000;">Favorited</a></li>
                                    <?php $flage = true;
                                    } 
                                } 
                                if ($flage == false)  { ?>	
                                    <li><a href="javascript:favoriteTweet('<?php echo $tweet_id;?>','1');" class="favorite">Favorite</a></li>
                                <?php }?>
                           </div> 
                           <li>
                           		<span class="posttime">
								<?php 
									$today = strtotime(date('Y-m-d H:i:s'));
									$distination = strtotime($tweet__Row['tweets']['created']);
									$difference = ($today - $distination);
									$days = floor($difference/(60*60*24));
									$hours = floor($difference/(60*60));
									if ($days >= 1)
										echo "$days days ago";
									else
										echo "$hours hours ago";
                            	?> 
                         	</span>
                           </li>   
                       </ul>
      				  <div class="clear"></div>
      			</div>
      				<div id="expand_tweet_photo_<?php echo $tweet_id;?>" style="width:100%; margin-top:5px; height:auto; display:none; clear:both;">
            				<?php echo $this->Html->image(MEDIA_URL.'/files/tweet/original/'.$tweet__Row['tweets']['photo'],array('style'=>''));?>
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
                                        <a href="/users_profiles/userprofile/<?php echo $comms['users_profiles']['user_id']?>">
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
                                        <a href="#"><?php echo $comms['users_profiles']['firstname']." ".$comms['users_profiles']['lastname'];?></a> 
                                        <?php echo substr($comms['Tweet_comment']['tweet_comment'],0,350);?>
                                        <?php if ($tweet_comment_user == $uid || $tweet_admin == $uid) {?>
                                        		<a href="#" class="comment-close" data-toggle="modal" data-target="#deleteuserreply<?php echo $tweet_comment_id;?>"></a>
                                        <?php }?>
                                         </li>
                                         <li><span class="posttime"><?php echo $day." ".$month.", ".$year."  @ ".$time; ?></span></li>
                                    </ul>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                
                                <!--- Delete Box Starts Here --->
                            	<div class="modal fade middlepopup" id="deleteuserreply<?php echo $tweet_comment_id;?>" tabindex="-1" role="dialog" aria-labelledby="deletebox" aria-hidden="true">
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
      </div>  
<?php }?>
<script>
function backto_tweet(tweet_id) {

	//$('#loadings').show();
	$("#retweeted_"+tweet_id).html('<img src="http://media.networkwe.com/img/loading.gif" alt="loading"/>');
	$.ajax({
              url     : baseUrl+"/tweets/back_tweet",
              type    : "POST",
              cache   : false,
              data    : {parent_id:tweet_id},
              success : function(data){
			 $("#"+tweet_id).slideUp('slow');
			  $("html, body").animate({ scrollTop: 0 }, "slow");
			  $("#user_add_tweets").html(data);
              },
     		 complete: function () {
				 $("#retweeted_"+tweet_id).html('');
      		 //$('#loadings').hide();
                },
			  error : function(data) {
           $("#retweet_"+tweet_id).html("there is error");
        }
          });		


}

</script>