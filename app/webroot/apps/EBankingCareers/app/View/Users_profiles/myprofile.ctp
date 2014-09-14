<?php if ($this->Session->read(@$userid)) {$uidd = $this->Session->read(@$userid); $uid = $uidd['userid'];}?>
<?php $arr = $this->params['pass']; 
	$message_received = $arr[0];
	if ($message_received == 'email_sent') { ?>
        <div class="success_msg"><?php echo __('Your message has been sent.');?> </div>
	<?php }
	?>
  <?php //foreach ($userRec as $user_Name) {
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
		$nationality_hide = $userRec['users_profiles']['nationality_hide'];
		$gender_hide = $userRec['users_profiles']['gender_hide'];
		?>
  <div class="profile-user userprofile-form">
  	<?php if($userRec['users_profiles']['hiring'] == 1){  ?>
    	<div class="availabletag">Available for New Challenges</div>
       <?php }?>
	<div class="profile-user-pic">
        <?php 
        if (!empty($userRec['users_profiles']['photo']) && file_exists(MEDIA_PATH.'/files/user/logo/'.$userRec['users_profiles']['photo'])):
        echo $this->Html->image(MEDIA_URL.'/files/user/logo/'.$userRec['users_profiles']['photo'],array('style'=>''));
        else:
        echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>''));
        endif;
        ?> 
        </div>
    <div class="profile-user-rgt">
    	<ul>
	          <li>
	            <h1><?php echo $userRec['users_profiles']['firstname']; 
					if ($userRec['users_profiles']['lastname_hide'] != 1) { echo " ".$userRec['users_profiles']['lastname']; } ?></h1>
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
             <?php  $i =1; foreach ($userExperience as $user_Edu) {  ?>
              <li><?php if ($i==1) { //echo $user_Edu['companies']['title']; 
			  			} else {?>
             				 Previous: <?php echo $user_Edu['companies']['title']; }?></li>
              	<?php $i++;} ?>
              <li>
              <?php foreach ($lastEducation as $last_Edu) {?>
              <li>Education: <?php echo $last_Edu['qualifications']['title'];?></li>
              <?php } ?>
              <li>
                <a href="/users_profiles/update/" class="button">Edit Profile</a>
              </li>
              <li>
              	<div class="clear"></div>
              	<div class="profile-link">
                <a href="/users_profiles/review#fragment-5" class="seeall2">Edit</a>
              	Public Profile -  <a href="<?php echo NETWORKWE_URL."/pub/".$userRec['users_profiles']['handler'];?>" target="_blank"><?php echo NETWORKWE_URL."/pub/".$userRec['users_profiles']['handler'];?></a>
                </div>
              </li>
              <!--<li>
               	  <div class="margintop15">
					  <a href="#" class="connect">Connect</a>
					  <a href="#" class="sendmsg">Send Message</a>
					  <a href="#" class="join">Join</a>
					  <a href="#" class="follow">Follow</a>
			      </div>
		      </li>-->
          </ul>
    </div>
    <div class="clear"></div>
     <!-- Activities start -->
           	<div class="myprofile-activities">
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
								$is_present = true;
								$present_start_date = $start_date;
							}
							
							
						}
						
					}
					if($is_present){
						$end_date = new DateTime(date("d-m-Y"));
						$diff = $present_start_date->diff($end_date);
						$year_diff += $diff->y;
						$month_diff += $diff->m;
					}
						
					$years_in_months = $month_diff/12;
						$years_of_month = intval($years_in_months);
					if ($years_of_month) { 
						$year_diff += $years_of_month;
					}
				  if ($year_diff>=1) { echo $year_diff." Years";} else {echo " < year";}
				  }?>
                  </span>
                  </li>
                  
              </ul>
       	  </div>
         <a href="<?php echo NETWORKWE_URL;?>/connections/index/<?php echo $uid;?>">
          <div class="myprofile-activities">
				<div class="activity-icon">
                <?php 
					echo $this->Html->image(MEDIA_URL.'/img/big-icon-connect.png',array('style'=>''));
				?>
			    </div>
                <ul>
                   	<li><strong> <?php echo "Connections";?></strong> </li>
                    <li><span class="smalltext">
						<?php if ($totalConnections) {
									echo $totalConnections;
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
          <div class="myprofile-activities">
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
          <div class="myprofile-activities">
				<div class="activity-icon">
                	<?php echo $this->Html->image(MEDIA_URL.'/img/big-icon-followers.png',array('style'=>''));?>
			    </div>
                <ul>
                   	<li><strong>Followers</strong> </li>
                    <li><span class="smalltext"><?php if ($followers) echo $followers; else echo "0";?></span></li>
            </ul>
   	      </div>
         </a>
          <div class="myprofile-activities">
          	<?php foreach ($user_starsign_dob as $starsign__Row) {
						$your_DOB = $userRec['users_profiles']['birth_date'];
						$date = date("d-m-Y",strtotime($your_DOB));
						$month_day = date("m-d",strtotime($date));
						$stdate = $starsign__Row['Star_sign']['start_date'];
						$endate = $starsign__Row['Star_sign']['end_date'];
						$stdate = date("m-d",strtotime($stdate));
						$endate = date("m-d",strtotime($endate));
						if ($month_day>=$stdate && $month_day<=$endate) {
							$id = $starsign__Row['Star_sign']['id'];
			?>
				<div class="activity-icon">
					<?php echo $this->Html->image(MEDIA_URL.'/files/starsign/'.$starsign__Row['Star_sign']['icon'],
																							array('onClick'=>'showStarSign('.$id.','.$uid.')'),
																									 array('style'=>'','class'=>'poplight'));?>
			    </div>
                <ul>
                   	<li><strong>Star Sign</strong> </li>
                    <li>
                    	<span class="smalltext">
                    		<a href="javascript:showStarSign('<?php echo $id?>','<?php echo $uid?>')" class="poplight" style="text-decoration:none; color:#C70000;">
																								 <?php echo $starsign__Row['Star_sign']['name'];?>
                           </a>
                       </span>
                   </li>
            	</ul>
             <?php }}?>
  	      </div>
          
          <div id="dd-more" class=" margintop15">
			<ul>
				<li class="has-sub"> 
                	<a href=""></a>
					<ul>
						<li><a href="<?php echo NETWORKWE_URL;?>/home/myupdates/<?php echo $uid;?>"><div class="icon-updates"></div>Updates</a></li>
						<li><a href="<?php echo NETWORKWE_URL;?>/tweets/profile/<?php echo $uid;?>"><div class="icon-tweets"></div>Tweets</a></li>
                        <li><a href="<?php echo NETWORKWE_URL;?>/blogs/"><div class="icon-blog"></div>Blogs</a></li>
					</ul>
			  </li>
			</ul>
		</div>
          <div class="clear"></div>
     <!-- Activities start --> 
  </div>
  <div class="clear"></div>
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
        <li><strong>Email</strong><span></span>: <?php echo $userRec['users']['email'];?></li>
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
<?php  }?>
<?php if ($userRec['users_profiles']['summary']) {?>
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
                <li>
                	<a href="#"><?php echo $totalExp['companies']['title'];?></a>
                </li>
                <?php if ($totalExp['users_experiences']['start_date'] != '0000-00-00' || $totalExp['users_experiences']['end_date'] != '0000-00-00') {?>
                <li><?php echo $totalExp['users_experiences']['start_date']." to ".$totalExp['users_experiences']['end_date'];?> </li>
                <?php }?>
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
        <div class="endorseby">Endorsed By</div>
    </div>
    
    <?php
	if ($userHaveSkills){ $i=1;
		foreach ($userHaveSkills as $userListSkill) {
			$skill_ids = $userListSkill['skills']['id'];
			?>
	<div class="endouresskill">
		<div class="skill-experties-left"> 
   		  <div class="skill-experties-blockes">
            	<a href="#?"  onclick="showProfiles('<?php echo $skill_ids ?>','<?php echo $uid ?>');" rel="skillbox<?php echo $userListSkill['skills']['id'];?>" class="poplight blockers-number"><?php echo $userListSkill[0]['total_recommendations'];?></a>
                <div class="blockers-text"><a href="#"><?php if ($i!=1) echo ""; echo $userListSkill['skills']['title'];?></a></div>
				<div class="clear"></div>
            </div>
		</div>
        <div class="skill-experties-right">
			<ul class="skillspeople-pic">
            	<?php 
				if ($userListSkill[0]['total_recommendations'] !=0) {?>	
            		<li><a href="#?" rel="skillbox<?php echo $userListSkill['skills']['id'];?>" onclick="showProfiles('<?php echo $skill_ids ?>','<?php echo $uid ?>');" class="poplight see-skill-people">
                    </a>
                    </li>
                    <?php }?>
            <?php foreach ($uers_RecommendedListingwithoutAjax as $withoutAjaxUserShow) { 
					if ($withoutAjaxUserShow['skill_recommendations']['skill_id'] == $userListSkill['skills']['id']) {?>
				<li><?php 
					if ($withoutAjaxUserShow['users_profiles']['photo']){
						if(file_exists(MEDIA_PATH.'/files/user/icon/'.$withoutAjaxUserShow['users_profiles']['photo'])){
							$UserShow_pic=MEDIA_URL.'/files/user/icon/'.$withoutAjaxUserShow['users_profiles']['photo'];
						}else{
							$UserShow_pic=MEDIA_URL.'/img/nophoto.jpg';
						}
					 }
					 else { 	
							$UserShow_pic=MEDIA_URL.'/img/nophoto.jpg'; 
					 }
					 echo $this->Html->image($UserShow_pic);
					
					}
				}?>			
                </li>
			</ul>
        </div>
	<div class="clear"></div>
    </div>
<!--- Like Box Starts Here --->
    <div id="skillbox<?php echo $userListSkill['skills']['id'];?>" class="popup_block">
    <!--your content start-->
      <div class="heading"><h1>People with Same Skills & Expertise</h1></div>
      <div class="popupmsg"><?php echo $userListSkill[0]['total_recommendations']." people recommended ".$userRec['users_profiles']['firstname']." for ".$userListSkill['skills']['title'];?></div>
        <div class="scroller" id="resultDiv_<?php echo $userListSkill['skills']['id'];?>">
            
      </div>
        <!--your content end-->
    </div>
<!--- Like Box Ends Here --->
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
            <?php if ($dob) { ?><li><strong>Birthday:</strong>&nbsp;&nbsp;&nbsp;<?php echo $month." ".$day; if($hide_year != 1) { echo ", ".$year;}?></li><?php }?>
            <?php if ($gender && $gender_hide != 1) { ?><li><strong>Gender: </strong>&nbsp;&nbsp;&nbsp;<?php echo $gender; ?></li><?php }?>
          <?php if ($marital_status && $marital_status_hide != 1) { ?><li><strong>Marital Status: </strong>&nbsp;&nbsp;&nbsp;<?php echo $marital_status; ?></li><?php }?>
		  <?php if ($userRec['nationality']['name'] && $userRec['users_profiles']['nationality_hide'] != 1) { echo "<li><strong>Nationality: </strong>&nbsp;&nbsp;&nbsp;".$userRec['nationality']['name']."</li>"; }?>
		  
          </ul>
        </div>
        <div class="clear"></div>
</div>

<?php } if ($getTotalUser) {?>
 <!-- Skill and experize end--> 
 
 <!-- Connection Start --> 
 <div class="profile-box">
    <div class="profile-box-heading">
    <div class="profile-box-heading-rgt">
    <?php echo $this->Html->link( 'All ('. $totalConnections.')' ,array('controller'=>'connections','action'=>'index'),array('style'=>'')); ?>
    	
    </div>
	<h1>
		<div class="profile-box-icon">
        	<?php echo $this->Html->image(MEDIA_URL.'/img/connection-icon.png',array('style'=>''));?>
		</div>
		<div class="heading-text">Connections</div></h1>
    </div>
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
																												$userId));?>
                  </h1>
			  </li>
			  <li><?php echo substr($cgetuser['users_profiles']['tags'],0,40);?></li>
		  </ul>
		</div>
        <div class="clear"></div>
	</div>
	<?php }?>
    <div class="more"><?php echo $this->Html->link('More...',array('controller'=>'connections','action'=>'index'),array('style'=>''));?></div>
	<div class="clear"></div>
  </div>
  <?php }?>
<!-- Recommendation text start--> 
<?php if ($user_commendations_text) {?>     
<div class="profile-box">
    <div class="profile-box-heading">
    	<div class="profile-box-heading-rgt">
        	<?php if ($count_given_recommendation) {?>
        	<a href="#?" class="given" onclick="show_recommendation('<?php echo $uid ?>','given')" style="color:#B9B9B9;">Given(<?php echo $count_given_recommendation;?>)</a>
            <?php }?>
           <a href="#?" class="received" onclick="show_recommendation('<?php echo $uid ?>','received')">Received (<?php echo $recevied = sizeof($user_commendations_text);?>)</a>
        </div>
		<h1>
            <div class="profile-box-icon">
                <?php echo $this->Html->image(MEDIA_URL.'/img/recommendation-icon.png',array('style'=>''));?>
            </div>
			<div class="heading-text">Recommendations</div>
        </h1>
    </div>
    <div id="recommendation_result">
    <?php 
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
    <?php }?> 
    </div>
    <div class="clear"></div>
  </div>
  <?php }?> 
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
    <?php 
		foreach ($groupsListing as $user_group) {
				$group_follow_id = $user_group['users_followings']['id'];
				$group_id = $user_group['users_followings']['following_id'];
				$groupid = $user_group['groups']['id'];
				$title_url = str_replace(" ", "-", strtolower($user_group['groups']['title']));
		?>
	<div class="profile-group">
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
    <?php }?>
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
    
    <?php 
		foreach ($uers_following_companies as $user_Company) {
			$company_follow_id = $user_Company['Users_following']['id'];
			$company_id = $user_Company['Users_following']['following_id'];
			$companyid = $user_Company['companies']['id'];
			$title_url = str_replace(" ", "-", strtolower($user_Company['companies']['title']));
		?>
    <div class="profile-group">
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
            <?php 
			if ($user_Company['Users_following']['status'] == 2) {
					
					echo $this->Html->link('Following','Javascript:unfollow('.$company_follow_id.','.$company_follow_id.','.$uid.',0,'.$company_id.')',
																			array('class'=>'follow','id'=>'follow_comp'.$company_follow_id,
																				  'onMouseOver'=>'showUnfollow('.$company_follow_id.')',
																				  'onMouseOut'=>'hideUnfollow('.$company_follow_id.')'));
			}
			else {
				  echo $this->Html->link('Follow','Javascript:unfollow('.$company_follow_id.','.$company_follow_id.','.$uid.',2,'.$company_id.')',
																	   array('class'=>'unfollow','id'=>'unfollow_comp'.$company_follow_id));
			}
				
			?>
            </div>
            </div>
            <div class="clear"></div>
   </div>
   <?php }?>
	<div class="clear"></div>
 </div>
  <!-- Following End --> 
  <?php }?>
 <div class="share_popup_ajax" id="starbox" style="width:600px; position:absolute;">
 	<div class="close" onclick="disablePopup()"></div>
 </div>
 <div id="backgroundPopup"></div>
 
 
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
					  <div class="connectbutton" id="follow_result<?php echo $follow_id;?>">
                      <input name="Connect" type="button" id="Connect" value="Following" class="red-bttn" onclick="unfollowMe('<?php echo $follow_id;?>','0','following')"></div>
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
			foreach ($following_users as $following__row) {
				if ($following__row['users_followings']['user_id'] == $uid && $following__row['users_followings']['following_id'] == $user_id) {
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
					  <div class="connectbutton" id="followers_result<?php echo $follow_id;?>">
                      	<?php if ($flag == true) {?>
                      	<input name="Connect" type="button" id="Connect" value="Following" class="red-bttn" onclick="followers('<?php echo $follow_id;?>','0','<?php echo $user_id;?>','<?php echo $following_id;?>')">
                      	<?php }
							else {
						?>
                        <input name="Connect" type="button" id="Connect" value="Follow" class="red-bttn" onclick="followers('<?php echo $follow_id;?>','2','<?php echo $user_id;?>','<?php echo $following_id;?>')">
                        <?php }?>
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