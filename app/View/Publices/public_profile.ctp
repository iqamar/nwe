<script type="text/javascript">
function autoSaveField(uid,fieldid,field){
var fieldVal = document.getElementById(fieldid).value;
$.ajax({
              url     : baseUrl+"/publices/public_profile",
              type    : "POST",
              cache   : false,
              data    : {cuserid: uid,fieldnew:fieldVal,field:field},
              success : function(data){
			  $("#span_"+field).html(data);
              },
			  error : function(data) {
           $("#span_"+field).html(data);
        }
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
<li class="profile"><?php echo $this->Html->link(__('Profile Handler'), array('plugin' => false, 'admin' => false, 'controller' => 'publices', 'action' => 'public_profile'),array('class'=>'selected')); ?>
</li>
<li class="profile"><?php echo $this->Html->link(__('Availability Status'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'hire_status')); ?>
</li>
<li class="password"><?php echo $this->Html->link(__('Change Password'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'account')); ?></li>

</ul>


</div>

<div class="settings-content"  style="float: left; width: 70%;">
<div class="boxed-group" style="min-height:35px;">
<h3>Public Profile<span style="float:right">
<?php echo $this->Html->link(__('View Profile'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'myprofile'),array('style'=>'font-weight:800;font-size:12px;text-decoration:none;')); ?>
</h3>
<div class="boxed-group-inner" style="min-height:300px;">
<?php 
$cuser = $this->Session->read($userid);
$uid = $cuser['userid'];
//echo $this->Form->create('Public',array('method'=>'post'));
?>
<dl class="form"><dt><label>Public Profile</label></dt>
<dd><span style="float:left"><?php echo "http://demo.networkwe.com/pub/&nbsp;&nbsp;&nbsp;";?></span>
<?php 
echo $this->Form->text('handler',array('required'=>false,'value'=>$handler_Value,'onChange'=>'autoSaveField('.$uid.',"handler","handler")','id'=>'handler')); ?>
<span id="span_handler" style="color:#F00; font-size:15px; float:right; width:190px;"></span></dd></dl>
<?php echo $this->Form->input('user_id' , array('type' => 'hidden', 'value' => $cuser['userid'])) ?>
<?php // echo $this->Form->end(array('div'=>false,'class'=>'submitss','style'=>'display:none;')); ?>
</div>
</div>
</div>