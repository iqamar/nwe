<div>
    <ul class="breadcrumb">
	<li>
	    <a href="#">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="#">Plans</a>
	</li>
    </ul>
</div>
 




<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Plans</h2>
	    <div class="box-icon">
		<a title="Add" href="<?php echo $this->request->webroot; ?>admin/plans_features/add" style="width:25px;"><img alt="Add" src="/alaxos/img/toolbar/add.png"></a>
	    </div>
	</div>
	<div class="box-content">
	    <table class="table table-striped table-bordered bootstrap-datatable datatable">
		<thead>
		    <tr>
			<th>Feature Name</th>
			<th >Feature For</th>				
			<th>Created On</th>
			<th>Status</th>
			<th>Actions</th>
		    </tr>
		</thead>
		<tbody>


		    <?php
		   //echo "<pre>";
		    //print_r($plansfeatures);
		    foreach ($plansfeatures as $plansfeature):
			?>



    		    <tr>
    		
    			<td>
				<?php echo $plansfeature['plans_features_masters']['title']; ?>
    			</td>
			
    			<td>
				<?php echo ucfirst($plansfeature['plans_features_masters']['type']); ?>
    			</td>
			


    			<td>
				<?php echo DateTool :: sql_to_date($plansfeature['plans_features_masters']['created']); ?>
    			</td>

    			<td class="center">
				<?php
				if ($plansfeature['plans_features_masters']['status'] == 2) {
				    echo '<span class="label label-success">Active</span>';
				} else if ($plansfeature['plans_features_masters']['status'] == -2) {
				    echo '<span class="label label-important">Banned</span>';
				} else if ($plansfeature['plans_features_masters']['status'] == -1) {
				    echo '<span class="label label-warning">Deleted</span>';
				}  else if ($plansfeature['plans_features_masters']['status'] == 0) {
				    echo '<span class="label label-warning">Pending</span>';
				} else {
				    echo '<span class="label">In Active</span>';
				}
				?>
    			</td>


    			<td class="center">
				<?php
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-zoom-in icon-white')) . " View", array('action' => 'view', $plansfeature['plans_features_masters']['id']), array('class' => 'btn btn-success', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-edit icon-white')) . " Edit", array('action' => 'edit', $plansfeature['plans_features_masters']['id']), array('class' => 'btn btn-info', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-trash icon-white')) . " Delete", array('action' => 'delete', $plansfeature['plans_features_masters']['id']), array('class' => 'btn btn-danger', 'escape' => false), "Are you sure you wish to delete this plans features?"
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



