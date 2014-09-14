<?php echo $this->Form->create('Users_profile', array('url'=>'/users_profiles/profile_summary/','enctype'=>'multipart/form-data','id'=>'summaryUploader'));?>	
<?php echo $this->Form->textarea('summary',array('required'=>false,
										'style'=>array('width:475px; height:230px; padding:6px;'),'value'=>$profile_summary_array,'id'=>'summary1'));?>
<?php echo $this->Form->submit('Submit',array('div'=>false,'id'=>'summary_btn')); ?>
<?php echo $this->Form->end();?>