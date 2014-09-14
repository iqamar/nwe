

<style>
#passwordStrength {
        width:100%;
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
        left:0;8/
    }
</style>
<script type="text/javascript" src="http://media.networkwe.com/js/passwd_meter_strength.js"></script>

<script>
	var twiterJSON;
	
	function validateForm(){
		
			email_address = document.getElementById("userRegEmail").value;
			password = document.getElementById("userRegPassword").value;			
			var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (!filter.test(email_address)) {
				alert('Please provide a valid email address');
				document.getElementById("userRegEmail").focus;
				return false;
			}			
			if(password.length < 6 ){
				alert('Please provide a valid password. Must be atleast six characters.');
				document.getElementById("userRegPassword").focus;
				return false;				
			}
			return true;		
		}
    jQuery(document).ready(function() {
		
		
        jQuery("#step1Submit").click(function() {
			 
			/*email_address = ("#userRegEmail").val();
			password = ("#userRegPassword").val();
			var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (!filter.test(email_address)) {
				alert('Please provide a valid email address');
				$("#userRegEmail").focus;
				return false;
			}
			
			if(password.length < 6 ){
				alert('Please provide a valid password. Must be atleast six characters.');
				$("#userRegPassword").focus;
				return false;
				
			}*/
        
        
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

		twitterConnect = function(){
			screen_name = $("#screen_name").val();

			if((screen_name == "") || (screen_name == " ")){alert("Please provide valid twitter screen name"); return false;}
			$.get( "<?= $this->request->base ?>/apps/TwitterOAuth/connect.php?handle="+screen_name, function( data ) {
				response = data.split("$$");
				if(response[0] != 1){alert("Please provide valid twitter screen name"); return false;}
				

				//tw_verify_password tw_password tw_email_address tw_last_name tw_first_name tw_photo twitter_details


				jsonObj = jQuery.parseJSON( response[1]);
				twiterJSON = jsonObj;
				tw_name = jsonObj.first_name +" "+ jsonObj.last_name +"("+ jsonObj.screen_name +")";
				$("#tw_first_name").val(jsonObj.first_name);
				$("#tw_last_name").val(jsonObj.last_name);
				$("#tw_photo").attr("src", jsonObj.profile_photo);
				$( "#tw_name" ).html( tw_name );

				$("#twitter_master").hide();
				$("#twitter_details").show();
				
			//	$( ".result" ).html( data );
			//	alert( "Load was performed." );
			});
			return false;

		}

		twitterSaveData = function(){
			
			twiterJSON.first_name = $("#tw_first_name").val();
			twiterJSON.last_name = $("#tw_last_name").val();
			twiterJSON.email_address = $("#tw_email_address").val();
			twiterJSON.password = $("#tw_password").val();
			twiterJSON.social ="twitter";
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

		tw_db_reply = function (data){
			if(data == 1 ){
				$("#twitter_master").hide();
				$("#twitter_details").hide();
				$("#twitter_thankyou").show();

			}else if(data == -1 ){
				alert("The email address you entered is already being used for another NetworkWe Account.")
			}else{
				alert("Unable to register. Please try again.")
			}
		}

				
		$("#userRegPassword").passwordStrength({
               targetDiv:'passwordStrength',
                showTime: false,
				text:{}
        });
        
        $("#tw_password").passwordStrength({
				targetDiv:'tw_passwordStrength',
				progressTargetDiv: 'tw_progress',
				progressBarTargetDiv: 'tw_progressbar',
				percentageTargetDiv: 'tw_percentage',
                showTime: false,                
				text:{}
        });




    });



</script>
<?php echo $this->Form->create("User", array('controller' => 'users', 'onsubmit' => 'javascript:return validateForm();', 'action' => 'ajax_signup_step1', 'id' => 'axForm', 'class' => 'user_reg')); ?>
<table width="100%" border="0" cellspacing="2" cellpadding="1">
  <tr>   
  
   <td class="transparent-logo"><strong>Quick sign up </strong>
       <?php echo $this->Html->link($this->Html->image('home-page/icon-linkedin.jpg', array('alt' => '')), $this->request->base.'/apps/LinkedinOAuth/connect.php', array('escapeTitle' => false, 'title' => '')); ?>
       <?php echo $this->Html->link($this->Html->image('home-page/icon-twitter.jpg', array('alt' => '')),'#?',array('rel' => 'twitterlogin', 'class' => 'poplight','escapeTitle' => false, 'title' => '')); ?>
       <?php echo $this->Html->link($this->Html->image('home-page/icon-fb.jpg', array('alt' => '')),$this->request->base.'/apps/FacebookSDK/connect.php',array('escapeTitle' => false, 'title' => '')); ?>     
  </tr>
	<tr>
    <td>&nbsp;</td>
  </tr> 
  <tr>
    <td><hr/><strong>Or sign up with your email address:</strong></td>
  </tr> 

  <tr>
    <td>What Type of user you are? </td>
  </tr>
  <tr>
    <td>
        <?php 
        $options_1 = array(
            '1' => 'I am a Professional',
            //'2' => 'I am a Employer',
            //'4' => 'I am a Advertiser',
            //'5' => 'I am a Publisher',
            //'6' => 'I am a Developer',
            //'7' => 'I am a Journalist', 
            '2' => 'I am a Recruiter'
            );
        echo $this->Form->input('role_id', array('options' => $options_1,'label' => false,'div'=>true,'class'=>'droplist width1droplist'));?></td>
  </tr>
  <tr>
    <td><?=__('Email Id  ')?><span class="note-text"><?=__('( your email id will be your User Name for login)')?></span> </td>
  </tr>
  <tr>
    <td><?php echo $this->Form->email('email', array('required' => true, 'class' => 'textfield width1', 'id' => 'userRegEmail')) ?></td>
  </tr>
  <tr>
    <td>Select Password <span class="note-text">(should be at least 6 characters)</span> </td>
  </tr>
  <tr>
    <td><?php echo $this->Form->password('password', array('type' => 'password', 'class' => 'textfield width1 mypassword', 'id' => 'userRegPassword')) ?>
    <div id="passwordStrength"></div>
    </td>
  </tr>
  <tr>
    <td><?php echo $this->Form->submit('Sign Up', array('type' => 'submit', 'label' => false, 'class'=>'red-bttn')); ?></td>
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

 
<!--- Login Box Starts Here --->
<div id="twitterlogin" class="popup_block" style="width:500px;"> 
    <div class="popup-heading"><h1>Register Using Twitter Account </h1></div>
		<div id="twitter_master">	
	    	<form action="" method="get" class="loginformstyle" onsubmit="return false;">
				<fieldset>
					<label style="width:120px;" for="">Twitter Handle<span class="redcolor">*</span></label>
					<label1 style="width:370px;">https://twitter.com/ <input style="width:100px;" name="" type="text" id="screen_name" placeholder="screen name"/> <input name="" type="submit" onclick="return twitterConnect();" value="Fetch Details" /></label1>									
					
				</fieldset>
			</form>
		</div>


		<div id="twitter_details" style="display:none;">
			Thanks <span id="tw_name"></span>.<br/>
				Just a few more details ...
			<hr/>

			<form action="" method="get" class="loginformstyle" onsubmit="return false;">
				<fieldset>
					<div style="float:left;width:380px">
						<label style="width:100px;" for="">First Name</label>
						<label1 style="width:270px;"><input id="tw_first_name" name="tw_first_name" type="text" placeholder="First Name"/></label1>									
						<label style="width:100px;" for="">Last Name</label>
						<label1 style="width:270px;"><input id="tw_last_name" name="tw_last_name" type="text" placeholder="Last Name"/></label1>
						<label style="width:100px;" for="">Email address<span class="redcolor">*</span></label>
						<label1 style="width:270px;"><input id="tw_email_address" name="tw_email_address" type="text" placeholder="Email address"/></label1>
						<label style="width:100px;" for="">Password<span class="redcolor">*</span></label>
						<label1 style="width:270px;"><input id="tw_password" name="tw_password" type="Password" placeholder="Password"/>
						<div id="tw_passwordStrength">
						
<div id="tw_progressbar"><div id="tw_progress" style="width: 0%; background-color: rgb(234, 255, 0);"></div><div id="tw_percentage"></div></div>
						</div>
						</label1>
						
					<!--	<label style="width:100px;" for="">Verify Password<span class="redcolor">*</span></label>
						<label1 style="width:270px;"><input id="tw_verify_password" name="tw_verify_password" type="Password" placeholder="Password"/></label1>-->
				   </div>
					<div style="float: right; border-radius: 10px; background: none repeat scroll 0% 0% rgb(193, 193, 193); height: 96px; padding: 10px;">
								<img id="tw_photo" src="" alt="" width="96" height="96" border="0" />
					</div>
					<div style="clear:both;"></div>
					<input name="" type="submit" onclick="return twitterSaveData();" value="Register" />
				</fieldset>
			</form>
		</div>

		<div id="twitter_thankyou" style="display:none;">
			<h3>Thank yoy for registering with NetworkWe</h3>
			<h4>A confirmation link is sent to your mentioned email.</h4>
			
			
		</div>
	</div>
	<!--- Login Box Ends Here --->
