<div class="tab-pane active" id="step_1">


<form class="form-horizontal" enctype="multipart/form-data" action="#" method="post">
		<fieldset>
		    <div class="control-group">
			<label class="control-label" for="jobTitle">Job Title</label>
			<div class="controls">
			    <input class="input-xlarge focused" id="jobTitle" name="jobTitle" type="text" value="">
			</div>
		    </div>


			 <div class="control-group">
			<label class="control-label" for="job_description">Job Description</label>
			
		   		   <div class="controls">
			    <textarea class="cleditor" id="jobDescription" name="jobDescription" rows="3"></textarea>
			</div>
		    </div>


		    <div class="control-group">
			<label class="control-label" for="startDate">Start Date</label>
			<div class="controls">
			    <input type="text" class="input-xlarge datepicker" id="startDate" name="startDate" value="">
			</div>
		    </div>

		    <div class="control-group">
			<label class="control-label" for="expiryDate">Expiry Date</label>
			<div class="controls">
			    <input type="text" class="input-xlarge datepicker" id="expiryDate" name="expiryDate" value="">
			</div>
		    </div>



		    <div class="control-group">
			<label class="control-label" for="locations">Job Locations</label>
			<div class="controls">
			    <select id="locations" name="locations" data-rel="chosen">
				<?php
				foreach ($countries as $country):
				    ?>
    				<option value="<?php echo $country['countries']['id']; ?>">
					<?php echo $country['countries']['name']; ?>
    				</option>
				<?php endforeach; ?>
			    </select>
			</div>
		    </div>


			<div class="control-group">
			<label class="control-label" for="city">City</label>
			<div class="controls">
			    <input type="text" id="city" name="city" >
				
			</div>
		    </div>



		<div class="control-group">
			<label class="control-label" for="employmentType">Employment Type</label>
			<div class="controls">
			    <select id="employmentType" name="employmentType" >							
					<option value="0"> - Unspecified - </option>
					<option value="1">Part Time</option>
					<option value="2">Full Time</option>
					<option value="3">Contractor</option>
					<option value="4">Internship</option>
					<option value="5">Temporary Employee</option>		
			    </select>
			</div>
		    </div>




			<div class="control-group">
			<label class="control-label" for="vacancies">Number of Vacancies</label>
			<div class="controls">
			    <select id="vacancies" name="vacancies">
				<?php
				for($i=1; $i<=100; $i++){
				    ?>
    				<option value="<?php echo $i; ?>">
					<?php echo $i; ?>
    				</option>
				<?php } ?>
			    </select>
			</div>
		    </div>


			<div class="control-group">
			<label class="control-label" for="manages">Manages Others</label>
			<div class="controls">
			   <input data-no-uniform="true" id="manages" name="manages" type="checkbox" class="iphone-toggle">
			</div>
		    </div>
		   
		   


		   
		    <div class="control-group">
			<div class="controls" style="text-align:right;">
			    <button type="button" class="btn btn-primary">Next &rarr;</button>
			    
			</div>
		    </div>

		</fieldset>
	    </form>
</div>