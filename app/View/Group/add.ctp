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

	
function validateForm() {
	var group_title = document.getElementById('title_group').value;
	var summary = document.getElementById('summary').value;
	var description = document.getElementById('description').value;
	var logo = document.getElementById('logo').value;
	var company_type_id = document.getElementById('company_type_id').value;
	var cover_image = document.getElementById('image').value;
	var group_id = document.getElementById('group_id').value;
	var url = document.getElementById('url').value;
		if (url) {
			if(url.match(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/)){
			}
			else {
				$("#error_url").html("Enter a valid url");
				$("#url").focus();
				$('html,body').animate({scrollTop: 300},600);
				return false;
			}
		}
	    
		if (logo) {
			var FileName  = logo;
			var FileExt = FileName.substr(FileName.lastIndexOf('.')+1);
			var FileExt = FileExt.toLowerCase();
			if (FileExt != "png" && FileExt != "jpg" && FileExt != "gif" && FileExt != "jpeg")
			{
				$("#error_logo").html("Unacceptable file type");
				$("#logo").focus();
				$('html,body').animate({scrollTop: 200},600);
				return false;
			}
			else {
				$("#error_logo").html("");
			}
		}
		if (cover_image) {
			var cover_image  = cover_image;
			var CoverExt = cover_image.substr(cover_image.lastIndexOf('.')+1);
			var CoverExt = CoverExt.toLowerCase();
			if (CoverExt != "png" && CoverExt != "jpg" && CoverExt != "gif" && CoverExt != "jpeg" && CoverExt != "")
			{
				$("#error_image").html("Unacceptable file type");
				$("#image").focus();
				$('html,body').animate({scrollTop: 200},600);
				return false;
			}
			else {
				$("#error_image").html("");
			}
			
		}
	if (group_title == 'Maximum 100 characters only' || group_title == '') {
		$("#error_title_group").html("Enter the group name");
		$("#title_group").focus();
		 $('html,body').animate({scrollTop: 0},600);
		return false;
	}
	else if (logo == '' && group_id == '') {
		$("#error_logo").html("Select group logo");
		$("#logo").focus();
		$('html,body').animate({scrollTop: 200},600);
		return false;
	}
	else if (summary == '') {
		$("#error_summary").html("Enter summary for group");
		$("#summary").focus();
		$('html,body').animate({scrollTop: 260},600);
		return false;
	}
	else if (description == '') {
		$("#error_description").html("Enter Discription for group");
		$("#description").focus();
		$('html,body').animate({scrollTop: 260},650);
		return false;
	}
	else if (company_type_id == 0) {
		$("#error_company_type_id").html("Select group type");
		$("#company_type_id").focus();
		$('html,body').animate({scrollTop: 500},600);
		return false;
	}
	else {
	return true;	
	}
	
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
	
<div class="box">
	<div class="tab-container" id="tab-container" data-easytabs="true">
		<ul class="etabs">
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/lists/" >Your Groups</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/" >Following</a></li>	
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/groups/search">Search Group</a></li>
			<li class="tab active"><a href="#" class="active">Add Group</a></li>
		</ul>
		<div class="panel-container">
			<div id="tabs1" style="display: block;" class="active">  
				<?php echo $this->Session->flash();?>
<form method="post" class="tabform" name="addGroup" onsubmit="return validateForm();" enctype="multipart/form-data" id="addGroup" action="/groups/add/">
    <fieldset>
		<label><h1>Group name<span class="redcolor">*</span></h1></h1></label>
		<label>
    
    
   			 
      		 <input type="text" name="data[Group][title]" id="title_group" value="<?php echo $title;?>" onblur="fieldVlidate('title_group');" maxlength="100" placeholder="Maximum 100 characters only" />
             <span id="error_title_group" style="color:#B00;"></span>
             <input type="hidden" name="data[Group][groupid]" id="group_id" value="<?php echo $groupid; ?>" />
             </label>
             
             
                <label><h1>Cover Photo</h1></label>
                <label>
      		 <input type="file" name="data[Group][image]" id="image" class="image_field" onblur="fieldVlidate('image');" />
             <span id="error_image" style="color:#B00;"></span>
             <div class="old_image" id="old_image" style="margin-top:10px;">
			 <?php if ($group_detail_row['groups']['image']) {
						echo $this->Html->image(MEDIA_URL."/files/group/cover/".$image,array('alt'=>'no image','style'=>'width:653px; height:237px;'));
					}?>
			</div>
			</label>
             <label><h1>Group logo<span class="redcolor">*</span></h1></h1></label>
             <label>
      		 <input type="file" name="data[Group][logo]" id="logo" class="image_field" onblur="fieldVlidate('logo');" />
             <span id="error_logo" style="color:#B00;"></span>
             <div class="old_image" id="old_logo" style="margin-top:10px;">
			 <?php if ($group_detail_row['groups']['logo']) {
						echo $this->Html->image(MEDIA_URL."/files/group/logo/".$logo,array('alt'=>'no image','style'=>'width:75px; height:75px;'));
					}?>
			</div>
			
			</label>
             <label><h1>Summary<span class="redcolor">*</span></h1></h1></label>
 <textarea type="text" name="data[Group][summary]" id="summary"  onblur="fieldVlidate('summary');"><?php echo $summary;?></textarea>
            <span id="error_summary" style="color:#B00;"></span>
       		
       		<label><h1>Description<span class="redcolor">*</span></h1></h1></label>
             <span id="error_description" style="color:#B00;"></span>
       		<label>
            <textarea type="text" id="description" name="data[Group][description]" onblur="fieldVlidate('description');"><?php echo $description;?></textarea>
            </label>
             
             
             
             
             
             
             <label><h1>Pre-approve memebers</h1></label>
             
             <!--
                <input type="text" id="admin_title" value="" style="border:1px solid #999;" placeholder="type a name for member" />
                 
                <div id="result_user">
                	
                </div>
                -->
             	<ul>
                	<div id="delete_message" style="display:none; padding:10px; background:#FFFFD9; color:#333; margin-bottom:5px;"></div>
                     <div id="loadings" style="position:absolute; z-index:100px; left:50%; top:50%; text-align:center; display:none;"> 
                        	<?php echo $this->Html->image('loading.gif');?>	
                        </div>
                	<?php if ($user_profile) {?>
             		<li class="feed-item">
                    	<?php if ($user_profile['photo'])
						echo $this->Html->image(MEDIA_URL."/files/user/original/".$user_profile['photo'],array('alt'=>'no image','style'=>'float:left;width:40px;height:40px;'));
						else
                    	 echo $this->Html->image(MEDIA_URL.'/files/user/original/no-image.png',array('alt'=>'no image','style'=>'float:left;width:40px;height:40px;'));?>
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
						echo $this->Html->image(MEDIA_URL."/files/user/original/".$user_admin_Row['users_profiles']['photo'],array('alt'=>'no image','style'=>'float:left;width:40px;height:40px;'));
						else
                    	 echo $this->Html->image(MEDIA_URL.'/files/user/original/no-image.png',array('alt'=>'no image','style'=>'float:left;width:40px;height:40px;'));?>
                        <div class="vcard">
                        <strong><?php echo $user_admin_Row['users_profiles']['firstname']." ".$user_admin_Row['users_profiles']['lastname'];?></strong>
                        <p><?php echo $user_admin_Row['users_profiles']['tags'];?></p>
                        <span style="float:right;" class="remove_icon">
						<?php echo $this->Html->image('simple_close_icon.png',array('onClick'=>'closeAdmin('.$admin_ID.')'),array('style'=>'width:20px; height:21px;')); ?></span>
                        </div>
                        
                    </li>
                    <?php }}}?>
                    
             <br/><br/>
             
          
       
	
        
            	<label><h1>Group Type<span class="redcolor">*</span></h1></h1></label>
            	<label>
            		<select id="company_type_id" name="data[Group][group_type_id]" onblur="fieldVlidate('company_type_id');">
                    	<option value="0" selected="selected">Select Group Type</option>
                    	<?php foreach ($group__Types as $comp_type_Row) {
								if ($comp_type_Row['groups_types']['id'] == $group_type_id) { 
							?>
                        <option value="<?php echo $comp_type_Row['groups_types']['id'];?>" selected="selected"><?php echo $comp_type_Row['groups_types']['title'];?></option> 
                            <?php } else {?>
                        <option value="<?php echo $comp_type_Row['groups_types']['id'];?>"><?php echo $comp_type_Row['groups_types']['title'];?></option>
                        	<?php }}?>
                    </select> 
                    <span id="error_company_type_id" style="color:#B00;"></span>
                 </label> 
                 <label><h1>Group Website url</h1></label>
                 <label>
            		<input type="text" name="data[Group][weburl]" id="url" value="<?php echo $weburl;?>" />
                    <span id="error_url" style="color:#B00;"></span>
               </label>
                  <label><h1>Joining mode</h1></label>
                  <label>
            		<select id="joining_mode" name="data[Group][joining_mode]">>
                        <option value="Request to join" <?php if ($joining_mode=='Request to join') echo 'selected=selected';?>>Request to join</option>
                        <option value="Auto-Join" <?php if ($joining_mode=='Auto-Join') echo 'selected=selected';?>>Auto join</option>
                    </select>
                   </label>
  					 <label><h1>Group mode</h1></label>
  					 <label>
            		<select id="group_mode" name="data[Group][group_mode]">>
                        <option value="Open" <?php if ($group_mode=='Open') echo 'selected=selected';?>>Open</option>
                        <option value="Members Only" <?php if ($group_mode=='Members Only') echo 'selected=selected';?>>Members Only</option>
                    </select>
                   </label>
                    
                    <label><h1>Country</h1></label>
                    <label>
            		<select id="company_type_id" name="data[Group][country_id]">
                    	<option value="0" selected="selected">Select Country</option>
                    	<?php foreach ($group_countries as $comp_coun_Row) {
							if ($comp_coun_Row['Country']['id'] == $country_id) {
							?>
                            <option value="<?php echo $comp_coun_Row['Country']['id'];?>" selected="selected"><?php echo $comp_coun_Row['Country']['name'];?></option>
                            <?php } else {?>
                        <option value="<?php echo $comp_coun_Row['Country']['id'];?>"><?php echo $comp_coun_Row['Country']['name'];?></option>
                        <?php }}?>
                    </select>
                    </label>
                    
           		 
            
            <input type="submit" value="Publish" class="submitbttn" />
             <input type="submit" class="canclebttn" value="Cancel" onclick="resetForm();" />
             </fieldset>
       
</form>
 </div> </div> </div> </div>
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
	function resetForm() {
	document.forms["addGroup"].reset();	
	}
	function fieldVlidate(id)
		{
		
			var value_field = document.getElementById(id).value;
			var id_len = value_field.length;
			if (id_len == 0)
			{
				$("#error_"+id).html("Enter your required field!");
				id.focus();
				return false;
			}
			else {
				$("#error_"+id).html("");
				return true;
			}
       }
	
</script>
