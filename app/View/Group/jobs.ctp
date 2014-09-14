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
										
								<a style="width:97px;"  class="waiting_approval"> Pending Request</a>
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
						<?php echo '<a class="selected" href="'.NETWORKWE_URL.'/groups/jobs/'.$groupID.'/'.$grouptitle.'">Jobs</a>';?>
						<?php echo $this->Html->link('Members',array('controller'=>'groups','action'=>'members',$groupID,$grouptitle));?>
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
		
		<?php if ($user_group_id) {
				
				if ($check_user_ToGroup != 0) {?>  
					<!--- company shareupdate start -->	
					<div class="companypage-mainbox">
					<div class="boxheading">
						<h1>Jobs</h1>
						<div class="boxheading-arrow"></div>
					</div>
						<?php 
							
							$i=0;
							foreach($data as $row){
								$postdate = date("F j, Y", strtotime($row['Job']['modified']));
								if($row['Company']['logo']){
									if (file_exists(MEDIA_PATH.'/files/company/icon/'.$row['Company']['logo'])) {
										$company_logo='/files/company/icon/'.$row['Company']['logo'];
									}
									else {
										$company_logo='/img/no_group_photo.jpg';
									}
								}else{
									$company_logo='/img/no_group_photo.jpg';
								}
							
								$listing ="<div class='joblisting'>";
								$listing.="<div class='job-com-logo'>".$this->Html->link($this->Html->Image(MEDIA_URL.$company_logo,array()),JOBS_URL.'/search/jobDetails/'.$row['Job']['id'],array('escape'=>false))."</div>";
								$listing.="<ul style='width:550px'><li><h1>".$this->Html->link($row['Job']['title'],JOBS_URL.'/search/jobDetails/'.$row['Job']['id'],array('escape'=>false))."</h1></li>";
								$listing.="<li>Location: <span class='location'>".$row['Job']['city'].",&nbsp;".$row['Country']['name']."</span></li>";
								$listing.="<li><span class='postedon'>Posted On: ".$postdate."</span>";
								$listing.="<div class='listing-bttns'>";
								
								
								$listing.=$this->Html->link('Apply for Job',JOBS_URL.'/search/jobDetails/'.$row['Job']['id'],array('escape'=>false,'class'=>'apply-bttn'));
								$listing.="</div></li></ul><div class='clear'></div></div>";
								
								echo $listing;
							}
						?>
						<div class="clear"></div>
						<div class="paging">
							<?php echo $this->Paginator->numbers(array('separator'=>'&nbsp;&nbsp;'));?>
						</div>
					</div>          

		<?php }?>
	<?php } ?>

		

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

</script>