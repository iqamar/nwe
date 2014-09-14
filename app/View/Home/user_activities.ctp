 <?php 
 $str = ''; $flag = false;
 if ($user_birthday) {
$str .= '<div class="greybox">
		  <div class="greybox-div-heading">
			<h1>User Activities</h1>
		   </div>';
		foreach ($your_birthday_message as $ur_message) {
					$u_id = $ur_message['users_messages']['user_id'];
					$friend_id_array[] = $ur_message['users_messages']['friend_id'];
					
		}
		
		foreach ($user_birthday as $birth__Row) {
					$user_id = $birth__Row['users_profiles']['user_id'];
					$fullanme = $birth__Row['users_profiles']['firstname']." ".$birth__Row['users_profiles']['lastname'];
					$photo = $birth__Row['users_profiles']['photo'];
					$birth_date = $birth__Row['users_profiles']['birth_date'];
					$Birth_Day = $birth__Row[0]['numDays'];
				
				   if (in_array($user_id,$friend_id_array)) {
					   
				   }
				   else {
					$flag = true;
  $str .= '<div class="rgtwidget-listing2">
				<div class="rgtwidget-listing2-logo">
					<a href="/users_profiles/userprofile/'.$birth__Row['users_profiles']['user_id'].'">';
						 if ($photo && file_exists(MEDIA_PATH.'/files/user/icon/'.$photo)) {
								$str .= $this->Html->image(MEDIA_URL.'/files/user/icon/'.$photo,array('alt'=>'post-img'));
							  }
							  else { 	
								$str .= $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>'','alt'=>'post-img')); 
								} 
			$str .= '</a>
				</div>
			<div class="rgtwidget-listing2-rgt">
				<ul>
					<li>
						<h1>'; $str .= $this->Html->link($fullanme,
														array(
																'controller'=>'users_profiles',
																'action'=>'userprofile',$user_id
																));
				$str .= '</h1>
					</li>
                    <li>'.$birth__Row['users_profiles']['tags'].'</li>
					<li>
                     <input type="hidden" name="user_id" id="user_id" value="'.$uid.'" />
                    </li>
					<li>
                    	
                    	<a href="javascript:loadBirthdayPopup('.$user_id.')" class="birthday">Say Happy Birth Day</a>
                        &nbsp; 
                        <span class="posttime">';
                          if ($user_birthday){
								
									if ($Birth_Day == 0) {
										$str .= "Today";
									}
									else if($Birth_Day == 1) {
										$str .= "Tomorrow";
									}
									else if($Birth_Day >=2) {
										
										$str .= "After ".$Birth_Day." days";
									}
							}
                   $str .= '</span>
                        
                    </li>
				</ul>
			</div>
        <div class="clear"></div>
        </div>
		
		
		
		<div id="brithday_'.$user_id.'" class="share_popup_ajax" style="width:600px;"> 
		<div class="close" onclick="disableBirthdayPopup('.$user_id.')"></div>
    	<div class="greybox-div-heading"><h1>Wish Happy Birth Day to '.$fullanme.'</h1></div>
		<div class="userprofile-box">
			<div class="userprofile-box-pic">
            	   <a href="/users_profiles/userprofile/'.$birth__Row['users_profiles']['user_id'].'">';
						if ($photo && file_exists(MEDIA_PATH.'/files/user/icon/'.$photo)) {
								$str .= $this->Html->image(MEDIA_URL.'/files/user/thumbnail/'.$photo,array('alt'=>'post-img'));
							  }
							  else { 	
								$str .= $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>'','alt'=>'post-img')); 
							 }
				$str .= '</a>
                </div>
			<div class="userprofile-box-rgt">
				<ul>
					<li>
						<h1>'; $str .= $this->Html->link($fullanme,
														array(
																'controller'=>'users_profiles',
																'action'=>'userprofile',$user_id
																));
						
				$str .= '</h1>
				    </li>
					<li>'.$birth__Row['users_profiles']['tags'].'</li>
					<li>';
						if( $birth__Row['users_profiles']['city']) { $str .= 'City : <span class="redcolor">'.$birth__Row['users_profiles']['city'].'</span>'; }
                 $str .= '</li>
			    </ul>
		    </div>
			<div class="clear"></div>
	  </div>
     <div class="commentsbox">
        <span id="birthday_ajax_data'.$user_id.'">
        	<div id="birthday_loader" style="display:none; text-align:center;">';
			$str .= $this->Html->image(MEDIA_URL.'/img/loading.gif');
		 $str .= '</div>';
           foreach ($user_birthday_message as $message_row) {
			   		
			   		$id = $message_row['users_profiles']['user_id'];
					$full_name = $message_row['users_profiles']['firstname']." ".$message_row['users_profiles']['lastname'];
					$photos = $message_row['users_profiles']['photo'];
					$message = $message_row['users_messages']['user_message'];
					$friend_ids = $message_row['users_messages']['friend_id'];
					$date_created = $message_row['users_messages']['created'];
					$today = strtotime(date('Y-m-d H:i:s'));
					$distination = strtotime($date_created);
					$difference = ($today - $distination);
					$days = floor($difference/(60*60*24));
					$hours = floor($difference/(60*60));
				 if ($friend_ids == $user_id) {
    $str .= '<div class="comment-listing" id="commentsbox">
        	<div class="comment-listing-pic">';
            	 if ($photos && file_exists(MEDIA_PATH.'/files/user/icon/'.$photos)) {
							$str .= $this->Html->image(MEDIA_URL.'/files/user/icon/'.$photos,array('controller'=>'users_profiles','action'=>'userporfile',$friend_ids));
						  }
						  else { 	
							$str .= $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('controller'=>'users_profiles','action'=>'userporfile',$friend_ids)); 
						 }
      $str .= '</div>
             <div class="comment-listing-rgt">
                <ul>
                    <li>
                    
                    <a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$friend_ids.'">'.$full_name.'</a> 
                    '.$message.' 
                    <span class="timecount">'; if ($days >=1) $str .= $days."d"; else $str .= $hours."h";
					$str .= '</span>
                    </li>
                </ul>
            </div>
           <div class="clear"></div>
        </div>';
       }}
 $str .= '</span>
     <div class="clear"></div>
     <div class="writecomment">
     	<div class="comment-listing-pic">';
            	if ($imgname && file_exists(MEDIA_PATH.'/files/user/icon/'.$imgname)) {
            		$str .= $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$imgname,array('controller'=>'users_profiles','action'=>'myprofile'));
				}
				else {
				    $str .= $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('controller'=>'users_profiles','action'=>'myprofile')); 
				}
  $str .= '</div>
        <div class="writecomment-rgt">
                      <input type="text" placeholder="Happy Birth Day" id="birth_days_'.$user_id.'" style="width:450px; height:28px;" />
                      <a href="javascript:;" onclick="sayHappybirth('.$uid.','.$user_id.')" class="button" id="wish_btn" style="float:right;">Wish</a>
         </div>
        <div class="clear"></div>
        

     </div>  
	</div>
	</div>';
     
 
       }
    }
$str .= '</div><div id="backgroundPopup"></div>';
 }
 if ($flag == true) {
	 echo $str; 
 }
 ?>
<script>
function loadBirthdayPopup(ID) {

	$("#brithday_"+ID).fadeIn(0500); // fadein popup div
	$("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
	$("#backgroundPopup").fadeIn(0001);
}
function disableBirthdayPopup(ID) {
	$("#brithday_"+ID).fadeOut("normal");
	$("#backgroundPopup").fadeOut("normal");
}


function sayHappybirth(my_id,friend_id) {
	var brithday_text = document.getElementById("birth_days_"+friend_id).value;
	document.getElementById('wish_btn').style.display = 'none';
	$('#birthday_loader').show();
	$.ajax({
              url     : baseUrl+"/users_profiles/wish_birthday",
              type    : "POST",
              cache   : false,
              data    : {my_id: my_id,brithday_text:brithday_text,friend_id:friend_id},
              success : function(data){

				$("#birthday_ajax_data"+friend_id).html(data);
				document.getElementById("birth_days_"+friend_id).value = '';
				
              },
     		 complete: function () {
      		 $('#birthday_loader').hide();
                },
			  error : function(data) {
           $("#birthday_ajax_data"+friend_id).html("there is error");
        }
   });	
}
</script>