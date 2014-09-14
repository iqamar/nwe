
<style type="text/css">
.myclass { display:none;}

</style>
<script type="text/javascript">
function showClick(ids) {
	window.location="http://demo.networkwe.com/users_profiles/userprofile/"+ids;
	/*$.ajax({
              url     : baseUrl+"/users_profiles/userprofile",
              type    : "POST",
              cache   : false,
              data    : {ids: ids},
              success : function(data){
			  $("#span_user").html(data);
              },
			  error : function(data) {
           $("#span_user").html("there is error");
        }
          });*/
}
</script>

<script type="text/javascript">
function show_div(){
	$('#notifylist').addClass('menu-active');
	 $("#notifylist").show("slow"); 
}
function close_notify(){
	$('#notifylist').addClass('');
	 $("#notifylist").hide("slow"); 
}
function showSubMenus(){
	$("#account_Menus").show("slow");
	return true;
}
function hideSubMenus(){
	$("#account_Menus").hide("slow");
	return true;
}
</script>
<ul id="gn-menu" class="gn-menu-main" >
<!--
				<li class="gn-trigger">
					<a class="gn-icon gn-icon-menu"><span>Menu</span></a>
					<nav class="gn-menu-wrapper" style="z-index: 1000;">
						<div class="gn-scroller">
							<ul class="gn-menu">
								<li class="gn-search-item">
									<input placeholder="Search here..." type="search" class="gn-search" ><input type="submit" value="Go" style="background: burlywood;border-radius: 10px 10px 10px 10px;  height: 35px; margin-left: 10px; padding: 5px; width: 70px;">
									<a class="gn-icon gn-icon-search"><span>Search</span></a>
								</li>
                                <li>
									<a class="gn-icon gn-icon-profile">Profiles</a>
									<ul class="gn-submenu">
										<li><a class="gn-icon gn-icon-edit">Edit Your Profile</a></li>
										<li><a class="gn-icon gn-icon-view">Who's viewed your profile</a></li>
									</ul>
								</li>
                             
								<li>
									<a class="gn-icon gn-icon-connection">Connections</a>
									<ul class="gn-submenu">
                                    	<li><a class="gn-icon gn-icon-contact">Contacts</a></li>
										<li><a class="gn-icon gn-icon-add">Add Connections</a></li>
										<li><a class="gn-icon gn-icon-invite">Invite Contacts</a></li>
                                        <li><a class="gn-icon gn-icon-import">Import Contacts</a></li>
									</ul>
								</li>
								<li><a class="gn-icon gn-icon-setting">Settings</a></li>
								<li><a class="gn-icon gn-icon-help" target="_blank">Help</a></li>
								
							</ul>
						</div>
					</nav>
				</li>-->
				<li><a href="/"><img src="http://demo.networkwe.com/img/logo.png" style="height:30px; margin-top: -5px;"></a></li>
                <li>
				<?php echo $this->Html->link(__('Home'), array('plugin' => false, 'admin' => false, 'controller' => 'home', 'action' => 'index')); ?>
				</li>
                <li>
				<?php echo $this->Html->link(__('Profile'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'myprofile')); ?>
				</li>
				<li><?php echo $this->Html->link(__('Connections'), array('plugin' => false, 'admin' => false, 'controller' => 'connections', 'action' => 'index')); ?></a></li>
                <li><?php echo $this->Html->link(__('Tweets'), array('plugin' => false, 'admin' => false, 'controller' => 'tweets', 'action' => 'index')); ?></a></li>
                 <li>
				<?php echo $this->Html->link(__('Jobs'), 'http://jobs.networkwe.com/',array('target'=>'blank')); ?>
				</li> 
                <li>
				<?php echo $this->Html->link(__('Companies'), array('plugin' => false, 'admin' => false, 'controller' => 'companies', 'action' => 'search')); ?>
				</li> 
                <li>
				<?php echo $this->Html->link(__('Groups'), array('plugin' => false, 'admin' => false, 'controller' => 'groups', 'action' => 'search')); ?>
				</li> 
               <!--<li>
				<?php echo $this->Html->link(__('Contacts'), array('plugin' => false, 'admin' => false, 'controller' => 'contacts', 'action' => 'yahoo_show')); ?>
				</li> 
				-->
                <!--<li><input placeholder="Search" type="search" class="gn-search"><a class="gn-icon gn-icon-search"><span>Search</span></a></li>-->
				
				<li class="profile_link" onmouseover="document.getElementById('account_Menus').style.visibility = 'visible'" onmouseout="document.getElementById('account_Menus').style.visibility = 'hidden'">
				<?php if ($imgname) {
				echo $this->Html->image('/files/users/'.$imgname,array('url'=>'/users_profiles/myprofile','style'=>'width:30px; height:30px; cursor:pointer;',' onmouseover'=>'return showSubMenus();'));
				}
				else { 
				echo $this->Html->image('no-image.png',array('url'=>'/users_profiles/myprofile','style'=>'width:30px; height:30px; cursor:pointer;',' onmouseover'=>'return showSubMenus();'));
				}?>
                
                <div class="account-sub-nav" style="display:none;" id="account_Menus" onmouseout="this.style.visibility = 'hidden'">
                	<div class="account-sub-nav-options">
                    	<div class="activity-drop-header">
                        	<h3>Account Settings ></h3>
                            <?php 
							if ($user_Profile) {
								$user_Full_Name = $user_Profile['firstname']." ".$user_Profile['lastname'];
							}
							?>
                        </div>
                        <div class="account-sub-nav-body">
                        	<ul class="account-settings">
                            	<li>
                                	<div class="account-settings-link">
                                    	<span class="act-set-row">
                                        	<span class="act-set-icon">
											<?php echo $this->Html->image('/files/users/'.$imgname,array('url'=>'/users/logout','style'=>'width:20px; height:20px; cursor:pointer;')); ?>
                                            </span>
                                            <span class="act-set-name">
                                            <?php echo $this->Html->link($user_Full_Name,array('controller'=>'users','action'=>'logout'),array('style'=>'cursor:pointer;')); ?>
                                            </span>
                                            <span class="act-set-action">
                                             <?php echo $this->Html->link(__('Sign Out'),array('controller'=>'users','action'=>'logout'),array('style'=>'cursor:pointer;')); ?>
                                            </span>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                	<div class="account-settings-link">
                                    	<span class="act-set-row">
                                        	<span class="act-set-icon account-icon">
                                            </span>
                                            <span class="act-set-name">
                                            <?php echo $this->Html->link(__('Account Basic'),array('controller'=>'users_profiles','action'=>'profile'),array('style'=>'cursor:pointer;')); ?>
                                            </span>
                                            <span class="act-set-action">
                                             <?php echo $this->Html->link(__('Upgrade'),array('controller'=>'users_profiles','action'=>'profile'),array('style'=>'cursor:pointer;')); ?>
                                            </span>
                                        </span>
                                    </div>
                              </li>
                              <li>
                                	<div class="account-settings-link">
                                    	<span class="act-set-row">
                                        	<span class="act-set-icon privacy-icon">
                                            </span>
                                            <span class="act-set-name">
                                            <?php echo $this->Html->link(__('Privacy & Setting'),array('controller'=>'users_profiles','action'=>'privacy'),array('style'=>'cursor:pointer;')); ?>
                                            </span>
                                            <span class="act-set-action">
                                             <?php echo $this->Html->link(__('Review'),array('controller'=>'users_profiles','action'=>'review'),array('style'=>'cursor:pointer;')); ?>
                                            </span>
                                        </span>
                                    </div>
                              </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
				</li>   
 <li style="float: right; margin-right:16px;" class="notify" onmouseover ="document.getElementById('notificationMenus').style.display = 'block'" onmouseout="document.getElementById('notificationMenus').style.display = 'none'">
				<span style="cursor:pointer;"><?php  if($usernotification > 0 ){ echo '<div id="home-menu" onclick="show_div()">'.$usernotification.'</div>';}?></span>				
         <div class="account-sub-nav" style="display:none; right:104px;" id="notificationMenus" onmouseout="this.style.display = 'none'">
                	<div class="account-sub-nav-options">
                    	<div class="activity-drop-header">
                        	<h3>Notifications ></h3>
                        </div>
                        <div class="account-sub-nav-body">
                        	<ul class="account-settings">
                            <?php 
								if ($this->Session->read(@$userid)){
								$userary = $this->Session->read(@$userid);
								
									if ($requserss){
										$count = sizeof($uSc);
										foreach ($requserss as $requser) { 
												
											?>
                            	<li class="update">
                                	<div class="account-settings-link" style="padding-bottom:10px;">
                                    	<span class="act-set-row" style="width:280px;">
                                        	<span class="photo">
                                            <?php if ($requser['users_profiles']['photo']) {
		echo $this->Html->image('/files/users/'.$requser['users_profiles']['photo'],array('url'=>'/connections/connection_profile/'.$requser['users_profiles']['user_id'],'style'=>'width:40px; height:40px; cursor:pointer;')); 			
											} else {
												echo $this->Html->image('no-image.png',array('style'=>'width:40px; height:40px;'));
											}
											?>
                                            </span>
                                            <span class="action">
                                            	<span class="name">
                                                <?php if ($requser['users_profiles']['firstname']) {
                                                echo '<strong>'.$requser['users_profiles']['firstname']." ".$requser['users_profiles']['lastname'].'</strong><br />';
												echo $requser['users_profiles']['tags'];
												}else {
													echo '<span>'.$requser['users']['email'].'</span>';
												}?>
												</span>
                                                <?php if ($requser['connections']['request'] == 0) {?>
                                                <span style="text-align:right;">
            		 							 <form name="userConfirm" action="/connections/updateConnection" method="post">
                                                    <input type="hidden" name="user_id" value="<?php echo $requser['users']['id'];?>" />
                                                    <input type="hidden" name="friend_id" value="<?php echo $userary['userid'];?>" />
                                                    <input type="submit" name="confirm" value="Confirm" class="button-accept" />
                                                 </form>
                                               	 </span> 
                                                 <?php } else{ 
												 				echo "<strong>is now a connection</strong>";
												 }?>
                                                </span>
                                            </span>
                                            <span class="act-set-action" style="width:33px;">
                                             <?php 
											 $now_date = strtotime(date('Y-m-d'));
											 $postDate = strtotime($requser['connections']['created']);
											 if ($postDate) {
											 $diff = $now_date-$postDate;
											 $days = floor(($now_date-$postDate)/(86400));
											 if ($days<=1){
												 $hours   = floor(($diff-($days*60*60*24))/(60*60));
												 echo $hours."h";
											 }
											 else {
												 echo $days."d";
											 }
											 }
											 //echo $days;
											 ?>
                                            </span>
                                        </span>
                                    </div>
                                </li><?php }}} ?> <!-- Session check end -->

                                         <?php 
								if ($this->Session->read(@$userid)){
								$userary = $this->Session->read(@$userid);
								
									if ($chat_User_Requsers){
										$count = sizeof($chat_User_Requsers);
										foreach ($chat_User_Requsers as $chatRequset) { 
						
											?>
                            	<li class="update">
                                	<div class="account-settings-link" style="padding-bottom:10px;">
                                    	<span class="act-set-row" style="width:280px;">
                                        	<span class="photo">
                                            <?php if ($chatRequset['users_profiles']['photo']) {
		echo $this->Html->image('/files/users/'.$chatRequset['users_profiles']['photo'],array('url'=>'/connections/connection_profile/'.$chatRequset['users_profiles']['user_id'],'style'=>'width:40px; height:40px; cursor:pointer;')); 			
											} else {
												echo $this->Html->image('no-image.png',array('style'=>'width:40px; height:40px;'));
											}
											?>
                                            </span>
                                            <span class="action">
                                            	<span class="name">
                                                <?php if ($chatRequset['users_profiles']['firstname']) {
                                                echo '<strong>'.$chatRequset['users_profiles']['firstname']." ".$chatRequset['users_profiles']['lastname'].'</strong><br />';
												echo "<strong>is inviting you for chat.</strong>";
												}else {
													echo '<span>'.$chatRequset['users']['email'].'</span>';
												}?>
												</span>
                                                <?php if ($chatRequset['cometchat_friends']['status'] == 0) {?>
                                                <span style="text-align:right;">
            		 							 <form name="userConfirm" action="/users_profiles/chat_invitation" method="post">
                                                    <input type="hidden" name="invite_id" value="<?php echo $chatRequset['cometchat_friends']['id'];?>" />
                                                     <input type="hidden" name="accept_date" value="<?php echo $dt = date('Y-m-d h:i:s');?>" />
                                                    <input type="submit" name="confirm" value="Accept" class="button-accept" style="" />
                                                 </form>
                                               	 </span> 
                                                 <?php } ?>
                                                </span>
                                            </span>
                                            <span class="act-set-action" style="width:33px;">
                                             <?php 
											 $now_date = strtotime(date('Y-m-d'));
											$postDate = strtotime($chatRequset['cometchat_friends']['invite_date']);
											if ($postDate) {
											 $diff = $now_date-$postDate;
											 $days = floor(($now_date-$postDate)/(86400));
											 if ($days<=1){
												 $hours   = floor(($diff-($days*60*60*24))/(60*60));
												 echo $hours."h";
											 }
											 else {
												 echo $days."d";
											 }
											}
											 //echo $days;
											 ?>
                                            </span>
                                        </span>
                                    </div>
                                </li><?php }}} ?> <!-- Session check end -->
                                
                                <!-- Notification of user skill recommendation -->
                                <?php 
								if ($this->Session->read(@$userid)){
								$userary = $this->Session->read(@$userid);
								
									if ($skills_Recommended_for_User){
										$count = sizeof($skills_Recommended_for_User);
										foreach ($skills_Recommended_for_User as $skill_Recommended_row) { 
						
											?>
                            	<li class="update">
                                	<div class="account-settings-link" style="padding-bottom:10px;">
                                    	<span class="act-set-row" style="width:280px;">
                                        	<span class="photo">
                                            <?php if ($skill_Recommended_row['users_profiles']['photo']) {
		echo $this->Html->image('/files/users/'.$skill_Recommended_row['users_profiles']['photo'],array('url'=>'/connections/connection_profile/'.$skill_Recommended_row['users_profiles']['user_id'],'style'=>'width:40px; height:40px; cursor:pointer;')); 			
											} else {
												echo $this->Html->image('no-image.png',array('style'=>'width:40px; height:40px;'));
											}
											?>
                                            </span>
                                            <span class="action">
                                            	<span class="name">
                                                <?php if ($skill_Recommended_row['users_profiles']['firstname']) {
                                              echo '<strong>'.$skill_Recommended_row['users_profiles']['firstname']." ".$skill_Recommended_row['users_profiles']['lastname'].'</strong><br />';
												echo " recommended you for a skill <strong>".$skill_Recommended_row['skills']['title']."</strong>";
												}else {
													echo '<span>'.$skill_Recommended_row['users']['email'].'</span>';
												}?>
												</span>
                                                </span>
                                           </span>
                                            <span class="act-set-action" style="width:33px;">
                                             <?php 
											 $now_date = strtotime(date('Y-m-d'));
											$postDate = strtotime($skill_Recommended_row['skill_recommendations']['start_date']);
											if ($postDate) {
											 $diff = $now_date-$postDate;
											 $days = floor(($now_date-$postDate)/(86400));
											 if ($days<=1){
												 $hours   = floor(($diff-($days*60*60*24))/(60*60));
												 echo $hours."h";
											 }
											 else {
												 echo $days."d";
											 }
											}
											 //echo $days;
											 ?>
                                            
                                        </span>
                                    </div>
                                </li><?php }}} ?> <!-- skill end -->
                                
                             <!-- Notification of user congrates messages -->
                                <?php 
								if ($this->Session->read(@$userid)){
								$userary = $this->Session->read(@$userid);
								
									if ($get_total_congrates_messages){
										$count = sizeof($get_total_congrates_messages);
										if ($count ==1){
											foreach ($get_total_congrates_messages as $congrates_message_row) { 
										
											?>
                            	<li class="update">
                                	<div class="account-settings-link" style="padding-bottom:10px;">
                                    	<span class="act-set-row" style="width:280px;">
                                        	<span class="photo">
                                            <?php if ($congrates_message_row['users_profiles']['photo']) {
		echo $this->Html->image('/files/users/'.$congrates_message_row['users_profiles']['photo'],array('url'=>'/connections/connection_profile/'.$congrates_message_row['users_profiles']['user_id'],'style'=>'width:40px; height:40px; cursor:pointer;')); 			
											} else {
												echo $this->Html->image('user-icon.png',array('style'=>'width:40px; height:40px;'));
											}
											?>
                                            </span>
                                            <span class="action">
                                            	<span class="name">
                                                <?php if ($congrates_message_row['users_profiles']['firstname']) {
                                              echo '<strong>'.$congrates_message_row['users_profiles']['firstname']." ".$congrates_message_row['users_profiles']['lastname'].'</strong><br />';
												echo " send you a congrates message on your new job";
												}else {
													echo '<span>'.$congrates_message_row['users']['email'].'</span>';
												}?>
												</span>
                                                </span>
                                           </span>
                                            <span class="act-set-action" style="width:33px;">
                                             <?php 
											 $now_date = strtotime(date('Y-m-d H:i:s'));
											$postDate = strtotime($congrates_message_row['users_messages']['created']);
											if ($postDate) {
											 $diff = $now_date-$postDate;
											 $days = floor(($now_date-$postDate)/(86400));
											 if ($days<=1){
												 $hours   = floor(($diff-($days*60*60*24))/(60*60));
												 echo $hours."h";
											 }
											 else {
												 echo $days."d";
											 }
											}
											 //echo $days;
											 ?>
                                            
                                        </span>
                                    </div>
                                </li>
								<?php }} else { ?>
									
                                <li class="update">
                                	<div class="account-settings-link" style="padding-bottom:10px;">
                                    	<span class="act-set-row" style="width:280px; color:#333; font-weight:bold; font-size:12px;">
                                        <?php 
										echo $count." people send you congrates on your new job";
										foreach ($get_total_congrates_messages as $congrates_message_row) { ?>
                                        	<span class="photo" style="width:40px;">
                                          <?php  if ($congrates_message_row['users_profiles']['photo']) {
		echo $this->Html->image('/files/users/'.$congrates_message_row['users_profiles']['photo'],array('url'=>'/users_messages/view/','style'=>'width:35px; height:35px; cursor:pointer;')); 			
											} else {
												echo $this->Html->image('user-icon.png',array('style'=>'width:35px; height:35px;'));
											}
											?>
                                            </span>
                                            <?php }?>
                                            
                                           </span>
                                            <span class="act-set-action" style="width:33px;">
                                             <?php 
											 $now_date = strtotime(date('Y-m-d H:i:s'));
											$postDate = strtotime($congrates_message_row['users_messages']['created']);
											if ($postDate) {
											 $diff = $now_date-$postDate;
											 $days = floor(($now_date-$postDate)/(86400));
											 if ($days<=1){
												 $hours   = floor(($diff-($days*60*60*24))/(60*60));
												 echo $hours."h";
											 }
											 else {
												 echo $days."d";
											 }
											}
											 //echo $days;
											 ?>
                                            
                                        </span>
                                    </div>
                                </li>
								<?php }}} ?> <!-- congrates  end -->
                                
                              </ul>
                            </div>
                           </div>
                         </div>
                </li>
    
				<li style="margin-right:16px;">
					<div class="cont-inptbtn">
					    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                       <input type="text" class="srh-icon ui-autocomplete-input" placeholder="Search people ..." name="search_str" id="search_str" onkeypress="showPeopleUser(this.value);" />
                       <div id="result_user" style="width:300px;">
                        
                       </div> 
				    </div>
				</li>

			</ul>
        <div id="notifylist" style="display:none;">
            <ul>
      <?php 
			if ($this->Session->read(@$userid)){
			$userary = $this->Session->read(@$userid);
			}
			if ($requsers){
				$count = sizeof($uSc);
			foreach ($requsers as $requser) { 
			if ($count !=0) {
			?>
          	  <li>
            <?php if ($requser['users_profiles']['photo']) {?>
            <img src="<?php echo $this->base;?>/files/users/<?php echo $requser['users_profiles']['photo']?>" width="25" height="25" alt="<?php echo $requser['users_profiles']['firstname'];?>" />
            <?php } else {?>
            <img src="<?php echo $this->base;?>/img/no-image.png" width="25" height="25" alt="no image" />
            <?php } if ($requser['users']['firstname']) {?>
            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $requser['users_profiles']['firstname']." ".$requser['users_profiles']['lastname'];
			} else {
				echo $requser['users']['email'];
			}
			?>
					<span style="text-align:right;">
            		  <form name="userConfirm" action="/connections/updateConnection" method="post">
           				<input type="hidden" name="user_id" value="<?php echo $requser['users']['id'];?>" />
            			<input type="hidden" name="friend_id" value="<?php echo $userary['userid'];?>" />
            			<input type="submit" name="confirm" value="Confirm" class="button-primary" />
    				  </form>
            		</span> 
              </li>	
              
			  <?php }}} ?>

            </ul>
            <div id="notify-text">
            <a href="#">See all notifications</a>
            <div onclick="close_notify();" style="float:right;"><a href="#">x</a></div>
            </div>
       </div>