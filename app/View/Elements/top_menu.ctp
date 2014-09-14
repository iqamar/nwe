

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

		background-color: #f9f9f9;

		background-image: -moz-linear-gradient(#ffffff, #f9f9f9); 

		background-image: -webkit-gradient(linear, left top, left bottom, from(#ffffff), to(#f9f9f9));	

		background-image: -webkit-linear-gradient(#ffffff, #f9f9f9);	

		background-image: -o-linear-gradient(#ffffff, #f9f9f9);

		background-image: -ms-linear-gradient(#ffffff, #f9f9f9);

		background-image: linear-gradient(#ffffff, #f9f9f9);

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

		border-right: 1px solid #D1D1D1;

		/*-moz-box-shadow: 1px 0 0 #444;

		-webkit-box-shadow: 1px 0 0 #444;

		box-shadow: 1px 0 0 #444;*/

	height:40px;

		position: relative;

	}

	

	#menu a {

		float: left;

		padding: 12px 20px;

		color: #333;

		text-transform: uppercase;

		font: bold 12px Arial, Helvetica;

		text-decoration: none;

		

	}

	

	#menu li:hover > a {

		color: red;

	}

	

	*html #menu li a:hover { /* IE6 only */

		color: red;

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

		background: #ffffff;

		background: -moz-linear-gradient(#ffffff, #f9f9f9);

		background-image: -webkit-gradient(linear, left top, left bottom, from(#ffffff), to(#f9f9f9));

		background: -webkit-linear-gradient(#ffffff, #f9f9f9);    

		background: -o-linear-gradient(#ffffff, #f9f9f9);	

		background: -ms-linear-gradient(#ffffff, #f9f9f9);	

		background: linear-gradient(#ffffff, #f9f9f9);

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

		border: 1px solid #333;		

		

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

		-moz-box-shadow: 0 1px 0 #f9f9f9, 0 2px 0 #666;

		-webkit-box-shadow: 0 1px 0 #f9f9f9, 0 2px 0 #666;

		box-shadow: 0 1px 0 #f9f9f9, 0 2px 0 #666;

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

		border-bottom: 6px solid #ffffff;

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

			color: #333;

			font-weight: bold;

			background-color: #f9f9f9;

			background: no-repeat 10px center, -moz-linear-gradient(#ffffff, #f9f9f9); 

			background: no-repeat 10px center, -webkit-linear-gradient(#ffffff, #f9f9f9);	

			background: no-repeat 10px center, -o-linear-gradient(#ffffff, #f9f9f9);

			background: no-repeat 10px center, -ms-linear-gradient(#ffffff, #f9f9f9);

			background: no-repeat 10px center, linear-gradient(#ffffff, #f9f9f9);

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

			background-color: #ffffff;

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

			border-bottom: 8px solid #ffffff;

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

			border: 1 px solid gray;

			background:red;

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



<nav id="menu-wrap" style="top: 0px; position: fixed; z-index: 2147483647; width: 100%; left: 0px;">    

	<ul id="menu">

		<li><a href="/" style="padding: 0px 30px 0px;"><img style="height:40px;padding-top:1px;" src="http://demo.networkwe.com/images/nt-logo.png"></a></li>

		<li><?php echo $this->Html->link(__('Home'), array('plugin' => false, 'admin' => false, 'controller' => 'home', 'action' => 'index')); ?>

			<ul>

				<li><?php echo $this->Html->link(__('News'), array('plugin' => false, 'admin' => false, 'controller' => 'news', 'action' => 'index')); ?></li>

                <li><?php echo $this->Html->link(__('Press Releases'), array('plugin' => false, 'admin' => false, 'controller' => 'press_releases', 'action' => 'index')); ?></li>

			</ul>

		</li>

		<li><?php echo $this->Html->link(__('Profile'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'myprofile')); ?></li>



		<li><?php echo $this->Html->link(__('Connections'), array('plugin' => false, 'admin' => false, 'controller' => 'connections', 'action' => 'index')); ?>

			<ul>

				<li><?php echo $this->Html->link(__('People'), array('plugin' => false, 'admin' => false, 'controller' => 'connections', 'action' => 'index')); ?></li>

				<li><?php echo $this->Html->link(__('Companies'), array('plugin' => false, 'admin' => false, 'controller' => 'companies', 'action' => 'search')); ?></li>

				<li><?php echo $this->Html->link(__('Groups'), array('plugin' => false, 'admin' => false, 'controller' => 'groups', 'action' => 'search')); ?></li>

			</ul>				

		</li>

		<li><?php echo $this->Html->link(__('Jobs'), 'http://jobs.networkwe.com/',array('target'=>'blank')); ?></li>

		<li><?php echo $this->Html->link(__('Tweets'), array('plugin' => false, 'admin' => false, 'controller' => 'tweets', 'action' => 'index')); ?></li>

		<li><?php echo $this->Html->link(__('Blogs'), array('plugin' => false, 'admin' => false, 'controller' => 'blogs', 'action' => 'index')); ?>

        	<ul>

            	<li><?php echo $this->Html->link(__('Add Blog'), array('plugin' => false, 'admin' => false, 'controller' => 'blogs', 'action' => 'add')); ?></li>

            </ul>

        </li>

		<li><?php echo $this->Html->link(__('Forum'), 'http://forum.networkwe.com/',array('target'=>'blank')); ?></li>



				        <li style="margin-right:16px;">

            <?php echo $this->Form->create(null, array('url' => '/users_profiles/search_result/', 'name' => 'searchform', 'id' => 'searchform')); ?>

            <div class="cont-inptbtn">

                <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>

                <?php 

                echo $this->Form->input(null, array('options' => array(

                    '0' => 'All',

                    '1' => 'People',

                    '2' => 'Jobs',

                    '3' => 'Company',

                    '4' => 'Groups'

                    ), 'default' => '0', 'style' => 'width: 100px', 'id' => 'SearchScope', 'name' => 'SearchScope' ,'label' => false, 'div'=>false, 'selected' => $SearchScope));?>

                <?php echo $this->Form->input('username', array(

                    'label' => false,

                    'div'=>false,

                    'class' => 'srh-icon ui-autocomplete-input',

                    'placeholder' => 'Search...',

                    'name' => 'search_str',

                    'id' => 'search_str',

                    'onkeypress' => 'showPeopleUser(this.value);',

                    'value' => $SearchString

                    )); ?>

<!--                <input type="text" class="srh-icon ui-autocomplete-input" placeholder="Search people ..." name="search_str" id="search_str" onkeypress="showPeopleUser(this.value);" />-->

                <?php //echo $this->Form->input('Location',array('options'=>array(''=>'In All Location',$countryList),'name'=>'location','id'=>'location','label'=>false,'div'=>false,'class'=>'no-bder no-bg sbox')); ?>

                <?php //echo $this->Form->submit('Submit', array('type' => 'image', 'label' => false, 'src' => $this->request->base.'images/srh-icon.png')); ?>

                <div id="result_user" style="width:300px;">



                </div>

            </div>

            <?php echo $this->Form->end(); ?>

        </li>

                <li style="float: right;" >

				<span style="cursor:pointer;"><?php  if($usernotification > 0 ){ echo '<div id="home-menu" onclick="show_div()">'.$usernotification.'</div>';}?></span>				

         <div class="account-sub-nav" style="display:none; right:104px;" id="notificationMenus" onmouseout="this.style.display = 'none'">

                	<div class="account-sub-nav-options">

                    	<div class="activity-drop-header">

                        	<h3>Notifications &rarr;</h3>

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

                <li style="float: right; margin-right: 70px;">

				<?php if ($imgname) {

				echo $this->Html->image('/files/users/'.$imgname,array('url'=>'/users_profiles/myprofile','style'=>'margin-top: -6px;width:30px; height:30px; cursor:pointer;',' onmouseover'=>'return showSubMenus();'));

				}

				else { 

				echo $this->Html->image('no-image.png',array('url'=>'/users_profiles/myprofile','style'=>'margin-top: -6px;width:30px; height:30px; cursor:pointer;',' onmouseover'=>'return showSubMenus();'));

				}?>

                

            

                        	

                            <?php 

								$user_Full_Name="";

								if ($user_Profile) {

									$user_Full_Name .= $user_Profile['firstname']." ".$user_Profile['lastname'];

								}

								$user_Full_Name .= "&nbsp;&nbsp;&nbsp;Sign Out";

							?>

                        

                        	<ul class1="account-settings">

                            	<li>                                	

                                   <?php echo $this->Html->link(__('Sign Out'),array('controller'=>'users','action'=>'logout'),array('style'=>'cursor:pointer;')); ?>                                       

                                </li>

                                <li>                                

                             		<?php echo $this->Html->link(__('Upgrade Account'),array('controller'=>'users_profiles','action'=>'profile'),array('style'=>'cursor:pointer;')); ?>                                           

                              </li>

                              <li>                                	

                                   <?php echo $this->Html->link(__('Privacy & Settings'),array('controller'=>'users_profiles','action'=>'review'),array('style'=>'cursor:pointer;')); ?>

						      </li>

							</ul>

		</li>				

	</ul>

</nav>

<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>-->

<script type="text/javascript">

    $(function() {

		if ($.browser.msie && $.browser.version.substr(0,1)<7)

		{

		$('li').has('ul').mouseover(function(){

			$(this).children('ul').css('visibility','visible');

			}).mouseout(function(){

			$(this).children('ul').css('visibility','hidden');

			})

		}



		/* Mobile */

		$('#menu-wrap').prepend('<div id="menu-trigger">Menu</div>');		

		$("#menu-trigger").on("click", function(){

			$("#menu").slideToggle();

		});



		// iPad

		var isiPad = navigator.userAgent.match(/iPad/i) != null;

		if (isiPad) $('#menu ul').addClass('no-transition');      

    });          

</script>