<div>
    <ul class="breadcrumb">
	<li>
	    <a href="#">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="#">Institutes</a>
	</li>
    </ul>
</div>





<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Institutes</h2>
	    <div class="box-icon">
		<a title="Add" href="<?php echo $this->request->webroot; ?>admin/institutes/add" style="width:25px;"><img alt="Add" src="/alaxos/img/toolbar/add.png"></a>
	    </div>
	</div>
	<div class="box-content">
	    <table class="table table-striped table-bordered bootstrap-datatable datatable">
		<thead>
		    <tr>
			<th colspan="2">Institutes Name</th>
			<th>Featured Institutes</th>
			<th>Top Institutes</th>
			<th>Created On</th>
			<th>Status</th>
			<th>Actions</th>
		    </tr>
		</thead>
		<tbody>


		    <?php
		 //  echo "<pre>";
		  //  print_r($institutes);
		    foreach ($institutes as $institute):
			?>



    		    <tr>
    			<td>
				<?php echo '<img alt="logo" style="width:40px;" src="' . $this->request->webroot . 'files/institutes_logo/' . $institute['institutes']['logo'] . '">'; ?>
    			</td>
    			<td>
				<?php echo $institute['institutes']['title']; ?><br/>
					<?php echo $institute['institutes']['city'] . " - " . $institute['countries']['name']; ?>
    			</td>
    			<td>
					<?php echo $this->AlaxosHtml->get_yes_no($institute['institutes']['featured_display']);?>

    			</td>
    			<td>
					<?php echo $this->AlaxosHtml->get_yes_no($institute['institutes']['top_institutes_display']);?>
    			</td>


    			<td>
				<?php echo DateTool :: sql_to_date($institute['institutes']['created']); ?>
    			</td>


    			<td class="center">
				<?php
				if ($institute['institutes']['status'] == 2) {
				    echo '<span class="label label-success">Active</span>';
				} else if ($institute['institutes']['status'] == -2) {
				    echo '<span class="label label-important">Banned</span>';
				} else if ($institute['institutes']['status'] == -1) {
				    echo '<span class="label label-warning">Deleted</span>';
				}  else if ($institute['institutes']['status'] == 0) {
				    echo '<span class="label label-warning">Pending</span>';
				} else {
				    echo '<span class="label">In Active</span>';
				}
				?>
    			</td>


    			<td class="center">
				<?php
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-zoom-in icon-white')) . " View", array('action' => 'view', $institute['institutes']['id']), array('class' => 'btn btn-success', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-edit icon-white')) . " Edit", array('action' => 'edit', $institute['institutes']['id']), array('class' => 'btn btn-info', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-trash icon-white')) . " Delete", array('action' => 'delete', $institute['institutes']['id']), array('class' => 'btn btn-danger', 'escape' => false), "Are you sure you wish to delete this institutes?"
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



