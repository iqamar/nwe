<div class="box">
	<div class="tab-container" id="tab-container" data-easytabs="true">
		<ul class="etabs">
			<li class="tab active"><a href="#" class="active">Your Groups</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/" >Following</a></li>	
			 <li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/search">Search Group</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/add/">Add Group</a></li>
		</ul>
		<div class="panel-container">
			<div id="tabs1" style="display: block;" class="active">  
				<?php if ($this->params['named']['mesg'] !=''){ ?>
					<div id="global-error">
    					<div class="alert success">
						<?php
							$mesg = $this->params['named']['mesg']; 
							echo $mesg;
						?>
         				</div>
     				 </div>
     			<?php  }?>
          
				<?php 
                if ($groupListing) {
                $idx=1;
                foreach ($groupListing as $group) { 
                $groupID = $group['groups']['id'];
                $users_following_id = $group['users_followings']['id'];
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
                </ul>
                <div class="clear"></div>
            </div>
            <?php }}?>
  
			<input type="hidden" name="start_date" id="start_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
			<input type="hidden" name="end_date" id="end_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
			<div class="clear"></div>


		</div>
     </div>
   </div>
 </div>

      
