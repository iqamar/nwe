

<div id="step_1">
 

<form class="form-horizontal" enctype="multipart/form-data" action="#" method="post">
		<fieldset>
				The fields marked with <span style="color:#FF0000;font-weight: 800;">*</span> are mandatory
			<div class="control-group">
			<div class="controls" style="text-align:right;">
					<button type="button" class="btn btn-success btn-primary" onclick="jobsAction('save');">Save</button>	
					<button type="button" class="btn btn-primary" onclick="jobsAction('next');">Next &rarr;</button>			    
			</div>
		    </div>
		

		    <div class="control-group">
			<label class="control-label" for="jobTitle">Job Title <span style="color:#FF0000;font-weight: 800;">*</span></label>
			<div class="controls">
			    <input class="input-xlarge focused" id="jobTitle" name="jobTitle" type="text" value="">
			</div>
		    </div>


			 <div class="control-group">
			<label class="control-label" for="job_description">Job Description <span style="color:#FF0000;font-weight: 800;">*</span></label>
			
		   		   <div class="controls">
			    <textarea class="cleditor" id="jobDescription" name="jobDescription" rows="3"></textarea>
			</div>
		    </div>


		    <div class="control-group">
			<label class="control-label" for="startDate">Start Date <span style="color:#FF0000;font-weight: 800;">*</span></label>
			<div class="controls">
			    <input type="text" class="input-xlarge datepicker" id="startDate" name="startDate" value="">
			</div>
		    </div>

		    <div class="control-group">
			<label class="control-label" for="expiryDate">Expiry Date <span style="color:#FF0000;font-weight: 800;">*</span></label>
			<div class="controls">
			    <input type="text" class="input-xlarge datepicker" id="expiryDate" name="expiryDate" value="">
			</div>
		    </div>

		    <div class="control-group">
			<label class="control-label" for="locations">Job Country <span style="color:#FF0000;font-weight: 800;">*</span></label>
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
			<label class="control-label" for="city">City <span style="color:#FF0000;font-weight: 800;">*</span></label>
			<div class="controls">
			    <input type="text" id="city" name="city" >
				
			</div>
		    </div>



		<div class="control-group">
			<label class="control-label" for="employmentType">Employment Type <span style="color:#FF0000;font-weight: 800;">*</span></label>
			<div class="controls">
			    <select id="employmentType" name="employmentType" >							
					<option value="Unspecified"> - Unspecified - </option>
					<option value="Part Time">Part Time</option>
					<option value="Full Time" selected>Full Time</option>
					<option value="Contractor">Contractor</option>
					<option value="Internship">Internship</option>
					<option value="Temporary Employee">Temporary Employee</option>		
			    </select>
			</div>
		    </div>

			<div class="control-group">
			<label class="control-label" for="vacancies">Number of Vacancies <span style="color:#FF0000;font-weight: 800;">*</span></label>
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
			<div class="controls" style="text-align:right;">					
				<button type="button" class="btn btn-success btn-primary" onclick="jobsAction('save');">Save</button>	
				<button type="button" class="btn btn-primary" onclick="jobsAction('next');">Next &rarr;</button>		    
			</div>
		    </div>

		</fieldset>
	    </form>
</div>