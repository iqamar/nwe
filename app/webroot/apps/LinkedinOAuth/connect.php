<?php

//$oauth->setToken("71fc36e7-1ee2-4bd6-a184-ece5b1ae1702", "d7cdb1e1-e4c3-473f-82af-b4382648a113");
 
// Change these
define('API_KEY',      'cb3jeygyo96v');
define('API_SECRET',   'XfqlQyiJfopr7NK7');
define('REDIRECT_URI', 'http://www.networkwe.com/apps/LinkedinOAuth/connect.php');// . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']);
//define('SCOPE',        'r_fullprofile');
define('SCOPE',        'r_basicprofile r_fullprofile r_emailaddress r_contactinfo');
// You'll probably use a database

ob_start();
session_start();
error_reporting(0);
if($_GET["action"]=="changeAccount"){
	 session_destroy();
	  header("Location: connect.php");
		exit;
}
// OAuth 2 Control Flow
if (isset($_GET['error'])) {
    // LinkedIn returned an error
    print $_GET['error'] . ': ' . $_GET['error_description'];
    exit;
} elseif (isset($_GET['code'])) {
    // User authorized your application
    if ($_SESSION['state'] == $_GET['state']) {
        // Get token so you can make API calls
        getAccessToken();
    } else {
        // CSRF attack? Or did you mix up your states?
        exit;
    }
} else { 
    if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
        // Token has expired, clear the state
        $_SESSION = array();
    }
    if (empty($_SESSION['access_token'])) {
        // Start authorization process
        getAuthorizationCode();
    }
}

 
// Congratulations! You have a valid token. Now fetch your profile 
//$user = fetch('GET', '/v1/people/~:(first-name,last-name,headline,picture-url,location,industry,summary,email-address,skills,languages,courses,certifications,three-current-positions,three-past-positions,date-of-birth)'); //, educations,company,date-of-birth,honors-awards
$user = fetch('GET', '/v1/people/~:(first-name,last-name,headline,picture-url,location,industry,summary,email-address,three-current-positions,three-past-positions)');
require_once("../commons/header.inc.php");
echo "<div style='display:none;'>";

print_r($user);
echo "</div>";

//$location= "{code:'". $user->location->country->code ."',name:'".$user->location->name."'}";
$location= $user->location->country->code;
$current_positions = "";
if(isset($user->threeCurrentPositions->_total)){
	$current_positions = '[';
	foreach($user->threeCurrentPositions->values as $current){
		$current_positions .= '{"name":"'.$current->company->name.'","title":"'.$current->title.'","isCurrent":"'.$current->isCurrent.'"},';	
	}
	$current_positions = trim($current_positions,",").']';

}
$past_positions = "";
if(isset($user->threePastPositions->_total)){
        $past_positions = '[';
        foreach($user->threePastPositions->values as $past){
                $past_positions .= '{"name":"'.$past->company->name.'","title":"'.$past->title.'","isCurrent":"'.$past->isCurrent.'"},';	
        }
        $past_positions = trim($past_positions,",").']';

}
?>
<script>
	var linkedinJSON =new Object();
    
	 linkedinJSON.summary = "<?php echo urlencode($user->summary);?>";	
	 linkedinJSON.location = "<?php echo $location;?>";
	 linkedinJSON.exp_current = '<?php echo $current_positions;?>';
	 linkedinJSON.exp_past = '<?php echo $past_positions;?>';
	 
	 linkedinJSON.headline = "<?php echo urlencode($user->headline);?>";
	 linkedinJSON.industry = "<?php echo urlencode($user->industry);?>";		 
	 
	jQuery(document).ready(function() {
		linkedinSaveData = function(){
			email_address = $("#ln_email").val();
			password = $("#ln_password").val();
			
			
			var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (!filter.test(email_address)) {
				alert('Please provide a valid email address');
				$("#ln_email").focus;
				return false;
			}
			
			if(password.length < 6 ){
				alert('Please provide a valid password. Must be atleast six characters.');
				$("#ln_password").focus;
				return false;
				
			}
			linkedinJSON.first_name = $("#ln_first_name").val();
			linkedinJSON.last_name = $("#ln_last_name").val();
			linkedinJSON.email_address = email_address;
			linkedinJSON.password = password;
			linkedinJSON.profile_photo = $("#ln_photo").val();
			linkedinJSON.city = "";//$("#ln_city").val();
			linkedinJSON.social ="linkedin";
		

			$.ajax({
					type: "POST",
					url: "http://www.networkwe.com/users/register_social",
					data: linkedinJSON,
					success: ln_db_reply,
					dataType: "JSON"	
				});

			
			return false;

		}

		ln_db_reply = function (data){
			if(data == 1 ){				
				$("#linkedin_details").hide();
				$("#linkedin_thankyou").show();

			}else if(data == -1 ){
				alert("The email address you entered is already being used for another NetworkWe Account.")
			}else{
				alert("Unable to register. Please try again.")
			}
		}


	$("#ln_password").passwordStrength({
               targetDiv:'passwordStrength',
                showTime: false,
				text:{}
        });

    });




</script>
    
<div class="wrapper">
	<div class="maincontent" style="min-height: 600px;">
		<div class="boxheading">
			<h1>Register Using Linkedin Account <small style="float: right; color: gray; font-size: 9px;">You may exercise your right to access, modify or delete your personal information at any time on Networkwe.</small></h1>
			<div class="boxheading-arrow"></div>
		</div>
		<div class="margintop20" id="linkedin_thankyou" style="display:none;">

			<div class="listing">
		       	 <div class="heading" style="padding:40px;">
		       	    	<h3>Thank yoy for registering with NetworkWe</h3>
						<h4>A confirmation link is sent to your mentioned email.</h4>
						<br/><br/><br/><br/>
						<h2>Once verify your account, click <a style="color: #FF0000;text-decoration: underline;" href="http://www.networkwe.com">here</a> to login</h2>
				
        		</div>
			</div>

		</div>
		<input type="hidden" id="ln_first_name" value="<?php echo $user->firstName;; ?>">
		<input type="hidden" id="ln_last_name" value="<?php echo $user->lastName;; ?>">
		<input type="hidden" id="ln_city" value="<?php echo $user->location->name; ; ?>">
		<input type="hidden" id="ln_photo" value="<?php echo $user->pictureUrl; ; ?>">
		<div class="margintop20" id="linkedin_details">
        <div class="lftloginbox tabledata-style">
        <div class="listing">
       	  <div class="heading">
       	    <h1>Thanks <?php echo $user->firstName; ?>.</h1>
					<small style="float: right; color: gray; font-size: 12px;">Just a few more details..</small></div>					
<div style="clear:both;"></div>
<hr/>       	
We successfully capture your information from linkedin. please provide valid username and password in order to create your networkwe account

<div style="margin-top:10px;box-shadow: 1px 1px 10px 1px; padding: 10px;"><h3>Create Your NetworkWe Account</h3>

       	    <table width="100%">
       	    <tr>
       	      <td>Username</td>
       	      <td><input type="text" name="email"  id="ln_email" value="<?php echo $user->emailAddress; ?>" /></td>
   	        </tr>
       	    <tr>
       	      <td>Password</td>
       	      <td><input type="password" name="password" id="ln_password"  /> <div id="passwordStrength"></div></td>
   	        </tr>
       	    <!--<tr>
       	      <td>Verify Password</td>
       	      <td><input type="password" name="email3"  /></td>
   	        </tr>-->
       	    <tr>
       	      <td>&nbsp;</td>
       	      <td><input type="submit" name="button" id="button" value="Register" onclick="return linkedinSaveData();" /></td>
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
                    	<img src="<?php echo $user->pictureUrl; ?>" alt="" width="80" height="80" border="0" />
					</a>
				</div>
				<div class="listing-rgt">
					<ul><small style="float: right; text-align: right; color: blueviolet; font-size: 16px;">if you want to register with different account, click <a href="connect.php?action=changeAccount">here &rarr;</a></small>
						<li>
							<h1><?php echo $user->firstName." ".$user->lastName; ?></h1>
						</li>
						<li>Location: <span class="location"><?php echo $user->location->name; ?></span> </li>
						<li>Tag line: <?php echo $user->headline; ?></li>
						<li>Industry: <?php echo $user->industry; ?> </li>
					</ul>
				</div>
				<div class="clear"></div>
		</div>

		<div class="listing">
       	  <div class="heading"><h1>Summary</h1></div>
       	  <p><?php echo $user->summary;?></p>
       	</div>


	<?php
			if(isset($user->threeCurrentPositions) || isset($user->threePastPositions)){					


	?>
				  <div class="listing">
       	  <div class="heading"><h1>Work Experience</h1></div>
				<table width="100%" border='0'>
                <tr class="headingtd">
                  <td width="175" height="30" bgcolor="#333333"><span>Employer</span></td>
                  <td width="181" height="30" bgcolor="#333333"><span>Position</span></td>                  
                </tr>
	<?php
				$idx=0;
		
				foreach($user->threeCurrentPositions->values as $work){
				
					/*$startDate = $work->startDate->month." ".$work->startDate->year;
					if($work->isCurrent ==1){
						$endDate="Till Date";
					}else{
						$endDate = $work->endDate->month." ".$work->endDate->year;
					}*/
					if($idx%2 ==0){$bgcolor="#FBFBFB";}else{$bgcolor="#DFDFDF";}
					//echo '<tr><td bgcolor="'.$bgcolor.'">'.$work->company->name.'</td><td bgcolor="'.$bgcolor.'">'.$work->title.'</td><td bgcolor="'.$bgcolor.'">'.$startDate.'</td><td align="center" bgcolor="'.$bgcolor.'">'.$endDate.'</td></tr>';
					echo '<tr><td bgcolor="'.$bgcolor.'">'.$work->company->name.'</td><td bgcolor="'.$bgcolor.'">'.$work->title.'</td></tr>';
					$idx++;
				}

				foreach($user->threePastPositions->values as $work){
					/*$startDate = $work->startDate->month." ".$work->startDate->year;
					if($work->isCurrent ==1){
						$endDate="Till Date";
					}else{
						$endDate = $work->endDate->month." ".$work->endDate->year;
					}*/
					if($idx%2 ==0){$bgcolor="#FBFBFB";}else{$bgcolor="#DFDFDF";}
//					echo '<tr><td bgcolor="'.$bgcolor.'">'.$work->company->name.'</td><td bgcolor="'.$bgcolor.'">'.$work->title.'</td><td bgcolor="'.$bgcolor.'">'.$startDate.'</td><td align="center" bgcolor="'.$bgcolor.'">'.$endDate.'</td></tr>';
					echo '<tr><td bgcolor="'.$bgcolor.'">'.$work->company->name.'</td><td bgcolor="'.$bgcolor.'">'.$work->title.'</td></tr>';
					$idx++;
				}
				echo '</table><div class="clear"></div></div>';
			}


require_once("../commons/footer.inc.php");
exit;
 

function getAuthorizationCode() {
    $params = array('response_type' => 'code',
                    'client_id' => API_KEY,
                    'scope' => SCOPE,
                    'state' => uniqid('', true), // unique long string
                    'redirect_uri' => REDIRECT_URI,
              );
 
    // Authentication request
    $url = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);
     
    // Needed to identify request when it returns to us
    $_SESSION['state'] = $params['state'];
 
    // Redirect user to authenticate
    header("Location: $url");
    exit;
}
     
function getAccessToken() {
    $params = array('grant_type' => 'authorization_code',
                    'client_id' => API_KEY,
                    'client_secret' => API_SECRET,
                    'code' => $_GET['code'],
                    'redirect_uri' => REDIRECT_URI,
              );
     
 
    // Access Token request
//    $url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query($params);
	$url = urldecode('https://www.linkedin.com/uas/oauth2/accessToken?'.http_build_query($params));
      
	$ch = curl_init();

    curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $token = json_decode($response);

    // Store access token and expiration time
    $_SESSION['access_token'] = $token->access_token; // guard this! 
    $_SESSION['expires_in']   = $token->expires_in; // relative time (in seconds)
    $_SESSION['expires_at']   = time() + $_SESSION['expires_in']; // absolute time
     
    return true;
}
 
function fetch($method, $resource, $body = '') {
    $params = array('oauth2_access_token' => $_SESSION['access_token'],
                    'format' => 'json',
              );
     
   
 
 


$url = urldecode('https://api.linkedin.com' . $resource . '?' .http_build_query($params));
      
$ch = curl_init();

        curl_setopt($ch,CURLOPT_URL, $url);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
        $response = curl_exec($ch);

        curl_close($ch);

  //echo "<pre>";
//print_r($response);
 
    // Native PHP object, please
    return json_decode($response);
}
