
<div style="padding-left:30px;display:none;border: 0px solid rgb(255, 0, 0);background:#f1f1f1; position: absolute; left: 425px; width: 300px; top: 280px;" id="ajaxSkills" >

</div>
<div id="step_2" style="display:none;">
	<form class="form-horizontal" enctype="multipart/form-data" action="#" method="post">
		<fieldset>
The fields marked with <span style="color:#FF0000;font-weight: 800;">*</span> are mandatory
				<div class="control-group">
					<div class="controls" style="text-align:right;">
						<button type="button" class="btn btn-primary" onclick="jobsAction('previous');">&larr; Previous</button>						
						<button type="button" class="btn btn-success btn-primary" onclick="jobsAction('save');">Save</button>	
						<button type="button" class="btn btn-primary" onclick="jobsAction('next');">Next &rarr;</button>
			    	</div>
			    </div>
			
			<div class="control-group">
			  <label class="control-label" >Skills <span style="color:#FF0000;font-weight: 800;">*</span></label>
			  <div class="controls">  
				<div style="float:left;width:40%;">	
					<input type="text" class="span8" id="skills" onKeyUp="fetchSkills(this.value);" >
					<p class="help-block">Start typing to activate auto complete!</p>
				</div> 
				<div style="float:left;">
						<div class="alert alert-success" id="skill_box_1" style="display:none;margin-bottom: 3px;padding: 2px 35px 2px 14px;">
							<button class="close" type="button" onclick="removeSkill(1);">x</button>
							<span id="skill_1">You successfully read this important alert message.</span>
						</div>
							<div class="alert alert-success" id="skill_box_2" style="display:none;margin-bottom: 3px;padding: 2px 35px 2px 14px;">
							<button class="close" type="button" onclick="removeSkill(2);">x</button>
							<span id="skill_2">You successfully read this important alert message.</span>
						</div>

							<div class="alert alert-success" id="skill_box_3" style="display:none;margin-bottom: 3px;padding: 2px 35px 2px 14px;">
							<button class="close" type="button" onclick="removeSkill(3);">x</button>
							<span id="skill_3">You successfully read this important alert message.</span>
						</div>
							<div class="alert alert-success" id="skill_box_4" style="display:none;margin-bottom: 3px;padding: 2px 35px 2px 14px;">
							<button class="close" type="button" onclick="removeSkill(4);">x</button>
							<span id="skill_4">You successfully read this important alert message.</span>
						</div>
							<div class="alert alert-success" id="skill_box_5" style="display:none;margin-bottom: 3px;padding: 2px 35px 2px 14px;">
							<button class="close" type="button" onclick="removeSkill(5);">x</button>
							<span id="skill_5">You successfully read this important alert message.</span>
						</div>

					

	
					 
					
				</div>
			  </div>
			</div>

		<div class="control-group">
			<label class="control-label" for="career_level">Career Level</label>
			<div class="controls">
			    <select id="career_level" name="career_level" >											
					<option value="">- Select one -</option>
					<option value="1">Entry Level</option>
					<option value="0">Student/Internship</option>
					<option value="2">Mid Career</option>
					<option value="3">Management</option>
					<option value="4">Executive/Director</option>
					<option value="5">Senior Executive (President, CEO)</option>
			    </select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="Jobs_jobMinExperience">Years of Experience <span style="color:#FF0000;font-weight: 800;">*</span></label>
			<div class="controls">
			   <select name="Jobs[jobMinExperience]" id="Jobs_jobMinExperience">
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


				<select name="Jobs[jobMaxExperience]" id="Jobs_jobMaxExperience">
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
			<label class="control-label" for="qualifications">Qualifications </label>
			<div class="controls">
			    <select data-placeholder="Set Qualifications" id="qualifications" name="qualifications"  data-rel="chosen">
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
			<label class="control-label" for="Jobs_jobGender">Gender</label>
			<div class="controls">			    										
				<select name="Jobs[jobGender]" id="Jobs_jobGender">
					<option value="">- No preference -</option>
					<option value="m">Male</option>
					<option value="f">Female</option>
			    </select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="Jobs_jobAgeMin">Age </label>
			<div class="controls">
			    <select name="Jobs[jobAgeMin]" id="Jobs_jobAgeMin">
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

				<select name="Jobs[jobAgeMax]" id="Jobs_jobAgeMax">
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


			 <div class="control-group">
			<div class="controls" style="text-align:right;">
			    <button type="button" class="btn btn-primary" onclick="jobsAction('previous');">&larr; Previous</button>						
				<button type="button" class="btn btn-success btn-primary" onclick="jobsAction('save');">Save</button>	
				<button type="button" class="btn btn-primary" onclick="jobsAction('next');">Next &rarr;</button>
			    
			</div>
		    </div>

		</fieldset>
	</form>
</div>