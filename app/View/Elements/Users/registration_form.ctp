<?php echo $this->Html->script(array(MEDIA_URL . '/js/jquery.validate.js', MEDIA_URL . '/js/jquery.form.js')); ?>
<style type="text/css">
    #passwordStrength {
        width:280px;
        border-left:1px solid #ccc;
        border-right:1px solid #ccc;
        border-top:1px solid #ccc;
        /*border-top-right-radius: 8px;
        border-top-left-radius: 8px;
        border-bottom:1px solid #ccc;
        border-bottom-right-radius: 8px;
        border-bottom-left-radius: 8px;*/
        background-color: white;
        position:relative;
    }

    #progressbar {
        height:15px;
        display:block;
        overflow:hidden;
        border-top:1px solid #ccc;
        /*  border-top-right-radius: 8px;
          border-top-left-radius: 8px;*/
    }

    #progress {
        display:block;
        height:15px;
        width:0%;
        z-index: 100;
    }

    #percentage {
        display:block;
        width:100%;
        text-align:center;
        z-index: 1000;
        height: 15px;
        font-weight: bold;
        position:absolute;
        top:0;
        left:0;
    }


    #tw_progressbar {
        height:15px;
        display:block;
        overflow:hidden;
        border-top:1px solid #ccc;
        /* border-top-right-radius: 8px;
         border-top-left-radius: 8px;*/
    }

    #tw_progress {
        display:block;
        height:15px;
        width:0%;
        z-index: 100;
        float:left;
    }

    #tw_percentage {
        display:block;
        float:right;
        margin-left:50px;
        text-align:center;
        z-index: 1000;
        height: 15px;
        font-weight: bold;
        position:absolute;
        /* top:0;
        left:0;*/
        }
        .error_msg { text-align: left; }
	a#socialLink{width:28px;height:28px;display:block;padding:2px;float:left;}
    </style>
    <script type="text/javascript" src="http://media.networkwe.com/js/passwd_meter_strength.js"></script>
    <script type="text/javascript">
        var twiterJSON;
             
        jQuery(document).ready(function() {

            jQuery("#step1Submit").click(function() {
                jQuery.post("<?= $this->request->base ?>/users/ajax_signup_step1", jQuery("#regForm").serialize(), function(data) {
                    if (data.indexOf('mooError') > 0) {

                        jQuery("#regError").show();
                        jQuery("#regError").html(data);
                    } else {
                        alert("signup called");
                        jQuery("#regError").hide();
                    }
                });
            });

            twitterConnect = function() {
                screen_name = $("#screen_name").val();
                if ((screen_name == "") || (screen_name == " ")) {
                    alert("Please provide valid twitter screen name");
                    return false;
                }
                $.get("<?= $this->request->base ?>/apps/TwitterOAuth/connect.php?handle=" + screen_name, function(data) {
                    response = data.split("$$");
                    if (response[0] != 1) {
                        alert("Please provide valid twitter screen name");
                        return false;
                    }
                    //tw_verify_password tw_password tw_email_address tw_last_name tw_first_name tw_photo twitter_details
                    jsonObj = jQuery.parseJSON(response[1]);
                    twiterJSON = jsonObj;
                    tw_name = jsonObj.first_name + " " + jsonObj.last_name + "(" + jsonObj.screen_name + ")";
                    $("#tw_first_name").val(jsonObj.first_name);
                    $("#tw_last_name").val(jsonObj.last_name);
                    $("#tw_photo").attr("src", jsonObj.profile_photo);
                    $("#tw_name").html(tw_name);
                    $("#twitter_master").hide();
                    $("#twitter_details").show();
                    //	$( ".result" ).html( data );
                    //	alert( "Load was performed." );
                });
                return false;
            }

            twitterSaveData = function() {
                twiterJSON.first_name = $("#tw_first_name").val();
                twiterJSON.last_name = $("#tw_last_name").val();
                twiterJSON.email_address = $("#tw_email_address").val();
                twiterJSON.password = $("#tw_password").val();
                twiterJSON.social = "twitter";
                //twiterJSON
                $.ajax({
                    type: "POST",
                    url: "<?= $this->request->base ?>users/register_social",
                    data: twiterJSON,
                    success: tw_db_reply,
                    dataType: "JSON"
                });
                return false;
            }

            tw_db_reply = function(data) {
                if (data == 1) {
                    $("#twitter_master").hide();
                    $("#twitter_details").hide();
                    $("#twitter_thankyou").show();
                } else if (data == -1) {
                    alert("The email address you entered is already being used for another NetworkWe Account.")
                } else {
                    alert("Unable to register. Please try again.")
                }
            }

            $("#userRegPassword").passwordStrength({
                targetDiv: 'passwordStrength',
                showTime: false,
                text: {}
            });

            $("#tw_password").passwordStrength({
                targetDiv: 'tw_passwordStrength',
                progressTargetDiv: 'tw_progress',
                progressBarTargetDiv: 'tw_progressbar',
                percentageTargetDiv: 'tw_percentage',
                showTime: false,
                text: {}
            });
            
            $.validator.addMethod("alphanumeric", function(value, element) {
                return this.optional(element) || /^\w+$/i.test(value);
            }, "Letters, numbers, and underscores only please");
        
            $.validator.addMethod('validemail', function (emailAddress) {
                var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
                return pattern.test(emailAddress);
            },'Invalid Email!');
            
           $('#axForm').validate({
               debug: false,
               rules: { 
                    userRegEmail: {
                        required: true,
                        validemail: true,
                        remote: {
                            param: {
                                url: "<?php echo NETWORKWE_URL?>/publices/chkemail/",
                                type: "get",
                                async: true,
                                data: {
                                    primary_email: function() {
                                        return $('#userRegEmail').val();
                                    }
                                }
                            },
                            depends: function(element){
                                return $('#UserRoleId').val() == 2;
                            }
                        }
                    },
                    userRegPassword: {
                        required: true, 
                        minlength: 6,
                        alphanumeric: true
                    } 
                },
                messages: {
                    userRegEmail: {
                        validemail: "Invalid email format",
                        required: "Email address required",
                        minlength: jQuery.format("At least {0} characters required!"),
                        remote: "Domain already in use, Please use a different one."
                    } 
                },
                errorClass: 'error_msg',
                errorElement:'div',
                errorPlacement: function(error, element) { error.insertAfter("#userRegPassword"); },
                highlight: function(element) { $(element).removeClass("error_msg"); }
           });

        });
$(function(){ 
	$('a.current').click(function(e){
		
		return true;
		
	});
	
	
	
});
    </script>
    <?php echo $this->Form->create("User", array('controller' => 'users', 'action' => 'ajax_signup_step1', 'id' => 'axForm', 'name'=>'axForm', 'class' => 'user_reg')); ?>
    <table width="100%" border="0" cellspacing="2" cellpadding="1">
        <tr>
            <td style="text-align:center;"><strong>Quick sign up </strong></td>
		</tr>
		<tr>
			<td style="padding-left:60px;">
				<?php echo $this->Html->link('', $this->request->base . '/apps/LinkedinOAuth/connect.php', array('escape' => false,'id'=>'popup_linkedin','class'=>'current')); ?>
                <?php echo $this->Html->link('', '#?', array('rel' => 'twitterlogin', 'class' => 'poplight current', 'escapeTitle' => false, 'title' => '','id'=>'popup_twitter')); ?>
                <?php echo $this->Html->link('', $this->request->base . '/apps/FacebookSDK/connect.php', array('escape' => false, 'title' => '','id'=>'popup_fb','class'=>'current')); ?>
				<?php echo $this->Html->link('', $this->request->base . '/apps/GulfBankers/connect.php', array('escape' => false, 'title' => '','id'=>'popup_gb','class'=>'current')); ?>
				<?php echo $this->Html->link('', $this->request->base . '/apps/GulfManagers/connect.php', array('escape' => false, 'title' => '','id'=>'popup_gm','class'=>'current')); ?>
				<?php echo $this->Html->link('', $this->request->base . '/apps/EBankingCareers/connect.php', array('escape' => false, 'title' => '','id'=>'popup_ebc','class'=>'current')); ?>
			</td>
		</tr>
		<tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><strong>Or sign up with your email address:</strong>
</td>
        </tr>
        </tr>

        <tr>
            <td>What Type of user you are? </td>
        </tr>
	<tr>
            <td class="note-text" style="text-align:right;color:green;"><strong>Register as an employer to post jobs</strong></td>
        </tr>

        <tr>
            <td>
                <?php
                $options_1 = array(
                    '1' => 'I am a Professional',
                    '2' => 'I am an Employer'
                    //'4' => 'I am a Advertiser',
                    //'5' => 'I am a Publisher',
                    //'6' => 'I am a Developer',
                    //'7' => 'I am a Journalist',
//                    '2' => 'I am a Recruiter'
                );
                echo $this->Form->input('role_id', array('options' => $options_1, 'label' => false, 'div' => true, 'class' => 'droplist width1droplist'));
                ?></td>
        </tr>
        <tr>
            <td><?= __('Email Id  ') ?><span class="note-text"><?= __('( your email id will be your User Name for login)') ?></span> </td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('email', array('type' => 'text', 'required' => true, 'class' => 'textfield width1', 'id' => 'userRegEmail', 'name' => 'userRegEmail','label'=>false,'div'=>false)) ?></td>
        </tr>
        <tr>
            <td>Select Password <span class="note-text">(should be at least 6 characters)</span> </td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('password', array('type' => 'password', 'required' => true, 'class' => 'textfield width1 mypassword', 'id' => 'userRegPassword', 'label'=>false,'div'=>false,'name' => 'userRegPassword')) ?>
                <div id="passwordStrength"></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $this->Form->submit('Sign Up', array('type' => 'submit', 'label' => false, 'class' => 'red-bttn')); ?></td>
        </tr>
    </table>
    <?php echo $this->Form->hidden('oauth', array('value' => '0')) ?>
    <?php echo $this->Form->end(); ?>

    <!--- Login Box Starts Here --->
    <div id="linkedinlogin" class="popup_block">
        <div class="popup-heading"><h1>Login With Your Linkedin ID</h1></div>
        <form action="" method="get" class="loginformstyle">
            <fieldset>
                <label for="">Login ID <span class="redcolor">*</span></label>
                <label1><input name="" type="text" /></label1>
                <label for="">Password <span class="redcolor">*</span></label>
                <label1><input name="" type="password" class="textfield"/></label1>
                <label1>
                    <input name="" type="submit" value="Login" />
                    <input name="" type="checkbox" value="" /> Remember Me
                </label1>
            </fieldset>
        </form>
    </div>
    <!--- Login Box Ends Here --->


    
