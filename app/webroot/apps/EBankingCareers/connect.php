<?php


ob_start();
require_once("../commons/header.inc.php");

if(isset($_POST["chk_om"])){
$username =$_POST["gulfbankers_email"];
$pass= $_POST["gulfbankers_password"];
$rowData = fetch($username,$pass);
$userData = json_decode($rowData);

if($userData->code ==1){
	$fullname = $userData->name;
	
	$arrName = split(" ",$fullname); 
	
	$count = count($arrName);
	$firstName = $arrName[0] ;
	$lastName="";
	if($count>1){
			for($i=1;$i<$count;$i++){
				$lastName .=$arrName[$i]." "; 
			}
	}
	
	
	
	$gender = $userData->gender ;
	$birthday = $userData->birthday;
	$summary = $userData->summary;
	$phone = $userData->phone;
	$mobile = $userData->mobile;
	//$industry = $userData->industry;
	$country = $userData->country;
	$nationality = $userData->nationality;
	$tags = $userData->tags;
	$city = $userData->city;
	$college = $userData->college;
	$degree = $userData->degree;
	$speciliz = $userData->speciliz;
	$year = $userData->year;
	$company = $userData->company;
	$title = $userData->title;	
	$key_skill = $userData->key_skill;
	$industry = $userData->industry;
	$photo = $userData->photo;
	
							
	$emailAddress = $username;
	
?>

<script>
	
	 
	var oneManagerJSON =new Object();
   
	oneManagerJSON.first_name = "<?php echo $firstName;?>";	
	oneManagerJSON.last_name = "<?php echo $lastName;?>";
	
	oneManagerJSON.gender = '<?php echo $gender;?>';
	oneManagerJSON.birthday = '<?php echo $birthday;?>'; 
	oneManagerJSON.phone = '<?php echo $phone;?>'; 
	oneManagerJSON.mobile = '<?php echo $mobile;?>'; 
	
	oneManagerJSON.country = '<?php echo $country;?>'; 
	oneManagerJSON.nationality = '<?php echo $nationality;?>'; 
	oneManagerJSON.city = '<?php echo $city;?>'; 
	oneManagerJSON.tags = '<?php echo $tags;?>'; 
	//oneManagerJSON.key_skill = '<?php echo $key_skill;?>'; 
	oneManagerJSON.industry = '<?php echo $industry;?>'; 
	oneManagerJSON.profile_photo = '<?php echo $photo;?>'; 
	oneManagerJSON.company = '<?php echo $company;?>'; 
	oneManagerJSON.title = '<?php echo $title;?>'; 
	oneManagerJSON.college = '<?php echo $college;?>'; 
	oneManagerJSON.degree = '<?php echo $degree;?>'; 
	oneManagerJSON.speciliz = '<?php echo $speciliz;?>'; 
	oneManagerJSON.year = '<?php echo $year;?>'; 
	
	
	
	jQuery(document).ready(function() {		
		gulfbankersSaveData = function(){
			email_address = $("#om_email").val();
			password = $("#om_password").val();
			
			
			var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (!filter.test(email_address)) {
				alert('Please provide a valid email address');
				$("#om_email").focus;
				return false;
			}
			
			if(password.length < 6 ){
				alert('Please provide a valid password. Must be atleast six characters.');
				$("#om_password").focus;
				return false;
				
			}
			
			oneManagerJSON.email_address = email_address;
			oneManagerJSON.password = password;
			
			
			oneManagerJSON.social ="ebankingcareers";
		

			$.ajax({
					type: "POST",
					url: "http://www.networkwe.com/users/register_social",
					data: oneManagerJSON,
					success: om_db_reply,
					dataType: "JSON"	
				});

			
			return false;

		}

		om_db_reply = function (data){
			if(data == 1 ){				
				$("#linkedin_details").hide();
				$("#linkedin_thankyou").show();

			}else if(data == -1 ){
				alert("The email address you entered is already being used for another NetworkWe Account.")
			}else{
				alert("Unable to register. Please try again.")
			}
		}


	$("#om_password").passwordStrength({
               targetDiv:'passwordStrength',
                showTime: false,
				text:{}
        });

    });




</script>
    
<div class="wrapper">
	<div class="maincontent" style="min-height: 600px;">
		<div class="boxheading">
			<h1>Register Using eBankingCareers Account <small style="float: right; color: gray; font-size: 9px;">You may exercise your right to access, modify or delete your personal information at any time on Networkwe.</small></h1>
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
		
		<div class="margintop20" id="linkedin_details">
        <div class="lftloginbox tabledata-style">
        <div class="listing">
       	  <div class="heading">
       	    <h1>Thanks <?php echo $firstName; ?>.</h1>
					<small style="float: right; color: gray; font-size: 12px;">Just a few more details..</small></div>					
<div style="clear:both;"></div>
<hr/>       	
We successfully capture your information from eBankingCareers. please provide valid username and password in order to create your NetworkWE account

<div style="margin-top:10px;box-shadow: 1px 1px 10px 1px; padding: 10px;"><h3>Create Your NetworkWe Account</h3>

       	    <table width="100%">
       	    <tr>
       	      <td>Username</td>
       	      <td><input type="text" name="email"  id="om_email" value="<?php echo $emailAddress; ?>" /></td>
   	        </tr>
       	    <tr>
       	      <td>Password</td>
       	      <td><input type="password" name="password" id="om_password"  /> <div id="passwordStrength"></div></td>
   	        </tr>
       	    <!--<tr>
       	      <td>Verify Password</td>
       	      <td><input type="password" name="email3"  /></td>
   	        </tr>-->
       	    <tr>
       	      <td>&nbsp;</td>
       	      <td><input type="submit" name="button" id="button" value="Register" onclick="return gulfbankersSaveData();" /></td>
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
                    	<img src="<?php echo $photo; ?>" alt="" width="80" height="80" border="0" />
					</a>
				</div>
				<div class="listing-rgt">
					<ul><small style="float: right; text-align: right; color: blueviolet; font-size: 16px;">if you want to register with different account, click <a href="connect.php?action=changeAccount">here &rarr;</a></small>
						<li>
							<h1><?php echo $firstName." ".$lastName; ?></h1>
						</li>
						<li>
							<h1><?php echo $tags; ?></h1>
						</li>
						
						<li>
							<h3>Gender : <?php echo $gender; ?></h3>
						</li>	
						<li>
							<h3>Birthday :<?php echo $birthday; ?></h3>
						</li>	
						<li>
							<h3>Phone :<?php echo $phone; ?></h3>
						</li>						
						<li>
							<h3>Mobile :<?php echo $mobile; ?></h3>
						</li>	
						
						<li>
							<h3>City :<?php echo $city; ?></h3>
						</li>	
						
						<li>
							<h3>Country :<?php echo $country; ?></h3>
						</li>	
						
						<li>
							<h3>Nationality :<?php echo $nationality; ?></h3>
						</li>	
						<!--
						<li>
							<h3>Key Skill :<?php echo $key_skill; ?></h3>
						</li>	
						-->
						<li>
							<h3>Industry :<?php echo $industry; ?></h3>
						</li>	
	
	
	
	
	
						
								
					</ul>
				</div>
				<div class="clear"></div>
		</div>
		
		
		<div class="listing">
		       	  <div class="heading">
		       	    <h1 style="padding:10px;" class="headingtd">Education</h1></div>
					<ul>  	
						<li>
							<h3>Institute :<?php echo $college; ?></h3>
						</li>		
						<li>
							<h3>Qualification  :<?php echo $degree; ?></h3>
						</li>
						<li>
							<h3>Specialization :<?php echo $speciliz; ?></h3>
						</li>
						<li>
							<h3>Completion Date :<?php echo $year; ?></h3>
						</li>			
					</ul>     
				
		</div>
		<div class="clear"></div>
		<div class="listing">
		       	  <div class="heading">
		       	    <h1 style="padding:10px;" class="headingtd">Experience</h1></div>
					<ul>  	
						<li>
							<h3>Company :<?php echo $company; ?></h3>
						</li>		
						<li>
							<h3>Job Title :<?php echo $title; ?></h3>
						</li>
								
					</ul>  		                  
				
				
		</div>		
       	<div class="clear"></div>
	
       	<?php
			
			
			
}else if($userData->code == 0){
	?>
	
	<script>
	jQuery(document).ready(function() {
		
    
		gulfbankersFetchData = function(){
			
			email_address = $("#gulfbankers_email").val();
			password = $("#gulfbankers_password").val();
			
			
			var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (!filter.test(email_address)) {
				alert('Please provide a valid email address');
				$("#gulfbankers_email").focus;
				return false;
			}
			
			if(password.length < 6 ){
				alert('Please provide a valid password. Must be atleast six characters.');
				$("#gulfbankers_password").focus;
				return false;
				
			}
			return true;
		}
	});
</script>
<form method="post" name="om_chk" id="om_chk" action="connect.php" onsubmit="return gulfbankersFetchData();">
	<div class="wrapper">
	<div class="maincontent" style="min-height: 600px;">
		<div class="boxheading">
			<h1>Register Using eBankingCareers Account <small style="float: right; color: gray; font-size: 9px;">You may exercise your right to access, modify or delete your personal information at any time on Networkwe.</small></h1>
			<div class="boxheading-arrow"></div>
		</div>
		
		
		<div class="margintop20" id="linkedin_details">
        <div class="lftloginbox tabledata-style">
        <div class="listing">
       	  <div class="heading">
			  <h1>Invalid username or password, please try again</h1>
			<div style="margin-top:10px;box-shadow: 1px 1px 10px 1px; padding: 10px;"><h3>Enter Your eBankingCareers Account</h3></div>
       	    <table width="100%">
       	    <tr>
       	      <td>Username</td>
       	      <td><input type="text" name="gulfbankers_email"  id="gulfbankers_email" value="" /></td>
   	        </tr>
       	    <tr>
       	      <td>Password</td>
       	      <td><input type="password" name="gulfbankers_password" id="gulfbankers_password"  /></td>
   	        </tr>
       	    <!--<tr>
       	      <td>Verify Password</td>
       	      <td><input type="password" name="email3"  /></td>
   	        </tr>-->
       	    <tr>
       	      <td>&nbsp;</td>
       	      <td><input type="submit" name="chk_om" id="chk_om" value="Fetch My Information"  /></td>
   	        </tr>
       	    
   	      </table>
   	      </div>
       	  <div class="clear"></div>
		</div>
        </div>
        </div>
        </div>
        </form>
<?php
}else{
		
?>
	
	<script>
	jQuery(document).ready(function() {
		
    
		gulfbankersFetchData = function(){
			
			email_address = $("#gulfbankers_email").val();
			password = $("#gulfbankers_password").val();
			
			
			var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (!filter.test(email_address)) {
				alert('Please provide a valid email address');
				$("#gulfbankers_email").focus;
				return false;
			}
			
			if(password.length < 6 ){
				alert('Please provide a valid password. Must be atleast six characters.');
				$("#gulfbankers_password").focus;
				return false;
				
			}
			return true;
		}
	});
</script>
<form method="post" name="om_chk" id="om_chk" action="connect.php" onsubmit="return gulfbankersFetchData();">
	<div class="wrapper">
	<div class="maincontent" style="min-height: 600px;">
		<div class="boxheading">
			<h1>Register Using eBankingCareers Account <small style="float: right; color: gray; font-size: 9px;">You may exercise your right to access, modify or delete your personal information at any time on Networkwe.</small></h1>
			<div class="boxheading-arrow"></div>
		</div>
		
		
		<div class="margintop20" id="linkedin_details">
        <div class="lftloginbox tabledata-style">
        <div class="listing">
       	  <div class="heading">
			  <h1>An error occurred with eBankingCareers API, please try again</h1>
			<div style="margin-top:10px;box-shadow: 1px 1px 10px 1px; padding: 10px;"><h3>Enter Your eBankingCareers Account</h3></div>
       	    <table width="100%">
       	    <tr>
       	      <td>Username</td>
       	      <td><input type="text" name="gulfbankers_email"  id="gulfbankers_email" value="" /></td>
   	        </tr>
       	    <tr>
       	      <td>Password</td>
       	      <td><input type="password" name="gulfbankers_password" id="gulfbankers_password"  /></td>
   	        </tr>
       	    <!--<tr>
       	      <td>Verify Password</td>
       	      <td><input type="password" name="email3"  /></td>
   	        </tr>-->
       	    <tr>
       	      <td>&nbsp;</td>
       	      <td><input type="submit" name="chk_om" id="chk_om" value="Fetch My Information"  /></td>
   	        </tr>
       	    
   	      </table>
   	      </div>
       	  <div class="clear"></div>
		</div>
        </div>
        </div>
        </div>
        </form>
<?php	
}
}else{
	?>
	<script>
	jQuery(document).ready(function() {
		
    
		gulfbankersFetchData = function(){
			
			email_address = $("#gulfbankers_email").val();
			password = $("#gulfbankers_password").val();
			
			
			var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (!filter.test(email_address)) {
				alert('Please provide a valid email address');
				$("#gulfbankers_email").focus;
				return false;
			}
			
			if(password.length < 6 ){
				alert('Please provide a valid password. Must be atleast six characters.');
				$("#gulfbankers_password").focus;
				return false;
				
			}
			return true;
		}
	});
</script>
<form method="post" name="om_chk" id="om_chk" action="connect.php" onsubmit="return gulfbankersFetchData();">
	<div class="wrapper">
	<div class="maincontent" style="min-height: 600px;">
		<div class="boxheading">
			<h1>Register Using eBankingCareers Account <small style="float: right; color: gray; font-size: 9px;">You may exercise your right to access, modify or delete your personal information at any time on Networkwe.</small></h1>
			<div class="boxheading-arrow"></div>
		</div>
		
		
		<div class="margintop20" id="linkedin_details">
        <div class="lftloginbox tabledata-style">
        <div class="listing">
       	  <div class="heading">
			<div style="margin-top:10px;box-shadow: 1px 1px 10px 1px; padding: 10px;"><h3>Enter Your eBankingCareers Account</h3></div>
       	    <table width="100%">
       	    <tr>
       	      <td>Username</td>
       	      <td><input type="text" name="gulfbankers_email"  id="gulfbankers_email" value="" /></td>
   	        </tr>
       	    <tr>
       	      <td>Password</td>
       	      <td><input type="password" name="gulfbankers_password" id="gulfbankers_password"  /></td>
   	        </tr>
       	    <!--<tr>
       	      <td>Verify Password</td>
       	      <td><input type="password" name="email3"  /></td>
   	        </tr>-->
       	    <tr>
       	      <td>&nbsp;</td>
       	      <td><input type="submit" name="chk_om" id="chk_om" value="Fetch My Information"  /></td>
   	        </tr>
       	    
   	      </table>
   	      </div>
       	  <div class="clear"></div>
		</div>
        </div>
        </div>
        </div>
        </form>
<?php
	
}

require_once("../commons/footer.inc.php");
exit;
 

 
function fetch($username, $password) {
    $params = array('username' => urlencode($username),
                    'password' => urlencode(md5($password)),
              );
     
$url = urldecode('http://www.ebankingcareers.com/forNWE/getProfile.php?' .http_build_query($params));
      
$ch = curl_init();

        curl_setopt($ch,CURLOPT_URL, $url);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
        $response = curl_exec($ch);

        curl_close($ch);

 
    // Native PHP object, please
    return json_decode($response);
}
