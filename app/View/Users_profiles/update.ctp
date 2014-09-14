<div class="box">
    <div class="boxheading">
        <a href="#" onclick="save_preview();" class="save-preview">Save & Preview</a>
        <h1>Update Your Profile</h1>
        <div class="boxheading-arrow"></div>
    </div>
    <div id="tabs">
        <ul>
            <li><a href="#fragment-1"><img src="<?php echo MEDIA_URL; ?>/img/icon-editprofile.png" width="15" height="16" />Edit Profile</a></li>
            <li><a href="#fragment-2"><img src="<?php echo MEDIA_URL; ?>/img/icon-editphoto.png" width="15" height="16" /> Photo</a></li>
            <li><a href="#fragment-3"><img src="<?php echo MEDIA_URL; ?>/img/icon-summary.png" width="15" height="16" /> Summary</a></li>
            <li><a href="#fragment-4"><img src="<?php echo MEDIA_URL; ?>/img/icon-education.png" width="15" height="16" /> Education</a></li>
            <li><a href="#fragment-5"><img src="<?php echo MEDIA_URL; ?>/img/icon-experience.png" width="15" height="16" /> Experience</a></li>
            <li><a href="#fragment-6"><img src="<?php echo MEDIA_URL; ?>/img/icon-skills.png" width="15" height="16" /> Professional Skills</a></li>

            <li><a href="#fragment-7"><img src="<?php echo MEDIA_URL; ?>/img/icon-status.png" width="15" height="16" /> Availability Status</a></li>
            <!--<li><img src="<?php echo MEDIA_URL; ?>/img/icon-changepass.png" width="15" height="16" /> Change Password</li>
            <li><img src="<?php echo MEDIA_URL; ?>/img/icon-shortcourse.png" width="15" height="16" /> Short Courses</li>
            <li><img src="<?php echo MEDIA_URL; ?>/img/icon-trainignaward.png" width="15" height="16" /> Trainings/Awards</li>
            <li><img src="<?php echo MEDIA_URL; ?>/img/icon-voluntry.png" width="15" height="16" /> Voluntary Work</li>
            <li><img src="<?php echo MEDIA_URL; ?>/img/icon-membership.png" width="15" height="16" /> Alumni/Membership</li>
            <li><img src="<?php echo MEDIA_URL; ?>/img/icon-hobbies.png" width="15" height="16" /> Hobbies</li>-->
        </ul>

        <div>
            <!--Profile Tab Start -->
            <div id="fragment-1" class="ui-tabs-panel">
                <div class=""><h1>Basic Information</h1></div>
                <div class="success_msg" id="message_profile" style="display:none;">Your profile has been updated successfully!</div>
                <div class="formstyle">
                    <fieldset>
                        <label for="">Title</label>
                        <label1>
                            <select name="title" id="title" class="droplist">
                                <option value="" <?php echo ('' == $profilefields['title']) ? ' selected="selected" ' : ''; ?>>Select</option>
                                <?php if ('Mr' == $profilefields['title']) { ?>
                                    <option value="Mr" selected="selected">Mr</option>
                                <?php } else { ?>
                                    <option value="Mr">Mr</option>
                                <?php } ?>
                                <?php if ('Mrs' == $profilefields['title']) { ?>
                                    <option value="Mrs" selected="selected">Mrs</option>
                                <?php } else { ?>
                                    <option value="Mrs">Mrs</option>
                                <?php } ?>
                                <?php if ('Miss' == $profilefields['title']) { ?>
                                    <option value="Miss" selected="selected">Miss</option>
                                <?php } else { ?>
                                    <option value="Miss">Miss</option>
                                <?php } ?>
                                <?php if ('Ms' == $profilefields['title']) { ?>
                                    <option value="Ms." selected="selected">Ms</option>
                                <?php } else { ?>
                                    <option value="Ms">Ms</option>
                                <?php } ?>
                            </select>
                        </label1>
                        <label for="">First Name <span class="redcolor">*</span></label>
                        <label1>
                            <a href="#first"></a>
                          <?php echo $this->Form->text('firstname', array('required' => true, 'value' => $profilefields['firstname'], 'class' => 'required', 'id' => 'first')); ?>
                            <span id="first_error" style="display:none;"></span>
                        </label1>
                        <label for="">Last Name </label></label>
                        <label1>
                            <?php echo $this->Form->text('lastname', array('required' => false, 'value' => $profilefields['lastname'], 'id' => 'last')); ?>
                            <!--span class="hide-text"><input type="checkbox" <?php// if ($profilefields['lastname_hide'] == 1) echo 'checked= checked'; ?> value="0" id="hide_lname" name="data[Users_profile][hide_lastname]">&nbsp;Hide from profile? </span-->
                            <span id="last_error" style="display:none;"></span>
                        </label1>
                        <label for="">Gender </label>
                        <label1>
                            <select name="gender" id="gender" class="droplist" onblur="genderVlidate('gender')">
                                <option value="" <?php echo ('' == $profilefields['gender']) ? ' selected="selected" ' : ''; ?>>Select</option>
                                <?php if ('Male' == $profilefields['gender']) { ?>
                                    <option value="Male" selected="selected">Male</option>
                                <?php } else { ?>
                                    <option value="Male">Male</option>
                                <?php } ?>
                                <?php if ('Female' == $profilefields['gender']) { ?>
                                    <option value="Female" selected="selected">Female</option>
                                <?php } else { ?>
                                    <option value="Female">Female</option>
                                <?php } ?>
                            </select>
                            <span class="hide-text"><input type="checkbox" value="0" <?php if ($profilefields['gender_hide'] == 1) echo 'checked= checked'; ?> id="hide_gender" name="data[Users_profile][hide_gender]">&nbsp;Hide from profile? </span>
                            <div id="gender_error"  class="validate_error" style="display:none;"></div>
                        </label1>

                        <label for="">Marital Status</label>
                        <label1>
                            <select name="marital_status" id="marital_status" class="droplist">
                                <option value="" <?php echo ('' == $profilefields['marital_status']) ? ' selected="selected" ' : ''; ?>>Select</option>
                                <?php if ('Single' == $profilefields['marital_status']) { ?>
                                    <option value="Single" selected="selected">Single</option>
                                <?php } else { ?>
                                    <option value="Single">Single</option>
                                <?php } ?>
                                <?php if ('Married' == $profilefields['marital_status']) { ?>
                                    <option value="Married" selected="selected">Married</option>
                                <?php } else { ?>
                                    <option value="Married">Married</option>
                                <?php } ?>
                            </select>
                            <span class="hide-text"><input type="checkbox" <?php if ($profilefields['marital_status_hide'] == 1) echo 'checked= checked'; ?> value="0" id="hide_marital" name="data[Users_profile][hide_marital]">&nbsp;Hide from profile? </span>
                            <div id="gender_error"  class="validate_error" style="display:none;"></div>
                        </label1>

                        <label for="">Date of Birth<span class="redcolor">*</span></label>
                        <label1>
                            <?php
                            $doB = date("d-M-Y", strtotime($profilefields['birth_date']));
                            echo $this->Form->text('birth_date', array(
                                'value' => $doB, 'id' => 'inputField', 'class' => 'textfield', 'onBlur' => 'birthVlidate("inputField")', 'style' => '','readonly'=>true
                            ));
                            ?>
                            <span class="hide-text"> <input type="checkbox" name="data[Users_profile][hide_year]" id="hide_year" <?php if ($profilefields['hide_year'] == 1) echo 'checked= checked'; ?> value="0" />  Hide Year.</span>
                            <div class="clear"></div>
                            <div id="birth_error"  class="validate_error" style="display:none;"></div>
                        </label1>
                        <label for="">Nationality</label>
                        <label1>
                            <select name="data[Users_profile][nationality]" id="nationality" class="droplist" style="width:237px;">
                                <option value="" <?php echo ('' == $profilefields['nationality']) ? ' selected="selected" ' : ''; ?>>Select</option>
                                <?php
                                foreach ($countries as $countryRow) {
                                    if ($countryRow['Country']['id'] == $profilefields['nationality']) {
                                        ?>
                                        <option value="<?php echo $countryRow['Country']['id']; ?>" selected="selected"><?php echo $countryRow['Country']['name']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $countryRow['Country']['id']; ?>"><?php echo $countryRow['Country']['name']; ?></option>
                                    <?php }
                                }
                                ?>
                            </select>
                      <span class="hide-text"><input type="checkbox" <?php if ($profilefields['nationality_hide'] == 1) echo 'checked= checked'; ?> value="0" id="hide_nationality" name="data[Users_profile][hide_nationality]">&nbsp;Hide from profile? </span>
                            <span id="nationality_error"  class="validate_error" style="display:none;"></span>
                        </label1>
                        <label for="">Professional Headline<span class="redcolor">*</span></label>
                        <label1><?php echo $this->Form->text('tags', array('required' => false, 'value' => $profilefields['tags'], 'id' => 'tags')) ?>
                        <span class="hide-text">
                        <input type="checkbox" <?php if ($profilefields['tags_hide'] == 1) echo 'checked= checked'; ?> value="0" id="hide_tags" name="data[Users_profile][hide_tags]">&nbsp;Hide from profile? </span>
                            <span id="tags_error" style="display:none;"></span>
                        </label1>
                        <label for="">Sector/ Industry </label>
                        <label1>
                            <select name="data[Users_profile][industry_id]" id="industry_id" class="droplist" style="width:237px;">
                                <option value="" <?php echo ('' == $profilefields['industry_id']) ? ' selected="selected" ' : ''; ?>>Select</option>
                                <?php
                                foreach ($industries as $industryRow) {
                                    if ($industryRow['Industry']['id'] == $profilefields['industry_id']) {
                                        ?>
                                        <option value="<?php echo $industryRow['Industry']['id']; ?>" selected="selected"><?php echo $industryRow['Industry']['title']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $industryRow['Industry']['id']; ?>"><?php echo $industryRow['Industry']['title']; ?></option>
    <?php }
}
?>
                            </select>
                            <span class="hide-text"><input type="checkbox" <?php if ($profilefields['industry_id_hide'] == 1) echo 'checked= checked'; ?> value="0" id="hide_industry" name="data[Users_profile][hide_industry]">&nbsp;Hide from profile? </span>
                            <div id="industry_id_error" class="validate_error" style="display:none;"></div>
                        </label1>
                        <label for="">Phone</label>
                        <label1>
                            <?php echo $this->Form->text('phone', array('required' => false, 'value' => $profilefields['phone'], 'name' => 'phone', 'id' => 'phone')); ?>
                            <span class="hide-text"><input type="checkbox" <?php if ($profilefields['phone_hide'] == 1) echo 'checked= checked'; ?> value="0" id="hide_phone" name="data[Users_profile][hide_phone]">&nbsp;Hide from profile? </span>
                            <span class="hide-text">e.g. 00971-41234567</span>
                            <sapn id="phone_error" style="display:none;"></span>
                        </label1>
                        <label for="">Mobile</label>
                        <label1>
                            <?php echo $this->Form->text('mobile', array('required' => false, 'value' => $profilefields['mobile'], 'name' => 'mobile', 'id' => 'mobile')); ?>
                            <span class="hide-text"><input type="checkbox" <?php if ($profilefields['mobile_hide'] == 1) echo 'checked= checked'; ?> value="0" id="hide_mobile" name="data[Users_profile][hide_mobile]">&nbsp;Hide from profile? </span>
                            <span class="hide-text">e.g. 00971-55-1234567</span>
                            <span id="mobile_error" style="display:none;"></span>
                        </label1>
                        <label for="">Address1</label>
                        <label1>
						<?php echo $this->Form->text('address1', array('required' => true, 'value' => $profilefields['address1'], 'name' => 'address1', 'id' => 'address1')) ?>
						<span class="hide-text"><input type="checkbox" <?php if ($profilefields['address1_hide'] == 1) echo 'checked= checked'; ?> value="0" id="hide_address1" name="data[Users_profile][hide_address1]">&nbsp;Hide from profile? </span>
                        </label1>
                        <label for="">Address2</label>
                        <label1>
                         <?php echo $this->Form->text('address2', array('required' => false, 'value' => $profilefields['address2'], 'name' => 'address2', 'id' => 'address2')) ?>
                         <span class="hide-text"><input type="checkbox" <?php if ($profilefields['address2_hide'] == 1) echo 'checked= checked'; ?> value="0" id="hide_address2" name="data[Users_profile][hide_address2]">&nbsp;Hide from profile? </span>
                        </label1>
                        <label for="">P.O.Box</label>
                        <label1>
						<?php echo $this->Form->text('pobox', array('required' => false, 'value' => $profilefields['zip'], 'id' => 'pobox', 'id' => 'pobox')) ?>
                        <span class="hide-text"><input type="checkbox" <?php if ($profilefields['zip_hide'] == 1) echo 'checked= checked'; ?> value="0" id="hide_zip" name="data[Users_profile][hide_zip]">&nbsp;Hide from profile? </span>
                        </label1>

                        <label for="">Country of Residence </label>
                        <label1>
                            <select  name="country_id" id="country_id" class="droplist" style="width:237px;">
                                <option value="" <?php echo ('' == $profilefields['country_id']) ? ' selected="selected" ' : ''; ?>>Select</option>
                                <?php
                                foreach ($countries as $countryRow) {
                                    if ($countryRow['Country']['id'] == $profilefields['country_id']) {
                                        ?>
                                        <option value="<?php echo $countryRow['Country']['id']; ?>" selected="selected"><?php echo $countryRow['Country']['name']; ?></option>
    <?php } else { ?>
                                        <option value="<?php echo $countryRow['Country']['id']; ?>"><?php echo $countryRow['Country']['name']; ?></option>
    <?php }
}
?>
                            </select>
                            <span class="hide-text"><input type="checkbox" <?php if ($profilefields['country_id_hide'] == 1) echo 'checked= checked'; ?> value="0" id="hide_country" name="data[Users_profile][hide_country]">&nbsp;Hide from profile? </span>
                            <div id="country_id_error" class="validate_error" style="display:none;"></div>
                        </label1>

                        <label for="">City <span class="redcolor">*</span></label>
                        <label1>
						<?php echo $this->Form->text('city', array('onBlur' => 'cityVlidate("city")', 'value' => $profilefields['city'], 'name' => 'city', 'id' => 'city')) ?>
                        <span class="hide-text"><input type="checkbox" <?php if ($profilefields['city_hide'] == 1) echo 'checked= checked'; ?> value="0" id="hide_city" name="data[Users_profile][hide_city]">&nbsp;Hide from profile? </span>
                            <div id="city_error" style="display:none;"></div>
                        </label1>
						
                    </fieldset>
                </div>
            </div>
            <!--Profile Tab end -->

            <!--Photo start -->
            <div id="fragment-2" class="ui-tabs-panel ui-tabs-hide">
                <div class="marginbottom20"><h1>Profile Photo</h1></div>
                <div class="success_msg" id="message_photo" style="display:none;">Profile Photo updated successfully!</div>
                <div id="photo_error" class="error_msg" style="display: none;"></div>
                <div id="photo_loader" style="display:none; text-align:center;">
					<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
				</div>
                <div id="ajax_photo_response">
				<?php if ($imgname) { ?>
                        <div style="float:left;width:60px;">
                            <img src="<?php echo MEDIA_URL . '/files/user/icon/' . $imgname ?>" width="50" height="50" id="photo_style_1" />
                        </div>
                        <div style="float:left;width:110px;">
                            <img src="<?php echo MEDIA_URL . '/files/user/thumbnail/' . $imgname ?>" width="100" height="100" id="photo_style_2" />
                        </div>

                        <div style="float:left;width:169px;height:169px;">
                            <img src="<?php echo MEDIA_URL . '/files/user/logo/' . $imgname ?>" width="165" height="165" id="photo_style_3" />
                        </div>
			<?php } else {
   						 ?>
                        <div style="float:left;width:60px;">
                            <img src="<?php echo MEDIA_URL . '/img/nophoto.jpg' ?>" width="50" height="50" />
                        </div>
                        <div style="float:left;width:110px;">
                            <img src="<?php echo MEDIA_URL . '/img/nophoto.jpg' ?>" width="100" height="100" />
                        </div>

                        <div style="float:left;width:169px;height:169px;">
                            <img src="<?php echo MEDIA_URL . '/img/nophoto.jpg' ?>" width="165" height="165" />
                        </div>
                        <?php } ?>
                </div>

                <div class="clear"></div>
                <div style="margin-top:15px;">
                    <div>
                                        <?php echo $this->Form->create('Users_profile', array('url' => '/users_profiles/userphoto/', 'enctype' => 'multipart/form-data', 'id' => 'photoUploader')); ?>
                        <div class="userpic-attach-file">
                            <table width="100%" border="0" cellspacing="2" cellpadding="1">
                                <tr>
                                    <td>
                                        <?php echo $this->Html->image(MEDIA_URL . '/img/upload_photo_button.png', array('class' => 'userpic-uploadimg')); ?>

<?php echo $this->Form->file('photo', array('required' => false, 'id' => 'uploadfile', 'class' => 'userpic-attachedfile-style', 'onClick' => 'showButton();')); ?>
                                    </td>
                                    <td>
                        <?php echo $this->Form->submit('Upload Picture', array('div' => false, 'id' => 'uploadPhoto', 'class' => 'uploadphoto-bttn', 'style' => 'display:none;')); ?>
                                    </td>
                                </tr>
                            </table>
                        </div>

<?php echo $this->Form->end(); ?>
                    </div>
                    <div class="clear"></div>
                    <div class="take_photo_webcam">
                        <div class="or_textstyle">Or</div>
                        <a href="#?" rel="camera" class="poplight webcam"> Take & Upload Photo for Webcam</a>
                    </div>
                    <div id="photos" style="height:0px;"></div>
                    <div id="camera" class="popup_block">
                        <span class="tooltip"></span>
                        <span class="camTop">Take Photo</span>
                        <div id="screen"></div>

                        <div id="output" style="width: 503px;display:none; text-align:center;background: #CCCCCC;color: #666666;height: 370px;position:absolute;top:76px;">
<?php echo $this->Html->image(MEDIA_URL . '/img/loading.gif', array('style' => 'margin-top:138px;')); ?>
                        </div>
                        <div id="buttons">
                            <div class="buttonPane">
                                <a id="shootButton" href="" class="blueButton">Shoot!</a>
                            </div>
                            <div class="buttonPane hidden">
                                <a id="cancelButton" href="" class="blueButton">Cancel</a>
                                <a id="uploadButton" href="" class="greenButton">Upload!</a>
                            </div>
                        </div>
                        <span class="settings"></span>
                    </div>
                </div>
				<div id="basic_info_loader" style="display:none; text-align:center;">
					<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
				</div>
            </div>
            <!--Photo Tab end -->

            <!--Profile Summary Tab start -->
            <div id="fragment-3" class="ui-tabs-panel ui-tabs-hide">
                <div class="marginbottom20"><h1>Profile Summary</h1></div>
                <div class="success_msg" id="smuuary_sucsses" style="display:none;">Profile Summary updated successfully!</div>
                <div id="ajax_summary_response" class="formstyle">
                    <?php echo $this->Form->create('Users_profile', array('url' => '/users_profiles/profile_summary/', 'id' => 'summaryUploader', 'name' => 'summaryUploader')); 		                     ?>
				<?php
                echo $this->Form->textarea('summary', array('required' => false,
															'style' => array('width:475px; height:200px; padding:6px;'),
															'value' => $profilefields['summary'],
															'id' => 'pro_summary'
															)
										   );
                ?>
                <?php //echo $this->Form->submit('Submit',array('div'=>false,'id'=>'summary_btn'));   ?>
                <?php echo $this->Form->end(); ?>
                </div>
                <span id="summary_error" class="redcolor"></span>
            </div>
            <!--Profile Summary Tab end -->


            <!--Education Tab start -->
            <div id="fragment-4" class="ui-tabs-panel ui-tabs-hide">
                <div class="success_msg" id="message_edu" style="display:none;">Qualification added successfully!</div>
                <div class="success_msg" id="message_edit_edu" style="display:none;">Qualification edited successfully!</div>
                <div class="success_msg" id="delete_edu" style="display:none;">Education deleted successfully!</div>
                <div class="marginbottom20">
                    <a href="#?" rel="addEdu" class="poplight addedu">Add Education</a>
                    <h1>Education</h1>
                </div>

                <div id="addEdu" class="popup_block">
                    <div id="popup_content"> <!--your content start-->
                    	 <div id="add_edu_loader" style="display:none; text-align:center;">
						<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
						</div>
                        <div class="userprofile-form">
                            <h1>Your Qualification</h1>
                            <div class="error_msg" id="qualification_error" style="display:none;"></div>
                            <form action="<?php echo NETWORKWE_URL;?>/users_profiles/user_edu/" method="post" id="edu_Upload" name="edu_Upload">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td><strong>School/University/Institute Name<span class="note-text">*</span></strong></td>
                                    </tr>
                                    <tr>
                                        <td style="position:relative;">
                                            <select type="text" name="institute_title" id="institute_title" onblur="instituteValidate('institute_title')" ></select>
                                            <span class="redcolor" id="institute_error"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Qualification<span class="note-text">*</span></strong></td>
                                    </tr>
                                    <tr>
                                        <td style="position:relative;">
                                            <select type="text" name="qualification_title" id="qualification_title" onblur="qualificationValidate('qualification_title')"></select>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Major</strong></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="data[users_qualifications][field_study]" id="field_study" class="textfield" size="60" /></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Grade</strong></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="data[users_qualifications][grade]" id="grade" class="textfield" size="60" /></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Start Date</strong></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="data[users_qualifications][stmonth]" class="droplist" id="startmonth">
                                                <option selected="selected" value="0">Select Month</option>
                                                <option value = "01">January</option>
                                                <option value = "02">February</option>
                                                <option value = "03">March</option>
                                                <option value = "04">April</option>
                                                <option value = "05">May</option>
                                                <option value = "06">June</option>
                                                <option value = "07">July</option>
                                                <option value = "08">August</option>
                                                <option value = "09">September</option>
                                                <option value = "10">October</option>
                                                <option value = "11">November</option>
                                                <option value = "12">December</option>
                                            </select>
                                                <?php $current_year = date('Y'); ?>
                                            <select name="data[users_qualifications][styear]" class="droplist" id="startyear">
                                                <option value="0" selected="selected">Select Year</option>
											<?php for ($i = $current_year; $i >= 1970; $i--) {
                                                ?>
                                                  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
											<?php } ?>
                                            </select>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>End Date</strong></td>
                                    </tr>
                                    <tr>
                                        <td><select name="data[users_qualifications][enmonth]" class="droplist" id="enmonth">
                                                <option selected="selected" value="0">Select Month</option>
                                                <option value = "01">January</option>
                                                <option value = "02">February</option>
                                                <option value = "03">March</option>
                                                <option value = "04">April</option>
                                                <option value = "05">May</option>
                                                <option value = "06">June</option>
                                                <option value = "07">July</option>
                                                <option value = "08">August</option>
                                                <option value = "09">September</option>
                                                <option value = "10">October</option>
                                                <option value = "11">November</option>
                                                <option value = "12">December</option>
                                            </select>
										<?php $current_year = date('Y'); ?>
                                            <select name="data[users_qualifications][enyear]" class="droplist" id="enyear">
                                                <option value="0" selected="selected">Select Year</option>
										<?php for ($i = $current_year; $i >= 1970; $i--) { ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
												<?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="submit" name="edu_button" value="Submit" class="red-bttn" id="edu_button" />

                                        </td>

                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div> <!--your content end-->
                </div>
                <div id="editEdu" class="popup_block">
                    <div id="popup_content"> <!--your content start-->
                    <div id="edit_edu_loader" style="display:none; text-align:center;">
						<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
					</div>
                        <div class="userprofile-form">
                            <h1>Your Qualification</h1>
                            <div class="error_msg" id="qualification_edit_error" style="display:none;"></div>
                            <form action="" method="post" id="edu_edit_form" name="edu_Upload">
<?php echo $this->Form->hidden('edu_id', array('value' => ($edu_id) ? $edu_id : '', 'name' => 'edu_id', 'id' => 'edu_id')); ?>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td><strong>School/University/Institute Name<span class="note-text">*</span></strong></td>
                                    </tr>
                                    <tr>
                                        <td style="position:relative;" id="institute_idd">
                                            <select type="text" name="institute_title" id="institute_title_edit" onblur="instituteValidate('institute_title')" ></select>
                                            <span class="redcolor" id="institute_error"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Qualification<span class="note-text">*</span></strong></td>
                                    </tr>
                                    <tr>
                                        <td style="position:relative;" id="qualification_idd">
                                            <select type="text" name="qualification_title" id="qualification_title_edit" onblur="qualificationValidate('qualification_title')"></select>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Major</strong></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="data[users_qualifications][field_study]" id="field_study_edit" class="textfield" size="60" /></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Grade</strong></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="data[users_qualifications][grade]" id="grade_edit" class="textfield" size="60" /></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Start Date</strong></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="data[users_qualifications][stmonth]" class="droplist" id="startmonth_edit">
                                                <option selected="selected" value="0">Select Month</option>
                                                <option value = "01">January</option>
                                                <option value = "02">February</option>
                                                <option value = "03">March</option>
                                                <option value = "04">April</option>
                                                <option value = "05">May</option>
                                                <option value = "06">June</option>
                                                <option value = "07">July</option>
                                                <option value = "08">August</option>
                                                <option value = "09">September</option>
                                                <option value = "10">October</option>
                                                <option value = "11">November</option>
                                                <option value = "12">December</option>
                                            </select>
                                                <?php $current_year = date('Y'); ?>
                                            <select name="data[users_qualifications][styear]" class="droplist" id="startyear_edit">
                                                <option value="0" selected="selected">Select Year</option>
<?php for ($i = $current_year; $i >= 1970; $i--) {
    ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                                            </select>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>End Date</strong></td>
                                    </tr>
                                    <tr>
                                        <td><select name="data[users_qualifications][enmonth]" class="droplist" id="enmonth_edit">
                                                <option selected="selected" value="0">Select Month</option>
                                                <option value = "01">January</option>
                                                <option value = "02">February</option>
                                                <option value = "03">March</option>
                                                <option value = "04">April</option>
                                                <option value = "05">May</option>
                                                <option value = "06">June</option>
                                                <option value = "07">July</option>
                                                <option value = "08">August</option>
                                                <option value = "09">September</option>
                                                <option value = "10">October</option>
                                                <option value = "11">November</option>
                                                <option value = "12">December</option>
                                            </select>
											<?php $current_year = date('Y'); ?>
                                            <select name="data[users_qualifications][enyear]" class="droplist" id="enyear_edit">
                                                <option value="0" selected="selected">Select Year</option>
												<?php for ($i = $current_year; $i >= 1970; $i--) { ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
												<?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="submit" name="edu_button" value="Submit" class="red-bttn" id="edu_button_edit" />

                                        </td>

                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div> <!--your content end-->
                </div>

                <div class="editprofile">
                    <span id="ajax_edu_response">
<?php
foreach ($user_qualification as $edu__Row) {
    $start_date = $edu__Row['users_qualifications']['start_date'];
    $end_date = $edu__Row['users_qualifications']['end_date'];
    $edu_id = $edu__Row['users_qualifications']['id'];
    ?>
                            <div class="profile-box-content" id="<?php echo $edu_id; ?>">
                                <ul>
                                    <li>
                                        <h1><?php echo $edu__Row['institutes']['title']; ?></h1>
                                    </li>
                                    <li><?php echo $edu__Row['qualifications']['title']; ?></li>
                                    <li><?php echo $start_date . " - " . $end_date; ?></li>
                                    <li><a href="#?" rel="editEdu" onclick="edit_edu('<?php echo $edu_id; ?>')" class="poplight edit">Edit</a> <a href="javascript:void(0)" onclick="delete_edu('<?php echo $edu_id; ?>');" class="delete">Remove</a></li>
                                </ul>
                                <div class="clear"></div>
                            </div>
<?php } ?>
                    </span>
                </div>
            </div>
            <!--Education Tab end -->

            <!--Experience Tab start -->
            <div id="fragment-5" class="ui-tabs-panel ui-tabs-hide">
                <div class="success_msg" id="message_exp" style="display:none;">Position added successfully!</div>
                <div class="success_msg" id="message_edit_exp" style="display:none;">Position edited successfully!</div>
                <div class="success_msg" id="delete_exp" style="display:none;">Position deleted successfully!</div>
                <div class="marginbottom20">
                    <a href="#?" rel="addExp" class="poplight addedu">Add Position</a>
                    <h1>Experience</h1>
                </div>

                <div id="addExp" class="popup_block">
                    <div class="error_msg" id="experience_error" style="display:none;"></div>
                    <div id="popup_content"> <!--your content start-->
                    	<div id="add_exp_loader" style="display:none; text-align:center;">
						<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
						</div>
                        <form action="<?php echo NETWORKWE_URL;?>/users_profiles/userexp/" method="post" id="exp_Upload" class="userprofile-form">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td><strong>Company Name<span class="note-text">*</span></strong></td>
                                </tr>
                                <tr>
                                    <td style="position:relative;">
                                        <select type="text" name="company_title" id="company_title"></select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Location</strong></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="data[Users_profile][location]" class="textfield" size="60" />    </td>
                                </tr>
                                <tr>
                                    <td><strong>Designation</strong></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="data[Users_profile][designation]" id="designation" class="textfield" size="60" />    </td>
                                </tr>
                                
                                 <tr>
                                    <td><strong>Job Description</strong></td>
                                </tr>
                                <tr>
                                    <td>   
                                    	<textarea rows="4" cols="51" class="textfield" name="data[Users_profile][responsibilities]" id="responsibilities"></textarea>
                                     </td>
                                </tr>
                                
                                <tr>
                                    <td><strong>Start Date</strong></td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="data[Users_profile][stmonth]" class="droplist" id="st_month">
                                            <option selected="selected" value="0">Select Month</option>
                                            <option value = "01">January</option>
                                            <option value = "02">February</option>
                                            <option value = "03">March</option>
                                            <option value = "04">April</option>
                                            <option value = "05">May</option>
                                            <option value = "06">June</option>
                                            <option value = "07">July</option>
                                            <option value = "08">August</option>
                                            <option value = "09">September</option>
                                            <option value = "10">October</option>
                                            <option value = "11">November</option>
                                            <option value = "12">December</option>
                                        </select>
									<?php $current_year = date('Y'); ?>
                                        <select name="data[Users_profile][styear]" class="droplist" id="st_year">
                                            <option value="0" selected="selected">Select Year</option>
										<?php for ($i = $current_year; $i >= 1970; $i--) { ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php } ?>
                                        </select>

                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>End Date</strong></td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="data[Users_profile][enmonth]" class="droplist" id="en_month">
                                            <option selected="selected" value="0">Select Month</option>
                                            <option value = "01">January</option>
                                            <option value = "02">February</option>
                                            <option value = "03">March</option>
                                            <option value = "04">April</option>
                                            <option value = "05">May</option>
                                            <option value = "06">June</option>
                                            <option value = "07">July</option>
                                            <option value = "08">August</option>
                                            <option value = "09">September</option>
                                            <option value = "10">October</option>
                                            <option value = "11">November</option>
                                            <option value = "12">December</option>
                                        </select>
                                            <?php $current_year = date('Y'); ?>
                                        <select  name="data[Users_profile][enyear]" class="droplist" id="en_year">
                                            <option value="0" selected="selected">Select Year</option>
										<?php for ($i = $current_year; $i >= 1970; $i--) {
                                            ?>
                                             <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" value="Present" onclick="disabledField()" id="presents" <?php if ($user_Exp['end_date'] == 'Present') echo 'checked=checked'; ?> name="data[Users_profile][presents]" />&nbsp;&nbsp; Present
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="submit" name="Submit" value="Submit" class="red-bttn" id="exp_button" /></td>
                                </tr>
                            </table>
                        </form>
                    </div> <!--your content end-->
                </div>
                <div id="editExp" class="popup_block">
                    <div class="error_msg" id="experience_error" style="display:none;"></div>
                    <div id="edit_exp_loader" style="display:none; text-align:center;">
						<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
					</div>
                    <div id="popup_content"> <!--your content start-->
                        <form action="" method="post" id="exp_edit_form" class="userprofile-form">
							<?php echo $this->Form->hidden('exp_id', array('value' => ($exp_id) ? $exp_id : '', 'name' => 'exp_id', 'id' => 'exp_id')); ?>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td><strong>Company Name<span class="note-text">*</span></strong></td>
                                </tr>
                                <tr>
                                    <td style="position:relative;">
                                        <select type="text" name="company_title" id="company_title_edit"></select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Location</strong></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="data[Users_profile][location]" id="exp_location" class="textfield" size="60" />    </td>
                                </tr>
                                <tr>
                                    <td><strong>Designation</strong></td>
                                </tr>
                                
                                <tr>
                                    <td><input type="text" name="data[Users_profile][designation]" id="exp_designation" class="textfield" size="60" />    </td>
                                </tr>
                                <tr>
                                    <td><strong>Job Description</strong></td>
                                </tr>
                                <tr>
                                    <td>   
                                    	<textarea rows="4" cols="51" class="textfield" name="data[Users_profile][responsibilities]" id="responsibilities"></textarea>
                                     </td>
                                </tr>
                                <tr>
                                    <td><strong>Start Date</strong></td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="data[Users_profile][stmonth]" class="droplist" id="exp_s_month">
                                            <option selected="selected" value="0">Select Month</option>
                                            <option value = "01">January</option>
                                            <option value = "02">February</option>
                                            <option value = "03">March</option>
                                            <option value = "04">April</option>
                                            <option value = "05">May</option>
                                            <option value = "06">June</option>
                                            <option value = "07">July</option>
                                            <option value = "08">August</option>
                                            <option value = "09">September</option>
                                            <option value = "10">October</option>
                                            <option value = "11">November</option>
                                            <option value = "12">December</option>
                                        </select>
									<?php $current_year = date('Y'); ?>
                                        <select name="data[Users_profile][styear]" class="droplist" id="exp_s_year">
                                            <option value="0" selected="selected">Select Year</option>
											<?php for ($i = $current_year; $i >= 1970; $i--) { ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
											<?php } ?>
                                        </select>

                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>End Date</strong></td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="data[Users_profile][enmonth]" class="droplist" id="exp_e_month">
                                            <option selected="selected" value="0">Select Month</option>
                                            <option value = "01">January</option>
                                            <option value = "02">February</option>
                                            <option value = "03">March</option>
                                            <option value = "04">April</option>
                                            <option value = "05">May</option>
                                            <option value = "06">June</option>
                                            <option value = "07">July</option>
                                            <option value = "08">August</option>
                                            <option value = "09">September</option>
                                            <option value = "10">October</option>
                                            <option value = "11">November</option>
                                            <option value = "12">December</option>
                                        </select>
                                            <?php $current_year = date('Y'); ?>
                                        <select  name="data[Users_profile][enyear]" class="droplist" id="exp_e_year">
                                            <option value="0" selected="selected">Select Year</option>
										<?php for ($i = $current_year; $i >= 1970; $i--) {
                                            ?>
                                              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" value="<?php echo $current_date = date('m-Y'); ?>" onclick="disabledExpField()" id="exp_presents" <?php if ($user_Exp['end_date'] == 'Present') echo 'checked=checked'; ?> name="data[Users_profile][presents]" />&nbsp;&nbsp; Present
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="submit" name="Submit" value="Submit" class="red-bttn" id="exp_button_edit" /></td>
                                </tr>
                            </table>
                        </form>
                    </div> <!--your content end-->
                </div>

                <div class="editprofile">
                    <span id="ajax_exp_response">
                        <?php
                        foreach ($user_experience as $exp__Row) {
                            $exp_id = $exp__Row['users_experiences']['id'];
                            $start_date = $exp__Row['users_experiences']['start_date'];
                            if ($exp__Row['users_experiences']['end_date'] != 'Present') {
                                $end_date = $exp__Row['users_experiences']['end_date'];
                            } else {
                                $end_date = $exp__Row['users_experiences']['end_date'];
                            }
                            ?>
                            <div class="profile-box-content" id="<?php echo $exp_id; ?>">
                                <div class="exp-com-logo">
                                    <?php
                                    if ($exp__Row['companies']['logo'] && file_exists(MEDIA_PATH . '/files/company/logo/' . $exp__Row['companies']['logo'])) {
                                        echo $this->Html->image(MEDIA_URL . '/files/company/logo/' . $exp__Row['companies']['logo'], array('style' => 'width:60px; height:60px; float:right;'));
                                    } else {
                                        echo $this->Html->image(MEDIA_URL . '/img/nologo.jpg', array('style' => 'width:60px; height:60px; float:right;'));
                                    }
                                    ?>
                                </div>
                                <div class="profile-box-content-rgt">
                                    <ul>
                                        <li>
                                            <h1><a href="#"><?php echo $exp__Row['users_experiences']['designation']; ?></a></h1>
                                        </li>
                                        <li>
                                            <a href="#"><?php echo $exp__Row['companies']['title']; ?></a>
                                        </li>
                                        <li><?php echo $start_date . " - " . $end_date; ?> - <?php echo $exp__Row['users_experiences']['location']; ?></li>
                                        <li><a href="#?" rel="editExp" onclick="edit_exp('<?php echo $exp_id; ?>')" class="poplight edit">Edit</a> <a href="javascript:void(0)" onclick="delete_exp('<?php echo $exp_id; ?>');" class="delete">Remove</a></li>
                                    </ul>
                                </div>
                                <div class="clear"></div>
                            </div>
<?php } ?>
                    </span>
                </div>
            </div>
            <!--Experience Tab end -->

            <!--Skill Tab start -->
            <div id="fragment-6" class="ui-tabs-panel ui-tabs-hide">
                <div class="success_msg" id="message_skill" style="display:none;">Skill added successfully!</div>
                <div class="success_msg" id="delete_skill" style="display:none;">Skill deleted successfully!</div>
                <div class="marginbottom20">
                    <a href="#?" rel="addSkill" class="poplight addedu">Add a Skill</a>
                    <h1>Professional Skills</h1>
                </div>
                <div id="addSkill" class="popup_block">
                    <div class="error_msg" id="skill_error" style="display:none;"></div>
                    <div id="popup_content"> <!--your content start-->
                        <form action="/users_profiles/user_skill/" method="post" id="skill_Upload" class="userprofile-form">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td><strong>Skill Title</strong></td>
                                </tr>
                                <tr>
                                    <td style="position:relative;">
                                        <select name="skill_title" id="skill_title"></select>
                                        <br/>
                                        <span class="smalltext rgt">i.e. Executive Search, Technical Architecture, Team Management</span>
                                        <div class="clear"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Start Date</strong></td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="data[Users_profile][stmonth]" class="droplist">
                                            <option selected="selected" value="0">Select Month</option>
                                            <option value = "01">January</option>
                                            <option value = "02">February</option>
                                            <option value = "03">March</option>
                                            <option value = "04">April</option>
                                            <option value = "05">May</option>
                                            <option value = "06">June</option>
                                            <option value = "07">July</option>
                                            <option value = "08">August</option>
                                            <option value = "09">September</option>
                                            <option value = "10">October</option>
                                            <option value = "11">November</option>
                                            <option value = "12">December</option>
                                        </select>
                                            <?php $current_year = date('Y'); ?>
                                        <select id="birthyear" name="data[Users_profile][styear]" class="droplist">
                                            <option value="0" selected="selected">Select Year</option>
<?php for ($i = $current_year; $i >= 1970; $i--) {
    ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                                        </select>

                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>End Date</strong></td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="data[Users_profile][enmonth]" class="droplist" id="end_month">
                                            <option selected="selected" value="0">Select Month</option>
                                            <option value = "01">January</option>
                                            <option value = "02">February</option>
                                            <option value = "03">March</option>
                                            <option value = "04">April</option>
                                            <option value = "05">May</option>
                                            <option value = "06">June</option>
                                            <option value = "07">July</option>
                                            <option value = "08">August</option>
                                            <option value = "09">September</option>
                                            <option value = "10">October</option>
                                            <option value = "11">November</option>
                                            <option value = "12">December</option>
                                        </select>
                                            <?php $current_year = date('Y'); ?>
                                        <select  name="data[Users_profile][enyear]" class="droplist" id="end_year">
                                            <option value="0" selected="selected">Select Year</option>
<?php for ($i = $current_year; $i >= 1970; $i--) {
    ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="submit" name="Submit" value="Submit" class="red-bttn" id="skill_button" /></td>
                                </tr>
                            </table>
                        </form>
                    </div> <!--your content end-->
                </div>
                <div class="editprofile">
                    <span id="ajax_skill_response">
<?php
foreach ($userHaveSkills as $skill__Row) {

    $skill_ids = $skill__Row['skills']['id'];
    $user_skill_id = $skill__Row['users_skills']['id'];
    ?>
                            <div class="editprofile-skill skill_list" id="<?php echo $user_skill_id; ?>">
                                <a href="#" class="blockers-number"><?php echo $skill__Row[0]['total_recommendations']; ?></a>
                                <div class="blockers-text">
                                    <a href="#"><?php echo $skill__Row['skills']['title']; ?></a>
                                </div>
                                <a href="javascript:void(0)" onclick="delete_skill('<?php echo $user_skill_id; ?>')" class="delete-skills"></a>
                                <div class="clear"></div>
                            </div>
<?php } ?>
                    </span>
                </div>
            </div>
            <!--Skill Tab end -->

            <!--Availablity Status Tab start -->
            <div id="fragment-7" class="ui-tabs-panel ui-tabs-hide">
                <div class="success_msg" id="message_status" style="display:none;">Your status has been changed successfully!</div>
                <div class="marginbottom20">
                    <h1>Availability Status</h1>
                </div>
                <div class="editprofile">
                    <ul>
                        <li>Show your job availability on profile?</li>
                        <li>
                            <form action="/users_profiles/hire_status/" method="post" id="status_Upload" class="formstyle">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td>
                                            <select name="data[Users_profile][hiring]" id="hire_status" class="droplist">
                                                <option value="1" <?php if ($profilefields['hiring'] == 1) echo 'selected=selected'; ?>>Yes</option>
                                                <option value="0" <?php if ($profilefields['hiring'] == 0) echo 'selected=selected'; ?>>No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr>
                                        <td><input type="submit" name="Submit" value="Change" class="red-bttn" id="status_button" /></td>
                                    </tr>
                                </table>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <!--Availablity Status Tab end -->
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>

<?php
//echo "<pre>";;
//print_r($qualifcation_list);
$strstr_institutes = "";
$num_of_institutes = count($institue_list);

if ($num_of_institutes > 0) {

    foreach ($institue_list as $institute) {

        $id = $institute["Institutes"]["title"];
        $label = $institute["Institutes"]["title"];

        $strstr_institutes .= '{id:"' . $id . '",label:"' . $label . '"},';
    }
    $strstr_institutes = trim($strstr_institutes, ",");
}



$strstr_qualifcation = "";
$num_of_qualifcations = count($qualifcation_list);

if ($num_of_qualifcations > 0) {

    foreach ($qualifcation_list as $qualifcation) {

        $id = $qualifcation["Qualifications"]["title"];
        $label = $qualifcation["Qualifications"]["title"];

        $strstr_qualifcation .= '{id:"' . $id . '",label:"' . $label . '"},';
    }
    $strstr_qualifcation = trim($strstr_qualifcation, ",");
}

$strstr_company = "";
$num_of_company = count($company_List);
if ($num_of_company > 0) {

    foreach ($company_List as $company) {

        $id = $company["Company"]["title"];
        $label = $company["Company"]["title"];

        $strstr_company .= '{id:"' . $id . '",label:"' . $label . '"},';
    }
    $strstr_company = trim($strstr_company, ",");
}


$strstr_skill = "";
$num_of_skill = count($skill_List);
if ($num_of_skill > 0) {

    foreach ($skill_List as $skill) {

        $id = $skill["skills"]["title"];
        $label = $skill["skills"]["title"];

        $strstr_skill .= '{id:"' . $id . '",label:"' . $label . '"},';
    }
    $strstr_skill = trim($strstr_skill, ",");
}
?>
<?php

echo $this->Html->css(array(MEDIA_URL . '/css/fcbkcomplete.css'));
?>

