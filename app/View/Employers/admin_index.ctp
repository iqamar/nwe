<?php // echo "<pre>"; echo print_r($companies); echo "</pre>"; ?>

<div>
    <ul class="breadcrumb">
	<li>
	    <a href="#">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="#">Employers</a>
	</li>
    </ul>
</div>





<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Business Houses</h2>
	    <div class="box-icon">
		<a title="Add" href="<?php echo $this->request->webroot; ?>admin/employers/add" style="width:25px;"><img alt="Add" src="/alaxos/img/toolbar/add.png"></a>
	    </div>
	</div>
	<div class="box-content">
	    <table class="table table-striped table-bordered bootstrap-datatable datatable">
		<thead>
		    <tr>
			<th colspan="2">Employer Name</th>
			<th>Featured Employer</th>
			<th>Top Employer</th>
			<th>Created On</th>
			<th>Status</th>
			<th>Actions</th>
		    </tr>
		</thead>
		<tbody>


		    <?php
		 //  echo "<pre>";
		  //  print_r($companies);
		    foreach ($companies as $company):
			?>



    		    <tr>
    			<td>
				<?php echo '<img alt="logo" style="width:40px;" src="' . $this->request->webroot . 'files/companies_logo/' . $company['companies']['logo'] . '">'; ?>
    			</td>
    			<td>
				<?php echo $company['companies']['title']; ?><br/>
					<?php echo $company['companies']['city'] . " - " . $company['countries']['name']; ?>
    			</td>
    			<td>
					<?php echo $this->AlaxosHtml->get_yes_no($company['companies']['featured_display']);?>

    			</td>
    			<td>
					<?php echo $this->AlaxosHtml->get_yes_no($company['companies']['top_employer_display']);?>
    			</td>


    			<td>
				<?php // echo DateTool :: sql_to_date($company['companies']['created']);
                                echo date("M d, Y", strtotime($company['companies']['created']));
                                
                                ?>
    			</td>


    			<td class="center">
				<?php
				if ($company['companies']['status'] == 2) {
				    echo '<span class="label label-success">Active</span>';
				} else if ($company['companies']['status'] == -2) {
				    echo '<span class="label label-important">Banned</span>';
				} else if ($company['companies']['status'] == -1) {
				    echo '<span class="label label-warning">Deleted</span>';
				}  else if ($company['companies']['status'] == 0) {
				    echo '<span class="label label-warning">Pending</span>';
				} else {
				    echo '<span class="label">In Active</span>';
				}
				?>
    			</td>


    			<td class="center">
				<?php
                                
                                echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-zoom-in icon-white')) . " View", array('action' => 'view' , $company['companies']['id']), array('class' => 'btn btn-success', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-edit icon-white')) . " Edit", array('action' => 'edit', $company['companies']['id']), array('class' => 'btn btn-info', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-trash icon-white')) . " Delete", array('action' => 'delete', $company['companies']['id']), array('class' => 'btn btn-danger', 'escape' => false), "Are you sure you wish to delete this member?"
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



