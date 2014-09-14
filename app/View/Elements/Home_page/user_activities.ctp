 <?php if ($user_birthday) {?>
<div class="greybox">
		  <div class="greybox-div-heading">
          
          <?php //echo $this->Html->link('See All Activities',array('controller'=>'users_profiles','action'=>'activities'), array('class'=>'seeall2'));?>
			<h1>User Activities</h1>
		</div>
        <?php
		foreach ($user_birthday as $birth__Row) {
					$user_id = $birth__Row['users_profiles']['user_id'];
					$fullanme = $birth__Row['users_profiles']['firstname']." ".$birth__Row['users_profiles']['lastname'];
					$photo = $birth__Row['users_profiles']['photo'];
					$birth_date = $birth__Row['users_profiles']['birth_date'];
					$Birth_Day = $birth__Row[0]['numDays'];
			?>
        <div class="rgtwidget-listing2">
				<div class="rgtwidget-listing2-logo">
					<a href="/users_profiles/userprofile/<?php echo $birth__Row['users_profiles']['user_id']?>">
						<?php if ($photo && file_exists(MEDIA_PATH.'/files/user/icon/'.$photo)) {
									echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$photo,array('alt'=>'post-img'));
							  }
							  else { 	
									echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>'','alt'=>'post-img')); 
								}
					  ?> 
					</a>
				</div>
			<div class="rgtwidget-listing2-rgt">
				<ul>
					<li>
						<h1><?php echo $this->Html->link($fullanme,
																	array(
																			'controller'=>'users_profiles',
																			'action'=>'userprofile',$user_id
																			));
						?></h1>
					</li>
                    <li><?php echo $birth__Row['users_profiles']['tags'];?></li>
					<li>
                     <input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
                    </li>
					<li>
                    	
                    	<a href="#?w=600" rel="brithday_<?php echo $user_id;?>" class="poplight birthday">Say Happy Birthday</a>
                        &nbsp; 
                        <span class="posttime">
                        <?php if ($user_birthday){
								
									if ($Birth_Day == 0) {
										echo "Today";
									}
									else if($Birth_Day == 1) {
										echo "Tomorrow";
									}
									else if($Birth_Day >=2) {
										
										echo "After ".$Birth_Day." days";
									}/*
									else if($Birth_Day ==3) {
										
										echo "After ".$Birth_Day." days";
									}
									else if($Birth_Day ==4) {
										
										echo "After ".$Birth_Day." days";
									}
									else if($Birth_Day ==5) {
										
										echo "After ".$Birth_Day." days";
									}
									else if($Birth_Day ==6) {
										
										echo "After ".$Birth_Day." days";
									}
									else if($Birth_Day ==7) {
										
										echo "After ".$Birth_Day." days";
									}
									else if($Birth_Day ==8) {
										
										echo "After ".$Birth_Day." days";
									}
									else if($Birth_Day ==9) {
										
										echo "After ".$Birth_Day." days";
									}*/
							}?>
                        </span>
                        
                    </li>
				</ul>
			</div>
        <div class="clear"></div>
        </div>
        
        
        <div id="brithday_<?php echo $user_id;?>" class="popup_block"> 
        
    <!--your content start-->
    	<div class="greybox-div-heading"><h1>Wish Happy Birthday to <?php echo $fullanme;?></h1></div>
		<div class="userprofile-box">
			<div class="userprofile-box-pic">
            	   <a href="/users_profiles/userprofile/<?php echo $birth__Row['users_profiles']['user_id']?>">
						<?php if ($photo && file_exists(MEDIA_PATH.'/files/user/icon/'.$photo)) {
									echo $this->Html->image(MEDIA_URL.'/files/user/thumbnail/'.$photo,array('alt'=>'post-img'));
							  }
							  else { 	
									echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>'','alt'=>'post-img')); 
							 }
					    ?>
					</a>
                </div>
			<div class="userprofile-box-rgt">
				<ul>
					<li>
						<h1><?php echo $this->Html->link($fullanme,
																	array(
																			'controller'=>'users_profiles',
																			'action'=>'userprofile',$user_id
																			));
						?>
						
						</h1>
				    </li>
					<li> <?php echo $birth__Row['users_profiles']['tags'];?></li>
					<li><?php 
						if( $birth__Row['users_profiles']['city']) {?> City : <span class="redcolor"><?php echo $birth__Row['users_profiles']['city'];?></span> <?php }?>
                    </li>
			    </ul>
		    </div>
			<div class="clear"></div>
	  </div>
     <div class="commentsbox">
        <span id="birthday_ajax_data<?php echo $user_id?>">
        	<div id="birthday_loader" style="display:none; text-align:center;">
			<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
		   </div>
           <?php foreach ($user_birthday_message as $message_row) {
			   		
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
			   ?>
        	<div class="comment-listing" id="commentsbox">
        	<div class="comment-listing-pic">
            	 <?php if ($photos && file_exists(MEDIA_PATH.'/files/user/icon/'.$photos)) {
								echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$photos,array('alt'=>'post-img'));
						  }
						  else { 	
								echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>'','alt'=>'post-img')); 
						 }
					  ?>  
            </div>
             <div class="comment-listing-rgt">
                <ul>
                    <li>
                    
                    <a href="#"><?php echo $full_name;?></a> 
                    <?php echo $message;?> 
                    <span class="timecount"><?php if ($days >=1) echo $days."d"; else echo $hours."h"; ?></span>
                    </li>
                </ul>
            </div>
           <div class="clear"></div>
        </div>
       <?php }}?>
 		</span>
     <div class="clear"></div>
     <div class="writecomment">
     	<div class="comment-listing-pic">
			<?php
            	if ($imgname && file_exists(MEDIA_PATH.'/files/user/icon/'.$imgname)) {
            		echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$imgname,array('alt'=>'user-pic'));
				}
				else {
					echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>'','alt'=>'post-img')); 
				}
            ?> 
      	</div>
        <div class="writecomment-rgt">
                      <input type="text"  onfocus="if(this.value=='Happy Birthday') this.value='';" onblur="if(this.value=='') this.value='Happy Birthday';" value="Happy Birthday" id="birth_days_<?php echo $user_id; ?>" style="width:450px; height:28px;" />
                      <a href="javascript:;" onclick="sayHappybirth('<?php echo $uid; ?>','<?php echo $user_id; ?>')" class="button" style="float:right;">Wish</a>
         </div>
        <div class="clear"></div>
        
     </div>  
     
       </div>
	   <!--your content end-->
	</div>
        
        
        
       <?php }?> 
</div>
<?php }?>
<script>
function sayHappybirth(my_id,friend_id) {
	
	var brithday_text = document.getElementById("birth_days_"+friend_id).value;
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
