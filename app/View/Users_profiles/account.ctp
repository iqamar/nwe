<script type="text/javascript">
function checFormValidation() {

var newpass = document.getElementById('UserPassword').value;
var cnewpass = document.getElementById('UserCpassword').value;
if (newpass != cnewpass) {
document.getElementById('con_div').innerHTML="Your password not confirmed";
return false;
}
else {
return true;
}
}
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
<div class="left_p_user">
<ul class="menu accordion">
<li class="section">
<a  class="section-head">Update your profile</a>
</li>
</ul>
<ul class="expanded">
<!--<li class="profile"><?php echo $this->Html->link(__('Profile'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'myprofile'),array('class'=>'selected')); ?></li>-->
<li class="profile"><?php echo $this->Html->link(__('Edit Profile'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'profile')); ?></li>
<li class="profile"><?php echo $this->Html->link(__('Photo'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'userphoto')); ?></li>
<li class="profile"><?php echo $this->Html->link(__('Summary'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'profile_summary')); ?></li>

<li class="exp"><?php echo $this->Html->link(__('Experience'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'display')); ?></li>
<li class="skill"><?php echo $this->Html->link(__('Skills'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'showskills')); ?></li>
<li class="edu"><?php echo $this->Html->link(__('Qualification'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'useredu')); ?></li>
<li class="profile"><?php echo $this->Html->link(__('Profile Handler'), array('plugin' => false, 'admin' => false, 'controller' => 'publices', 'action' => 'public_profile')); ?>
</li>
<li class="profile"><?php echo $this->Html->link(__('Availability Status'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'hire_status')); ?>
</li>
<li class="password"><?php echo $this->Html->link(__('Change Password'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'account'),array('class'=>'selected')); ?></li>

</ul>

</div>

<div class="settings-content"  style="float: left; width: 70%;">
<div class="boxed-group">
<h3>Change Password<span style="float:right">
<?php echo $this->Html->link(__('View Profile'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'myprofile'),array('style'=>'font-weight:800;font-size:12px;text-decoration:none;')); ?>
</h3>
<div class="boxed-group-inner">
<?php echo $this->Form->create("Users_profile",array('controller' => 'users_profiles', 'action' => 'account','onsubmit'=>'return checFormValidation()'));?>

<dl class="form"><dt><label>Old Password</label></dt><dd><?php echo $this->Form->password('oldpassword',array('required'=>true)) ?>
<span id="autosavenotify" style="color:#F00; font-size:15px; float:right; width:220px;"></span></dd></dl>
<dl class="form"><dt><label>New Password </label></dt><dd><?php echo $this->Form->password('password',array('required'=>true)) ?><span id="autosavenotify" style="color:#F00; font-size:15px; float:right; width:220px;"></span></dd></dl>
<dl class="form"><dt><label>Confirm Password</label></dt><dd><?php echo $this->Form->password('cpassword',array('required'=>true)) ?><span id="con_div" style="color:#F00; font-size:15px; float:right; width:220px;"></span></dd></dl><br /><br /><br />
<?php echo $this->Form->end('Update' ,array('class' => 'submit')); ?>

</div>
</div>
</div>