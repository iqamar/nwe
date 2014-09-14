 <div class="success_msg" id="message_connection" style="display:none;">Connection request sent successfully!</div>
 <div class="error_msg" id="error_connection" style="display:none;">Please select at least one user!</div>
 <div id="connection_loadings" style="text-align:center; display:none;">
 	<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif',array('style'=>''));?>	
 </div>
  <div class="profile-box" id="registered">
 <?php if ($users_registered != '') {?>
 	<div class="profile-box-heading">Connect with people you know on NetworkWE.</div>
    	<p>We found <?php echo sizeof($users_registered);?> people you know on NetworkWE when you added your address book. Select the people you'd like to connect to.</p>
        <form name="myform1">
        <div class="profile-connections">
        	<a href="javascript:void();" onclick="javascript:checkAll('myform1', true);">Check All</a>
         </div>
         <div class="profile-connections">
         	<a href="javascript:void();" onclick="javascript:checkAll('myform1', false);">UnCheck All</a>
         </div>
         <div class="clear"></div>
 		<?php foreach ($users_registered as $user_profile_row) {
			$user_id = $user_profile_row['Users_profile']['user_id'];
			$user_name = $user_profile_row['Users_profile']['firstname']." ".$user_profile_row['Users_profile']['lastname'];
			$tag = $user_profile_row['Users_profile']['tags'];
			$email = $user_profile_row['users']['email'];
			$photo = $user_profile_row['Users_profile']['photo'];
			if ($photo && file_exists(MEDIA_PATH.'/files/user/icon/'.$photo)) {
				$user_photo = MEDIA_URL.'/files/user/icon/'.$photo;
			}
			else {
				$user_photo = MEDIA_URL.'/img/nophoto.jpg';
			}
			?>
        	<div class="profile-connections">
            	<input type="checkbox" name="conttact" id="email<?php echo $user_id;?>" value="<?php echo $email;?>" style="float:left; margin:15px 5px 0px 0px;" />
            	<div class="profile-connections-pic">
                <a href="<?php echo $user_id;?>">
                	<?php echo $this->Html->image($user_photo,array('alt'=>'user_photo'));?>
                </a>
                </div>
                <div class="profile-connections-rgt" style="width:75%;">
                	<ul>
                    	<li><h1><?php echo $user_name;?></h1></li>
                        <li><?php if ($tag) { echo $tag; } else { echo $email; }?></li>
                    </ul>
                </div>
                
            </div>
        <?php }?>
        </form>
        <div class="clear"></div>
        <div class="margintop10">
            <a class="button rgt" id="addconnect" onclick="addConnection('<?php echo $uid;?>');">Add Connections</a>
            <div class="more lft" style="margin-left:10px; cursor:pointer;"><a onclick="skip();">Skip this step</a></div>
        </div>
        
<?php }
	else {
		echo '<h3>Non of your Contact is registered with NetworkWE.</h3>';
		?>
        <div class="margintop10">
            <div class="more lft" style="margin-left:10px; cursor:pointer;"><a onclick="skip();">Skip this step</a></div>
        </div>
	<?php }?>
	
	
 <div class="clear"></div>
</div>
<div class="profile-box" id="not_registered" style="display:none;">
 <?php if( isset($result) && count($result) > 0){ ?>
    <div class="profile-box-heading">Why not invite some people?</div>
    	<p>Stay in touch with your contacts we found when you added your address book. Invite them to NetworkWE so they can connect with you.</p>
        <form name="myform">
        <div class="profile-connections">
        	<a href="javascript:void();" onclick="javascript:checkAll('myform', true);">Check All</a>
         </div>
         <div class="profile-connections">
         	<a href="javascript:void();" onclick="javascript:checkAll('myform', false);">UnCheck All</a>
         </div>
         <div class="clear"></div>
	<?php $i=1; foreach($result as $key => $user_email){ ?>
    
    		<div class="profile-connections">
         		<input type="checkbox" id="network<?php echo $i;?>" name="network" value="<?php echo $user_email;?>" /> <?php echo $user_email;?>
    		</div>
    <?php }?>
    </form>
    <div class="clear"></div>
        <div class="margintop10 rgt">
            <a class="button" id="addnetwork" onclick="addtoNetworkwe('<?php echo $uid;?>');">Add to NetworkWE</a>
        </div>
    
<?php $i++;} 
	else {
		echo '<h3>You have no Contact in your Gmail Address Book.</h3>';
	}
?>
	<div class="clear"></div>
</div>
<script>
function checkAll(formname, checktoggle)
    {
        var checkboxes = new Array();
        checkboxes = document.forms[formname].getElementsByTagName('input');

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type === 'checkbox') {
                checkboxes[i].checked = checktoggle;
            }
        }
    }


function skip() {
	$("#registered").slideUp('slow');
	$("#not_registered").slideDown('slow');
	return true;
}

function addConnection(user_id) {
	var selected_emails = new Array();
	$("input:checkbox[name=conttact]:checked").each(function() {
       selected_emails.push($(this).val());
  	});
	$('#connection_loadings').show();
	$("html, body").animate({ scrollTop: 0 }, "slow");
	 if (selected_emails != '') {
		$.ajax({
		url     : baseUrl+"/contacts/connection_request",
		type    : "GET",
		cache   : false,
		data    : {user_id: user_id,selected_emails:selected_emails},
		success : function(data){	
		$('#connection_loadings').hide();
		$("#message_connection").slideDown('slow').delay(900).fadeOut();
		},
		error : function(data) {
		$("#registered").html(data);
		}
		});
	 }
  else {
	 $("#error_connection").slideDown('slow').delay(900).fadeOut(); 
	 return false;
  }
    
}

function addtoNetworkwe(user_id) {
	var selected_emails = new Array();
	$("input:checkbox[name=network]:checked").each(function() {
       selected_emails.push($(this).val());
  	});
	$('#connection_loadings').show();
	$("html, body").animate({ scrollTop: 0 }, "slow");
	if (selected_emails != '') {
		$.ajax({
		url     : baseUrl+"/contacts/networkwe_request",
		type    : "GET",
		cache   : false,
		data    : {user_id: user_id,selected_emails:selected_emails},
		success : function(data){	
		$('#connection_loadings').hide();
		$("#message_connection").slideDown('slow').delay(900).fadeOut();
		},
		error : function(data) {
		$("#registered").html(data);
		}
		});
	}
  else {
	  $('#connection_loadings').hide();
	 $("#error_connection").slideDown('slow').delay(900).fadeOut(); 
	 return false;
  }
}
</script>