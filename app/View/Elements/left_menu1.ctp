
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

<style>

	
	a {
		color: #2A679F;
	}
	
	/* You don't need the above styles, they are demo-specific ----------- */
	
	#menu, #menu ul {
		margin: 0;
		padding: 0;
		list-style: none;
	}
	
	#menu {
		width: 100%;
		margin: 0px 0px;
		border: 1px solid #222;
		background-color: #111;
		background-image: -moz-linear-gradient(#444, #111); 
		background-image: -webkit-gradient(linear, left top, left bottom, from(#444), to(#111));	
		background-image: -webkit-linear-gradient(#444, #111);	
		background-image: -o-linear-gradient(#444, #111);
		background-image: -ms-linear-gradient(#444, #111);
		background-image: linear-gradient(#444, #111);
	/*	-moz-border-radius: 6px;
		-webkit-border-radius: 6px;
		border-radius: 6px;*/
		-moz-box-shadow: 0 1px 1px #777, 0 1px 0 #666 inset;
		-webkit-box-shadow: 0 1px 1px #777, 0 1px 0 #666 inset;
		box-shadow: 0 1px 1px #777, 0 1px 0 #666 inset;
	}
	
	#menu:before,
	#menu:after {
		content: "";
		display: table;
	}
	
	#menu:after {
		clear: both;
	}
	
	#menu {
		zoom:1;
	}
	
	#menu li {
		float: left;
		border-right: 1px solid #222;
		-moz-box-shadow: 1px 0 0 #444;
		-webkit-box-shadow: 1px 0 0 #444;
		box-shadow: 1px 0 0 #444;
		position: relative;
	}
	
	#menu a {
		float: left;
		padding: 12px 20px;
		color: #999;
		text-transform: uppercase;
		font: bold 12px Arial, Helvetica;
		text-decoration: none;
		text-shadow: 0 1px 0 #000;
	}
	
	#menu li:hover > a {
		color: #fafafa;
	}
	
	*html #menu li a:hover { /* IE6 only */
		color: #fafafa;
	}
	
	#menu ul {
		margin: 20px 0 0 0;
		_margin: 0; /*IE6 only*/
		opacity: 0;
		visibility: hidden;
		position: absolute;
		top: 38px;
		left: 0;
		z-index: 1;    
		background: #444;
		background: -moz-linear-gradient(#444, #111);
		background-image: -webkit-gradient(linear, left top, left bottom, from(#444), to(#111));
		background: -webkit-linear-gradient(#444, #111);    
		background: -o-linear-gradient(#444, #111);	
		background: -ms-linear-gradient(#444, #111);	
		background: linear-gradient(#444, #111);
		-moz-box-shadow: 0 -1px rgba(255,255,255,.3);
		-webkit-box-shadow: 0 -1px 0 rgba(255,255,255,.3);
		box-shadow: 0 -1px 0 rgba(255,255,255,.3);	
		-moz-border-radius: 3px;
		-webkit-border-radius: 3px;
		border-radius: 3px;
		-webkit-transition: all .2s ease-in-out;
		-moz-transition: all .2s ease-in-out;
		-ms-transition: all .2s ease-in-out;
		-o-transition: all .2s ease-in-out;
		transition: all .2s ease-in-out;  
	}

	#menu li:hover > ul {
		opacity: 1;
		visibility: visible;
		margin: 0;
	}
	
	#menu ul ul {
		top: 0;
		left: 150px;
		margin: 0 0 0 20px;
		_margin: 0; /*IE6 only*/
		-moz-box-shadow: -1px 0 0 rgba(255,255,255,.3);
		-webkit-box-shadow: -1px 0 0 rgba(255,255,255,.3);
		box-shadow: -1px 0 0 rgba(255,255,255,.3);		
	}
	
	#menu ul li {
		float: none;
		display: block;
		border: 0;
		_line-height: 0; /*IE6 only*/
		-moz-box-shadow: 0 1px 0 #111, 0 2px 0 #666;
		-webkit-box-shadow: 0 1px 0 #111, 0 2px 0 #666;
		box-shadow: 0 1px 0 #111, 0 2px 0 #666;
	}
	
	#menu ul li:last-child {   
		-moz-box-shadow: none;
		-webkit-box-shadow: none;
		box-shadow: none;    
	}
	
	#menu ul a {    
		padding: 10px;
		width: 130px;
		_height: 10px; /*IE6 only*/
		display: block;
		white-space: nowrap;
		float: none;
		text-transform: none;
	}
	
	#menu ul a:hover {
		background-color: #0186ba;
		background-image: -moz-linear-gradient(#04acec,  #0186ba);	
		background-image: -webkit-gradient(linear, left top, left bottom, from(#04acec), to(#0186ba));
		background-image: -webkit-linear-gradient(#04acec, #0186ba);
		background-image: -o-linear-gradient(#04acec, #0186ba);
		background-image: -ms-linear-gradient(#04acec, #0186ba);
		background-image: linear-gradient(#04acec, #0186ba);
	}
	
	#menu ul li:first-child > a {
		-moz-border-radius: 3px 3px 0 0;
		-webkit-border-radius: 3px 3px 0 0;
		border-radius: 3px 3px 0 0;
	}
	
	#menu ul li:first-child > a:after {
		content: '';
		position: absolute;
		left: 40px;
		top: -6px;
		border-left: 6px solid transparent;
		border-right: 6px solid transparent;
		border-bottom: 6px solid #444;
	}
	
	#menu ul ul li:first-child a:after {
		left: -6px;
		top: 50%;
		margin-top: -6px;
		border-left: 0;	
		border-bottom: 6px solid transparent;
		border-top: 6px solid transparent;
		border-right: 6px solid #3b3b3b;
	}
	
	#menu ul li:first-child a:hover:after {
		border-bottom-color: #04acec; 
	}
	
	#menu ul ul li:first-child a:hover:after {
		border-right-color: #0299d3; 
		border-bottom-color: transparent; 	
	}
	
	#menu ul li:last-child > a {
		-moz-border-radius: 0 0 3px 3px;
		-webkit-border-radius: 0 0 3px 3px;
		border-radius: 0 0 3px 3px;
	}
	
	/* Mobile */
	#menu-trigger {
		display: none;
	}

	@media screen and (max-width: 600px) {

		/* nav-wrap */
		#menu-wrap {
			position: relative;
		}

		#menu-wrap * {
			-moz-box-sizing: border-box;
			-webkit-box-sizing: border-box;
			box-sizing: border-box;
		}

		/* menu icon */
		#menu-trigger {
			display: block; /* show menu icon */
			height: 40px;
			line-height: 40px;
			cursor: pointer;		
			padding: 0 0 0 35px;
			border: 1px solid #222;
			color: #fafafa;
			font-weight: bold;
			background-color: #111;
			background: no-repeat 10px center, -moz-linear-gradient(#444, #111); 
			background: no-repeat 10px center, -webkit-linear-gradient(#444, #111);	
			background: no-repeat 10px center, -o-linear-gradient(#444, #111);
			background: no-repeat 10px center, -ms-linear-gradient(#444, #111);
			background: no-repeat 10px center, linear-gradient(#444, #111);
			-moz-border-radius: 6px;
			-webkit-border-radius: 6px;
			border-radius: 6px;
			-moz-box-shadow: 0 1px 1px #777, 0 1px 0 #666 inset;
			-webkit-box-shadow: 0 1px 1px #777, 0 1px 0 #666 inset;
			box-shadow: 0 1px 1px #777, 0 1px 0 #666 inset;
		}
		
		/* main nav */
		#menu {
			margin: 0; padding: 10px;
			position: absolute;
			top: 40px;
			width: 100%;
			z-index: 1;
			background-color: #444;
			display: none;
			-moz-box-shadow: none;
			-webkit-box-shadow: none;
			box-shadow: none;		
		}

		#menu:after {
			content: '';
			position: absolute;
			left: 25px;
			top: -8px;
			border-left: 8px solid transparent;
			border-right: 8px solid transparent;
			border-bottom: 8px solid #444;
		}	

		#menu ul {
			position: static;
			visibility: visible;
			opacity: 1;
			margin: 0;
			background: none;
			-moz-box-shadow: none;
			-webkit-box-shadow: none;
			box-shadow: none;				
		}

		#menu ul ul {
			margin: 0 0 0 20px !important;
			-moz-box-shadow: none;
			-webkit-box-shadow: none;
			box-shadow: none;		
		}

		#menu li {
			position: static;
			display: block;
			float: none;
			border: 0;
			margin: 5px;
			-moz-box-shadow: none;
			-webkit-box-shadow: none;
			box-shadow: none;			
		}

		#menu ul li{
			margin-left: 20px;
			-moz-box-shadow: none;
			-webkit-box-shadow: none;
			box-shadow: none;		
		}

		#menu a{
			display: block;
			float: none;
			padding: 0;
			color: #999;
		}

		#menu a:hover{
			color: #fafafa;
		}	

		#menu ul a{
			padding: 0;
			width: auto;		
		}

		#menu ul a:hover{
			background: none;	
		}

		#menu ul li:first-child a:after,
		#menu ul ul li:first-child a:after {
			border: 0;
		}		

	}

	@media screen and (min-width: 600px) {
		#menu {
			display: block !important;
		}
	}	

	/* iPad */
	.no-transition {
		-webkit-transition: none;
		-moz-transition: none;
		-ms-transition: none;
		-o-transition: none;
		transition: none;
		opacity: 1;
		visibility: visible;
		display: none;  		
	}

	#menu li:hover > .no-transition {
		display: block;
	}
	</style>



<nav id="menu-wrap" >    
	<ul id="menu">
		<li><a href="/" style="padding: 3px 30px 0px;"><img style="width:40px" src="http://demo.networkwe.com/img/logo.png"></a></li>
		<li><?php echo $this->Html->link(__('Home'), array('plugin' => false, 'admin' => false, 'controller' => 'home', 'action' => 'index')); ?>
			<ul>
				<li><a href="">NEWS</a></li>
				<li><a href="">PRESS RELEASES</a></li>
				<li><a href="">ARTICLES</a></li>
			</ul>
		</li>
		<li><?php echo $this->Html->link(__('Profile'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'myprofile')); ?></li>

		<li><?php echo $this->Html->link(__('Connections'), array('plugin' => false, 'admin' => false, 'controller' => 'connections', 'action' => 'index')); ?>
			<ul>
				<li><?php echo $this->Html->link(__('Peoples'), array('plugin' => false, 'admin' => false, 'controller' => 'connections', 'action' => 'index')); ?></li>
				<li><?php echo $this->Html->link(__('Companies'), array('plugin' => false, 'admin' => false, 'controller' => 'companies', 'action' => 'search')); ?></li>
				<li><?php echo $this->Html->link(__('Groups'), array('plugin' => false, 'admin' => false, 'controller' => 'groups', 'action' => 'search')); ?></li>
			</ul>				
		</li>
		<li><?php echo $this->Html->link(__('Jobs'), 'http://jobs.networkwe.com/',array('target'=>'blank')); ?></li>
		<li><?php echo $this->Html->link(__('Tweets'), array('plugin' => false, 'admin' => false, 'controller' => 'tweets', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Blogs'), array('plugin' => false, 'admin' => false, 'controller' => 'blogs', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Forums'), array('plugin' => false, 'admin' => false, 'controller' => 'forums', 'action' => 'index')); ?></li>

            	
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
                                </li><?php }}} ?> <!-- Session check end -->
                                
                                
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
</nav>
            <div id="notify-text">
            <a href="#">See all notifications</a>
            <div onclick="close_notify();" style="float:right;"><a href="#">x</a></div>
            </div>
       </div>