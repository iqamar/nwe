<?php if ($set_flash_success == 'yes' || $set_flash_error == 'yes') {?>
<script>
  //$("#messge_hide").slideDown('slow').delay(300).fadeOut();
  alert("tes");
  $("#messge_hide").show();
setTimeout(function() { $("#messge_hide").hide(); }, 300);
</script>
<?php }?>
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
				<div class="boxheading">
					<h1>Company Page</h1>
					<div class="boxheading-arrow"></div>
                    
				</div>
                <span id="messge_hide"><?php echo $this->Session->flash('company_valid');?></span>
				<form class="tabform" method="post" name="chckCompany" onsubmit="return validateForm();" id="chckCompany" action="/companies/validity/">
				<fieldset>
					<label><h1>Company Name</h1></label>
					<label>
						 <input type="text" name="data[Company][title]" id="title_company" value="" />
						<span id="company_title" style="color:#B00;"></span> <br />
					</label>
					<label>
					<h1>Company Email ID</h1>
					</label> 
					<label>
						 <input type="email" name="data[Company][primary_email]" id="primary_email" value="" />
						 <span id="company_email" style="color:#B00;"></span>
					</label>  
				
				<input type="submit" value="Next" class="submitbttn">				
          
				</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
   		
        
    <script type="text/javascript">
function validateForm() {
	var company_title = document.getElementById('title_company').value;
	var primary_email = document.getElementById('primary_email').value;
	if (company_title == '') {
		$("#company_title").html("Enter the company name");
		$("#title_company").focus();
		return false;
	}
	else if (primary_email == '') {
		$("#company_email").html("Enter email at company");
		$("#primary_email").focus();
		return false;
	}
	else {
	return true;	
	}
	
}
</script>
