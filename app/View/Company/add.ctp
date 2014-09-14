<script>
function showAdminUser(company_id,user_id) {
var admins_title = document.getElementById('admin_title').value;
var len = admins_title.length;
if (len >=3) {
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
function resetForm() {
	document.forms["addCompany"].reset();	
}

function validateForm() {
	var title_company = document.getElementById('title_company').value;
	var logo = document.getElementById('logo').value;
	var company_type_id = document.getElementById('company_type_id').value;
	var description = document.getElementById('description').value;
	var cover_image = document.getElementById('image').value;
	var logo_id = document.getElementById('logo_id').value;
	var url = document.getElementById('url').value;
		if (url) {
			if(url.match(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/)){
			}
			else {
				$("#error_url").html("Enter a valid url");
				$("#url").focus();
				$('html,body').animate({scrollTop: 400},600);
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
	
	if (title_company == '') {
		$("#error_company_title").html("Enter the Company name");
		$("#title_company").focus();
		 $('html,body').animate({scrollTop: 0},600);
		return false;
	}
	else if (logo == '' && logo_id == '') {
		$("#error_logo").html("Select Company logo");
		$("#logo").focus();
		$('html,body').animate({scrollTop: 200},600);
		return false;
	}
	else if (description == '') {
		$("#error_description").html("Enter Company description");
		$("#description").focus();
		$('html,body').animate({scrollTop: 200},600);
		return false;
	}
	else if (company_type_id == 0 || company_type_id == '') {
		$("#error_company_type_id").html("Select Company type");
		$("#company_type_id").focus();
		$('html,body').animate({scrollTop: 300},600);
		return false;
	}
	else {
	return true;	
	}
	
}
function fieldVlidate(id)
		{
		
			var value_field = document.getElementById(id).value;
			var id_len = value_field.length;
			if (id_len == 0)
			{
				$("#error_"+id).html("Enter your name!");
				id.focus();
				return false;
			}
			else {
				$("#error_"+id).html("");
				return true;
			}
   }
   
$( document ).ready(function() {
  //$("#success_mesg_hide").slideDown('slow').delay(300).fadeOut();
});
</script>


<div class="box">
	<div class="tab-container" id="tab-container" data-easytabs="true">
		<ul class="etabs">
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/page/" >Company Page</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/">Following</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/search/">Search Company</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/home/">Companies Updates</a></li>
			<li class="tab active"><a href="#" class="active">Add Company</a></li>
		</ul>
		<div class="panel-container">
			<div id="tabs1" style="display: block;" class="active"> 
			<?php if ( $this->Session->flash('add_error')) {
					echo $this->Session->flash('add_error'); 
				}
				?>
<?php foreach ($Update_Company_Detail as $company_detail_row) {
	$size = $company_detail_row['companies']['company_size'];
	$user_id = $company_detail_row['companies']['user_id'];
	?>
	
		
		<form class="tabform" method="post" id="addCompany" name="addCompany" onsubmit="return validateForm();" enctype="multipart/form-data" id="addCompany" action="/companies/add/">
		<fieldset>
		<label><h1>Company Name<span class="redcolor">*</span></h1></label>
		<label>
		<input type="text" name="data[Company][title]" id="title_company" value="<?php echo $company_detail_row['companies']['title'];?>" maxlength="100" placeholder=" Maximum 100 characters only" />
             <span id="error_company_title" style="color:#B00;"></span>
             <input type="hidden" name="data[Company][companyid]" id="company_id" value="<?php echo $companyid; ?>" />
		</label>
        					
		<label><h1>Cover Image</h1></label>	
        <span id="error_image" style="color:#B00;"></span>	
		<label>
      		 <input type="file" name="data[Company][image]" id="image" />
             <div class="old_image">
			 <?php if ($company_detail_row['companies']['image']) {
						echo $this->Html->image(MEDIA_URL."/files/company/cover/".$company_detail_row['companies']['image'],array('alt'=>'no image','style'=>'width:653px; height:237px;'));
					}?>
			</div>
		</label>	
		<label><h1>Company Logo<span class="redcolor">*</span></h1></label>
        <span id="error_logo" style="color:#B00;"></span>
        <label>
      		 <input type="file" name="data[Company][logo]" id="logo" />
             <input type="hidden"  id="logo_id" value="<?php echo $company_detail_row['companies']['logo']; ?>" />
             <div class="old_image">
			 <?php if ($company_detail_row['companies']['logo']) {
						echo $this->Html->image(MEDIA_URL."/files/company/logo/".$company_detail_row['companies']['logo'],array('alt'=>'no image'));
					}?>
			</div>
		</label>
		<label><h1>Company Description<span class="redcolor">*</span></h1></label>
        <span id="error_description" style="color:#B00;"></span>
		<label>
            <textarea id="description" type="text" name="data[Company][description]"><?php echo $company_detail_row['companies']['description'];?></textarea>
             
         </label>    	
            
	<label><h1>Company Type<span class="redcolor">*</span></h1></label>	
   	 <span id="error_company_type_id" style="color:#B00;"></span>	
		<label>
            	
            	
            		<select id="company_type_id" name="data[Company][company_type_id]">
                    	<option value="0" selected="selected">Select Company Type</option>
                    	<?php foreach ($company__Types as $comp_type_Row) {
							if ($comp_type_Row['companies_types']['id'] == $company_detail_row['companies']['company_type_id']) {
							?>
                        <option value="<?php echo $comp_type_Row['companies_types']['id'];?>" selected="selected"><?php echo $comp_type_Row['companies_types']['title'];?></option> 
                            <?php } else {?>
                        <option value="<?php echo $comp_type_Row['companies_types']['id'];?>"><?php echo $comp_type_Row['companies_types']['title'];?></option>
                        <?php }}?>
                    </select> 
                    
           </label>         
                    
         <label><h1>Company Size</h1></label>		
		 <label>       	         
               
            		<select id="company_size" name="data[Company][company_size]">
                    	<option <?php if ($size == '2-10') echo 'selected=selected';?> value="2-10" >2-10</option>
                        <option <?php if ($size == '11-50') echo 'selected=selected';?> value="11-50">11-50</option>
                        <option <?php if ($size == '51-200') echo 'selected=selected';?> value="51-200">51-200</option>
                        <option <?php if ($size == '200-500') echo 'selected=selected';?> value="200-500">200-500</option>
                        <option <?php if ($size == '500-1000') echo 'selected=selected';?> value="500-1000">500-1000</option>
                        <option <?php if ($size == '1000-5000') echo 'selected=selected';?> value="1000-5000">1000-5000</option>
                        <option <?php if ($size == '5000+') echo 'selected=selected';?> value="5000+">5000+</option>
                    </select> <br />
            </label>   
         <label><h1>Company Url</h1></label>
         <span id="error_url" style="color:#B00;"></span>		
		 <label>                    
            		<input type="text" name="data[Company][weburl]" id="url" value="<?php echo $company_detail_row['companies']['weburl'];?>" />
                    </label>
                   <label> 
                  <label>Company Industry</label>
            		<select id="company_type_id" name="data[Company][industry_id]">
                    	<?php foreach ($company__OF_Indus as $comp_Indus_Row) {
							if ($comp_Indus_Row['industries']['id'] == $company_detail_row['companies']['industry_id']) {
							?>
                        <option value="<?php echo $comp_Indus_Row['industries']['id'];?>" selected="selected"><?php echo $comp_Indus_Row['industries']['title'];?></option>
                            <?php } else {?>
                        <option value="<?php echo $comp_Indus_Row['industries']['id'];?>"><?php echo $comp_Indus_Row['industries']['title'];?></option>
                        <?php }}?>
                    </select>
           </label>
          <label><h1>Company Operating Status</h1></label>		
		 <label>
                    
            		<select id="company_operating_status" name="data[Company][company_operating_status]">
                    	<?php foreach ($company_Operating_status as $comp_operating_Row) {
							if ($comp_operating_Row['company_operating_statuses']['id'] == $company_detail_row['companies']['company_operating_status']) {
							?>
					<option value="<?php echo $comp_operating_Row['company_operating_statuses']['id'];?>" selected="selected"><?php echo $comp_operating_Row['company_operating_statuses']['operating_status'];?></option>
                            <?php } else {?>
      				<option value="<?php echo $comp_operating_Row['company_operating_statuses']['id'];?>"><?php echo $comp_operating_Row['company_operating_statuses']['operating_status'];?></option>
                        <?php }}?>
                    </select>
             </label>
           <label><h1>Year Founded</h1></label>		
		 <label>                    
            		<input type="text" name="data[Company][established]" value="<?php echo $company_detail_row['companies']['established'];?>" />
          </label>
         <label><h1>Address</h1></label>		
		 <label>                 
                    <input type="text" name="data[Company][address]" id="address" value="<?php echo $company_detail_row['companies']['address'];?>" />
           </label>
           <label><h1>City</h1></label>
           <label>
            		<input type="text" name="data[Company][city]" value="<?php echo $company_detail_row['companies']['city'];?>" />
           </label>
           <label><h1>State/Province</h1></label>		
		 <label>
                     
            		<input type="text" name="data[Company][state]" value="<?php echo $company_detail_row['companies']['state'];?>" />
           </label>  
           <label><h1>Country</h1></label>		
		 <label>       
                  
            		<select id="company_type_id" name="data[Company][country_id]">
                    	<?php foreach ($company_countries as $comp_coun_Row) {
							if ($comp_coun_Row['countries']['id'] == $company_detail_row['companies']['country_id']) {
							?>
                            <option value="<?php echo $comp_coun_Row['countries']['id'];?>" selected="selected"><?php echo $comp_coun_Row['countries']['name'];?></option>
                            <?php } else {?>
                        <option value="<?php echo $comp_coun_Row['countries']['id'];?>"><?php echo $comp_coun_Row['countries']['name'];?></option>
                        <?php }}?>
                    </select>
           </label>
           
		 <label>
                    <textarea name="data[Company][address2]" id="address2"  placeholder="address2"><?php echo $company_detail_row['companies']['address2'];?></textarea>
              </label>
              
		 <label>
                    <textarea name="data[Company][address3]" id="address3" placeholder="address3"><?php echo $company_detail_row['companies']['address3'];?></textarea>
                    
           	</label>	
            
            <input type="submit" value="Publish" class="submitbttn" />
             <input type="submit" class="canclebttn" value="Cancel" onclick="resetForm();" />
             </fieldset>
       
</form>
<?php }?>
</div>
</div>
</div>
</div>
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
