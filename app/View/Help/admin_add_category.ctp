<div>
    <ul class="breadcrumb">
	<li>
	    <a href="/admin">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="/admin/help">Help Section</a>
	</li>
    </ul>
</div>

<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-edit"></i>Add Category</h2>
	    <div class="box-icon">
		<a title="List" href="<?php echo $this->request->webroot; ?>admin/help/" style="width:25px;"><img alt="Add" src="<?php echo $this->request->webroot; ?>alaxos/img/toolbar/list.png"></a>
	    </div>
	</div>


	<div class="box-content"><br/>
            <form class="form-horizontal" name="form" action="/admin/help/addCategory" method="post">
		<fieldset>




		    <div class="control-group">
			<label class="control-label" for="category_name">Category</label>
			<div class="controls">
			    <input class="input-xlarge focused" id="selectComapny" name="category_name" type="text" value="">
			</div>
		    </div>

		    <div class="control-group">
			<div class="controls">
			    <button type="submit" class="btn btn-primary">Save</button>
			</div>
		    </div>

		</fieldset>
	    </form>
	</div>


    </div>
</div>





