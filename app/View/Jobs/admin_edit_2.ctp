<?php
//echo "<pre>";
//print_r($jobs);
//echo "</pre>";
echo $this->Html->script('jquery-1.9.1.js');
echo $this->Html->script('jquery.validate.min.js');
?>

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
                    jobTitle: "Please define job title.",
                    locations: "Please choose country.",
                    city: "City is required",
                    startDate: "Please type start date.",
                    expiryDate: "Please type expiry date.",
                    min_exp: "Please type minimum experience.",
                    max_exp: "Please type maximum experience.",
                    job_description: "Job description needed.",
                    vacancies: "Please choose number of vacancies.",
                    job_type: "Please define job type.",
                    residence_locations: "Please choose residence location.",
                    nationality: "Please select nationality.",
                    gender: "Please choose gender.",
                    contactEmail: "Contact Email is needed."    
                    
                },
                submitHandler: function(form) {
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


//function jobsValidations(){		
//	
//		var jobTitle = $("#jobTitle").val();
//		var jobDescription = $("#jobDescription").val();
//		var startDate = $("#startDate").val();
//		var expiryDate = $("#expiryDate").val();
//		var locations = $("#locations").val();
//		var city = $("#city").val();
//		var employmentType = $("#employmentType").val();
//		var vacancies = $("#vacancies").val();
//
//		if((jobTitle == "") || (jobTitle == " ")){alert("Title must be filled out"); return false;}			
//		if((jobDescription == "") || (jobDescription == " ")){alert("Description must be filled out"); return false;}
//		if((startDate == "") || (startDate == " ")){alert("Start date must be filled out"); return false;}
//		if((expiryDate == "") || (expiryDate == " ")){alert("Expiry date must be filled out"); return false;}
//		if((locations == "") || (locations == " ")){alert("Country must be filled out"); return false;}
//		if((city == "") || (city == " ")){alert("City must be filled out"); return false;}
//		if((employmentType == "") || (employmentType == " ")){alert("Employment type must be filled out"); return false;}
//		if((vacancies == "") || (vacancies == " ")){alert("Number of vacancies must be filled out"); return false;}
//
//		
//		if(!(skill_check[1] || skill_check[2] || skill_check[3] || skill_check[4] || skill_check[5])||(skills_set.length == 0)){	
//			alert("At least one skill must be selected"); $("#skills").focus(); return false;
//			return false;
//		}	
//		
//		var experienceMin = $("#Jobs_jobMinExperience").val();
//		var experienceMax = $("#Jobs_jobMaxExperience").val();
//		var qualifications = $("#qualifications").val();
// 
//
//		var manages = "";
//
//		if ($('#manages').is(':checked')){
//
//			manages = 1;
//		}
//
//
//		var residence_locations = $("#residence_locations").val();
//		var nationality = $("#nationality").val();
//		var gender = $("#Jobs_jobGender").val();
//		var ageMin = $("#Jobs_jobAgeMin").val();
//		var ageMax = $("#Jobs_jobAgeMax").val();
//
//		if((experienceMin == "") || (experienceMin == " ")){alert("Minimum experience must be filled out"); $("#Jobs_jobMinExperience").focus(); return false;}			
//		if((experienceMax == "") || (experienceMax == " ")){alert("Maximum experience must be filled out"); $("#Jobs_jobMaxExperience").focus(); return false;}			
//		//if(experienceMin > experienceMax){alert("Minimum experience must be less than maximum experience"); $("#Jobs_jobMinExperience").focus(); return false;}			
//		
//		if((residence_locations == "") || (residence_locations == " ")){alert("Candidate residence country must be filled out"); $("#residence_locations").focus(); return false;}
//		if((nationality == "") || (nationality == " ")){alert("Candidate nationality must be filled out"); $("#nationality").focus(); return false;}
//		skills_set_str ="";	
//		if(skill_check[1]){skills_set_str = skills_set[0]["key"];} 
//		if(skill_check[2]){if(skills_set_str == ""){skills_set_str = skills_set[1]["key"];}else{skills_set_str += "," + skills_set[1]["key"];}} 
//		if(skill_check[3]){if(skills_set_str == ""){skills_set_str = skills_set[2]["key"];}else{skills_set_str += "," + skills_set[2]["key"];}} 
//		if(skill_check[4]){if(skills_set_str == ""){skills_set_str = skills_set[3]["key"];}else{skills_set_str += "," + skills_set[3]["key"];}} 
//		if(skill_check[5]){if(skills_set_str == ""){skills_set_str = skills_set[4]["key"];}else{skills_set_str += "," + skills_set[4]["key"];}} 
//
//		
//		$("#selectedSkills").val(skills_set_str);
//
//		auto_reply_apply = 0;
//		auto_reply_apply_text = "";
//		if ($('#auto_reply_apply').is(':checked')){
//			auto_reply_apply=1;	
//			auto_reply_apply_text = $('#auto_reply_apply_text').val();
//			if((auto_reply_apply_text == "") || (auto_reply_apply_text == " ")){alert("Auto reply apply text must be filled out"); $("#auto_reply_apply_text").focus(); return false;}					
//		}
//
//
//		var contactEmail = $("#contactEmail").val();
//	
//		if((contactEmail == "") || (contactEmail == " ")){alert("Contact Email must be filled out"); $("#contactEmail").focus(); return false;}			
//		
//	
//
//
//}
//
//


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
}
</script>

<div class="row-fluid sortable">
    <div class="box span12">
		<div class="box-header well" data-original-title>
		    <h2><i class="icon-edit"></i> Edit Job</h2>
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
		

		    <div style="float:left;width:50%;">
				<div class="control-group">
					<label class="control-label" for="jobTitle">Job Title <span style="color:#FF0000;font-weight: 800;">*</span></label>
					<div class="controls">
					    <input class="input-xlarge focused" id="jobTitle" name="jobTitle" type="text" value="<?=$jobs['jobs']['title']?>">
					</div>
			    </div>



				 <div class="control-group">
			<label class="control-label" for="locations">Job Country <span style="color:#FF0000;font-weight: 800;">*</span></label>
			<div class="controls">
			    <select id="locations" name="locations" data-rel="chosen" style="width:150px;">
                                <option value="<?=$sCountry['countries']['id']?>"><?=$sCountry['countries']['name']?></option>    
				<?php
				foreach ($countries as $country):
				    ?>
    				<option value="<?php echo $country['countries']['id']; ?>">
					<?php echo $country['countries']['name']; ?>
    				</option>
				<?php endforeach; ?>
			    </select> <input type="text" id="city" name="city" style="width:150px;margin-top: -20px;" placeholder="city" value="<?=$jobs['jobs']['city']?>">
			</div>
		    </div>


			<div class="control-group">
			
			<div class="controls">
			   <label class="checkbox" style="margin-left: -20px;">
                               <input type="checkbox" id="relocation" name="relocation" value="1" <?php if($jobs['jobs']['relocation_assistance'] == 1) echo "checked"; ?>>
						Relocation assistance offered for this position
			   		</label>
					<label class="checkbox" style="margin-left: -20px;">
					<input type="checkbox" id="remote_work" name="remote_work" value="1" <?php if($jobs['jobs']['work_anywhere'] == 1) echo "checked"; ?>>
						Work can be done from anywhere (i.e. telecommuting)
			   		</label>
 
 

				
			</div>
		    </div>



			<div class="control-group">
			<label class="control-label" for="startDate">Choose Timeframe<span style="color:#FF0000;font-weight: 800;">*</span></label>
			<div class="controls">
			    <input style="width:125px;" type="text" class="input-xlarge datepicker" id="startDate" name="startDate" value="<?=$jobs['jobs']['start_date']?>" readonly>
				&nbsp;&nbsp;&nbsp;
				<input style="width:125px;" type="text" class="input-xlarge datepicker" id="expiryDate" name="expiryDate" value="<?=$jobs['jobs']['expiry_date']?>" readonly>
			</div>
		    </div>

		    <div class="control-group">
			<label class="control-label" for="min_exp">Years of Experience <span style="color:#FF0000;font-weight: 800;">*</span></label>
			<div class="controls">
			   <select name="min_exp" style="width:125px;" id="Jobs_jobMinExperience">
                               <option value="<?=$jobs['jobs']['min_experience']?>"><?=$jobs['jobs']['min_experience']?></option>
					<option value="">- Min -</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="5">5</option>
					<option value="7">7</option>
					<option value="10">10</option>
					<option value="15">15</option>
					<option value="20">20</option>
				</select>


				<select name="max_exp" style="width:125px;" id="Jobs_jobMaxExperience">
                                    <option value="<?=$jobs['jobs']['max_experience']?>"><?=$jobs['jobs']['max_experience']?></option>
					<option value="">- Max -</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="5">5</option>
					<option value="7">7</option>
					<option value="10">10</option>
					<option value="15">15</option>
					<option value="20">20</option>
				</select>
		</div>
		</div>
		   

<div class="control-group">
			<label class="control-label" for="job_description">Job Description <span style="color:#FF0000;font-weight: 800;">*</span></label>
			
		   		   <div class="controls">
			    <textarea class="cleditor" id="jobDescription" name="job_description" rows="3"><?=$jobs['jobs']['description']?></textarea>
			</div>
		    </div>





			</div>

			<div style="float:right;width:45%;"> 
					<div class="control-group">
						<label class="control-label">Job Type <span style="color:#FF0000;font-weight: 800;">*</span></label>
							<div class="controls">
								
								<div style="box-shadow: 1px 1px 1px 1px; padding-top: 10px;">							  
									<label class="radio">	
									<input type="radio" name="employmentType" id="employmentType1" value="1" checked="">
									<strong>Full-time</strong>
									<div style="margin:0px 0px 10px 40px;font-size:12px;color:#d1d1d1;font-weight:800;">
										Salaried position, typically 40 hours a week
									</div>
									</label>		
								</div>

								<div style="box-shadow: 1px 1px 1px 1px; padding-top: 10px;">	
									<label class="radio">							  
									<input type="radio" name="employmentType" id="employmentType2" value="2" checked="">
									<strong>Contract</strong>
									<div style="margin:0px 0px 10px 40px;font-size:12px;color:#d1d1d1;font-weight:800;">
										Temporary position, typically 40 hours a week
									</div>		
									</label>
								</div>

								<div style="box-shadow: 1px 1px 1px 1px; padding-top: 10px;">	
									<label class="radio">							  
									<input type="radio" name="employmentType" id="employmentType3" value="3" checked="">
									<strong>Part-time</strong>
									<div style="margin:0px 0px 10px 40px;font-size:12px;color:#d1d1d1;font-weight:800;">
										Typically 10�35 hours a week, usually on-site
									</div>
									</label>		
								</div>

								<div style="box-shadow: 1px 1px 1px 1px; padding-top: 10px;">
									<label class="radio">								  
									<input type="radio" name="employmentType" id="employmentType4" value="4" checked="">
									<strong>Freelance</strong>
									<div style="margin:0px 0px 10px 40px;font-size:12px;color:#d1d1d1;font-weight:800;">
										Shorter-term work, usually remote (off-site)
									</div>
									</label>		
								</div>

								<div style="box-shadow: 1px 1px 1px 1px; padding-top: 10px;">	
									<label class="radio">							  
									<input type="radio" name="employmentType" id="employmentType5" value="5" checked="">
									<strong>Moonlighting</strong>
									<div style="margin:0px 0px 10px 40px;font-size:12px;color:#d1d1d1;font-weight:800;">
										Work that can be done in the evenings & weekends
									</div>	
									</label>	
								</div>
								<div style="box-shadow: 1px 1px 1px 1px; padding-top: 10px;">	
									<label class="radio">							  
									<input type="radio" name="employmentType" id="employmentType6" value="6" checked="">
									<strong>Internship</strong>
									<div style="margin:0px 0px 10px 40px;font-size:12px;color:#d1d1d1;font-weight:800;">
										On-the-job training
									</div>	
									</label>		
								</div>

					  		</div>
					</div>
			</div>
			 <div style="clear:both"></div>

			 

		    

		 <div style="float:left;width:50%;">



			<div class="control-group">
			<label class="control-label" for="vacancies">Number of Vacancies <span style="color:#FF0000;font-weight: 800;">*</span></label>
			<div class="controls">
			    <select id="vacancies" name="vacancies">
                                <option value="<?=$jobs['jobs']['title']?>"><?=$jobs['jobs']['vacancies']?></option>
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
			<label class="control-label" for="qualifications">Qualifications </label>
			<div class="controls">
			    <input type="text" id="qualifications" name="qualifications" style="width:250px;" placeholder="add comma separated qualifications" >
			    <!--<select data-placeholder="Set Qualifications" id="qualifications" name="qualifications"  data-rel="chosen">
				<option value=""></option>
				<?php
				$optiongroup = "-1";
				foreach ($qualifications as $qualification):
				    if ($optiongroup != $qualification['qualifications']['priority']) {
					if ($optiongroup != "-1") {
					    echo "</optgroup>";
					}
					echo '<optgroup label="' . $qualification['qualifications']['type'] . '">';
					$optiongroup = $qualification['qualifications']['priority'];
				    }
				    ?>
    				<option value="<?php echo $qualification['qualifications']['qualification_id']; ?>">
					<?php echo $qualification['qualifications']['title']; ?>
    				</option>
				<?php endforeach; ?>



				</optgroup>

			    </select>-->
			</div>
		    </div>


			<div class="control-group">
			<label class="control-label" for="manage_others">Manages Others</label>
			<div class="controls">
			   <input data-no-uniform="true" id="manages" name="manage_others" type="checkbox" class="iphone-toggle">
			</div>
		    </div>	



		   </div>

			 <div style="float:right;width:45%;"> 
			<input type="hidden" name="selectedSkills" id="selectedSkills" value="">
			<div class="control-group">
			  <label class="control-label" >Skills <span style="color:#FF0000;font-weight: 800;">*</span></label>
			  <div class="controls">  				
					<input type="text"  id="skills" onKeyUp="fetchSkills(this.value);" placeholder="Start typing to activate auto complete!">
			
				<div style="margin-top:20px;">
						<div class="alert alert-success" id="skill_box_1" style="display:none;margin-bottom: 3px;padding: 2px 35px 2px 14px;">
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
						</div>

				 	

	
					 
					
				</div>
			  </div>
			</div>

		</div>
		   
	<div style="clear:both;"></div>
 

<div style="float:left;width:50%;"> 
			<div class="control-group">
				<label class="control-label" for="residence_locations">Residence Location <span style="color:#FF0000;font-weight: 800;">*</span></label>
				<div class="controls">
			    <select id="residence_locations" name="residence_locations">
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
			<label class="control-label" for="min_age">Age </label>
			<div class="controls">
			    <select name="min_age" style="width:125px;" id="Jobs_jobAgeMin">
					<option value="">- Min -</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>
					<option value="30">30</option>
					<option value="31">31</option>
					<option value="32">32</option>
					<option value="33">33</option>
					<option value="34">34</option>
					<option value="35">35</option>
					<option value="36">36</option>
					<option value="37">37</option>
					<option value="38">38</option>
					<option value="39">39</option>
					<option value="40">40</option>
					<option value="41">41</option>
					<option value="42">42</option>
					<option value="43">43</option>
					<option value="44">44</option>
					<option value="45">45</option>
					<option value="46">46</option>
					<option value="47">47</option>
					<option value="48">48</option>
					<option value="49">49</option>
					<option value="50">50</option>
					<option value="51">51</option>
					<option value="52">52</option>
					<option value="53">53</option>
					<option value="54">54</option>
					<option value="55">55</option>
					<option value="56">56</option>
					<option value="57">57</option>
					<option value="58">58</option>
					<option value="59">59</option>
					<option value="60">60</option>
					<option value="61">61</option>
					<option value="62">62</option>
					<option value="63">63</option>
					<option value="64">64</option>
					<option value="65">65</option>
				</select>

				<select name="max_age" style="width:125px;" id="Jobs_jobAgeMax">
					<option value="">- Max -</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>
					<option value="30">30</option>
					<option value="31">31</option>
					<option value="32">32</option>
					<option value="33">33</option>
					<option value="34">34</option>
					<option value="35">35</option>
					<option value="36">36</option>
					<option value="37">37</option>
					<option value="38">38</option>
					<option value="39">39</option>
					<option value="40">40</option>
					<option value="41">41</option>
					<option value="42">42</option>
					<option value="43">43</option>
					<option value="44">44</option>
					<option value="45">45</option>
					<option value="46">46</option>
					<option value="47">47</option>
					<option value="48">48</option>
					<option value="49">49</option>
					<option value="50">50</option>
					<option value="51">51</option>
					<option value="52">52</option>
					<option value="53">53</option>
					<option value="54">54</option>
					<option value="55">55</option>
					<option value="56">56</option>
					<option value="57">57</option>
					<option value="58">58</option>
					<option value="59">59</option>
					<option value="60">60</option>
					<option value="61">61</option>
					<option value="62">62</option>
					<option value="63">63</option>
					<option value="64">64</option>
					<option value="65">65</option>
				</select>


			</div>
		</div>

</div>
<div style="float:right;width:45%;"> 
			<div class="control-group">
				<label class="control-label" for="nationality">Nationality <span style="color:#FF0000;font-weight: 800;">*</span></label>
				<div class="controls">
			    <select id="nationality" name="nationality">
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
			<label class="control-label" for="gender">Gender</label>
			<div class="controls">			    										
				<select name="gender" id="Jobs_jobGender">
					<option value="a">Any</option>
					<option value="m">Male</option>
					<option value="f">Female</option>
                                        
			    </select>
			</div>
		</div>
</div>
		
<div style="clear:both;"></div>

<div style="float:left;width:50%;"> 







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
				<label class="control-label" for="confidentiality">Confidentiality</label>
				<div class="controls">
					<label class="checkbox inline" style="margin-left: -20px;">
					<input type="checkbox" id="confidentiality" name="confidentiality" value="1" <?php if($jobs['jobs']['confidentiality'] == 1) echo "checked"; ?>>
					Hide company name when this job is viewed online
			   		</label>
				</div>				
			    </div>

				<div class="control-group">
					<label class="control-label" >Email Setting</label>
					<div class="controls">	
					<label class="radio" style="margin-left: -20px;">				  
						<input type="radio" name="email_setting" id="email_setting1" value="0" checked="">
						Do not email me
						<p class="help-block" style="margin:-10px 0px 10px 80px">No notifications will be e-mailed to you regarding job applications; you will check your Workspace for new applicants.</p>
					 </label>
					  <div style="clear:both"></div>
					  <label class="radio" style="margin-left: -20px;">
						<input type="radio" name="email_setting" id="email_setting2" value="1">
						Email me the daily count of new applicants
						<p class="help-block" style="margin:-10px 0px 10px 80px">The total number of new applicants for each day will be e-mailed to you on a daily basis. You can also check your Workspace for new applicants.</p>
					  </label>
					  <label class="radio" style="margin-left: -20px;">
						<input type="radio" name="email_setting" id="email_setting3" value="2">
						 Email me CVs of new applicants
						<p class="help-block" style="margin:-10px 0px 10px 80px">Each applicant's CV will be e-mailed directly to you as they apply. You can also check your Workspace for new applicants.</p>
					  </label>
					</div>
			</div>
</div>
<div style="float:right;width:45%;"> 

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

				<div class="controls">
					<label class="checkbox inline" style="margin-left: -20px;">
					<input type="checkbox" id="auto_reply_apply" name="auto_reply_apply" value="1">
					Automatically send "Application Received" email to applicants
			   		</label>
				</div>				
		    </div>
			<div class="control-group">
					<label class="control-label" for="auto_reply_apply-text">Email Text</label>
					<div class="controls">	
					<label class="radio">				  
						<textarea style="width:300px;" id="auto_reply_apply_text" name="auto_reply_apply_text" rows="8" cols="80">Dear [NAME_OF_CANDIDATE]

Thank you for applying to the [JOB_TITLE] vacancy we have posted on networkwe.com.

We have received your application and will be reviewing it shortly.

Please bear with us while we diligently screen the applications. We will contact you to take things further should your qualifications match our requirements.

Best regards
The [COMPANY_NAME] team
						</textarea>						
					 </label>					  
					</div>
			</div>

</div>
		
<div style="clear:both;"></div>
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




<div style="display:none;background: none repeat scroll 0 0 #F1F1F1;box-shadow: 1px 10px 10px 10px; left: 1045px;padding-left: 30px; position: absolute; top: 750px;    width: 190px;" id="ajaxSkills" >



</div>


