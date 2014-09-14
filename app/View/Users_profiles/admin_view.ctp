<?php //echo "<pre>"; print_r($users_profiles); echo "</pre>"; ?>

<div>
    <ul class="breadcrumb">
	<li>
	    <a href="#">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="#">Users</a> <span class="divider">/</span>
	</li>

	</li>
	<li>
	   <?php echo $users_profiles['firstname']." ".$users_profiles['lastname']; ?>
	</li>
    </ul>
</div>


<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Member Details</h2>
	    <div class="box-icon">
	
		<a title="Add" href="/admin/users_profiles/" style="width:25px;"><img alt="Add" src="/alaxos/img/toolbar/list.png"></a>
		<a title="Edit" href="/admin/users_profiles/edit/85/" style="width:25px;"><img alt="Add" src="/alaxos/img/toolbar/editor.png"></a>
		<a title="Delete" href="#" onclick="if (confirm("Do you really want to delete this user ?")) { document.post_529d7f1a5beb1655236964.submit(); } event.returnValue = false; return false;" style="width:25px;"><img alt="Add" src="/alaxos/img/toolbar/drop.png"></a>
	    </div>
	</div>

	
	<div class="box-content">
	    <table class="table table-striped bootstrap-datatable ">		
		<tbody>

			
			<tr>
			<td><?php echo ___('username'); ?></td>
			<td><?php echo $user['User']['email']; ?></td>

			<td colspan="2" rowspan="3"><img style="width:100px;" src="/files/users/<?php echo $users_profiles['photo']; ?>"></td>
			</tr>

			<tr>
			<td><?php echo ___('role name'); ?></td>
			<td>
			<?php echo $user['Role']['name']; ?>
			</td>
			</tr>

			<tr>
			<td><?php echo ___('Full Name'); ?></td>
			<td><?php echo $users_profiles['firstname']." ".$users_profiles['lastname']; ?></td>
			</tr>

	<tr>
			<td><?php echo ___('address'); ?></td>
			<td ><?php echo $users_profiles['address1']."<br/>".$users_profiles['address2']; ?></td>
			<td><?php echo ___('profile handler'); ?></td>
			<td><?php echo $users_profiles['handler']; ?></td>

			</tr>

				<tr>
		
			</tr>

			<tr>
			<td><?php echo ___('mobile'); ?></td>
			<td><?php echo $users_profiles['mobile']; ?></td>
			
			<td><?php echo ___('city'); ?></td>
			<td><?php echo $users_profiles['city']; ?></td>
			</tr>


	
		
			
			<td><?php echo ___('avaliable for hire'); ?></td>
			<td><?php echo $this->AlaxosHtml->get_yes_no($users_profiles['avaliable']);?></td>
	<td><?php echo ___('show hiring status on profile'); ?></td>
			<td><?php echo $this->AlaxosHtml->get_yes_no($users_profiles['hiring']);?></td>
			</tr>

<tr>
			<td><?php echo ___('active user'); ?></td>
			<td>
				<?php	echo $this->AlaxosHtml->get_yes_no($user['User']['status']);?>
			</td>
			<td><?php echo ___('intrested in'); ?></td>
			<td><?php echo $users_profiles['availability_type'] ."<br />". $users_profiles['intrested_in']; ?></td>
			</tr>
	<tr>



			<td><?php echo ___('summary'); ?></td>
			<td colspan="3"><?php echo $users_profiles['summary']; ?></td>
			</tr>

	<tr>
			<td><?php echo ___('tags'); ?></td>
			<td colspan="3"><?php echo $users_profiles['tags']; ?></td>
			</tr>
   

			
			<tr>
			<td colspan="4"><div class="created_modified_zone">
	<?php
	echo ucfirst($this->element('create_update_dates', array('model' => $user['User']), array('plugin' => 'alaxos')));
	?>
	</div></td>
			
			</tr>
		</tbody>
		</table>
	
	</div>


	</div>
</div>


