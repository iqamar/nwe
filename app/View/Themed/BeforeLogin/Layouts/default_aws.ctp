<?php
ob_start();
if ($this->Session->read(@$userid)) {
    $userarray = $this->Session->read(@$userid);
}
?>
<?php echo $this->Html->docType('html5'); ?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="verify-NWW" content="" />
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <meta name="keywords" content="Professional Networking Sites, Young Professionals Network, Professional Social Network, Social Networking For Business, Business Networking Sites, Business Networking Tips, Small Business Network, Networking Events, Professional Networking Groups, Professional Networking Online, Networking Tips" />
        <meta name="description" content="Deal with professionals in single platform.  Assemble your own professional network. Share knowledge and opportunities with others" />
        <meta name="ROBOTS" content="INDEX,FOLLOW" />
        <meta name="copyright" content="networkwe" />
        <meta name="content-language" content="EN" />
        <meta name="author" content="Team Networkwe" />
        <meta name="resource-type" content="document" />
        <meta name="distribution" content="GLOBAL" />
        <meta name="robots" content="ALL" />
        <meta name="revisit-after" content="1 day" />
        <meta name="rating" content="general" />
        <meta name="pragma" content="no-cache" />
        <meta name="classification" content=" A Global and Unique Network Portal for Professional, Recruiters and Agencies" />
        <title>Leading Professionals Network of the World | NETWORKWE</title>
		<script type="text/javascript">

            var baseUrl = '<?= $this->request->base ?>';

            var root = '<?= $this->request->webroot ?>';

            var media = '<?= MEDIA_URL ?>';
            var NETWORKWE_URL = '<?= NETWORKWE_URL ?>';

        </script>
        <!-- html5.js for IE less than 9 -->
        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- css3-mediaqueries.js for IE less than 9 -->
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <![endif]-->
        <?php
		echo $this->fetch('meta');
       
        echo $this->Html->css(array(MEDIA_URL . '/css/networkwe-all-style-1.1.1.css'));
		 echo $this->Html->css(array(MEDIA_URL.'/css/beforelogin/home.css', MEDIA_URL.'/css/popup-style.css'));
		echo $this->fetch('css');
		 echo $this->Html->script(array(  MEDIA_URL . '/js/jquery-1.10.2.min.js',
									MEDIA_URL . '/js/respond.min.js',
									MEDIA_URL . '/js/selectdd.js',

									   MEDIA_URL . '/js/carousels.js',

									   MEDIA_URL . '/js/easyResponsiveTabs.js',

									   MEDIA_URL . '/js/jquery.form.js',
									   
									   MEDIA_URL . '/js/selectlist_style.js',

									   MEDIA_URL . '/js/popup.js',

									   MEDIA_URL . '/js/article-slider/jquery-easing-1.3.pack.js',

									   MEDIA_URL . '/js/article-slider/jquery-easing-compatibility.1.2.pack.js',

									   MEDIA_URL . '/js/article-slider/coda-slider.1.1.1.pack.js',

									   MEDIA_URL . '/js/article-slider/articleslider-script.js',

									   MEDIA_URL . '/js/jquery.flow.1.2.auto.js',

									   MEDIA_URL . '/js/related-job-slider.js',

									   MEDIA_URL . '/js/common.js',
									   MEDIA_URL . '/js/bl_updates_loading.js'
									   
									   
									   ));
	echo $this->fetch('script');
		?>


    </head>
    <?php flush(); ?>
    <body id="innerpage-flow">

		<div id="header-innerpage">
			<?php echo $this->element('before-login-header'); ?>
		</div>
		<?php flush(); ?>
		<div class="clear"></div>
        
		<div class="wrapper" id="inner-flow">   
			<div class="top_wrap_area">
				<div class="left_top_wrap">
					<a href="http://www.hult.edu/en/landing/global/ps/global-emba/" class="top_wrap_ad" target="blank">Executive MBA in Dubai - Hult International Business School. Secure your place for September 2014.</a>
				</div>
				<div class="right_top_wrap">
					<div class="findus-icons">
						<ul>
							<li><div class="topfollowus"></div></li>
							<li><a href="https://www.facebook.com/pages/Networkwe/237158053100688" target="_blank" class="fb"></a></li>
							<li><a href="https://twitter.com/networkwe" target="_blank" class="twitter"></a></li>
							<li><a href="http://www.linkedin.com/company/networkwe" target="_blank" class="gplus"></a></li>
							<li><a href="https://plus.google.com/+Networkwe" rel="publisher" target="_blank" class="linkedin"></a></li>
							<li><a href="http://www.pinterest.com/networkwe/" rel="publisher" target="_blank" class="pinterest"></a></li>
							<li><a href="http://instagram.com/network_we" rel="publisher" target="_blank" class="instagram"></a></li>
						</ul>
						<div class="clear"></div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
			<div id="ser">
				<?php echo $this->fetch('content'); ?>
			</div>
            <div class="clear"></div>
        </div>
		<?php flush(); ?>       
        <div class="clear"></div>
        <?php// echo $this->element('Default/footer'); ?>
       
		<!-- --share form for updates post start-->

	<div id="share_popup_ajax" class="share_popup_ajax" style="width:640px;">
		<div class="close" onclick="disablePopup()"></div>
		<div style="width:300px;float:left;padding:10px 0px 0px 0px;">
			<?php echo $this->element('Users/registration_form'); ?>
			
		</div>
		<div style="width:2px;height:150px;background:#ddd;float:left;margin:50px 5px 0px 5px;"></div>
		<div style="width:300px;float:right;padding:5px;">
			<div class="greybox-div-heading"><h1>Login</h1></div>
			<?php echo $this->element('Users/login_form'); ?>
		</div>
		<div class="clear"></div>
	</div>
	
     <div id="backgroundPopup"></div>
<!-- --share form for shared post end-->  

<!--- Login Box Starts Here --->
<div id="forgot_password" class="popup_block" style="width:500px;">
    <div class="popup-heading"><h1>Forgot Password</h1></div>
    <div id="forgot_password_master">
        <form action="" id="forgot_password_form" method="get" class="loginformstyle">
            <fieldset>
                <label style="width:500px;" for="">Please enter your email to reset your password</label>
                <label1 style="width:500px;">
                    <input name="forgot_password_email" type="text" class="required email textfield width1 signin-text" id="forgot_password_email" placeholder="email address"/> 
                    <?php echo $this->Form->submit('Submit', array('type' => 'submit', 'id'=> 'forgot_password_btn','label' => false, 'div' => false,'class' => 'red-bttn')); ?>
<!--                    <input type="submit" id="forgot_password_btn" <?php /*onclick="return sendPassword('forgot_password_form');" */?> value="Submit" />-->
                </label1>
            </fieldset>
        </form>
    </div>
    <div id="forgot_password_error" style="display:none;">
        <h3>The email address you entered is not registered with NetworkWe Account.</h3>
    </div>
    <div id="forgot_password_thankyou" style="display:none;">
        <h3>A password reset email has been sent to </h3>
    </div>
    <div id="forgot_password_invalid" style="display:none;">
        <h3>Not a valid email.</h3>
    </div>
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
            <h3>Thank you for registering with NetworkWe</h3>
            <h4>A confirmation link is sent to your mentioned email.</h4>


        </div>
    </div>
    <!--- Login Box Ends Here --->



	<?php 
	
	
	echo $this->element('sql_dump'); ?>		
<script>
$(function(){ 
	$('a').click(function(e){
		var cl = $(e.target).hasClass('current');
		//var np = $(e.target).hasId('np');
		if(!cl){
			e.preventDefault();
			loadSharePopup();
		}
		
	});
	
});
function loadSharePopup(ID) {
	
	$("#share_popup_ajax").fadeIn(0500); 
	$("#backgroundPopup").css("opacity", "0.7"); 
	$("#backgroundPopup").fadeIn(0001);
}
function disablePopup(ID) {
	$("#share_popup_ajax").fadeOut("normal");
	$("#backgroundPopup").fadeOut("normal");
}

</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
//  ga(.set., .&uid., {{USER_ID}}); // Set the user ID using signed-in user_id.
  ga('create', 'UA-44504907-1', 'networkwe.com');
  ga('send', 'pageview');

</script>

    </body>
</html>
