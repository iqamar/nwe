   function showButton() {
                document.getElementById('uploadPhoto').style.display = 'block';

            }
			
   /*form validation*/	
	$(document).ready(function() {
			
			//firstname validation
		$('#first').blur(function() {
			
			document.getElementById('first_error').style.display = 'none';
			var firstname = $(this).val();
			//var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
			if(firstname.match(/^[a-zA-Z\s]+$/) !== null)  {
				document.getElementById('first_error').style.display = 'none';
			}
			else if (firstname == '') {
				$("#first_error").html('<div class="validate_error">Enter your First Name.</div>');
				document.getElementById('first_error').style.display = 'block';
			}
			else {
				$("#first_error").html('<div class="validate_error">Text characters only.</div>');
				document.getElementById('first_error').style.display = 'block';
			}
		});	
		//lastname validation
		$('#last').blur(function() {
			
			document.getElementById('last_error').style.display = 'none';
			var lastname = $(this).val();
			//var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
			if(lastname.match(/^[a-zA-Z\s]+$/) !== null)  {
				document.getElementById('last_error').style.display = 'none';
			}
			else if (lastname == '') {
				//$("#last_error").html('<div class="validate_error">Enter your Last Name.</div>');
				document.getElementById('last_error').style.display = 'none';
			}
			else {
				$("#last_error").html('<div class="validate_error">Text characters only.</div>');
				document.getElementById('last_error').style.display = 'block';
			}
		});
		
		//Professional Headline validation
		$('#tags').blur(function() {
			
			document.getElementById('tags_error').style.display = 'none';
			var tags = $(this).val();
			//var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
			if(tags.match(/^[a-zA-Z\s]+$/) !== null)  {
				document.getElementById('tags_error').style.display = 'none';
			}
			else if (tags == '') {
				$("#tags_error").html('<div class="validate_error">Enter your Professional Headline.</div>');
				document.getElementById('tags_error').style.display = 'block';
			}
			else {
				$("#tags_error").html('<div class="validate_error">Text characters only.</div>');
				document.getElementById('tags_error').style.display = 'block';
			}
		});
		
		//Phone validation
		$('#phone').blur(function() {
			
			document.getElementById('phone_error').style.display = 'none';
			var phone = $(this).val();
			//var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
			//var characterReg = /^[2-9]\d{2}-\d{3}-\d{4}$/;
			if(phone.match(/^[0-9-+]+$/) !== null)  {
				document.getElementById('phone_error').style.display = 'none';
			}
			else if (phone == '') {
				//$("#phone_error").html('<div class="validate_error">Enter your Professional Headline.</div>');
				document.getElementById('phone_error').style.display = 'none';
			}
			else {
				$("#phone_error").html('<div class="validate_error">Invalid Phone Number</div>');
				document.getElementById('phone_error').style.display = 'block';
			}
		});
		
		//Mobile validation
		$('#mobile').blur(function() {
			
			document.getElementById('mobile_error').style.display = 'none';
			var mobile = $(this).val();
			//var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
			//var characterReg = /^[2-9]\d{2}-\d{3}-\d{4}$/;
			if(mobile.match(/^[0-9-+]+$/) !== null)  {
				document.getElementById('mobile_error').style.display = 'none';
			}
			else if (mobile == '') {
				//$("#phone_error").html('<div class="validate_error">Enter your Professional Headline.</div>');
				document.getElementById('mobile_error').style.display = 'none';
			}
			else {
				$("#mobile_error").html('<div class="validate_error">Invalid Mobile Number</div>');
				document.getElementById('mobile_error').style.display = 'block';
			}
		});
		
		//City validation
		$('#city').blur(function() {
			
			document.getElementById('city_error').style.display = 'none';
			var city = $(this).val();
			//var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
			if(city.match(/^[a-zA-Z\s]+$/) !== null)  {
				document.getElementById('city_error').style.display = 'none';
			}
			else if (city == '') {
				$("#city_error").html('<div class="validate_error">Enter Your City Name.</div>');
				document.getElementById('city_error').style.display = 'block';
			}
			else {
				$("#city_error").html('<div class="validate_error">Text characters only.</div>');
				document.getElementById('city_error').style.display = 'block';
			}
		});	
		
	 });

            function genderVlidate(gender)
            {
                var gender_name = document.getElementById(gender).value;
                var gender_len = gender.length;
                if (gender_len == '')
                {
                    $("#gender_error").html('<div class="validate_error">Select gender!</div>');
                    gender.focus();
                    return false;
                }
                else {
                    $("#gender_error").html("");
                    return true;
                }
            }

            function birthVlidate(birth_date)
            {
                var birthdate = document.getElementById(birth_date).value;
                var birthdate_len = birthdate.length;
                if (birthdate_len == 0)
                {
                    $("#birth_error").html("Select Birth Date!");
                    birth_date.focus();
                    return false;
                }
                else {
                    $("#birth_error").html("");
                    return true;
                }
            }

            function cityVlidate(city)
            {
                var user_city = document.getElementById(city).value;
                var user_city_len = user_city.length;
                if (user_city_len == 0)
                {
                    $("#city_error").html("Enter your City!");
                    city.focus();
                    return false;
                }
                else {
                    $("#city_error").html("");
                    return true;
                }
            }

            function instituteVlidate(institute_title)
            {
                var institute_title = document.getElementById(institute_title).value;
                var institute_title_len = institute_title.length;
                if (institute_title_len == 0)
                {
                    $("#institute_error").html("Enter your Institute!");
                    institute_title.focus();
                    return false;
                }
                else {
                    $("#institute_error").html("");
                    return true;
                }
            }

            function qualificationVlidate(qualification_title)
            {
                var qualification_title = document.getElementById(qualification_title).value;
                var iqualification_title_len = qualification_title.length;
                if (iqualification_title_len == 0)
                {
                    $("#qualification_error").html("Enter your qualification!");
                    qualification_title.focus();
                    return false;
                }
                else {
                    $("#qualification_error").html("");
                    return true;
                }
            }

            $(function() {
                var $tabs = $('#tabs').tabs();
                $(".ui-tabs-panel").each(function(i) {
                    var totalSize = $(".ui-tabs-panel").size() - 1;
                    if (i != totalSize) {
                        next = i + 2;
                        if (next == 2) {
                     $(this).append("<a href='#?' onclick='return saveProfile(" + next + ")' class='next-tab mover' rel='" + next + "' id='" + next + "'>Save & Next &#187;</a>");
                            $('html,body').animate({scrollTop: 0}, 1000);
                        }
                        else if (next == 4) {
                            $(this).append("<a href='#' onclick='saveSummary(" + next + ")' class='next-tab mover' rel='" + next + "' id='" + next + "'>Save & Next &#187;</a>");
                        }
                        else {
                            $(this).append("<a href='#' onclick='saveProfile(" + next + ")' class='next-tab mover' rel='" + next + "' id='" + next + "'>Next &#187;</a>");
                            $('html,body').animate({scrollTop: 0}, 1000);
                        }
                    }
                    /**if (i != 0) {
                     prev = i;
                     $(this).append("<a href='#' class='prev-tab mover' rel='" + prev + "'>&#171; Prev Page</a>");
                     }  	**/
                });
                $('.next-tab, .prev-tab').click(function() {
                    var tabval = $(this).attr("rel");
                    if (tabval == 2) {
                        var first = $("#first").val();
                        var birth_date = $("#inputField").val();
                        var city = $("#city").val();
						 var tags = $("#tags").val();
						  var phone = $("#phone").val();
						   var mobile = $("#mobile").val();
						   var last = $("#last").val();


                        if (first == '') {
                            $("#first").focus();
                            //$('html, body').animate({scrollTop: $("#first").offset().top}, 1000);
							document.getElementById('first_error').style.display = 'block';
							$("#first_error").html('<div class="validate_error">Enter Your First Name.</div>');
                            $('html,body').animate({scrollTop: 0}, 'slow');
                            //$('body').animate({ scrollTop: '#first' }, 1000);
                            return false;
                        }
						else if(first.match(/^[a-zA-Z\s]+$/) == null)  {
							$("#first_error").html('<div class="validate_error">Text characters only.</div>');
						  document.getElementById('first_error').style.display = 'block';
						  return false;
						}
						if (birth_date == 0) {
                            $("#birth_date").focus();
							document.getElementById('gender_error').style.display = 'block';
							$("#gender_error").html('<div class="validate_error">Enter Your First Name.</div>');
                            $('html,body').animate({scrollTop: 200}, 'slow');
                            //$('html, body').animate({scrollTop: $("#birth_date").offset().top}, 1000);
                            return false;
                        }
						
						if (tags == '') {
                            $("#tags").focus();
                            //$('html, body').animate({scrollTop: $("#city").offset().top}, 1000);
							document.getElementById('tags_error').style.display = 'block';
							$("#tags_error").html('<div class="validate_error">Enter Professional Headline.</div>');
                            $('html,body').animate({scrollTop: 200}, 'slow');
                            return false;
                        }
						else if(tags.match(/^[a-zA-Z\s]+$/) == null)  {
							$("#tags_error").html('<div class="validate_error">Text characters only.</div>');
							$('html,body').animate({scrollTop: 200}, 'slow');
						  document.getElementById('tags_error').style.display = 'block';
						  return false;
						}
                        if (city == '') {
                            $("#city").focus();
                            //$('html, body').animate({scrollTop: $("#city").offset().top}, 1000);
							document.getElementById('city_error').style.display = 'block';
							$("#city_error").html('<div class="validate_error">Enter Your City Name.</div>');
                            $('html,body').animate({scrollTop: 400}, 'slow');
                            return false;
                        }
						else if(city.match(/^[a-zA-Z\s]+$/) == null)  {
							$("#city_error").html('<div class="validate_error">Text characters only.</div>');
						  document.getElementById('city_error').style.display = 'block';
						  return false;
						}
						if(last.match(/^[a-zA-Z\s]+$/) !== null)  {
							document.getElementById('last_error').style.display = 'none';
						}
						else {
							if (last != '') {
								$("#last_error").html('<div class="validate_error">Text characters only.</div>');
								document.getElementById('last_error').style.display = 'block';
								$("#last").focus();
								$('html,body').animate({scrollTop: 0}, 'slow');
								return false;
							}
						}
						if(mobile.match(/^[0-9-+]+$/) !== null)  {
							document.getElementById('mobile_error').style.display = 'none';
						}
						else {
							if (mobile != '') {
							$("#mobile_error").html('<div class="validate_error">Enter a valid mobile number.</div>');
								document.getElementById('mobile_error').style.display = 'block';
								$("#mobile").focus();
								$('html,body').animate({scrollTop: 300}, 'slow');
								return false;
							}
						}
						
						if(phone.match(/^[0-9-+]+$/) !== null)  {
							document.getElementById('phone_error').style.display = 'none';
						}
						else {
							if (phone != '') {
								$("#phone_error").html('<div class="validate_error">Enter a valid phone number.</div>');
								document.getElementById('mobile_error').style.display = 'block';
								$("#phone").focus();
								$('html,body').animate({scrollTop: 300}, 'slow');
								return false;
							}
						}

                    }

                    $tabs.tabs('select', $(this).attr("rel"));
                    return false;
                });
            });
            /*Education Delete*/
            function delete_edu(edu_id) {
                var checkstr = confirm('Are you want to delete this?');
                if (checkstr == true) {
                    $.ajax({
                        url: NETWORKWE_URL+"/users_profiles/delete_education",
                        type: "GET",
                        cache: false,
                        data: {edu_id: edu_id},
                        success: function(data) {
                            //if (share == 1) {
                            //$("#message_update").slideDown('slow');
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $("#delete_edu").slideDown('slow').delay(1000).fadeOut();
                            $("#" + edu_id).slideUp('slow');
                            //}
                        },
                        complete: function() {
                            $("#" + edu_id).css({opacity: 0.6});
                        },
                        error: function(data) {
                            $("#" + edu_id).html(data);
                        }
                    });
                }
                else {
                    return false;
                }
            }

		function init_popup() {
                $('a.poplight[href^=#]').click(function() {
                    var popID = $(this).attr('rel');
                    var popURL = $(this).attr('href');
                    var query = popURL.split('?');
                    var dim = query[1].split('&');
                    var popWidth = dim[0].split('=')[1];
                    $('#' + popID).fadeIn().css({'width': Number(popWidth)}).prepend('<a href="#" class="close"><img src="'+media+'/img/closebox.png" class="btn_close" title="Close Window" alt="Close" /></a>');
                    var popMargTop = ($('#' + popID).height() + 80) / 2;
                    var popMargLeft = ($('#' + popID).width() + 80) / 2;
                    $('#' + popID).css({
                        'margin-top': -popMargTop,
                        'margin-left': -popMargLeft
                    });
                    $('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
                    $('#fade').css({'filter': 'alpha(opacity=80)'}).fadeIn(); //Fade in the fade layer - .css({'filter' : 'alpha(opacity=80)'}) is used to fix the IE Bug on fading transparencies
                    return false;
                });
            }
            /*Experience Edit*/
            function edit_exp(exp_id) {
				
				$("#exp_edit_form").trigger('reset');
				$("#edit_exp_loader").show();
				$("#exp_button_edit").hide();
				
				 if ($("#exp_presents").val() == 'Present') {
					document.getElementById('exp_e_month').disabled = true;
					document.getElementById('exp_e_year').disabled = true;
				}
                $.ajax({
                    url: NETWORKWE_URL+"/users_profiles/load_exp",
                    type: "post",
                    dataType: "json",
                    cache: false,
                    data: {exp_id: exp_id},
					complete: function() {
						$("#edit_exp_loader").hide();
						$("#exp_button_edit").show();
					},
                    success: function(data) {
						
                        var s_date = data.Users_experience.start_date.split('-');
                        $('#exp_edit_form #exp_s_month').val(s_date[0]);
                        $('#exp_edit_form #exp_s_year').val(s_date[1]);
                        if (data.Users_experience.end_date.toLowerCase() == 'present') {
                            $('#exp_edit_form #exp_presents').prop('checked', true);
                        }
                        else {
                            var end_date = data.Users_experience.end_date.split('-');
                            $('#exp_edit_form #exp_e_month').val(end_date[0]);
                            $('#exp_edit_form #exp_e_year').val(end_date[1]);
                        }
                        $('#exp_edit_form #exp_location').val(data.Users_experience.location);
                        $('#exp_edit_form #exp_designation').val(data.Users_experience.designation);
						
                        $('#exp_edit_form #company_title_edit').empty();
                        $('#exp_edit_form #company_title_edit').trigger("removeItem",[{"title":"","value": ""}]);
                        $('#exp_edit_form #company_title_edit').trigger("addItem",[{"title": data.Users_experience.title, "value": data.Users_experience.title}]);
						var title_id = $(".bit-box").attr("id");
						$('#'+title_id).html(data.Users_experience.title+'<a href="#" class="closebutton"></a>');
                        $('#exp_edit_form #exp_id').val(exp_id);
                    }
                });
            }
            function fix_fcbk(){
                var value = $('#company_title_edit_annoninput .maininput').val();
                $('#company_title_edit_annoninput .maininput').blur(function() { 
                    if(value !== '')
                        $('#company_title_edit').trigger("addItem",[{"title": value, "value": value}]);
                    //$('#company_title_edit').trigger("removeItem",[{"value": $('#company_title_edit :first').val()[0]}]);
                    //console.log(value);
                });
            }
            /*$(function() {
                var value = $('#company_title_edit_annoninput .maininput').val();
                $('#company_title_edit_annoninput .maininput').on('blur',function() { 
                    alert('here');
                    if(value !== '')
                        $('#company_title_edit').trigger("addItem",[{"title": value, "value": value}]);
                    //$('#company_title_edit').trigger("removeItem",[{"value": $('#company_title_edit :first').val()[0]}]);
                    console.log(value);
                });
            });
            $(document).ready( fix_fcbk );*/

            $("#exp_edit_form").on('submit', function(e) {
                e.preventDefault();
                var start = new Date($('#exp_edit_form #exp_s_year').val()+'-'+$('#exp_edit_form #exp_s_month').val()+'-01');
                var end = new Date();
				 var current_date = end;
                if($('#exp_edit_form #exp_presents').prop('checked')){
                    var d = new Date();
                    var month = d.getMonth()+1;
                    var day = d.getDate();
                    end = new Date(d.getFullYear() + '-' + ((''+month).length<2 ? '0' : '') + month + '-' + ((''+day).length<2 ? '0' : '') + day);
                }
                else
                    end = new Date($('#exp_edit_form #exp_e_year').val()+'-'+$('#exp_edit_form #exp_e_month').val()+'-01');
                var diff = new Date(end - start);
                var days = diff/1000/60/60/24;
                //console.log(company+' - '+$('#exp_edit_form #company_title_edit').val());
                //$('#company_title_edit :not(:last)').remove();
                //if (validator()){
				if (current_date < end) {
					if ($('#msg').length < 1)
                        $('#exp_edit_form').before('<div id="msg"></div>');
                    	$("#msg").removeClass("success_msg").addClass("error_msg").slideDown('slow').delay(2000).fadeOut().html('End date should be less than current date');
						return false;
				}
				if (current_date < start) {
					if ($('#msg').length < 1)
                        $('#exp_edit_form').before('<div id="msg"></div>');
                    	$("#msg").removeClass("success_msg").addClass("error_msg").slideDown('slow').delay(2000).fadeOut().html('Start date should be less than current date');
						return false;
				}
					
                if(days >= 0 && end && start){
                        $('#fade , #editExp').fadeOut(function() {
                        $('#fade, a.close').remove();
                        $('.holder .bit-box').remove();
                        $('#exp_edit_form #company_title_edit').trigger("removeItem",[{"value": $('#exp_edit_form #company_title_edit :first').val()[0]}]);
                        $('#exp_edit_form')[0].reset();
                        /*$('#exp_edit_form #exp_location').val('');
                        $('#exp_edit_form #exp_designation').val('');
                        $('#exp_edit_form #exp_s_month').val('');
                        $('#exp_edit_form #exp_s_year').val('');
                        $('#exp_edit_form #exp_e_month').val('');
                        $('#exp_edit_form #exp_e_year').val('');
                        $('#exp_edit_form #exp_presents').prop('checked', false);*/
                    });
                    var companyset = []; 
                    $('#company_title_edit :selected').each(function(i, selected){ companyset[i] = $(selected).text(); });
                    var company = companyset[0]?companyset[0]:$('#company_title_edit_annoninput .maininput').val();
                    if(companyset.length === 0){
                        $('#company_title_edit').trigger("addItem",[{"title": company, "value": company}]);
                    }
                    $.ajax({
                        url: NETWORKWE_URL+"/users_profiles/edit_exp",
                        type: 'post',
                        cache: false,
                        data: $(this).serialize(),
                        success: function(data) {
                            $('#ajax_exp_response').html(data);
                            $("#message_edit_exp").removeClass("error_msg").addClass("success_msg").slideDown('slow').delay(2000).fadeOut().html('Successfully saved changes.');
                            init_popup();
                        },
                        error: function(data) {
                            $("experience_error").removeClass("success_msg").addClass("error_msg").slideDown('slow').delay(2000).fadeOut().html('Error saving data: ' + data);
                        }
                    });
                }
                else {
                    if ($('#msg').length < 1)
                        $('#exp_edit_form').before('<div id="msg"></div>');
                    $("#msg").removeClass("success_msg").addClass("error_msg").slideDown('slow').delay(2000).fadeOut().html('Please check the dates');
					return false;
                }
                //}
            });

            function edit_edu(edu_id) {
				$("#edu_edit_form").trigger('reset');
				$("#edit_edu_loader").show();
				$("#edu_button_edit").hide();
                $.ajax({
                    url: NETWORKWE_URL+"/users_profiles/load_edu",
                    type: "post",
                    dataType: "json",
                    cache: false,
                    data: {edu_id: edu_id},
                    success: function(data) {
                        var s_date = data.users_qualifications.start_date.split('-');
                        $('#edu_edit_form #startmonth_edit').val(s_date[0]);
                        $('#edu_edit_form #startyear_edit').val(s_date[1]);
                        var end_date = data.users_qualifications.end_date.split('-');
                        $('#edu_edit_form #enmonth_edit').val(end_date[0]);
                        $('#edu_edit_form #enyear_edit').val(end_date[1]);
                        $('#edu_edit_form #field_study_edit').val(data.users_qualifications.field_study);
                        $('#edu_edit_form #grade_edit').val(data.users_qualifications.grade);
                        $('#edu_edit_form #institute_title_edit').empty();
                        $('#edu_edit_form #institute_title_edit').trigger("removeItem",[{"value": ""}]);
                        //$('#edu_edit_form #institute_title_edit :not(:last)').remove();
                        $('#edu_edit_form #institute_title_edit').trigger("addItem",[{"title": data.users_qualifications.university, "value": data.users_qualifications.university}]);
                        $('#edu_edit_form #qualification_title_edit').empty();
                        $('#edu_edit_form #qualification_title_edit').trigger("removeItem",[{"value": ""}]);
                        //$('#edu_edit_form #qualification_title_edit :not(:last)').remove();
                        $('#edu_edit_form #qualification_title_edit').trigger("addItem",[{"title": data.users_qualifications.qualification, "value": data.users_qualifications.qualification}]);
						var title_id = $("#institute_idd .bit-box").attr("id");
						$('#'+title_id).html(data.users_qualifications.university+'<a href="#" class="closebutton"></a>');
						
						var qualifiied_id = $("#qualification_idd .bit-box").attr("id");
						$('#'+qualifiied_id).html(data.users_qualifications.qualification+'<a href="#" class="closebutton"></a>');
						
                        $('#edu_edit_form #edu_id').val(edu_id);
                        fix_fcbk();
                    },
                    complete: function() {
						$("#edit_edu_loader").hide();
						$("#edu_button_edit").show();
                        fix_fcbk();
                    },
                    error: function(data) {
                        //$("#" + exp_id).html(data);
                    }
                });
            }
			
            $("#edu_edit_form").on('submit', function(e) {									  
                e.preventDefault();
                
                var instset = [];
                $('#institute_title_edit :selected').each(function(i, selected) {
                    instset[i] = $(selected).text();
                });
                var inst = instset[0] ? instset[0] : $('#institute_title_edit_annoninput .maininput').val();
                if (instset.length === 0) {
                    $('#institute_title_edit').trigger("addItem",[{"title": inst, "value": inst}]);
                }
                var instsetqual = [];
                $('#qualification_title_edit :selected').each(function(i, selected) {
                    instsetqual[i] = $(selected).text();
                });
                var qual = instsetqual[0] ? instsetqual[0] : $('#qualification_title_edit_annoninput .maininput').val();
                if (instsetqual.length === 0) {
                    $('#qualification_title_edit').trigger("addItem",[{"title": qual, "value": qual}]);
                }
				
				
				var start = new Date($('#edu_edit_form #startyear_edit').val()+'-'+$('#edu_edit_form #startmonth_edit').val()+'-01');
			
                var end = new Date();
				var current_date = end;
                	end = new Date($('#edu_edit_form #enyear_edit').val()+'-'+$('#edu_edit_form #enmonth_edit').val()+'-01');
                var diff = new Date(end - start);
                var days = diff/1000/60/60/24;
                //console.log(company+' - '+$('#exp_edit_form #company_title_edit').val());
                //$('#company_title_edit :not(:last)').remove();
                //if (validator()){
				if (current_date < start) {
					if ($('#msg').length < 1)
                        $('#edu_edit_form').before('<div id="msg"></div>');
                    	$("#msg").removeClass("success_msg").addClass("error_msg").slideDown('slow').delay(2000).fadeOut().html('Start date should be less than current date');
						return false;
				}
				 
            //if (validator()){
			if (days >=0 && end && start) {
                $.ajax({
                    url: NETWORKWE_URL+"/users_profiles/edit_edu",
                    type: 'post',
                    cache: false,
                    data: $(this).serialize(),
                    success: function(data) {
                        $("#ajax_edu_response").html(data);
                        $("#message_edit_exp").removeClass("error_msg").addClass("success_msg").slideDown('slow').delay(2000).fadeOut().html('Successfully saved changes.');
                        $('#edu_edit_form #institute_title_edit').trigger("removeItem",[{"value": $('#edu_edit_form #institute_title_edit :first').val()[0]}]);
						$('#edu_edit_form #qualification_title_edit').trigger("removeItem",[{"value": $('#edu_edit_form #qualification_title_edit :first').val()[0]}]);
						$('#edu_edit_form #field_study_edit').val('');
						$('#edu_edit_form #grade_edit').val('');
						$('#edu_edit_form #startmonth_edit').val('');
						$('#edu_edit_form #startyear_edit').val('');
						$('#edu_edit_form #enmonth_edit').val('');
						$('#edu_edit_form #enyear_edit').val('');
						
                        init_popup();
                    },
                    error: function(data) {
                        $("#message_edit_exp").removeClass("success_msg").addClass("error_msg").slideDown('slow').delay(2000).fadeOut().html('Error saving data: ' + data);
                    }
                });
               }
			   else {
				   if ($('#msg').length < 1)
                        $('#edu_edit_form').before('<div id="msg"></div>');
                    	$("#msg").removeClass("success_msg").addClass("error_msg").slideDown('slow').delay(2000).fadeOut().html('Enter a valid Date');
						return false;
			   }
			   $('#fade , #editEdu').fadeOut(function() {
                    $('#fade, a.close').remove();
                    $('.holder .bit-box').remove();
                   
                });
            });

            /*Experience Delete*/
            function delete_exp(exp_id) {
                var checkstr = confirm('Are you want to delete this?');
                if (checkstr == true) {
                    $.ajax({
                        url: NETWORKWE_URL+"/users_profiles/delete_experience",
                        type: "GET",
                        cache: false,
                        data: {exp_id: exp_id},
                        success: function(data) {
                            //if (share == 1) {
                            //$("#message_update").slideDown('slow');
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $("#delete_exp").slideDown('slow').delay(1000).fadeOut();
                            $("#" + exp_id).slideUp('slow');
                            //}
                        },
                        complete: function() {
                            $("#" + exp_id).css({opacity: 0.6});
                        },
                        error: function(data) {
                            $("#" + exp_id).html(data);
                        }
                    });
                }
                else {
                    return false;
                }
            }

        /*Skill Delete*/
            function delete_skill(skill_id) {
                var checkstr = confirm('Are you want to delete this?');
                if (checkstr == true) {
                    $.ajax({
                        url: NETWORKWE_URL+"/users_profiles/delete_skill",
                        type: "GET",
                        cache: false,
                        data: {skill_id: skill_id},
                        success: function(data) {
                            //if (share == 1) {
                            //$("#message_update").slideDown('slow');
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $("#delete_skill").slideDown('slow').delay(1000).fadeOut();
                            $("#" + skill_id).slideUp('slow');
                            //}
                        },
                        complete: function() {
                            $("#" + skill_id).css({opacity: 0.6});
                        },
                        error: function(data) {
                            $("#" + skill_id).html(data);
                        }
                    });
                }
                else {
                    return false;
                }
            }
     
       function saveSummary(id) {
        var summary = document.getElementById('pro_summary').value;
            $("#summary_error").html("");
            //e.preventDefault();
            //$('#summary_btn').attr('disabled', ''); // disable upload button
            $.ajax({
                url: NETWORKWE_URL+"/users_profiles/add_summary",
                type: "POST",
                cache: false,
                data: {summary: summary},
                success: function(data) {
                    //$("#ajax_summary_response").html(data);
                    $("#smuuary_sucsses").slideDown('slow').delay(1000).fadeOut();
                },
                error: function(data) {
                    $("#ajax_summary_response").html(data);
                }
            });
    }

    $(document).ready(function() {
        $("#qualification_title").fcbkcomplete({
            json_url: NETWORKWE_URL + "/users_profiles/fetch_qualifications/",
            addontab: true,
            maxitems: 1,
            height: 5,
            firstselected: true,
            cache: true
        });
        $("#qualification_title_edit").fcbkcomplete({
            json_url: NETWORKWE_URL +"/users_profiles/fetch_qualifications/",
            //addontab: true,
            maxitems: 1,
            newel: true,
            height: 5,
            firstselected: true,
            cache: true
        });
        $("#institute_title").fcbkcomplete({
            json_url: NETWORKWE_URL +"/users_profiles/fetch_institutes/",
            addontab: true,
            maxitems: 1,
            height: 5,
            cache: true
        });
        $("#institute_title_edit").fcbkcomplete({
            json_url:NETWORKWE_URL + "/users_profiles/fetch_institutes/",
            //addontab: true,
            maxitems: 1,
            newel: true,
            height: 5,
            cache: true
        });
        $("#company_title").fcbkcomplete({
            json_url: NETWORKWE_URL +"/users_profiles/fetch_companies/",
            addontab: true,
            maxitems: 1,
            height: 5,
            newel: true,
            cache: true
        });
        
        $("#company_title_edit").fcbkcomplete({
            json_url: NETWORKWE_URL +"/users_profiles/fetch_companies/",
            addontab: true,
            maxitems: 1,
            newel: true,
            height: 5,
            cache: true
        });

        $("#skill_title").fcbkcomplete({
            json_url: NETWORKWE_URL +"/users_profiles/fetch_skills/",
            addontab: true,
            maxitems: 1,
            height: 5,
            cache: true
        });

        /*Profile Picture*/
        $('#photoUploader').on('submit', function(e) {
            var photo = $('#uploadfile').val();
            var photo_len = photo.length;
            var ext = photo.split('.').pop().toLowerCase();
            if (photo_len == 0) {
                $("#photo_error").html("Select photo!").fadeIn('slow').delay(5000).fadeOut();
                return false;
            }
            else if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                $("#photo_error").html("Invalid picture!").fadeIn('slow').delay(5000).fadeOut();
                return false;
            }
            else {
				$("#photo_loader").show();
                $("#photo_error").html("");
                e.preventDefault();
                //$('#uploadPhoto').attr('disabled', ''); // disable upload button
                $(this).ajaxSubmit({
                    type: "POST",
                    cache: false,
                    success: function(data) {
                        $(".userpic span a").children("img").attr('src', $(data + " div img:first-child").children("img").attr('src'));
                        $("#message_photo").slideDown('slow').delay(3000).fadeOut();
                        $("#ajax_photo_response").html(data);
						$("#uploadPhoto").hide();	
						
                    },
					complete: function() {
						$("#photo_loader").hide();	
					},
                    error: function(data) {
                        $("#ajax_photo_response").html(data);
                    }
                });
            }
        });

        /*User Education*/
        $('#edu_Upload').on('submit', function(e) {
											   
            e.preventDefault();
			$("#add_edu_loader").show();
			$("#edu_button").hide();
            var instset = [];
            $('#institute_title :selected').each(function(i, selected) {
                instset[i] = $(selected).text();
            });
            var inst = instset[0] ? instset[0] : $('#institute_title_annoninput .maininput').val();
            if (instset.length === 0) {
                $('#institute_title').append($('<option>', {value: inst}).text(inst));
                $("#institute_title").val(inst);
                $("#institute_title option[value='" + inst + "']").attr("selected", "selected");
            }
            var instsetqual = [];
            $('#qualification_title :selected').each(function(i, selected) {
                instsetqual[i] = $(selected).text();
            });
            var inst1 = instsetqual[0] ? instsetqual[0] : $('#qualification_title_annoninput .maininput').val();
            if (instsetqual.length === 0) {
                $('#qualification_title').append($('<option>', {value: inst1}).text(inst1));
                $("#qualification_title").val(inst1);
                $("#qualification_title option[value='" + inst1 + "']").attr("selected", "selected");
            }
			
				var start = new Date($('#edu_Upload #startyear').val()+'-'+$('#edu_Upload #startmonth').val()+'-01');
			
                var end = new Date();
				var current_date = end;
                	end = new Date($('#edu_Upload #enyear').val()+'-'+$('#edu_Upload #enmonth').val()+'-01');
                var diff = new Date(end - start);
                var days = diff/1000/60/60/24;
                //console.log(company+' - '+$('#exp_edit_form #company_title_edit').val());
                //$('#company_title_edit :not(:last)').remove();
                //if (validator()){
				if (current_date < start) {
					$("#add_edu_loader").hide();
					$("#edu_button").show();
					if ($('#msg').length < 1)
                        $('#edu_Upload').before('<div id="msg"></div>');
                    	$("#msg").removeClass("success_msg").addClass("error_msg").slideDown('slow').delay(2000).fadeOut().html('Start date should be less than current date');
						return false;
				}
			
            //var inst = document.getElementById('ms-input-0').value;
            var flag = '';
            if (inst != '' || inst1 != '') {
                //e.preventDefault();
                //  $('#edu_button').attr('disabled', ''); // disable upload button
			 if (days >=0 && end && start) {
                $(this).ajaxSubmit({
                    type: "POST",
                    cache: false,
                    success: function(data) {
						
                        $("#ajax_edu_response").html(data);
                        $('#fade , #addEdu').fadeOut(function() {
                            $('#fade, a.close').remove();  //fade them both out
                        });
                        $("#message_edu").slideDown('slow').delay(1000).fadeOut();
						$("#edu_Upload input[type='text']").val('');
						$("#edu_Upload #institute_title").empty();
						$("#edu_Upload #qualification_title").empty();
						$("#edu_Upload .holder .bit-box").remove();
						$("#edu_Upload [name='data[users_qualifications][stmonth]']").val('');
						$("#edu_Upload [name='data[users_qualifications][styear]']").val('');
						$("#edu_Upload [name='data[users_qualifications][enmonth]']").val('');
						$("#edu_Upload [name='data[users_qualifications][enyear]']").val('');
						
                        init_popup();
                    },
					complete: function(data) {
						$("#add_edu_loader").hide();
						$("#edu_button").show();
					},
                    error: function(data) {
                        $("#ajax_edu_response").html(data);
                    }
                });
			 }
			 else {
				 $("#add_edu_loader").hide();
				 $("#edu_button").show();
				if ($('#msg').length < 1)
					$('#edu_Upload').before('<div id="msg"></div>');
					$("#msg").removeClass("success_msg").addClass("error_msg").slideDown('slow').delay(2000).fadeOut().html('Select a valid Date.');
					return false; 
			 }
                flag = true;
            }
            else {
				$("#add_edu_loader").hide();
				 $("#edu_button").show();
				$("#qualification_error").removeClass("success_msg").addClass("error_msg").slideDown('slow').delay(2000).fadeOut().html('Enter the required fields');
                document.getElementById('qualification_error').style.display = 'block';
                flag = false;
            }
            return flag;
        });

        /*User Experience*/
        $('#exp_Upload').on('submit', function(e) {
            e.preventDefault();
			$("#add_exp_loader").show();
			$("#exp_button").hide();
            var companyset = [];
            $('#company_title :selected').each(function(i, selected) {
                companyset[i] = $(selected).text();
            });
            var company = companyset[0] ? companyset[0] : $('#company_title_annoninput .maininput').val();
            if (companyset.length === 0) {
                $('#company_title').append($('<option>', {value: company}).text(company));
                $("#company_title").val(company);
                $("#company_title option[value='" + company + "']").attr("selected", "selected");
            }
            //var company = document.getElementById('ms-input-2').value;
			
			
			var start = new Date($('#exp_Upload #st_year').val()+'-'+$('#exp_Upload #st_month').val()+'-01');
			
                var end = new Date();
				 var current_date = end;
                if($('#exp_Upload #presents').prop('checked')){
                    var d = new Date();
                    var month = d.getMonth()+1;
                    var day = d.getDate();
                    end = new Date(d.getFullYear() + '-' + ((''+month).length<2 ? '0' : '') + month + '-' + ((''+day).length<2 ? '0' : '') + day);
                }
                else
                    end = new Date($('#exp_Upload #en_year').val()+'-'+$('#exp_Upload #en_month').val()+'-01');
                var diff = new Date(end - start);
                var days = diff/1000/60/60/24;
                //console.log(company+' - '+$('#exp_edit_form #company_title_edit').val());
                //$('#company_title_edit :not(:last)').remove();
                //if (validator()){
				if (current_date < end) {
					$("#add_exp_loader").hide();
					$("#exp_button").show();
					if ($('#msg').length < 1)
                        $('#exp_Upload').before('<div id="msg"></div>');
                    	$("#msg").removeClass("success_msg").addClass("error_msg").slideDown('slow').delay(2000).fadeOut().html('End date should be less than current date');
						return false;
				}
				if (current_date < start) {
					$("#add_exp_loader").hide();
					$("#exp_button").show();
					if ($('#msg').length < 1)
                        $('#exp_Upload').before('<div id="msg"></div>');
                    	$("#msg").removeClass("success_msg").addClass("error_msg").slideDown('slow').delay(2000).fadeOut().html('Start date should be less than current date');
						return false;
				}
			
            var flag = '';
            if (company != '') {

                //$('#exp_button').attr('disabled', ''); // disable upload button
				  if(days >= 0 && end && start){
					$(this).ajaxSubmit({
						type: "POST",
						cache: false,
						success: function(data) {
							$("#ajax_exp_response").html(data);
							$('#fade , #addExp').fadeOut(function() {
								$('#fade, a.close').remove();  //fade them both out
							});
							$("#message_exp").slideDown('slow').delay(1000).fadeOut();
							
							$("#exp_Upload input[type='text']").val('');
							$("#exp_Upload #company_title").empty();
							$("#exp_Upload .holder .bit-box").remove();
							$("#exp_Upload [name='data[Users_profile][stmonth]']").val('');
							$("#exp_Upload [name='data[Users_profile][styear]']").val('');
							$("#exp_Upload [name='data[Users_profile][enmonth]']").val('');
							$("#exp_Upload [name='data[Users_profile][enyear]']").val('');
							$("#exp_Upload input[type='checkbox']").prop('checked', false);
							document.getElementById('en_month').disabled = false;
							document.getElementById('en_year').disabled = false;
							//$("a.close").hide();
							init_popup();
						},
						complete: function(data) {
							$("#add_exp_loader").hide();
							$("#exp_button").show();
						},
						error: function(data) {
							$("#ajax_exp_response").html(data);
						}
					});
					flag = true;
				}
				else {
					$("#add_exp_loader").hide();
					$("#exp_button").show();
					if ($('#msg').length < 1)
                        $('#exp_Upload').before('<div id="msg"></div>');
                    	$("#msg").removeClass("success_msg").addClass("error_msg").slideDown('slow').delay(2000).fadeOut().html('Select a valid Date');
						return false;
				}
			}
            else {
				$("#add_exp_loader").hide();
				$("#exp_button").show();
				$("#experience_error").removeClass("success_msg").addClass("error_msg").slideDown('slow').delay(2000).fadeOut().html('Enter the required fields');
                document.getElementById('experience_error').style.display = 'block';
                flag = false;
            }
            return flag;
        });

        /*User Skill*/
        $('#skill_Upload').on('submit', function(e)
        {
            e.preventDefault();
            var skillset = [];
            $('#skill_title :selected').each(function(i, selected) {
                skillset[i] = $(selected).text();
            });
            var skill = skillset[0] ? skillset[0] : $('#skill_title_annoninput .maininput').val();//document.getElementById('ms-input-3').value;
            if (skillset.length === 0) {
                $('#skill_title').append($('<option>', {value: skill}).text(skill));
                $("#skill_title").val(skill);
                $("#skill_title option[value='" + skill + "']").attr("selected", "selected");
            }
            var flag = '';
            if (skill != '') {
                //$('#skill_button').attr('disabled', ''); // disable upload button
                var LastDiv = $(".skill_list:last"); /* get the first div of the dynamic content using ":first" */
                var LastId = $(".skill_list:last").attr("id"); /* get the id of the first div */
                $(this).ajaxSubmit({
                    type: "POST",
                    cache: false,
                    success: function(data) {
                        $('#fade , #addSkill').fadeOut(function() {
                            $('#fade, a.close').remove();  //fade them both out
                        });
                        if (LastId) {
                            if (data) {
                                LastDiv.after(data);
                            }
                        }
                        else {
                            $("#ajax_skill_response").html(data);
                        }
                        $("#skill_Upload input[type='text']").val('');
                        $("#skill_Upload #skill_title").empty();
						$("#skill_Upload .holder .bit-box").remove();
						$("#skill_Upload [name='data[Users_profile][stmonth]']").val('');
						$("#skill_Upload [name='data[Users_profile][styear]']").val('');
						$("#skill_Upload [name='data[Users_profile][enmonth]']").val('');
						$("#skill_Upload [name='data[Users_profile][enyear]']").val('');
                        
                        //$("#ajax_skill_response").html(data);
                        $("#message_skill").slideDown('slow').delay(1000).fadeOut();
                    },
                    error: function(data) {
                        $("#ajax_skill_response").html(data);
                    }
                });
                flag = true;
            }
            else {
                $("#skill_error").html("Enter the required fields");
                document.getElementById('skill_error').style.display = 'block';
                flag = false;
            }
            return flag;
        });

        /*User Availiablity Status*/
        $('#status_Upload').on('submit', function(e)
        {
            e.preventDefault();
            $('#status_button').attr('disabled', ''); // disable upload button
            $(this).ajaxSubmit({
                type: "POST",
                cache: false,
                success: function(data) {
                    $("#message_status").slideDown('slow').delay(1000).fadeOut();
                },
                error: function(data) {
                    $("#ajax_status_response").html(data);
                }
            });
        });

    });

    /* on 11032014
     function showInstitutes(search_str) {
     $.ajax({
     url     : NETWORKWE_URL +"/users_profiles/search_institute",
     type    : "GET",
     cache   : false,
     data    : {search_str: search_str},
     success : function(data){
     //alert(data);
     // if (search_str !='') {
     $("#institute_result").html(data);
     // }
     // else {
     //$("#result_skill").html("");
     //}
     },
     error : function(data) {
     $("#institute_result").html("there is error");
     }
     });
     }
     */
    function disabledField() {
        if (document.getElementById('presents').checked)
        {
            document.getElementById('en_month').disabled = true;
            document.getElementById('en_year').disabled = true;
            document.getElementById('en_month').value = 'Select Month';
            document.getElementById('en_year').value = 'Select Year';
        } else {
            document.getElementById('en_month').disabled = false;
            document.getElementById('en_year').disabled = false;
        }

    }

    function disabledExpField() {
        if (document.getElementById('exp_presents').checked)
        {
            document.getElementById('exp_e_month').disabled = true;
            document.getElementById('exp_e_year').disabled = true;
            document.getElementById('exp_e_month').value = 'Select Month';
            document.getElementById('exp_e_year').value = 'Select Year';
        } else {
            document.getElementById('exp_e_month').disabled = false;
            document.getElementById('exp_e_year').disabled = false;
        }

    }
    function showTotalSkills(search_str) {
        var search_str = document.getElementById('skillid').value;
        $.ajax({
            url: NETWORKWE_URL+"/users_profiles/search_skill",
            type: "GET",
            cache: false,
            data: {search_str: search_str},
            success: function(data) {
                //alert(data);
                // if (search_str !='') {
                $("#result_skill").html(data);
                // }
                // else {
                //$("#result_skill").html("");
                //}
            },
            error: function(data) {
                $("#result_skill").html("there is error");
            }
        });

    }
    function assignSkill(title, skillid) {
        $("#result_skill").show('slow');
        document.getElementById('skillid').value = title;
        document.getElementById('skill_id').value = skillid;
        $("#result_skill").html('');
        return true;
    }
    
     tinymce.init({
        selector: "textarea#summary",
        theme: "modern",
        width: 500,
        height: 300,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor"
        ],
        content_css: "css/content.css",
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
        image_advtab: true,
        style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ]
    });
    var ajaxProcess = false;
    current_tab = 1;
    var postData;
    var client = new XMLHttpRequest();
    function uploadFile()
    {
        var file = document.getElementById("uploadfile");

        /* Create a FormData instance */
        var formData = new FormData();
        /* Add the file */
        formData.append("upload", file.files[0]);
        formData.append("action", "photo");

        client.open("post", NETWORKWE_URL+"/external_apps/", true);
        client.setRequestHeader("Content-Type", "multipart/form-data");
        client.send(formData);  /* Send to server */
    }

    /* Check the response status */
    client.onreadystatechange = function()
    {
        if (client.readyState == 4 && client.status == 200)
        {
            alert(client.responseText);
        }
    }

    function saveProfile(id) {
        if (id == 2) {
            var flag = true;
            title = $("#title").val();
            first = $("#first").val();
            last = $("#last").val();
            gender = $("#gender").val();
            marital_status = $("#marital_status").val();
            birth_date = $("#inputField").val();
            nationality = $("#nationality").val();
            tags = $("#tags").val();
            industry_id = $("#industry_id").val();
            phone = $("#phone").val();
            mobile = $("#mobile").val();
            address1 = $("#address1").val();
            address2 = $("#address2").val();
            fax = $("#fax").val();
            pobox = $("#pobox").val();
            city = $("#city").val();
            country_id = $("#country_id").val();
			

            var hide_year = $("#hide_year").val();
            if (document.getElementById('hide_year').checked) {
                hide_year = 1;
            }
            else {
                hide_year = 0;
            }
		/*
			var lastname_hide = $("#hide_lname").val();
            if (document.getElementById('hide_lname').checked) {
                lastname_hide = 1;
            }
            else {
                lastname_hide = 0;
            }
			*/
			var gender_hide = $("#hide_gender").val();
            if (document.getElementById('hide_gender').checked) {
                gender_hide = 1;
            }
            else {
                gender_hide = 0;
            }
			var marital_status_hide = $("#hide_marital").val();
            if (document.getElementById('hide_marital').checked) {
                marital_status_hide = 1;
            }
            else {
                marital_status_hide = 0;
            }
	
			var nationality_hide = $("#hide_nationality").val();
            if (document.getElementById('hide_nationality').checked) {
                nationality_hide = 1;
            }
            else {
                nationality_hide = 0;
            }
			
			var tags_hide = $("#hide_tags").val();
            if (document.getElementById('hide_tags').checked) {
                tags_hide = 1;
            }
            else {
                tags_hide = 0;
            }
			
			var industry_id_hide = $("#hide_industry").val();
            if (document.getElementById('hide_industry').checked) {
                industry_id_hide = 1;
            }
            else {
                industry_id_hide = 0;
            }
			
			var phone_hide = $("#hide_phone").val();
            if (document.getElementById('hide_phone').checked) {
                phone_hide = 1;
            }
            else {
                phone_hide = 0;
            }
			
			var mobile_hide = $("#hide_mobile").val();
            if (document.getElementById('hide_mobile').checked) {
                mobile_hide = 1;
            }
            else {
                mobile_hide = 0;
            }
			
			var address1_hide = $("#hide_address1").val();
            if (document.getElementById('hide_address1').checked) {
                address1_hide = 1;
            }
            else {
                address1_hide = 0;
            }
			
			var address2_hide = $("#hide_address2").val();
            if (document.getElementById('hide_address2').checked) {
                address2_hide = 1;
            }
            else {
                address2_hide = 0;
            }
			
			var zip_hide = $("#hide_zip").val();
            if (document.getElementById('hide_zip').checked) {
                zip_hide = 1;
            }
            else {
                zip_hide = 0;
            }
			
			var country_id_hide = $("#hide_country").val();
            if (document.getElementById('hide_country').checked) {
                country_id_hide = 1;
            }
            else {
                country_id_hide = 0;
            }
			
			var city_hide = $("#hide_city").val();
            if (document.getElementById('hide_city').checked) {
                city_hide = 1;
            }
            else {
                city_hide = 0;
            }

            if (first == '' || birth_date == '' || city == '' || tags == '') {
                flag = false;
                return false;
            }
			
			if(first.match(/^[a-zA-Z\s]+$/) !== null)  {
				document.getElementById('first_error').style.display = 'none';
			}
			else {
				document.getElementById('first_error').style.display = 'block';
				$("#first").focus();
				$('html,body').animate({scrollTop: 0}, 'slow');
				return false;
			}
			
			if(last.match(/^[a-zA-Z\s]+$/) !== null)  {
				document.getElementById('last_error').style.display = 'none';
			}
			else {
				if (last != '') {
					document.getElementById('last_error').style.display = 'block';
					$("#last").focus();
					$('html,body').animate({scrollTop: 0}, 'slow');
					return false;
				}
			}
			
			if(tags.match(/^[a-zA-Z\s]+$/) !== null)  {
				document.getElementById('tags_error').style.display = 'none';
				
			}
			else {
				document.getElementById('tags_error').style.display = 'block';
				$("#tags").focus();
				$('html,body').animate({scrollTop: 0}, 'slow');
				return false;
			}
			if(mobile.match(/^[0-9-+]+$/) !== null)  {
				document.getElementById('mobile_error').style.display = 'none';
			}
			else {
				if (mobile !='') {
					$("#mobile_error").html('<div class="validate_error">Enter a valid mobile number.</div>');
						document.getElementById('mobile_error').style.display = 'block';
						$("#mobile").focus();
						$('html,body').animate({scrollTop: 300}, 'slow');
						return false;
				}
			}
			
			if(phone.match(/^[0-9-+]+$/) !== null)  {
				document.getElementById('phone_error').style.display = 'none';
			}
			else {
				if (phone !='') {
					$("#phone_error").html('<div class="validate_error">Enter a valid phone number.</div>');
						document.getElementById('mobile_error').style.display = 'block';
						$("#phone").focus();
						$('html,body').animate({scrollTop: 300}, 'slow');
						return false;
				}
			}
			if(city.match(/^[a-zA-Z\s]+$/) !== null)  {
				document.getElementById('city_error').style.display = 'none';
				
			}
			else {
				document.getElementById('city_error').style.display = 'block';
				$("#city").focus();
				$('html,body').animate({scrollTop: 400}, 'slow');
				return false;
			}
            postData = {"action": "basic", "request": {"title": title, "first": first, "last": last, "gender": gender, "birth_date": birth_date, "nationality": nationality, "tags": tags, "industry_id": industry_id, "phone": phone, "mobile": mobile, "address1": address1, "address2": address2, "fax": fax, "pobox": pobox, "city": city, "country_id": country_id, "marital_status": marital_status, "hide_year": hide_year,  "gender_hide": gender_hide, "marital_status_hide": marital_status_hide, "nationality_hide": nationality_hide, "tags_hide": tags_hide, "industry_id_hide": industry_id_hide, "phone_hide": phone_hide, "mobile_hide": mobile_hide, "address1_hide": address1_hide, "address2_hide": address2_hide, "zip_hide": zip_hide, "country_id_hide": country_id_hide, "city_hide": city_hide}};
            //	alert(postData);
            //return false;
			$("#basic_info_loader").show();
            $.ajaxSetup({
                beforeSend: function() {
                    $("#basic_info").val('Saving data...');
                },
                complete: function() {
					$("#basic_info_loader").hide();
                    $("#basic_info").val('Save');
                }
            });

            $.ajax({
                type: "POST",
                url: NETWORKWE_URL + "/users_profiles/update/",
                data: postData,
                success: function(data, textStatus) {
                    ajaxProcess = false;
                    if (data == 1) {
                        $('html,body').animate({scrollTop: 0}, 600);
                        $("#message_profile").slideDown('slow').delay(1000).fadeOut();
                    }
                }
            });
        } // if condition for id end
        return true;
    }

    function save_preview() {
        var title = $("#title").val();
        var first = $("#first").val();
        var last = $("#last").val();
        var gender = $("#gender").val();
        var marital_status = $("#marital_status").val();
        var birth_date = $("#inputField").val();
        var nationality = $("#nationality").val();
        var tags = $("#tags").val();
        var industry_id = $("#industry_id").val();
        var phone = $("#phone").val();
        var mobile = $("#mobile").val();
        var address1 = $("#address1").val();
        var address2 = $("#address2").val();
        var fax = $("#fax").val();
        var pobox = $("#pobox").val();
        var city = $("#city").val();
        var country_id = $("#country_id").val();
        var pro_summary = $("#pro_summary").val();
        var hide_year = $("#hide_year").val();
		if (document.getElementById('hide_year').checked) {
			hide_year = 1;
		}
		else {
			hide_year = 0;
		}
	
		
		
		var gender_hide = $("#hide_gender").val();
		if (document.getElementById('hide_gender').checked) {
			gender_hide = 1;
		}
		else {
			gender_hide = 0;
		}
		var marital_status_hide = $("#hide_marital").val();
		if (document.getElementById('hide_marital').checked) {
			marital_status_hide = 1;
		}
		else {
			marital_status_hide = 0;
		}

		var nationality_hide = $("#hide_nationality").val();
		if (document.getElementById('hide_nationality').checked) {
			nationality_hide = 1;
		}
		else {
			nationality_hide = 0;
		}
		
		var tags_hide = $("#hide_tags").val();
		if (document.getElementById('hide_tags').checked) {
			tags_hide = 1;
		}
		else {
			tags_hide = 0;
		}
		
		var industry_id_hide = $("#hide_industry").val();
		if (document.getElementById('hide_industry').checked) {
			industry_id_hide = 1;
		}
		else {
			industry_id_hide = 0;
		}
		
		var phone_hide = $("#hide_phone").val();
		if (document.getElementById('hide_phone').checked) {
			phone_hide = 1;
		}
		else {
			phone_hide = 0;
		}
		
		var mobile_hide = $("#hide_mobile").val();
		if (document.getElementById('hide_mobile').checked) {
			mobile_hide = 1;
		}
		else {
			mobile_hide = 0;
		}
		
		var address1_hide = $("#hide_address1").val();
		if (document.getElementById('hide_address1').checked) {
			address1_hide = 1;
		}
		else {
			address1_hide = 0;
		}
		
		var address2_hide = $("#hide_address2").val();
		if (document.getElementById('hide_address2').checked) {
			address2_hide = 1;
		}
		else {
			address2_hide = 0;
		}
		
		var zip_hide = $("#hide_zip").val();
		if (document.getElementById('hide_zip').checked) {
			zip_hide = 1;
		}
		else {
			zip_hide = 0;
		}
		
		var country_id_hide = $("#hide_country").val();
		if (document.getElementById('hide_country').checked) {
			country_id_hide = 1;
		}
		else {
			country_id_hide = 0;
		}
		
		var city_hide = $("#hide_city").val();
		if (document.getElementById('hide_city').checked) {
			city_hide = 1;
		}
		else {
			city_hide = 0;
		}

        if (first == '') {
            $("#first").focus();
            //$('html, body').animate({scrollTop: $("#first").offset().top}, 1000);
            $('html,body').animate({scrollTop: 0}, 'slow');
            //$('body').animate({ scrollTop: '#first' }, 1000);
            return false;
        }
		if (birth_date == '') {
            $("#birth_date").focus();
            $('html,body').animate({scrollTop: 200}, 'slow');
            //$('html, body').animate({scrollTop: $("#birth_date").offset().top}, 1000);
            return false;
        }
		
		if (tags == '') {
			$("#tags").focus();
			//$('html, body').animate({scrollTop: $("#city").offset().top}, 1000);
			$('html,body').animate({scrollTop: 200}, 'slow');
			return false;
		}
		
        if (city == '') {
            $("#city").focus();
            //$('html, body').animate({scrollTop: $("#city").offset().top}, 1000);
            $('html,body').animate({scrollTop: 400}, 'slow');
            return false;
        }
        if(first.match(/^[a-zA-Z\s]+$/) !== null)  {
				document.getElementById('first_error').style.display = 'none';
			}
			else {
				document.getElementById('first_error').style.display = 'block';
				$("#first").focus();
				$('html,body').animate({scrollTop: 0}, 'slow');
				return false;
			}
			
			
			
			if(tags.match(/^[a-zA-Z\s]+$/) !== null)  {
				document.getElementById('tags_error').style.display = 'none';
				
			}
			else {
				document.getElementById('tags_error').style.display = 'block';
				$("#tags").focus();
				$('html,body').animate({scrollTop: 0}, 'slow');
				return false;
			}
			
			if(mobile.match(/^[0-9-+]+$/) !== null)  {
				document.getElementById('mobile_error').style.display = 'none';
			}
			else {
			$("#mobile_error").html('<div class="validate_error">Enter a valid mobile number.</div>');
				document.getElementById('mobile_error').style.display = 'block';
				$("#mobile").focus();
				$('html,body').animate({scrollTop: 300}, 'slow');
				return false;
			}
			
			if(phone.match(/^[0-9-+]+$/) !== null)  {
				document.getElementById('phone_error').style.display = 'none';
			}
			else {
			$("#phone_error").html('<div class="validate_error">Enter a valid phone number.</div>');
				document.getElementById('mobile_error').style.display = 'block';
				$("#phone").focus();
				$('html,body').animate({scrollTop: 300}, 'slow');
				return false;
			}
			if(city.match(/^[a-zA-Z\s]+$/) !== null)  {
				document.getElementById('city_error').style.display = 'none';
				
			}
			else {
				document.getElementById('city_error').style.display = 'block';
				$("#city").focus();
				$('html,body').animate({scrollTop: 400}, 'slow');
				return false;
			}
			$("#basic_info_loader").show();
        postData = {"action": "basic", "request": {"title": title, "first": first, "last": last, "gender": gender, "birth_date": birth_date, "nationality": nationality, "tags": tags, "industry_id": industry_id, "phone": phone, "mobile": mobile, "address1": address1, "address2": address2, "fax": fax, "pobox": pobox, "city": city, "country_id": country_id, "marital_status": marital_status, "hide_year": hide_year, "pro_summary": pro_summary, "gender_hide": gender_hide, "marital_status_hide": marital_status_hide, "nationality_hide": nationality_hide, "tags_hide": tags_hide, "industry_id_hide": industry_id_hide, "phone_hide": phone_hide, "mobile_hide": mobile_hide, "address1_hide": address1_hide, "address2_hide": address2_hide, "zip_hide": zip_hide, "country_id_hide": country_id_hide, "city_hide": city_hide}};

        $.ajax({
            type: "POST",
            url: NETWORKWE_URL +"/users_profiles/update/",
            data: postData,
            success: function(data, textStatus) {
                ajaxProcess = false;
                if (data == 1) {
                    $("#message_profile").slideDown('slow').delay(1000).fadeOut();
                    window.location.replace(NETWORKWE_URL+"/users_profiles/myprofile");
                }
            },
			complete: function() {
					$("#basic_info_loader").hide();

            }
        });

    }

   $(document).ready(function() {
        if (typeof easyResponsiveTabs !== 'undefined' && $.isFunction(easyResponsiveTabs)) {
            $('#horizontalTab').easyResponsiveTabs({
                type: 'default', //Types: default, vertical, accordion
                width: 'auto', //auto or any width like 600px
                fit: true, // 100% fit in a container
                closed: 'accordion', // Start closed if in accordion view
                activate: function(event) { // Callback function if tab is switched
                    var $tab = $(this);
                    var $info = $('#tabInfo');
                    var $name = $('span', $info);

                    $name.text($tab.text());

                    $info.show();
                }
            });

            $('#verticalTab').easyResponsiveTabs({
                type: 'vertical',
                width: 'auto',
                fit: true
            });
        }
    });
