<div class="roles view">
	
	<h2><?php echo ___('role');?></h2>
	
	<?php
	echo $this->element('toolbar/toolbar', array('add' => true, 'list' => true, 'edit_id' => $role['Role']['id'], 'copy_id' => $role['Role']['id'], 'delete_id' => $role['Role']['id'], 'delete_text' => ___('do you really want to delete this role ?')), array('plugin' => 'alaxos'));
	?>

	<table border="0" class="view">
	<tr>
		<td>
			<?php echo ___('name'); ?>
		</td>
		<td>:</td>
		<td>
			<?php echo $role['Role']['name']; ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo ___('order'); ?>
		</td>
		<td>:</td>
		<td>
			<?php echo $role['Role']['order']; ?>
		</td>
	</tr>
	</table>
	
	<div class="created_modified_zone">
	<?php
	echo ucfirst($this->element('create_update_dates', array('model' => $role['Role']), array('plugin' => 'alaxos')));
	?>
	</div>
	
</div>
