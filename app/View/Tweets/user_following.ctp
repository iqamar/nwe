<div class="heading"><h1>User Following</h1></div>
	<?php foreach ($userFollowings as $tweet__Row) {
			$user_following_id = $tweet__Row['users_followings']['id'];
			$u_id = $tweet__Row['users_profiles']['user_id'];
			?>
            <div class="tweets">
                <div class="tweetuser-pic">
                   <?php  if ($tweet__Row['users_profiles']['photo']) {
                    echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$tweet__Row['users_profiles']['photo'],array('url'=>'/pub/'.$tweet__Row['users_profiles']['handler']));
                    }
                    else {
                        echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>''));	
                    }
                    ?>
                </div>
                <div class="tweets-rgt">
                    <ul>
                        <li>
                            <a href="/pub/<?php echo $tweet__Row['users_profiles']['handler'];?>" class="postwall-name">
                                <?php echo $tweet__Row['users_profiles']['firstname']." ".$tweet__Row['users_profiles']['lastname']?>
                            </a> 
                            <?php if($tweet__Row['users_profiles']['handler']){
                                    echo $this->Html->link("@".$tweet__Row['users_profiles']['handler'],array('controller'=>'tweets',
																										  'action'=>'profile',$u_id),
                                                                                                          array('style'=>''));	
                            }
                            ?>
                        </li>
                        <li><?php echo $tweet__Row['users_profiles']['tags'];?></li>
                      </ul>
                </div>            
			<div style="clear:both;"></div>	
		</div>
<?php }?>