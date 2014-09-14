<?php if ($userInfo['users']['id']) { $uid = $userInfo['users']['id'];}?>
  <?php
	  	$dob = $userRec['users_profiles']['birth_date'];
		$marital_status = $userRec['users_profiles']['marital_status'];
		$hide_year = $userRec['users_profiles']['hide_year'];
		$marital_status = $userRec['users_profiles']['marital_status'];
		$gender = $userRec['users_profiles']['gender'];
		$mobile_hide = $userRec['users_profiles']['mobile_hide'];
		$phone_hide = $userRec['users_profiles']['phone_hide'];
		$zip_hide = $userRec['users_profiles']['zip_hide'];
		$address1_hide = $userRec['users_profiles']['address1_hide'];
		$address2_hide = $userRec['users_profiles']['address2_hide'];
		$marital_status_hide = $userRec['users_profiles']['marital_status_hide'];
		$gender_hide = $userRec['users_profiles']['gender_hide'];
	  ?>
  <div class="success_msg" id="message_remove_connection" style="display:none;">Your connection has been deleted successfully!</div> 
  <div class="success_msg" id="message_remove_request" style="display:none;">Your connection request has been removed successfully!</div>   
  <div class="profile-user userprofile-form">
  	<?php if($userRec['users_profiles']['hiring'] == 1){  ?>
    	<div class="availabletag">Available for New Challenges</div>
       <?php }?>
	<div class="profile-user-pic">
    <?php if ($userRec['users_profiles']['photo']) {
			if (file_exists(MEDIA_PATH.'/files/user/logo/'.$userRec['users_profiles']['photo'])) {
				echo $this->Html->image(MEDIA_URL.'/files/user/logo/'.$userRec['users_profiles']['photo'],array('style'=>''));
			}
			else {
				echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>''));
			}
		 } 
		 else {
	   		echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>''));
		}?> 
    </div>
    <div class="profile-user-rgt">
    	<ul>
	          <li>
	            <h1><?php echo $userRec['users_profiles']['firstname'];
					if ($userRec['users_profiles']['lastname_hide'] != 1) { echo " ".$userRec['users_profiles']['lastname']; }?></h1>
              </li>
	           <li><?php if ($userRec['users_profiles']['tags_hide'] != 1) { echo $userRec['users_profiles']['tags']; }?> </li>
	          <li>
   
			  <?php 
			  if ($userRec['users_profiles']['city_hide'] != 1) {
			  	echo $userRec['users_profiles']['city'];
			  }
				if ($userRec['countries']['name'] && $userRec['users_profiles']['country_id_hide'] != 1) { echo ", ".$userRec['countries']['name']; } 
			  ?>
                <?php if ($userRec['industries']['title']&& $userRec['users_profiles']['industry_id_hide'] != 1) {?> 
               	<a>|</a><?php echo " ".$userRec['industries']['title'];?><?php }?></li>
             <?php  $i =1; foreach ($uSers_exp as $key=>$experience_val) {
							foreach ($experience_val as $totalExp) {  ?>
              <li><?php 
			  			if ($i==1 && $totalExp['users_experiences']['end_date'] != 'Present') { //echo $user_Edu['companies']['title']; 
								 echo "Previous: ".$totalExp['companies']['title']; break;
			  			} else if($i == 2) {?>
             				 Previous: <?php echo $totalExp['companies']['title']; break;}?>
              	<?php $i++;} }?>
                </li>
              <li>
              <?php foreach ($lastEducation as $last_Edu) {?>
              <li>Education: <?php echo $last_Edu['qualifications']['title'];?></li>
              <?php } ?>

              <li>
               <div class="profile-user-bttns">
                <div class="profileuser-activities">
                  <div class="activity-icon">
              		<?php
					echo $this->Html->image(MEDIA_URL.'/img/big-icon-experties.png',array('style'=>''));
					?>
		     	 </div>
                    <ul>
                      <li><strong>Expertise</strong> </li>
                      <li><span class="smalltext">
                      <?php  if (sizeof($total_user_experience)) {
                         $present_start_date =date("d-m-Y");
                         $is_present = false;
						 
						 $i = 1;
					  	
						$year_diff = '';
						
						
                        foreach ($total_user_experience as $countExp) {
                            $start_date = $countExp['users_experiences']['start_date'];
                            $start_date = '01-'.$start_date;
                            $start_date = new DateTime($start_date);
                            
                            if ($countExp['users_experiences']['end_date'] != 'Present') {
                                $end_date = $countExp['users_experiences']['end_date'];
                                $end_date = '01-'.$end_date;
                                $end_date = new DateTime($end_date);
                                $diff = $start_date->diff($end_date);
                                $year_diff += $diff->y;
                                $month_diff += $diff->m;
                            }
                            else {

							if($present_start_date > date($start_date)){
								
								if ($i <= 1) {
									$new_start_date = $start_date;
									$present_start_date = $start_date;
									$is_present = true;
								}
								else if ($i > 1) {
									//echo $i;
									$greater_present_start_date = $present_start_date;
									
									$present_start_date = $start_date;
									
									if ($present_start_date <= $greater_present_start_date) {
										
										$is_present = true;
									
										$new_start_date = $present_start_date;
									}
								}
								
							}
							$i++;
						}
                            
                        }
                        if($is_present){
                            $end_date = new DateTime(date("d-m-Y"));
                            $diff = $new_start_date->diff($end_date);
                            $year_diff += $diff->y;
                            $month_diff += $diff->m;
                        }
                            
                        $years_in_months = $month_diff/12;
                            $years_of_month = intval($years_in_months);
                        if ($years_of_month) { 
                            $year_diff += $years_of_month;
                        }
                      if ($year_diff>=1) { echo $year_diff." Years";} else {echo $month_diff." months";}
                      }?>
                      </span></li>
                  </ul>    
               </div>
                <a href="<?php echo NETWORKWE_URL;?>/connections/index/<?php echo $friend_id;?>"> 
                 <div class="profileuser-activities connection-bttn">
                	<div class="activity-icon">
                <?php 
                    echo $this->Html->image(MEDIA_URL.'/img/big-icon-connect.png',array('style'=>''));
                ?>
                </div>
                <ul>
                    <li><strong> <?php echo "Connections";?></strong> </li>
                    <li><span class="smalltext">
                        <?php if ($totalUserRequestedConnections) {
                                    echo $totalUserRequestedConnections;
                                }
                                else {
                                    echo "0"; 
                                    }
                        ?>
                        </span>
                   </li>
                </ul>
   	          </div>
              </a>
                <a href="#?" rel="following_popup" class="poplight totalnumber">
         		 <div class="profileuser-activities">
				<div class="activity-icon">
                	<?php echo $this->Html->image(MEDIA_URL.'/img/big-icon-follow.png',array('style'=>''));?>
			    </div>
                <ul>
                   	<li><strong>Following</strong> </li>
                    <li><span class="smalltext"><?php if ($following) echo $following; else echo "0";?></span></li>
           		</ul>
   	     	  </div>
          		 </a>
                <a href="#?" rel="followers_popup" class="poplight totalnumber">
          <div class="profileuser-activities">
				<div class="activity-icon">
                	<?php echo $this->Html->image(MEDIA_URL.'/img/big-icon-followers.png',array('style'=>''));?>
			    </div>
                <ul>
                   	<li><strong>Followers</strong> </li>
                    <li><span class="smalltext"><?php if ($followers) echo $followers; else echo "0";?></span></li>
            </ul>
   	      </div>
          </a>
          <?php
			if ($starsign__Row['Star_sign']['id'] != '') {
						$user_id = $userRec['users_profiles']['user_id'];
						$id = $starsign__Row['Star_sign']['id'];
			?>
            <a href="javascript:showStarSign('<?php echo $id?>','<?php echo $friend_id?>','starsign')" class="poplight">
              <div class="profileuser-activities">
                    <div class="activity-icon">
                        <?php echo $this->Html->image(MEDIA_URL.'/files/starsign/'.$starsign__Row['Star_sign']['icon'],
                                                                                                array('style'=>''));?>
                    </div>
                    <ul>
                        <li><strong>Star Sign</strong> </li>
                        <li>
                            <span class="smalltext">
                            <?php echo $starsign__Row['Star_sign']['name'];?>
                           </span>
                       </li>
                    </ul>
                 
              </div>
           </a>
          
		  <?php }?> 
                </div> 
                <div class="clear"></div>
		      </li>
              <li>
              	<div class="profile-link">
              	Public Profile -  <a href="<?php echo NETWORKWE_URL."/pub/".$userRec['users_profiles']['handler'];?>" target="_blank"><?php echo NETWORKWE_URL."/pub/".$userRec['users_profiles']['handler'];?></a>
                </div>
                <div class="clear"></div>
              </li>
          </ul>
    </div>
    <div class="clear"></div>
     <!-- Activities start -->
	<div class="activities-div">
         <?php if ($uid != $friend_id) { 
              	$connection_check = $checkRequest[0]['connections'];
				?>
                <span id="approval_pending_ajax">
				<?php	if (empty($checkRequest)){?>
                  	 <!-- user connection form start-->
                     <!--<div id="request_loader" style="display:none; float:left;">
							<?php //echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
					</div-->
                     <span id="connectUser_<?php echo $friend_id?>">
                     	
					  <a href="#" class="connect" data-toggle="modal" data-target="#connectdiv">Connect</a>
                      </span>
                      
                      <!-- user connection form end-->
                      <?php }
					  else if ($connection_check['request'] == 0) {
					  ?>
                     
                       <span id="request_canel">
                         <a class="connect" onmouseover="cancelRequest()" id="approval">Approval Pending</a>
                     	 <a href="#" class="remove" data-toggle="modal" onmouseout="showApproval()" data-target="#deleterequest" style="display:none;" id="request" >
                        Cancel Request</a>     			 
                      </span>
                     
                     

					  <?php	} else if ($connection_check['request'] == 1) {
					  ?> 
                       <a id="go_recommendation" style="cursor:pointer;" class="recommendation">Recommendation</a>
                      <?php }?>
                      
                    </span>
                       <a href="#" style="display:none;" id="connect_user" class="connect" data-toggle="modal" data-target="#connectdiv">Connect</a>
                      <!-- user Message form start-->
					  <a href="#?" rel="sendmessage" class="sendmsg poplight">Send Message</a>
                      <!-- user Message form end-->
                      
                      <!-- user chat connection form start-->
                      <?php  if (empty($chatRequest) && $uid != $friend_id){?>
                      	<form method="post" id="chat_connect" name="chat_connect" action="/users_profiles/invite_for_chat" >
                			<input type="hidden" name="user_id" id="user_id" value="<?php echo $uid?>" />
                			<input type="hidden" name="friend_id" id="friend_id" value="<?php echo $friend_id;?>" />
                			<input type="hidden" name="status" value="0" />
                			<input type="hidden" name="invite_date" id="invite_date" value="<?php echo $dt = date('Y-m-d h:i:s');?>" />
                        </form>
                     	 <a href="#" class="chat" onclick="chat_Connection();">Connect to chat</a>
                      <?php }?>
                      <!-- user chat connection form end-->
                
                      <!-- User Follow Start-->
                      <div id="user_following_btn">
						  <?php 
                          if (sizeof($checkUserFollowings)== 0 ){?>
                            <a href="Javascript:userFollow('2');" id="follow_user1" class="follow"><?php echo __('Follow');?></a>
                          <?php } 
                          else {
                                if ($following_status == 2) {
                            ?>
                                 <a href="Javascript:userFollow('0',<?php echo $following_id ?>);" id="following_user1" class="unfollow"><?php echo __('Following');?></a>
                          <?php }
                                else {
                                ?>
                                <a href="Javascript:userFollow('2',<?php echo $following_id ?>);" id="follow_user1" class="follow"><?php echo __('Follow');?></a>
                          <?php }}?>
                       </div>
                        <input type="hidden" name="u_id" id="u_id" value="<?php echo $uid;?>" />
						<input type="hidden" name="content_type" id="content_type" value="users" />
			 			<input type="hidden" name="following_id" id="following_id" value="<?php echo $friend_id;?>" />
                		<input type="hidden" name="start_date" id="start_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
                 		<input type="hidden" name="end_date" id="end_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
                      <!-- User Follow End-->                
                   <?php }?>  	

          <div id="dd-more">
			<ul>
				<li class="has-sub"> 
                	<a href=""></a>
					<ul>
						<li><a href="<?php echo NETWORKWE_URL;?>/home/myupdates/<?php echo $friend_id;?>"><div class="icon-updates"></div>Updates</a></li>
						<li><a href="<?php echo NETWORKWE_URL;?>/tweets/profile/<?php echo $friend_id;?>"><div class="icon-tweets"></div>Tweets</a></li>
                        <li><a href="<?php echo NETWORKWE_URL;?>/blogs/"><div class="icon-blog"></div>Blogs</a></li>   
						<li><a href="<?php echo NETWORKWE_URL;?>/news/userarticles/<?php echo $friend_id;?>"><div class="icon-articles"></div>Articles</a></li>  
			<?php 
              if (!empty($checkRequest)){
                    if($connection_check['request'] == 1){?> 
                         <li><a href="#" class="remove" data-toggle="modal" data-target="#deleteupdatebox" id="remove_connection">
                            <div class="icon-remove-conn"></div>Remove Connection</a> 
                         </li>
                             
                        <?php }}?>
					</ul>
			  </li>
			</ul>
		</div>
          <div class="clear"></div>
     </div>
     <!-- Activities start --> 
  </div>
  <div class="clear"></div>
  <div class="modal fade middlepopup" id="deleteupdatebox" tabindex="-1" role="dialog" aria-labelledby="deletebox" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <a class="popupclose" data-dismiss="modal" aria-hidden="true"></a>
            <h1 class="modal-title" id="myModalLabel">Delete</h1>
          </div>
          <div class="modal-body">
            <h2>Are You sure want to remove contact ?</h2>
          </div>
          <div class="modal-footer">
           <button type="button" onclick="return remove_contact('<?php echo $connection_check['id'];?>','0','remove_connection');" class="btn submitbttn" data-dismiss="modal">Yes</button>
            <button type="button" class="btn canclebttn" data-dismiss="modal">No</button>
          </div>
        </div>
      </div>
</div>
       <!--- Delete Box Ends Here ---> 
    <div class="modal fade middlepopup" id="deleterequest" tabindex="-1" role="dialog" aria-labelledby="deletebox" aria-hidden="true">
        <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                    	<a class="popupclose" data-dismiss="modal" aria-hidden="true"></a>
                   		 <h1 class="modal-title" id="myModalLabel">Delete</h1>
                    </div>
                    <div class="modal-body">
                    <h2>Are You sure want to cancel connection request?</h2>
                    </div>
                    <div class="modal-footer">
                    <button type="button" onclick="return remove_contact('<?php echo $connection_check['id'];?>','','request_canel');" class="btn submitbttn" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn canclebttn" data-dismiss="modal">No</button>
                    </div>
                </div>
        	</div>
        </div>
    <!--- Delete Box Ends Here ---> 
  
  <!-- Profile basic info end--> 
  <?php if ($userRec['users']['email']) {?>
<!-- Contact info start-->  
<div class="profile-box">
    <div class="profile-box-heading">
	<h1>
		<div class="profile-box-icon">
            <?php echo $this->Html->image(MEDIA_URL.'/img/contact-icon.png',array('style'=>''));?>
		</div>
		<div class="heading-text">Contact Information</div>
	</h1>
    </div>
    <div>
      <ul>
      <?php  if ($email_display == 1) {?>
        <li><strong>Email</strong><span></span>: <?php echo $userRec['users']['email'];?></li>
        <?php }?>
      <?php if ($userRec['users_profiles']['mobile'] && $mobile_hide != 1) {?>
       		<li><strong>Mobile: </strong>&nbsp;&nbsp;<?php echo $userRec['users_profiles']['mobile'];?></li><?php }?>
       <?php if ($userRec['users_profiles']['phone'] && $phone_hide != 1) {?>
       		<li><strong>Phone: </strong>&nbsp;&nbsp;<?php echo $userRec['users_profiles']['phone'];?></li><?php }?>
       <?php if ($userRec['users_profiles']['zip'] && $zip_hide != 1) {?>
       		<li><strong>P.O.Box: </strong>&nbsp;&nbsp;<?php echo $userRec['users_profiles']['zip'];?></li><?php }?>
       <?php if ($userRec['users_profiles']['address1'] || $userRec['users_profiles']['address2']) {?>
       			<?php if ($address1_hide != 1) {?>	
                    <li><strong>Address: </strong>&nbsp;&nbsp;<?php echo $userRec['users_profiles']['address1'];
				}
						if ($userRec['users_profiles']['address2'] && $address2_hide != 1) { echo "&nbsp;<a>|</a>&nbsp;".$userRec['users_profiles']['address2']; }?></li>
			<?php }?>
      </ul>
    </div>
	<div class="clear"></div>
</div>
<!-- Contact info end-->

<?php } if ($userRec['users_profiles']['summary']) {?>
<!-- Profile Summary start--> 
<div class="profile-box">
    <div class="profile-box-heading">
	<h1>
		<div class="profile-box-icon">
            <?php echo $this->Html->image(MEDIA_URL.'/img/summary-icon.png',array('style'=>''));?>
		</div>
		<div class="heading-text">Summary</div>
	</h1>
    </div>
    <div>
     <?php echo strip_tags($userRec['users_profiles']['summary']);?>
    </div>
	<div class="clear"></div>
  </div>
<!-- Profile Summary end-->   
<?php  }?>
 <?php if (sizeof($uSers_exp[0]) != 0 || sizeof($uSers_exp[1]) != 0) {?>
<!--  experience--> 
<div class="profile-box">
        <div class="profile-box-heading">
        <h1>
            <div class="profile-box-icon">
                <?php echo $this->Html->image(MEDIA_URL.'/img/experience-icon.png',array('style'=>''));?>
            </div>
            <div class="heading-text">Experience</div></h1>
        </div>
        <?php 
             foreach ($uSers_exp as $key=>$experience_val) {
				foreach ($experience_val as $totalExp) {
            ?>
        <div class="profile-box-content experience">
            <div class="exp-com-logo"> 
                <a href="#">
                <?php 
                    $job_description = $totalExp['users_experiences']['responsibilities'];
					if ($totalExp['companies']['logo']){
						if(file_exists(MEDIA_PATH.'/files/company/logo/'.$totalExp['companies']['logo'])){
							$totalExp_logo=MEDIA_URL.'/files/company/logo/'.$totalExp['companies']['logo'];
						}else{
							$totalExp_logo=MEDIA_URL.'/img/nologo.jpg';
						}
					 }
					 else { 	
							$totalExp_logo=MEDIA_URL.'/img/nologo.jpg'; 
					 }
					 echo $this->Html->image($totalExp_logo);
					
					?>
                </a>
            </div>
            <div class="profile-box-content-rgt">
            <ul>
                <li>
                  <h1><a href="#"><?php echo $totalExp['users_experiences']['designation'];?></a></h1>
                </li>
                <li><a href="#"><?php echo $totalExp['companies']['title'];?></a></li>
                <li><?php echo $totalExp['users_experiences']['start_date']." to ".$totalExp['users_experiences']['end_date']; 
                echo $totalExp['users_experiences']['location'] ? ' - '.$totalExp['users_experiences']['location'] : '';?> </li>
                <li><?php echo $job_description; ?></li>
            </ul>
            </div>
            <div class="clear"></div> 
        </div>
        <?php }}?>
    <div class="clear"></div> 
  	</div>	
    <!-- education--> 
 <?php } if ($uSerEDU) {?>
 <!-- education--> 
<div class="profile-box">
        <div class="profile-box-heading">
        <h1> <div class="profile-box-icon">
                 <?php echo $this->Html->image(MEDIA_URL.'/img/education-icon.png',array('style'=>''));?>
            </div>
        <div class="heading-text">Education</div></h1>
        </div>
        <?php foreach ($uSerEDU as $Uedu) {?>
        <div class="profile-box-content">
          <ul>
          <li>
            <h1><a href="#"><?php echo $Uedu['institutes']['title'];?></a></h1>
          </li>
           <li><?php echo $Uedu['qualifications']['title']." in ".$Uedu['users_qualifications']['field_study'];?></li>
           <li><?php echo $Uedu['users_qualifications']['start_date']." to ".$Uedu['users_qualifications']['end_date'];?></li>
          </ul>
        </div>
 	<?php }?>
	<div class="clear"></div> 
  	</div>	
 <?php  }?>
 <!-- Skill and experize--> 
<?php if ($userHaveSkills) {?>
<div class="profile-box">
    <div class="profile-box-heading">
	<h1>
		<div class="profile-box-icon">
            <?php echo $this->Html->image(MEDIA_URL.'/img/skills-icon.png',array('style'=>''));?>
		</div>
		<div class="heading-text">Skill &amp; Expertise</div>
        </h1>
    </div>
    <?php
	if ($userHaveSkills){ $i=1;
		foreach ($userHaveSkills as $userListSkill) {
			$skill_ids = $userListSkill['skills']['id'];
			?>
	<div class="endouresskill">
		<div class="skill-experties-left"> 
   		  <div class="skill-experties-blockes">
            	<a href="#?" id="skill_counter_<?php echo $userListSkill['skills']['id'];?>" rel="skillbox<?php echo $userListSkill['skills']['id'];?>" class="poplight blockers-number"><?php echo $userListSkill[0]['total_recommendations'];?></a>
                <div class="blockers-text"><a href="#"><?php if ($i!=1) echo ""; echo $userListSkill['skills']['title'];?></a></div>
				<div class="clear"></div>
            </div>
		</div>
        <input type="hidden" id="friend_user_id" value="<?php echo $friend_id;?>" />
        <input type="hidden" id="recommends" value="<?php echo $uid;?>" />
        <input type="hidden" id="skill_id_<?php echo $userListSkill['skills']['id'];?>" value="<?php echo $userListSkill['skills']['id'];?>" />
        <input type="hidden" id="status" value="0" />
        <input type="hidden" id="recommend_id" value="0" />
        <input type="hidden" id="start_date" value="<?php echo $start_dt = date("Y-m-d H:i:s")?>" />
        <input type="hidden" id="end_date" value="<?php echo $end_dt = date("Y-m-d H:i:s")?>" />
         <div class="recommendationlink">
        <?php 
			$flag = false;
			foreach ($recommendsRecords as $skillRecommendedbyUser) {
				if ($userListSkill['users_skills']['skill_id'] == $skillRecommendedbyUser['skill_recommendations']['skill_id']) {
					 if ($skillRecommendedbyUser['skill_recommendations']['recommends'] == $uid){
 						 if ($skillRecommendedbyUser['skill_recommendations']['recommendation'] == 0) {?>
                               <span class="recommend" id="recommend<?php echo $userListSkill['users_skills']['skill_id']?>"
                                onclick="removeSkill('<?php echo $userListSkill['skills']['id'];?>','1','<?php echo $skillRecommendedbyUser['skill_recommendations']['id']?>');">
                                        <a href="javascript:" class="recommendationlink">Recommend</a>
                                </span>
                                   
 								<?php } else if($skillRecommendedbyUser['skill_recommendations']['recommendation'] == 1){?>
                                   <span class="recommend" id="recommended<?php echo $userListSkill['users_skills']['skill_id']?>" onclick="removeSkill('<?php echo $userListSkill['skills']['id'];?>','0','<?php echo $skillRecommendedbyUser['skill_recommendations']['id']?>');">
                                        <a href="javascript:" class="recommended-link">Recommended</a>
                                   </span>
                                    <?php }}  
									 $flag=true; } //if condition end
									} //loop end here
									?>
                          <?php if ($flag == false) { 
									 ?>
                                    <span class="recommend" id="recommend<?php echo $userListSkill['skills']['id'];?>" style="cursor:pointer; display:block;" onclick="recommendSkill('<?php echo $userListSkill['skills']['id'];?>','1');">
                                       <a href="javascript:" class="recommendationlink">Recommend</a>
                                   </span>
									<?php }?>
        
        </div>
        <span id="spanid_<?php echo $userListSkill['skills']['id'];?>">
        <div class="skill-experties-right">
			<ul class="skillspeople-pic">
            	<?php 
				if ($userListSkill[0]['total_recommendations'] !=0) {?>	
            		<li><a href="#?" rel="skillbox<?php echo $userListSkill['skills']['id'];?>" onclick="showProfiles('<?php echo $skill_ids ?>','<?php echo $friend_id ?>');" class="poplight see-skill-people">
                    </a>
                    </li>
                    <?php }?>
            <?php foreach ($uers_RecommendedListingwithoutAjax as $withoutAjaxUserShow) { 
					if ($withoutAjaxUserShow['skill_recommendations']['skill_id'] == $userListSkill['skills']['id']) {?>
				<li><?php 
				echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$withoutAjaxUserShow['users_profiles']['photo'], array('style'=>''));
					}
				}?>			
                </li>
			</ul>
        </div>
     </span>
	<div class="clear"></div>
    </div>
<!--- Like Box Starts Here --->
    <div id="skillbox<?php echo $userListSkill['skills']['id'];?>" class="popup_block">
    <!--your content start-->
      <div class="heading"><h1>People with Same Skills & Expertise</h1></div>
      <div class="popupmsg"><span id="count_people_<?php echo $skill_ids;?>"><?php echo $userListSkill[0]['total_recommendations']?></span> <?php echo " people recommended ".$userRec['users_profiles']['firstname']." for ".$userListSkill['skills']['title'];?></div>
        <div class="scroller" id="resultsDiv_<?php echo $userListSkill['skills']['id'];?>">
            
      </div>
        <!--your content end-->
    </div>
    
<!--- Like Box Ends Here --->
<!--- SECOND POPUP Here --->
	<div id="profile_popup_ajax<?php echo $userListSkill['skills']['id'];?>" class="share_popup_ajax">
    <div class="close" onclick="disablePopup('<?php echo $userListSkill['skills']['id'];?>')"></div>
    <!--your content start-->
      <div class="heading"><h1>People with Same Skills & Expertise</h1></div>
      <div class="popupmsg"><span id="count_people_<?php echo $skill_ids;?>"><?php echo $userListSkill[0]['total_recommendations']?></span> <?php echo " people recommended ".$userRec['users_profiles']['firstname']." for ".$userListSkill['skills']['title'];?></div>
        <div class="scroller" id="popupContent_<?php echo $userListSkill['skills']['id'];?>">
        
        </div>
        <!--your content end-->
    </div>
	<div id="backgroundPopup"></div>
	<?php $i++;}?>
    <?php }?>
	<div class="clear"></div>
</div>

<?php } if ($dob || $marital_status || $gender) {
			
			$month = date('F',strtotime($dob));
			$day = date('d',strtotime($dob));
			$year = date('Y',strtotime($dob));
			?>
	<!-- Personal Detail start -->
	<div class="profile-box">
        <div class="profile-box-heading">
            <h1>
                <div class="profile-box-icon">
                    <?php echo $this->Html->image(MEDIA_URL.'/img/personal_info_icon.png',array('style'=>''));?>
                </div>
                <div class="heading-text">Personal Details</div>
            </h1>
        </div>
        <div>
          <ul>
            <?php if ($dob) { ?><li><strong>Birthday:</strong>&nbsp;&nbsp;&nbsp;<?php echo $month." ".$day; if ($hide_year != 1) { echo ", ".$year; }?></li><?php }?>
            <?php if ($gender && $gender_hide != 1) { ?><li><strong>Gender: </strong>&nbsp;&nbsp;&nbsp;<?php echo $gender; ?></li><?php }?>
          <?php if ($marital_status && $marital_status_hide != 1) { ?><li><strong>Marital Status: </strong>&nbsp;&nbsp;&nbsp;<?php echo $marital_status; ?></li><?php }?>
		  <?php if ($userRec['nationality']['name'] && $userRec['users_profiles']['nationality_hide'] != 1) { echo "<li><strong>Nationality: </strong>&nbsp;&nbsp;&nbsp;".$userRec['nationality']['name']."</li>"; }?>
          </ul>
        </div>
        <div class="clear"></div>
</div>
	<!-- Personal Detail end -->

<?php } if ($getTotalUser) {?>
 <!-- Skill and experize end--> 
 
 <!-- Connection Start --> 
 <div class="profile-box">
    <div class="profile-box-heading">
    <div class="profile-box-heading-rgt">
 	<a href="Javascript:sharedConnection('<?php echo $uid?>','<?php echo $friend_id?>','all');">All<?php  if($user_connections) echo '('.$user_connections.')';
 	?>
    </a>
        <a href="Javascript:sharedConnection('<?php echo $uid?>','<?php echo $friend_id?>','shared');">Shared(<?php echo $shared_Users ;?>)</a>
    </div>
	<h1>
		<div class="profile-box-icon">
        	<?php echo $this->Html->image(MEDIA_URL.'/img/connection-icon.png',array('style'=>''));?>
		</div>
		<div class="heading-text">Connections</div></h1>
    </div>
     <div id="users_shared_connection" style="position:relative;">
     <?php 
		foreach ($getTotalUser as $cgetuser) {
			$userId = $cgetuser['users_profiles']['user_id'];
	?>
	<div class="profile-connections">
		  <div class="profile-connections-pic">
          <?php 
		  if ($cgetuser['users_profiles']['photo']){
			if(file_exists(MEDIA_PATH.'/files/user/icon/'.$cgetuser['users_profiles']['photo'])){
				$cgetuser_photo=MEDIA_URL.'/files/user/icon/'.$cgetuser['users_profiles']['photo'];
			}else{
				$cgetuser_photo=MEDIA_URL.'/img/nophoto.jpg';
			}
		 }
		 else { 	
				$cgetuser_photo=MEDIA_URL.'/img/nophoto.jpg'; 
		 }
		 echo $this->Html->image($cgetuser_photo,array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$userId)));
		  
		
		  ?>
		  </div>
		<div class="profile-connections-rgt">
		  <ul>
			  <li>
				  <h1><?php echo $this->Html->link($cgetuser['users_profiles']['firstname']." ".$cgetuser['users_profiles']['lastname'],
																															array(
																												'controller'=>'users_profiles',
																												'action' => 'userprofile',
																												$userId));?></h1>
			  </li>
			  <li><?php echo substr($cgetuser['users_profiles']['tags'],0,40);?></li>
		  </ul>
		</div>
        <div class="clear"></div>
	</div>
	<?php }?>
    </div>
    <div class="clear"></div>
    <div class="more"><?php echo $this->Html->link('More...',array('controller'=>'connections','action'=>'index',$friend_id),array('style'=>''));?></div>
	<div class="clear"></div>
  </div>
  <?php }?>
<!-- Recommendation text start-->     
<div class="profile-box">
    <div class="profile-box-heading">
    	<div class="profile-box-heading-rgt">
        <?php if ($count_given_recommendation) {?>
        	<a href="#?" class="given" onclick="show_recommendation('<?php echo $friend_id ?>','given')" style="color:#B9B9B9;">Given(<?php echo $count_given_recommendation;?>)</a>
            <?php }?>
          <a href="#?" class="received" onclick="show_recommendation('<?php echo $friend_id ?>','received')">Received (<?php echo $recevied = sizeof($user_commendations_text);?>)</a>
        </div>
        <h1>
            <div class="profile-box-icon">
                <?php echo $this->Html->image(MEDIA_URL.'/img/recommendation-icon.png',array('style'=>''));?>
            </div>
            <div class="heading-text">Recommendations</div>
         </h1>
    </div>
    <div class="profile-box-content" id="profile_box_id">
    <?php 
		if($counts_for_texts ==0) {
			$fullname = $userInfo['users_profiles']['firstname']." ".$userInfo['users_profiles']['lastname'];
			
			?>
    	<div class="exp-com-logo"> 
        <?php echo $this->Html->image(MEDIA_URL.'/files/user/thumbnail/'.$imgname,array('style'=>''));?>
        </div>
		<div class="profile-box-content-rgt">
        <ul>
            <li>
              <h1><?php echo $fullname.", would you like to recommend ".$requested_user_name."?"; ?></h1>
            </li>
            <li><a href="#" onClick="showhide('recommendationDiv', 'block'); return false" ><?php echo "Recommend ".$requested_user_name;?></a></li>
            <li>
              <div id="recommendationDiv" style="display:none" class="recommendation">
                    <div>
                        <?php 
                            echo $this->Form->textarea('recommended_text',array('rows'=>4,'cols'=>50,'id'=>'recommended_text','placeholder'=>'Put your recommended text.'));
                            echo $this->Form->text('created',array('type'=>'hidden','value'=>$created_dt = date("Y-m-d H:i:s"),'id'=>'created_date'));
                            echo $this->Form->text('modified',array('type'=>'hidden','value'=>$modified_dt = date("Y-m-d H:i:s"),'id'=>'modified_date'));
                        ?>
                    </div>
                    <div id="recommend_btn">
                    <a href="Javascript:add_recommendation('<?php echo $uid?>','<?php echo $friend_id?>')" class="button">Recommend</a>
                    </div>
              </div>
            </li>
        </ul>
        </div>
		<div class="clear"></div>
	
    <?php }?>
    </div>
    <div id="loading" style="position:relative; text-align:center; display:none;"> 
    <?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
    </div>
    
    <div id="users_recommended_text_for_user"> <!-- Ajax recods start here --> 
    <?php 
  if ($user_commendations_text) {
	foreach ($user_commendations_text as $commendations_text_Row) {
			$created_date = $commendations_text_Row['Users_recommendation']['created'];
			$year = date("Y", strtotime($created_date));
			$month = date("M", strtotime($created_date));
			$day = date("d", strtotime($created_date));
		?>
    <div class="recommendations">
    	<div class="profile-box-content">
    		<div class="exp-com-logo">
        	<?php 
			if ($commendations_text_Row['users_profiles']['photo']){
				if(file_exists(MEDIA_PATH.'/files/user/thumbnail/'.$commendations_text_Row['users_profiles']['photo'])){
					$commendations_photo=MEDIA_URL.'/files/user/thumbnail/'.$commendations_text_Row['users_profiles']['photo'];
				}else{
					$commendations_photo=MEDIA_URL.'/img/nophoto.jpg';
				}
			 }
			 else { 	
					$commendations_photo=MEDIA_URL.'/img/nophoto.jpg'; 
			 }
			 echo $this->Html->image($commendations_photo);
			
			?>
        </div>
		<div class="profile-box-content-rgt">
        <ul>
            <li>
              <h1><?php echo $commendations_text_Row['users_profiles']['firstname']." ".$commendations_text_Row['users_profiles']['lastname'];?></h1>
            </li>
            <li><strong><?php echo $commendations_text_Row['users_profiles']['tags'];?></strong></li>
            <li>Recommendation on: <?php echo $month." ".$day.", ".$year; ?></li>
            <li>
                <?php echo $this->Html->image(MEDIA_URL.'/img/quotes1.png',array('style'=>'width:10px; height:10px;'));?>
				<?php echo $commendations_text_Row['Users_recommendation']['recommended_text'];?>
				 <?php echo $this->Html->image(MEDIA_URL.'/img/quotes2.png',array('style'=>'width:10px; height:10px;'));?>
			</li>
        </ul>
        </div>
		<div class="clear"></div>
	  </div>
    </div>
    <?php }}?>
    </div> 
    <div class="clear"></div>
  </div>
<!-- Recommendation text end--> 
<?php if ($groupsListing) {?>
<!-- Group Start --> 
<div class="profile-box">
    <div class="profile-box-heading">
	<h1>
		<div class="profile-box-icon">
            <?php echo $this->Html->image(MEDIA_URL.'/img/group-icon.png',array('style'=>''));?>
		</div>
		Groups</h1>
    </div>
    <?php  $j=1; $total_group = sizeof($groupsListing);
		foreach ($groupsListing as $user_group) {
				$group_follow_id = $user_group['users_followings']['id'];
				$group_id = $user_group['users_followings']['following_id'];
				$groupid = $user_group['groups']['id'];
				$title_url = str_replace(" ", "-", strtolower($user_group['groups']['title']));
		?>
	<div class="profile-group <?php if ($j > 11) { echo 'hidden-class'; }?>" id="groupbox<?php echo $j;?>">
		  <div class="profile-group-logo">
			  <?php 
				
				if ($user_group['groups']['logo']){
					if(file_exists(MEDIA_PATH.'/files/group/original/'.$user_group['groups']['logo'])){
						$user_group_photo=MEDIA_URL.'/files/group/original/'.$user_group['groups']['logo'];
					}else{
						$user_group_photo=MEDIA_URL.'/img/nophoto.jpg';
					}
				 }
				 else { 	
						$user_group_photo=MEDIA_URL.'/img/nophoto.jpg'; 
				 }
				 echo $this->Html->image($user_group_photo, array('url'=>array('controller'=>'groups','action'=>'view',$groupid,$title_url),'style'=>''));
				
				
				  ?>
		  </div>
		<div class=""><?php echo $user_group['groups']['title'];?></div>
        <div class="clear"></div>
	</div>
    <?php $j++;}?>
    <div class="profile-group" id="more_group" <?php if ($total_group < 11) echo 'style="display:none;"'?>>
      <div class="profile-group-logo">
      <?php echo $this->Html->image(MEDIA_URL.'/img/more_arrow.jpg',array('onclick'=>'seemoreGroup('.$total_group.');','style'=>'cursor:pointer; margin-left:30px;'));?>
      </div>
      <div align="center"><a href="#" style="color:#C70000;" onclick="seemoreGroup('<?php echo $total_group;?>')">See more</a></div>
    </div>
    <div class="profile-group" id="less_group" style="display:none;">
      <div class="profile-group-logo">
       <?php echo $this->Html->image(MEDIA_URL.'/img/less_arrow.jpg',array('onclick'=>'seelessGroup('.$total_group.');','style'=>'cursor:pointer; margin-left:30px;'));?>
      </div>
       <div align="center"><a href="#" style="color:#C70000;" onclick="seelessGroup('<?php echo $total_group;?>')">See less</a></div>
    </div>
	<div class="clear"></div>
  </div>
 <?php }?> 
 <!-- Group End --> 
 <?php if ($uers_following_companies) {?>
 <!-- Following Start --> 
 <div class="profile-box">
    <div class="profile-box-heading">
	<h1>
		<div class="profile-box-icon">
            <?php echo $this->Html->image(MEDIA_URL.'/img/follow-icon.png',array('style'=>''));?>
		</div>
		Following</h1>
    </div>
    <?php $total_company = sizeof($uers_following_companies);
		  $hide_companies = $total_company - 11;
		$i = 1;
		foreach ($uers_following_companies as $user_Company) {
			$company_follow_id = $user_Company['Users_following']['id'];
			$company_id = $user_Company['Users_following']['following_id'];
			$companyid = $user_Company['companies']['id'];
			$title_url = str_replace(" ", "-", strtolower($user_Company['companies']['title']));
			
		?>
        
    <div class="profile-group <?php if ($i > 11) { echo 'hidden-class'; }?>" id="pbox<?php echo $i;?>">
              <div class="profile-group-logo">
              <?php 
              
				if ($user_Company['companies']['logo']){
					if(file_exists(MEDIA_PATH.'/files/company/logo/'.$user_Company['companies']['logo'])){
						$user_Company_logo=MEDIA_URL.'/files/company/logo/'.$user_Company['companies']['logo'];
					}else{
						$user_Company_logo=MEDIA_URL.'/img/nologo.jpg';
					}
				 }
				 else { 	
						$user_Company_logo=MEDIA_URL.'/img/nologo.jpg'; 
				 }
				echo $this->Html->image($user_Company_logo, array('url'=>array('controller'=>'companies','action'=>'view',$companyid,$title_url),'style'=>''));
              ?>
              </div>
            <div class="">
            <div><strong><?php echo $user_Company['companies']['title'];?></strong></div>
            <div id="company_follow_by_user<?php echo $company_follow_id;?>">
            </div>
            </div>
            <div class="clear"></div>
   </div>
   <?php $i++; }?>
   <div class="profile-group" id="more_result" <?php if ($total_company < 11) echo 'style="display:none;"'?>>
      <div class="profile-group-logo">
      <?php echo $this->Html->image(MEDIA_URL.'/img/more_arrow.jpg',array('onclick'=>'seemore('.$total_company.');','style'=>'cursor:pointer; margin-left:30px;'));?>
      </div>
      <div align="center"><a href="#" style="color:#C70000;" onclick="seemore('<?php echo $total_company;?>')">See <?php echo $hide_companies;?> more</a></div>
    </div>
    <div class="profile-group" id="less_result" style="display:none;">
      <div class="profile-group-logo">
       <?php echo $this->Html->image(MEDIA_URL.'/img/less_arrow.jpg',array('onclick'=>'seeless('.$total_company.');','style'=>'cursor:pointer; margin-left:30px;'));?>
      </div>
       <div align="center"><a href="#" style="color:#C70000;" onclick="seeless('<?php echo $total_company;?>')">See less</a></div>
    </div>
	<div class="clear"></div>
 </div>
  <!-- Following End --> 
  <?php }?>
  <div class="share_popup_ajax" id="starbox" style="width:600px; position:absolute;">
 	<div class="close" onclick="disablePopup()"></div>
 </div>
 <div id="backgroundPopup"></div>
 
 <!-- Send Message Popup -->
 <div id="sendmessage" class="popup_block">
                    <!--your content start-->
                        <div class="userprofile-box">
                            <div class="userprofile-box-rgt">
                                <ul>
                                    <li>
                                        <h1><?php echo "Send ".$userRec['users_profiles']['firstname']." ".$userRec['users_profiles']['lastname']." a message";?></h1>
                                    </li>
                                </ul>
                            </div>
                        <div class="clear"></div>
                      </div>
                        <form action="/users_profiles/user_send_message/" method="post" class="userprofile-form">
                        	<?php if($userInfo['users']['email']){ $yourEmail = $userInfo['users']['email'];}?>
                        	<input type="hidden" name="reciver" value="<?php echo $userRec['users']['email'];?>" />
                            <input type="hidden" name="sender" value="<?php echo $yourEmail;?>" />
                            <input type="hidden" name="recivername" value="<?php echo $userRec['users_profiles']['firstname'];?>" />
							<input type="hidden" name="sender_id" value="<?php echo $userRec['users_profiles']['user_id'];?>" />
                            <input type="hidden" name="user_id" value="<?php echo $uid;?>" />
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td><strong>To </strong>
                                    <?php echo $userRec['users_profiles']['firstname']." ".$userRec['users_profiles']['lastname']." (".$userRec['users']['email'].")";?>
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
              
 <!---Following box popup Here --->
			<div id="following_popup" class="popup_block">
<!--your content start-->
  <div class="heading"><h1>Following</h1></div>
	<div class="scroller">
    <?php if ($following_users) {?>
    	<?php foreach ($following_users as $following__row) {
			$follow_id = $following__row['users_followings']['id'];
			$status = $following__row['users_followings']['status'];
			$user_id = $following__row['users_followings']['user_id'];
			$following_id = $following__row['users_followings']['following_id'];
			$flag = false;
			foreach ($your_following_users as $follow__row) {
				if ($follow__row['users_followings']['following_id'] == $following_id) {
					$follow_id = $follow__row['users_followings']['id'];
				$flag = true;	
				}
			}
			?>
		<div class="wholike">
		  <div class="wholike-pic">
          		<a href="/users_profiles/userprofile/<?php echo $following__row['users_profiles']['user_id'];?>">
                	<?php if ($following__row['users_profiles']['photo'] && file_exists(MEDIA_PATH.'/files/user/icon/'.$following__row['users_profiles']['photo'])) {
							echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$following__row['users_profiles']['photo'],array('stayle'=>''));
					}
					else {
						echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg'.$following__row['users_profiles']['photo'],array('stayle'=>''));
					}?>
                </a>
          </div>
		  <div class="wholike-rgt">
			  <ul>
				  <li>
                  	<?php if ($following_id != $uid) {?>
					  <div class="connectbutton" id="follow_result<?php echo $following_id;?>">
                      	<?php if ($flag == true) {?>
                     	 <input name="Connect" type="button" id="Connect" value="Following" class="red-bttn" onclick="followers('<?php echo $follow_id;?>','0','<?php echo $following_id;?>','<?php echo $uid;?>','following')">
                         <?php }
							else {
						?>
                         <input name="Connect" type="button" id="Connect" value="Follow" class="red-bttn" onclick="followers('<?php echo $follow_id;?>','2','<?php echo $following_id;?>','<?php echo $uid;?>','following')">
                        <?php }?>
                      </div>
                      <?php }?>
					  <h1>
                      	<a href="/users_profiles/userprofile/<?php echo $following__row['users_profiles']['user_id'];?>">
                        	<?php echo $following__row['users_profiles']['firstname']." ".$following__row['users_profiles']['lastname'];?> </a></h1>
				  </li>
			  </ul>
		  </div>
		<div class="clear"></div>
	  </div>
	<?php } }
	else {
		
		echo '<div class="heading"><h1>No user found</h1></div>';
	}
	?>
  </div>
	<!--your content end-->
</div>
<!--- Following box popup Here --->
 
 <!---Followers box popup Here --->
<div id="followers_popup" class="popup_block">
<!--your content start-->
  <div class="heading"><h1>Followers</h1></div>
	<div class="scroller">
    <?php if ($follower_users) {?>
    	<?php foreach ($follower_users as $follower__row) { 
			$follow_id = $follower__row['users_followings']['id'];
			$status = $follower__row['users_followings']['status'];
			$user_id = $follower__row['users_followings']['user_id'];
			$following_id = $follower__row['users_followings']['following_id'];
			$flag = false;
			foreach ($your_following_users as $following__row) {
				if ($following__row['users_followings']['following_id'] == $user_id) {
					$follow_id = $following__row['users_followings']['id'];
				$flag = true;	
				}
			}
			?>
		<div class="wholike">
		  <div class="wholike-pic">
          		<a href="/users_profiles/userprofile/<?php echo $follower__row['users_profiles']['user_id'];?>">
                	<?php if ($follower__row['users_profiles']['photo'] && file_exists(MEDIA_PATH.'/files/user/icon/'.$follower__row['users_profiles']['photo'])) {
							echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$follower__row['users_profiles']['photo'],array('stayle'=>''));
					}
					else {
							echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg'.$follower__row['users_profiles']['photo'],array('stayle'=>''));
					}?>
                </a>
          </div>
		  <div class="wholike-rgt">
			  <ul>
				  <li>
					  <div class="connectbutton" id="followers_result<?php echo $user_id;?>">
                      <?php if ($user_id != $uid) {?>
                      	<?php if ($flag == true) {?>
                      	<input name="Connect" type="button" id="Connect" value="Following" class="red-bttn" onclick="unfollowMe('<?php echo $follow_id;?>','0','<?php echo $user_id;?>','<?php echo $uid;?>','followers')">
                      	<?php }
							else {
						?>
                        <input name="Connect" type="button" id="Connect" value="Follow" class="red-bttn" onclick="unfollowMe('<?php echo $follow_id;?>','2','<?php echo $user_id;?>','<?php echo $uid;?>','followers')">
                        <?php }}?>
                      </div>
					  <h1>
                      	<a href="/users_profiles/userprofile/<?php echo $follower__row['users_profiles']['user_id'];?>">
                        	<?php echo $follower__row['users_profiles']['firstname']." ".$follower__row['users_profiles']['lastname'];?> 
                        </a>
                      </h1>
				  </li>
			  </ul>
		  </div>
		<div class="clear"></div>
	  </div>
	<?php } }
	else {
		
		echo '<div class="heading"><h1>No user found</h1></div>';
	}
	?>
  </div>
	<!--your content end-->
</div>
<!--- Followers box popup Here --->

 <!--- Connection Popup Starts Here --->
<div class="modal fade middlepopup" id="connectdiv" tabindex="-1" role="dialog" aria-labelledby="connectdiv" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
		<form action="" method="post">
          <div class="modal-header">
            <a class="popupclose" data-dismiss="modal" aria-hidden="true"></a>
            <h1 class="modal-title" id="myModalLabel">Send Connection Request</h1>
          </div>
          <div class="modal-body">
            <div class="popup-listing">
			    <div class="popup-listing-logo"> 
                	
                    	<?php 
						if ($userRec['users_profiles']['photo']) {
								if (file_exists(MEDIA_PATH.'/files/user/logo/'.$userRec['users_profiles']['photo'])) {
									echo $this->Html->image(MEDIA_URL.'/files/user/logo/'.$userRec['users_profiles']['photo'],array('style'=>''));
								}
								else {
									echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>''));
								}
		 					} 
		 					else {
	   							echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>''));
							}
							?> 
                    
                </div>
			    <div class="popup-listing-rgt">
			      <ul>
			        <li>
			          <h1><?php echo $userRec['users_profiles']['firstname']." ".$userRec['users_profiles']['lastname'];?></h1>
		            </li>
			        <li><?php echo $userRec['users_profiles']['tags'];?></li>
                  </ul>
		        </div>
			    <div class="clear"></div>
		      </div>
                 <div class="popup-checkbox">
                 Connect as: 
			<input name="connection_type" id="professional" type="radio" value="Professional" checked="checked"/> <label> Professional</label>	
                    	<input name="connection_type" id="friend" type="radio" value="Friend"/><label> Friend</label>
                        <input name="connection_type" id="both" type="radio" value="Both" /><label>  Both</label>
                    </div>
                    <span class="redcolor" id="connection_error"></span>
          </div>
          <div class="modal-footer">
            <button type="button" id="connect_btn" class="btn submitbttn" data-dismiss="modal" onclick="return add_ajax_user('<?php echo $uid?>','<?php echo $friend_id?>');">Connect</button>
            <button type="button" class="btn canclebttn" data-dismiss="modal">Cancel</button>
          </div>
          </form>
        </div> 
      </div>
 </div>