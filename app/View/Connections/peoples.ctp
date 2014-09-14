<div class="leftcol" id="search_container">
	
	
	
	<?php
	
		$num_contacts = count($peoples["contacts"]);
				
		echo '<div class="box">'.
				'<div class="boxheading">'.
					'<h1>'.
						'<div class="searchbox-icons">'.
							'<img src="'.MEDIA_URL.'/img/connection-icon.png" />'.
						'</div>'.
						'Your Contacts'.
						'<span class="searchbox-total"> ('.$num_contacts.')</span></h1>'.
						'<div class="boxheading-arrow"></div>'.
				'</div>'.
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
									'<a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$contacts["friend_id"].'"><img src="'.MEDIA_URL.'/files/user/icon/'.$contacts["photo"].'" alt="" border="0"/></a>'.
								'</div>'.
								'<div class="searchresult-rgt-full">'.
									'<ul>'.
										'<li>'.
											'<h1><a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$contacts["friend_id"].'">'.$contacts["firstname"].' '.$contacts["lastname"].'</a></h1>'.
										'</li>'.
										'<li>'.															
											'<div class="listing-bttns">'. 
												'<a href="javascript:remove_contact('.$contacts["id"].','."'connection'".')" class="poplight remove"/>Remove Connection</a>'.
											'</div>'.
											  $contacts["tags"].
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
	
		$num_request = count($peoples["request"]);
				
		echo '<div class="box">'.
				'<div class="boxheading">'.
					'<h1>'.
						'<div class="searchbox-icons">'.
							'<img src="'.MEDIA_URL.'/img/connection-icon.png" />'.
						'</div>'.
						'Invitations Pending'.
						'<span class="searchbox-total"> ('.$num_request.')</span></h1>'.
						'<div class="boxheading-arrow"></div>'.
				'</div>'.
				'<div class="margintop20">';
				echo '<div class="success_msg" id="message_accept" style="display:none;">You accept connection request successfully!</div>';
				echo '<div class="success_msg" id="message_decline" style="display:none;">You decline connection request successfully!</div>';
				
				if($num_request<=0){
					echo '<div class="searchresult-holder">'.
							'<div class="searchresult-rgt-full">'.
								'<ul>'.
									'<li>'.
										'<h1>No Invitations Pending.</h1>'.
									'</li>'.						
								'</ul>'.
							'</div>'.
							'<div class="clear"></div>'.
						'</div>';
				}else{
				
					foreach($peoples["request"] as $request){
						echo '<div class="searchresult-holder" id="'.$request["id"].'">'.
								'<div class="resultpic">'.
									'<a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$request["friend_id"].'"><img src="'.MEDIA_URL.'/files/user/icon/'.$request["photo"].'" alt="" border="0"/></a>'.
								'</div>'.
								'<div class="searchresult-rgt-full">'.
									'<ul>'.
										'<li>'.
											'<h1><a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$request["friend_id"].'">'.$request["firstname"].' '.$request["lastname"].'</a></h1>'.
										'</li>'.
										'<li>'.
											'<div style="display: block; float:right;"  id="notification-bttns">'.
                                               '<span id="response_102">'.
													'<a class="acceptbttn" href="javascript:invite_contacts('.$request["id"].',1)">Accept</a>'.
                                                    '<a class="declinebttn" href="javascript:invite_contacts('.$request["id"].',-1)">Decline</a>'.
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
						'<span class="searchbox-total"> ('.$num_invited.')</span></h1>'.
						'<div class="boxheading-arrow"></div>'.
				'</div>'.
				'<div class="margintop20">';
				echo '<div class="success_msg" id="message_pending" style="display:none;">Your request for connection has been deleted successfully!</div>';
				
				if($num_invited<=0){
					echo '<div class="searchresult-holder">'.
							'<div class="searchresult-rgt-full">'.
								'<ul>'.
									'<li>'.
										'<h1>All your Invitations was replied.</h1>'.
									'</li>'.						
								'</ul>'.
							'</div>'.
							'<div class="clear"></div>'.
						'</div>';																																																																																															
				}else{
				
					foreach($peoples["invited"] as $invited){
						echo '<div class="searchresult-holder" id="'.$invited["id"].'">'.
								'<div class="resultpic">'.
									'<a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$invited["friend_id"].'"><img src="'.MEDIA_URL.'/files/user/icon/'.$invited["photo"].'" alt="" border="0"/></a>'.
								'</div>'.
								'<div class="searchresult-rgt-full">'.
									'<ul>'.
										'<li>'.
											'<h1><a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$invited["friend_id"].'">'.$invited["firstname"].' '.$invited["lastname"].'</a></h1>'.
										'</li>'.
										'<li>'.
											'<div class="listing-bttns">'. 
												'<a href="javascript:remove_contact('.$invited["id"].','."'request'".')" class="poplight remove"/>Cancel Request</a>'.
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
function remove_contact(contact_id,type) {
	var checkstr =  confirm('Are you want to delete this?');
		if(checkstr == true){
  			$.ajax({
					url     : baseUrl+"/connections/remove_contact",
					type    : "GET",
					cache   : false,
					data    : {contact_id: contact_id},
					success : function(data){
					  if (type == 'connection') {
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$("#message_contact").slideDown('slow').delay(800).fadeOut();
						$("#"+contact_id).slideUp('slow');
					  }
					  else if (type == 'request') {
						$("#message_pending").slideDown('slow').delay(800).fadeOut();
						$("#"+contact_id).slideUp('slow');
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
		return false;
		}
}
function invite_contacts(contact_id,action) {
  			$.ajax({
					url     : baseUrl+"/connections/invite_update",
					type    : "GET",
					cache   : false,
					data    : {contact_id: contact_id,action:action},
					success : function(data){
						//$("html, body").animate({ scrollTop: 0 }, "slow");
						if (action == 1) {
							$("#message_accept").slideDown('slow').delay(800).fadeOut();
						}
						else {
							$("#message_decline").slideDown('slow').delay(800).fadeOut();
						}
						//$("#"+contact_id).slideUp('slow');
						$("#"+contact_id).html(data);
					  
					},
					complete: function() {
					$("#"+contact_id).css({ opacity: 0.6 });		
					},
					error : function(data) {
					$("#"+contact_id).html(data);
					}
			});

}
</script>
