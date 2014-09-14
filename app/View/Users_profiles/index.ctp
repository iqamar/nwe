<div class="users index">

	<h2><?php echo ___('users');?></h2>

	<?php
	echo $this->element('toolbar/toolbar', array('add' => true, 'container_class' => 'toolbar_container_list', 'pagination_limit' => true), array('plugin' => 'alaxos'));
	?>

	<?php
	echo $this->AlaxosForm->create('User');
	?>

	<table cellspacing="0" class="administration">

	<tr class="sortHeader">
		<th style="width:5px;"></th>
		<th><?php echo $this->Paginator->sort('User.role_id', __('role'));?></th>
		<th><?php echo $this->Paginator->sort('User.username', __('username'));?></th>
		<th><?php echo $this->Paginator->sort('User.firstname', __('firstname'));?></th>
		<th><?php echo $this->Paginator->sort('User.lastname', __('lastname'));?></th>
		<th><?php echo $this->Paginator->sort('User.email', __('email'));?></th>
		<th><?php echo $this->Paginator->sort('User.enabled', __('enabled'));?></th>
		<th style="width:120px;"><?php echo $this->Paginator->sort('User.created', __('created'));?></th>
		<th style="width:120px;"><?php echo $this->Paginator->sort('User.modified', __('modified'));?></th>

		<th class="actions">&nbsp;</th>
	</tr>

	<tr class="searchHeader">
		<td style="padding:0px 3px;">
			<?php
			echo $this->AlaxosForm->checkbox('_Tech.selectAll', array('style' => 'margin-bottom:8px;'));
			?>
		</td>
			<td>
			<?php
				echo $this->AlaxosForm->filter_field('role_id');
			?>
		</td>
		<td>
			<?php
				echo $this->AlaxosForm->filter_field('username');
			?>
		</td>
		<td>
			<?php
				echo $this->AlaxosForm->filter_field('firstname');
			?>
		</td>
		<td>
			<?php
				echo $this->AlaxosForm->filter_field('lastname');
			?>
		</td>
		<td>
			<?php
				echo $this->AlaxosForm->filter_field('email');
			?>
		</td>
		<td>
			<?php
				echo $this->AlaxosForm->filter_field('enabled');
			?>
		</td>
		<td>
			<?php
				echo $this->AlaxosForm->filter_field('created');
			?>
		</td>
		<td>
			<?php
				echo $this->AlaxosForm->filter_field('modified');
			?>
		</td>
		<td class="searchHeader" style="width:80px">
    		<div class="submitBar">
    					<?php echo $this->AlaxosForm->end(___('search'));?>
    		</div>
    	</td>
	</tr>

	<?php
	$i = 0;
	foreach ($users as $user):
		$class = null;
		if ($i++ % 2 == 0)
		{
			$class = ' class="row"';
		}
		else
		{
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td>
		<?php
		echo $this->AlaxosForm->checkBox('User.' . $i . '.id', array('value' => $user['User']['id'], 'class' => 'model_id'));
		?>
		</td>
		<td>
			<?php echo $this->Html->link($user['Role']['name'], array('controller' => 'roles', 'action' => 'view', $user['Role']['id'])); ?>
		</td>
		<td>
			<?php echo $user['User']['username']; ?>
		</td>
		<td>
			<?php echo $user['User']['firstname']; ?>
		</td>
		<td>
			<?php echo $user['User']['lastname']; ?>
		</td>
		<td>
			<?php echo $user['User']['email']; ?>
		</td>
		<td>
			<?php
			echo $this->AlaxosHtml->get_yes_no($user['User']['enabled']);
			?>
		</td>
		<td>
			<?php echo DateTool :: sql_to_date($user['User']['created']); ?>
		</td>
		<td>
			<?php echo DateTool :: sql_to_date($user['User']['modified']); ?>
		</td>
		<td class="actions">

			<?php echo $this->Html->link($this->Html->image('/alaxos/img/toolbar/loupe.png'), array('action' => 'view', $user['User']['id']), array('class' => 'to_detail', 'escape' => false)); ?>
			<?php echo $this->Html->link($this->Html->image('/alaxos/img/toolbar/small_edit.png'), array('action' => 'edit', $user['User']['id']), array('escape' => false)); ?>
			<?php echo $this->Form->postLink($this->Html->image('/alaxos/img/toolbar/small_drop.png'), array('action' => 'delete', $user['User']['id']), array('escape' => false), sprintf(___("are you sure you want to delete '%s' ?"), $user['User']['username'])); ?>

		</td>
	</tr>
<?php endforeach; ?>
	</table>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 |
	 	<?php echo $this->Paginator->numbers(array('modulus' => 5, 'first' => 2, 'last' => 2, 'after' => ' ', 'before' => ' '));?>	 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>

	<?php
	if($i > 0)
	{
		echo '<div class="choose_action">';
		echo ___d('alaxos', 'action to perform on the selected items');
		echo '&nbsp;';
		echo $this->AlaxosForm->input_actions_list();
		echo '&nbsp;';
		echo $this->AlaxosForm->hidden('_Tech.actionAllUrl', array('value' => $this->AlaxosForm->url(array('action' => 'actionAll'))));
		echo $this->AlaxosForm->button(___d('alaxos', 'go'), array('id' => 'chooseActionFormBtn', 'type' => 'button'));
		echo '</div>';
	}
	?>

</div>
