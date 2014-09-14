<?php 
 foreach ($user_tweets as $tweet__Row) { 
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
                	 
                    	<?php $i =1; $flag = false;
						foreach ($tweets_retweeted_byUser as $retweet_users) {
							$rettweet_content_id = $retweet_users['tweets']['parent_id'];
							$rettweet_user = $retweet_users['tweets']['user_id'];
							$rettweet_id = $retweet_users['tweets']['id'];
							$user_name = $retweet_users['users_profiles']['firstname']." ".$retweet_users['users_profiles']['lastname'];
							$user_handler = $retweet_users['users_profiles']['handler'];
							$photo = $retweet_users['users_profiles']['photo'];
							if ($rettweet_content_id == $tweet_id && $rettweet_user != $uid) {
								if ($i<=3) {
										if ($i == 1) {
											echo '<li><span class="retweetedby">Retweeted by:';
										}
									?>
									<?php if ($i>1) { echo ",&nbsp;";}?>
									<a href="<?php echo NETWORKWE_URL;?>/tweets/profile/<?php echo $user_handler;?>"><?php echo $user_name;?></a>  
								<?php 
									if ($i == 1) {
										
									}
								}
								if ($i == 3) {
									echo '&nbsp&nbsp&nbsp<a href="#?" rel="wholikebox'.$tweet_id.'" class="poplight totalnumber">More</a>';
									
								}
								$flag = true;
							$i++; 
						  }
						}
						if ($flag == true) {
							echo '</span></li>';
						}
						?>
                        
                        <!--- Like Box Starts Here --->
                          <div id="wholikebox<?php echo $tweet_id;?>"  class="popup_block" style="width:500px;">
                           
                    		<!--your content start-->
                          	<div class="heading"><h1>People Who Retweet This Tweet</h1></div>
                            <div class="scroller">
                        <?php foreach ($tweets_retweeted_byUser as $retweet_users) {
								$rettweet_content_id = $retweet_users['tweets']['parent_id'];
								$rettweet_user = $retweet_users['tweets']['user_id'];
								$rettweet_id = $retweet_users['tweets']['id'];
								$user_name = $retweet_users['users_profiles']['firstname']." ".$retweet_users['users_profiles']['lastname'];
								$user_handler = $retweet_users['users_profiles']['handler'];
								$user_photo = $retweet_users['users_profiles']['photo'];
								if ($rettweet_content_id == $tweet_id && $rettweet_user != $uid) {
								?>
                                <div class="wholike">
                                  <div class="wholike-pic">
                                    <?php 
                                        if(!empty($user_photo)&& file_exists(MEDIA_PATH.'/files/user/icon/'.$user_photo)){ 
                                            echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$user_photo,array('url'=>array('controller'=>'pub','action'=>$user_handler)));
                                        }else{ 
                                            echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'pub','action'=>$user_handler)));
                                        }    
                                    ?>
                                  </div>
                                  <div class="wholike-rgt">
                                      <ul>
                                          <li>
                                              <h1><?php echo $this->Html->link($user_name,array('controller'=>'pub','action'=>$user_handler));?></h1>
                                          </li>
                                          <li><?php echo $retweet_users['users_profiles']['tags']?></li>
                                      </ul>
                                  </div>
                                  
                                <div class="clear"></div>
                              </div>
                        <?php }}?>
                        </div>
                         <!--your content end-->
                    </div> <!--- Like Box Ends Here --->
                    
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
								echo $tweet__Row['tweets']['tweet'];
						}
					?> 
                    
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
                            
                             <?php 
							 if ($tweet_admin != $uid) {
							 $flage = false;
                                foreach ($retweeted_tweets as $retweet__rows) {
										$rtwet = $retweet__rows['tweets']['retweet'];
                                    if ($tweet__Row['tweets']['id'] == $retweet__rows['tweets']['parent_id'] && $retweet__rows['tweets']['user_id'] == $uid) { 
										?>
                                        <li><a id="retweeted_<?php echo $tweet_id;?>" href="javascript:backtotweet('<?php echo $tweet_id;?>')" class="retweet">Retweeted</a></li>
                                <?php $flage = true;
                                    }
                                } 
                                if ($flage == false) {?>
                                        <li><a href="#?" onclick="loadPopup('<?php echo $tweet_id;?>')" id="retweet_<?php echo $tweet_id;?>" class="retweet">Retweet</a></li>
                                 <?php }?>
                                         <li> 
                                         	<a id="retweeted_<?php echo $tweet_id;?>" href="javascript:backtotweet('<?php echo $tweet_id;?>')" class="retweet" style="display:none;">Retweeted</a>
                                            <a href="#?" onclick="loadPopup('<?php echo $tweet_id;?>')" id="retweet_<?php echo $tweet_id;?>" class="retweet" style="display:none;">Retweet</a>
                                         </li>
                            
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
                                    <li><a href="javascript:favoriteTweet('<?php echo $tweet_id;?>','1');" class="favorite">Favourite</a></li>
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
 <div id="backgroundPopup"></div>
<script>
$(function(){
	$(".tweettextfield").focus(function(){
		$("#tweetbttn").show({
		});
		$(this).animate({
			height:'45px'
		},
		"slow"
		);
	});
$(".canclebttn").click(function(){
	$("#tweetbttn").hide({
	});
	$(".tweettextfield").animate({
		height:'15px'
		},
		"slow"
		);
	});
});

function loadPopup(ID) {
//if(popupStatus == 0) { // if value is 0, show popup
//closeloading(); // fadeout loading
$("#retweet_ajax"+ID).fadeIn(0500); // fadein popup div
$("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
$("#backgroundPopup").fadeIn(0001);
//popupStatus = 1; // and set value to 1
//}
}
function disablePopup(ID) {
//if(popupStatus == 1) { // if value is 1, close popup
$("#retweet_ajax"+ID).fadeOut("normal");
$("#backgroundPopup").fadeOut("normal");
//popupStatus = 0; // and set value to 0
//}
}
function retweet_byajax(tweet_id) {
	var user_id = document.getElementById('user_id').value;
	var photo = document.getElementById('photo_'+tweet_id).value;
	var tweet = document.getElementById('tweet_'+tweet_id).value;
	document.getElementById('retweet_ajax'+tweet_id).style.display = 'none';
	document.getElementById('backgroundPopup').style.display = 'none';
	$("html, body").animate({ scrollTop: 0 }, "slow"); 
	$('#loadings').show();
	$.ajax({
              url     : baseUrl+"/tweets/retweet",
              type    : "POST",
              cache   : false,
              data    : {user_id: user_id,tweet:tweet,photo:photo,parent_id:tweet_id},
              success : function(data){
			  $("#retweet_"+tweet_id).css({
            	'display' : 'none'
       			 });
			  
			  $("#retweeted_"+tweet_id).css({
            	'display' : 'block'
       			 });
			  $("#user_add_tweets").html(data);
              },
     		 complete: function () {
      		    $('#loadings').hide();
                },
			  error : function(data) {
           $("#retweeted_"+tweet_id).html("there is error");
        }
          });		
}
</script>