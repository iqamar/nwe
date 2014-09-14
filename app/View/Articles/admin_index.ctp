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
	    <h2><i class="icon-user"></i> Articles</h2>
	    <div class="box-icon">
		<a title="Add" href="<?php echo $this->request->webroot; ?>admin/articles/add" style="width:25px;"><img alt="Add" src="<?php echo $this->request->webroot; ?>alaxos/img/toolbar/add.png"></a>
	    </div>
	</div>
	<div class="box-content">
	    <table class="table table-striped table-bordered bootstrap-datatable datatable">
		<thead>
		    <tr>
			<th colspan="2">Article Title</th>
			<th>Category</th>
			<th>Author</th>
			<th>Created On</th>
			<th>Status</th>
			<th>Actions</th>
		    </tr>
		</thead>
		<tbody>


		    <?php
		    //echo "<pre>";
		    //print_r($countries);
		    foreach ($articles as $article):
			?>



    		    <tr>
    			<td>
				<?php echo '<img alt="logo" style="width:40px;" src="' . $this->request->webroot . 'files/articles_logo/' . $company['articles']['logo'] . '">'; ?>
    			</td>
    			<td>
				<?php echo $article['articles']['title']; ?>
    			</td>
    			<td>
				<?php echo $article['articles_categories']['title']; ?>
    			</td>
    			<td>
				<?php echo $article['users_profiles']['firstname']." ".$article['users_profiles']['lastname']; ?>
    			</td>


    			<td>
				<?php echo DateTool :: sql_to_date($article['articles']['created']); ?>
    			</td>


    			<td class="center">
				<?php
				if ($article['articles']['status'] == 1) {
				    echo '<span class="label label-success">Active</span>';
				} else if ($article['articles']['status'] == -2) {
				    echo '<span class="label label-important">Banned</span>';
				} else if ($article['articles']['status'] == -1) {
				    echo '<span class="label label-warning">Pending</span>';
				} else {
				    echo '<span class="label">In Active</span>';
				}
				?>
    			</td>


    			<td class="center" nowrap>
				<?php
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-zoom-in icon-white')) . " View", array('action' => 'view', $article['articles']['id']), array('class' => 'btn btn-success', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-edit icon-white')) . " Edit", array('action' => 'edit', $article['articles']['id']), array('class' => 'btn btn-info', 'escape' => false)
				);

				echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-trash icon-white')) . " Delete", array('action' => 'delete', $article['articles']['id']), array('class' => 'btn btn-danger', 'escape' => false), "Are you sure you wish to delete this article?"
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



