<div class="box">
	<div class="tab-container" id="tab-container" data-easytabs="true">
        <ul class="etabs">
            <li class="tab active"><a href="#" class="active">Your Groups</a></li>
            <li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/">Following</a></li>	
            <li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/search">Search Group</a></li>	
            <li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/add/">Add Group</a></li>
        </ul>
    <div class="panel-container">
		<div id="tabs1" style="display: block;" class="active"> 
        	<?php if ($this->params['named']['mesg'] !=''){ ?>
					<div class="success_msg">
							<?php
								$mesg = $this->params['named']['mesg']; 
								echo $mesg;
							?>
					</div>
			<?php  }?>
     
     	
		<?php 
        if ($groupDetail) {
        $groupID = $groupDetail['groups']['id'];
		$grouptitle = strtolower($groupDetail['groups']['title']);
		$grouptitle = str_replace(' ', '-', $grouptitle);
		$group_owner = $groupDetail['groups']['user_id'];
		?>
        
		<!--- group header start -->
			<div>
				<div class="com-rgt">
					<div class="companypage-logo">
					<?php
						if(!empty($groupDetail['groups']['logo'])){
							$file = MEDIA_URL.'/files/group/logo/'.$groupDetail['groups']['logo'];
							$file_headers = @get_headers($file);
							if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
								echo $this->Html->image(MEDIA_URL.'/img/no_group_photo.jpg',array());
							}else {
								echo $this->Html->image($file,array());
							}
						}else{
							echo $this->Html->image(MEDIA_URL.'/img/no_group_photo.jpg',array());
						}
					?>		
					</div> 
					<div class="button-in-middle">					
						<?php if ($groupDetail['groups']['user_id'] != $uid) {?>
							<span id="group_follow_by_user">            
								<?php 
									if ($users_following_thisGroup !=0){
										if ($status == 2) {?>
											<a href="javascript:unfollow('<?php echo $user_group_id ?>','<?php echo $uid?>','0','<?php echo $groupID?>')" class="button" >Leave</a> 
										<?php } else if ($status == 1) { ?>
										
								<a style="width:97px;" class="waiting_approval" >Pending Request</a>
										<?php } else {?>
											<a href="javascript:unfollow('<?php echo $user_group_id ?>','<?php echo $uid?>','2','<?php echo $groupID?>')" class="button" >Member</a>
										<?php }
									} else {?>
										<a href="javascript:unfollow('<?php echo $user_group_id ?>','<?php echo $uid?>','2','<?php echo $groupID?>')" class="button">Member</a>
									<?php }?>
								</span>
						<?php } ?>						   						
						
						<div class="clear"></div>
					</div>
					<div class="totalfollowers">
							<span id="total_following"><?php  echo $count_following_thisGroup;?> </span> members </span>							
					</div>
					<div class="clear"></div>
				</div>
		 
				<div class="com-lft">
					<div class="com-left-details">
						<ul>
							<li>
								<h1><?php echo $groupDetail['groups']['title'];?></h1>
							</li>
							<li>									
								<a target="_blank" href="<?php echo $groupDetail['groups']['weburl'];?>"><?php echo $groupDetail['groups']['weburl'];?></a>
							</li>
							<li>
								<strong>Type:</strong> <?php echo $groupDetail['groups_types']['title'];?>
							</li>
							<li>
								<strong>Created:</strong> <?php echo date("M d, Y", strtotime($groupDetail['groups']['created']));?> | <strong>Group Mode:</strong> <?php echo $groupDetail['groups']['group_mode'];?> | <strong>Joining Mode:</strong> <?php echo $groupDetail['groups']['joining_mode'];?>
							</li>
						</ul> 
					</div>
					<div class="companypage-nav">
						
                        <?php echo $this->Html->link('Home',array('controller'=>'groups','action'=>'view',$groupID,$grouptitle));?>
						<?php echo '<a  href="'.NETWORKWE_URL.'/groups/jobs/'.$groupID.'/'.$grouptitle.'">Jobs</a>';?>
						<?php echo $this->Html->link('Members',array('controller'=>'groups','action'=>'members',$groupID,$grouptitle),array('class'=>'selected'));?>
						<?php if ($groupDetail['groups']['user_id'] == $uid){?>
						<?php echo '<a href="'.NETWORKWE_URL.'/groups/add/'.$groupID.'/'.$grouptitle.'">Edit Group</a>';?>
                        <?php echo '<a href="'.NETWORKWE_URL.'/groups/delete/'.$groupID.'/'.$grouptitle.'">Delete Group</a>';?>
                        
						<?php }?>		
						<div class="clear"></div>    
					</div>   
					<div class="clear"></div>
				</div>
			<div class="clear"></div>
		</div>
		<!--- group header end -->


        <?php if ($group_owner == $uid){?>
        <?php if ($group_members_approve) {?>
        	<div class="heading"><h1>New Members</h1></div>
        	<?php foreach ($group_members_approve as $group_approve_Row) {
					$member_id = $group_approve_Row['Users_following']['id'];
					$user_id = $group_approve_Row['Users_following']['user_id'];
					$user_name = $group_approve_Row['users_profiles']['firstname']." ".$group_approve_Row['users_profiles']['lastname'];
					$user_tag = $group_approve_Row['users_profiles']['tags'];
					$user_handler = $group_approve_Row['users_profiles']['handler'];
				?>
                
                <div class="connection-listing">
					    <div class="connection"> 
                        	<a href="/pub/<?php echo $user_handler;?>">
                        		<?php 
								if (!empty($group_approve_Row['users_profiles']['photo'])) {
									if (file_exists(MEDIA_PATH.'/files/user/thumbnail/'.$group_approve_Row['users_profiles']['photo'])) {	
       									echo $this->Html->image(MEDIA_URL.'/files/user/thumbnail/'.$group_approve_Row['users_profiles']['photo'],array('alt'=>'no-img'));
									}
									else {
										echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'no-img'));
									}
        						}
							  else {
								echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'no-img'));
							  }?>
                            </a>
                        </div>
					    <div class="connection-listing-rgt">
					      <ul>
					        <li>
					          <h1><a href="/pub/<?php echo $user_handler;?>"><?php echo $user_name;?></a></h1>
				            </li>
					        <li><?php echo $user_tag;?> </li>
					        <li>
					          <div class="listing-bttns"> 
                                  <form method="post" name="approve_form" action="/groups/approve_for_joining/<?php echo $groupID;?>/<?php echo $grouptitle;?>">
                                        <input type="hidden" name="data[Users_following][user_id]" value="<?php echo $user_id;?>" />
                                        <input type="hidden" name="data[Users_following][following_id]" value="<?php echo $groupID;?>" />
                                        <input type="hidden" name="data[Users_following][member_id]" value="<?php echo $member_id;?>" />
                                        <input type="hidden" name="data[Users_following][group_title]" value="<?php echo $grouptitle;?>" />
                                        <input type="submit" name="approve" value="Approve" class="submitbttn" />
                                  </form>
                              </div>
					         </li>
				          </ul>
				        </div>
					    <div class="clear"></div>
			    </div>
			<?php }?>   
    <?php } }?>
    
				<div class="heading"><h1>Group Members</h1></div>
        	<?php foreach ($group_members as $group_members_Row) {
					$fullname = $group_members_Row['users_profiles']['firstname']." ".$group_members_Row['users_profiles']['lastname'];
					$user_headline = $group_members_Row['users_profiles']['tags'];
					$user_publiclink = $group_members_Row['users_profiles']['handler'];
				?>
            
                <div class="connection-listing">
                            <div class="connection"> 
                                <a href="/pub/<?php echo $user_publiclink;?>">
                                    <?php 
									   if (!empty($group_members_Row['users_profiles']['photo'])) {
											if (file_exists(MEDIA_PATH.'/files/user/thumbnail/'.$group_members_Row['users_profiles']['photo'])) {
                                            	echo $this->Html->image(MEDIA_URL.'/files/user/thumbnail/'.$group_members_Row['users_profiles']['photo'],array('alt'=>'no-img'));
											}
											else {
												echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'no-img'));
											}
									  }
									  else {
										echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'no-img'));
									  }?>
                                </a>
                            </div>
                            <div class="connection-listing-rgt">
                              <ul>
                                <li>
                                  <h1><a href="/pub/<?php echo $user_publiclink;?>"><?php echo $fullname;?></a></h1>
                                </li>
                                <li><?php echo $user_headline;?> </li>
                                
                              </ul>
                            </div>
                            <div class="clear"></div>
                   </div>
			<?php }?>
   
    
	<?php }?>
    	<div class="clear"></div>
    	</div>
     </div>
	</div>
</div>
<script type="text/javascript">
function unfollow(user_follow_id,user_id,status,group_id) {
	$("#group_follow_by_user").html('<img src="http://media.networkwe.net/img/loading.gif" />');
	$.ajax({
	url     : baseUrl+"/groups/follow_group",
	type    : "POST",
	cache   : false,
	data    : {status:status,user_id:user_id,group_id:group_id,user_follow_id:user_follow_id},
	success : function(data){	
	//$(this).css('background','none');
	responseArray = data.split("::::");
	$("#total_following").html(responseArray[0]);
	$("#group_follow_by_user").html(responseArray[1]);
	},
	error : function(data) {
	$("#group_follow_by_user").html("error");
	}
	});
	
}

function showShare() {
document.getElementById('status_share_options').style.display='block';
return true;
}

$(document).ready(function(){
	/*
	This function is called when the value of input type='file' changes.
	It further calls previewImage function which sets the image to 'preview_img'
	*/
	$("#myfile").change(function(){
    	previewImage(this);
		
	});
});
function afterSuccess() {
    $('.loading').hide();
	$('.result_txt').show();
}
function previewImage(input) {
	if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.preview_img').attr('src', e.target.result);
			$('.output_div').show();
			$('.result_txt').hide();
        }
		reader.readAsDataURL(input.files[0]);
    }
}

</script>