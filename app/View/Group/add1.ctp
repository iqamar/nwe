<script>
function showAdminUser(company_id,user_id) {
var admins_title = document.getElementById('admin_title').value;
$.ajax({
              url     : baseUrl+"/companies/search_users",
              type    : "GET",
              cache   : false,
              data    : {admins_title: admins_title,company_id:company_id,user_id:user_id},
              success : function(data){
				  if (admins_title !='') {
			  $("#result_user").html(data);
				  }
				  else {
					$("#result_user").html("");  
				  }
              },
			  error : function(data) {
           $("#result_user").html("there is error");
        }
          });
		  
}
function closeAdmin(company_user_id) {
	$('#loadings').show();
$.ajax({
              url     : baseUrl+"/companies/delete_admin",
              type    : "GET",
              cache   : false,
              data    : {company_user_id: company_user_id},
              success : function(data){
			  $("#response_Div"+company_user_id).slideUp('slow');
			   $("#delete_message").slideDown('slow');
			  $("#delete_message").html(data);

              },
			   complete: function () {
       $('#loadings').hide();
                },
			  error : function(data) {
           $("#delete_message").html("there is error");
        }
          });
		  
}
</script>

<?php foreach ($Update_Group_Detail as $group_detail_row) {
	$user_id = $group_detail_row['groups']['user_id'];
	$title = $group_detail_row['groups']['title'];
	$weburl = $group_detail_row['groups']['weburl'];
	$group_type_id = $group_detail_row['groups']['group_type_id'];
	$country_id = $group_detail_row['groups']['country_id'];
	$summary = $group_detail_row['groups']['summary'];
	$description = $group_detail_row['groups']['description'];
	$image = $group_detail_row['groups']['image'];
	$logo = $group_detail_row['groups']['logo'];
	$joining_mode = $group_detail_row['groups']['joining_mode'];
	$group_mode = $group_detail_row['groups']['group_mode'];
	
}
	?>
<form method="post" name="addGroup" onsubmit="return validateForm();" enctype="multipart/form-data" id="addGroup" action="/groups/add/">
    	<div class="com_right" style="width:67%; margin-right:10px;">
        <div class="ttle-bar effectX">Group</div>
   		 <div class="fieldgroup">
   			 <label>Group name</label>
      		 <input type="text" name="data[Group][title]" id="title_group" value="<?php echo $title;?>" />
             <span id="title_group" style="color:#B00;"></span>
             <input type="hidden" name="data[Group][groupid]" value="<?php echo $groupid; ?>" />
             
             <label>Summary</label>
 <textarea type="text" name="data[Group][summary]" id="summary" rows="6" cols="60" style="width:100%; height:130px;"><?php echo $summary;?></textarea>
            <span id="summary" style="color:#B00;"></span>
       		<label>Description</label>
            <textarea type="text" name="data[Group][description]" rows="6" cols="60" style="width:100%; height:170px;"><?php echo $description;?></textarea>
             
             <fieldset style="position:relative;">
             	<legend>Pre-approve Members</legend>
                <input type="text" id="admin_title" value="" style="border:1px solid #999;" placeholder="type a name for member" />
                <div id="result_user">
                	
                </div>
             	<ul>
                	<div id="delete_message" style="display:none; padding:10px; background:#FFFFD9; color:#333; margin-bottom:5px;"></div>
                     <div id="loadings" style="position:absolute; z-index:100px; left:50%; top:50%; text-align:center; display:none;"> 
                        	<?php echo $this->Html->image('loading.gif');?>	
                        </div>
                	<?php if ($user_profile) {?>
             		<li class="feed-item">
                    	<?php if ($user_profile['photo'])
						echo $this->Html->image("/files/users/".$user_profile['photo'],array('alt'=>'no image'));
						else
                    	 echo $this->Html->image('no-image.png',array('alt'=>'no image'));?>
                        <div class="vcard">
                        <strong><?php echo $user_profile['firstname']." ".$user_profile['lastname'];?></strong>
                        <p><?php echo $user_profile['tags'];?></p>
                        </div>
                    </li>
                    <?php }?>
                    <?php if ($admin_users_to_page) {?>
                    	<?php foreach ($admin_users_to_page as $user_admin_Row) { 
						if ($user_admin_Row['users_profiles']['user_id'] != $uid) {
							$admin_ID = $user_admin_Row['Company_user']['id'];
						?>
                        <li class="feed-item" id="response_Div<?php echo $admin_ID;?>">
                        <?php
							if ($user_admin_Row['users_profiles']['photo'])
						echo $this->Html->image("/files/users/".$user_admin_Row['users_profiles']['photo'],array('alt'=>'no image'));
						else
                    	 echo $this->Html->image('no-image.png',array('alt'=>'no image'));?>
                        <div class="vcard">
                        <strong><?php echo $user_admin_Row['users_profiles']['firstname']." ".$user_admin_Row['users_profiles']['lastname'];?></strong>
                        <p><?php echo $user_admin_Row['users_profiles']['tags'];?></p>
                        <span style="float:right;" class="remove_icon">
						<?php echo $this->Html->image('simple_close_icon.png',array('onClick'=>'closeAdmin('.$admin_ID.')'),array('style'=>'width:20px; height:21px;')); ?></span>
                        </div>
                        
                    </li>
                    <?php }}}?>
                    
             	</ul>
             </fieldset>
              <label>Cover Image</label>
      		 <input type="file" name="data[Group][image]" id="image" class="image_field" />
             <span id="image" style="color:#B00;"></span>
             <div class="old_image">
			 <?php if ($group_detail_row['groups']['image']) {
						echo $this->Html->image("/files/groups_logo/".$image,array('alt'=>'no image','style'=>'width:724px; height:230px;'));
					}?>
			</div>
             <label>Group logo</label>
      		 <input type="file" name="data[Group][logo]" id="logo" class="image_field" />
             <span id="logo" style="color:#B00;"></span>
             <div class="old_image">
			 <?php if ($group_detail_row['groups']['logo']) {
						echo $this->Html->image("/files/groups_logo/".$logo,array('alt'=>'no image','style'=>'width:75px; height:75px;'));
					}?>
			</div>
       </div>
       </div>
	<div id="extra" class="com_right" style="width:32%;">
        <div class="ttle-bar effectX">Group Detail</div>
        	<fieldset>
            	<label>Group Type</label>
            	<div class="fieldgroup">
            		<select id="company_type_id" name="data[Group][group_type_id]">
                    	<?php foreach ($group__Types as $comp_type_Row) {
								if ($comp_type_Row['groups_types']['id'] == $group_type_id) { 
							?>
                        <option value="<?php echo $comp_type_Row['groups_types']['id'];?>" selected="selected"><?php echo $comp_type_Row['groups_types']['title'];?></option> 
                            <?php } else {?>
                        <option value="<?php echo $comp_type_Row['groups_types']['id'];?>"><?php echo $comp_type_Row['groups_types']['title'];?></option>
                        	<?php }}?>
                    </select> 
                    <span id="company_type_id" style="color:#B00;"></span>
                    <br />
                 <label>Group Website url</label>
            		<input type="text" name="data[Group][weburl]" value="<?php echo $weburl;?>" />
                   <br />
                  <label>Joining mode</label>
            		<select id="joining_mode" name="data[Group][joining_mode]">>
                        <option value="Request to join" <?php if ($joining_mode=='Request to join') echo 'selected=selected';?>>Request to join</option>
                        <option value="Auto-Join" <?php if ($joining_mode=='Auto-Join') echo 'selected=selected';?>>Auto join</option>
                    </select>
                    <br />
  					 <label>Group mode</label>
            		<select id="group_mode" name="data[Group][group_mode]">>
                        <option value="Open" <?php if ($group_mode=='Open') echo 'selected=selected';?>>Open</option>
                        <option value="Members Only" <?php if ($group_mode=='Members Only') echo 'selected=selected';?>>Members Only</option>
                    </select>
                    <br />
                    
                    <label>Country</label>
            		<select id="company_type_id" name="data[Group][country_id]">
                    	<?php foreach ($group_countries as $comp_coun_Row) {
							if ($comp_coun_Row['Country']['id'] == $country_id) {
							?>
                            <option value="<?php echo $comp_coun_Row['Country']['id'];?>" selected="selected"><?php echo $comp_coun_Row['Country']['name'];?></option>
                            <?php } else {?>
                        <option value="<?php echo $comp_coun_Row['Country']['id'];?>"><?php echo $comp_coun_Row['Country']['name'];?></option>
                        <?php }}?>
                    </select>
                    
                    
           		 </div>
            
            <input type="submit" value="Publish" class="pub_btn" />
             <input type="submit" value="Cancel" class="pub_btn" />
             </fieldset>
        </div>
</form>

<style type="text/css">
#addCompany label.error {
    color: #FB3A3A;
    display: inline-block;
    margin: 4px 0 5px 125px;
    padding: 0;
    text-align: left;
    width: 220px;
}
</style>
    <script type="text/javascript">
function validateForm() {
	var group_title = document.getElementById('title_group').value;
	var summary = document.getElementById('summary').value;
	var image = document.getElementById('image').value;
	var logo = document.getElementById('logo').value;
	var company_type_id = document.getElementById('company_type_id').value;
	if (group_title == '') {
		$("#title_group").html("Enter the group name");
		$("#title_group").focus();
		return false;
	}
	else if (summary == '') {
		$("#summary").html("Enter summary for group");
		$("#summary").focus();
		return false;
	}
/*		else if (image == '') {
		$("#image").html("Select Image");
		$("#image").focus();
		return false;
	}
		else if (logo == '') {
		$("#logo").html("Select group logo");
		$("#logo").focus();
		return false;
	}*/
	else if (company_type_id == '') {
		$("#company_type_id").html("Select group type");
		$("#company_type_id").focus();
		return false;
	}
	else {
	return true;	
	}
	
}
</script>