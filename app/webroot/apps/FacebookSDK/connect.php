<?php
session_start();
error_reporting(0);
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require 'src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '239132809574955',
  'secret' => '349eb44f0e59a95f0fb41f5475979fcb',
));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me?fields=name,email,birthday,location,username,first_name,last_name,gender,education,work,hometown');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}  
//session_destroy();
// Login or logout url will be needed depending on current user state.
if ($user) {

  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $statusUrl = $facebook->getLoginStatusUrl();

  $loginUrl = $facebook->getLoginUrl(array('scope' => 'email,user_location,user_birthday'));
  echo '<script language="javascript">document.location="'.$loginUrl.'"; '.	
		'</script>';
	exit;
}
?>
<?php if ($user): 
require_once("../commons/header.inc.php");



?>




	
	
	

<script>
	var facebookJSON =new Object();  
	
	 
	 facebookJSON.birthday = "<?php echo $user_profile["birthday"];?>";
	 facebookJSON.gender = '<?php echo $user_profile["gender"];?>';
	 
	 <?php 
	 
	 if(isset($user_profile["education"])){
		 $education = '[';
		foreach($user_profile["education"] as $edu){
                $education .= '{"name":"'.$edu["school"]["name"].'","year":"'.$edu["year"]["name"].'","type":"'.$edu["type"].'"},';	
        }
        $education = trim($education,",").']';					
				
				 
	 ?>
	  facebookJSON.education = '<?php echo $education;?>';	
	  <?php 
	 }
	 if(isset($user_profile["work"])){
		  $positions = '[';
		 foreach($user_profile["work"] as $work){
                $positions .= '{"name":"'.$work["employer"]["name"].'","location":"'.$work["location"]["name"].'","job_title":"'.$work["position"]["name"].'","start_date":"'.$work["start_date"].'","end_date":"'.$work["end_date"].'"},';	
        }
        $positions = trim($positions,",").']';
	 ?>
	  facebookJSON.experience = '<?php echo $positions;?>';	
	  <?php 
	 
	}
	 ?>
	 					
	jQuery(document).ready(function() {
		facebookSaveData = function(){
			
			email_address = $("#fb_email").val();
			password = $("#fb_password").val();
			
			var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (!filter.test(email_address)) {
				alert('Please provide a valid email address');
				$("#fb_email").focus;
				return false;
			}
			
			if(password.length < 6 ){
				alert('Please provide a valid password. Must be atleast six characters.');
				$("#fb_password").focus;
				return false;
				
			}
			
			
			facebookJSON.first_name = $("#fb_first_name").val();
			facebookJSON.last_name = $("#fb_last_name").val();
			facebookJSON.email_address = email_address;
			facebookJSON.password = password;
			facebookJSON.profile_photo = $("#fb_photo").val();
			facebookJSON.city = $("#fb_city").val();
			facebookJSON.social ="facebook";


			$.ajax({
					type: "POST",
					url: "http://www.networkwe.com/users/register_social",
					data: facebookJSON,
					success: fb_db_reply,
					dataType: "JSON"	
				});

			
			return false;

		}

		fb_db_reply = function (data){
			if(data == 1 ){				
				$("#facebook_details").hide();
				$("#facebook_thankyou").show();

			}else if(data == -1 ){
				alert("The email address you entered is already being used for another NetworkWe Account.")
			}else{
				alert("Unable to register. Please try again.")
			}
		}


		
  $("#fb_password").passwordStrength({
               targetDiv:'passwordStrength',
                showTime: false,
                                text:{}
        });

    });




</script>
    
<div class="wrapper">
	<div class="maincontent" style="min-height: 600px;">
		<div class="boxheading">
			<h1>Register Using Facebook Account <small style="float: right; color: gray; font-size: 9px;">You may exercise your right to access, modify or delete your personal information at any time on Networkwe.</small></h1>
			<div class="boxheading-arrow"></div>
		</div>
		<div class="margintop20" id="facebook_thankyou" style="display:none;">

			<div class="listing">
		       	 <div class="heading" style="padding:40px;">
		       	    	<h3>Thank yoy for registering with NetworkWe</h3>
						<h4>A confirmation link is sent to your mentioned email.</h4>
						<br/><br/><br/><br/>
						<h2>Once verify your account, click <a style="color: #FF0000;text-decoration: underline;" href="http://www.networkwe.com">here</a> to login</h2>
				
        		</div>
			</div>

		</div>


		<input type="hidden" id="fb_first_name" value="<?php echo $user_profile["first_name"]; ?>">
		<input type="hidden" id="fb_last_name" value="<?php echo $user_profile["last_name"]; ?>">
		<input type="hidden" id="fb_city" value="<?php echo $user_profile["location"]["name"]; ?>">
		<input type="hidden" id="fb_photo" value="https://graph.facebook.com/<?php echo $user; ?>/picture">
		<div class="margintop20" id="facebook_details">
        <div class="lftloginbox tabledata-style">
        <div class="listing">
       	  <div class="heading">
       	    <h1>Thanks <?php echo $user_profile["first_name"]; ?>.</h1>
					<small style="float: right; color: gray; font-size: 12px;">Just a few more details..</small></div>
<div style="clear:both;"></div>
<hr/>

We successfully capture your information from facebook. please provide valid username and password in order to create your networkwe account

<div style="margin-top:10px;box-shadow: 1px 1px 10px 1px; padding: 10px;"><h3>Create Your NetworkWe Account</h3>
       	  <table width="100%">
       	    <tr>
       	      <td>Username</td>
       	      <td><input type="text" name="email"  id="fb_email" value="<?php echo $user_profile["email"]; ?>" /></td>
   	        </tr>
       	    <tr>
       	      <td>Password</td>
       	      <td><input type="password" name="password" id="fb_password"  /> <div id="passwordStrength"></div></td>
   	        </tr>
       	    <!--<tr>
       	      <td>Verify Password</td>
       	      <td><input type="password" name="email3"  /></td>
   	        </tr>-->
       	    <tr>
       	      <td>&nbsp;</td>
       	      <td><input type="submit" name="button" id="button" value="Register" onclick="return facebookSaveData();" /></td>
   	        </tr>
       	    
   	      </table>
   	      </div>
       	  <div class="clear"></div>
		</div>
        </div>

		<div class="rgtloginbox tabledata-style">
			<div class="listing">
				<div class="listing-logo">
					<a href="jobs-detail.html">
                    	<img src="https://graph.facebook.com/<?php echo $user; ?>/picture" alt="" width="180" height="164" border="0" />
					</a>
				</div>
				<div class="listing-rgt">
					<ul>
						<li>
							<h1><?php echo $user_profile["first_name"]." ".$user_profile["last_name"]; ?></h1>
						</li>
						<li>Location: <span class="location"><?php echo $user_profile["location"]["name"]; ?></span> </li>
						<li>Date of Birth: <?php echo $user_profile["birthday"]; ?></li>
						<li>Gender: <?php echo $user_profile["gender"]; ?> </li>
					</ul>
				</div>
				<div class="clear"></div>
		</div>


	
		<?php
			if(isset($user_profile["education"])){
		?>
				<div class="listing">
		       	  <div class="heading">
		       	    <h1>Education</h1></div>
						<table width="100%" border='0'>
		                <tr class="headingtd">
		                  <td width="33%" height="30" bgcolor="#333333"><span>Name</span></td>
		                  <td width="33%" height="30" bgcolor="#333333"><span>Year</span></td>
		                  <td width="33%" height="30" bgcolor="#333333"><span>Type</span></td>
		                  </tr>              
				

				<?php
				$idx=0;
				foreach($user_profile["education"] as $education){
					if($idx%2 ==0){$bgcolor="#FBFBFB";}else{$bgcolor="#DFDFDF";}
									 
					echo '<tr><td width="33%" bgcolor="'.$bgcolor.'">'.$education["school"]["name"].'</td><td width="33%" bgcolor="'.$bgcolor.'">'.$education["year"]["name"].'</td><td width="33%" bgcolor="'.$bgcolor.'">'.$education["type"].'</td></tr>';
					$idx++;
				}
				echo '</table><div class="clear"></div></div>';
			}
		?>

				

		
		<?php
			if(isset($user_profile["work"])){
	?>
				  <div class="listing">
       	  <div class="heading"><h1>Work Experience</h1></div>
				<table width="100%" border='0'>
                <tr class="headingtd">
                  <td width="175" height="30" bgcolor="#333333"><span>Employer</span></td>
                  <td width="136" height="30" bgcolor="#333333"><span>Location</span></td>
                  <td width="181" height="30" bgcolor="#333333"><span>Position</span></td>
                  <td width="83" height="30" bgcolor="#333333"><span>Start Date</span></td>
                  <td width="81" height="30" bgcolor="#333333"><span>End Date</span></td>
                </tr>
	<?php
				$idx=0;
			
				foreach($user_profile["work"] as $work){
					if($idx%2 ==0){$bgcolor="#FBFBFB";}else{$bgcolor="#DFDFDF";}
					echo '<tr><td bgcolor="'.$bgcolor.'">'.$work["employer"]["name"].'</td><td bgcolor="'.$bgcolor.'">'.$work["location"]["name"].'</td><td bgcolor="'.$bgcolor.'">'.$work["position"]["name"].'</td><td align="center" bgcolor="'.$bgcolor.'">'.$work["start_date"].'</td><td align="center" bgcolor="'.$bgcolor.'">'.$work["end_date"].'</td></tr>';
					$idx++;
				}
				echo '</table><div class="clear"></div></div>';
			}


require_once("../commons/footer.inc.php");
		?>

				

	
	  
	   
      <pre><?php //print_r($user_profile); ?></pre>


    
    <?php endif ?>

  
