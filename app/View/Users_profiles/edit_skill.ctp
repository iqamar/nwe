<script type="text/javascript">
	$(document).ready(function() {
	$("#startdate").datepicker();
	$("#enddate").datepicker();
	});
	</script>
<?php echo $this->Form->create("Users_profile",array('controller' => 'users_profiles', 'action' => 'edit_skill'));?>
<?php
foreach ($cuserskill as $user_Skill) {
?>
<?php $cuser = $this->Session->read($userid);?>
<?php echo $this->Form->input('user_id' , array('type' => 'hidden', 'value' => $user_Skill['users_skills']['user_id'])) ?>
<?php echo $this->Form->input('id' , array('type' => 'hidden', 'value' => $user_Skill['users_skills']['id'])) ?>
<?php echo $this->Form->text('skillid',array('required'=>true,'id'=>'skillidS', 'value' => $user_Skill['skills']['title'],'disabled'=>true)) ?>
</dd> 
</dl>
<dl class="form"><dt><label>Start Date</label></dt><dd><?php echo $this->Form->text('start_date',array('required'=>true,'id'=>'startdate','value'=>$user_Skill['users_skills']['start_date'])) ?></dd></dl>
<dl class="form"><dt><label>End Date</label></dt><dd><?php echo $this->Form->text('end_date',array('required'=>true,'id'=>'enddate','value'=>$user_Skill['users_skills']['end_date'])) ?></dd></dl>
<dl class="form" style="clear:both;"><dd><?php echo $this->Form->end('Update', array('class'=>'submit','style'=>'float:right')); ?></dd></dl>
<?php }?>