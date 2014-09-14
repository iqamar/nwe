<div class="users view">
	
	<h2><?php echo ___('user');?></h2>
	
	<?php
	echo $this->element('toolbar/toolbar', array('add' => true, 'list' => true, 'edit_id' => $user['User']['id'], 'copy_id' => $user['User']['id'], 'delete_id' => $user['User']['id'], 'delete_text' => ___('do you really want to delete this user ?')), array('plugin' => 'alaxos'));
	?>

	<table border="0" class="view">
	<tr>
		<td>
			<?php echo ___('role'); ?>
		</td>
		<td>:</td>
		<td>
			<?php echo $this->Html->link($user['Role']['name'], array('controller' => 'roles', 'action' => 'view', $user['Role']['id'])); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo ___('username'); ?>
		</td>
		<td>:</td>
		<td>
			<?php echo $user['User']['username']; ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo ___('firstname'); ?>
		</td>
		<td>:</td>
		<td>
			<?php echo $user['User']['firstname']; ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo ___('lastname'); ?>
		</td>
		<td>:</td>
		<td>
			<?php echo $user['User']['lastname']; ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo ___('email'); ?>
		</td>
		<td>:</td>
		<td>
			<?php echo $user['User']['email']; ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo ___('enabled'); ?>
		</td>
		<td>:</td>
		<td>
			<?php
			echo $this->AlaxosHtml->get_yes_no($user['User']['enabled']);
			?>
		</td>
	</tr>
	</table>
	
	<div class="created_modified_zone">
	<?php
	echo ucfirst($this->element('create_update_dates', array('model' => $user['User']), array('plugin' => 'alaxos')));
	?>
	</div>
	
</div>
