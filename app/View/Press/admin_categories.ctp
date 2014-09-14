<div>
    <ul class="breadcrumb">
	<li>
	    <a href="/admin">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="/admin/press">Press Categories</a>
	</li>
    </ul>
</div>





<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Press Categories</h2>
            
	    <div class="box-icon">
                
		<a title="Add" href="<?php echo $this->request->webroot; ?>admin/press/addCategory" style="width:25px;"><img alt="Add" src="<?php echo $this->request->webroot; ?>alaxos/img/toolbar/add.png"></a>
                
	    </div>
	</div>
	<div class="box-content">
	    <table class="table table-striped table-bordered bootstrap-datatable datatable">
		<thead>
		    <tr>
			<th>Category Name</th>
			
		    </tr>
		</thead>
		<tbody>


		    <?php
		    //echo "<pre>";
		    //print_r($countries);
		    foreach ($categories as $category):
			?>



    		    <tr>
    			<td>
                            <?php echo $category['press_categories']['category']; ?>
    			</td>

    			<td class="center" nowrap>
				<?php
				

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-edit icon-white')) . " Edit", array('action' => 'editCategory', $category['press_categories']['id']), array('class' => 'btn btn-info', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-trash icon-white')) . " Delete", array('action' => 'deleteCategory', $category['press_categories']['id']), array('class' => 'btn btn-danger', 'escape' => false), "Are you sure you wish to delete this category?"
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



