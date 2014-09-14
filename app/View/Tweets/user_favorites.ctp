	<div class="twiter_profile">
    	<?php echo $this->Html->image('default_profile_0_normal.png',array('style' => 'width:48px; height:48px; margin-left:236px; margin-top:55px;'));?>
    	<h1><?php echo $userName['firstname']." ".$userName['lastname'];?></h1>
    </div>
    <div class="tweeter-header-inner" style="margin-bottom:15px;">
    	<ul>
        	<li><?php echo $this->Html->link('Tweets ('.$tweets_count_added_user.')','javascript:user_tweets('.$uid.');');?></li>
            <li><?php echo $this->Html->link('Followers ('.$followers.')','javascript:user_followers('.$uid.');');?></li>
            <li><?php echo $this->Html->link('Following ('.$following.')','javascript:user_following('.$uid.');');?></li>
        </ul>
        <?php echo $this->Html->link('Edit profile',array('controller'=>'users_profiles','action'=>'profile'),array('class'=>'savebtn','style'=>'float:right; padding:3px 5px; height:32px; overflow:hidden;'));?>
    </div>
	<div class="user_status" style="background:#FFF;border-radius:0px 0px 5px ;">
    <div class="tweeter-header-inner">Favorites</div>
	<?php foreach ($tweet_favorites as $favorite__Row) {
			$favorite_id = $favorite__Row['favorites']['id'];
			?>
		<div style="border-bottom: 1px dashed #ccc; padding:5px 0px 15px 0px;">
			<div style="float:left;padding-left: 10px;padding-top: 10px;">
            	<?php  if ($favorite__Row['users_profiles']['photo']) {
				echo $this->Html->Image('/files/users/'.$favorite__Row['users_profiles']['photo'],array('style'=>'width:32px; height:32px;'));
				}
				else {
				echo $this->Html->Image('user-icon.png',array('style'=>'width:32px; height:32px;'));	
				}
				?>
			</div>		
			<div style="float:left;padding-left: 10px;width: 85%;"> 
				<span style="font-size:13px;font-weight:800"><?php echo $favorite__Row['users_profiles']['firstname']." ".$favorite__Row['users_profiles']['lastname']?></span>
               <?php if($favorite__Row['users_profiles']['handler']) echo "@".$favorite__Row['users_profiles']['handler'];?>
						<span style="float:right;"> 	
							<?php 
                            $today = strtotime(date('Y-m-d H:i:s'));
                            $distination = strtotime($favorite__Row['tweets']['created']);
                            $difference = ($today - $distination);
                            $days = floor($difference/(60*60*24));
                            $hours = floor($difference/(60*60));
                            if ($days >= 1)
                                echo "$days days ago";
                            else
                                echo "$hours hours ago";
                            ?> 
                       </span>
				<br/>
				<?php echo $favorite__Row['tweets']['tweet'];?>
        		<div style="font-size:12px; padding-top:4px;">
                                <?php if ($favorite__Row['tweets']['photo']) {?>
                		<a href="javascript:viewPhoto('<?php echo $favorite_id;?>');" id="view_photo_<?php echo $favorite_id;?>" style="text-decoration:none; color:#B0B0B0; padding:5px; margin-right:8px; float:left;">Veiw photo</a>
                		<a href="javascript:hidePhoto('<?php echo $favorite_id;?>');" id="hide_photo_<?php echo $favorite_id;?>" style="text-decoration:none; display:none; color:#B0B0B0; padding:5px; margin-right:8px; float:left;">Hide photo</a>
                	
                    <?php }?>
        				<a href="javascript:showTweets('<?php echo $favorite_id;?>');" id="view_expand_<?php echo $favorite_id;?>" style="text-decoration:none; color:#B0B0B0; padding:5px; margin-right:8px; float:left;">Expand</a>
        				<a href="javascript:HideTweets('<?php echo $favorite_id;?>');" id="view_collapse_<?php echo $favorite_id;?>" style="text-decoration:none; display:none; color:#B0B0B0; padding:5px; margin-right:8px; float:left;">Collapse</a>
        			<a href="javascript:showTweets('<?php echo $favorite_id;?>');" style="text-decoration:none; color:#B0B0B0; padding:5px; margin-right:8px; float:left;">Reply</a>
        				<?php $flage = false;
								foreach ($retweeted_tweets as $retweet__rows) {
								if ($favorite__Row['tweets']['id'] == $retweet__rows['tweets']['parent_id'] && $retweet__rows['tweets']['user_id'] == $uid) {  ?>
        	 						<a id="retweeted_<?php echo $favorite_id;?>" style="text-decoration:none; color:#006FDD; padding:5px; margin-right:8px; float:left;">Retweeted</a>
            						<?php $flage = true;
									}} 
									if ($flage == false) {?>
           							 	<a href="javascript:showRetweet('<?php echo $favorite_id;?>')" id="retweet_<?php echo $favorite_id;?>" style="text-decoration:none; color:#B0B0B0; padding:5px; margin-right:8px; float:left;">Retweet</a>
            					<?php }?>
           
            <a id="retweeted_<?php echo $favorite_id;?>" style="text-decoration:none; display:none; color:#006FDD; padding:5px; margin-right:8px; float:left;">Retweeted</a>
            
                         <div id="user_like_update_<?php echo $favorite_id;?>" style="float:left; width:56px; margin-right:7px;">
							<?php $flage = false;
	 							foreach ($favorites_on_Tweet as $favorite_tweet_row)  {
									$user_id = $favorite_tweet_row['favorites']['user_id'];
									$content_id = $favorite_tweet_row['favorites']['content_id'];
                   				 	if ($favorite__Row['favorites']['favorite']==1 && $user_id == $uid && $favorite__Row['favorites']['content_id'] == $content_id){?>
       									<a style="text-decoration:none; color:#FFA851; padding:5px; margin-right:8px; float:left;">Favorited</a>
                   				 <?php $flage = true;} } 
									if ($flage == false)  { ?>	
                    	<a href="javascript:favoriteTweet('<?php echo $favorite_id;?>','1');" style="text-decoration:none; color:#B0B0B0; padding:5px; margin-right:8px; float:left;">Favorite</a>
                    <?php }?>
                    </div>
                    <div id="expand_tweet_photo_<?php echo $favorite_id;?>" style="width:100%; margin-top:5px; height:auto; display:none; clear:both;">
                    	<?php echo $this->Html->image('/files/updates/'.$favorite__Row['tweets']['photo'],array('style'=>'width:350px; height:350px;'));?>
                    </div>
                    <div id="expand_tweet_<?php echo $favorite_id;?>" style="width:100%; margin-top:5px; height:auto; display:none; clear:both;">
                    <span style="color:#8B8B8B; font-size:12px;"><?php echo $today = date("F j, Y, g:i a"); ?></span>
                        <textarea id="tweet_reply_<?php echo $favorite_id;?>" name="data[Tweet][tweet_text]" onkeyup="countReply(this);" cols="55" rows="4" style="width:100%; height:35px; padding:8px; border:1px solid #ccc; margin-bottom:10px;" onClick="openReplayTweet('<?php echo $favorite_id;?>');" placeholder="Compose tweet replay.."></textarea>
                        <input type="hidden" id="user_id" value="<?php echo $uid;?>" />
                        <input type="hidden" id="comment_type" value="tweets" />
                        <input type="hidden" id="created_<?php echo $favorite_id;?>" value="<?php echo $created = date("Y-m-d H:i:s");?>" />
                        <span id="tweetReplaybtn_<?php echo $favorite_id;?>" style="display:none;">
                         	<a href="javascript:tweet_replay('<?php echo $favorite_id;?>');" class="savebtn" style="float:right">Tweet</a>&nbsp;&nbsp;
                        	<span id="Reply_tweet_count" style="float:right;">113 characters</span>
                       	</span>
                        
                         <!-- Comments listing start -->
                          <div id="span_<?php echo $favorite_id;?>">
                            <div class="postComments" style="width:460px; margin:10px 0px 0px 0px;">
                                <ul>
                                    <?php 
                                    foreach ($user_tweet_comments as $comms) {
										if ($comms['Tweet_comment']['content_id'] == $favorite__Row['tweets']['id']) {
                                    ?>
                                        <li style="clear:both;">
                                            <?php if ($comms['users_profiles']['photo']) {?>
                                            <img src="<?php echo $this->base;?>/files/users/<?php echo $comms['users_profiles']['photo'];?>" alt="<?php echo $comms['users_profiles']['firstname'];?>" />
                                            <?php } else {?>
                                            <img src="<?php echo $this->base;?>/img/no-image.png" alt="no image" />
                                            <?php }?>
                                            <div class="desc" style="width:400px;">
                                            <h3 style="font-weight:bold;"><?php echo $comms['users_profiles']['firstname']." ".$comms['users_profiles']['lastname'];?></h3>
                                                <?php echo substr($comms['Tweet_comment']['tweet_comment'],0,350);?> 
                                            </div>
                                             <div style="clear:both;">&nbsp;</div>
                                        </li>
                                    <?php }}?>
                                </ul>
                            </div>
                           </div>
                        <!-- Comments listing end -->
                        
                    </div>
        		</div>
			</div>
			<div style="clear:both;"></div>	
            
            <!-- --share form for updates post start-->
		<div class="referel_pop" id="openEditWindow_<?php echo $favorite_id;?>" style="display:none; padding-bottom:15px; top:200px;">
			<div class="close_icon_row" style="width:480px;">
				<div class="close_icon_row_left" style="width:460px;">Retweet this to your followers </div><div class="close_icon" style="float:right;" onclick="close_RetweetWindow('<?php echo $favorite_id;?>')">
				</div>
			</div>
 			<div class="mini-form">
             <input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
             <input type="hidden" name="photo" id="photo_<?php echo $favorite_id;?>" value="<?php echo $favorite__Row['tweets']['photo'];?>" />
              <input type="hidden" name="tweet" id="tweet_<?php echo $favorite_id;?>" value="<?php echo $favorite__Row['tweets']['tweet'];?>" />
             </div>
 	
 		<div class="view">
 			<?php if ($favorite__Row['users_profiles']['photo']){
						$user_id = $favorite__Row['users_profiles']['user_id'];
				echo $this->Html->image('/files/users/'.$favorite__Row['users_profiles']['photo'],array('url'=>array('controller'=>'connections','action'=>'connection_profile',$user_id),'style'=>'float:left; padding-right:4px; width:40px; height:40px;'));
					}	else {
 				echo $this->Html->image('user-icon.png',array('url'=>'/pub/'.$favorite__Row['users_profiles']['handler']),array(
																											 'style'=>'float:left; padding-right:4px; width:40px; height:40px;'));
					 }?>
			<div style="width:440px; float:left;">
				<h3 class="title"><?php echo $favorite__Row['users_profiles']['firstname']." ".$favorite__Row['users_profiles']['lastname'];?></h3>
    			<p class="meta"></p>
    			<p class="summary"><?php echo $favorite__Row['tweets']['tweet']?></p>
			</div>
            <a href="javascript:tweetToRetweet('<?php echo $favorite_id;?>');" class="savebtn" style="float:right;">Retweet</a>&nbsp;
            <a href="javascript:close_RetweetWindow('<?php echo $favorite_id;?>');" class="savebtn" style="float:right;">Cancel</a>
 
		</div>
	</div>
		<!-- --share form for shared post end-->
            
		</div>
<?php }?>
	</div>