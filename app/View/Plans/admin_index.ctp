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
		<a title="Add" href="<?php echo $this->request->webroot; ?>admin/plans/add" style="width:25px;"><img alt="Add" src="/alaxos/img/toolbar/add.png"></a>
	    </div>
	</div>
	<div class="box-content">
	    <table class="table table-striped table-bordered bootstrap-datatable datatable">
		<thead>
		    <tr>
			<th>Plan Name</th>
			<th >Price</th>
			<th>Yearly Discount (In Percentage)</th>		
			<th>Created On</th>
			<th>Status</th>
			<th>Actions</th>
		    </tr>
		</thead>
		<tbody>


		    <?php
		 //  echo "<pre>";
		  //  print_r($groups);
		    foreach ($plans as $plan):
			?>



    		    <tr>
    		
    			<td>
				<?php echo ucfirst($plan['plans']['type'])." ". $plan['plans']['title']; ?>
    			</td>
			
    			<td>
				<?php echo $plan['plans']['price']; ?>
    			</td>
				<td>
				<?php echo $plan['plans']['yearly_discount_percentage']; ?>
    			</td>


    			<td>
				<?php echo DateTool :: sql_to_date($plan['plans']['created']); ?>
    			</td>

    			<td class="center">
				<?php
				if ($plan['plans']['status'] == 2) {
				    echo '<span class="label label-success">Active</span>';
				} else if ($plan['plans']['status'] == -2) {
				    echo '<span class="label label-important">Banned</span>';
				} else if ($plan['plans']['status'] == -1) {
				    echo '<span class="label label-warning">Deleted</span>';
				}  else if ($plan['plans']['status'] == 0) {
				    echo '<span class="label label-warning">Pending</span>';
				} else {
				    echo '<span class="label">In Active</span>';
				}
				?>
    			</td>


    			<td class="center">
				<?php
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-cog icon-white')) . " Features", array('action' => 'features', $plan['plans']['id']), array('class' => 'btn btn-inverse', 'escape' => false)
				);

				echo "&nbsp;";
			
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-zoom-in icon-white')) . " View", array('action' => 'view', $plan['plans']['id']), array('class' => 'btn btn-success', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-edit icon-white')) . " Edit", array('action' => 'edit', $plan['plans']['id']), array('class' => 'btn btn-info', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-trash icon-white')) . " Delete", array('action' => 'delete', $plan['plans']['id']), array('class' => 'btn btn-danger', 'escape' => false), "Are you sure you wish to delete this plan?"
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



