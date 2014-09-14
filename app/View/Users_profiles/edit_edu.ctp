
<script type="text/javascript">
	$(document).ready(function() {
	//$.noConflict();
	$("#sdate").datepicker();
		$("#edate").datepicker();
	});

	</script>

<?php foreach ($userEduRec as $eduRecUser){?>

<?php echo $this->Form->create("Users_profile",array('controller' => 'users_profiles', 'action' => 'edit_edu'));?>
<?php $cuser = $this->Session->read(@$userid);?>
<?php echo $this->Form->input('user_id' , array('type' => 'hidden', 'value' => $cuser['userid'])) ?>
<?php echo $this->Form->input('id' , array('type' => 'hidden', 'value' => $id)) ?>



<dl class="form"><dt><label>School/University/Institute Name</label></dt>
<dd><?php echo $this->Form->text('institute_name',array('required'=>true,'id'=>'institute_name','name'=>'institute_name','value'=>'')) ?>
</dd></dl>

<dl class="form"><dt><label>Major</label></dt>
<dd>
<?php echo $this->Form->text('Major',array('required'=>true,'name'=>'qualification','id'=>'qualification','value'=>$eduRecUser['users_qualifications']['qualifications'])) ?>
</dd></dl>
<dl class="form"><dt><label>Field of study</label></dt>
<dd><?php echo $this->Form->text('field_study',array('required'=>true,'id'=>'field_study','value'=>$eduRecUser['users_qualifications']['field_study'])) ?>
</dd></dl>



<dl class="form"><dt><label><b>Attended period</b></label></dt><dd> 
<?php echo $this->Form->text('start_date',array('required'=>true,'id'=>'stdate', style=>"width:150px",'value'=>$eduRecUser['users_qualifications']['start_date'])) ?>
<?php echo $this->Form->text('end_date',array('required'=>true,'id'=>'endate', style => "width:150px",'value'=>$eduRecUser['users_qualifications']['end_date'])) ?></dd></dl>
<dl class="form" style="clear:both;"><dd><?php echo $this->Form->Submit('Add', array('div'=>false,'class'=>'inpt-btn','style'=>'float:right; margin-top:5px;')); ?>
<?php echo $this->Form->end(); ?>
</dd></dl>
<dl class="form" style="clear:both;"><dd><?php echo $this->Form->end('Update', array('class'=>'submit','style'=>array('float:right'))); ?>
</dd></dl>

<?php }?>
