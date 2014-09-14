<div class="roles form">

	<?php echo $this->AlaxosForm->create('Role');?>
	<?php echo $this->AlaxosForm->input('id'); ?>
	
 	<h2><?php echo ___('admin edit role'); ?></h2>
 	
 	<?php
	echo $this->element('toolbar/toolbar', array('list' => true, 'back_to_view_id' => $role['Role']['id']), array('plugin' => 'alaxos'));
	?>
 	
 	<table border="0" cellpadding="5" cellspacing="0" class="edit">
	<tr>
		<td>
			<?php echo ___('name') ?>
		</td>
		<td>:</td>
		<td>
			<?php echo $this->AlaxosForm->input('name', array('label' => false)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo ___('order') ?>
		</td>
		<td>:</td>
		<td>
			<?php echo $this->AlaxosForm->input('order', array('label' => false)); ?>
		</td>
	</tr>
	<tr>
 		<td></td>
 		<td></td>
 		<td>
			<?php echo $this->AlaxosForm->end(___('update')); ?> 		</td>
 	</tr>
	</table>
	
	<div class="created_modified_zone">
	<?php
	echo ucfirst($this->element('create_update_dates', array('model' => $role['Role']), array('plugin' => 'alaxos')));
	?>
	</div>

</div>
