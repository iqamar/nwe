<?php ob_start();
echo $this->Html->docType('html5'); ?>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>

       
		<meta name="viewport" content="initial-scale=1, maximum-scale=1" />
    	<meta name="viewport" content="width=device-width, user-scalable=no" />

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

        <!--<meta name="pragma" content="no-cache" />-->
        <meta name="pragma" content="cache" />

        <meta name="classification" content=" A Global and Unique Network Portal for Professional, Recruiters and Agencies" />

        <title><?php if ($title_for_layout) echo $title_for_layout; ?> | NETWORKWE Leading Professionals Network of the World</title>

        <?php
	 echo $this->fetch('meta');
	 //echo $this->fetch('css');
	// echo $this->fetch('script');
	/*
       echo $this->Html->css(array(MEDIA_URL . '/css/networkwe.css',

									MEDIA_URL . '/css/userprofile-tab.css',

									MEDIA_URL . '/css/popup-style.css',

									MEDIA_URL . '/js/datepicker/datepicker-style.css',

									MEDIA_URL . '/js/article-slider/articleslider.css',

									MEDIA_URL . '/css/related-jobslider.css',

									MEDIA_URL . '/css/webcam.css',
									
									MEDIA_URL . '/css/selectlist_style.css',

									MEDIA_URL . '/js/notification-scroll/jquery.custom-scrollbar.css'

									));*/
echo $this->Html->css(array(MEDIA_URL . '/css/networkwe-all-style-1.1.1.css'));
       

        echo $this->fetch('css');
	
        ?>

        <script type="text/javascript">

           /* var baseUrl = '<?= $this->request->base ?>';

            var root = '<?= $this->request->webroot ?>';

            var media = '<?= MEDIA_URL ?>';*/

        </script>


<style>
.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('http://media.networkwe.com/img/loading.gif') 50% 50% no-repeat rgb(249,249,249);
}

</style>
</head>
<?php flush(); ?>
    <body id="innerpage-flow" >
	<!--<div class="loader">
		<div id="header-innerpage">

            <?php //echo $this->element('pre-header'); ?>

        </div>
	</div>
	-->
	<div id="chat_indicator" class="chat-indicator">
		<a class="chat_indicator_close" onClick="document.getElementById('chat_indicator').style.display = 'none';" href="javascript:void(0)"></a>
	</div>
        <div id="header-innerpage">

            <?php echo $this->element('header'); ?>

        </div>
<?php flush(); ?>
        <div class="clear"></div>

        <div class="wrapper" id="inner-flow">
		
		<div class="top_wrap_area">
		
			<a href="<?php echo NETWORKWE_URL;?>/companies/validity/" class="create-com-bttn">
				<div class="create-com-icon"></div>
				Create Company Page to Attract Talent
			</a>
			<a href="<?php echo NETWORKWE_URL;?>/groups/add/" class="create-com-bttn">
				<div class="create-blog-icon"></div>
				Create Group And Post Your Updates
			</a>
			
			<?php /*if($assignedUsers):?>
			<div id="joboption">
				<ul>
					<li class="has-sub"> 
						<a href=""> <div class="switch-acc"></div>Go to Recruitment Account</a>
						<ul>
							<?php foreach($assignedUsers as $user):							
							?>
							<li><?php echo $this->Html->link($user['Recruiter']['title'],array('controller'=>'users','action'=>'switchToRecruiter/'.$user['Recruiter']['user_id'].'/'.$user['Recruiter']['id'].'/'.$uid),array('escape'=>false)); ?></li>
							
							<?php endforeach; ?>
						</ul>
				  </li>
				</ul>
			</div>
			<?php endif; */?>
			<a href="#" onClick="showChat(this);" value="1" class="create-com-bttn">
				<div class="create-chat-icon"></div>
				Chat With Your Connection
			</a>
			<div class="clear"></div>
			
		</div>
		<div class="clear"></div>
            <div class="rgtcol">

                <?php 

/*                $url = $this->here;

                $url = @explode('/', $url);

                $controller = $url[1];

                $action = $url[2];*/
		 $controller = $this->params['controller'];
		 $action = $this->params['action'];
                if ($controller == 'companies' && $action == 'add') {

                    echo $this->element('no-sidebar');

                } 

				//else if ($controller == 'groups' && $action == 'add') {

                    //echo $this->element('add-sidebar');

                //} 

				//else if ($controller == 'groups') {

                    //echo $this->element('groups_right');

                //}

				else if ($controller == 'articles') {

                    echo $this->element('article_right');

                }  else if ($controller == 'users_profiles' || $controller == 'connections' || $controller == 'groups' || $controller == 'companies' || $controller == 'messages'|| $controller == 'blogs' || $controller == 'news' || $controller == 'contacts') {

                    echo $this->element('right_col');

				} else if ($controller == 'home' || $controller == '') {

                    echo $this->element('home_right');

                } else if ($controller == 'press_releases' || $controller == 'tweets') {

                    echo $this->element('right_press');

                }

                ?>

            </div>
<?php flush(); ?>
            <div class="leftcol" id="search_container">

               <?php echo $this->fetch('content'); ?> 

            </div>

            <div class="clear"></div>

        </div>

        <div class="clear"></div>
<?php flush(); ?>
        

 <script type="text/javascript">

            var baseUrl = '<?= $this->request->base ?>';

            var root = '<?= $this->request->webroot ?>';

            var media = '<?= MEDIA_URL ?>';
            var NETWORKWE_URL = '<?= NETWORKWE_URL ?>';

        </script>

 <?php
 
	
	 //echo $this->fetch('css');
	// echo $this->fetch('script');
       

        echo $this->Html->script(array(MEDIA_URL . '/js/jquery-1.10.2.min.js',

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

									   

									   MEDIA_URL . '/js/notification-scroll/jquery.custom-scrollbar.js',

									  // MEDIA_URL . '/js/notification-scroll/show-hide-scrollDiv.js',

									  // MEDIA_URL . '/js/datepicker/datepick-modules.js',

									   MEDIA_URL . '/js/datepicker/datepick-moduel1.js',
									   MEDIA_URL . '/js/common.js',
									   MEDIA_URL . '/js/global_search.js'	//for global search index								 

									   ));
									   
									   if(("home" == $this->params['controller'])){ 
									   
									   		if ("myupdates" == $this->params['action'] || "view" == $this->params['action']) {
										  //for home myupdates 
										  echo $this->Html->script(array(MEDIA_URL . '/js/textarea.autosize.js',
																		 MEDIA_URL . '/js/home_index.js')); 
											}
											else if("index" == $this->params['action']) {
											//for home index 
										  echo $this->Html->script(array(MEDIA_URL . '/js/textarea.autosize.js',
																		 MEDIA_URL . '/js/home_index.js',
																		 MEDIA_URL . '/js/updates_loading.js')); 
											
											}
										  
									   }
									   else if("users_profiles" == $this->params['controller']){
										   
										  //for update profile
										  if("update" == $this->params['action']){
											  
												echo $this->Html->script(array(MEDIA_URL.'/js/webcam/webcam.js', MEDIA_URL.'/js/webcam/script.js',
																			   MEDIA_URL.'/js/jquery.fcbkcomplete.js',
																			   MEDIA_URL.'/js/tinymce/tinymce.min.js',
																			   MEDIA_URL.'/js/update_profile.js')); 
												
										  }
										  else if("review" == $this->params['action']){
												echo $this->Html->script(array(MEDIA_URL . '/js/easyResponsiveTabs.js',
																			   MEDIA_URL.'/js/update_review.js'));
										  }
										   else if("myprofile" == $this->params['action']){ 
									   
											echo $this->Html->script(array(MEDIA_URL.'/js/myprofile.js'));
									   		}
											else if("userprofile" == $this->params['action']){ 
									   
											echo $this->Html->script(array(MEDIA_URL.'/js/userprofile.js'));
									   		}
									   }
									   else if("tweets" == $this->params['controller']){
										   
										  //for tweets
										  if("index" == $this->params['action']){
											  
											echo $this->Html->script(array(MEDIA_URL.'/js/jquery.form.js',
																		   MEDIA_URL.'/js/tweet_index.js')); 											
										  }
										  else if("profile" == $this->params['action']){
											  
											echo $this->Html->script(array(MEDIA_URL.'/js/jquery.form.js',
																		   MEDIA_URL.'/js/tweet_profile.js')); 
										  }
									   }
									   else if(("companies" == $this->params['controller']) && ("view" == $this->params['action'])){ 
									   
											echo $this->Html->script(array(MEDIA_URL.'/js/company_update.js'));
											
									   }
									   else if(("groups" == $this->params['controller']) && ("view" == $this->params['action'])){ 
									   
											echo $this->Html->script(array(MEDIA_URL.'/js/group_update.js'));
									   }else if(("news" == $this->params['controller']) && ("index" == $this->params['action'])){ 
									   
											echo $this->Html->script(array(MEDIA_URL.'/js/news_index.js'));
									   }
									   else if(("messages" == $this->params['controller']) && ("index" == $this->params['action'])){ 
											echo $this->Html->css(array(MEDIA_URL . '/css/magicsuggest-1.3.1.css'));
											echo $this->Html->script(array(MEDIA_URL.'/js/msg_inbox.js',
																			MEDIA_URL.'/js/jquery.validate.js',
																			MEDIA_URL.'/js/magicsuggest-1.3.1.js'));
									   }
									   
									   if(("users_profiles" == $this->params['controller']) || ("connections" == $this->params['controller']) || ("companies" == $this->params['controller']) || ("groups" == $this->params['controller']) || ("blogs" == $this->params['controller']) || ("news" == $this->params['controller']) || ("messages" == $this->params['controller']) || ("contacts" == $this->params['controller'])){ 
									   
									   		echo $this->Html->script(array(MEDIA_URL.'/js/sidebar.js'));
									   }
									  

        echo $this->fetch('script');

        
        ?>

       

        <!-- html5.js for IE less than 9 -->

        <!--[if lt IE 9]>

                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>

        <![endif]-->

        <!-- css3-mediaqueries.js for IE less than 9 -->

        <!--[if lt IE 9]>

                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>

        <![endif]-->
		
		<script type="text/javascript">
/*$(window).load(function() {
	$(".loader").fadeOut("fast");
})*/


</script>
<?php ob_flush(); ?>

<script type="text/javascript">

	var userid = <?php echo $_SESSION['userid']; ?>;

	var username = "<?php echo $_SESSION['email']; ?>";	

	var fullname = "<?php echo $_SESSION['fullname']; ?>";

	var link = "<?php echo $_SESSION['handler']; ?>";

	var avatar = "<?php echo $_SESSION['picture']; ?>";

	document.cookie = "cc_data="+userid;

	document.cookie = "cc_data="+userid+'::'+username+'::'+link+'::'+avatar+'::'+fullname; 



	</script>



	<link type="text/css" rel="stylesheet" media="all" href="http://chat.networkwe.com/cometchatcss.php" /> 
	<script type="text/javascript" src="http://chat.networkwe.com/cometchatjs.php" charset="utf-8"></script>
<?php echo $this->Html->script(array(MEDIA_URL . '/js/datepicker/datepick-modules.js')); ?>
<style>
#chat_indicator{display:none;}
</style>
<script type="text/javascript">
function showChat(e){
	var id = e.getAttribute("value");
	if(id=='1'){
		$("#chat_indicator").show();
		//$("#cometchat_userstab_popup").addClass('cometchat_tabopen');
		
	}else{
		$("#chat_indicator").hide();
		//$("#cometchat_userstab_popup").removeClass('cometchat_tabopen');
	}
}
</script>
	<?php echo $this->element('sql_dump'); ?>
    </body>

</html>
<script type="text/javascript">
/*$(window).unload(function() {
    var answer = confirm("Are you sure?")
if (answer){
    alert("Bye bye!")
}else{
    alert("Thanks for sticking around!")
}

});*/





var globalIndicator = true;

$( 'a[href^=http]' ).on('click', function() {
    globalIndicator = false;
});


window.onunload=function(){
if(globalIndicator && (readCookie("js_remember_me") ==  "-1")){
	 $.ajax({
        	url: 'http://www.networkwe.com/users/logout',
	        type: 'GET',
        	async: false,
	        timeout: 4000
	    });
	}
};


function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
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

