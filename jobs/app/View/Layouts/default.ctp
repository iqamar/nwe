<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
<title>NETWORKWE | Leading Professionals Network of World</title>  
<script type="text/javascript">
    var baseUrl = '<?= $this->request->base ?>';
    var root = '<?= $this->request->webroot ?>';
    var media = '<?= MEDIA_URL ?>';
    var NETWORKWE_URL = '<?= JOBS_URL ?>';
</script>
<?php 
	/*echo $this->Html->css(array(MEDIA_URL.'/css/networkwe.css', 
								
								MEDIA_URL.'/css/popup-style.css', 
								MEDIA_URL.'/css/magicsuggest-1.3.1.css',
								MEDIA_URL.'/js/notification-scroll/jquery.custom-scrollbar.css'
								));*/
	echo $this->Html->css(array(MEDIA_URL . '/css/networkwe-all-style-1.1.1.css',MEDIA_URL.'/css/magicsuggest-1.3.1.css'));
        echo $this->Html->script(array(MEDIA_URL . '/js/jquery-1.10.2.min.js',
									   MEDIA_URL . '/js/respond.min.js',
									   MEDIA_URL . '/js/global_search.js',	//for global search index								 
									   MEDIA_URL . '/js/selectdd.js',
									   MEDIA_URL . '/js/carousels.js',
									   MEDIA_URL . '/js/easyResponsiveTabs.js',
									   MEDIA_URL . '/js/jquery.form.js',		   
									   MEDIA_URL . '/js/popup.js',
									   MEDIA_URL . '/js/article-slider/jquery-easing-1.3.pack.js',
									   MEDIA_URL . '/js/article-slider/jquery-easing-compatibility.1.2.pack.js',
									   MEDIA_URL . '/js/article-slider/coda-slider.1.1.1.pack.js',
									   MEDIA_URL . '/js/article-slider/articleslider-script.js',
									   MEDIA_URL . '/js/jquery.flow.1.2.auto.js',
									   MEDIA_URL . '/js/related-job-slider.js',
									   MEDIA_URL . '/js/notification-scroll/jquery.custom-scrollbar.js',
									   //MEDIA_URL . '/js/notification-scroll/show-hide-scrollDiv.js',
									   MEDIA_URL . '/js/common.js',
									   MEDIA_URL . '/js/magicsuggest-1.3.1.js'
									   
									   ));
//		if ($userInfo) {
			echo $this->Html->script(array(MEDIA_URL.'/js/selectlist_style.js'));
//		}
		
	echo $this->fetch('meta');
	echo $this->fetch('script');
	echo $this->fetch('css');
?>

<!-- html5.js for IE less than 9 -->

<!--[if lt IE 9]>

	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>

<![endif]-->

<!-- css3-mediaqueries.js for IE less than 9 -->

<!--[if lt IE 9]>

	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>

<![endif]-->
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

<body id="innerpage-flow">
	<div id="chat_indicator" class="chat-indicator">
		<a class="chat_indicator_close" onclick="document.getElementById('chat_indicator').style.display = 'none';" href="javascript:void(0)"></a>
	</div>
	
	<div id="header-innerpage">
		<?php 
			//$userid= $this->userInfo['users']['id'];
		if ($userInfo) {
			echo $this->element('header'); 
		}else {
			echo $this->element('before-login-header'); 
		}
		?>
	</div>
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
			<a href="#" onclick="showChat(this);" value="1" class="create-com-bttn">
				<div class="create-chat-icon"></div>
				Chat With Your Connection
			</a>
			<div class="clear"></div>
			
		</div>
		<div class="clear"></div>
		<div class="rgtcol">
			<?php echo $this->element('right_panel'); ?>
		</div>

		<div class="leftcol" id="search_container">
			<?php echo $this->element('search_filter_box'); ?>

			  
		
		<div id="ser">
		<?php echo $this->fetch('content'); ?>
		</div>
		<div class="clear"></div>

		</div>

		<div class="clear"></div>

	</div>

	<div class="clear"></div>
	<div class="footer">
		<?php //echo $this->element('footer'); ?>
	</div> 
    
    <?php if (empty($userInfo)) {?>
    	
		<div id="share_popup_ajax" class="share_popup_ajax" style="width:400px; padding:10px 8px 30px 10px;">
		<div class="close" onClick="disablePopup()"></div>
		<a href="<?php echo NETWORKWE_URL.'/home/user_login' ?>" class="current loginbttn-big margintop20">Please Login</a>
		<div class="clear"></div>
	</div>
	
     <div id="backgroundPopup"></div>

    
  <script>
			$('a').click(function(e){
				var cl = $(e.target).hasClass('current');
				//var np = $(e.target).hasId('np');
			if ($(this).attr("class")) {
				var cclass = $(this).attr("class");
				
					var spilit_class = cclass.split(" ",2);
				
					var class_current = spilit_class[0];
		
				if(class_current != 'current'){
					//e.preventDefault();
					loadSharePopup(class_current);
					return false;
				}
			}
			
			else {
					
				//e.preventDefault();
					loadSharePopup(class_current);	//return true
					return false;
			}		
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
    
        <?php }?>
	<script type="text/javascript">
	$(document).ready(function() {
		$(".flash").slideDown('slow').delay(2000).fadeOut();
	});
	var job_id;
	function jobsave(e){
		job_id = e.getAttribute("value");
		var user_id = document.getElementById("user_id").value;
		//alert(jobstatus+jobid);
		$("#savedJob").show();
		$("#savedJob").html("<img src='<?php echo MEDIA_URL?>/img/loading.gif' style='' alt='Saving' />");
		$.ajax({
			url     : '/search/saveJob/',
			type    : 'POST',
			cache: false,
			data    : {user_id: user_id,job_id:job_id,status:2},
			success : function(data){
				var res = data.split("|",2); 
				
				$("#savedJob").html(res[1]);
				$("#refreshSave").html(res[0]);
				$("#sj_"+job_id).html("<a href='#' onclick='jobunsave(this);' value="+job_id+" class='jobunsave-bttn' id='savejob'>Unsave</a>&nbsp;");
				$(".flash").slideDown('slow').delay(2000).fadeOut();
              },
			 error : function(data) {
			   $("#savedJob").html("there is error");
			}
          });
    
	}
	function jobunsave(e){
		job_id = e.getAttribute("value");
		var user_id = document.getElementById("user_id").value;
		
		$("#savedJob").show();
		$("#savedJob").html("<img src='<?php echo MEDIA_URL?>/img/loading.gif' style='' alt='Saving' />");
		$.ajax({
			url     : '/search/unsaveJob/',
			type    : 'POST',
			cache: false,
			data    : {user_id: user_id,job_id:job_id},
			success : function(data){
				var res = data.split("|",2); 
				
				$("#savedJob").html(res[1]);
				$("#refreshSave").html(res[0]);
				$("#sj_"+job_id).html("<a href='#' onclick='jobsave(this);' value="+job_id+" class='jobsave-bttn' id='savejob'>Save</a>&nbsp;");
				$(".flash").slideDown('slow').delay(2000).fadeOut();
              },
			 error : function(data) {
			   $("#savedJob").html("there is error");
			}
          });
		
    
	}
	
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
 <?php if ($userInfo) {?>
<script type="text/javascript">

        var userid = <?php echo $userInfo['users']['id']; ?>;

        var username = "<?php echo $userInfo['users']['email']; ?>";

        var fullname = "<?php echo $userInfo['users_profiles']['firstname']; ?>";

        var link = "<?php echo $userInfo['users_profiles']['handler']; ?>";

        var avatar = "<?php echo $userInfo['users_profiles']['photo']; ?>";

document.cookie = "cc_data="+userid;

        document.cookie = "cc_data="+userid+'::'+username+'::'+link+'::'+avatar+'::'+fullname;



        </script>



        <link type="text/css" rel="stylesheet" media="all" href="http://chat.networkwe.com/cometchatcss.php" />

        <script type="text/javascript" src="http://chat.networkwe.com/cometchatjs.php" charset="utf-8"></script>
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
<?php } ?>
        <?php echo $this->element('sql_dump'); ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
//  ga(.set., .&uid., {{USER_ID}}); // Set the user ID using signed-in user_id.
  ga('create', 'UA-44504907-1', 'networkwe.com');
  ga('send', 'pageview');

</script>


	<?php echo $this->element('sql_dump'); ?>

</body>

</html>
