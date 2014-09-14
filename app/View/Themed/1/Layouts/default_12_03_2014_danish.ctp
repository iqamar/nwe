<?php echo $this->Html->docType('html5'); ?>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
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
        <title>NETWORKWE | <?php if ($title_for_layout) echo $title_for_layout; ?></title>
        <?php
        echo $this->Html->css(array(MEDIA_URL . '/css/networkwe.css',
									MEDIA_URL . '/css/userprofile-tab.css',
									MEDIA_URL . '/css/popup-style.css',
									MEDIA_URL . '/js/datepicker/datepicker-style.css',
									MEDIA_URL . '/js/article-slider/articleslider.css',
									MEDIA_URL . '/css/related-jobslider.css',
									MEDIA_URL . '/css/webcam.css',
									MEDIA_URL . '/js/notification-scroll/jquery.custom-scrollbar.css'
									));
        echo $this->Html->script(array(MEDIA_URL . '/js/jquery-1.10.2.min.js',
									   MEDIA_URL . '/js/respond.min.js',
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
									   MEDIA_URL . '/js/notification-scroll/show-hide-scrollDiv.js',
									   MEDIA_URL . '/js/datepicker/datepick-modules.js',
									   MEDIA_URL . '/js/datepicker/datepick-moduel1.js'
									   ));
        echo $this->fetch('script');
        echo $this->fetch('css');
        ?>
        <script type="text/javascript">
            var baseUrl = '<?= $this->request->base ?>';
            var root = '<?= $this->request->webroot ?>';
            var media = '<?= MEDIA_URL ?>';
        </script>
        <!-- html5.js for IE less than 9 -->
        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- css3-mediaqueries.js for IE less than 9 -->
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <![endif]-->
    </head>
    <body id="innerpage-flow">
        <div id="header-innerpage">
            <?php echo $this->element('header'); ?>
        </div>
        <div class="clear"></div>
        <div class="wrapper" id="inner-flow">
            <div class="rgtcol">
                <?php 
                $url = $this->here;
                $url = @explode('/', $url);
                $controller = $url[1];
                $action = $url[2];
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
                } 
					//else if ($controller == 'companies') {
                    //echo $this->element('companies_right');
                   //} 
				else if ($controller == 'blogs' && $action != 'add') {
                    echo $this->element('right_blog');
                } else if ($controller == 'blogs' && $action == 'add') {
                    echo $this->element('add-blog');
                } else if ($controller == 'news') {
                    echo $this->element('news_right');
                } else if ($controller == 'users_profiles' || $controller == 'connections' || $controller == 'groups' || $controller == 'companies') {
                    echo $this->element('right_col');
				} else if ($controller == 'home' || $controller == '') {
                    echo $this->element('home_right');
                } else if ($controller == 'press_releases' || $controller == 'tweets') {
                    echo $this->element('right_press');
                }
                ?>
            </div>
            <div class="leftcol" id="search_container">
               <?php echo $this->fetch('content'); ?> 
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="footer">
            <?php echo $this->element('footer'); ?>
        </div>
        <script type="text/javascript">
	var userid = <?php echo $_SESSION['userid']; ?>;
	var username = "<?php echo $_SESSION['email']; ?>";	
	var fullname = "<?php echo $_SESSION['fullname']; ?>";
	var link = "<?php echo $_SESSION['handler']; ?>";
	var avatar = "<?php echo $_SESSION['picture']; ?>";
	//document.cookie = "cc_data="+userid;
	document.cookie = "cc_data="+userid+'::'+username+'::'+link+'::'+avatar+'::'+fullname; 

	</script>

	<link type="text/css" rel="stylesheet" media="all" href="http://chat.networkwe.com/cometchatcss.php" /> 
	<script type="text/javascript" src="http://chat.networkwe.com/cometchatjs.php" charset="utf-8"></script>

    </body>
</html>
