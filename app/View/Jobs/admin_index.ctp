<div>
    <ul class="breadcrumb">
	<li>
	    <a href="#">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="#">Jobs</a>
	</li>
    </ul>
</div>





<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Jobs Board</h2>
	    <div class="box-icon">
		<a title="Add" href="add" style="width:25px;"><img alt="Add" src="/alaxos/img/toolbar/add.png"></a>
	    </div>
	</div>
	<div class="box-content">
	    <table class="table table-striped table-bordered bootstrap-datatable datatable">
		<thead>
		    <tr>
			<th>Job Title</th>
			<th>Employer</th>
			<th>Location</th>
			<th>Experience</th>
			<th>Start Date</th>
			<th>End Date</th>			
			<th>Status</th>
			<th>Actions</th>
		    </tr>
		</thead>
		<tbody>


		    <?php
		   // echo "<pre>";
		//   print_r($jobs);
		    foreach ($jobs as $data):
			?>



    		    <tr>
    			<td>
				<?php echo "<b>".$data['jobs']['title']."</b>"; ?>				
                 </td>
    			<td>
				<?php echo $data['companies']['title']; ?>
    			</td>
    			<td>
				<?php echo $data['jobs']['city']."<br/>".$data['countries']['name']; ?>
    			</td>
				<td>
				<?php echo $data['jobs']['min_experience']." - ".$data['jobs']['max_experience']." years"; ?>
				</td>	
				<td>
				<?php echo date("M d, Y", strtotime($data['jobs']['start_date'])); ?>
				
    			</td>
    			<td>
				<?php echo date("M d, Y", strtotime($data['jobs']['expiry_date'])); ?>
    			</td>                  		
    			<td class="center">
				<?php
				if ($data['jobs']['status'] == 2) {
				    echo '<span class="label label-success">Active</span>';
				} else if ($data['jobs']['status'] == -2) {
				    echo '<span class="label label-important">Banned</span>';
				} else if ($data['jobs']['status'] == -1) {
				    echo '<span class="label label-warning">Pending</span>';
				} else {
				    echo '<span class="label">In Active</span>';
				}
				?>
    			</td>


    			<td class="center" nowrap>
				<?php
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-zoom-in icon-white')) . " View", array('action' => 'view', $data['jobs']['id']), array('class' => 'btn btn-success', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-edit icon-white')) . " Edit", array('action' => 'edit', $data['jobs']['id']), array('class' => 'btn btn-info', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-trash icon-white')) . " Delete", array('action' => 'delete', $data['jobs']['id']), array('class' => 'btn btn-danger', 'escape' => false), "Are you sure you wish to delete this member?"
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



