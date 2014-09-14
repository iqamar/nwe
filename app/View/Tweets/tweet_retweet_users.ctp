<div class="close_icon_row" style="width:567px;">
				<div class="close_icon_row_left" style="width:548px;">Retweeted by users </div><div class="close_icon" style="float:right;" onclick="close_PopUp_Retweet('<?php echo $tweet_id;?>')">
				</div>
			</div>
            <div style="clear:both; height:85px; padding:12px; margin-bottom:10px; background:#F4F4F4;">
              			<?php 
						foreach ($user_current_tweet as $tweet_Detail_Row){
							$tweet_id = $tweet_Detail_Row['Tweet']['id'];
							if ($tweet_Detail_Row['users_profiles']['photo']) {
							echo $this->Html->image('/files/users/'.$tweet_Detail_Row['users_profiles']['photo'],array('url'=>array('controller'=>'connections','action'=>'connection_profile',$user_id),'style'=>'float:left; padding-right:4px; width:40px; height:40px;'));
							}	
							else {
 				echo $this->Html->image('user-icon.png',array('url'=>array('controller'=>'connections','action'=>'connection_profile',$user_id),'style'=>'float:left; padding-right:4px; width:40px; height:40px;'));
							 }?>
				<div style="width:495px; float:left; margin-left:5px;">
					<h3 style="font-size:15px; font-weight:bold; color:#333;">
					<?php echo $tweet_Detail_Row['users_profiles']['firstname']." ".$tweet_Detail_Row['users_profiles']['lastname'];?>
                    <?php if ($tweet_Detail_Row['users_profiles']['handler']) {?>
                    <span style="font-size:12px; color:#8D8D8D;">
                    <?php echo " @".$tweet_Detail_Row['users_profiles']['handler'];?>
                    </span>	<?php }?></h3>
    				<p class="meta"></p>
    				<p class="summary"><?php echo $tweet_Detail_Row['Tweet']['tweet']?></p>
				</div>
             </div>
             <?php }?>
 			<div style="overflow:auto; height:350px; width:100%;">
            <div id="loading" style="position:relative; text-align:center; display:none;"> 
           <?php echo $this->Html->image('loading.gif');?>
         	</div>
 			<?php foreach ($user_retweet_tweets as $user_retweet_row) {
						$user_id = $user_retweet_row['users_profiles']['user_id']; ?>
						<div style="clear:both; height:60px; padding:12px; margin-bottom:5px; border: 1px dashed #ccc;">
						<?php if ($user_retweet_row['users_profiles']['photo']){
							echo $this->Html->image('/files/users/'.$user_retweet_row['users_profiles']['photo'],array(
							'url'=>array('controller'=>'connections','action'=>'connection_profile',$user_id),'style'=>'float:left; padding-right:4px; width:40px; height:40px;'));
						}	else {
 								echo $this->Html->image('user-icon.png',array(
							'url'=>array('controller'=>'connections','action'=>'connection_profile',$user_id),'style'=>'float:left; padding-right:4px; width:40px; height:40px;'));
							 }?>
							<div style="width:415px; float:left; margin-left:5px;">
								<h3 style="font-size:12px; font-weight:bold; color:#333;">
									<?php echo $user_retweet_row['users_profiles']['firstname']." ".$user_retweet_row['users_profiles']['lastname'];?>
                   					 <?php if ($user_retweet_row['users_profiles']['handler']) {?>
                    				<span style="font-size:12px; color:#8D8D8D;">
                    					<?php echo " @".$user_retweet_row['users_profiles']['handler'];?>
                   					 </span>	<?php }?>
                               </h3>
                               <?php $followers_counts = ''; $j = 1; 
								 foreach ($user_following as $followers__rows) {
			if ($followers__rows['Users_following']['following_id'] == $user_retweet_row['users_profiles']['user_id'] && $followers__rows['Users_following']['status'] ==2) { 
										$followers_counts += $j;
										$j++; }
								} ?>
    							<p class="summary"><?php if ($j>0) { echo $j." followers"; } ?></p>
							</div>

           			  </div>
            <?php }  ////loop end here ?> 
            </div>
            <a href="javascript:close_PopUp_Retweet('<?php echo $tweet_id;?>');" class="savebtn" style="float:right;">Cancel</a>