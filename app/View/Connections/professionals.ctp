<div class="leftcol" id="search_container">

	<?php
		$paginator = $this->Paginator;
		$num_contacts = count($peoples["contacts"]);
				
		echo '<div class="box">'.
				'<div class="boxheading">'.
					'<h1>'.
						'<div class="searchbox-icons">'.
							'<img src="'.MEDIA_URL.'/img/connection-icon.png" />'.
						'</div>'.
						'Your Professional Contacts'.
						'<span class="searchbox-total"> (<span  id="your_connections">'.$total_connections.'</span>)</span></h1>'.
						'<div class="boxheading-arrow"></div>'.
				'</div>'.
				'<div id="contacts_loading" style="display:none; text-align:center;"><img src="'.MEDIA_URL.'/img/loading.gif" /></div>'.
				'<div class="margintop20">';
			echo '<div class="success_msg" id="message_contact" style="display:none;">Your Connection has been deleted successfully!</div>';
				
				if($num_contacts<=0){
					echo '<div class="searchresult-holder">'.
							'<div class="searchresult-rgt-full">'.
								'<ul>'.
									'<li>'.
										'<h1>No contacts were found in your friends list.</h1>'.
									'</li>'.						
								'</ul>'.
							'</div>'.
							'<div class="clear"></div>'.
						'</div>';
				}else{
				
					foreach($peoples["contacts"] as $contacts){
						echo '<div class="searchresult-holder" id="'.$contacts["id"].'">'.
								'<div class="resultpic">'.
									'<a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$contacts["friend_id"].'">';
									if ($contacts["photo"] && file_exists(MEDIA_PATH.'/files/user/icon/'.$contacts["photo"])) {
										echo '<img src="'.MEDIA_URL.'/files/user/icon/'.$contacts["photo"].'" alt="" border="0"/></a>';
									}
									else {
										echo '<img src="'.MEDIA_URL.'/img/nophoto.jpg" alt="" border="0"/></a>';
									}
							echo '</div>'.
								'<div class="searchresult-rgt-full">'.
									'<ul>'.
										'<li>'.
											'<h1><a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$contacts["friend_id"].'">'.$contacts["firstname"].' '.$contacts["lastname"].'</a></h1>'.
										'</li>'.
										'<li>'.															
											  $contacts["tags"].
										'</li>';
					if ($uid == $user_profile_id) {	
								   echo '<li><div class="connpage-bttns">'; ?>
                                   		<a href="#?" rel="sendmessage<?php echo $contacts["id"]?>" class="sendmsg poplight">Send Message</a>
                      <!-- following section start -->
                     <div id="user_following_btn<?php echo $contacts["id"]?>">
						  			<?php 
						  				if ($contacts["following_id"]) {
											if ($contacts["status"] == 2) {
									?>
							  				 <a href="Javascript:userFollow('0','<?php echo $contacts["following_id"]?>','<?php echo $contacts["id"]?>');" id="following_user1" class="unfollow"><?php echo __('Following');?></a>
						  					<?php }
										else {
										?>
								<a href="Javascript:userFollow('2','<?php echo $contacts["following_id"]?>','<?php echo $contacts["id"]?>');" id="follow_user1" class="follow"><?php echo __('Follow');?></a>
								  <?php }}
								  else {
								  ?>
									<a href="Javascript:userFollow('2','','<?php echo $contacts["id"]?>');" id="follow_user1" class="follow"><?php echo __('Follow');?></a>
								  <?php }?>
                       </div>
                       <input type="hidden" name="u_id" id="u_id<?php echo $contacts["id"]?>" value="<?php echo $uid;?>" />
						<input type="hidden" name="content_type" id="content_type" value="users" />
			 			<input type="hidden" name="following_id" id="following_id<?php echo $contacts["id"]?>" value="<?php echo $contacts["user_id"];?>" />
                		<input type="hidden" name="start_date" id="start_date<?php echo $contacts["id"]?>" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
                 		<input type="hidden" name="end_date" id="end_date<?php echo $contacts["id"]?>" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
                       <!-- following section end -->
                       <!-- user chat connection form start-->
                      <?php  if ($contacts['friend_in_chat'] == ''){?>
                        <form method="post" id="chat_connect<?php echo $contacts["id"]?>" name="chat_connect" action="/users_profiles/invite_for_chat" >
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $uid?>" />
                            <input type="hidden" name="friend_id" id="friend_id" value="<?php echo $contacts["user_id"];?>" />
                            <input type="hidden" name="status" value="0" />
                            <input type="hidden" name="invite_date" id="invite_date" value="<?php echo $dt = date('Y-m-d h:i:s');?>" />
                        </form>
                         <a href="#" class="chat" onclick="chat_Connection('<?php echo $contacts["id"]?>');">Connect to chat</a>
                      <?php }?>
                               
                          <a href="javascript:" onclick="return remove_contact('<?php echo $contacts["id"]?>','connection',1)" class="poplight remove">Remove Connection</a>
                              
                              <!-- Send Message Popup -->
                       		 <div id="sendmessage<?php echo $contacts["id"]?>" class="popup_block">
                            <!--your content start-->
                                <div class="userprofile-box">
                                    <div class="userprofile-box-rgt">
                                        <ul>
                                            <li>
                                                <h1><?php echo "Send ".$contacts["firstname"]." ".$contacts["lastname"]." a message";?></h1>
                                            </li>
                                        </ul>
                                    </div>
                                <div class="clear"></div>
                              </div>
                                <form action="/users_profiles/user_send_message/" method="post" class="userprofile-form">
                                    <?php if($userInfo['users']['email']){ $yourEmail = $userInfo['users']['email'];}?>
                                    <input type="hidden" name="reciver" value="<?php echo $contacts["email"];?>" />
                                    <input type="hidden" name="sender" value="<?php echo $yourEmail;?>" />
                                    <input type="hidden" name="recivername" value="<?php echo $contacts["firstname"];?>" />
									<input type="hidden" name="sender_id" value="<?php echo $contacts['user_id'];?>" />
                                    <input type="hidden" name="user_id" value="<?php echo $uid;?>" />
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td><strong>To </strong>
                                            <?php echo $contacts["firstname"]." ".$contacts["lastname"]." (".$contacts["email"].")";?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Subject</strong></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="subject" class="textfield" size="60" />    </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Message</strong></td>
                                        </tr>
                                        <tr>
                                            <td><textarea name="message" cols="58" rows="7" class="textfield" ></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><input type="submit" name="Submit" value="Send" class="red-bttn" /></td>
                                        </tr>
                                    </table>
                                </form>
                               <!--your content end-->
                          </div>	
                       <?php }?>    
								<?php
                                echo '</div></li>'.
									'</ul>'.
								'</div>'.
								'<div class="clear"></div>'.
							'</div>';
					}
				
				}
				
					// pagination section Start
					echo "<div class='paging' style='float:right;'>";
				 
						// the 'first' page button
						echo $paginator->first("First");
						 
						// 'prev' page button, 
						// we can check using the paginator hasPrev() method if there's a previous page
						// save with the 'next' page button
						if($paginator->hasPrev()){
							echo $paginator->prev("Prev");
						}
						 
						// the 'number' page buttons
						echo $paginator->numbers(array('modulus' => 2));
						 
						// for the 'next' button
						if($paginator->hasNext()){
							echo $paginator->next("Next");
						}
						 
						// the 'last' page button
						echo $paginator->last("Last");
					 
					echo "</div>";
					// pagination section End
				
				echo '</div></div>'.
					 '<div class="clear"></div>';
			
			?>
			
			<?php
	
		$num_request = count($peoples["request"]);
				
		echo '<div class="box">'.
				'<div class="boxheading">'.
					'<h1>'.
						'<div class="searchbox-icons">'.
							'<img src="'.MEDIA_URL.'/img/connection-icon.png" />'.
						'</div>'.
						'Invitations Pending'.
						'<span class="searchbox-total"> (<span id="your_accept_request">'.$num_request.'</span>)</span></h1>'.
						'<div class="boxheading-arrow"></div>'.
				'</div>'.
				'<div id="invite_loading" style="display:none; text-align:center;"><img src="'.MEDIA_URL.'/img/loading.gif" /></div>'.
				'<div class="margintop20">';
				echo '<div class="success_msg" id="message_accept" style="display:none;">You accept connection request successfully!</div>';
				echo '<div class="success_msg" id="message_decline" style="display:none;">You decline connection request successfully!</div>';
				
				if($num_request<=0){
					echo '<div class="searchresult-holder">'.
							'<div class="searchresult-rgt-full">'.
								'<ul>'.
									'<li>'.
										'<h1>No Pending Invitations .</h1>'.
									'</li>'.						
								'</ul>'.
							'</div>'.
							'<div class="clear"></div>'.
						'</div>';
				}else{
				
					foreach($peoples["request"] as $request){
						echo '<div class="searchresult-holder" id="'.$request["id"].'">'.
								'<div class="resultpic">'.
									'<a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$request["friend_id"].'">';
									if ($request["photo"] && file_exists(MEDIA_PATH.'/files/user/icon/'.$request["photo"])) {
										echo '<img src="'.MEDIA_URL.'/files/user/icon/'.$request["photo"].'" alt="" border="0"/></a>';
									}
									else {
										echo '<img src="'.MEDIA_URL.'/img/nophoto.jpg" alt="" border="0"/></a>';
									}
							echo '</div>'.
								'<div class="searchresult-rgt-full">'.
									'<ul>'.
										'<li>'.
											'<h1><a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$request["friend_id"].'">'.$request["firstname"].' '.$request["lastname"].'</a></h1>'.
										'</li>'.
										'<li>'.
											'<div style="display: block; float:right;"  id="notification-bttns">'.
                                               '<span id="response_102">'.
													'<a class="acceptbttn" href="javascript:invite_contacts('.$request["id"].',1,3)">Accept</a>'.
                                                '</span>'.
                                             '</div>'.
											  $request["tags"].
										'</li>'.
									'</ul>'.
								'</div>'.
								'<div class="clear"></div>'.
							'</div>';
					}
				
				}
				echo '</div></div>'.
					 '<div class="clear"></div>';
			
			?>
			
			<?php
	
		$num_invited = count($peoples["invited"]);
				
		echo '<div class="box">'.
				'<div class="boxheading">'.
					'<h1>'.
						'<div class="searchbox-icons">'.
							'<img src="'.MEDIA_URL.'/img/connection-icon.png" />'.
						'</div>'.
						'Pending connection requests'.
						'<span class="searchbox-total"> (<span id="your_invitation">'.$num_invited.'</span>)</span></h1>'.
						'<div class="boxheading-arrow"></div>'.
				'</div>'.
				'<div id="request_loading" style="display:none; text-align:center;"><img src="'.MEDIA_URL.'/img/loading.gif" /></div>'.
				'<div class="margintop20">';
				echo '<div class="success_msg" id="message_pending" style="display:none;">Your request for connection has been deleted successfully!</div>';
				
				if($num_invited<=0){
					echo '<div class="searchresult-holder">'.
							'<div class="searchresult-rgt-full">'.
								'<ul>'.
									'<li>'.
										'<h1>All your Invitations were replied.</h1>'.
									'</li>'.						
								'</ul>'.
							'</div>'.
							'<div class="clear"></div>'.
						'</div>';																																																																																															
				}else{
				
					foreach($peoples["invited"] as $invited){
						echo '<div class="searchresult-holder" id="'.$invited["id"].'">'.
								'<div class="resultpic">'.
									'<a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$invited["friend_id"].'">';
									if ($invited["photo"] && file_exists(MEDIA_PATH.'/files/user/icon/'.$invited["photo"])) {
										echo '<img src="'.MEDIA_URL.'/files/user/icon/'.$invited["photo"].'" alt="" border="0"/></a>';
									}
									else {
										echo '<img src="'.MEDIA_URL.'/img/nophoto.jpg" alt="" border="0"/></a>';
									}
							echo '</div>'.
								'<div class="searchresult-rgt-full">'.
									'<ul>'.
										'<li>'.
											'<h1><a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$invited["friend_id"].'">'.$invited["firstname"].' '.$invited["lastname"].'</a></h1>'.
										'</li>'.
										'<li>'.
											'<div class="listing-bttns">'. 
												'<a href="javascript:" onclick="remove_contact('.$invited["id"].','."'request'".',3)" class="poplight remove"/>Cancel Request</a>'.
											'</div>'.
											  $invited["tags"].
										'</li>'.
									'</ul>'.
								'</div>'.
								'<div class="clear"></div>'.
							'</div>';
					}
				
				}
				echo '</div></div>'.
					 '<div class="clear"></div>';
			
			?>	
</div>
 <script>
 function chat_Connection(contact_id) {
	document.getElementById("chat_connect"+contact_id).submit();
}
function remove_contact(contact_id,type,contact_type) {
	if (type == 'connection') {
		$("#contacts_loading").show();
	}
	else {
		$("#request_loading").show();
	}
	var checkstr =  confirm('Are you want to delete this?');
		if(checkstr == true){
  			$.ajax({
					url     : baseUrl+"/connections/remove_contact",
					type    : "GET",
					cache   : false,
					data    : {contact_id: contact_id,contact_type:contact_type},
					success : function(data){
					  if (type == 'connection') {
						  $("#contacts_loading").hide();
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$("#message_contact").slideDown('slow').delay(800).fadeOut();
						$("#"+contact_id).slideUp('slow');
						$("#your_connections").html(data);
					  }
					  else if (type == 'request') {
						 $("#request_loading").hide();
						$("#message_pending").slideDown('slow').delay(800).fadeOut();
						$("#"+contact_id).slideUp('slow');
						$("#your_invitation").html(data);
					  }
					},
					complete: function() {
					$("#"+contact_id).css({ opacity: 0.6 });		
					},
					error : function(data) {
					$("#"+contact_id).html(data);
					}
			});
		}
		else{
			  $("#contacts_loading").hide();
			  return false;
		}
}
function invite_contacts(contact_id,action,contact_type) {
			$("#invite_loading").show();
  			$.ajax({
					url     : baseUrl+"/connections/invite_update",
					type    : "GET",
					cache   : false,
					data    : {contact_id: contact_id,action:action,contact_type:contact_type},
					success : function(data){
						//$("html, body").animate({ scrollTop: 0 }, "slow");
						$("#invite_loading").hide();
						if (action == 1) {
							
							$("#message_accept").slideDown('slow').delay(800).fadeOut();
							$("#your_accept_request").html(data);
						}
						else {
							$("#message_decline").slideDown('slow').delay(800).fadeOut();
							$("#your_accept_request").html(data);
						}
						$("#"+contact_id).slideUp('slow');
						//$("#"+contact_id).html(data);
					  
					},
					complete: function() {
					$("#"+contact_id).css({ opacity: 0.6 });		
					},
					error : function(data) {
					$("#"+contact_id).html(data);
					}
			});

}


function userFollow(status,id,contact_id) {
		
	var user_id = document.getElementById('u_id'+contact_id).value;
	var following_type = document.getElementById('content_type').value;
	var following_id = document.getElementById('following_id'+contact_id).value;
	var start_date = document.getElementById('start_date'+contact_id).value;
	var end_date = document.getElementById('end_date'+contact_id).value;
	var connection = 'connection';
	$("#user_following_btn"+contact_id).html('<img src="http://media.networkwe.com/img/loading.gif" style="float:left;" />');
	//alert(following_id+"and"+start_date+"and"+user_id+"and"+following_type);
	$.ajax({
	url     : baseUrl+"/comments/add_follow",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,following_type:following_type,start_date:start_date,following_id:following_id,end_date:end_date,status:status,id:id,contact_id:contact_id,connection:connection},
	success : function(data){	
	responseArrays = data.split("-");
	//alert(responseArrays);
	$("#resultantDiv"+contact_id).html(responseArrays[0]);
	$("#user_following_btn"+contact_id).html(responseArrays[1]);
	},
	error : function(data) {
	$("#resultantDiv"+contact_id).html("error");
	}
	});
}
</script>
