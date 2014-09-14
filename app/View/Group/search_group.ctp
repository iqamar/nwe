<?php if ($comResult) {
		foreach ($comResult as $group) {
			$groupID = $group['groups']['id'];
			$grouptitle = strtolower($group['groups']['title']);
			$grouptitle = str_replace(' ', '-', $grouptitle);
			?>

		<div class="profile-group">
                      <div class="profile-group-logo">
                          <a href="#">
                            <?php 
                                if (!empty($group['groups']['logo'])) {
									if (file_exists(MEDIA_PATH.'/files/group/logo/'.$group['groups']['logo'])) {
                                   		 echo $this->Html->image(MEDIA_URL.'/files/group/logo/'.$group['groups']['logo'],array('url'=>array(
                                                                                                                                       'controller'=>'groups',
                                                                                                                                       'action'=>'view',$groupID,$grouptitle),
                                                                                                                          'alt'=>'no-img'));
									}
									else {
										 echo $this->Html->image(MEDIA_URL.'/img/no_group_photo.jpg',array('url'=>array(
                                                                                                           'controller'=>'groups',
                                                                                                           'action'=>'view',$groupID,$grouptitle),
                                                                                            'alt'=>'no-img'));
									}
                                }else {
                                    echo $this->Html->image(MEDIA_URL.'/img/no_group_photo.jpg',array('url'=>array(
                                                                                                           'controller'=>'groups',
                                                                                                           'action'=>'view',$groupID,$grouptitle),
                                                                                            'alt'=>'no-img'));
                                }
                            ?>
                          </a>
                      </div>
                      <ul>
                        <li>
                            <?php echo $this->Html->link($group['groups']['title'],array('controller'=>'groups','action'=>'view',$groupID,$grouptitle),array());?>
                        </li>
                        <li><?php echo $group['groups_types']['title'];?></li>
                        <li>   <?php foreach ($loggeduers_following_groups as $logged_user_group) {
                                            $my_following_id = $logged_user_group['users_followings']['following_id'];
                                            $my_user_follow_id = $logged_user_group['users_followings']['id'];
                                    if ($groupID == $my_following_id) {
                                ?>
                                      <?php if ($logged_user_group['users_followings']['status']== 0 && $logged_user_group['users_followings']['user_id']==$uid) {?>
                            <span id="follow_<?php echo $companyID;?>">
                                <a href="Javascript:followingTheGroup('<?php echo $groupID?>','<?php echo $uid?>','2','<?php echo $my_user_follow_id ?>')" class="join" >Join</a>
                            </span>
                            <?php  $flag = true; break;}?>
                            <?php if ($logged_user_group['users_followings']['status']==2 && $logged_user_group['users_followings']['user_id']==$uid) { ?>
                            <span>
                                 <?php echo $this->Html->link('View',array('controller'=>'groups','action'=>'view',$groupID,$grouptitle), array('class'=>'join'));?>
                            </span>
                            <?php $flag = true; break; }?>
                            <?php if ($logged_user_group['users_followings']['status']==1 && $logged_user_group['users_followings']['user_id']==$uid) { ?>
                            <span>
                                 <?php echo $this->Html->link('Approval Pending',array('controller'=>'groups','action'=>'view',$groupID,$grouptitle),
                                                                                                  array('class'=>'waiting_approval'));?>
                            </span>
                            <?php $flag = true; break; }?>
                            <?php }}?>
                            <?php if ($flag == false) { ?>
                            <span id="follow_<?php echo $groupID;?>">
                                <a href="Javascript:followingTheGroup('<?php echo $groupID?>','<?php echo $uid?>','2','')" class="join">Join</a>
                            </span>
                            <?php }?>   
                          </li>
                      </ul>
                 </div>

			
<?php }}?>