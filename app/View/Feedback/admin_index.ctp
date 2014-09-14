<div>
    <ul class="breadcrumb">
	<li>
	    <a href="#">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="#">Feedbacks</a>
	</li>
    </ul>
</div>





<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Feedbacks</h2>
	    
	</div>
	<div class="box-content">
	    <table class="table table-striped table-bordered bootstrap-datatable datatable">
		<thead>
		    <tr>
			<th>Subject</th>
			<th>User ID</th>
			<th>Created On</th>
			<th>Actions</th>
		    </tr>
		</thead>
		<tbody>


		    <?php
                    foreach ($feedbacks as $feedback):
			?>

    		    <tr>
    			
    			<td>
				<?=$feedback['feedbacks']['subject']?>
					
    			</td>
                        
    			<td>
					<?=$feedback['feedbacks']['user_id']?>

    			</td>
                        
    			<td>
					<?php echo DateTool :: sql_to_date($feedback['feedbacks']['created']); ?>
    			</td>


    			<td class="center">
				<?php
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-zoom-in icon-white')) . " View", array('action' => 'view', $feedback['feedbacks']['id']), array('class' => 'btn btn-success', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-trash icon-white')) . " Delete", array('action' => 'delete', $feedback['feedbacks']['id']), array('class' => 'btn btn-danger', 'escape' => false), "Are you sure you wish to delete this institutes?"
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



