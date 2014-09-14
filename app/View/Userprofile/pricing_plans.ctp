<div class="mid-txt">
<script type="text/javascript" language="javascript">
var plan_prices = {};
//alert(plan_prices);
</script>
	 <style> 	

		
	#pricing-table {
		margin: 20px auto 50px auto;
		text-align: center;
		width: 892px; /* total computed width = 222 x 3 + 226 */
	}

	#pricing-table .plan_features {
		font: 12px 'Lucida Sans', 'trebuchet MS', Arial, Helvetica;
		text-shadow: 0 1px rgba(255,255,255,.8);        
		background: #fff;      
		border: 1px solid #ddd;
		color: #333;
		padding: 20px;
		width: 275px; /* plan width = 180 + 20 + 20 + 1 + 1 = 222px */      
		float: left;
		position: relative;
	}

	#pricing-table .plan {
		font: 12px 'Lucida Sans', 'trebuchet MS', Arial, Helvetica;
		text-shadow: 0 1px rgba(255,255,255,.8);        
		background: #fff;      
		border: 1px solid #ddd;
		color: #333;
		padding: 20px;
		width: 100px; /* plan width = 180 + 20 + 20 + 1 + 1 = 222px */      
		float: left;
		position: relative;
	}
	
	#pricing-table #most-popular {
		z-index: 2;
		top: -13px;
		border-width: 3px;
		padding: 30px 20px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		border-radius: 5px;
		-moz-box-shadow: 20px 0 10px -10px rgba(0, 0, 0, .15), -20px 0 10px -10px rgba(0, 0, 0, .15);
		-webkit-box-shadow: 20px 0 10px -10px rgba(0, 0, 0, .15), -20px 0 10px -10px rgba(0, 0, 0, .15);
		box-shadow: 20px 0 10px -10px rgba(0, 0, 0, .15), -20px 0 10px -10px rgba(0, 0, 0, .15);    
	}

	#pricing-table .plan:nth-child(1) {
		-moz-border-radius: 5px 0 0 5px;
		-webkit-border-radius: 5px 0 0 5px;
		border-radius: 5px 0 0 5px;        
	}

	#pricing-table .plan:nth-child(4) {
		-moz-border-radius: 0 5px 5px 0;
		-webkit-border-radius: 0 5px 5px 0;
		border-radius: 0 5px 5px 0;        
	}
	
	/* --------------- */	

	#pricing-table h3 {
		font-size: 20px;
		font-weight: normal;
		padding: 20px;
		margin: -20px -20px 50px -20px;
		background-color: #eee;
		background-image: -moz-linear-gradient(#fff,#eee);
		background-image: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#eee));    
		background-image: -webkit-linear-gradient(#fff, #eee);
		background-image: -o-linear-gradient(#fff, #eee);
		background-image: -ms-linear-gradient(#fff, #eee);
		background-image: linear-gradient(#fff, #eee);
	}
	
	#pricing-table #most-popular h3 .heading {
		background-color: #ddd;
		background-image: -moz-linear-gradient(#eee,#ddd);
		background-image: -webkit-gradient(linear, left top, left bottom, from(#eee), to(#ddd));    
		background-image: -webkit-linear-gradient(#eee, #ddd);
		background-image: -o-linear-gradient(#eee, #ddd);
		background-image: -ms-linear-gradient(#eee, #ddd);
		background-image: linear-gradient(#eee, #ddd);
		margin-top: -30px;
		padding-top: 30px;
		-moz-border-radius: 5px 5px 0 0;
		-webkit-border-radius: 5px 5px 0 0;
		border-radius: 5px 5px 0 0; 		
	}

	
	#pricing-table .plan:nth-child(1) h3 {
		-moz-border-radius: 5px 0 0 0;
		-webkit-border-radius: 5px 0 0 0;
		border-radius: 5px 0 0 0;       
	}

	#pricing-table .plan:nth-child(4) h3 {
		-moz-border-radius: 0 5px 0 0;
		-webkit-border-radius: 0 5px 0 0;
		border-radius: 0 5px 0 0;       
	}	

	#pricing-table h3 span {
		display: block;
		font: bold 15px/100px Georgia, Serif;
		color: #777;
		background: #fff;
		border: 5px solid #fff;
		height: 100px;
		width: 100px;
		margin: 10px auto -65px;
		-moz-border-radius: 100px;
		-webkit-border-radius: 100px;
		border-radius: 100px;
		-moz-box-shadow: 0 5px 20px #ddd inset, 0 3px 0 #999 inset;
		-webkit-box-shadow: 0 5px 20px #ddd inset, 0 3px 0 #999 inset;
		box-shadow: 0 5px 20px #ddd inset, 0 3px 0 #999 inset;
	}
	
	/* --------------- */

	#pricing-table ul {
		margin: 20px -20px;
		padding: 0;
		list-style: none;
	}

	#pricing-table li {
		border-top: 1px solid #ddd;
		padding: 10px 0;
	}
	

	#pricing-table .plan_features li {
		border-top: 1px solid #ddd;
		padding: 10px 10px 10px 0px;
		text-align:right;
	} 
	
	/* --------------- */
		
	#pricing-table .signup {
		position: relative;
		padding: 8px 20px;
		margin: 20px 0 0 0;  
		color: #fff;
		font: bold 14px Arial, Helvetica;
		text-transform: uppercase;
		text-decoration: none;
		display: inline-block;       
		background-color: #72ce3f;
		background-image: -moz-linear-gradient(#72ce3f, #62bc30);
		background-image: -webkit-gradient(linear, left top, left bottom, from(#72ce3f), to(#62bc30));    
		background-image: -webkit-linear-gradient(#72ce3f, #62bc30);
		background-image: -o-linear-gradient(#72ce3f, #62bc30);
		background-image: -ms-linear-gradient(#72ce3f, #62bc30);
		background-image: linear-gradient(#72ce3f, #62bc30);
		-moz-border-radius: 3px;
		-webkit-border-radius: 3px;
		border-radius: 3px;     
		text-shadow: 0 1px 0 rgba(0,0,0,.3);        
		-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, .5), 0 2px 0 rgba(0, 0, 0, .7);
		-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, .5), 0 2px 0 rgba(0, 0, 0, .7);
		box-shadow: 0 1px 0 rgba(255, 255, 255, .5), 0 2px 0 rgba(0, 0, 0, .7);
	}

 .upgrades {
		position: relative;
		padding: 8px 20px;
		margin: 0px;  
		color: #fff;
		font: bold 12px Arial, Helvetica;
		
		text-decoration: none;
		display: inline-block;       
		background-color: #6B8E23;	
		-moz-border-radius: 3px;
		-webkit-border-radius: 3px;
		border-radius: 3px;     
		text-shadow: 0 1px 0 rgba(0,0,0,.3);        
		-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, .5), 0 2px 0 rgba(0, 0, 0, .7);
		-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, .5), 0 2px 0 rgba(0, 0, 0, .7);
		box-shadow: 0 1px 0 rgba(255, 255, 255, .5), 0 2px 0 rgba(0, 0, 0, .7);
	}

#



	#pricing-table .signup:hover {
		background-color: #62bc30;
		background-image: -moz-linear-gradient(#62bc30, #72ce3f);
		background-image: -webkit-gradient(linear, left top, left bottom, from(#62bc30), to(#72ce3f));      
		background-image: -webkit-linear-gradient(#62bc30, #72ce3f);
		background-image: -o-linear-gradient(#62bc30, #72ce3f);
		background-image: -ms-linear-gradient(#62bc30, #72ce3f);
		background-image: linear-gradient(#62bc30, #72ce3f); 
	}

	#pricing-table .signup:active, #pricing-table .signup:focus {
		background: #62bc30;       
		top: 2px;
		-moz-box-shadow: 0 0 3px rgba(0, 0, 0, .7) inset;
		-webkit-box-shadow: 0 0 3px rgba(0, 0, 0, .7) inset;
		box-shadow: 0 0 3px rgba(0, 0, 0, .7) inset; 
	}
	
	/* --------------- */

	.clear:before, .clear:after {
	  content:"";
	  display:table
	}

	.clear:after {
	  clear:both
	}

	.clear	{
	  zoom:1
	}



/** custom login button **/
.flatbtn-blu { 
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  display: inline-block;
  outline: 0;
  border: 0;
  color: #edf4f9;
  text-decoration: none;
  background-color: #4f94cf;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  font-size: 1.3em;
  font-weight: bold;
  padding: 12px 26px 12px 26px;
  line-height: normal;
  text-align: center;
  vertical-align: middle;
  cursor: pointer;
  text-transform: uppercase;
  text-shadow: 0 1px 0 rgba(0,0,0,0.3);
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
}
.flatbtn-blu:hover {
  color: #fff;
  background-color: #519dde;
}
.flatbtn-blu:active {
  -webkit-box-shadow: inset 0 1px 5px rgba(0, 0, 0, 0.1);
  -moz-box-shadow:inset 0 1px 5px rgba(0, 0, 0, 0.1);
  box-shadow:inset 0 1px 5px rgba(0, 0, 0, 0.1);
}


/** modal window styles **/
#lean_overlay {
    position: fixed;
    z-index:100;
    top: 0px;
    left: 0px;
    height:100%;
    width:100%;
    background: #000;
    display: none;
}


#loginmodal {
  width: 300px;
  padding: 20px;
  background: #f3f6fa;
  -webkit-border-radius: 6px;
  -moz-border-radius: 6px;
  border-radius: 6px;
  -webkit-box-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
  -moz-box-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
  box-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
}

.loginform { margin-top:20px; }

.loginform label { display: block; font-size: 1.1em; font-weight: bold; color: #7c8291; margin-bottom: 3px; }


.txtfield { 
  display: block;
  width: 100%;
  padding: 6px 5px;
  margin-bottom: 15px;
  font-family: 'Helvetica Neue', Helvetica, Verdana, sans-serif;
  color: #7988a3;
  font-size: 1.4em;
  text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.8);
  background-color: #fff;
  background-image: -webkit-gradient(linear, left top, left bottom, from(#edf3f9), to(#fff));
  background-image: -webkit-linear-gradient(top, #edf3f9, #fff);
  background-image: -moz-linear-gradient(top, #edf3f9, #fff);
  background-image: -ms-linear-gradient(top, #edf3f9, #fff);
  background-image: -o-linear-gradient(top, #edf3f9, #fff);
  background-image: linear-gradient(top, #edf3f9, #fff);
  border: 1px solid;
  border-color: #abbce8 #c3cae0 #b9c8ef;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.25), 0 1px rgba(255, 255, 255, 0.4);
  -moz-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.25), 0 1px rgba(255, 255, 255, 0.4);
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.25), 0 1px rgba(255, 255, 255, 0.4);
  -webkit-transition: all 0.25s linear;
  -moz-transition: all 0.25s linear;
  transition: all 0.25s linear;
}

.txtfield:focus {
  outline: none;
  color: #525864;
  border-color: #84c0ee;
  -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15), 0 0 7px #96c7ec;
  -moz-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15), 0 0 7px #96c7ec;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15), 0 0 7px #96c7ec;
}

.heading_popup{
   box-shadow: 1px 1px 5px 5px #085C64 inset;
    font-size: 20px;
    font-style: normal;
    font-weight: normal;
    padding: 10px;
	width: 100%;
}

	
    </style>

<h3 style="padding:10px;background:#FFF; font-size: 25px;font-weight: 800; text-decoration: none;">


<?php

	if($type == "recruiters"){
		echo 'Reach top talent on NetworkWe<a class="upgrades" href="/users/pricing_plans/jobseekers/" style="float:right;">Check Plans For Jobseekers &rarr;</a>';
	}else{
		echo 'Accelerate your career<a class="upgrades" href="/users/pricing_plans/recruiters/" style="float:right;">Check Plans For Recruiters &rarr;</a>';
	}
?>
</h3>
<div style="clear:both;"></div>
<div id="pricing-table" class="clear">
<div class="plan_features">
        <h3>Features<span id="current_plan">Monthly</span></h3>
          <a class="signup"  href="javascript:void(0);" onclick="changePrices();" id="plan_swither_top">Change To Yearly Pricing</a>       
		<div style=" margin-top: -59px;position:absolute;background:#FFF;color:#6B8E23;">Save up to 25% per year on Annual plans</div>
        <ul>
		<?php
		  foreach ($features as $feature):
            echo '<li><b>'.$feature['plans_features_masters']['title'].' &rarr;</b></li>';
			endforeach; 
		?>           		
        </ul> 
		<a class="signup" href="javascript:void(0);"  onclick="changePrices();" id="plan_swither_bottom">Change To Yearly Pricing</a>
    </div >

    <div class="plan">
        <h3>Free<span id="plan_1">$0</span></h3>
          <a class="signup" href="#loginmodal" id="plan_1_top" onclick="javascript:current_plan=0;">Sign up</a>       
        <ul>
            <li>Limited</li>

				<?php 
				$totcount= count($features);
				for($k=1;$k<$totcount;$k++){
		            echo '<li>&nbsp;</li>';
				}
			?>
        </ul> 
		<a class="signup" href="#loginmodal" id="plan_1_bottom" onclick="javascript:current_plan=0;">Sign up</a> 
    </div >

		<?php			
			$plan_id = "-1";
			$plan_idx=2;
		   foreach ($plans as $plan):
					if($plan_id != $plan['plans']['id']){
						if($plan_id != "-1"){	
						echo '</ul>'.
							 '<a class="signup" href="#loginmodal" id="plan_'.$plan_idx.'_bottom" onclick="javascript:current_plan='.$plan_id.';">Sign up</a>'.
					 		 '</div>';
							$plan_idx++;
						}
						if($plan['plans']['most-popular'] ==1){
							echo '<div class="plan" id="most-popular">';
						}else{
							echo '<div class="plan" >';
						} 

						$value = $plan['plans_features']['value'];	
						if(empty($value)){
							$value= "&nbsp;";
						}
						$plan_id = $plan['plans']['id'];
						$yearly_price = (12 * $plan['plans']['price']) - (12 * $plan['plans']['price'] * $plan['plans']['yearly_discount_percentage']) /100;
							echo '<script type="text/javascript">'.
								 'plan_prices["'.$plan_idx.'"] = {m:"'.$plan['plans']['price'].'", y:"'.$yearly_price.'"}; '.
							// 'plan_prices["'.$plan_idx.'"]["price"]="'.$plan['plans']['price'].'";'.
							// 'plan_prices["'.$plan_idx.'"]["yearly_discount_percentage"]="'.$plan['plans']['yearly_discount_percentage'].'";'.
							 '</script>';
					     echo '<h3>'.$plan['plans']['title'].'<span id="plan_'.$plan_idx.'">$'.$plan['plans']['price'].'</span></h3>'.
						 '<a class="signup" href="#loginmodal" id="plan_'.$plan_idx.'_top" onclick="javascript:current_plan='.$plan_id.';">Sign up</a>'.            
        				 '<ul>'.
						 '<li>'.$value.'</li>';
					
					}else{ 
						$value = $plan['plans_features']['value'];	
						if(empty($value)){
							$value= "&nbsp;";
						}
						echo  '<li>'.$value.'</li>';
					}
			
			endforeach; 
			echo '</ul>'.
					 '<a class="signup" href="#loginmodal" id="plan_'.$plan_id.'_bottom" onclick="javascript:current_plan='.$plan_id.';">Sign up</a>'.
					 '</div>';
		?>    

    
</div>	   

</div>

<div id="loginmodal" style="display:none;">
	<div id="login_screen">
  		<h1 class="heading_popup">User Login</h1>
 			<form class="loginform" id="loginform" name="loginform" method="post" action="#">	
			    <label for="login_username">Username:</label>
			    <input type="text" name="login_username" id="login_username" class="txtfield" tabindex="1">
     		    <label for="login_password">Password:</label>
			    <input type="password" name="login_password" id="login_password" class="txtfield" tabindex="2">     
			    <div class="center"><input type="submit" name="loginbtn" id="loginbtn" class="flatbtn-blu hidemodal" value="Log In" tabindex="3">
				<br/><br/>
				<a style="color: #4F94CF;font-size: 1em;font-weight: bold;line-height: normal; outline: 0 none; text-decoration: none;" href="javascript:void(0);" onclick="changeScreen();">Create an account</a></div>
  			</form>
	</div>
	<div id="register_screen" style="display:none;">
  		<h1 class="heading_popup">Sign up with Email</h1>
 			<form id="registerform" class="loginform" name="registerform" method="post" action="#">	
			    <label for="register_username">Username(Email ID):</label>
			    <input type="text" name="register_username" id="register_username" class="txtfield" tabindex="1">
     		    <label for="register_password">Password:</label>
			    <input type="password" name="register_password" id="register_password" class="txtfield" tabindex="2"> 
				<label for="register_confirm_password">Confirm Password:</label>
			    <input type="password" name="register_confirm_password" id="register_confirm_password" class="txtfield" tabindex="3">    
			    <div class="center"><input type="submit" name="registerbtn" id="register" class="flatbtn-blu" value="Register" tabindex="4">
				<br/><br/>
				<a style="color: #4F94CF;font-size: 1em;font-weight: bold;line-height: normal; outline: 0 none; text-decoration: none;" href="javascript:void(0);" onclick="changeScreen();">Already have an account?</a> </div>
  			</form>
	</div>
</div>

 <script type="text/javascript" charset="utf-8" src="/js/jquery.leanModal.min.js"></script>

<script type="text/javascript">
	API_PATH = "http://stage.networkwe.com/";
	current_plan = 1;
	type = "<?php echo $type;?>";

$(function(){
  $('#loginform').submit(function(e){
	username = $("#login_username").val();
	password = $("#login_password").val();

	if((username == "") || (username == " ")){
		alert("please enter username");
		return false;
	}

	if((password == "") || (password == " ")){
		alert("please enter password");
		return false;
	}


	


	var loginData = {'User':{"email" : username,"password" : password}};

	$.ajax({
				type: "POST", 
				data: loginData,
  				url: API_PATH + "users/ajax_login/",
  				dataType: "json",
				success: function(result){
					if(result==1){
						alert(current_plan);
					}else{
						alert("Invalid username/password. please try again!");
					}			
  				}
			});
    return false;
  });

 $('#registerform').submit(function(e){
	username = $("#register_username").val();
	password = $("#register_password").val();

	if((username == "") || (username == " ")){
		alert("please enter username");
		return false;
	}

	if((password == "") || (password == " ")){
		alert("please enter password");
		return false;
	}


	if(password != $("#register_confirm_password").val()){
		alert("Your passwords do not match. Please try again.");
		return false;
	}
 
	var registerData = {'User':{"email" : username,"password" : password,"role_id":3}};
	$.ajax({
				type: "POST", 
				data: registerData,
  				url: API_PATH + "users/ajax_register/",
  				dataType: "json",
				success: function(result){
					if(result>1){
						document.location = "/users/pricing_registered/"+current_plan+"_"+result+"_"+currentPriceMode;
					}else{
						alert("Unable to register new user account. please try again!");
					}			
  				}
			});	

    return false;

  });



changeScreen =function() {
	$("#login_screen").slideToggle("fast");		
	$("#register_screen").slideToggle("fast");
}	
  
$('#plan_1_top').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
$('#plan_1_bottom').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
$('#plan_2_top').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
$('#plan_2_bottom').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
$('#plan_3_top').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
$('#plan_3_bottom').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
$('#plan_4_top').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
$('#plan_4_bottom').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });

  
});
</script>
<script type="text/javascript" language="javascript">
var currentPriceMode = "m";
function changePrices(){
		if(currentPriceMode == "m"){
			document.getElementById("plan_swither_top").innerHTML="Change To Monthly Pricing";
			document.getElementById("plan_swither_bottom").innerHTML="Change To Monthly Pricing";
			document.getElementById("current_plan").innerHTML="Yearly";			
			for(key in plan_prices) {
				if(document.getElementById("plan_"+key)){
						document.getElementById("plan_"+key).innerHTML="$"+plan_prices[key].y;
				}			
			}


			currentPriceMode = "y";

		}else{
			document.getElementById("plan_swither_top").innerHTML="Change To Yearly Pricing";
			document.getElementById("plan_swither_bottom").innerHTML="Change To Yearly Pricing";
			document.getElementById("current_plan").innerHTML="Monthly";
		
			for(key in plan_prices) {
				if(document.getElementById("plan_"+key)){
						document.getElementById("plan_"+key).innerHTML="$"+plan_prices[key].m;
				}			
			}
			currentPriceMode = "m";
		}
}


</script>