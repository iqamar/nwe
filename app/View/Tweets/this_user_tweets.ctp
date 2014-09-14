<script type="text/javascript">
function openTweet() {
$('#twetarea').css({
            'height' : '70px'
        });
$('#tweetbtn').css({
            'display' : 'block'
        });

}

function openReplayTweet(tweet_id) {
$('#tweet_reply_'+tweet_id).css({
            'height' : '70px'
        });
$('#tweetReplaybtn_'+tweet_id).css({
            'display' : 'block'
        });
}
</script>

<div style="float: left; width: 30%; padding-right: 20px;">
	<div style="background: none repeat scroll 0px 0px rgb(249, 249, 249); border-radius: 5px;">
    
		<div style="padding: 10px;">	
			<div style="float: left;"> 
			<?php 
			if ($user_profile['photo']) {
				echo $this->Html->Image('/files/users/'.$user_profile['photo'],array('style'=>'width:32px; height:32px;', 'align' => 'top'));
			}
			else {
				echo $this->Html->Image('user-icon.png',array('style'=>'width:32px; height:32px;', 'align' => 'top'));
			}
			?>
			</div>
			<div class="profile_view">
					<span style="color:#333333;font-size: 14px;font-weight: 800;"><?php echo $user_profile['firstname']." ".$user_profile['lastname']; ?></span>
					<br><a href="/connections/connection_profile/<?php echo $user_profile['user_id'];?>">view my profile</a>
			</div>
			 <div style="clear:both;"></div>
		</div>
		
		<div class="tweets_links">
			
            <a href="javascript:user_tweets('<?php echo $u_id;?>')"> 
			    <b><?php if ($tweets_count_added_user) echo $tweets_count_added_user; else echo "0"; ?></b><br>Tweets
			</a>
			<a href="javascript:user_following('<?php echo $u_id;?>')"> 
			    <b><?php if ($following) echo $following; else echo "0";?></b><br>Following
			</a>
			<a href="javascript:user_followers('<?php echo $u_id;?>')" style=" border:none;"> 
			    <b><?php if ($followers) echo $followers; else echo "0";?></b><br>Followers
			</a>
			 <div style="clear:both;"></div>
		</div>
	
	</div>
</div>

<div style="float:left;width:70%;">
    <div id="loadings" style="position:absolute; z-index:100px; left:50%; top:50%; text-align:center; display:none;"> 
            <?php echo $this->Html->image('loading.gif');?>	
    </div>
     <?php if ($this->params['named']['mesg'] !=''){ ?>
	<div id="global-error">
    	<div class="alert success">
        	<p>
					<?php
					$mesg = $this->params['named']['mesg']; 
					echo $mesg;
			?>
            </p>
          </div>
     </div>
     <?php  }?>
	<div class="relat-lftmain-div">
		<div class="relat-lft-div">
		<?php if ($this->Session->read(@$userid)) {
				$cuser = $this->Session->read(@$userid);
				$logged_user = $cuser['Auth']['User'];
				$uid = $cuser['userid'];
				?>
			<?php }?>
		</div>			
	</div>
	<div class="user_status" style="background:#FFF;border-radius:0px 0px 5px ;" id="result_from_ajax">
    <div class="tweeter-header-inner">Tweets</div>
    	<?php foreach ($user_tweets as $tweet__Row) {
			$tweet_id = $tweet__Row['tweets']['id'];
			$u_id = $tweet__Row['users_profiles']['user_id'];
			?>
		<div style="border-bottom: 1px dashed #ccc; padding:5px 0px 15px 0px;">
			<div style="float:left;padding-left: 10px;padding-top: 10px;">
            	<?php  if ($tweet__Row['users_profiles']['photo']) {
				echo $this->Html->Image('/files/users/'.$tweet__Row['users_profiles']['photo'],array('style'=>'width:32px; height:32px;'));
				}
				else {
				echo $this->Html->Image('user-icon.png',array('style'=>'width:32px; height:32px;'));	
				}
				?>
			</div>		
			<div style="float:left;padding-left: 10px;width: 85%;"> 
				<span style="font-size:13px;font-weight:800"><?php echo $tweet__Row['users_profiles']['firstname']." ".$tweet__Row['users_profiles']['lastname']?></span>
                <?php if($tweet__Row['users_profiles']['handler']) 
						{
							echo $this->Html->link("@".$tweet__Row['users_profiles']['handler'],array('controller'=>'tweets','action'=>'this_user_tweets',$u_id),
																									  array('style'=>'text-decoration:none; color:#006FDD;'));
							
						}?>
						<span style="float:right;"> 	
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
				<br/>
				<?php echo $tweet__Row['tweets']['tweet']?> 
                <!-- tweet Retweeted by user-->
                <div style=" padding-top:4px;">
                 <?php $retweets_counts = ''; $i = 1;
				 foreach ($retweeted_tweets as $retweet__rows) { 
						if ($tweet__Row['tweets']['id'] == $retweet__rows['tweets']['parent_id']) { 
							$retweets_counts += 1;
							$i++;
							
						}
					
				}
				
				//foreach ($retweeted_tweets as $retweet__rows) {
				//if ($tweet__Row['tweets']['id'] == $retweet__rows['tweets']['parent_id'] && $retweet__rows['tweets']['user_id'] != $u_id) {  ?>
        	 	<!--<a href="/connections/connection_profile/<?php //echo $retweet__rows['users_profiles']['user_id'];?>" 
                style="text-decoration:none; font-size:13px; font-weight:bold; color:#006FDD; padding:5px; margin-right:8px; float:left;">Retweeted by
				<?php //echo " ".$retweet__rows['users_profiles']['firstname']." ".$retweet__rows['users_profiles']['lastname'];?></a>-->
            	<?php 
				//}} ?>
                </div>
                 <!-- tweet Retweeted by user END-->
        		<div style="font-size:12px; padding-top:4px; clear:both;">
                <?php if ($tweet__Row['tweets']['photo']) {?>
                		<a href="javascript:viewPhoto('<?php echo $tweet_id;?>');" id="view_photo_<?php echo $tweet_id;?>" style="text-decoration:none; color:#B0B0B0; padding:5px; margin-right:8px; float:left;">Veiw photo</a>
                		<a href="javascript:hidePhoto('<?php echo $tweet_id;?>');" id="hide_photo_<?php echo $tweet_id;?>" style="text-decoration:none; display:none; color:#B0B0B0; padding:5px; margin-right:8px; float:left;">Hide photo</a>
                	
                    <?php }?>
        				<a href="javascript:showTweets('<?php echo $tweet_id;?>');" id="view_expand_<?php echo $tweet_id;?>" style="text-decoration:none; color:#B0B0B0; padding:5px; margin-right:8px; float:left;">Expand</a>
        				<a href="javascript:HideTweets('<?php echo $tweet_id;?>');" id="view_collapse_<?php echo $tweet_id;?>" style="text-decoration:none; display:none; color:#B0B0B0; padding:5px; margin-right:8px; float:left;">Collapse</a>
        			<a href="javascript:showTweets('<?php echo $tweet_id;?>');" style="text-decoration:none; color:#B0B0B0; padding:5px; margin-right:8px; float:left;">Reply</a>
                    
                <?php $flage = false;
				foreach ($retweeted_tweets as $retweet__rows) {
				if ($tweet__Row['tweets']['id'] == $retweet__rows['tweets']['parent_id'] && $retweet__rows['tweets']['user_id'] == $uid) {  ?>
        	 <a id="retweeted_<?php echo $tweet_id;?>" style="text-decoration:none; color:#006FDD; padding:5px; margin-right:8px; float:left;">Retweeted</a>
            <?php $flage = true;
				}} 
			if ($flage == false) {?>
            <a href="javascript:showRetweet('<?php echo $tweet_id;?>')" id="retweet_<?php echo $tweet_id;?>" style="text-decoration:none; color:#B0B0B0; padding:5px; margin-right:8px; float:left;">Retweet</a>
            <?php }?>
           
            <a id="retweeted_<?php echo $tweet_id;?>" style="text-decoration:none; display:none; color:#006FDD; padding:5px; margin-right:8px; float:left;">Retweeted</a>
            
                         <div id="user_like_update_<?php echo $tweet_id;?>" style="float:left; width:56px; margin-right:7px;">
							<?php $flage = false; 
	 							foreach ($favorites_on_Tweet as $favorite_tweet_row)  {
									$user_id = $favorite_tweet_row['favorites']['user_id'];
									$content_id = $favorite_tweet_row['favorites']['content_id'];
                   				 	if ($tweet__Row['favorites']['favorite']==1 && $user_id == $u_id && $tweet__Row['favorites']['content_id'] == $content_id){?>
       									<a style="text-decoration:none; color:#FFA851; padding:5px; margin-right:8px; float:left;">Favorited</a>
                   				 <?php $flage = true;} } 
									if ($flage == false)  { ?>	
                    	<a href="javascript:favoriteTweet('<?php echo $tweet_id;?>','1');" style="text-decoration:none; color:#B0B0B0; padding:5px; margin-right:8px; float:left;">Favorite</a>
                    <?php }?>
                    </div>
                    <div id="expand_tweet_photo_<?php echo $tweet_id;?>" style="width:100%; margin-top:5px; height:auto; display:none; clear:both;">
                    	<?php echo $this->Html->image('/files/updates/'.$tweet__Row['tweets']['photo'],array('style'=>'width:350px; height:350px;'));?>
                    </div>
                    <div id="expand_tweet_<?php echo $tweet_id;?>" style="width:100%; margin-top:5px; height:auto; display:none; clear:both;">
                    	<div class="tweets-states-container">
									<a href="javascript:showTweetFavorite('<?php echo $tweet_id;?>')"><?php echo "Favorites : ".$tweet__Row[0]['total_favorites']; ?></a>
                                    <a href="javascript:showTweetRetweeted('<?php echo $tweet_id;?>')"><?php echo "Retweets : ".$retweets_counts; ?></a>
                         </div>
                    	<span style="color:#8B8B8B; font-size:12px;"><?php echo $today = date("F j, Y, g:i a"); ?></span>
                        <textarea id="tweet_reply_<?php echo $tweet_id;?>" name="data[Tweet][tweet_text]" onkeyup="countReply(this);" cols="55" rows="4" style="width:100%; height:35px; padding:8px; border:1px solid #ccc; margin-bottom:10px;" onClick="openReplayTweet('<?php echo $tweet_id;?>');" placeholder="Compose tweet reply.."></textarea>
                        <input type="hidden" id="user_id" value="<?php echo $u_id;?>" />
                        <input type="hidden" id="comment_type" value="tweets" />
                        <input type="hidden" id="created_<?php echo $tweet_id;?>" value="<?php echo $created = date("Y-m-d H:i:s");?>" />
                        <span id="tweetReplaybtn_<?php echo $tweet_id;?>" style="display:none;">
                         	<a href="javascript:tweet_replay('<?php echo $tweet_id;?>');" class="savebtn" style="float:right">Tweet</a>&nbsp;&nbsp;
                        	<span id="Reply_tweet_count" style="float:right;">113 characters</span>
                       	</span>
                        <!-- Comments listing start -->
                        <div id="span_<?php echo $tweet_id;?>">
                            <div class="postComments" style="width:460px; margin:10px 0px 0px 0px;">
                                <ul>
                                    <?php 
                                    foreach ($user_tweet_comments as $comms) {
										if ($comms['Tweet_comment']['content_id'] == $tweet__Row['tweets']['id']) {
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
		</div>
        <div id="loading" style="position:relative; text-align:center; display:none;"> 
           <?php echo $this->Html->image('loading.gif');?>
         </div>
		<!-- --share form for updates post start-->
		<div class="referel_pop" id="openEditWindow_<?php echo $tweet_id;?>" style="display:none; padding-bottom:15px; top:200px;">
			<div class="close_icon_row" style="width:480px;">
				<div class="close_icon_row_left" style="width:460px;">Retweet this to your followers </div><div class="close_icon" style="float:right;" onclick="close_RetweetWindow('<?php echo $tweet_id;?>')">
				</div>
			</div>
 			<div class="mini-form">
             <input type="hidden" name="user_id" id="user_id" value="<?php echo $u_id;?>" />
             <input type="hidden" name="photo" id="photo_<?php echo $tweet_id;?>" value="<?php echo $tweet__Row['tweets']['photo'];?>" />
              <input type="hidden" name="tweet" id="tweet_<?php echo $tweet_id;?>" value="<?php echo $tweet__Row['tweets']['tweet'];?>" />
             </div>
 	
 		<div class="view">
 			<?php if ($tweet__Row['users_profiles']['photo']){
						$user_id = $tweet__Row['users_profiles']['user_id'];
				echo $this->Html->image('/files/users/'.$tweet__Row['users_profiles']['photo'],array('url'=>array('controller'=>'connections','action'=>'connection_profile',$user_id),'style'=>'float:left; padding-right:4px; width:40px; height:40px;'));
					}	else {
 				echo $this->Html->image('user-icon.png',array('url'=>'/pub/'.$tweet__Row['users_profiles']['handler']),array(
																											 'style'=>'float:left; padding-right:4px; width:40px; height:40px;'));
					 }?>
			<div style="width:440px; float:left;">
				<h3 class="title"><?php echo $tweet__Row['users_profiles']['firstname']." ".$tweet__Row['users_profiles']['lastname'];?></h3>
    			<p class="meta"></p>
    			<p class="summary"><?php echo $tweet__Row['tweets']['tweet']?></p>
			</div>
            <a href="javascript:tweetToRetweet('<?php echo $tweet_id;?>');" class="savebtn" style="float:right;">Retweet</a>&nbsp;
            <a href="javascript:close_RetweetWindow('<?php echo $tweet_id;?>');" class="savebtn" style="float:right;">Cancel</a>
 
		</div>
	</div>
		<!-- --share form for shared post end-->
        <?php }?>
        <!-- Tweet favorite users Puopop-->
        <div class="referel_pop" id="openFavoriteWindow" style="display:none; padding-bottom:15px; top:200px; width:590px;">
        
        </div>
        
        <!-- Tweet Retweet users Puopop-->
        <div class="referel_pop" id="openRetweetWindow" style="display:none; padding-bottom:15px; top:200px; width:590px;">
        
        </div>
        
    </div>
</div>

<script>
function addTweet(user_id) {
//$('#edit_Recs').show();
alert(user_id);
 im = new Image();
    im.src = document.Tweet.photo.value;
if(!im.src)
    im.src = document.getElementById('myfile').value;
    alert(im.src);
	
var tweets = document.getElementById('twetarea').value;
var myfile = document.getElementById('myfile').value;
var status = document.getElementById('status').value;
$.ajax({
              url     : baseUrl+"/tweets/add_tweet",
              type    : "POST",
              cache   : false,
              data    : {user_id: user_id, myfile:myfile,tweets:tweets,status:status},
              success : function(data){
			  $("#result_from_ajax").html(data);
              },
			  error : function(data) {
           $("#result_from_ajax").html("there is error");
        }
          });	
}
function countChar(val) {
        var len = val.value.length;
        if (len >= 140) {
          val.value = val.value.substring(0, 140);
		  document.getElementById('twetarea').disabled = true;
        } else {
          $('#tweet_count').text(140 - len+' characters');
        }
      }
function countReply(val) {
        var len = val.value.length;
        if (len >= 115) {
          val.value = val.value.substring(0, 115);
		  document.getElementById('tweet_reply').disabled = true;
        } else {
          $('#Reply_tweet_count').text(115 - len+' characters');
        }
      }
function showTweets(tweet_id) {
	$("#expand_tweet_"+tweet_id).slideToggle('slow');
	$("#view_collapse_"+tweet_id).css({
            'display' : 'block'
        });
	$("#view_expand_"+tweet_id).css({
            'display' : 'none'
        });
}
function HideTweets(tweet_id) {
	$("#expand_tweet_"+tweet_id).slideToggle('slow');
	$("#view_expand_"+tweet_id).css({
            'display' : 'block'
        });
	$("#view_collapse_"+tweet_id).css({
            'display' : 'none'
        });
}
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
function user_tweets(user_id) {
	$('#loadings').show();
	$.ajax({
              url     : baseUrl+"/tweets/user_tweets",
              type    : "GET",
              cache   : false,
              data    : {user_id: user_id},
              success : function(data){
			  $("#result_from_ajax").html(data);
              },
     		 complete: function () {
      		 $('#loadings').hide();
                },
			  error : function(data) {
           $("#result_from_ajax").html("there is error");
        }
          });	
}
function user_following(user_id) {
	$('#loadings').show();
	$.ajax({
              url     : baseUrl+"/tweets/user_following",
              type    : "GET",
              cache   : false,
              data    : {user_id: user_id},
              success : function(data){
			  $("#result_from_ajax").html(data);
              },
     		 complete: function () {
      		 $('#loadings').hide();
                },
			  error : function(data) {
           $("#result_from_ajax").html("there is error");
        }
          });	
}
function user_followers(user_id) {
	$('#loadings').show();
	$.ajax({
              url     : baseUrl+"/tweets/user_followers",
              type    : "GET",
              cache   : false,
              data    : {user_id: user_id},
              success : function(data){
			  $("#result_from_ajax").html(data);
              },
     		 complete: function () {
      		 $('#loadings').hide();
                },
			  error : function(data) {
           $("#result_from_ajax").html("there is error");
        }
          });	
}
function tweet_replay(content_id) {
var user_id = document.getElementById('user_id').value;
var comment_type = document.getElementById('comment_type').value;
var created = document.getElementById('created_'+content_id).value;
var tweet_reply = document.getElementById('tweet_reply_'+content_id).value;
//alert(user_id+"and"+comment_type+"and"+content_id);
//return false;
$.ajax({
url     : baseUrl+"/tweets/add_tweet_replay",
type    : "GET",
cache   : false,
data    : {user_id: user_id,comment_type:comment_type,content_id:content_id,created:created,tweet_reply:tweet_reply},
success : function(data){
	//if (share == 1) {
$("#span_"+content_id).html(data);
$("#expand_tweet_"+content_id).slideUp('slow');
	//}
},
error : function(data) {
$("#span_"+content_id).html(data);
}
});
}
function favoriteTweet(tweet_id,favorite) {
var user_id = document.getElementById('user_id').value;
//alert(tweet_id+"and"+favorite+"and"+user_id);
$.ajax({
url     : baseUrl+"/tweets/add_favorite",
type    : "GET",
cache   : false,
data    : {user_id: user_id,content_id:tweet_id,favorite:favorite},
success : function(data){	
//$(this).css('background','none');
//$("#alike"+commentid).css('display','none');
//$("#likediv"+commentid).css('display','block');
$("#user_like_update_"+tweet_id).html(data);
},
error : function(data) {
$("#user_like_update_"+tweet_id).html("there is error");
}
});	
}

function showRetweet(tweet_id) {
$('#loadings').show();
document.getElementById('fade').style.display = 'block';
document.getElementById('openEditWindow_'+tweet_id).style.display = 'block';
 $('#loadings').hide();
}
function close_RetweetWindow(tweet_id) {
document.getElementById('fade').style.display = 'none';
document.getElementById('openEditWindow_'+tweet_id).style.display = 'none';
}
function tweetToRetweet(tweet_id) {
	var user_id = document.getElementById('user_id').value;
	var photo = document.getElementById('photo_'+tweet_id).value;
	var tweet = document.getElementById('tweet_'+tweet_id).value;
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
			  document.getElementById('fade').style.display = 'none';
			  document.getElementById('openEditWindow_'+tweet_id).style.display = 'none';
              },
     		 complete: function () {
      		 $('#loadings').hide();
                },
			  error : function(data) {
           $("#retweeted_"+tweet_id).html("there is error");
        }
          });		
}
function close_PopUp_Favorite(tweet_id) {
document.getElementById('fade').style.display = 'none';
document.getElementById('openFavoriteWindow').style.display = 'none';
}
function close_PopUp_Retweet(tweet_id) {
document.getElementById('fade').style.display = 'none';
document.getElementById('openRetweetWindow').style.display = 'none';
}
/*show tweet favorites*/
function showTweetFavorite(tweet_id) {
	$('#loadings').show();
	document.getElementById('fade').style.display = 'block';
	document.getElementById('openFavoriteWindow').style.display = 'block';
	$.ajax({
              url     : baseUrl+"/tweets/tweet_favorite_users",
              type    : "POST",
              cache   : false,
              data    : {tweet_id:tweet_id},
              success : function(data){
			  $("#openFavoriteWindow").html(data);
              },
     		 complete: function () {
      		 $('#loadings').hide();
                },
			  error : function(data) {
           $("#openFavoriteWindow").html("there is error");
        }
          });
}
function showTweetRetweeted(tweet_id) {
	document.getElementById('fade').style.display = 'block';
	document.getElementById('openRetweetWindow').style.display = 'block';
	
	$('#loadings').show();
	$.ajax({
              url     : baseUrl+"/tweets/tweet_retweet_users",
              type    : "POST",
              cache   : false,
              data    : {tweet_id:tweet_id},
              success : function(data){
			  $("#openRetweetWindow").html(data);
              },
     		 complete: function () {
      		 $('#loadings').hide();
                },
			  error : function(data) {
           $("#openRetweetWindow").html("there is error");
        }
          });
}
</script>