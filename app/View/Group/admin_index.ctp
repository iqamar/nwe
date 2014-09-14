<div>
    <ul class="breadcrumb">
	<li>
	    <a href="#">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="#">Groups</a>
	</li>
    </ul>
</div>





<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Groups</h2>
	    <div class="box-icon">
		<a title="Add" href="<?php echo $this->request->webroot; ?>admin/groups/add" style="width:25px;"><img alt="Add" src="/alaxos/img/toolbar/add.png"></a>
	    </div>
	</div>
	<div class="box-content">
	    <table class="table table-striped table-bordered bootstrap-datatable datatable">
		<thead>
		    <tr>
			<th colspan="2">Group Name</th>
			<th >Group Type</th>
			<th>Featured Group</th>
			<th>Top Group</th>
			<th>Created On</th>
			<th>Status</th>
			<th>Actions</th>
		    </tr>
		</thead>
		<tbody>


		    <?php
		 //  echo "<pre>";
		  //  print_r($groups);
		    foreach ($groups as $group):
			?>



    		    <tr>
    			<td>
				<?php echo '<img alt="logo" style="width:40px;" src="' . $this->request->webroot . 'files/groups_logo/' . $group['groups']['logo'] . '">'; ?>
    			</td>
    			<td>
				<?php echo $group['groups']['title']; ?>
    			</td>
				<td>
				<?php echo $group['groups_types']['title']; ?>
    			</td>
    			<td>
					<?php echo $this->AlaxosHtml->get_yes_no($group['groups']['featured_display']);?>

    			</td>
    			<td>
					<?php echo $this->AlaxosHtml->get_yes_no($group['groups']['top_groups_display']);?>
    			</td>


    			<td>
				<?php echo DateTool :: sql_to_date($group['groups']['created']); ?>
    			</td>


    			<td class="center">
				<?php
				if ($group['groups']['status'] == 2) {
				    echo '<span class="label label-success">Active</span>';
				} else if ($group['groups']['status'] == -2) {
				    echo '<span class="label label-important">Banned</span>';
				} else if ($group['groups']['status'] == -1) {
				    echo '<span class="label label-warning">Deleted</span>';
				}  else if ($group['groups']['status'] == 0) {
				    echo '<span class="label label-warning">Pending</span>';
				} else {
				    echo '<span class="label">In Active</span>';
				}
				?>
    			</td>


    			<td class="center">
				<?php
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-zoom-in icon-white')) . " View", array('action' => 'view', $group['groups']['id']), array('class' => 'btn btn-success', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-edit icon-white')) . " Edit", array('action' => 'edit', $group['groups']['id']), array('class' => 'btn btn-info', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-trash icon-white')) . " Delete", array('action' => 'delete', $group['groups']['id']), array('class' => 'btn btn-danger', 'escape' => false), "Are you sure you wish to delete this groups?"
				);
				?>
    			</td>



    		    </tr>
		    <?php endforeach; ?>



		</tbody>
	    </table>
	</div>
    </div><!--/span-->

</div><!--/row-->



