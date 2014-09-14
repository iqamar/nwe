<script type="text/javascript">

jQuery(document).ready(function(){
			$('#zipsearch').autocomplete({source:'users/search', minLength:1});
		});
</script>
<style type="text/css"><!--
	
	        /* style the auto-complete response */
	        li.ui-menu-item { font-size:12px !important; }
	
	--></style>
    <div class="left_p_user">
<ul class="menu accordion">
<li class="section">
<a href="/users/profile" class="section-head">NetworkWe</a>
</li>
</ul>
<ul class="expanded">
<li class="profile"><?php echo $this->Html->link(__('Profile'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'profile'),array('class'=>'selected')); ?></li>
<li class="password"><?php echo $this->Html->link(__('Change Password'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'account')); ?></li>
<li class="exp"><?php echo $this->Html->link(__('Experience'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'display')); ?></li>
<li class="skill"><?php echo $this->Html->link(__('Skills'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'showskills')); ?></li>
<li class="edu"><?php echo $this->Html->link(__('Qualification'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'useredu')); ?></li>
<li class="edu"><?php echo $this->Html->link(__('Connections'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'search')); ?></li>
</ul>
</div> 
<div class="settings-content">
<div class="boxed-group" style="min-height:35px;">
<h3>User Connections</h3>
<div class="boxed-group-inner" style="min-height:300px;">
<div style="width:400px; height:40px;">                 
  <?php echo $this->Form->create('users',array('controller'=>'users','action'=>'search','class'=>'searForm'));?> 
<?php echo $this->Form->input('username',array('type'=>'text','id'=>'username','label'=>'')); ?> 
<?php echo $this->Form->end(array('div'=>false,'text'=>'Search','class'=>'savebtn','style'=>'margin-top:-38px; height:30px; width:70px;'));?>            
 </div>
 <?php if ($user_con) {
 print_r($user_con);
 foreach ($user_con as $user_req) {
 ?>
 <div class="user-profile">
 <div class="profile-picture"></div>
 </div> 
 <?php }} ?>  
</div>
</div>
</div>