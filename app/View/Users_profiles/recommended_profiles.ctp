<?php foreach ($recommend_Users_for_skill as $user_skill_row) { ?>                                                                 
<div class="wholike">
              <div class="wholike-pic">
              <a href="#">
              <?php 
			  if ($user_skill_row['users_profiles']['photo']) {
			  	echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$user_skill_row['users_profiles']['photo'], array('style'=>''));
			  } 
			  else {
				 echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg', array('style'=>'')); 
			  }
				?>
                </a>
                </div>
              <div class="wholike-rgt">
                  <ul>
                      <li>
                          <h1>
						  <?php 
							echo $user_skill_row['users_profiles']['firstname']." ". $user_skill_row['users_profiles']['lastname'];
							?>
                          	<?php if ($user_skill_row['users_profiles']['user_id'] != $uid) {
				 					echo $this->Html->link("@".$user_skill_row['users_profiles']['handler'],
																			  array('controller'=>'pub','action'=>$user_skill_row['users_profiles']['handler']),
																			  array('style'=>''));
				 					}
									else {
									echo $this->Html->link("@".$user_skill_row['users_profiles']['handler'],
																								 array('controller'=>'users_profiles','action'=>'myprofile'),
																								 array('style'=>''));
						}
				 ?>	
                          </h1>
                      </li>
                      <li><?php echo $user_skill_row['users_profiles']['tags'];?></li>
                  </ul>
              </div>
     <div class="clear"></div>
</div>
 <?php }?>