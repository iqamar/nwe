<div class="users form">

	<?php echo $this->AlaxosForm->create('User');?>
	
 	<h2><?php echo ___('admin copy user'); ?></h2>
 	
 	<?php
	echo $this->element('toolbar/toolbar', array('list' => true, 'back_to_view_id' => $user['User']['id']), array('plugin' => 'alaxos'));
	?>
 	
 	<table border="0" cellpadding="5" cellspacing="0" class="edit">
	<tr>
		<td>
			<?php echo ___('role_id') ?>
		</td>
		<td>:</td>
		<td>
			<?php echo $this->AlaxosForm->input('role_id', array('label' => false)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo ___('username') ?>
		</td>
		<td>:</td>
		<td>
			<?php echo $this->AlaxosForm->input('username', array('label' => false)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo ___('password') ?>
		</td>
		<td>:</td>
		<td>
			<?php echo $this->AlaxosForm->input('password', array('label' => false)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo ___('firstname') ?>
		</td>
		<td>:</td>
		<td>
			<?php echo $this->AlaxosForm->input('firstname', array('label' => false)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo ___('lastname') ?>
		</td>
		<td>:</td>
		<td>
			<?php echo $this->AlaxosForm->input('lastname', array('label' => false)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo ___('email') ?>
		</td>
		<td>:</td>
		<td>
			<?php echo $this->AlaxosForm->input('email', array('label' => false)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo ___('enabled') ?>
		</td>
		<td>:</td>
		<td>
			<?php echo $this->AlaxosForm->input('enabled', array('label' => false)); ?>
		</td>
	</tr>
	<tr>
 		<td></td>
 		<td></td>
 		<td>
			<?php echo $this->AlaxosForm->end(___d('alaxos', 'copy')); ?> 		</td>
 	</tr>
	</table>

</div>
