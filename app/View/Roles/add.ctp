<div class="roles form">

	<?php echo $this->AlaxosForm->create('Role');?>
	
 	<h2><?php echo ___('add role'); ?></h2>
 	
 	<?php
	echo $this->element('toolbar/toolbar', array('list' => true), array('plugin' => 'alaxos'));
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
			<?php echo $this->AlaxosForm->end(___('submit')); ?> 		</td>
 	</tr>
	</table>
	
</div>
