<div class="tab-pane" id="step_2">

	<form class="form-horizontal" enctype="multipart/form-data" action="#" method="post">
		<fieldset>

			<div class="control-group">
			  <label class="control-label" >Skills </label>
			  <div class="controls">
				<input type="text" class="span6 typeahead" id="skills_1"  data-provide="typeahead" data-items="4" data-source='["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Dakota","North Carolina","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"]'>
				<input type="text" class="span6 typeahead" id="skills_2"  data-provide="typeahead" data-items="4" data-source='["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Dakota","North Carolina","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"]'>
				<input type="text" class="span6 typeahead" id="skills_3"  data-provide="typeahead" data-items="4" data-source='["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Dakota","North Carolina","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"]'>
				<input type="text" class="span6 typeahead" id="skills_4"  data-provide="typeahead" data-items="4" data-source='["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Dakota","North Carolina","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"]'>
				<input type="text" class="span6 typeahead" id="skills_5"  data-provide="typeahead" data-items="4" data-source='["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Dakota","North Carolina","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"]'>
				<input type="text" class="span6 typeahead" id="skills_6"  data-provide="typeahead" data-items="4" data-source='["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Dakota","North Carolina","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"]'>
				<p class="help-block">Start typing to activate auto complete!</p>
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
			<label class="control-label" for="Jobs_jobMinExperience">Years of Experience</label>
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
			<label class="control-label" for="qualifications">Qualifications</label>
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
				<label class="control-label" for="residence_locations">Residence Location</label>
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
				<label class="control-label" for="nationality">Nationality</label>
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
			<label class="control-label" for="Jobs_jobAgeMin">Age</label>
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
			    <button type="button" class="btn btn-primary">Next &rarr;</button>
			    
			</div>
		    </div>

		</fieldset>
	</form>
</div>