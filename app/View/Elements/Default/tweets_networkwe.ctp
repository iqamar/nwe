 <?php if ($latestTweets) {?>
<div class="greybox">
		  <div class="greybox-div-heading">
          
          <?php echo $this->Html->link('See All Tweets','#', array('class'=>'seeall2','onclick'=>'loadSharePopup();'));?>
			<h1>Tweets on NetworkWE</h1>
		</div>
        <?php 
		foreach ($latestTweets as $tweet__Row) {
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
					<?php 
					if ($tweet__Row['users_profiles']['photo']){
						if(file_exists(MEDIA_PATH.'/files/user/icon/'.$tweet__Row['users_profiles']['photo'])){
							$ustatus_photo=MEDIA_URL.'/files/user/icon/'.$tweet__Row['users_profiles']['photo'];
						}else{
							$ustatus_photo=MEDIA_URL.'/img/nophoto.jpg';
						}
					 }
					 else { 	
							$ustatus_photo=MEDIA_URL.'/img/nophoto.jpg'; 
					 }
					 echo $this->Html->image($ustatus_photo,array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$tweet__Row['users_profiles']['user_id'])));
					?>
						
					
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
							foreach ($relatestTweets as $retweet__rows) {
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