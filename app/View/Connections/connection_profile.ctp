<script>
function showInfo(div) {
$("#"+div).slideToggle('slow');
}
function checkValidate() {

var userid = document.getElementById('user_id').value;
var friendid = document.getElementById('friend_id').value;
if (friendid == userid)
alert("you cant sent reques to itself");
return false;
}
</script>
<?php if ($this->Session->read(@$userid)) {$uidd = $this->Session->read(@$userid); $uid = $uidd['userid'];}?>

<?php foreach ($userRec as $user_Name) {?>
	<div class="prof-div">
    	<div class="profmain-div">


<div class="profi-div">
<div class="profcolm">
<div class="proftxt">

<h2><?php echo $user_Name['users_profiles']['firstname']." ".$user_Name['users_profiles']['lastname'];?></h2>
<?php }?>
<h3 class="h3-prof fntsize"><?php echo $user_Name['users_profiles']['tags'];?></h3>
<div class="location"><?php if ($user_Name['users_profiles']['city']) {  echo $user_Name['users_profiles']['city']; } echo "  ".$user_Name['countries']['name']; ?></div>
<?php  $i =1; foreach ($userExperience as $user_Edu) {  if ($i==1) {?>
<!--<div><span class="prof_key">Current:</span><span class="prof_value"> <?php echo $user_Edu['companies']['title'];?></div>-->
<?php } else {?>
<div><span class="prof_key">Previous:</span><span class="prof_value"> <?php echo $user_Edu['companies']['title'];?></span></div>
<?php } $i++; }?>
<?php foreach ($lastEducation as $last_Edu) {?>
<div><span class="prof_key">Education:</span><span class="prof_value"><?php echo $last_Edu['qualifications']['title']." , in ".$last_Edu['users_qualifications']['field_study'];?>
</span></div>

<?php } ?>
		<div style="margin-bottom:7px;">
        	<div style=" float:left; margin-top:5px;">
            	<a href="Javascript:showMessageForm();" class ="connect_btn"><?php echo __('Message');?></a>
                </div>
                <?php  if (empty($chatRequest) && $uid != $friend_id){?>
                <div>
                  <form method="post" name="userConnection" action="/users_profiles/invite_for_chat" >
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $uid?>" id="user_id" />
                <input type="hidden" name="friend_id" id="friend_id" value="<?php echo $friend_id;?>" id="friend_id" />
                <input type="hidden" name="status" value="0" />
                <input type="hidden" name="invite_date" id="invite_date" value="<?php echo $dt = date('Y-m-d h:i:s');?>" />
                <input type="submit" name="chat" value="Invite for Chat" class="connect_btn" style="float:left; margin-top:5px;" />
                </form>
            </div>
             <?php }?> <!-- User chat request button End-->	
            	<!-- User connection request button-->	
             <?php  if (empty($checkRequest) && $uid != $friend_id){?>
            <div>
                <form method="post" name="userConnection" action="/connections/add_connection" >
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $uid?>" id="user_id" />
                <input type="hidden" name="friend_id" id="friend_id" value="<?php echo $friend_id;?>" id="friend_id" />
                <input type="hidden" name="request_date" value="<?php echo $dt = date('Y-m-d');?>" />
                <input type="hidden" name="start_date" id="start_date" value="<?php echo $dt = date('Y-m-d h:i:s');?>" />
                <input type="submit" name="connect" value="Connect" class="connect_btn" style="float:left; margin-top:5px;" />
                </form>
           </div>
           <?php }?> <!-- User connection request button End-->	
           <div style=" float:left; margin-top:5px;" id="user_following_btn">
           		<?php if (sizeof($checkUserFollowings)== 0 ){?>
            	<a href="Javascript:userFollow('2');" class ="connect_btn" id="follow_user1" style="display:block;"><?php echo __('Follow');?></a>
                <?php } else{
					if ($following_status == 2) {?>
                <a href="Javascript:userFollow('0',<?php echo $following_id ?>);" class ="connect_btn" id="following_user1"><?php echo __('Following');?></a>
                 <?php } else{?>
                 <a href="Javascript:userFollow('2',<?php echo $following_id ?>);" class ="connect_btn" id="follow_user1"><?php echo __('Follow');?></a>
                 <?php }}?>
                 
                </div>
       
	<div class="clear"></div>
    </div>
    
    
<?php if($this->Session->read('email')){
	$yourEmail = $this->Session->read('email');
}?>
 <!-- SEND MESSAGE FORM -->
   <div class="dialog-wrapper" style="display:none;" id="userSendForm">
   	<div class="dialog-mask">
    	<div class="dialog-window">
        	<div class="dialog-title" style="background:#333;">
            	<button class="dialog-close" onclick="hideMessageForm();"></button>
            	<h3 class="title"><?php echo "Send ".$user_Name['users_profiles']['firstname']." ".$user_Name['users_profiles']['lastname']." a message";?> </h3>
            </div>
            <div class="dialog-body">
            	<div class="dialog-content">
                	<div class="send-message-dialog">
                	<form name="sendMessage" method="post" action="/users_profiles/user_send_message/">
                    		<input type="hidden" name="reciver" value="<?php echo $user_Name['users']['email'];?>" />
                            <input type="hidden" name="sender" value="<?php echo $yourEmail;?>" />
                    	<ul>
                        	<li>
                            	<label>To:</label>
                                <div class="elem"><?php echo $user_Name['users_profiles']['firstname']." ".$user_Name['users_profiles']['lastname']." (".$user_Name['users']['email'].")";?></div>
                            </li>
                            	<li>
                            	<label>Subject:</label>
                                <div class="elem"><input type="text" class="inpt " maxlength="150" name="subject" /></div>
                            </li>
                            <li>
                            	<textarea rows="4" cols="50" name="message" placholder="related to job"></textarea>
                            </li>
                            <li class="action">
                            	<input type="submit" class="btn-primary" value="Send Message" name="submit" />
                            </li>
                        </ul>
                    </form>
                </div>
               </div>
            </div>
        </div>
    </div>
   </div>

	
</div>
</div>
<?php if($user_Name['users_profiles']['hiring'] == 1){  
if ($user_Name['users_profiles']['avaliable'] == 'Available for hiring') {
?>
<div style="margin-right:10px; clear:both; ">
<img src="<?php echo $this->base;?>/img/available_for_new_challenges.jpg" height="30px" alt="Available For New Challenges" />
<!--<strong>Availabile for new challenges</strong>-->
</div>
<?php }}?>	
</div>

<div class="prof-pht">
<?php foreach ($userRec as $pPic) {?>
<?php if ($userRec) {?>
<img src="<?php echo $this->base;?>/files/users/<?php echo $pPic['users_profiles']['photo'];?>" width="200" height="200" />
<?php } else {?>
<img src="<?php echo $this->base;?>/img/hdr2.jpg" width="200" height="200" alt="No-IMAGE" />
<?php }}?>
</div>
<div class="tp-btn-pro">
        <!-- Count user total expertise here -->
        <?php foreach ($uSers_exp as $countExp) {
        	$start_date = strtotime($countExp['users_experiences']['start_date']);
			$end_date = strtotime($countExp['users_experiences']['end_date']);
			$year1 = date('Y', $start_date);
			$year2 = date('Y', $end_date);
			$month1 = date('m', $start_date);
			$month2 = date('m', $end_date);
			if ($end_date>$start_date) {
				$year_diff += ($year2 - $year1);
				$month_diff += ($month2 - $month1);

			}
		
		}   ?>
        <div class="availibility_img" style="height:70px;">

		<div style="margin-top:10px;">
        	<div class="expertize-left">
				<?php echo $this->Html->image('expertize.png',array('style'=>'float:left;width:29px;margin-right:5px;;margin-top:2px;'));?>
                <strong>Expertise</strong>
                <p><?php if ($year_diff>=1) {echo $year_diff." Years";} else {echo "less than year";}?></p>
            </div>
			<div class="expertize-left last-box">
				<?php echo $this->Html->image('connections.png',array('style'=>'float:left;width:29px;margin-right:5px;;margin-top:2px;'));?>
            <?php echo $this->Html->link('Connections',array('controller'=>'connections','action'=>'index',$friend_id),array('style'=>'text-decoration:none; font-weight:bold; color:#333;'));?>
         
                <p><?php if ($totalUserRequestedConnections) {
	echo $this->Html->link($totalUserRequestedConnections,array('controller'=>'connections','action'=>'index',$friend_id),array('style'=>'text-decoration:none; color:#333;'));
						}
						else {echo "0"; } ?>
                </p>
            </div>
			
           
            
                  <div class="expertize-left last-box">
				<?php echo $this->Html->image('following-icon.png',array('style'=>'float:left;width:29px;margin-right:5px;;margin-top:2px;'));?>
                <strong>Following</strong>
                <p><?php if ($following) echo $following; else echo "0";?></p>
            </div>
            	<div class="expertize-left last-box">
				<?php echo $this->Html->image('followers.png',array('style'=>'float:left;width:29px;margin-right:5px;;margin-top:2px;'));?>
                <strong>Followers</strong>
                <p><span id="resultantDiv"><?php if ($followers) echo $followers; else echo "0";?></span></p>
            </div>
            <div class="expertize-left last-box">
            	<?php foreach ($user_starsign_dob as $starsign__Row) {
						$your_DOB = $user_Name['users_profiles']['birth_date'];
						$month_day = date("m-d",strtotime($your_DOB));
						$stdate = $starsign__Row['Star_sign']['start_date'];
						$endate = $starsign__Row['Star_sign']['end_date'];
						$stdate = date("m-d",strtotime($stdate));
						$endate = date("m-d",strtotime($endate));
						if ($month_day>=$stdate && $month_day<=$endate) {
							$id = $starsign__Row['Star_sign']['id'];
					?>
				<?php echo $this->Html->image('starsign/'.$starsign__Row['Star_sign']['icon'],
									array('onClick'=>'showStarSign('.$id.','.$friend_id.');','style'=>'float:left;width:29px;margin-right:5px;;margin-top:2px; cursor:pointer;'));?>
                <strong>Star sign</strong>
                <p><?php echo $starsign__Row['Star_sign']['name'];?></p>
                <?php }}?>
            </div>
            
            <div class="clear"></div>
        	</div>
             
		</div>
        <div class="clear"></div>
    </div>
</div>
    </div>

				<input type="hidden" name="u_id" id="u_id" value="<?php echo $uid;?>" />
				<input type="hidden" name="content_type" id="content_type" value="users" />
			 	<input type="hidden" name="following_id" id="following_id" value="<?php echo $friend_id;?>" />
                <input type="hidden" name="start_date" id="start_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
                 <input type="hidden" name="end_date" id="end_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />


<?php  if ($userRec) {?>
<div class="col-pan-div">
			<div class="main-coldiv">
            	<a class="opn-col-btn"><span style="padding:10px;" class="effectX">Contact information</span></a>
                <div class="col-bot-div cnct-info">
                	<ul>
                    <?php foreach ($userRec as $user_Name) {?>
                    	<li> <span>Email</span><a href="#"><?php echo $user_Name['users']['email'];?></a></li>
                        <li> <span>Mobile</span><?php echo $user_Name['users_profiles']['mobile'];?></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
</div>
<?php } if ($user_Name['users_profiles']['summary']) {?>
		<div class="col-pan-div">
			<div class="main-coldiv">
				<a class="opn-col-btn">
					<span style="padding:10px;" class="effectX">Summary</span></a>
<!--            	<a class="opn-col-btn">Contact information</a>-->
                <div class="col-bot-div cnct-info">
                	<div class="sub-pro-txt">
					<?php echo $user_Name['users_profiles']['summary'];?>
					</div>
                </div>
            </div>
	</div>
<?php  } if ($uSers_exp) {?>
  <div class="col-pan-div">
        	<div class="main-coldiv">
        		<a class="opn-col-btn"><span style="padding:10px;" class="effectX">Experience</span></a>
                <?php foreach ($uSers_exp as $totalExp) {?>
        		<div class="expi-main-div">
       			  <div class="expi-div" style="border-bottom:none;">
        			<div class="expi-colm">
        				<div class="expi-txt">
                         <ul>
       					 	<li class="edu-ttle"><?php echo $totalExp['users_experiences']['designation'];?></li>
       					 	<li><?php echo $totalExp['companies']['title'];?></li>
       					 	<li><?php echo $totalExp['users_experiences']['start_date']." to ".$totalExp['users_experiences']['end_date'];?></li>
       					 </ul>
       				 </div>
       			 </div>
       		 </div>
        <div class="expi-pht">
			<?php if ($totalExp['companies']['logo']) {
					echo $this->Html->image('/files/companies_logo/'.$totalExp['companies']['logo'],array('style'=>'width:60px; height:60px; border:none;'));
				 }else {
					 echo $this->Html->image('no-image.png',array('style'=>'width:60px; height:60px; border:none;'));
				 }
		?>
        </div>  
      </div>
      <?php }?>
    </div>
  </div>  
<?php  } if ($uSerEDU) {?>
 <div class="col-pan-div">
                    <div class="main-coldiv">
                        <a class="opn-col-btn"><span style="padding:10px;" class="effectX">Education</span></a>
                      
                            	<?php foreach ($uSerEDU as $Uedu) {?>
                                <div class="expi-main-div">
        						<div class="expi-div" style="border-bottom:none;">
        						<div class="expi-colm">
                                <div class="expi-txt">
                                <ul>
                                <li class="edu-ttle"><?php echo $Uedu['institutes']['title'];?></li>
                                <li><?php echo $Uedu['qualifications']['title']." in ".$Uedu['users_qualifications']['field_study'];?></li>
                                <li><?php echo $Uedu['users_qualifications']['start_date']." to ".$Uedu['users_qualifications']['end_date'];?></li>
                                 </ul>
                               </div>
       				 </div>
       			 </div>
                 <div class="expi-pht">
			<?php if ($Uedu['institutes']['logo']) {
					echo $this->Html->image('/files/institutes_logo/'.$Uedu['institutes']['logo'],array('style'=>'width:60px; height:60px; border:none;'));
				 }else {
					 echo $this->Html->image('no-image.png',array('style'=>'width:60px; height:60px; border:none;'));
				 }
		?>
        		</div>  
       		 </div>
           <?php }?>                                      
      </div>                                 
  </div>       
<?php  } if ($userHaveSkills) {?>
<div class="col-pan-div">
                    <div class="main-coldiv">
                        <a class="opn-col-btn"><span style="padding:10px;" class="effectX">Skills & Experties</span></a>
                         <div class="col-bot-div cnct-info">
                        
                        <?php if ($userHaveSkills){ $i=1;
						foreach ($parrentCats as $parrentList) {?>
                       
                            <ul>
                                
                                <?php  
								foreach ($userHaveSkills as $userListSkill) {
									$skill_ids = $userListSkill['skills']['id'];
								if ($parrentList['skills_categories']['id'] == $userListSkill['skills']['skills_category_id']) {
									
								?>
                                <input type="hidden" id="friend_user_id" value="<?php echo $friend_id;?>" />
                                <input type="hidden" id="recommends" value="<?php echo $uid;?>" />
                                <input type="hidden" id="skill_id_<?php echo $userListSkill['skills']['id'];?>" value="<?php echo $userListSkill['skills']['id'];?>" />
                                <input type="hidden" id="status" value="0" />
                                <input type="hidden" id="recommend_id" value="0" />
                                <input type="hidden" id="start_date" value="<?php echo $start_dt = date("Y-m-d H:i:s")?>" />
                                <input type="hidden" id="end_date" value="<?php echo $end_dt = date("Y-m-d H:i:s")?>" />
                            
                                <li>
                                	
                                	<span class="skill_recommendation" style="display:block;">
                                <a  class="endorse-count" id="skill_counter_<?php echo $userListSkill['skills']['id'];?>"><?php echo $userListSkill[0]['total_recommendations'];?></a>
								<a style="padding:4px;"><?php if ($i!=1) echo "";
								echo $userListSkill['skills']['title'];?></a>
                                	</span> 
                                    <?php 
									
										$flag = false;
									foreach ($recommendsRecords as $skillRecommendedbyUser) {
									if ($userListSkill['users_skills']['skill_id'] == $skillRecommendedbyUser['skill_recommendations']['skill_id']) {
										?> 
                                   <?php if ($skillRecommendedbyUser['skill_recommendations']['recommends'] == $uid){?>
 								<?php if ($skillRecommendedbyUser['skill_recommendations']['recommendation'] == 0) {?>
                                    <span class="recommend" id="recommend<?php echo $userListSkill['users_skills']['skill_id']?>" style="cursor:pointer;" onclick="removeSkill('<?php echo $userListSkill['skills']['id'];?>','1','<?php echo $skillRecommendedbyUser['skill_recommendations']['id']?>');">
                                        <span class="endorse-plus"><?php echo $this->Html->image('recommend.png', array('alt'=>'recommend','class'=>'endorse-plus'));?></span>
                                        <span class="endorse-text">Recommend</span>
                                   </span>
                                   
 								<?php } else if($skillRecommendedbyUser['skill_recommendations']['recommendation'] == 1){?>
                                   <span class="recommend" id="recommended<?php echo $userListSkill['users_skills']['skill_id']?>" style="cursor:pointer;" onclick="removeSkill('<?php echo $userListSkill['skills']['id'];?>','0','<?php echo $skillRecommendedbyUser['skill_recommendations']['id']?>');">
                                        <span class="endorse-plus"><?php echo $this->Html->image('nonrecommend.png', array('alt'=>'recommend','class'=>'endorse-plus'));?></span>
                                        <span class="endorse-text">Recommended</span>
                                   </span>
                                    <?php }}  $flag=true; } //if condition end
									} //loop end here
									if ($flag == false) { 
									 ?>
                                    <span class="recommend" id="recommend<?php echo $userListSkill['skills']['id'];?>" style="cursor:pointer; display:block;" onclick="recommendSkill('<?php echo $userListSkill['skills']['id'];?>','1');">
                                        <span class="endorse-plus"><?php echo $this->Html->image('recommend.png', array('alt'=>'recommend','class'=>'endorse-plus'));?></span>
                                        <span class="endorse-text">Recommend<?php //echo $skillRecommendedbyUser['skill_recommendations']['skill_id']?></span>
                                   </span>
									<?php }?>
                                    
                                    <!-- ONLY FOR JQUERY Display block or none..... ******start**** -->
                                    <span id="spanid_<?php echo $userListSkill['skills']['id'];?>">
                                   <!-- ONLY FOR JQUERY Display block or none..... ******END**** -->
                                   <div class="rocommend-container">
                                   
                                   		<ul class="recommend-pics" style="width:100%;">
                                        
                                        <?php foreach ($uers_RecommendedListingwithoutAjax as $withoutAjaxUserShow) {
											if ($withoutAjaxUserShow['skill_recommendations']['skill_id'] == $userListSkill['skills']['id']) {?>
					<li><?php echo $this->Html->image('/files/users/'.$withoutAjaxUserShow['users_profiles']['photo'], array('alt'=>'recommend','style'=>'width:30px; height:27px;'));?></li>
										<?php }}?>
                                       <?php if ($userListSkill[0]['total_recommendations'] !=0) {?>							
          <li><?php echo $this->Html->image('more.png', array('onClick'=>array('showProfiles('.$skill_ids.','.$requested_user_id.');'),'alt'=>'recommend','style'=>'width:15px; height:20px; float:right; padding-top:5px; cursor:pointer;'));?></li>
          			<?php }?>
                                       </ul>
                                        
                                   </div>
                                   
                                   </span> 
                                </li>
                                                                <!-- ALL Recommended user profiles start -->
           <div class="dialog-wrapper" style="display:none; width:600px; position:fixed; top:15%;" id="userSendForm_<?php echo $userListSkill['skills']['id'];?>">
            <div class="dialog-mask">
                <div class="dialog-window">
                    <div class="dialog-title">
                        <button class="dialog-close" onclick="closeMessageForm('<?php echo $skill_ids ?>');"></button>
                        <h3 class="title"><span id="count_people_<?php echo $skill_ids;?>"><?php echo $userListSkill[0]['total_recommendations'];?></span> <?php echo "people recommended ".$user_Name['users_profiles']['firstname']." for ".$userListSkill['skills']['title'];?> </h3>
                    </div>
                    <div class="dialog-body">
                        <div class="dialog-content">
                            <div class="send-message-dialog">
                                <ul style="height:auto; overflow:auto; max-height:290px; padding:0; margin:0; list-style:none;" id="resultDiv_<?php echo $userListSkill['skills']['id'];?>">

                                </ul>
                            
                        </div>
                       </div>
                    </div>
                </div>
            </div>
           </div> <!-- ALL Recommended user profiles END -->
                                <?php }  $i++; }?>
                                
                            </ul>
                        
                        <?php }}?>
                        </div>
              		</div>
                </div>
 <?php  } if ($current_user_profile) {?>
<div class="col-pan-div">
                    <div class="main-coldiv">
                        <a class="opn-col-btn"><span style="padding:10px;" class="effectX">Recommendations</span></a>
                        	<?php  
						if($counts_for_texts ==0) {
							foreach ($current_user_profile as $my_profile) {?>
                      		<div class="expi-main-div" style="padding:10px 20px;" id="your_ID">
                            <div class="expi-pht" style="margin-left:0px; float:left;">
                             <?php if ($my_profile['users_profiles']['photo']) {
						echo $this->Html->image('/files/users/'.$my_profile['users_profiles']['photo'],array('style'=>'width:60px; height:60px; border:none; margin-left:20px;'));
							 		}
									else {
					 					echo $this->Html->image('no-image.png',array('style'=>'width:60px; height:60px; border:none; margin-left:20px;'));
									 }
								?>
                             </div>
                             
        						<div class="expi-div" style="border-bottom:none; width:90%; float:left; margin-left:10px;">
        							<div class="expi-colm" style="width:100%;">
                               		 <div class="expi-txt" style="width:100%;">
                                      
                    <h2 class="title-recommendation"><?php echo $my_profile['users_profiles']['firstname'].", would you like to recommend ".$requested_user_name."?"; ?></h2>
                          			<a class="recommend_link" href="Javascript:show_recommendations()">
									<?php echo "Recommend ".$requested_user_name;?></a>
                                    <div id="recommend_form" class="recommendation_text_form" style="display:none; width:100%;">
                                    <?php 
									echo $this->Form->textarea('recommended_text',array('rows'=>4,'cols'=>50,'id'=>'recommended_text','placeholder'=>'Put your recommended text.'));
									echo $this->Form->text('created',array('type'=>'hidden','value'=>$created_dt = date("Y-m-d H:i:s"),'id'=>'created_date'));
									echo $this->Form->text('modified',array('type'=>'hidden','value'=>$modified_dt = date("Y-m-d H:i:s"),'id'=>'modified_date'));
									?>
                                    <a href="Javascript:add_recommendation('<?php echo $uid?>','<?php echo $friend_id?>')" class="recommend_link" style="float:left;">Recommend</a>

                                    </div>
                                	</div>
       				 			</div>
       						 </div>
                             
                           </div>
                           <?php } }?>
                           
                           		<div id="users_recommended_text_for_user"> <!-- Ajax recods start here --> 
                                <div id="loading" style="position:relative; text-align:center; display:none;"> 
                                <?php echo $this->Html->image('loading.gif');?>
                                </div>
                            	<?php foreach ($user_commendations_text as $commendations_text_Row) {?>
                                <div class="expi-main-div" style="padding:10px 20px;">
                                <div class="expi-pht" style="margin-left:0px; float:left;">
								<?php if ($commendations_text_Row['users_profiles']['photo']) {
									echo $this->Html->image('/files/users/'.$commendations_text_Row['users_profiles']['photo'],array('style'=>'width:60px; height:60px; border:none; margin-left:20px;'));
								 }else {
								 echo $this->Html->image('no-image.png',array('style'=>'width:60px; height:60px; border:none; margin-left:20px;'));
								 }
									?>
        					</div>  
        						<div class="expi-div" style="border-bottom:none; width:91%; float:left; margin-left:10px;">
        						<div class="expi-colm" style="margin-right:0px;">
                                <div class="expi-txt" style="width:100%;">
                                <ul>
                           <li class="edu-ttle"><?php echo $commendations_text_Row['users_profiles']['firstname']." ".$commendations_text_Row['users_profiles']['lastname'];?>
                           </li>
                           </ul>
                           <p><?php echo $commendations_text_Row['Users_recommendation']['recommended_text'];?></p>
                                 
                           </div>
       				 </div>
       			 </div>
                 
       		 </div>
                                <?php }?>
                           
                      </div> <!-- Ajax recods end here --> 
                      
                    </div>
        </div>
 <?php  } if ($getTotalUser) {?>
<div class="col-pan-div">
                    <div class="main-coldiv">
                        <div class="opn-col-btn"><span style="padding:10px;" class="effectX">Connections</span>
                        <ul class="connections-nav">
                <li><a href="Javascript:sharedConnection('<?php echo $uid?>','<?php echo $friend_id?>','all');">All(<?php echo $total_con = sizeof($getTotalUser);?>)</a></li>
                <li><a href="Javascript:sharedConnection('<?php echo $uid?>','<?php echo $friend_id?>','shared');">Shared(<?php echo $shared_Users ;?>)</a></li>
                        <!--<li><a href="Javascript:sharedConnection('<?php //echo $uid?>','<?php //echo $friend_id?>','new');">New</a></li>-->
                        </ul>
                        </div>
                        <div class="col-bot-div cone-info" id="users_shared_connection" style="position:relative;">
                        <div id="loadings" style="position:absolute; z-index:100px; left:50%; top:50%; text-align:center; display:none;"> 
                        	<?php echo $this->Html->image('loading.gif');?>	
                        </div>
                            <ul>
                            <?php 
								foreach ($getTotalUser as $cgetuser) {?>
                                  <li style=" width:47%; float:left; margin-bottom:15px;">
                                <?php if ($cgetuser['users_profiles']['photo']) {?>
									<a class="connection-photo" href="/connections/connection_profile/<?php echo $userId;?>" style="padding:5px; margin-right:8px; float:left;">
                      <img src="<?php echo $this->base;?>/files/users/<?php echo $cgetuser['users_profiles']['photo'];?>" width="36" height="36" alt="no image" style="border-radius:10px;" />
                    					</a>
								<?php } else {?>
                                <a class="connection-photo" href="/connections/connection_profile/<?php echo $userId;?>" style="padding:5px; margin-right:8px; float:left;">
							<img src="<?php echo $this->base;?>/img/no-image.png" width="36" height="36" alt="no image" style="border-radius:10px;" />
                            </a>
								<?php }?>
                                <strong><?php echo $cgetuser['users_profiles']['firstname']." ".$cgetuser['users_profiles']['lastname'];?></strong>
                                <p><?php echo $cgetuser['users_profiles']['tags'];?></p>
                                </li>
                                <?php }?>
                                
                            </ul>
                        </div>
                        
                    </div>
        </div>
    <?php  } if ($groupsListing) {?>
<div class="col-pan-div">
                    <div class="main-coldiv">
                        <a class="opn-col-btn"><span style="padding:10px;" class="effectX">Groups</span></a>
                        <div class="col-bot-div cone-info">
                            <ul>
                            <?php 
								foreach ($groupsListing as $user_group) {
									$group_follow_id = $user_group['users_followings']['id'];
									$group_id = $user_Company['users_followings']['following_id'];
									?>
                                <li style="padding:15px 0px 0px 20px; width:134px; float:left;">
                                <?php if ($user_group['groups']['logo']) {?>
									<a class="connection-photo company_link">
                                    <span style="height:70px;">
            				<img src="<?php echo $this->base;?>/files/groups_logo/<?php echo $user_group['groups']['logo'];?>" width="90" height="50" alt="no image"
             style="border-radius:10px;" />
                    					</span>
                                        </a>
								<?php } else {?>
                                <span style="height:70px;">
							<img src="<?php echo $this->base;?>/img/no-image.png" width="90" height="46" alt="no image" style="border-radius:10px;" />
                            </span>
								<?php }?>
                              <div style="clear:both;"><?php echo $user_group['groups']['title'];?></div>
                                </li>
                                <?php }?> 
                            </ul>
                        </div>
                    </div>
        </div>    
  <?php }if ($uers_following_companies) {?>
<div class="col-pan-div">
                    <div class="main-coldiv">
                        <a class="opn-col-btn"><span style="padding:10px;" class="effectX">Following</span></a>
                        <div class="col-bot-div cone-info">
                        <h3><?php echo "Companies";?></h3>
                            <ul>
                            <?php 
								foreach ($uers_following_companies as $user_Company) {
									$company_follow_id = $user_Company['Users_following']['id'];
									$company_id = $user_Company['Users_following']['following_id'];
									?>
                                <li style="padding:15px 0px 0px 20px; width:134px; float:left;">
                                
                                <?php if ($user_Company['companies']['logo']) {?>
									<a class="connection-photo company_link">
                                    <span style="height:70px;">
            <img src="<?php echo $this->base;?>/files/companies_logo/<?php echo $user_Company['companies']['logo'];?>" width="90" height="50" alt="no image"
             style="border-radius:10px;" />
                    					</span>
                                        </a>
								<?php } else {?>
                                <span style="height:70px;">
							<img src="<?php echo $this->base;?>/img/no-image.png" width="90" height="46" alt="no image" style="border-radius:10px;" />
                            </span>
								<?php }?>
                              <div style="clear:both;"><?php echo $user_Company['companies']['title'];?></div>
                           <div style="clear:both;" id="company_follow_by_user<?php echo $company_follow_id;?>">
                           <?php $flag = false;
						   if ($loggeduers_following_companies) {
							 foreach ($loggeduers_following_companies as $logged_user_company) {
                           	 		$my_following_id = $logged_user_company['Users_following']['following_id'];
									$my_user_follow_id = $logged_user_company['Users_following']['id'];
									if ($my_following_id == $company_id) {
										 if ($logged_user_company['Users_following']['status'] == 2) {
											echo $this->Html->link('Following','Javascript:unfollow('.$company_follow_id.','.$my_user_follow_id.','.$uid.',0,'.$company_id.')',array(
											'class'=>'follow_link follow-icon','id'=>'follow_comp'.$company_follow_id,
											'onMouseOver'=>'showUnfollow('.$company_follow_id.')','onMouseOut'=>'hideUnfollow('.$company_follow_id.')'));
											$flag = true;
											break;
           				  					}
						 
										else if ($logged_user_company['Users_following']['status'] == 0) { 
   										 echo $this->Html->link('Follow','Javascript:unfollow('.$company_follow_id.','.$my_user_follow_id.','.$uid.',2,'.$company_id.')',array(
															'class'=>'follow_link unfollow-icon','id'=>'unfollow_comp'.$company_follow_id));
										 $flag = true;
										 break;
           					 			}
									}
										
							}
							if ($flag == false) { 
							    echo $this->Html->link('Follow','Javascript:unfollow('.$company_follow_id.','.$company_follow_id.','.$uid.',2,'.$company_id.')',array(
															'class'=>'follow_link unfollow-icon','id'=>'unfollow_comp'.$company_follow_id)); 
						   	}
						   }
						   else {
							  echo $this->Html->link('Follow','Javascript:unfollow('.$company_follow_id.','.$company_follow_id.','.$uid.',2,'.$company_id.')',array(
															'class'=>'follow_link unfollow-icon','id'=>'unfollow_comp'.$company_follow_id)); 
						   }
						   
						?>
            </div>
                                </li>
                                <?php }?> 
                            </ul>
                        </div>
                    </div>
        </div>
       <?php }?> 
       <div class="dialog-wrapper" style="display:none; top:6%;" id="user_sign">
 </div>
    <script>
function showInfo(div) {
$("#"+div).slideToggle('slow');
}
function checkValidate() {

var userid = document.getElementById('user_id').value;
var friendid = document.getElementById('friend_id').value;
if (friendid == userid)
alert("you cant sent reques to itself");
return false;
}
function showProfiles(id,user_id) {
document.getElementById('fade').style.display = 'block';
document.getElementById('userSendForm_'+id).style.display = 'block';

	//return false;
	$.ajax({
	url     : baseUrl+"/users_profiles/recommended_profiles",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,id:id},
	success : function(data){	
	//$(this).css('background','none');
	$("#resultDiv_"+id).html(data);
	},
	error : function(data) {
	$("#resultDiv_"+id).html("error");
	}
	});
}
function closeMessageForm(id) {
document.getElementById('fade').style.display = 'none';
document.getElementById('userSendForm_'+id).style.display = 'none';
}
function inviteUserChat() {
var userid = document.getElementById('user_id').value;
var recommends = document.getElementById('friend_id').value;

var status = document.getElementById('status').value;
$.ajax({
              url     : baseUrl+"/users_profiles/recommend_skill",
              type    : "POST",
              cache   : false,
              data    : {userid: userid,recommends:recommends,skill:skill,status:status,recommendation:recommendation},
              success : function(data){
			  $("#spanid_"+skillID).html(data);
			  $("#recommend"+skillID).css('display','none');
			  $("#recommended"+skillID).css('display','none');
              },
			  error : function(data) {
           $("#span_"+skillID).html("there is error");
        }
          });
}
function recommendSkill(skillID,recommendation) {
var userid = document.getElementById('friend_user_id').value;
var recommends = document.getElementById('recommends').value;
var skill = document.getElementById('skill_id_'+skillID).value;
var status = document.getElementById('status').value;
var start_date = document.getElementById('start_date').value;
var end_date = document.getElementById('end_date').value;

$.ajax({
              url     : baseUrl+"/users_profiles/recommend_skill",
              type    : "POST",
              cache   : false,
              data    : {userid: userid,recommends:recommends,skill:skill,status:status,recommendation:recommendation,end_date:end_date,start_date:start_date},
              success : function(data){
				  responseArray = data.split("::::");
			  $("#skill_counter_"+skillID).html(responseArray[0]);
			  $("#count_people_"+skillID).html(responseArray[0]);
			  $("#spanid_"+skillID).html(responseArray[1]);
			  $("#recommend"+skillID).css('display','none');
			  $("#recommended"+skillID).css('display','none');
              },
			  error : function(data) {
           $("#span_"+skillID).html("there is error");
        }
          });
}
function removeSkill(skillID,recommendation,recommend_id) {
var userid = document.getElementById('friend_user_id').value;
var recommends = document.getElementById('recommends').value;
var skill = document.getElementById('skill_id_'+skillID).value;
var status = document.getElementById('status').value;
var start_date = document.getElementById('start_date').value;
var end_date = document.getElementById('end_date').value;
//alert(start_date+"and"+end_date);

$.ajax({
              url     : baseUrl+"/users_profiles/recommend_skill",
              type    : "POST",
              cache   : false,
              data    : {userid: userid,recommends:recommends,skill:skill,status:status,recommendation:recommendation,recommend_id:recommend_id,end_date:end_date,start_date:start_date},
              success : function(data){
			$("#recommend"+skillID).css('display','none');
			  $("#recommended"+skillID).css('display','none');
			  //$("#spanid_"+skillID).html(data);
			  responseArray = data.split("::::");
			  $("#skill_counter_"+skillID).html(responseArray[0]);
			  $("#count_people_"+skillID).html(responseArray[0]);
			  $("#spanid_"+skillID).html(responseArray[1]);
              },
			  error : function(data) {
           $("#spanid_"+skillID).html("there is error");
        }
          });
}

function userFollow(status,id) {
		
	var user_id = document.getElementById('u_id').value;
	var following_type = document.getElementById('content_type').value;
	var following_id = document.getElementById('following_id').value;
	var start_date = document.getElementById('start_date').value;
	var end_date = document.getElementById('end_date').value;
	//alert(following_id+"and"+start_date+"and"+user_id+"and"+following_type);
	$.ajax({
	url     : baseUrl+"/comments/add_follow",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,following_type:following_type,start_date:start_date,following_id:following_id,end_date:end_date,status:status,id:id},
	success : function(data){	
	responseArrays = data.split("-");
	//alert(responseArrays);
	$("#resultantDiv").html(responseArrays[0]);
	$("#user_following_btn").html(responseArrays[1]);
	},
	error : function(data) {
	$("#resultantDiv").html("error");
	}
	});
	}
function show_recommendations() {
	$("#recommend_form").slideToggle('slow');
}
function add_recommendation(user_id,friend_id) {
	var recommended_text = document.getElementById('recommended_text').value;
	var created = document.getElementById('created_date').value;
	var modified = document.getElementById('modified_date').value;
	//alert(user_id+"and"+friend_id+"and"+recommended_text+"and"+created);
	$('#loading').show();
	$.ajax({
	url     : baseUrl+"/users_profiles/add_recommendation_text",
	type    : "POST",
	cache   : false,
	data    : {user_id: user_id,friend_id:friend_id,created:created,modified:modified,recommended_text:recommended_text},
	success : function(data){	
	$("#users_recommended_text_for_user").html(data);
	$("#your_ID").slideUp('slow');
	},
     complete: function () {
                    $('#loading').hide();
                },
	error : function(data) {
	$("#users_recommended_text_for_user").html(data);
	}
	});
}

function sharedConnection(user_id,friend_id,type) {
	$('#loadings').show();
	$.ajax({
	url     : baseUrl+"/connections/shared_connections",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,friend_id:friend_id,type:type},
	success : function(data){	
	$("#users_shared_connection").html(data);
	},
     complete: function () {
       $('#loadings').hide();
                },
	error : function(data) {
	$("#users_shared_connection").html(data);
	}
	});
}

function showMessageForm() {
document.getElementById('fade').style.display = 'block';
document.getElementById('userSendForm').style.display = 'block';
}
function hideMessageForm() {
document.getElementById('fade').style.display = 'none';
document.getElementById('userSendForm').style.display = 'none';
}
function unfollow(result_id,following_id,user_id,status,company_id) {
	
	$.ajax({
	url     : baseUrl+"/users_profiles/companies_follow",
	type    : "POST",
	cache   : false,
	data    : {following_id:following_id,status:status,user_id:user_id,company_id:company_id,result_id:result_id},
	success : function(data){	
	//$(this).css('background','none');
	$("#company_follow_by_user"+result_id).html(data);
	},
	error : function(data) {
	$("#company_follow_by_user"+result_id).html(data);
	}
	});
	
}
function showUnfollow(following_id) {
$("#follow_comp"+following_id).html("Unfollow");
}
function hideUnfollow(following_id) {
$("#follow_comp"+following_id).html("Following");
}

function showStarSign(star_id,user_id) {
document.getElementById('fade').style.display = 'block';
document.getElementById('user_sign').style.display = 'block';
	$.ajax({
	url     : baseUrl+"/connections/user_star",
	type    : "GET",
	cache   : false,
	data    : {star_id: star_id,user_id:user_id},
	success : function(data){	
	//$(this).css('background','none');
	$("#user_sign").html(data);
	},
	error : function(data) {
	$("#user_sign").html("error");
	}
	});	
}
function hideUserSign() {
document.getElementById('fade').style.display = 'none';
document.getElementById('user_sign').style.display = 'none';
}
</script> 