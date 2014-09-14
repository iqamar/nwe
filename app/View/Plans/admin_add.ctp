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
	    <h2><i class="icon-edit"></i> Add New Plan</h2>
	    <div class="box-icon">
		<a title="List" href="<?php echo $this->request->webroot; ?>admin/groups/" style="width:25px;"><img alt="Add" src="/alaxos/img/toolbar/list.png"></a>
	    </div>
	</div>


	<div class="box-content"><br/>
	    <form class="form-horizontal" enctype="multipart/form-data" action="#" method="post">
		<fieldset>
		    <div class="control-group">
			<label class="control-label" for="plan_name">Plan Name</label>
			<div class="controls">
			    <input class="input-xlarge focused" id="plan_name" name="plan_name" type="text" value="">
			</div>
		    </div>	

			<div class="control-group">
			<label class="control-label" for="plan_type">Plan For</label>
			<div class="controls">
			     <select id="plan_type" name="plan_type" >			
    				<option value="jobseekers">Jobseekers</option>
					<option value="recruiters">Recruiters</option>
				
			    </select>
			</div>
		    </div>	


	
			<div class="control-group">
			<label class="control-label" for="price">Monthly Price</label>
			
		   		   <div class="controls">
			    <input class="input-xlarge focused"  id="price" name="price" type="text" value="" >
			</div>
		    </div>


			<div class="control-group">
			<label class="control-label" for="yearly_discount_percentage">Yearly Discount (In Percentage)</label>
			
		   		   <div class="controls">
			    <input class="input-xlarge focused"  id="yearly_discount_percentage" name="yearly_discount_percentage" type="text" value="">
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





