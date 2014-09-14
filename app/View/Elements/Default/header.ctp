<?php
if ($this->Session->read(@$userid)) {
    $userarray = $this->Session->read(@$userid);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="verify-NWW" content="" />
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <meta name="keywords" content="Professional Networking Sites, Young Professionals Network, Professional Social Network, Social Networking For Business, Business Networking Sites, Business Networking Tips, Small Business Network, Networking Events, Professional Networking Groups, Professional Networking Online, Networking Tips" />
        <meta name="description" content="Deal with professionals in single platform.  Assemble your own professional network. Share knowledge and opportunities with others" />
        <meta name="ROBOTS" content="INDEX,FOLLOW" />
        <meta name="copyright" content=" networkwe" />
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
        <script>
            var baseUrl = '<?= $this->request->base ?>';
            var root = '<?= $this->request->webroot ?>';
        </script>
        <!--[if lt IE 9]><script src="<?= $this->request->base ?>/js/excanvas.min.js"></script><![endif]-->
        <script type="text/javascript" src="<?= $this->request->base ?>/js/jquery-1.7.2.min.js"></script>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css(array("networkwe-base", "jquery.bxslider"));
        echo $this->fetch('meta');
        echo $this->fetch('css');
        ?>
        <script type="text/javascript" src="<?= $this->request->base ?>/js/jquery.bxslider.min.js"></script>
    </head>
    <body>
        <div class="main">
            <div class="mianborder">
                <div class="topbar-sc">
                    <a href="<?= $this->request->base ?>/"><div class="logo-ntwrk"></div></a>




                    <div class="toplinks"> 
                        <ul>
							<li>Follow us on: </li>
							<li>
                                <a title="LinkedIn" target="_blank" href="http://www.linkedin.com/company/networkwe"><img src="http://weblog.networkwe.com/wp-content/themes/itheme2/themify/img/social/linkedin.png"> </a>
                            </li>
                            <li>
                                <a title="Twitter" target="_blank" href="https://twitter.com/networkwe"><img src="http://weblog.networkwe.com/wp-content/themes/itheme2/themify/img/social/twitter.png"> </a>
                            </li>
                           
                            <li>
                               <a title="Facebook" target="_blank" href="https://www.facebook.com/pages/Networkwe/237158053100688"><img src="http://weblog.networkwe.com/wp-content/themes/itheme2/themify/img/social/facebook.png"> </a>
                            </li>
                            <li>
                               <a title="Google+" target="_blank" href="https://plus.google.com/+Networkwe"><img src="http://weblog.networkwe.com/wp-content/themes/itheme2/themify/img/social/google-plus.png"> </a>
                            </li>
                            <li>
                                <a title="Pinterest" target="_blank" href="http://www.pinterest.com/networkwe/"><img src="http://weblog.networkwe.com/wp-content/themes/itheme2/themify/img/social/pinterest.png"> </a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
                <?php echo $this->element('Users/login_form'); ?>