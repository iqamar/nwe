<?php
//echo "<pre>";
//print_r($categories);
//echo "</pre>";
?>

<div>
    <ul class="breadcrumb">
	<li>
	    <a href="#">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="#">Press Releases</a>
	</li>
    </ul>
</div>





<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Press Releases</h2>
            <a href="/admin/press/categories" style="position: absolute; left: 1082px;"> Manage Press Categories</a>
	    <div class="box-icon">
                
		<a title="Add" href="<?php echo $this->request->webroot; ?>admin/press/add" style="width:25px;"><img alt="Add" src="<?php echo $this->request->webroot; ?>alaxos/img/toolbar/add.png"></a>
	    </div>
	</div>
	<div class="box-content">
	    <table class="table table-striped table-bordered bootstrap-datatable datatable">
		<thead>
		    <tr>
			<th>Headline</th>
			<th>Created On</th>
			<th>Status</th>
			<th>Actions</th>
		    </tr>
		</thead>
		<tbody>


		    <?php
		    //echo "<pre>";
		    //print_r($countries);
		    foreach ($press as $presses):
			?>



    		    <tr>
    			<td>
                            <?php
                            echo $presses['press_releases']['headline'];
                            ?>
                               
    			</td>
    			<td>
				<?php echo DateTool :: sql_to_date($presses['press_releases']['created']); ?>
    			</td>

    			<td class="center">
				<?php
				if ($presses['press_releases']['publish'] == 1) {
				    echo '<span class="label label-success">Active</span>';
				} else {
				    echo '<span class="label">In Active</span>';
				}
				?>
    			</td>

    			<td class="center" nowrap>
				<?php
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-zoom-in icon-white')) . " View", array('action' => 'view', $presses['press_releases']['id']), array('class' => 'btn btn-success', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-edit icon-white')) . " Edit", array('action' => 'edit', $presses['press_releases']['id']), array('class' => 'btn btn-info', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-trash icon-white')) . " Delete", array('action' => 'delete', $presses['press_releases']['id']), array('class' => 'btn btn-danger', 'escape' => false), "Are you sure you wish to delete this article?"
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



