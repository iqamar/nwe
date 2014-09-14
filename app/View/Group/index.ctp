<script>
$( document ).ready(function() {
  $("#success_mesg_hide").slideDown('slow').delay(300).fadeOut();
});
</script>
<?php $paginator = $this->Paginator;?>
<div class="box">
	<div class="tab-container" id="tab-container" data-easytabs="true">
		<ul class="etabs">
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/lists">Your Groups</a></li>
			<li class="tab active"><a href="#" class="active">Following</a></li>
            <li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/search">Search Group</a></li>		
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/add/">Add Group</a></li>
		</ul>
		<div class="panel-container">
			<div id="tabs1" style="display: block;" class="active">  
			<?php echo $this->Session->flash();?>
		<div class="heading"><h1><?php echo "Groups you are following:";?></h1></div>
		<?php 
        if ($groupsListing) {
       	 	foreach ($groupsListing as $group) { 
        		$groupID = $group['Group']['id'];
				$users_following_id = $group['users_followings']['id'];
				$grouptitle = strtolower($group['Group']['title']);
				$grouptitle = str_replace(' ', '-', $grouptitle);
		?>

       <div class="profile-group">
		  <div class="profile-group-logo">
			  <a href="#">
				<?php 
					if (!empty($group['Group']['logo'])) {
						if (file_exists(MEDIA_PATH.'/files/group/logo/'.$group['Group']['logo'])) {
							echo $this->Html->image(MEDIA_URL.'/files/group/logo/'.$group['Group']['logo'],array('url'=>array(
																														   'controller'=>'groups',
																														   'action'=>'view',$groupID,$grouptitle),
																											  'alt'=>'no-img'));
						}
						else {
							echo $this->Html->image(MEDIA_URL.'/img/no_group_photo.jpg',array('url'=>array(
																							   'controller'=>'groups',
																							   'action'=>'view',$groupID,$grouptitle),
																				'alt'=>'no-img'));
						}
					}else {
						echo $this->Html->image(MEDIA_URL.'/img/no_group_photo.jpg',array('url'=>array(
																							   'controller'=>'groups',
																							   'action'=>'view',$groupID,$grouptitle),
																				'alt'=>'no-img'));
					}
				?>
			  </a>
		  </div>
          <ul>
            <li>
                <?php echo $this->Html->link($group['Group']['title'],array('controller'=>'groups','action'=>'view',$groupID,$grouptitle),array());?>
            </li>
            <li><?php echo $group['groups_types']['title'];?></li>
            <?php if ($group['users_followings']['status'] == 1) {?>
            <li><a class="waiting_approval">Approval Pending</a></li>
            <?php }?>
            
         </ul>
        <div class="clear"></div>
	</div>
	<?php }}?>
     <div class="clear"></div>
    <?php // pagination section Start
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
				//echo $paginator->numbers(array('modulus' => 1));
				echo $paginator->numbers();
				 
				// for the 'next' button
				if($paginator->hasNext()){
					echo $paginator->next("Next");
				}
				 
				// the 'last' page button
				echo $paginator->last("Last");
			 
			echo "</div>";
			// pagination section End
			?>
			<input type="hidden" name="start_date" id="start_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
			<input type="hidden" name="end_date" id="end_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
            <div class="clear"></div>
		<?php 
        if ($groups_you_may_know) {
			echo '<div class="heading"><h1>Groups you may be interested:</h1></div>';
        foreach ($groups_you_may_know as $group_you_know_row) {
			foreach ($group_you_know_row as $key=>$group_row) { 
				if ($group_row != '') {
        			$groupID = $group_row['groups']['id'];
					$grouptitle = strtolower($group_row['groups']['title']);
					$grouptitle = str_replace(' ', '-', $grouptitle);
					$flage = false;
					foreach ($groups_joined_by_you as $group_follow_you) { 
						if ($group_follow_you['users_followings']['following_id'] == $groupID) {
							$flage = true;
						}
					}
					if (in_array($groupID,$group_array)) {
								$flage = true;
						}
						else {
							$group_array[] = $groupID;
						}
					if ($flage == false){ ?>
				
		<div class="profile-group">
			<div class="profile-group-logo">
			  <a href="#">
				<?php 
					if (!empty($group_row['groups']['logo'])) {
						if (file_exists(MEDIA_PATH.'/files/group/logo/'.$group_row['groups']['logo'])) {
							echo $this->Html->image(MEDIA_URL.'/files/group/logo/'.$group_row['groups']['logo'],array('url'=>array(
																														   'controller'=>'groups',
																														   'action'=>'view',$groupID,$grouptitle),
																											  'alt'=>'no-img'));
						}
						else {
							echo $this->Html->image(MEDIA_URL.'/img/no-image.png',array('url'=>array(
																							 'controller'=>'groups',
																							 'action'=>'view',$groupID,$grouptitle),
																				'alt'=>'no-img'));
						}
					}else{
						echo $this->Html->image(MEDIA_URL.'/img/no-image.png',array('url'=>array(
																							 'controller'=>'groups',
																							 'action'=>'view',$groupID,$grouptitle),
																				'alt'=>'no-img'));
					}
				?>
			  </a>
			</div>
			<ul>
				<li>
					<?php echo $this->Html->link($group_row['groups']['title'],array('controller'=>'groups','action'=>'view',$groupID,$grouptitle),array());?>
				</li>
                <li><?php echo $group_row['groups_types']['title'];?></li>
				<li>
					<span id="follow_<?php echo $groupID?>">
						<a href="javascript:" class="join" onclick="return followingTheGroup('<?php echo $groupID?>','<?php echo $uid?>','0')" >Join</a>
					</span>
				</li>
			</ul>
			<div class="clear"></div>
		</div>	
	
	<?php }}}}}?>
			<div class="clear"></div>
            </div>	 
          </div>	
       </div>	
   </div>	
<script type="text/javascript">
function followingTheGroup(groupid,user_id,status,user_following_id) {
	//alert(companyid+follow);
	//$("#follow_"+companyid).css('display','none');
	//$("#following_"+companyid).css('display','block');
	var start_date = document.getElementById('start_date').value;
	var end_date = document.getElementById('end_date').value;
	$.ajax({
              url     : baseUrl+"/groups/join_group",
              type    : "GET",
              cache   : false,
              data    : {groupid: groupid,user_id:user_id,start_date:start_date,end_date:end_date,status:status,user_following_id:user_following_id},
              success : function(data){
				  $("#follow_"+groupid).html(data);
			 <!--location.href = "/groups/"-->
              },
			  error : function(data) {
           $("#follow_"+groupid).html("error in request");
        }
          });
			
}
</script>