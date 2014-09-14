<div class="mid-txt">
	 <style> 
	body {
		background: #2e3237
	}
	
	#about {
		text-align: center;
		color: #fafafa;
		font: normal small Arial, Helvetica;
	}
	
	#about a {
		color: #777;
	}
	
	/* --------------- */
		
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
    </style>

<h3 style="padding:10px;background:#FFF; font-size: 25px;font-weight: 800; text-decoration: underline;">

Accelerate your career
<a class="upgrades" href="/users/pricing_plans_recruiters/" style="float:right;">Check Plans For Recruiters &rarr;</a>
</h3>
<div style="clear:both;"></div>
<div id="pricing-table" class="clear"> 
<div class="plan_features">
        <h3>Features<span id="current_plan">Monthly</span></h3>
          <a class="signup"  href="javascript:void(0);" onclick="changePrices();" id="plan_swither_top">Change To Yearly Pricing</a>       
		<div style=" margin-top: -59px;position:absolute;background:#FFF;color:#6B8E23;">Save up to 25% per year on Annual plans</div>
        <ul>
            <li><b>Who's Viewed Your Profile</b></li>
            <li><b>Full Network Visibility</b></li>
            <li><b>InMail Messages</b></li>
			<li><b>Premium Search</b></li>	
			<li><b>Featured Applicant</b></li>	
<li><b>Chat Conversions with recuruiter's </b></li>	
<li><b>Get Top Jobs</b></li>	
<li><b>Premium Badge</b></li>	
<li><b>Salary Data</b></li>	
<li><b>Career Planning</b></li>	
<li><b>Resume Writing</b></li>	
<li><b>professional cover letters</b></li>		
        </ul> 
		<a class="signup" href="javascript:void(0);"  onclick="changePrices();" id="plan_swither_bottom">Change To Yearly Pricing</a>
    </div >

    <div class="plan">
        <h3>Free<span id="plan_1">$0</span></h3>
          <a class="signup" href="">Sign up</a>       
        <ul>
            <li>Limited</li>
            <li>&nbsp;</li>
           <li>&nbsp;</li>
<li>&nbsp;</li>
<li>&nbsp;</li>
<li>&nbsp;</li>
<li>&nbsp;</li>
<li>&nbsp;</li>
<li>&nbsp;</li>
<li>&nbsp;</li>
<li>&nbsp;</li>
<li>&nbsp;</li>

        </ul> 
		<a class="signup" href="">Sign up</a> 
    </div >
    <div class="plan" >
        <h3>Basic<span id="plan_2">$17</span></h3>
        <a class="signup" href="">Sign up</a>        
        <ul>
            <li>Yes</li>
            <li>&nbsp;</li>
           	<li>10 per month</li>
			<li>3rd</li>
			<li>Yes</li>
			<li>5 per month</li>
			<li>5 per month</li>
			<li>Yes</li>
			<li>Yes</li>
			<li>Yes</li>
			<li>Yes</li>
			<li>5 per month</li>			
        </ul>
 <a class="signup" href="">Sign up</a>    
    </div>
    <div class="plan" id="most-popular">
        <h3>Plus<span id="plan_3">$29</span></h3>
		<a class="signup" href="">Sign up</a>
        <ul>
            <li>Yes</li>
            <li>Yes</li>
           	<li>25 per month</li>
			<li>2nd</li>
			<li>Yes</li>
			<li>10 per month</li>
			<li>15 per month</li>
			<li>Yes</li>
			<li>Yes</li>
			<li>Yes</li>
			<li>Yes</li>
			<li>15 per month</li>			
        </ul>
 <a class="signup" href="">Sign up</a>
    </div>
    <div class="plan">
        <h3>Elite<span id="plan_4">$59</span></h3>
        <a class="signup" href="">Sign up</a>		
        <ul>
            <li>Yes</li>
            <li>Yes</li>
           	<li>50 per month</li>
			<li>1st</li>
			<li>Yes</li>
			<li>20 per month</li>
			<li>25 per month</li>
			<li>Yes</li>
			<li>Yes</li>
			<li>Yes</li>
			<li>Yes</li>
			<li>25 per month</li>			
        </ul>
 <a class="signup" href="">Sign up</a>
    </div> 	
</div>	   

</div>

<script type="text/javascript" language="javascript">
var currentPriceMode = "m";
function changePrices(){
		if(currentPriceMode == "m"){
			document.getElementById("plan_swither_top").innerHTML="Change To Monthly Pricing";
			document.getElementById("plan_swither_bottom").innerHTML="Change To Monthly Pricing";
			document.getElementById("current_plan").innerHTML="Yearly";
			document.getElementById("plan_2").innerHTML="$173.40";
			document.getElementById("plan_3").innerHTML="$278.40";
			document.getElementById("plan_4").innerHTML="$531";
			currentPriceMode = "y";

		}else{
			document.getElementById("plan_swither_top").innerHTML="Change To Yearly Pricing";
			document.getElementById("plan_swither_bottom").innerHTML="Change To Yearly Pricing";
			document.getElementById("current_plan").innerHTML="Monthly";
			document.getElementById("plan_2").innerHTML="$17";
			document.getElementById("plan_3").innerHTML="$29";
			document.getElementById("plan_4").innerHTML="$59";
			currentPriceMode = "m";
		}
}


</script>