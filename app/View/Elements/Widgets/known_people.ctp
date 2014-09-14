<?php 
if ($colse_Friends_toUser) {?>
	<div class="greybox">
	    <div class="greybox-div-heading">
				<h1>People You May Know</h1>
		 </div>
         <?php 
		 foreach ($colse_Friends_toUser as $user_you_know_row) {
				$user_id = $user_you_know_row['users_profiles']['user_id'];
				$full_name = $user_you_know_row['users_profiles']['firstname']." ".$user_you_know_row['users_profiles']['lastname'];
				$known_user_photo = $user_you_know_row['users_profiles']['photo'];
				
				if ($known_user_photo && file_exists(MEDIA_PATH.'/files/user/original/'.$known_user_photo)) {
					$user_photo = MEDIA_URL.'/files/user/original/'.$known_user_photo;
				}
				else {
					$user_photo = MEDIA_URL.'/img/nophoto.jpg';
				}
			?>
         <div class="rgtwidget-listing2" id="known_user_<?php echo $user_id?>">
				<div class="rgtwidget-listing2-logo">
					<?php 
						 echo $this->Html->image($user_photo,array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$user_id)));
					?>
				</div>
				<div class="rgtwidget-listing2-rgt">
				<ul> 
					<li>
						<h1>
                        	<?php echo $this->Html->link(substr($full_name,0,20),array('controller'=>'users_profiles','action'=>'userprofile',$user_id),array('style'=>''));?>
                        </h1>
					</li>
					<li><?php echo substr($user_you_know_row['users_profiles']['tags'],0,35);?></li>
						<?php  $flag = false; 
                        foreach ($get_user_connection_st as $conn_st_row) {
                            if ($conn_st_row['connections']['user_id'] == $uid && $conn_st_row['connections']['friend_id'] == $user_id) {
                                $request_status = $conn_st_row['connections']['request'];
                                $flag = true;
                            }
                            else if($conn_st_row['connections']['user_id'] == $user_id && $conn_st_row['connections']['friend_id'] == $uid) {
                                $request_status = $conn_st_row['connections']['request'];
                                $flag = true;
                            }
                        }
                        if($flag == true){
                            ?>
                    	<li>
							<?php 
							 if($request_status == 0){?>
                                <a class="connect">Approval Pending</a>
                          <?php }?>
                      </li>
                   <?php }?>
                    <span id="peopleDiv_<?php echo $user_id?>">
							<div id="networkwe_loader<?php echo $user_id?>" style="display:none; text-align:center;">
							<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
							</div>
                                <?php if($flag == false) {?>
                                <li>
								 <a href="#" class="connect" data-toggle="modal" data-target="#requestdiv<?php echo $user_id;?>">Connect</a>
                                </li>
                                <?php }?>
					   </span>
				</ul>
			</div>
        <div class="clear"></div>
        </div>
        
        <!--- Connection Popup Starts Here --->
		<div class="modal fade middlepopup" id="requestdiv<?php echo $user_id;?>" tabindex="-1" role="dialog" aria-labelledby="connectdiv" aria-hidden="true">
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
                        
                    <?php if ($user_you_know_row['users_profiles']['photo']) {
                            if (file_exists(MEDIA_PATH.'/files/user/original/'.$user_you_know_row['users_profiles']['photo'])) {
                                echo $this->Html->image(MEDIA_URL.'/files/user/original/'.$user_you_know_row['users_profiles']['photo'],
                                                                                                               array('alt'=>'post-image'));
                            }
                            else {
                                echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'post-img'));
                                }
                        }
                        else {
                             echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'post-img'));
                        }?> 
                        
                    </div>
                    <div class="popup-listing-rgt">
                      <ul>
                        <li>
                          <h1><?php echo $full_name;?></h1>
                        </li>
                        <li><?php echo $user_you_know_row['users_profiles']['tags'];?></li>
                      </ul>
                    </div>
                    <div class="clear"></div>
                  </div>
                     <div class="popup-checkbox">
                     Connect as: 
			    <input name="connection_type" id="known_professional<?php echo $user_id;?>" type="radio" value="Professional" checked="checked"/> <label> Professional</label>	
                            <input name="connection_type" id="known_friend<?php echo $user_id;?>" type="radio" value="Friend"/><label> Friend</label>
                            <input name="connection_type" id="known_both<?php echo $user_id;?>" type="radio" value="Both" /><label>  Both</label>
                        </div>
                        <span class="redcolor" id="connection_error"></span>
              </div>
              <div class="modal-footer">
                <button type="button" id="connect_btn" class="btn submitbttn" data-dismiss="modal" onclick="return add_ajax_known('<?php echo $uid?>','<?php echo $user_id?>');">Connect</button>
                <button type="button" class="btn canclebttn" data-dismiss="modal">Cancel</button>
              </div>
              </form>
            </div>
            
          </div>
     </div>
		<!--- Connection Popup Ends Here --->
        
        <?php }?>
    </div>
 <?php }?>  
<script>
function addConnection()
{
  document.getElementById("userConnection").submit();
} 
function add_ajax_known(user_id,friend_id){
$("#networkwe_loader"+friend_id).show();
	var connection_type = '';
	if (document.getElementById('known_friend'+friend_id).checked) {
  		connection_type = document.getElementById('known_friend'+friend_id).value;
	}
	else if (document.getElementById('known_professional'+friend_id).checked) {
		connection_type = document.getElementById('known_professional'+friend_id).value;
	}
	else if (document.getElementById('known_both'+friend_id).checked) {
		connection_type = document.getElementById('known_both'+friend_id).value;
	}
	if (connection_type == '') {
		connection_type = 'Friend';
	}
	$.ajax({
	url     : baseUrl+"/connections/add_connect_ajax",
	type    : "POST",
	cache   : false,
	data    : {user_id: user_id,friend_id:friend_id,connection_type:connection_type},
	success : function(data){
	//$("#peopleDiv_"+friend_id).html(data);
	$("#known_user_"+friend_id).slideUp('slow');
	},
	complete: function() {
	$("#networkwe_loader"+friend_id).hide();		
	},
	error : function(data) {
	$("#peopleDiv_"+friend_id).html(data);
	}
	});
}
</script>
