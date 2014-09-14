<?php if ($user_related_groups) { 
 $str = '';
 $check = 0;
$str .= '<div class="greybox">
	    <div class="greybox-div-heading">
				<h1>Groups You May Join</h1>
		  </div>';
		  
		  foreach ($user_related_groups as $group_Related_row) {
			foreach ($group_Related_row as $key=>$group_row) { 
					$groupID = $group_row['groups']['id'];
					$grouptitle = strtolower($group_row['groups']['title']);
					$grouptitle = str_replace(' ', '-', $grouptitle);
					$flage = false;
						foreach ($user_joined_groups as $group_follow_you) { 
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
						if ($flage == false) {
							$check = 1;
	 $str .= '<div class="rgtwidget-listing2">
				<div class="rgtwidget-listing2-logo">';
					if ($group_row['groups']['logo']) {
						if (file_exists(MEDIA_PATH.'/files/group/original/'.$group_row['groups']['logo'])) {
							$str .= $this->Html->image(MEDIA_URL.'/files/group/original/'.$group_row['groups']['logo'],
																						 array('url'=>array('controller'=>'groups',
																											'action'=>'view',
																											$groupID,
																											$grouptitle
																											),
																											'alt'=>'no image',
																											'style'=>''
																											)
																						 );
						}
						else {
							$str .= $this->Html->image(MEDIA_URL.'/img/nologo.jpg',
												array('url'=>array(
																   'controller'=>'groups',
																   'action'=>'view',
																   $groupID,
																   $grouptitle
																   ),
													  'alt'=>'no image',
													  'style'=>''
													  )
												);
						}
					}
					else {
						$str .= $this->Html->image(MEDIA_URL.'/img/nologo.jpg',
												array('url'=>array(
																   'controller'=>'groups',
																   'action'=>'view',
																   $groupID,
																   $grouptitle
																   ),
													  'alt'=>'no image',
													  'style'=>''
													  )
												);
					}
		$str .=	'</div>
				<div class="rgtwidget-listing2-rgt">
				<ul> 
					<li>
						<h1>';
                        	$str .= $this->Html->link($group_row['groups']['title'],array(
																							 'controller'=>'groups',
																							 'action'=>'view',
																							 $groupID,
																							 $grouptitle
																							 ));
                    $str .= '</h1>
					</li>
					<li>'.$group_row['groups_types']['title'].'</li>
					<li>
                    	<div id="span_'.$groupID.'">
							
            			</div>
                        <input type="hidden" name="start_date" id="start_date" value="'.$date = date("Y-m-d h:i:s").'" />
    					<input type="hidden" name="end_date" id="end_date" value="'.$date = date("Y-m-d h:i:s").'" />
                    </li>
				</ul>
			</div>
            
        <div class="clear"></div>
        </div>';
		 }}}
		  
        	$str .= '<div class="more">'; $str .= $this->Html->link('More...',array('controller'=>'groups','action'=>'search')); $str .='</div>';
$str .='</div>';
 }
 if ($check == 1) {
	 echo $str;
 }
 ?>

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
			  $("#span_"+groupid).html(data);
              },
			  error : function(data) {
           $("#span_"+groupid).html("error in request");
        }
          });
			
}
</script>