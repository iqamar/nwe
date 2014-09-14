<?php $paginator = $this->Paginator;?>
<div class="box">
	<div class="tab-container" id="tab-container" data-easytabs="true">
		<ul class="etabs">
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/lists">Your Groups</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/">Following</a></li>
            <li class="tab active"><a href="#" class="active">Search Group</a></li>		
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/add/">Add Group</a></li>
		</ul>
		<div class="panel-container">
			<div id="tabs1" style="display: block;" class="active">
            	<div class="connection-search">
                        	<form action="" method="post">
                            	<fieldset>
                                	<label>
                                   	  <input name="group_title" type="text"  class="textfield width2"  onfocus="if(this.value=='Search Groups') this.value='';" onblur="if(this.value=='') this.value='Search Groups';" value="Search Groups" id="group_title" onkeypress="showGroups();" />
                                    </label>
                                    <label>
                                    	<input type="button" class="submitbttn" onclick="showGroups();" value="Search" />
                                    </label>
                                </fieldset>
                            </form>
        		</div>
                <?php echo $this->Session->flash();?>
                <div id="serach_output">
            	<?php 
       				 if ($groupsListing) {
        				foreach ($groupsListing as $group) { 
        					$groupID = $group['Group']['id'];
							$users_following_id = $group['users_followings']['id'];
							$grouptitle = strtolower($group['Group']['title']);
							$grouptitle = str_replace(' ', '-', $grouptitle);
							$group_user = strtolower($group['Group']['user_id']);
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
							}
							else {
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
                       <li>
                       <div id="response_<?php echo $groupID;?>">
                       	 <?php if ($group_user != $uid) {?> 
                          
                            <?php $flag = false; 
                            foreach ($loggeduers_following_groups as $logged_user_group) {
                                            $my_following_id = $logged_user_group['users_followings']['following_id'];
                                            $my_user_follow_id = $logged_user_group['users_followings']['id'];
                                    if ($groupID == $my_following_id) {
                                ?>
                            <?php if ($logged_user_group['users_followings']['status']== 0 && $logged_user_group['users_followings']['user_id']==$uid) {?>
                            <span id="follow_<?php echo $groupID;?>">
                                <a href="Javascript:followingTheGroup('<?php echo $groupID?>','<?php echo $uid?>','2','<?php echo $my_user_follow_id ?>')" class="join lft" >Join</a>
                            </span>
                            <?php  $flag = true; break;}?>
                            <?php if ($logged_user_group['users_followings']['status']==2 && $logged_user_group['users_followings']['user_id']==$uid) { ?>
                            <span>
                                 <?php echo $this->Html->link('View',array('controller'=>'groups','action'=>'view',$groupID,$grouptitle), array('class'=>'join lft'));?>
                            </span>
                            <?php $flag = true; break; }?>
                            <?php if ($logged_user_group['users_followings']['status']==1 && $logged_user_group['users_followings']['user_id']==$uid) { ?>
                            <span>
                                 <?php echo $this->Html->link('Approval Pending',array('controller'=>'groups','action'=>'view',$groupID,$grouptitle),
                                                                                                  array('class'=>'waiting_approval lft'));?>
                            </span>
                            <?php $flag = true; break; }?>
                            <?php }}?>
                            <?php if ($flag == false) { ?>
                            <span id="follow_<?php echo $groupID;?>">
                                <a href="Javascript:followingTheGroup('<?php echo $groupID?>','<?php echo $uid?>','2','')" class="join lft">Join</a>
                            </span>
                            <?php }?>
                            
                         <?php }?>
                        </div>
                       </li>
                          <input type="hidden" name="start_date" id="start_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
    					  <input type="hidden" name="end_date" id="end_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
                     </ul>
                    <div class="clear"></div>
                </div>
				<?php }}?>
            	</div>
       			<div class="clear"></div>	
                
            </div>
    
        </div>
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
    </div>  
 </div> 	
 
<script type="text/javascript">
$( document ).ready(function() {
  $("#success_mesg_hide").slideDown('slow').delay(300).fadeOut();
});
function followingTheGroup(groupid,user_id,status,user_following_id) {
	$("#response_"+groupid).html('<img src="http://media.networkwe.com/img/loading.gif" style="float:left;" />');
	var start_date = document.getElementById('start_date').value;
	var end_date = document.getElementById('end_date').value;
	$.ajax({
              url     : baseUrl+"/groups/join_group",
              type    : "GET",
              cache   : false,
              data    : {groupid: groupid,user_id:user_id,start_date:start_date,end_date:end_date,status:status,user_following_id:user_following_id},
              success : function(data){
				  $("#response_"+groupid).html(data);
			 //$("#follow_"+groupid).css('display','none');
			 //$("#following_"+groupid).css('display','block');	
			  
              },
			  error : function(data) {
           $("#span_"+groupid).html("error in request");
        }
          });
			
}

function showGroups() {
//$('#edit_Recs').show();

var group_title = document.getElementById('group_title').value;
$.ajax({
              url     : baseUrl+"/groups/search_group",
              type    : "GET",
              cache   : false,
              data    : {group_title: group_title},
              success : function(data){
			  $("#serach_output").html(data);
              },
			  error : function(data) {
           $("#serach_output").html("there is error");
        }
          });
		  
}
</script>
