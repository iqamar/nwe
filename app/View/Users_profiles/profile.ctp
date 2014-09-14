<script type="text/javascript">
	$(document).ready(function() {
	$.noConflict();
	$("#birth_date").datepicker();
	});
</script>
<script type="text/javascript">
function updateProfile(uid){
var title = document.getElementById('title').value;



var first = document.getElementById('first').value;
var last = document.getElementById('last').value;
var tags = document.getElementById('tags').value;
var birth_date = document.getElementById('birth_date').value; //
//var email = document.getElementById('email').value;
var phone = document.getElementById('phone').value; //
var mobile = document.getElementById('mobile').value;
var country_id = document.getElementById('country_id').value;
var city = document.getElementById('city').value;
var address1 = document.getElementById('address1').value; //
var address2 = document.getElementById('address2').value;//
var fax = document.getElementById('fax').value;//
var pobox = document.getElementById('pobox').value;//
var industry_id = document.getElementById('industry_id').value;



if((title=='') || (title==' ')){
	alert("Title must be filled out");
	document.getElementById('title').focus();
	return false;
}

if((first=='') || (first==' ')){
	alert("First name must be filled out");
	document.getElementById('first').focus();
	return false;
}

if((last=='') || (last==' ')){
	alert("Last name must be filled out");
	document.getElementById('last').focus();
	return false;
}

if((tags=='') || (tags==' ')){
	alert("Job Title (Professional Headline) must be filled out");
	document.getElementById('tags').focus();
	return false;
}
if((mobile=='') || (mobile==' ')){
	alert("Mobile must be filled out");
	document.getElementById('mobile').focus();
	return false;
}

if((country_id=='') || (country_id==' ')){
	alert("Country must be filled out");
	document.getElementById('country_id').focus();
	return false;
}
if((city=='') || (city==' ')){
	alert("City must be filled out");
	document.getElementById('city').focus();
	return false;
}
if((industry_id=='') || (industry_id==' ')){
	alert("Industry must be filled out");
	document.getElementById('industry_id').focus();
	return false;
}

$.ajax({
              url     : baseUrl+"/users_profiles/updateprofile",
              type    : "POST",
              cache   : false,
              data    : {"cuserid": uid, "title":title, "first":first, "last":last, "tags":tags, "birth_date":birth_date, "phone":phone, "mobile":mobile, "country_id":country_id, "city":city, "address1":address1, "address2":address2, "fax":fax, "pobox":pobox, "industry_id":industry_id},
              success : function(data){
				alert("Your profile has been successfully updated.")
			  $("#span_"+field).html(data);
              },
			  error : function(data) {
           $("#span_"+field).html("there is error");
        }
          });

}

</script>


<?php echo $this->element('edit_profile_menus'); ?>

<div class="settings-content" style="float: left; width: 70%;">
<div class="boxed-group" style="min-height:35px;">
<h3>Basic Information<span style="float:right">
<?php echo $this->Html->link(__('View Profile'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'myprofile'),array('style'=>'font-weight:800;font-size:12px;text-decoration:none;')); ?>
</h3>
<div class="boxed-group-inner" style="min-height:300px;">

<?php 
$email = $this->Session->read('email');
foreach ($profilefields as $profiles) {
$firstname = $profiles['Users_profile']['firstname'];
$lastname = $profiles['Users_profile']['lastname'];
$cuser = $this->Session->read($userid);
$uid = $cuser['userid'];
//'.'"'.$firstname.'"'.'  for function value passing as a varialbe string.
?>
<?php echo $this->Form->input('user_id' , array('type' => 'hidden', 'value' => $cuser['userid'])) ?>
<?php echo $this->Form->input('password' , array('type' => 'hidden', 'value' => $profiles['Users_profile']['password'],'id'=>'confidential')) ?>


<dl class="form" ><dt style="float:left">The fields marked with <span id="span_hiring" style="color:#F00; font-size:15px;">*</span> are mandatory.</dt><dd style="float:right"><input type="button" value="Save" onclick="updateProfile('<?php echo $uid?>')"></dd></dl>
<dl class="form"><dt><label>Title <span id="span_hiring" style="color:#F00; font-size:15px;">*</span></label></dt><dd>
<select name="data[Users_profile][title]" name="title" id="title">
<?php 	if ('Mr' == $profiles['Users_profile']['title']){?>
		<option value="Mr" selected="selected">Mr</option>
    <?php } else {?>
    <option value="Mr">Mr</option>
<?php }?>
<?php 	if ('Mrs' == $profiles['Users_profile']['title']){?>
		<option value="Mrs" selected="selected">Mrs</option>
    <?php } else {?>
    <option value="Mrs">Mrs</option>
<?php }?>
<?php 	if ('Miss' == $profiles['Users_profile']['title']){?>
		<option value="Miss" selected="selected">Miss</option>
    <?php } else {?>
    <option value="Miss">Miss</option>
<?php }?>
<?php 	if ('Ms' == $profiles['Users_profile']['title']){?>
		<option value="Ms." selected="selected">Ms</option>
    <?php } else {?>
    <option value="Ms">Ms</option>
<?php }?>
</select>
</dd></dl>





<dl class="form"><dt><label>First Name <span id="span_hiring" style="color:#F00; font-size:15px;">*</span></label></dt><dd><?php echo $this->Form->text('firstname',array('required'=>false,'value'=>$profiles['Users_profile']['firstname'],'onChange'=>'autoSaveField('.$uid.',"first","firstname")','id'=>'first')); ?></dd></dl>

<dl class="form"><dt><label>Last Name <span id="span_hiring" style="color:#F00; font-size:15px;">*</span></label></dt><dd><?php echo $this->Form->text('lastname',array('required'=>false,'value'=>$profiles['Users_profile']['lastname'],'onChange'=>'autoSaveField('.$uid.',"last","lastname")','id'=>'last')); ?></dd></dl>

<dl class="form"><dt><label>Date of Birth</label></dt><dd><?php echo $this->Form->text('mobile',array('required'=>false,'value'=>$profiles['Users_profile']['birth_date'],'onChange'=>'autoSaveField('.$uid.',"birth_date","birth_date")','id'=>'birth_date')); ?></dd></dl>


<dl class="form"><dt><label>Nationality <span id="span_hiring" style="color:#F00; font-size:15px;">*</span></label></dt><dd>
<select name="data[Users_profile][nationality]" name="nationality" id="nationality">
<?php foreach ($countries as $countryRow) { 
		if ($countryRow['Country']['id'] == $profiles['Users_profile']['nationality']){?>
	<option value="<?php echo $countryRow['Country']['id']; ?>" selected="selected"><?php echo $countryRow['Country']['name']; ?></option>
    <?php } else {?>
    <option value="<?php echo $countryRow['Country']['id']; ?>"><?php echo $countryRow['Country']['name']; ?></option>
<?php }}?>
</select>
</dd></dl>

<dl class="form"><dt><label>Job Title (Professional Headline)  <span id="span_hiring" style="color:#F00; font-size:15px;">*</span></label></dt><dd><?php echo $this->Form->textarea('tags',array('required'=>false,'style'=>array('width:100%; height:30px; padding:6px;'), 'value'=>$profiles['Users_profile']['tags'],'id'=>'tags')) ?></dd></dl>

<dl class="form"><dt><label>Sector/ Industry <span id="span_hiring" style="color:#F00; font-size:15px;">*</span></label></dt><dd>
<select name="data[Users_profile][industry_id]" name="industry_id" id="industry_id">
<?php 
foreach ($industries as $industryRow) { 

		if ($industryRow['Industry']['id'] == $profiles['Users_profile']['industry_id']){?>
	<option value="<?php echo $industryRow['Industry']['id']; ?>" selected="selected"><?php echo $industryRow['Industry']['title']; ?></option>
    <?php } else {?>
    <option value="<?php echo $industryRow['Industry']['id']; ?>"><?php echo $industryRow['Industry']['title']; ?></option>
<?php }}?>
</select>
</dd></dl>

<!--
<dl class="form"><dt><label>Email <span id="span_hiring" style="color:#F00; font-size:15px;">*</span></label></dt><dd><?php echo $this->Form->email('email',array('value'=>$email,'onChange'=>'autoSaveField('.$uid.',"email","email")','id'=>'email')) ?></dd></dl>
-->
<dl class="form"><dt><label>Phone</label></dt><dd><?php echo $this->Form->text('phone',array('required'=>false,'value'=>$profiles['Users_profile']['phone'],'name'=>'phone','id'=>'phone')); ?></dd></dl>


<dl class="form"><dt><label>Mobile <span id="span_hiring" style="color:#F00; font-size:15px;">*</span></label></dt><dd><?php echo $this->Form->text('mobile',array('required'=>false,'value'=>$profiles['Users_profile']['mobile'],'name'=>'mobile','id'=>'mobile')); ?></dd></dl>


<dl class="form"><dt><label>Address1 </label></dt><dd><?php echo $this->Form->text('address1',array('required'=>true,'value'=>$profiles['Users_profile']['address1'],'name'=>'address1','id'=>'address1')) ?></dd></dl>

<dl class="form"><dt><label>Address2 </label></dt><dd><?php echo $this->Form->text('address2',array('required'=>false,'value'=>$profiles['Users_profile']['address2'],'name'=>'address2','id'=>'address2')) ?></dd></dl>


<dl class="form"><dt><label>Fax </label></dt><dd><?php echo $this->Form->text('fax',array('required'=>false,'value'=>$profiles['Users_profile']['fax'],'id'=>'fax','id'=>'fax')) ?></dd></dl>
<dl class="form"><dt><label>P.O.Box </label></dt><dd><?php echo $this->Form->text('pobox',array('required'=>false,'value'=>$profiles['Users_profile']['zip'],'id'=>'pobox','id'=>'pobox')) ?></dd></dl>

<dl class="form"><dt><label>City  <span id="span_hiring" style="color:#F00; font-size:15px;">*</span></label></dt><dd><?php echo $this->Form->text('city',array('required'=>false,'value'=>$profiles['Users_profile']['city'],'name'=>'city','id'=>'city')) ?></dd></dl>

<dl class="form"><dt><label>Country <span id="span_hiring" style="color:#F00; font-size:15px;">*</span></label></dt><dd>
<select name="data[Users_profile][country_id]" name="country_id" id="country_id">
<?php foreach ($countries as $countryRow) { 
		if ($countryRow['Country']['id'] == $profiles['Users_profile']['country_id']){?>
	<option value="<?php echo $countryRow['Country']['id']; ?>" selected="selected"><?php echo $countryRow['Country']['name']; ?></option>
    <?php } else {?>
    <option value="<?php echo $countryRow['Country']['id']; ?>"><?php echo $countryRow['Country']['name']; ?></option>
<?php }}?>
</select>
</dd></dl>






<dl class="form" style="float:right"><dd><input type="button" value="Save" onclick="updateProfile('<?php echo $uid?>')"></dd></dl>

</div>
</div>
<?php }?>

</div>
