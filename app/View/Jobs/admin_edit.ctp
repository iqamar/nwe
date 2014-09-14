<?php
echo $this->Html->script('jquery-1.9.1.js');
echo $this->Html->script('jquery.validate.min.js');
?>

<script type="text/javascript">
$(document).ready(function(){
    $("#salary_min").fadeOut('fast'); $("#salary_max").fadeOut('fast'); $("#salary_hourly").fadeOut('fast');
    $("#confidential_salary").change(function(){
        $("#salary_min").fadeOut('fast'); $("#salary_max").fadeOut('fast'); $("#salary_hourly").fadeOut('fast');
    });
    
    $("#yearly_salary").change(function(){
        $("#salary_min").fadeIn('fast');
        $("#salary_max").fadeIn('fast');
        $("#salary_hourly").fadeOut('fast');
    });
    
    $("#hourly_salary").change(function(){
        $("#salary_hourly").fadeIn('fast');
        $("#salary_min").fadeOut('fast');
        $("#salary_max").fadeOut('fast');
    });
    
    $("#auto_reply_apply").change(function(){
        $("#auto_reply_apply_text").toggle('fast');
    });
});
</script>

<script type="text/javascript">
/**
  * Basic jQuery Validation Form Demo Code
  * Copyright Sam Deering 2012
  * Licence: http://www.jquery4u.com/license/
  */
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#form_jobs").validate({
                rules: {
                    jobTitle: "required",
                    locations: "required",
                    city: "required",
                    startDate: "required",
                    expiryDate: "required",
                    min_exp: "required",
                    max_exp: "required",
                    job_description: "required",
                    vacancies: "required",
                    job_type: "required",
                    residence_locations: "required",
                    nationality: "required",

                    contactEmail: {
                        required: true,
                        email: true
                    }
                    
                },
                messages: {
                    jobTitle: "<font color='red'>Please define job title.</font>",
                    locations: "<font color='red'>Please choose country.</font>",
                    city: "<font color='red'>City is required</font>",
                    startDate: "<font color='red'>Please type start date.</font>",
                    expiryDate: "<font color='red'>Please type expiry date.</font>",
                    min_exp: "<font color='red'>Please type minimum experience.</font>",
                    max_exp: "<font color='red'>Please type maximum experience.</font>",
                    job_description: "<font color='red'>Job description needed.</font>",
                    vacancies: "<font color='red'>Please choose number of vacancies.</font>",
                    job_type: "<font color='red'>Please define job type.</font>",
                    residence_locations: "<font color='red'>Please choose residence location.</font>",
                    nationality: "<font color='red'>Please select nationality.</font>",
                    gender: "<font color='red'>Please choose gender.</font>",
                    contactEmail: "<font color='red'>Contact Email is needed.</font>"
                    
                },
                submitHandler: function(form) {
					
						skills_set_str ="";	
						if(skill_check[1]){skills_set_str = skills_set[0]["key"];} 
						if(skill_check[2]){if(skills_set_str == ""){skills_set_str = skills_set[1]["key"];}else{skills_set_str += "," + skills_set[1]["key"];}} 
						if(skill_check[3]){if(skills_set_str == ""){skills_set_str = skills_set[2]["key"];}else{skills_set_str += "," + skills_set[2]["key"];}} 
						if(skill_check[4]){if(skills_set_str == ""){skills_set_str = skills_set[3]["key"];}else{skills_set_str += "," + skills_set[3]["key"];}} 
						if(skill_check[5]){if(skills_set_str == ""){skills_set_str = skills_set[4]["key"];}else{skills_set_str += "," + skills_set[4]["key"];}} 

					$("#selectedSkills").val(skills_set_str);


                    form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);

</script>

<script type="text/javascript">

current_tab = 1;
current_job_id = 0;
var skills_set = new Array();
var skill_check = new Array();
skill_check[1] = false;
skill_check[2] = false; 
skill_check[3] = false;
skill_check[4] = false;
skill_check[5] = false;
<?php
$i=0;
foreach($skills as $skill){
?>
	skills_set[<?php echo $i;?>] = new Array();

	skills_set[<?php echo $i;?>]["key"] = "<?php echo $skill["jobs_skills"]["skill_id"];?>";
	skills_set[<?php echo $i;?>]["value"] = "<?php echo $skill["skills"]["title"];?>";


<?php
$i++;
?>

skill_check[<?php echo $i;?>] = true;

<?php

}
?>

function assignSkill(text, key){

	number = skills_set.length;
	if(number < 5 ){
		skills_set[number] = new Array();
		
	}else{
		if(!(skill_check[1])){number = 0;}
		if(!(skill_check[2])){number = 1;}
		if(!(skill_check[3])){number = 2;}
		if(!(skill_check[4])){number = 3;}
		if(!(skill_check[5])){number = 4;}
	}
	skills_set[number]["key"] = key;
	skills_set[number]["text"] = text;
	number++;
	$("#skill_"+number).html(text);
	$("#skill_box_"+number).show();
	$("#ajaxSkills").hide(); 
	$("#skills").val("");
	skill_check[number] = true; 
	
}

function removeSkill(id){

	skill_check[id] =false;
	$("#skill_box_"+id).hide();
}

function fetchSkills(value){
	number = skills_set.length;
        
	if(number >=5 ){
		if(skill_check[1] && skill_check[2] && skill_check[3] && skill_check[4] && skill_check[5]){
			alert("You can only add 5 skills!");
			return;
		}

	}
	if(value.length < 3){
		return;
	}

	var postData = {"search_str":value};
	$.ajax({
type: "GET",
url: "/users_profiles/search_skill",
data: postData 
})
.done(function( data ) {
$("#ajaxSkills").html(data);
$("#ajaxSkills").show();
});

//$("auto_reply_apply").click(function(){
//    if($("auto_reply_apply").checked){
//        $("#email_text").css("visibility", "visible");
//    }
//    else{
//        $("#email_text").css("visibility", "hidden");
//    }
//});   

}
</script>

<script type="text/javascript">
//$(document).ready(function(){
//    $("#uniform-auto_reply_apply").change(function(){
//        if(this.checked)
//            $("#email_text").fadeIn();
//        else
//            $("#email_text").fadeOut();
//    });
//});
</script>

<div class="row-fluid sortable">
    <div class="box span12">
		<div class="box-header well" data-original-title>
		    <h2><i class="icon-edit"></i> Add New Job</h2>
		    <div class="box-icon">
                        <a title="List" href="/admin/jobs/" style="width:25px;"><img alt="Add" src="/alaxos/img/toolbar/list.png"></a>
		    </div>
		</div>
		<div class="box-content">  

	
 

                    <form class="form-horizontal" enctype="multipart/form-data" action="#" id="form_jobs" method="post">
		<fieldset>
				The fields marked with <span style="color:#FF0000;font-weight: 800;">*</span> are mandatory
			<div class="control-group">
			<div class="controls" style="text-align:right;">
<!--					<button type="button" class="btn btn-success btn-primary" onclick="jobsAction('save');">Save</button>	
					<button type="button" class="btn btn-primary" onclick="jobsAction('next');">Next &rarr;</button>	-->
<!--				<input type="button" class="btn btn-success btn-primary" onclick="jobsValidations('save');" value="Save">-->
<input type="submit" class="btn btn-success btn-primary" value="Save">
				<input type="button" class="btn btn-primary" onclick="document.location='/admin/jobs/';" value="Cancel">
                        
                        </div>
		    </div>
		


				<div class="control-group">
					<label class="control-label" for="jobTitle">Job Title <span style="color:#FF0000;font-weight: 800;">*</span></label>
					<div class="controls">
					    <input class="input-xlarge focused" id="jobTitle" name="jobTitle" type="text" value="<?=$jobs['jobs']['title']?>">
					</div>
			    </div>








<div class="control-group">
				<label class="control-label" for="functional_area">Functional Areas</label>
				<div class="controls">
					 <select id="functional_area" name="functional_area" data-rel="chosen" >
						<?php
				foreach ($functional_areas as $farea):
				    ?>
    				<option value="<?php echo $farea['functional_areas']['id']; ?>">
					<?php echo $farea['functional_areas']['title']; ?>
    				</option>
				<?php endforeach; ?>
			    </select>



					
				
				
				</div>				
		    </div>




<div class="control-group">
				<label class="control-label" for="industries">Industries</label>
				<div class="controls">
					
					
					<select id="industries" name="industries" data-rel="chosen" >
						<?php
				foreach ($industries as $industry):
				    ?>
    				<option value="<?php echo $industry['industries']['id']; ?>">
					<?php echo $industry['industries']['title']; ?>
    				</option>
				<?php endforeach; ?>
			    </select>
				
				</div>				
		    </div>


<div class="control-group">
				<label class="control-label" for="job_type">Job Type <span style="color:#FF0000;font-weight: 800;">*</span></label>
				<div class="controls">
					
					
					<select id="job_type" name="job_type" data-rel="chosen" >
					<option value="">- Select one -</option>
					<option value="1" <?php if($jobs['jobs']['job_type'] == 1) echo "selected" ?>>Full-time</option>
					<option value="2" <?php if($jobs['jobs']['job_type'] == 2) echo "selected" ?>>Contract</option>
					<option value="3" <?php if($jobs['jobs']['job_type'] == 3) echo "selected" ?>>Part-time</option>
					<option value="4" <?php if($jobs['jobs']['job_type'] == 4) echo "selected" ?>>Freelance</option>
					<option value="5" <?php if($jobs['jobs']['job_type'] == 5) echo "selected" ?>>Moonlighting</option>
					<option value="6" <?php if($jobs['jobs']['job_type'] == 6) echo "selected" ?>>Internship</option>
			    </select>
				
				</div>				
		    </div>


                                
				 <div class="control-group">
			<label class="control-label" for="locations">Job Country <span style="color:#FF0000;font-weight: 800;">*</span></label>
			<div class="controls">
			    <select id="locations" name="locations" data-rel="chosen" style="width:150px;">
				 
				<?php
				foreach ($countries as $country):
				    ?>
    				<option value="<?php echo $country['countries']['id']; ?>" <?php if($sCountry['countries']['id'] == $country['countries']['id']) echo "selected"; ?>>
					<?php echo $country['countries']['name']; ?>
    				</option>
				<?php endforeach; ?>
			    </select> <input type="text" id="city" name="city" style="width:150px;margin-top: -20px;" placeholder="city" value="<?=$jobs['jobs']['city']?>" >
			</div>
		    </div>


			<div class="control-group">
			
			<div class="controls">
			   <label class="checkbox" style="margin-left: -20px;">
                  <input type="checkbox" id="relocation" name="relocation" value="1" <?php if($jobs['jobs']['relocation_assistance'] == 1) echo "checked" ?>>
						Relocation assistance offered for this position
			   		</label>
					<label class="checkbox" style="margin-left: -20px;">
					<input type="checkbox" id="remote_work" name="remote_work" value="1" <?php if($jobs['jobs']['work_anywhere'] == 1) echo "checked" ?>>
						Work can be done from anywhere (i.e. telecommuting)
			   		</label>
 
 

				
			</div>
		    </div>



			<div class="control-group">
			<label class="control-label" for="startDate">Choose Timeframe<span style="color:#FF0000;font-weight: 800;">*</span></label>
			<div class="controls">
			    <input style="width:125px;" type="text" class="input-xlarge datepicker" id="startDate" name="startDate" value="<?php echo date("m/d/Y", strtotime($jobs['jobs']['start_date']));?>" readonly>
				&nbsp;&nbsp;&nbsp;
				<input style="width:125px;" type="text" class="input-xlarge datepicker" id="expiryDate" name="expiryDate" value="<?php echo date("m/d/Y", strtotime($jobs['jobs']['expiry_date']));?>" readonly>
			</div>
		    </div>


			<div class="control-group">
			<label class="control-label" for="vacancies">Number of Vacancies <span style="color:#FF0000;font-weight: 800;">*</span></label>
			<div class="controls">
			    <select id="vacancies" name="vacancies">
				<?php
				for($i=1; $i<=100; $i++){
				    ?>
    				<option value="<?php echo $i; ?>" <?php if($jobs['jobs']['vacancies'] == $i) echo "selected"?>>
					<?php echo $i; ?>
    				</option>
				<?php } ?>
			    </select>
			</div>
		    </div>


		  
		   

<div class="control-group">
			<label class="control-label" for="job_description">Job Description <span style="color:#FF0000;font-weight: 800;">*</span></label>
			
		   		   <div class="controls">
			    <textarea class="cleditor" id="jobDescription" name="job_description" rows="3"><?=$jobs['jobs']['description']?></textarea>
			</div>
		    </div>




		
  <div class="control-group">
			<label class="control-label" for="min_exp">Years of Experience <span style="color:#FF0000;font-weight: 800;">*</span></label>
			<div class="controls">
			   <select name="min_exp" style="width:125px;" id="Jobs_jobMinExperience">
                               
					
                                        <?php
                                        for($i=0; $i<20; $i++){
                                        ?>
                                        <option value="<?=$i?>" <?php if($jobs['jobs']['min_experience']==$i) echo "selected"?>><?=$i?></option>
                                        <?php
                                        }
                                        ?>

				</select>


				<select name="max_exp" style="width:125px;" id="Jobs_jobMaxExperience">
                                    <?php
                                        for($i=0; $i<20; $i++){
                                        ?>
                                        <option value="<?=$i?>" <?php if($jobs['jobs']['max_experience']==$i) echo "selected"?>><?=$i?></option>
                                        <?php
                                        }
                                        ?>
				</select>
		</div>
		</div>




				<div class="control-group">
			<label class="control-label" for="career_level">Career Level</label>
			<div class="controls">
			    <select id="career_level" name="career_level" >											
					<option <?php if($jobs['jobs']['career_level'] == 0) echo "selected";?> value="0">- Select one -</option>
					<option <?php if($jobs['jobs']['career_level'] == 1) echo "selected";?> value="1">Entry Level</option>
					<option <?php if($jobs['jobs']['career_level'] == 2) echo "selected";?> value="2">Student/Internship</option>
					<option <?php if($jobs['jobs']['career_level'] == 3) echo "selected";?> value="3">Mid Career</option>
					<option <?php if($jobs['jobs']['career_level'] == 4) echo "selected";?> value="4">Management</option>
					<option <?php if($jobs['jobs']['career_level'] == 5) echo "selected";?> value="5">Executive/Director</option>
					<option <?php if($jobs['jobs']['career_level'] == 6) echo "selected";?> value="6">Senior Executive (President, CEO)</option>
			    </select>
			</div>
		</div>

<div class="control-group">
			<label class="control-label" for="manage_others">Manages Others</label>
			<div class="controls">
                            <input data-no-uniform="true" id="manages" name="manage_others" type="checkbox" class="iphone-toggle" value="1" <?php if($jobs['jobs']['manages_team'] == 1) echo "checked";?>>
			</div>
		    </div>


		 <div class="control-group">
			<label class="control-label" for="qualifications">Qualifications </label>
			<div class="controls">
                            <input type="text" id="qualifications" name="qualifications" style="width:250px;" placeholder="add comma separated qualifications" value="<?=$jobs['jobs']['qualifications']?>" >
			    <!--<select data-placeholder="Set Qualifications" id="qualifications" name="qualifications"  data-rel="chosen">
				<option value=""></option>
				<?php
//				$optiongroup = "-1";
//				foreach ($qualifications as $qualification):
//				    if ($optiongroup != $qualification['qualifications']['priority']) {
//					if ($optiongroup != "-1") {
//					    echo "</optgroup>";
//					}
//					echo '<optgroup label="' . $qualification['qualifications']['type'] . '">';
//					$optiongroup = $qualification['qualifications']['priority'];
//				    }
//				    ?>
    				<option value="<?php echo $qualification['qualifications']['qualification_id']; ?>">
					<?php //echo $qualification['qualifications']['title']; ?>
    				</option>
				//<?php //endforeach; ?>



				</optgroup>

			    </select>-->
			</div>
		    </div>



			<div class="control-group">
			<label class="control-label" >Salary</label>
			<div class="controls">

				<label class="radio" style="margin-left: -20px;">				  
                                    <input type="radio" name="salary_mode" id="confidential_salary" value="0" <?php if($jobs['jobs']['salary_mode'] == 0) echo "checked"; ?>>
						<strong>Confidential</strong>						
				</label>
				<div style="clear:both"></div>
				 <label class="radio" style="margin-left: -20px;padding-top:20px;">
                                     <input type="radio" name="salary_mode" id="yearly_salary" value="1" <?php if($jobs['jobs']['salary_mode'] == 1) echo "checked"; ?>>
						<strong>Yearly</strong>
				 </label>
                                <select id="salary_min" name="min_salary">
                                    <option value="<?=$jobs['jobs']['min_salary']?>"><?=number_format($jobs['jobs']['min_salary'], 0, '.', ',')?></option>
								<option value="-1">Min</option><option value="49999">Less than 50000</option><option value="50000">50,000</option><option value="60000">60,000</option><option value="70000">70,000</option><option value="80000">80,000</option><option value="90000">90,000</option><option value="100000">1,00,000</option><option value="125000">1,25,000</option><option value="150000">1,50,000</option><option value="175000">1,75,000</option><option value="200000">2,00,000</option><option value="225000">2,25,000</option><option value="250000">2,50,000</option><option value="275000">2,75,000</option><option value="300000">3,00,000</option><option value="325000">3,25,000</option><option value="350000">3,50,000</option><option value="375000">3,75,000</option><option value="400000">4,00,000</option><option value="425000">4,25,000</option><option value="450000">4,50,000</option><option value="475000">4,75,000</option><option value="500000">5,00,000</option><option value="550000">5,50,000</option><option value="600000">6,00,000</option><option value="650000">6,50,000</option><option value="700000">7,00,000</option><option value="750000">7,50,000</option><option value="800000">8,00,000</option><option value="850000">8,50,000</option><option value="900000">9,00,000</option><option value="950000">9,50,000</option><option value="1000000">10,00,000</option><option value="1100000">11,00,000</option><option value="1200000">12,00,000</option><option value="1300000">13,00,000</option><option value="1400000">14,00,000</option><option value="1500000">15,00,000</option><option value="1600000">16,00,000</option><option value="1700000">17,00,000</option><option value="1800000">18,00,000</option><option value="1900000">19,00,000</option><option value="2000000">20,00,000</option><option value="2250000">22,50,000</option><option value="2500000">25,00,000</option><option value="2750000">27,50,000</option><option value="3000000">30,00,000</option><option value="3250000">32,50,000</option><option value="3500000">35,00,000</option><option value="3750000">37,50,000</option><option value="4000000">40,00,000</option><option value="4500000">45,00,000</option><option value="5000000">50,00,000</option><option value="10000000">50,00,000 &amp; above</option>							
							</select>
                                <select id="salary_max" name="max_salary">
                                    <option value="<?=$jobs['jobs']['max_salary']?>"><?=number_format($jobs['jobs']['max_salary'], 0, '.', ',')?></option>
								<option value="-1">Min</option><option value="49999">Less than 50000</option><option value="50000">50,000</option><option value="60000">60,000</option><option value="70000">70,000</option><option value="80000">80,000</option><option value="90000">90,000</option><option value="100000">1,00,000</option><option value="125000">1,25,000</option><option value="150000">1,50,000</option><option value="175000">1,75,000</option><option value="200000">2,00,000</option><option value="225000">2,25,000</option><option value="250000">2,50,000</option><option value="275000">2,75,000</option><option value="300000">3,00,000</option><option value="325000">3,25,000</option><option value="350000">3,50,000</option><option value="375000">3,75,000</option><option value="400000">4,00,000</option><option value="425000">4,25,000</option><option value="450000">4,50,000</option><option value="475000">4,75,000</option><option value="500000">5,00,000</option><option value="550000">5,50,000</option><option value="600000">6,00,000</option><option value="650000">6,50,000</option><option value="700000">7,00,000</option><option value="750000">7,50,000</option><option value="800000">8,00,000</option><option value="850000">8,50,000</option><option value="900000">9,00,000</option><option value="950000">9,50,000</option><option value="1000000">10,00,000</option><option value="1100000">11,00,000</option><option value="1200000">12,00,000</option><option value="1300000">13,00,000</option><option value="1400000">14,00,000</option><option value="1500000">15,00,000</option><option value="1600000">16,00,000</option><option value="1700000">17,00,000</option><option value="1800000">18,00,000</option><option value="1900000">19,00,000</option><option value="2000000">20,00,000</option><option value="2250000">22,50,000</option><option value="2500000">25,00,000</option><option value="2750000">27,50,000</option><option value="3000000">30,00,000</option><option value="3250000">32,50,000</option><option value="3500000">35,00,000</option><option value="3750000">37,50,000</option><option value="4000000">40,00,000</option><option value="4500000">45,00,000</option><option value="5000000">50,00,000</option><option value="10000000">50,00,000 &amp; above</option>							
							</select>
				<div style="clear:both;"></div>
				 
				  <label class="radio" style="margin-left: -20px;padding-top:20px;">
                                      <input type="radio" name="salary_mode" id="hourly_salary" value="2" <?php if($jobs['jobs']['salary_mode'] == 2) echo "checked"; ?>>
						 <strong>Hourly</strong>
				</label>
                                <input type="text" id="salary_hourly" name="hourly_salary" style="width:150px;" placeholder="hourly rate" value="<?=$jobs['jobs']['hourly_salary']?>" >
				  



		
			</div>
		    </div>




				
				<div class="control-group">
				<label class="control-label" for="nationality">Nationality <span style="color:#FF0000;font-weight: 800;">*</span></label>
				<div class="controls">
			    <select id="nationality" name="nationality">
				<?php
				foreach ($countries as $country):
				    ?>
    				<option value="<?php echo $country['countries']['id']; ?>" <?php if($country['countries']['id'] == $jobs['jobs']['nationality']) echo "selected" ?>>
					<?php echo $country['countries']['name']; ?>
    				</option>
				<?php endforeach; ?>
			    </select>
				</div>
		    </div>

			<div class="control-group">
			<label class="control-label" for="min_age">Age </label>
			<div class="controls">
			    <select name="min_age" style="width:125px;" id="Jobs_jobAgeMin">
                                					
					<?php
                                        for($i=18; $i<65; $i++){
                                        ?>
                                        <option value="<?=$i?>" <?php if($jobs['jobs']['min_age']==$i) echo "selected";?>><?=$i?></option>
                                        <?php
                                        }
                                        ?>
				</select>

				<select name="max_age" style="width:125px;" id="Jobs_jobAgeMax">
					<?php
                                        for($i=18; $i<65; $i++){
                                        ?>
                                        <option value="<?=$i?>" <?php if($jobs['jobs']['max_age']==$i) echo "selected";?>><?=$i?></option>
                                        <?php
                                        }
                                        ?>
				</select>


			</div>
		</div>


		



		<div class="control-group">
			<label class="control-label" for="gender">Gender</label>
			<div class="controls">			    										
				<select name="gender" id="Jobs_jobGender">
					<option value="Any" <?php if($jobs['jobs']['gender'] == "Any") echo "selected";?>>Any</option>
					<option value="Male" <?php if($jobs['jobs']['gender'] == "Male") echo "selected";?>>Male</option>
					<option value="Female" <?php if($jobs['jobs']['gender'] == "Female") echo "selected";?>>Female</option>
                                        
			    </select>
			</div>
		</div>


<div class="control-group">
				<label class="control-label" for="residence_locations">Residence Location <span style="color:#FF0000;font-weight: 800;">*</span></label>
				<div class="controls">
			    <select id="residence_locations" name="residence_locations">
				<?php
				foreach ($countries as $country):
				    ?>
    				<option value="<?php echo $country['countries']['id']; ?>" <?php if($country['countries']['id'] == $jobs['jobs']['residence']) echo "selected" ?>>
					<?php echo $country['countries']['name']; ?>
    				</option>
				<?php endforeach; ?>
			    </select>
				</div>
		    </div>


			<input type="hidden" name="selectedSkills" id="selectedSkills" value="">
			<div class="control-group">
			  <label class="control-label" >Skills <span style="color:#FF0000;font-weight: 800;">*</span></label>
			  <div class="controls">  				
					<input type="text"  id="skills" onKeyUp="fetchSkills(this.value);" placeholder="Start typing to activate auto complete!">
			
				<div style="margin-top:20px;width: 300px;">
                                                <?php
                                                $i = 1;
                                                foreach($skills as $skill){
//                                                    echo "<hr/>".$skill["jobs_skills"]["skill_id"]."---".$skill["skills"]["title"];

													echo '<div class="alert alert-success" id="skill_box_'.$i.'" style="margin-bottom: 3px;padding: 2px 35px 2px 14px;">'.
														'<button class="close" type="button" onclick="removeSkill('.$i.');">x</button>'.
														'<span id="skill_'.$i.'">'.$skill["skills"]["title"].'</span>'.
														'</div>';
													$i++;

   												}	
												for($k=$i;$k<=5;$k++){

													echo '<div class="alert alert-success" id="skill_box_'.$k.'" style="display:none;margin-bottom: 3px;padding: 2px 35px 2px 14px;">'.
															'<button class="close" type="button" onclick="removeSkill('.$k.');">x</button>'.
															'<span id="skill_'.$k.'"></span>'.
														'</div>';
												}	
                                                ?>
                                                    
                                   
<!--						<div class="alert alert-success" id="skill_box_1" style="display:none;margin-bottom: 3px;padding: 2px 35px 2px 14px;">
							<button class="close" type="button" onclick="removeSkill(1);">x</button>
							<span id="skill_1"></span>
						</div>
							<div class="alert alert-success" id="skill_box_2" style="display:none;margin-bottom: 3px;padding: 2px 35px 2px 14px;">
							<button class="close" type="button" onclick="removeSkill(2);">x</button>
							<span id="skill_2"></span>
						</div>

							<div class="alert alert-success" id="skill_box_3" style="display:none;margin-bottom: 3px;padding: 2px 35px 2px 14px;">
							<button class="close" type="button" onclick="removeSkill(3);">x</button>
							<span id="skill_3"></span>
						</div>
							<div class="alert alert-success" id="skill_box_4" style="display:none;margin-bottom: 3px;padding: 2px 35px 2px 14px;">
							<button class="close" type="button" onclick="removeSkill(4);">x</button>
							<span id="skill_4"></span>
						</div>
							<div class="alert alert-success" id="skill_box_5" style="display:none;margin-bottom: 3px;padding: 2px 35px 2px 14px;">
							<button class="close" type="button" onclick="removeSkill(5);">x</button>
							<span id="skill_5"></span>
						</div>-->

				 	

	
					 
					
				</div>
			  </div>
			</div>

	
 
			

			



		<div class="control-group">
				<label class="control-label" for="confidentiality">Confidentiality</label>
				<div class="controls">
					<label class="checkbox inline" style="margin-left: -20px;">
					<input type="checkbox" id="confidentiality" name="confidentiality" value="1" <?php if($jobs['jobs']['confidentiality'] == 1) echo "checked" ?>>
					Hide company name when this job is viewed online
			   		</label>
				</div>				
			    </div>

				<div class="control-group">
					<label class="control-label" >Email Setting</label>
					<div class="controls">	
					<label class="radio" style="margin-left: -20px;">				  
						<input type="radio" name="email_setting" id="email_setting1" value="0" <?php if($jobs['jobs']['apply_notification'] == 0) echo "checked" ?>>
						Do not email me
						<p class="help-block" style="margin:-10px 0px 10px 80px">No notifications will be e-mailed to you regarding job applications; you will check your Workspace for new applicants.</p>
					 </label>
					  <div style="clear:both"></div>
					  <label class="radio" style="margin-left: -20px;">
						<input type="radio" name="email_setting" id="email_setting2" value="1" <?php if($jobs['jobs']['apply_notification'] == 1) echo "checked" ?>>
						Email me the daily count of new applicants
						<p class="help-block" style="margin:-10px 0px 10px 80px">The total number of new applicants for each day will be e-mailed to you on a daily basis. You can also check your Workspace for new applicants.</p>
					  </label>
					  <label class="radio" style="margin-left: -20px;">
						<input type="radio" name="email_setting" id="email_setting3" value="2" <?php if($jobs['jobs']['apply_notification'] == 2) echo "checked" ?>>
						 Email me CVs of new applicants
						<p class="help-block" style="margin:-10px 0px 10px 80px">Each applicant's CV will be e-mailed directly to you as they apply. You can also check your Workspace for new applicants.</p>
					  </label>
					</div>
			</div>


		


				<div class="control-group">

				<div class="controls">
					<label class="checkbox inline" style="margin-left: -20px;">
                                            <input type="checkbox" id="auto_reply_apply" name="auto_reply_apply" value="1" <?php if($jobs['jobs']['auto_reply_apply'] == 1) echo "checked" ?>>
					Automatically send "Application Received" email to applicants
			   		</label>
				</div>				
		    </div>
    <div class="control-group" id="email_text" style="//visibility: hidden;">
					<label class="control-label" for="auto_reply_apply-text">Email Text</label>
					<div class="controls">	
					<label class="radio">				  
						<textarea style="width:300px;" id="auto_reply_apply_text" name="auto_reply_apply_text" rows="8" cols="80" <?php if($jobs['jobs']['auto_reply_apply'] == 1) echo "style='visibility: hidden;'" ?>>Dear [NAME_OF_CANDIDATE]

Thank you for applying to the [JOB_TITLE] vacancy we have posted on networkwe.com.

We have received your application and will be reviewing it shortly.

Please bear with us while we diligently screen the applications. We will contact you to take things further should your qualifications match our requirements.

Best regards
The [COMPANY_NAME] team
						</textarea>						
					 </label>					  
					</div>
			</div>


			<div class="control-group">
			<label class="control-label" for="conatctPerson">Contact Person</label>
			<div class="controls">
			    <input class="input-xlarge focused" id="conatctPerson" name="contactPerson" type="text" value="<?=$jobs['jobs']['contact_person']?>">
			</div>
		    </div>

			<div class="control-group">
			<label class="control-label" for="contactEmail">Email Address <span style="color:#FF0000;font-weight: 800;">*</span></label>
			<div class="controls">
			    <input class="input-xlarge focused" id="contactEmail" name="contactEmail" type="text" value="<?=$jobs['jobs']['contact_email']?>">
			</div>
		    </div>

			<div class="control-group">
			<label class="control-label" for="contactNumber">Contact Number</label>
			<div class="controls">
			    <input class="input-xlarge focused" id="contactNumber" name="contactNumber" type="text" value="<?=$jobs['jobs']['contact_number']?>">
			</div>
		    </div>

		

		   
		    <div class="control-group">
			<div class="controls" style="text-align:right;">					
<!--				<button type="button" class="btn btn-success btn-primary" onclick="jobsAction('save');">Save</button>	
				<button type="button" class="btn btn-primary" onclick="jobsAction('next');">Next &rarr;</button>		    -->
			
<input type="submit" class="btn btn-success btn-primary" value="Save">
                        <input type="button" class="btn btn-primary" onclick="document.location='/admin/jobs/';" value="Cancel">
                        </div>
		    </div>

		</fieldset>
	    </form>







	    
		</div>


    </div>
</div>




<div style="display:none;background: none repeat scroll 0 0 #F1F1F1;box-shadow: 1px 10px 10px 10px;  top: 1395px;padding-left: 30px; position: absolute; left: 425px;width: 190px;" id="ajaxSkills" >



</div>


