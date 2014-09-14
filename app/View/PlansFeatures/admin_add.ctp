<div>
    <ul class="breadcrumb">
	<li>
	    <a href="#">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="#">Plan Features</a>
	</li>
    </ul>
</div>

<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-edit"></i> Add New Plan Feature</h2>
	    <div class="box-icon">
		<a title="List" href="<?php echo $this->request->webroot; ?>admin/plans_features/" style="width:25px;"><img alt="Add" src="/alaxos/img/toolbar/list.png"></a>
	    </div>
	</div>


	<div class="box-content"><br/>
	    <form class="form-horizontal" enctype="multipart/form-data" action="#" method="post">
		<fieldset>
		    <div class="control-group">
			<label class="control-label" for="title">Feature Name</label>
			<div class="controls">
			    <input class="input-xlarge focused" id="title" name="title" type="text" value="">
			</div>
		    </div>	

			<div class="control-group">
			<label class="control-label" for="type">Feature For</label>
			<div class="controls">
			     <select id="type" name="type" >			
    				<option value="jobseekers">Jobseekers</option>
					<option value="recruiters">Recruiters</option>
				
			    </select>
			</div>
		    </div>		

			<div class="control-group">
			<label class="control-label" for="description">Description</label>
			
		   		   <div class="controls">
			    <textarea id="description" name="description" ></textarea>
			</div>
		    </div>

		    <div class="control-group">
			<div class="controls">			    
				<button type="submit" class="btn btn-primary" name="create" value="plan" id="plan">Save</button>
			    <button type="reset" class="btn">Cancel</button>
			</div>
		    </div>

		</fieldset>
	    </form>
	</div>


    </div>
</div>





