<style type="text/css">
.control-group.required .control-label:after {
  content:"*";
  color:red;
}
.top-buffer4 { margin-top:20px; }
.top-buffer1 { margin-top:5px; }
</style>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Add New Job</h2>
        </div>
        <div class="box-content">
            <form class="form-horizontal" enctype="multipart/form-data" action="#" id="form_jobs" method="post" role="form">

                <fieldset>
                                       
                    
                    <h4 class="help-block"><span style="color:#FF0000;font-weight: 800;">*</span> Indicates required field.</h4>
                    <!--<div class="control-group">
                        <div class="controls" style="text-align:right;">
                            <input type="submit" class="btn btn-success btn-primary" value="Save">
                            <input type="button" class="btn btn-primary ignored" onclick="document.location = '/recruiter/jobs';" value="Cancel">
                        </div>
                    </div>-->
                    <div class="control-group required">
                        <label class="control-label" for="jobTitle">Job Title </label>
                        <div class="controls">
                            <input class="input-xlarge focused" id="jobTitle" name="jobTitle" type="text" value="">
                        </div>
                    </div>
                    <div class="control-group required">
                        <label class="control-label" for="functional_area">Functional Area </label>
                        <div class="controls">
                            <select id="functional_area" name="functional_area" data-rel1="chosen" >
                                <option value="">Select</option>
                                <?php foreach ($functional_areas as $farea): ?>
                                <option value="<?php echo $farea['functional_areas']['id']; ?>"><?php echo $farea['functional_areas']['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group required">
                        <label class="control-label" for="industries">Industries </label>
                        <div class="controls">
                            <span class="input-group">
                            <select id="industries" name="industries" data-rel1="chosen" >
                                <option value="">Select</option>
                                <?php foreach ($industries as $industry): ?>
                                <option value="<?php echo $industry['industries']['id']; ?>"><?php echo $industry['industries']['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input class="input-xlarge focused hidden" id="industries_other" name="industries_other" type="text" value="">
                            </span>
                        </div>
                    </div>
                    <div class="control-group required">
                        <label class="control-label" for="job_type">Job Type </label>
                        <div class="controls">
                            <select id="job_type" name="job_type" data-rel1="chosen" >
                                <option value="">Select</option>
                                <?php foreach ($job_types as $type) :?>
                                <option value="<?= $type['job_types']['id'] ?>"><?= $type['job_types']['type'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group required">
                        <label class="control-label" for="locations">Job Country </label>
                        <div class="controls">
                            <select id="locations" name="locations" data-rel1="chosen" >
                                <option value="">Select</option>
                                <?php foreach ($countries as $country): ?>
                                <option value="<?php echo $country['countries']['id']; ?>"><?php echo $country['countries']['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="locations">Job City</label>
                        <div class="controls">
                            <input type="text" id="city" name="city" placeholder="city" >
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" id="relocation" name="relocation" value="1">
                                Relocation assistance offered for this position
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" id="remote_work" name="remote_work" value="1">
                                Work can be done from anywhere (i.e. telecommuting)
                            </label>
                        </div>
                    </div>
                    <div class="control-group required">
                        <label class="control-label" for="startDate">Choose Timeframe </label>
                        <div class="controls">
                            <span class="input-group input-append date">
                            <input style="width:125px;" type="text" class="input-xlarge" id="startDate" name="startDate" value="" placeholder="Choose Start Date" readonly>
                            <span class="add-on"><i class="icon-calendar"></i></span>
                            &nbsp;&nbsp;&nbsp;
                            <input style="width:125px;" type="text" class="input-xlarge" id="expiryDate" name="expiryDate" value="" placeholder="Choose End Date" readonly>
                            <span class="add-on"><i class="icon-calendar"></i></span>
                            </span>
                        </div>
                    </div>
                    <div class="control-group required">
                        <label class="control-label" for="vacancies">Number of Vacancies </label>
                        <div class="controls">
                            <select id="vacancies" name="vacancies">
                                <option value="">Select</option>
                                <?php for ($i = 1; $i <= 100; $i++) :?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group required">
                        <label class="control-label" for="jobDescription">Job Description </label>
                        <div class="controls">
                            <span class="input-group">
                            <!--<textarea id="job_description" name="job_description" rows="3" required></textarea>-->
                            <textarea class="cleditor" id="job_description" name="job_description" rows="3" required></textarea>
                            </span>
                        </div>
                    </div>

                    <div class="control-group required">
                        <label class="control-label" for="min_exp">Years of Experience </label>
                        <div class="controls">
                            <span class="input-group">
                            <select name="min_exp" style="width:125px;" id="Jobs_jobMinExperience">
                                <option value="">- Min -</option>
                                <?php for ($i = 0; $i <= 20; $i++) :?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <select name="max_exp" style="width:125px;" id="Jobs_jobMaxExperience">
                                <option value="">- Max -</option>
                                <?php for ($i = 1; $i <= 20; $i++) :?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            </span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="career_level">Career Level</label>
                        <div class="controls">
                            <select id="career_level" name="career_level">
                                <option value="">Select</option>
                                <option value="1">Entry Level</option>
                                <option value="2">Student/Internship</option>
                                <option value="3">Mid Career</option>
                                <option value="4">Management</option>
                                <option value="5">Executive/Director</option>
                                <option value="6">Senior Executive (President, CEO)</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="manage_others">Manages Others</label>
                        <div class="controls">
                            <input data-no-uniform="true" id="manages" name="manage_others" type="checkbox" class="iphone-toggle" value="1">
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
                        <label class="control-label" >Salary</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="salary_mode" id="confidential_salary" value="0" checked="">
                                <strong>Confidential</strong>
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="salary_mode" id="yearly_salary" value="1">
                                <strong>Yearly</strong>
                            </label>
                            <span class="input-group">
                            <select id="salary_min" name="min_salary">
                                <option value="-1">Min</option><option value="49999">Less than 50000</option><option value="50000">50,000</option><option value="60000">60,000</option><option value="70000">70,000</option><option value="80000">80,000</option><option value="90000">90,000</option><option value="100000">1,00,000</option><option value="125000">1,25,000</option><option value="150000">1,50,000</option><option value="175000">1,75,000</option><option value="200000">2,00,000</option><option value="225000">2,25,000</option><option value="250000">2,50,000</option><option value="275000">2,75,000</option><option value="300000">3,00,000</option><option value="325000">3,25,000</option><option value="350000">3,50,000</option><option value="375000">3,75,000</option><option value="400000">4,00,000</option><option value="425000">4,25,000</option><option value="450000">4,50,000</option><option value="475000">4,75,000</option><option value="500000">5,00,000</option><option value="550000">5,50,000</option><option value="600000">6,00,000</option><option value="650000">6,50,000</option><option value="700000">7,00,000</option><option value="750000">7,50,000</option><option value="800000">8,00,000</option><option value="850000">8,50,000</option><option value="900000">9,00,000</option><option value="950000">9,50,000</option><option value="1000000">10,00,000</option><option value="1100000">11,00,000</option><option value="1200000">12,00,000</option><option value="1300000">13,00,000</option><option value="1400000">14,00,000</option><option value="1500000">15,00,000</option><option value="1600000">16,00,000</option><option value="1700000">17,00,000</option><option value="1800000">18,00,000</option><option value="1900000">19,00,000</option><option value="2000000">20,00,000</option><option value="2250000">22,50,000</option><option value="2500000">25,00,000</option><option value="2750000">27,50,000</option><option value="3000000">30,00,000</option><option value="3250000">32,50,000</option><option value="3500000">35,00,000</option><option value="3750000">37,50,000</option><option value="4000000">40,00,000</option><option value="4500000">45,00,000</option><option value="5000000">50,00,000</option><option value="10000000">50,00,000 &amp; above</option>
                            </select>
                            <select id="salary_max" name="max_salary">
                                <option value="-1">Min</option><option value="49999">Less than 50000</option><option value="50000">50,000</option><option value="60000">60,000</option><option value="70000">70,000</option><option value="80000">80,000</option><option value="90000">90,000</option><option value="100000">1,00,000</option><option value="125000">1,25,000</option><option value="150000">1,50,000</option><option value="175000">1,75,000</option><option value="200000">2,00,000</option><option value="225000">2,25,000</option><option value="250000">2,50,000</option><option value="275000">2,75,000</option><option value="300000">3,00,000</option><option value="325000">3,25,000</option><option value="350000">3,50,000</option><option value="375000">3,75,000</option><option value="400000">4,00,000</option><option value="425000">4,25,000</option><option value="450000">4,50,000</option><option value="475000">4,75,000</option><option value="500000">5,00,000</option><option value="550000">5,50,000</option><option value="600000">6,00,000</option><option value="650000">6,50,000</option><option value="700000">7,00,000</option><option value="750000">7,50,000</option><option value="800000">8,00,000</option><option value="850000">8,50,000</option><option value="900000">9,00,000</option><option value="950000">9,50,000</option><option value="1000000">10,00,000</option><option value="1100000">11,00,000</option><option value="1200000">12,00,000</option><option value="1300000">13,00,000</option><option value="1400000">14,00,000</option><option value="1500000">15,00,000</option><option value="1600000">16,00,000</option><option value="1700000">17,00,000</option><option value="1800000">18,00,000</option><option value="1900000">19,00,000</option><option value="2000000">20,00,000</option><option value="2250000">22,50,000</option><option value="2500000">25,00,000</option><option value="2750000">27,50,000</option><option value="3000000">30,00,000</option><option value="3250000">32,50,000</option><option value="3500000">35,00,000</option><option value="3750000">37,50,000</option><option value="4000000">40,00,000</option><option value="4500000">45,00,000</option><option value="5000000">50,00,000</option><option value="10000000">50,00,000 &amp; above</option>
                            </select>
                            <div style="clear:both;"></div>
                            </span>
                            
                            <label class="radio">
                                <input type="radio" name="salary_mode" id="hourly_salary" value="2">
                                <strong>Hourly</strong>
                            </label>
                            <input type="text" id="salary_hourly" name="hourly_salary" style="width:150px;" placeholder="hourly rate" >
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="nationality">Nationality</label>
                        <div class="controls">
                            <select id="nationality" name="nationality">
                                <option value="all">Any</option>
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
                            <span class="input-group">
                            <select name="min_age" style="width:125px;" id="Jobs_jobAgeMin">
                                <option value="">- Min -</option>
                                <?php for ($i = 18; $i < 65; $i++): ?>
                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <select name="max_age" style="width:125px;" id="Jobs_jobAgeMax">
                                <option value="">- Max -</option>
                                <?php for ($i = 18; $i < 65; $i++): ?>
                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                <?php endfor; ?>
                            </select>
                            </span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="gender">Gender</label>
                        <div class="controls">
                            <select name="gender" id="Jobs_jobGender">
                                <option value="Any">Any</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="residence_locations">Residence Location</label>
                        <div class="controls">
                            <select id="residence_locations" name="residence_locations">
                                <option value="all">Any</option>
                                <?php foreach ($countries as $country): ?>
                                <option value="<?php echo $country['countries']['id']; ?>"><?php echo $country['countries']['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="selectedSkills" id="selectedSkills" value="">
                    <div class="control-group">
                        <label class="control-label" >Skills</label>
                        <div class="controls">
                            <input type="text" class="ignored span3" id="skills" autocomplete="off" onKeyUp="fetchSkills(this.value);" placeholder="Start typing to activate auto complete!">
                            <div class="well" id="ajaxSkills" style="position: absolute; width: 202px; z-index: 1; display: none;"></div>
                            <br/>
                            <div class="span6">
                                <div class="btn btn-success" onclick="removeSkill(0,'');" id="skill_box_0" style="display:none;">
                                    <i class="icon-trash icon-dark"></i> 
                                    <span id="skill_0"></span>
                                </div>
                                <div class="clear top-buffer1"></div>
                                <div class="btn btn-success" onclick="removeSkill(1,'');" id="skill_box_1" style="display:none;">
                                    <i class="icon-trash icon-dark"></i> 
                                    <span id="skill_1"></span>
                                </div>
                                <div class="clear top-buffer1"></div>
                                <div class="btn btn-success" onclick="removeSkill(2,'');" id="skill_box_2" style="display:none;">
                                    <i class="icon-trash icon-dark"></i> 
                                    <span id="skill_2"></span>
                                </div>
                                <div class="clear top-buffer1"></div>
                                <div class="btn btn-success" onclick="removeSkill(3,'');" id="skill_box_3" style="display:none;">
                                    <i class="icon-trash icon-dark"></i> 
                                    <span id="skill_3"></span>
                                </div>
                                <div class="clear top-buffer1"></div>
                                <div class="btn btn-success" onclick="removeSkill(4,'');" id="skill_box_4" style="display:none;">
                                    <i class="icon-trash icon-dark"></i> 
                                    <span id="skill_4"></span>
                                </div>
                                <div class="clear top-buffer1"></div>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="confidentiality">Confidentiality</label>
                        <div class="controls">
                            <label class="checkbox inline">
                                <input type="checkbox" id="confidentiality" name="confidentiality" value="1">
                                Hide company name when this job is viewed online
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" >Email Setting</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="email_setting" id="email_setting1" value="0">
                                Do not email me
                                <p class="help-block">No notifications will be e-mailed to you regarding job applications; you will check your Workspace for new applicants.</p>
                            </label>
                            <div style="clear:both"></div>
                            <label class="radio">
                                <input type="radio" name="email_setting" id="email_setting2" value="1">
                                Email me the daily count of new applicants
                                <p class="help-block">The total number of new applicants for each day will be e-mailed to you on a daily basis. You can also check your Workspace for new applicants.</p>
                            </label>
                            <label class="radio">
                                <input type="radio" name="email_setting" id="email_setting3" value="2" checked="checked">
                                Email me CVs of new applicants
                                <p class="help-block">Each applicant's CV will be e-mailed directly to you as they apply. You can also check your Workspace for new applicants.</p>
                            </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox inline">
                                <input type="checkbox" id="auto_reply_apply" name="auto_reply_apply" value="1" checked="">
                                Automatically send "Application Received" email to applicants
                            </label>
                        </div>
                    </div>
                    <div class="control-group" id="email_text">
                        <label class="control-label" for="auto_reply_apply-text">Email Text</label>
                        <div class="controls">
                            <textarea id="auto_reply_apply_text" name="auto_reply_apply_text" rows="8" cols="80" class="span9">Dear [NAME_OF_CANDIDATE]
Thank you for applying to the [JOB_TITLE] vacancy we have posted on <?php echo SITE_URL?>.
We have received your application and will be reviewing it shortly.
Please bear with us while we diligently screen the applications. We will contact you to take things further should your qualifications match our requirements.
Best regards
The [COMPANY_NAME] team     </textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="conatctPerson">Contact Person</label>
                        <div class="controls">
                            <input class="input-xlarge focused" id="contactPerson" name="contactPerson" type="text" value="">
                        </div>
                    </div>

                    <div class="control-group required">
                        <label class="control-label" for="contactEmail">Email Address </label>
                        <div class="controls">
                            <input class="input-xlarge focused" id="contactEmail" name="contactEmail" type="text" value="">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="contactNumber">Contact Number</label>
                        <div class="controls">
                            <input class="input-xlarge focused" id="contactNumber" name="contactNumber" type="text" placeholder="Example: +971 4 417 9600">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="confidentiality">Post this job on <br>Company Pages: </label>
                        <div class="controls">
                            <?php
                            /*foreach ($company_pages as $pages) {
                                echo '<label class="checkbox inline">' .
                                '<input type="checkbox" id="company_page_' . $pages['companies']['id'] . '" name="company_page[' . $pages['companies']['id'] . ']" value="' . $pages['companies']['id'] . '">' .
                                $pages['companies']['title'] .
                                '</label>' .
                                '<div style="clear:both"></div>';
                            }*/
                            ?>
                            <?php foreach ($company_pages as $pages) :?>
                            <label class="checkbox inline">
                                <input type="checkbox" 
                                   id="company_page_<?php echo $pages['Company']['id']; ?>" 
                                   name="company_page[<?php echo $pages['Company']['id'];?>]" 
                                   value="<?php echo $pages['Company']['id'];?>">
                                <?php echo $pages['Company']['title']; ?>
                            </label>
                            <div style="clear:both"></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <hr/>
                    <div class="control-group">
                        <label class="control-label" for="confidentiality">Post this job on <br>Groups: </label>
                        <div class="controls">
                            <?php
                            foreach ($user_gruops as $group) {
                                echo '<label class="checkbox inline">' .
                                '<input type="checkbox" id="user_gruop_' . $group['groups']['id'] . '" name="user_gruop[' . $group['groups']['id'] . ']" value="' . $group['groups']['id'] . '">' .
                                $group['groups']['title'] .
                                '</label>' .
                                '<div style="clear:both"></div>';
                            }
                            ?>
                            <?php foreach ($user_groups as $group) : ?>
                            <label class="checkbox inline">
                                <input type="checkbox"
                                       id="user_group_<?php echo $group['Group']['id']; ?>" 
                                       name="user_group[<?php echo $group['Group']['id']; ?>]" 
                                       value="<?php echo $group['Group']['id']; ?>">
                                       <?php echo $group['Group']['title']; ?>
                            </label>
                            <div style="clear:both"></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <hr/>
                    <div class="control-group">
                        <label for="apply_remote_website" class="control-label">Apply Options </label>
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" name="apply_remote_website" id="apply">
                                <span>Apply on Company website</span>
                            </label>
                            &nbsp;<input type="text" id="apply_remote_website" name="remote_website_url" class="hidden" placeholder="http://www.networkwe.com/" />
                            <span class="help-block" for="apply_remote_website">Select to change job application Link.</span>
                            
                        </div>
                    </div>
                    <?php /*<div class="control-group">
                        <label class="control-label" >Apply Options</label>
                        <div class="controls">
                            
                            <label class="radio">
                                <input type="radio" name="apply_remote_website" value="1"/>
                                <strong>Apply on Company website</strong>
                            </label>
                            <input type="text" id="apply_remote_website" name="apply_remote_website" placeholder="http://www.networkwe.com/" />
                            <div style="clear:both"></div>
                            
                            <label class="radio">
                                <input type="radio" id="apply_default" name="apply_remote_website" value="0"/>
                                <strong>Apply on <?php echo SITE_TITLE?></strong>
                            </label>
                            
                        </div>
                    </div> */?>
                    <div class="control-group">
                        <label for="share_social" class="control-label">Share job </label>
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" name="share_social" id="share">
                                <span>Share on Facebook & Twitter</span>
                            </label>
                            <span class="help-block" for="share_social">Select to share on Facebook and Twitter.</span>
                        </div>
                    </div>


                    <div class="control-group">
                        <div class="controls">
                            <!--				<button type="button" class="btn btn-success btn-primary" onclick="jobsAction('save');">Save</button>
                                                            <button type="button" class="btn btn-primary" onclick="jobsAction('next');">Next &rarr;</button>		    -->

                            <input type="submit" class="btn btn-success btn-primary" value="Save">
                            <input type="button" class="btn btn-primary" onclick="document.location = '/recruiter/jobs';" value="Cancel">
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    current_tab = 1;
    current_job_id = 0;
    var skills_set = new Array();
    var skill_check = new Array();
    //var limit = skills_set.length;
    skill_check[0] = false;
    skill_check[1] = false;
    skill_check[2] = false;
    skill_check[3] = false;
    skill_check[4] = false;

    function assignSkill(text, key) {
        number = skills_set.length;
                    
        if (skills_set.length < 5) {
            skills_set[number] = new Array();
        } else {
            if (!(skill_check[0])) {
                number = 0;
            }
            if (!(skill_check[1])) {
                number = 1;
            }
            if (!(skill_check[2])) {
                number = 2;
            }
            if (!(skill_check[3])) {
                number = 3;
            }
            if (!(skill_check[4])) {
                number = 4;
            }
        }
        skills_set[number]["key"] = key;
        skills_set[number]["text"] = text;
        $("#skill_" + number).html(text);
        $("#skill_box_" + number).show();
        str = 'removeSkill('+ number +','+ key +')';
        $("#skill_box_" + number).attr('onclick', str);
        $("#ajaxSkills").hide();
        $("#skills").val("");
        skill_check[number] = true;
        update_skills();
    }
    
    function update_skills() {
        if ($('#skill_0').text()) {
            skills_set_str = skills_set[0]["key"];
        }
        if ($('#skill_1').text()) {
            if (skills_set_str == "") {
                skills_set_str = skills_set[1]["key"];
            } else {
                skills_set_str += "," + skills_set[1]["key"];
            }
        }
        if ($('#skill_2').text()) {
            if (skills_set_str == "") {
                skills_set_str = skills_set[2]["key"];
            } else {
                skills_set_str += "," + skills_set[2]["key"];
            }
        }
        if ($('#skill_3').text()) {
            if (skills_set_str == "") {
                skills_set_str = skills_set[3]["key"];
            } else {
                skills_set_str += "," + skills_set[3]["key"];
            }
        }
        if ($('#skill_4').text()) {
            if (skills_set_str == "") {
                skills_set_str = skills_set[4]["key"];
            } else {
                skills_set_str += "," + skills_set[4]["key"];
            }
        }
        skills_set_str = skills_set_str.split(',').filter(function(v){return v!==''}).join(",");
        //limit = skills_set_str.split(',').length;
        $("#selectedSkills").val(skills_set_str);
        //skills_set = skills_set.slice(0,$("#selectedSkills").val().split(',').length);
    }

    function removeSkill(id,key) {
        if(typeof skills_set[id]["key"] !== "undefined"){
            //if(skills_set[id]["key"] === key){
                skill_check[id] = false;
                skills_set[id]["key"] = '';
                skills_set[id] = false;
                $("#skill_box_" + id).hide();
                update_skills();
            //}
        }
    }

    function fetchSkills(value) {
        if(skills_set.length > 4){
            noty({text: 'You cannot add more skills!',type: 'error'});
            return;
        }
        /*if (skills_set.length > 4) {
            if (skill_check[1] && skill_check[2] && skill_check[3] && skill_check[4] && skill_check[5]) {
                //noty({text: 'You cannot add more skills!',type: 'error'});
                return;
            }
        }*/
        if (value.length < 3) {
            hide_auto_suggest();
            return;
        }

        var postData = {"search_str": value};
        $.ajax({
            type: "GET",
            url: "<?php echo NETWORKWE_URL ?>/recruiter/get_skills/q:"+value,
            data: postData
        })
        .done(function(data) {
            $("#ajaxSkills").html(data);
            $("#ajaxSkills").show();
        });

    }
    
    function hide_auto_suggest(){
        if($('#ajaxSkills').is(':visible'))
            $('#ajaxSkills').hide();
    }

$(function() {
    /*jQuery.extend(jQuery.validator.messages, {
            required: "Missing value.",
            remote: "Please fix this field.",
            email: "Invalid email.",
            url: "Please enter a valid URL.",
            date: "Please enter a valid date.",
            dateISO: "Please enter a valid date (ISO).",
            number: "Please enter a valid number.",
            digits: "Please enter only digits.",
            creditcard: "Please enter a valid credit card number.",
            equalTo: "Please enter the same value again.",
            accept: "Please enter a value with a valid extension.",
            maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
            minlength: jQuery.validator.format("Please enter at least {0} characters."),
            rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
            range: jQuery.validator.format("Please enter a value between {0} and {1}."),
            max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
            min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
        });*/
        
    $('body').on('click',function(event) {
        if($(event.target).parents('#ajaxSkills').length === 0 ) {
            hide_auto_suggest();
        }
    });
        
    /*$("#industries").change(function() {
        if(this.value == 41)
            $('#industries_other').removeClass("hidden");
        else
            $('#industries_other').addClass("hidden");
    });*/

    $.validator.setDefaults({
        errorClass: "help-block",
        errorElement: "span",
        ignore: ".ignored, .btn",
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element.closest('.control-group').removeClass('error').addClass('success');
        },
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length || element.parent('.cleditorMain').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
    
    $.validator.addMethod('validemail', function (emailAddress) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(emailAddress);
    },'Invalid email.');
    
    $.validator.addMethod('phone', function(value) {
        var numbers = value.split(/\d/).length - 1;
        if(numbers)
            return (10 <= numbers && numbers <= 20 && value.match(/^(\+){0,1}(\d|\s|\(|\)){10,20}$/));
        else
            return true;
    }, 'Invalid Phone/Fax format');
    
    $.validator.addMethod("alphanumeric", function(value, element) {
	return this.optional(element) || /^\w+$/i.test(value);
    }, "Letters, numbers, and underscores only please");
    
    $.validator.addMethod("characters", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
    }, "Letters only please");

    $.validator.addMethod("richtext", function(value, element) {
        value = value.replace("<br>", "");
        return (value.length>0) ? true : false;
    }, 'Missing description.');

    $.validator.addMethod('lessThan', function ($min, el, $max) {
        $max = parseInt($max);
        $max = $.isNumeric( $max )? $max : 0;
        $min = parseInt($min);
        $min = $.isNumeric( $min )? $min : 0;
        return ($min <= $max) ? true : false;
    },'Min must be less than max.');
    
    $.validator.addMethod('greaterThan', function ($max, el, $min) {
        $max = parseInt($max);
        $max = $.isNumeric( $max )? $max : 0;
        $min = parseInt($min);
        $min = $.isNumeric( $min )? $min : 0;
        return($max >= $min) ? true : false;
    },'Max must be greater than min.');

    var validator = $("#form_jobs").validate({
        debug: false,
        rules: {
            jobTitle: { required: true, minlength: 5 },
            functional_area: { required: true },
            industries: { required: true },
            job_type: { required: true },
            locations: { required: true },
            startDate: { required: true },
            expiryDate: { required: true },
            min_exp: { required: true, lessThan: function(){ return $("#Jobs_jobMaxExperience").val(); } },
            max_exp: { required: true, greaterThan: function(){ return $("#Jobs_jobMinExperience").val(); } },
            min_salary: { lessThan: function(){ return $("#salary_max").val(); } },
            max_salary: { greaterThan: function(){ return $("#salary_min").val(); } },
            job_description: { richtext: true },
            vacancies: { required: true },
            contactEmail: { required: true, validemail:true },
            min_age: { lessThan: function(){ return $("#Jobs_jobAgeMax").val(); } },
            max_age: { greaterThan: function(){ return $("#Jobs_jobAgeMin").val(); } },
            contactPerson: { characters: true },
            contactNumber: { minlength: 2, maxlength: 20, phone: true },
            hourly_salary: { digits: true },
            remote_website_url: {
                required: {
                    depends: function() {
                        return $('input[name=apply_remote_website]').is(":checked");
                    }
                }
            }
        },
        submitHandler: function(form){
            update_skills();
            if(validator.valid())
                form.submit();
        }
    });

    $.datepicker.setDefaults({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'mm/dd/yy'});

    $('#startDate').datepicker({
        minDate: '-1Y',
        onSelect: function(dateStr) {
            var min = $(this).datepicker('getDate') || new Date(); // Selected date or today if none
            var max = new Date(min.getTime());
            max.setMonth(max.getMonth() + 12); // Add one month
            $('#expiryDate').datepicker('option', {minDate: min, maxDate: max});
        }
    });
    $('#expiryDate').datepicker({
        minDate: '-30d',
        maxDate: '+1m',
        onSelect: function(dateStr) {
            var max = $(this).datepicker('getDate'); // Selected date or null if none
            $('#startDate').datepicker('option', {maxDate: max});
        }
    });
    
    $("#salary_min").fadeOut('fast');
    $("#salary_max").fadeOut('fast');
    $("#salary_hourly").fadeOut('fast');
    $("#confidential_salary").change(function() {
        $("#salary_min").fadeOut('fast');
        $("#salary_max").fadeOut('fast');
        $("#salary_hourly").fadeOut('fast');
    });

    $("#yearly_salary").change(function() {
        $("#salary_min").fadeIn('fast');
        $("#salary_max").fadeIn('fast');
        $("#salary_hourly").fadeOut('fast');
    });

    $("#hourly_salary").change(function() {
        $("#salary_hourly").fadeIn('fast');
        $("#salary_min").fadeOut('fast');
        $("#salary_max").fadeOut('fast');
    });
    
    $("[name=apply_remote_website]").click(function() {
        $("#apply_remote_website").toggleClass( "hidden" );
    });

    $("#auto_reply_apply").change(function() {
        $("#auto_reply_apply_text").toggle('fast');
    });
});
</script>