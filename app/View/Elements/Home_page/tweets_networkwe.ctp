 <?php if ($get_tweets) {?>
<div class="greybox">
		  <div class="greybox-div-heading">
          
          <?php echo $this->Html->link('See All Tweets',array('controller'=>'tweets','action'=>'index'), array('class'=>'seeall2'));?>
			<h1>Tweets on NetworkWE</h1>
		</div>
        <?php 
		foreach ($get_tweets as $tweet__Row) {
					$tweet_id = $tweet__Row['tweets']['id'];
					$today = strtotime(date('Y-m-d H:i:s'));
					$distination = strtotime($tweet__Row['tweets']['created']);
					$difference = ($today - $distination);
					$days = floor($difference/(60*60*24));
					$hours = floor($difference/(60*60));
					$minutes = floor($difference/(60));
			?>
        <div class="rgtwidget-listing2">
				<div class="rgtwidget-listing2-logo">
					<a href="/users_profiles/userprofile/<?php echo $tweet__Row['users_profiles']['user_id']?>">
						<?php if ($tweet__Row['users_profiles']['photo']) {
									echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$tweet__Row['users_profiles']['photo'],array('alt'=>'NetworkWe'));
							  }
							  else { 	
									echo $this->Html->image(MEDIA_URL.'/img/defaultpic-female.jpg',array('style'=>'width:32px; height:32px;','alt'=>'post-img')); 
								}
					  ?> 
					</a>
				</div>
			<div class="rgtwidget-listing2-rgt">
				<ul>
					<li>
						<h1><?php echo $this->Html->link($tweet__Row['users_profiles']['firstname']." ".$tweet__Row['users_profiles']['lastname'],
																														  array(
																																'controller'=>'pub',
																																'action'=>$tweet__Row['users_profiles']['handler']
																																));
						?></h1>
					</li>
					<li style="word-wrap:break-word;"><?php echo strip_tags(substr($tweet__Row['tweets']['tweet'],0,62));?>
                     <input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
            		 <input type="hidden" name="photo" id="photo_<?php echo $tweet_id;?>" value="<?php echo $tweet__Row['tweets']['photo'];?>" />
              		 <input type="hidden" name="tweet" id="tweet_<?php echo $tweet_id;?>" value="<?php echo $tweet__Row['tweets']['tweet'];?>" />
                    </li>
					<li>
                    	<?php 
							$flage = false;
							foreach ($get_retweeted as $retweet__rows) {
								if ($tweet__Row['tweets']['id'] == $retweet__rows['tweets']['parent_id'] && $retweet__rows['tweets']['user_id'] == $uid) {  ?>
                                	<span id="retweeted_<?php echo $tweet_id;?>" class="redcolor">Retweeted</span>
                          <?php 
						  			$flage = true;
								}
							}?>
                            <?php if ($flage == false) {?>
                    				<a href="javascript:tweetToRetweet('<?php echo $tweet_id;?>');" id="retweet_<?php echo $tweet_id;?>" class="retweet">Retweet</a>
                        	<?php }?>
                            <span id="retweeted_<?php echo $tweet_id;?>" style="display:none; float:left;" class="redcolor">Retweeted</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <?php	
						if ($days >= 1){
							echo $this->Html->link("$days days ago",'/tweets',array('escape'=>false));
						}else{ 
							if($hours >=1){
								echo $this->Html->link("$hours hours ago",'/tweets',array('escape'=>false)); 
							}else{
								echo $this->Html->link("$minutes minutes ago",'/tweets',array('escape'=>false)); 
							}
						}
						?>
                    </li>
				</ul>
			</div>
        <div class="clear"></div>
        </div>
       <?php }?> 
</div>
<?php }?>
<script>
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