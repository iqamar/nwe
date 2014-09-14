<script type="text/javascript">

function autoSave(field,uid){

var fieldVal = document.getElementById(field).value;

        alert(fieldVal);

	  	jQuery.post(baseUrl + "/users/profile", {field: fieldVal,userid:uid}, function(data) {

	    var res = jQuery.parseJSON(data);

		

	    jQuery('#autosavenotify').html(res.message);



	    if (res.result == 1)

		jQuery('#autosavenotify').css('color', 'green');

	    else

		jQuery('#autosavenotify').css('color', 'red');



	    jQuery('#autosavenotify').show();

	});

}

</script>

<script type="text/javascript">

	$(document).ready(function() {

	$.noConflict();

		$("#stdate").datepicker();

		$("#endate").datepicker();

	});

function disabledField() {

	if(document.getElementById('presents').checked)

{

	document.getElementById('endate').disabled = true;

	document.getElementById('endate').value = '';

} else { 

	document.getElementById('endate').disabled = false;

}

	

}

	</script>

<div class="left_p_user">

<ul class="menu accordion">

<li class="section">

<a href="/users/profile" class="section-head">NetworkWe</a>

</li>

</ul>

<ul class="expanded">

<li class="profile"><?php echo $this->Html->link(__('Profile'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'myprofile'),array('class'=>'selected')); ?></li>

<li class="profile"><?php echo $this->Html->link(__('Edit Profile'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'profile')); ?></li>

<li class="profile"><?php echo $this->Html->link(__('Profile Photo'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'userphoto')); ?></li>

<li class="password"><?php echo $this->Html->link(__('Change Password'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'account')); ?></li>

<li class="exp"><?php echo $this->Html->link(__('Experience'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'display')); ?></li>

<li class="skill"><?php echo $this->Html->link(__('Skills'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'showskills')); ?></li>

<li class="edu"><?php echo $this->Html->link(__('Qualification'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'useredu')); ?></li>

</ul>

</div>



<div class="settings-content">

<div class="boxed-group">

<h3>Edit Record</h3>

<div class="boxed-group-inner">

<?php echo $this->Form->create("Users_profile",array('controller' => 'users_profiles', 'action' => 'edit_exp'));?>

<?php

foreach ($exps as $user_Exp) {

?>

<?php $cuser = $this->Session->read($userid);?>

<?php echo $this->Form->input('user_id' , array('type' => 'hidden', 'value' => $cuser['userid'])) ?>

<?php echo $this->Form->input('exp_id' , array('type' => 'hidden', 'value' => $exp_id)) ?>

<dl class="form"><dt><label>Company</label></dt><dd>

<select name="data[Users_profile][company_id]">

<?php foreach ($company_List as $companyRow) { 

		if ($companyRow['Company']['id'] == $user_Exp['company_id']){?>

	<option value="<?php echo $companyRow['Company']['id']; ?>" selected="selected"><?php echo $companyRow['Company']['title']; ?></option>

    <?php } else {?>

    <option value="<?php echo $companyRow['Company']['id']; ?>"><?php echo $companyRow['Company']['title']; ?></option>

<?php }}?>

</select>

<span id="autosavenotify" style="color:#F00; font-size:15px; float:right; width:100px;"></span></dd></dl>

<dl class="form"><dt><label>Location </label></dt><dd><?php echo $this->Form->text('location',array('required'=>false,'value'=>$user_Exp['location'])) ?><span id="autosavenotify" style="color:#F00; font-size:15px; float:right; width:100px;"></span></dd></dl>

<dl class="form"><dt><label>Designation</label></dt><dd><?php echo $this->Form->text('designation',array('value'=>$user_Exp['designation'])) ?><span id="autosavenotify" style="color:#F00; font-size:15px; float:right; width:100px;"></span></dd></dl>

<dl class="form"><dt><label>Sart Date</label></dt><dd><?php echo $this->Form->text('start_date',array('value'=>$user_Exp['start_date'],'id' => 'stdate')) ?><span id="autosavenotify" style="color:#F00; font-size:15px; float:right; width:100px;"></span></dd></dl>

<dl class="form"><dt><label>End Date</label></dt><dd>



<?php echo $this->Form->text('end_date',array('value'=>$user_Exp['end_date'],'id' => 'endate')); ?>  - <?php echo $user_Exp['location']; ?>

&nbsp;&nbsp;

<input type="checkbox" value="Present" onclick="disabledField()" id="presents" <?php if ($user_Exp['end_date'] == 'Present') echo 'checked=checked';?> name="data[Users_profile][presents]" />&nbsp;&nbsp; Present



<span id="autosavenotify" style="color:#F00; font-size:15px; float:right; width:100px;"></span></dd></dl>

<br /><br /><br />

<?php echo $this->Form->end('Update', array('class'=>'submit','style'=>'float:right')); ?>



<?php }?>

</div>

</div>