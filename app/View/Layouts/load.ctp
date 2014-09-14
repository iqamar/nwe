<?php
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
        echo $this->Html->css(array(MEDIA_URL.'/css/beforelogin/home.css', MEDIA_URL.'/css/popup-style.css'));
        echo $this->Html->script(array(MEDIA_URL.'/js/respond.min.js', MEDIA_URL.'/js/jquery-1.10.2.min.js',  MEDIA_URL.'/js/beforelogin/sliderscript.js', MEDIA_URL.'/js/popup.js'));
        ?>


    </head>
    <body>

<div id="fullheader">
	<div id="header-homepage">
    	<a href="<?= NETWORKWE_URL ?>/" id="logo" title="NetworkWe"></a>
        <div class="headercaption">
   	    <img src="<?= MEDIA_URL?>/img/home-header-caption.png" width="612" height="47" /></div>
  </div>
</div>



        <div class="wrapper">            
            <?php echo $this->fetch('content'); ?>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <?php echo $this->element('Default/footer'); ?>
        <script>
            $('#games').coinslider();
        </script>   
<?php echo $this->element('sql_dump'); ?>		
    </body>
</html>