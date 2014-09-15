<?php App::import('Controller', 'Headers');
	App::import("Model", "Statusupdate");
	  $obj = new Statusupdate();
?>

<div id="header-innerpage">

    <div id="header-content">
	<div id="header-left-content">
		<div class="header-logo-area">
			<?php echo $this->Html->link('', NETWORKWE_URL, array('escape' => false, 'id' => 'logo-innerpage', 'title' => 'NetworkWe')); ?>
			<div class="findus-icons">
				<ul>
					
					<li><a href="https://www.facebook.com/NetworkWe" target="_blank" class="fb"></a></li>
					<li><a href="https://twitter.com/networkwe" target="_blank" class="twitter"></a></li>
					<li><a href="https://plus.google.com/+Networkwe" target="_blank" class="gplus"></a></li>
					<li><a href="http://www.linkedin.com/company/networkwe" rel="publisher" target="_blank" class="linkedin"></a></li>
					<li><a href="http://www.pinterest.com/networkwe/" rel="publisher" target="_blank" class="pinterest"></a></li>
					<li><a href="http://instagram.com/network_we" rel="publisher" target="_blank" class="instagram"></a></li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
		<div class="header-mid-area">
        <div id='cssmenu'>

            <ul>

                <li class='has-sub'><?php echo $this->Html->link('<span>Home</span>', NETWORKWE_URL . '/home/index', array('escape' => false)); ?></li>

                <li class='has-sub '>
					<?php echo $this->Html->link('<span>Profile</span>', NETWORKWE_URL . '/users_profiles/myprofile', array('escape' => false)); ?>
					<ul>
                        <li><?php echo $this->Html->link('Edit Profile', NETWORKWE_URL . '/users_profiles/update', array('escape' => false)); ?></li>
                    </ul>
				</li>

                <li class='has-sub '><?php echo $this->Html->link('<span>Connections</span>', NETWORKWE_URL . '/connections', array('escape' => false)); ?>

                    <ul>
						<li><?php echo $this->Html->link('Professionals', NETWORKWE_URL . '/connections/professionals', array('escape' => false)); ?></li>
                        <li><?php echo $this->Html->link('Friends', NETWORKWE_URL . '/connections/friends', array('escape' => false)); ?></li>
                        <li><?php echo $this->Html->link('Companies', NETWORKWE_URL . '/companies/', array('escape' => false)); ?></li>
                        <li><?php echo $this->Html->link('Groups', NETWORKWE_URL . '/groups/', array('escape' => false)); ?></li>
						<li><?php echo $this->Html->link('Add Connection', NETWORKWE_URL . '/contacts/', array('escape' => false)); ?></li>

                    </ul>

                </li>

                <li class='has-sub active'><?php echo $this->Html->link('Jobs', JOBS_URL . '/', array('class'=>'active','escape' => false)); ?></li>

                <li class='has-sub '><?php echo $this->Html->link('<span>Tweets</span>', NETWORKWE_URL . '/tweets', array('escape' => false)); ?></li>

                <li><?php echo $this->Html->link('<span>Blogs</span>', NETWORKWE_URL . '/blogs', array('escape' => false)); ?></li>

            <!--    <li><a href='#'><span>Forum</span></a></li>-->

            </ul>

        </div>
		
        <div class="topsearcharea">
            <div class="topsearch">
                <table width="200" border="0" cellspacing="0" cellpadding="0">
                    <tr>
						<?php echo $this->Form->create(null, array('url' => '', 'name' => 'globalsearchform', 'id' => 'globalsearchform')); ?>
                        <td>
                            <?php
                            echo $this->Form->input('username', array('label' => false, 'div' => false, 
								'class' => 'srh-icon ui-autocomplete-input textfield width2 search',
                                'placeholder' => 'Type Your Search',
                                'name' => 'search_str',
                                'autocomplete' => 'off',
                                'id' => 'search_str',
                                'required' => false,
                                'allowEmpty' => true
                            ));
                            ?>
                        </td>
                        <td>
                            <select name="SearchScope" id="SearchScope" class="default" tabindex="2">
      							<option value="0">All</option>
      							<option value="1">People</option>
                                <option value="2">Jobs</option>
      							<option value="3">Companies</option>
      							<option value="4">Groups</option>
							</select>   
                        </td>
                        <td>
                        <?php echo $this->Form->submit('', array('type' => 'submit', 'label' => false, 'div' => false, 'id' => 'submit-button', 'onclick' => 'get_Search(this.form.name)', 'class' => 'headersearchbutton')); ?>
                        </td>
						<?php echo $this->Form->end(); ?>
                    </tr>
                </table>
            </div>
			<div id="display"></div>
            <div class="clear"></div>
        </div>
		<div class="clear"></div>
	</div>
	</div>
        <div id="header-innerpage-rgt">
			<div id="notification-area">
			<div id="mixnotification">
                <input type="hidden" id="user_id" value="<?php echo $uid;?>" />
				<?php 
					$total_notification = $this->requestAction(array('controller' => 'headers', 'action' => 'getTotalNotification'));

                    if ($total_notification > 0 && $total_notification <= 20) {
                        echo '<a href="'.NETWORKWE_URL.'/home/notifications" class="notification-number" id="notification-count">'.$total_notification.'</a>';
                    }
					else if ($total_notification > 20) {
						echo '<a href="'.NETWORKWE_URL.'/home/notifications" class="notification-number" id="notification-count">20+</a>';	
					}
                    ?>
                
				<ul>
                    <li class="has-sub">
                        <a href="#"><span id="mixnotification-icon"></span></a>
                        <ul>
                            <li>
							<div class="notification_heading">
                            	<!--<a class="noti-seeall" href="notifications.html">See All</a>-->
                                <?php $user_no = $this->requestAction(array('controller' => 'headers', 'action' => 'getNotification')); ?>
                                <?php 
								if (sizeof($user_no) > 0) {
									echo $this->Html->link('Clear All',NETWORKWE_URL.'/home/clear',array('escape'=>false,'class' => 'noti-seeall'));
									
								}?>
                                <?php echo $this->Html->link('See All',NETWORKWE_URL.'/home/notifications',array('escape'=>false,'class' => 'noti-seeall'));?>
                          		<h3>Notification/Updates</h3>
                        	</div>
                    			<div class="fixed-thumb-size-demo default-skin">
                            
                           <?php 
								$user_viewed = $this->requestAction(array('controller' => 'headers', 'action' => 'getVeiwedNotification'));
                                ?>
                           <?php $flag = false; $viewed = 0; $activity_record='';
								foreach ($user_viewed as $view_row) {
									$viewed_array[] = $view_row['users_viewings']['viewings_id'];
								}
						   		foreach ($user_no as $notify_row) {
							   		
                                    $activity_id = $notify_row['master_activities']['activity_id'];
                                    $id = $notify_row['master_activities']['id'];
                                    $activity_type = $notify_row['master_activities']['activity_type'];
                                   // $viewed = $notify_row['master_activities']['viewed'];
                                    $created_date = $notify_row['master_activities']['created'];
                                    $post_owner = $notify_row['master_activities']['post_owner'];
                                   
                                    if (in_array($id,$viewed_array)) {
											$viewed = 1;
										}
										else {
											$viewed = 0;
										}
                                    if ($post_owner == $uid && ($activity_type == "likes" || $activity_type == "comments" || $activity_type == "connection")) {
                                        $activity_record = $obj->get_activity($activity_id,$activity_type);
                                    }
                                    if ($activity_type == "updates") {
                                        if (in_array($post_owner,$friends_Lists)) {
											
                                            $activity_record = $obj->get_activity($activity_id,$activity_type);
											//print_r($activity_record);
                                        }
                                    }
									
                                    if ($activity_record) {
												$flag = true;
                                                $user_photo = $activity_record['users_profiles']['photo']; 
                                                $user_name = $activity_record['users_profiles']['firstname']." ".$activity_record['users_profiles']['lastname']; 
                                                $user_id = $activity_record['users_profiles']['user_id'];
                                                $tags = substr($activity_record['users_profiles']['tags'],0,35);
                                                if ($activity_type == 'comments') {
                                                    $post_id = $activity_record['comments']['content_id'];
                                                }
                                                else if ($activity_type == 'likes') {
                                                        $post_id = $activity_record['likes']['content_id'];
                                                    
                                                }
                                                else if ($activity_type == 'updates') {
                                                        $post_id = $activity_record['statusupdates']['id'];
                                                    
                                                }
												else if ($activity_type == 'connection') {
                                                        $post_id = $activity_record['users_profiles']['user_id']; 
                                                }
                                                if ($user_photo && file_exists(MEDIA_PATH.'/files/user/icon/'.$user_photo)) {
                                                    $photo = MEDIA_URL.'/files/user/icon/'.$user_photo;
                                                }
                                                else {
                                                    $photo = MEDIA_URL.'/img/nophoto.jpg';
                                                }
                                                $now_date = strtotime(date('Y-m-d H:i:s'));
                                                $postDate = strtotime($created_date);
                                                if ($created_date) {
                                                    $diff = $now_date - $postDate;
                                                    $days = floor(($now_date - $postDate) / (86400));
                                                    
                                                }
                                           ?>
                                           <?php if ($viewed == 0) {?>
                                      			<a href="javascript:viewActivity('<?php echo $post_id;?>','<?php echo $id;?>','<?php echo $activity_type; ?>')" id="activity_<?php echo $id;?>" class="unread">
                                            <?php } else {?>
                                                 <a href="javascript:viewActivity('<?php echo $post_id;?>','0','<?php echo $activity_type;?>')" id="activity_<?php echo $id;?>">
                                            <?php }?>
                                                <div class="notification-div">
                                                    <div class="notification-img">
                                                        <?php echo $this->Html->image($photo,array('controller'=>'users_profiles','action'=>'userprofile',$user_id));?>
                                                    </div>
                                                    <div class="natfication-rgt">
                                                        <span class="timecount">
                                                        <?php if ($days <= 1) { 
                                                                    $hours = floor(($diff - ($days * 60 * 60 * 24)) / (60 * 60));
                                                                    echo $hours . "h";
                                                                } else {
                                                                    echo $days . "d";
                                                                
                                                        }?>
                                                        </span>
                                                        <span><strong><?php echo $user_name;?></strong></span><br>
                                                        <span><?php echo $tags;?></span><br>
                                                        <?php if ($activity_type == 'comments') {?>
                                                        <span>comments on your update</span>
                                                        <?php } else if($activity_type == 'likes') {?>
                                                        <span> likes your update</span>
                                                        <?php } else if($activity_type == 'updates') {?>
                                                        <span> share update on NetworkWE</span>
                                                        <?php } else if ($activity_type == 'connection') {?>
                                                        <span> accept your connection request</span>
                                                        <?php }?>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                            </a> 
                                <?php } $activity_record = '';}?>
                                <?php if ($flag == false) {?>
                                        <div class="no_notification">You don't have any notification or updates</div>
                                <?php }?>
                            </div>
                            </li>
                        </ul>
                    </li> 
               </ul>
			<div class="clear"></div>
	  </div>
            <div id='notification'>

                <?php $usernotification = $this->requestAction(array('controller' => 'headers', 'action' => 'getUserConnections')); ?>

                <div class="notification-number" id="notification_request"><?php if ($usernotification > 0) {

                    echo $usernotification;

                } ?></div>

            

			<?php $requserss = $this->requestAction(array('controller' => 'headers', 'action' => 'getUserRecord')); ?>

                <ul>

                    <li class='has-sub'>

                        <a href='#'><span><?php echo $this->Html->Image(MEDIA_URL . '/img/notification-icon.png'); ?></span></a>
					<?php if ($usernotification > 0) { ?>
                        <ul>
				
                            <li>
							<div class="notification_heading">
                      			<h3>Connection Requests</h3>
                     		  </div>
                                <?php
                                $requserss = $this->requestAction(array('controller' => 'headers', 'action' => 'getUserRecord'));
                                $requsers_res = $this->requestAction(array('controller' => 'headers', 'action' => 'getRequestResponse'));
                                $skills_Recommended_for_User = $this->requestAction(array('controller' => 'headers', 'action' => 'getUserSkillRecommendation'));
                                $chat_User_Requsers = $this->requestAction(array('controller' => 'headers', 'action' => 'getUserChatRequests'));
                                $user_comments = $this->requestAction(array('controller' => 'headers', 'action' => 'commentsOnActivity'));
                                ?>
                                    <?php if (sizeof($requserss) != 0 || sizeof($chat_User_Requsers) != 0){ ?>
                                    <div class="fixed-thumb-size-demo default-skin">
                                <!-- Accept Decline Request DIV -->

                                <?php

                                foreach ($requserss as $requser) {

                                    $photo = $requser['users_profiles']['photo'];

                                    $profi_title = $requser['users_profiles']['tags'];

                                    $full_name = $requser['users_profiles']['firstname'] . " " . $requser['users_profiles']['lastname'];

									$handler = $requser['users_profiles']['handler'];

                                    $now_date = strtotime(date('Y-m-d H:i:s'));

                                    $postDate = strtotime($requser['connections']['created']);

                                    $conn_id = $requser['connections']['id'];

                                    if ($requser['connections']['request'] == 0) {

                                        ?>

                                        <div class="notification-div" id="req_<?php echo $conn_id; ?>">

                                            <div class="notification-img">

                                                    <?php

                                                    if(!empty($photo)&& file_exists(MEDIA_PATH.'/files/user/icon/'.$photo)){ 
														echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$photo,array('url'=>array('controller'=>'pub','action'=>$handler)));
													}else{ 
														echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'pub','action'=>$handler)));
													} 

                                                    ?></div>

                                            <div class="natfication-rgt">

                                                <span><strong><?php echo $full_name; ?></strong>

                                                    <?php echo "   " . $profi_title; ?>

                                                    <div class="timecount">

                                                        <?php

                                                        if ($postDate) {

                                                            $diff = $now_date - $postDate;

                                                            $days = floor(($now_date - $postDate) / (86400));

                                                            if ($days <= 1) {

                                                                $hours = floor(($diff - ($days * 60 * 60 * 24)) / (60 * 60));

                                                                echo $hours . "h";

                                                            } else {

                                                                echo $days . "d";

                                                            }

                                                        }

                                                        ?></div></span>

                                                <?php if ($requser['connections']['request'] == 0) { ?>

                                                    <div id="notification-bttns" style="display: block;">

                                                        <span id="response_<?php echo $conn_id; ?>">

            <?php echo $this->Html->link('Accept', 'javascript:user_Action(1,' . $conn_id . ');', array('class' => 'acceptbttn')); ?>

                                                            <?php echo $this->Html->link('Decline', 'javascript:user_Action(-1,' . $conn_id . ');', array('class' => 'declinebttn')); ?>
															<?php echo $this->Html->link('Not Now', 'javascript:user_Action(-2,' . $conn_id . ');', array('class' => 'notnowbttn')); ?>
                                                        </span>

                                                    </div>

        <?php } ?>

                                                <span style="display:none;" id="accept_<?php echo $conn_id; ?>"><?php echo '<br />' . "is now a connection"; ?></span>

                                            </div>

                                            <div class="clear"></div>

                                        </div>

									<?php }
                                
                                } ?>

                                

                               

									<?php $chat_User_Requsers = $this->requestAction(array('controller' => 'headers', 'action' => 'getUserChatRequests')); ?>

                                    <?php

                                    foreach ($chat_User_Requsers as $chatRequset) {

										$photo = $chatRequset['users_profiles']['photo'];

										$profi_title = $chatRequset['users_profiles']['tags'];

										$full_name = $chatRequset['users_profiles']['firstname'] . " " . $chatRequset['users_profiles']['lastname'];

										$handler = $chatRequset['users_profiles']['handler'];

										$now_date = strtotime(date('Y-m-d H:i:s'));

										$postDate = strtotime($chatRequset['cometchat_friends']['invite_date']);

										$chat_id = $chatRequset['cometchat_friends']['id'];

										if ($chatRequset['cometchat_friends']['status'] == 0) { ?>

                                        <div class="notification-div" id="chat_<?php echo $chat_id; ?>">

                                            <div class="notification-img">

                                                <a href="#">

                                                <?php
												if(!empty($photo)&& file_exists(MEDIA_PATH.'/files/user/icon/'.$photo)){ 
													echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$photo,array('url'=>array('controller'=>'pub','action'=>$handler)));
												}else{ 
													echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'pub','action'=>$handler)));
												} 

                                                ?>

                                                </a>

                                            </div>

                                            <div class="natfication-rgt">

                                                <span><strong><?php echo $full_name; ?></strong>

                                        <?php echo "   " . $profi_title . "<br />"; ?>

                                                    <div class="timecount">

                                                    <?php

                                                    if ($postDate) {

                                                        $diff = $now_date - $postDate;

                                                        $days = floor(($now_date - $postDate) / (86400));

                                                        if ($days <= 1) {

                                                            $hours = floor(($diff - ($days * 60 * 60 * 24)) / (60 * 60));

                                                            echo $hours . "h";

                                                        } else {

                                                            echo $days . "d";

                                                        }

                                                    }

                                                    ?>

                                                    </div>

                                                </span>

                                                    <?php if ($chatRequset['cometchat_friends']['status'] == 0) { ?>

                                                    <span id="chat_invite_<?php echo $chat_id; ?>"> <?php echo " is inviting you for chat."; ?></span>

                                                    <div id="notification-bttns" style="display: block;">

                                                        <span id="chat_response_<?php echo $chat_id; ?>">

                                                            <?php echo $this->Html->link('Accept', 'javascript:chat_Action(2,' . $chat_id . ');', array('class' => 'acceptbttn')); ?>

                                                            <?php echo $this->Html->link('Decline', 'javascript:chat_Action(-1,' . $chat_id . ');', array('class' => 'declinebttn')); ?>
															<?php echo $this->Html->link('Not Now', 'javascript:user_Action(-2,' . $chat_id . ');', array('class' => 'notnowbttn')); ?>

                                                        </span>

                                                    </div>

                                                        <?php } ?>

                                                <span style="display:none;" id="chat_accept_<?php echo $chat_id; ?>"><?php echo "is now a chat connection"; ?></span>

                                            </div>

                                            <div class="clear"></div>

                                        </div>

                                            <?php }

                                        } ?>

                        

                                            <div class="clear"></div>

                                    </div>
<?php } ?>
                            </li>

                        </ul>
					 <?php } else {?>
                        <ul>
                        	<li>
                        		<div class="no_notification">You don't have any connection request</div>
                            </li>
                        </ul>
                        <?php }?>
                    </li>

                </ul>

            </div>
			 <div id="message"> 
				<?php $unreadCount = $this->requestAction(array('controller' => 'headers', 'action' => 'getMessagesCount')); 
					if ($unreadCount > 0) {
					?>
						<div class="notification-number" id="unreadCountHeader"><?php
							
								echo $unreadCount;
							
							?>
						</div>
					<?php } ?>
					<ul> 
                        <li class="has-sub">
                            <a href="<?php echo NETWORKWE_URL;?>/messages/"><span id="message-icon"></span></a>
                            
                        </li>
					</ul>
					<div class="clear"></div>
	  			</div>
	  <div id="dd-connections">
     <ul>
                        <li class="has-sub">
                            <a href="#"><span id="dd-connections-icon"></span></a>
                            <ul>
                                <li>
                                    <div class="marginbottom10">
                                        <h3>Add Connections</h3>
                                    </div>
                                    <div class="marginbottom10">Quickly find people you may know by searching your email contacts:</div>
                                        
                                        <a class="dd-gmail_icon" href="<?php echo NETWORKWE_URL;?>/contacts/"></a>
                                        <a class="dd-yahoo_icon" href="<?php echo NETWORKWE_URL;?>/contacts/"></a>
                                        <a class="dd-hotmail_icon" href="<?php echo NETWORKWE_URL;?>/contacts/"></a>
                                </li>
                            </ul>
                        </li>
     </ul>
     <div class="clear"></div>
      </div>
	  
	  </div>
            <div class="signout user-div">
				<div class="userpic">
					<span>
						<?php				
						if ($userInfo['users_profiles']['photo']){
							if(file_exists(MEDIA_PATH.'/files/user/icon/'.$userInfo['users_profiles']['photo'])){
								$user_photo=MEDIA_URL.'/files/user/icon/'.$userInfo['users_profiles']['photo'];
							}else{
								$user_photo=MEDIA_URL.'/img/nophoto.jpg';
							}
						 }
						 else { 	
								$user_photo=MEDIA_URL.'/img/nophoto.jpg'; 
						 }
						 echo $this->Html->link($this->Html->image($user_photo),NETWORKWE_URL.'/users_profiles/myprofile',array('escape'=>false));
						?>
					</span>
				</div>
				<div id='userarea'>
					<ul>
						<li class='has-sub'><a href='#' class="myaccount">My Account</a>
							<ul>
								<li><?php echo $this->Html->link('Profile', NETWORKWE_URL.'/users_profiles/myprofile', array('escape' => false)); ?></li>

								<li><?php echo $this->Html->link('Privacy & Settings', NETWORKWE_URL.'/users_profiles/review', array('escape' => false)); ?></li>
							</ul>
						</li>
						<?php echo $this->Html->link('Sign Out', NETWORKWE_URL.'/users/logout', array('class'=>'signout','escape' => false)); ?>
						
					</ul>
				</div>
				
			</div>
			<div class="clear"></div>
			<div class="header-small-links">
				<ul>
					<li><a href="<?php echo NETWORKWE_URL  ?>/companies/about/">About Us</a></li>
					<li><a href="<?php echo NETWORKWE_URL ?>/companies/contact/">Contact Us</a></li>
				
				</ul>
			</div>
			
        </div>
        

        <div class="clear"></div>

    </div>

</div>

<div class="clear"></div>
<script type="text/javascript">
function viewActivity(post_id,id,notify_type) {
	var user_id = document.getElementById('user_id').value;
    $.ajax({
        url: baseUrl + "/headers/view_activity",
        type: "POST",
        cache: false,
        data: {id: id,user_id:user_id},
        success: function(data) {
            //$("#req_"+connect_id).html(data);
            if (post_id && id != 0) {
				if (notify_type != 'connection') {
					window.location = "<?php echo NETWORKWE_URL;?>/home/view/"+post_id;
				}
				else {
					window.location = "<?php echo NETWORKWE_URL;?>/users_profiles/userprofile/"+post_id;
				}
                $("#notification-count").html(((parseInt($("#notification-count").html())-1) == 0) ? '' :parseInt($("#notification-count").html())-1);
             	//$("#activity_"+id).hide('slow');
				//$("#activity_"+id).slideUp('slow');
            }
			else {
				if (notify_type != 'connection') {
					window.location = "<?php echo NETWORKWE_URL;?>/home/view/"+post_id;
				}
				else {
					window.location = "<?php echo NETWORKWE_URL;?>/users_profiles/userprofile/"+post_id;
				}
			}
        },
        error: function(data) {
            $("#activity_"+id).html("there is error in your script.");
        }
    });
}
</script>
<?php /*
<script type="text/javascript">

    var ajaxProcess = false;



    $("#globalsearchform #search_str").keypress(function(e) {

        if (e.which == 13) {

            e.preventDefault();

            $("#globalsearchform #submit-button").click();

        }

    });



    $("#globalsearchform").submit(function(e) {

        return false;

    });



    function get_Search(formid) {
        if (ajaxProcess)
            return false;
        ajaxProcess = true;
        var data_save = $("#" + formid).serializeArray();
        data_save.push({name: "SearchScope", value: $("#dd ul li:contains('" + $("#dd #selected").html() + "')").index()});
        $.ajaxSetup({
            beforeSend: function() {
                $(".leftcol").html("<img class='loading1' src='<?php echo MEDIA_URL?>/img/loading.gif'>");
            },
            complete: function() {
                //$("#search_container").html('');
            }
        });
        $.ajax({
            dataType: "html", type: "POST", evalScripts: true,
            url: "/Globalsearch/index/",
            data: data_save,
            success: function(data, textStatus) {
                ajaxProcess = false;
                $(".leftcol").html(data);
            }
        });
    }
    
    function connect_user(id) {
        if (ajaxProcess)
            return false;
        ajaxProcess = true;
        var data_save = $("#" + formid).serializeArray();
        var formid = "#form-"+id;
        data_save.push({name: "friend_id", value: id});
        data_save.push({name: "action", value: 0});
        $.ajaxSetup({
            beforeSend: function() {
                $(formid+" #ajax_response").html("<img class='loading1' src='<?php echo MEDIA_URL?>/img/loading.gif' />");
            }
        });
        $.ajax({
            dataType: "html", type: "POST", evalScripts: true,
            url: "/Globalsearch/add_connection_ajax/",
            data: data_save,
            success: function(data) {
                ajaxProcess = false;
                $(formid+" #ajax_response").html(data);
            },
            error: function(data) {
                ajaxProcess = false;
                $(formid+" #ajax_response").html('Error saving data!');
            }
        });
    }



    $('.dropdown a').click(function(event) {

        var selected_value = this.id;

        var search_value = '';

        if (selected_value == 'All') {

            search_value = 0;

        }

        else if (selected_value == 'People') {

            search_value = 1;

        }

        else if (selected_value == 'Jobs') {

            search_value = 2;

        }

        else if (selected_value == 'Companies') {

            search_value = 3;

        }

        else if (selected_value == 'Groups') {

            search_value = 4;

        }

        document.getElementById('SearchScope').value = search_value;

        $("#selected").html(selected_value);

    });



    function user_Accept() {

        //document.userConfirm.submit();

        document.getElementById("userConfirm").submit();

    }

    

    function user_Action(action, connect_id) {

        $.ajax({

            url: "/headers/decline",

            type: "POST",

            cache: false,

            data: {action: action, connect_id: connect_id},

            success: function(data) {

                //$("#req_"+connect_id).html(data);

                if (action == -1) {

                    $("#req_" + connect_id).hide('slow');

                }

                else {

                    $("#response_" + connect_id).hide('slow');

                    $("#accept_" + connect_id).show('slow');

                }

            },

            error: function(data) {

                $("#req_" + connect_id).html("there is error in your script.");

            }

        });

    }



    function chat_Action(action, chat_id) {

        $.ajax({

            url: "/headers/chat_request",

            type: "POST",

            cache: false,

            data: {action: action, chat_id: chat_id},

            success: function(data) {

                //$("#req_"+connect_id).html(data);

                if (action == -1) {

                    $("#chat_" + chat_id).hide('slow');

                }



                else {

                    $("#chat_response_" + chat_id).hide('slow');

                    $("#chat_invite_" + chat_id).hide('slow');

                    $("#chat_accept_" + chat_id).show('slow');

                }

            },

            error: function(data) {

                $("#chat_" + connect_id).html("there is error in your script.");

            }

        });

    }

</script>
*/ ?>