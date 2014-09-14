<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>NetworkWe :: Recruiter Section</title>
        <script>
            var baseUrl = '<?php echo $this->request->base; ?>';
            var root = '<?php echo $this->request->webroot; ?>';
            var NETWORKWE_URL = '<?php echo NETWORKWE_URL; ?>';
            var media = '<?php echo MEDIA_URL; ?>';
        </script>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="verify-NWW" content="" />
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <meta name="keywords" content="professional, networking, professional networks, global professional network, professional networking tips, minority professional network, professional social network, professional social networking sites, bank job,banking,finance,careers,ebanking,dubai,international,experience,candidates,uae,skills,sourcing,opportunities,jobs,saudi arabia,abu dhabi,egypt,bahrain,jordan,oman,qatar,kuwait,2013,2014,career,bankers,bank jobs,financial careers" />
        <meta name="description" content="A Global and Unique Network Portal for Professional, Recruiters and Agencies for Banking and Financial Professional. Banking Jobs in UAE, Saudi Arabia, Bahrain, Oman, Qatar, Kuwait & Egypt. The Leading Job Portal in Banking and Finance Industry." />
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
        <?php
        //echo $this->Html->css(array('bootstrap-responsive', 'networkwe-app', 'jquery-ui-1.8.21.custom', 'fullcalendar', "fullcalendar.print", 'chosen', 
		//'uniform.default', 'colorbox', 'jquery.cleditor', 'jquery.noty', 'noty_theme_default', 'elfinder.min', 'elfinder.theme', 'jquery.iphone.toggle', 
		//'opa-icons', 'uploadify', 'bootstrap-simplex'));
        echo $this->Html->css(array(
		//MEDIA_URL . '/backend/css/bootstrap.min.css',
            MEDIA_URL . '/backend/css/bootstrap-responsive.min.css',
            MEDIA_URL . '/backend/css/jquery-ui-1.8.21.custom.css',
            MEDIA_URL . '/backend/css/networkwe-app.css',
            MEDIA_URL . '/backend/css/fullcalendar.css',
            MEDIA_URL . '/backend/css/fullcalendar.print.css',
            MEDIA_URL . '/backend/css/chosen.css',
            MEDIA_URL . '/backend/css/uniform.default.css',
            MEDIA_URL . '/backend/css/colorbox.css',
            //MEDIA_URL . '/backend/css/elfinder.min.css',
            //MEDIA_URL . '/backend/css/elfinder.theme.css',
            //MEDIA_URL . '/backend/css/jquery.iphone.toggle.css',
            //MEDIA_URL . '/backend/css/opa-icons.css',
            MEDIA_URL . '/backend/css/uploadify.css',
            MEDIA_URL . '/backend/css/jquery.cleditor.css',
            MEDIA_URL . '/backend/css/jquery.noty.css',
            MEDIA_URL . '/backend/css/noty_theme_default.css',
            MEDIA_URL . '/backend/css/bootstrap-simplex.css'
            ));
        echo $this->fetch('css');
        echo $this->Html->script(array(
		MEDIA_URL . '/backend/js/jquery.min.js',
		//MEDIA_URL . '/backend/js/typeahead.bundle.min.js'
		//MEDIA_URL . '/backend/js/bootstrap-typeahead.js'
		));
        ?>
        <style type="text/css">
            /*body {
                padding-bottom: 40px;
            }
            .sidebar-nav {
                padding: 9px 0;
            }
            .logo img { height: 35px; }
            .form-horizontal .control-label { border-bottom: none; }*/
        </style>
        <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js',
        <![endif]-->
        <!-- The fav icon -->
        <link rel="shortcut icon" href="<?php echo $this->request->base; ?>/img/favicon.ico">
    </head>
    <body>
        <noscript>
        <div class="alert alert-block span10">
            <h4 class="alert-heading">Warning!</h4>
            <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
        </div>
        </noscript>
        <!-- topbar starts -->
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="logo" href="<?php echo NETWORKWE_URL?>">
                        <img alt="<?php echo SITE_TITLE?>Logo" src="<?php echo MEDIA_URL; ?>/img/networkwe_logo.png" />
                    </a>
					
                    <!-- user dropdown starts -->
                    <div class="btn-group pull-right" >
						
						<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="icon-user"></i><span class="hidden-phone"> Recruiter</span>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo NETWORKWE_URL?>/recruiter/employer_edit/<?= $this->Session->read('company_id'); ?>">Settings</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo $this->request->base ?>/users/logout/">Logout</a></li>
                        </ul>
                    </div>
					<?php 
						$pro = $this->Session->read(@'professional');
					if($pro){
					?>
						<div class="btn-group pull-right" >
						
							<a href="<?php echo NETWORKWE_URL?>/users/switchToProfessional/<?= $pro.'/'.$this->Session->read('company_id'); ?>" class="btn btn-success"><i class="icon-white icon-user"></i> Go To Professional Account</a>
						</div>
					<?php } ?>
					
                </div>
            </div>
        </div>
        <!-- topbar ends -->
        <div class="container-fluid">
            <div class="row-fluid">
                <?php echo $this->element('Recruiter/left_menu'); ?>
                <div id="content" class="span10">
                    <?php echo $this->fetch('content'); ?>
                </div><!--/#content.span10-->
            </div><!--/fluid-row-->
            <hr>
            <div class="modal hide fade" id="myModal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Settings</h3>
                </div>
                <div class="modal-body">
                    <p>Here settings can be configured...</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn" data-dismiss="modal">Close</a>
                    <a href="#" class="btn btn-primary">Save changes</a>
                </div>
            </div>
            <footer>
                <p class="pull-left">Copyright &copy; <a href="http://www.networkwe.com" target="_blank">NetworkWE</a> <?php echo date("Y"); ?></p>
                <p class="pull-right">Powered by: <a href="http://forumintl.com" target="_blank">A Forum International Company</a></p>
            </footer>
        </div><!--/.fluid-container-->
        <?php
        //echo $this->Html->script(array('jquery.validate.js','jquery-ui-1.8.21.custom.min.js', 'bootstrap-transition.js', 'bootstrap-alert.js', 
        //'bootstrap-modal.js', 'bootstrap-dropdown.js', 'bootstrap-scrollspy.js', 'bootstrap-tab.js', 'bootstrap-tooltip.js','bootstrap-popover.js',
        //'bootstrap-button.js', 'bootstrap-collapse.js', 'bootstrap-carousel.js', 'bootstrap-typeahead.js', 'bootstrap-tour.js', 'jquery.cookie.js', 
        //'fullcalendar.min.js', 'jquery.dataTables.min.js', 'excanvas.js', 'jquery.flot.min.js', 'jquery.flot.pie.min.js', 'jquery.flot.stack.js', 
        //'jquery.flot.resize.min.js', 'jquery.chosen.min.js', 'jquery.uniform.min.js', 'jquery.colorbox.min.js', 'jquery.cleditor.min.js', 'jquery.noty.js', 
        //'jquery.elfinder.min.js', 'jquery.raty.min.js', 'jquery.iphone.toggle.js', 'jquery.autogrow-textarea.js', 'jquery.uploadify-3.1.min.js', 
        //'jquery.history.js', 'networkwe.js'));
        echo $this->Html->script(array(
            MEDIA_URL . '/backend/js/jquery.validate.min.js',
            MEDIA_URL . '/backend/js/jquery-ui-1.8.21.custom.min.js', 
			//MEDIA_URL . '/backend/js/bootstrap.min.js',
            //MEDIA_URL . '/backend/js/bootstrap-transition.js',
            MEDIA_URL . '/backend/js/bootstrap-alert.js',
            MEDIA_URL . '/backend/js/bootstrap-modal.js',
            MEDIA_URL . '/backend/js/bootstrap-dropdown.js',
            MEDIA_URL . '/backend/js/bootstrap-scrollspy.js',
            MEDIA_URL . '/backend/js/bootstrap-tab.js',
            MEDIA_URL . '/backend/js/bootstrap-tooltip.js',
            MEDIA_URL . '/backend/js/bootstrap-popover.js',
            MEDIA_URL . '/backend/js/bootstrap-button.js',
            //MEDIA_URL . '/backend/js/bootstrap-collapse.js',
            MEDIA_URL . '/backend/js/bootstrap-carousel.js',
            MEDIA_URL . '/backend/js/bootstrap-typeahead.js',
            //MEDIA_URL . '/backend/js/bootstrap-tour.js',//Check if needed
            MEDIA_URL . '/backend/js/jquery.cookie.js',
            MEDIA_URL . '/backend/js/fullcalendar.min.js',
            MEDIA_URL . '/backend/js/jquery.dataTables.min.js',
            MEDIA_URL . '/backend/js/excanvas.js',
            //MEDIA_URL . '/backend/js/jquery.flot.min.js',
            //MEDIA_URL . '/backend/js/jquery.flot.pie.min.js',
            //MEDIA_URL . '/backend/js/jquery.flot.stack.js',
            //MEDIA_URL . '/backend/js/jquery.flot.resize.min.js',
            MEDIA_URL . '/backend/js/jquery.chosen.min.js',
            MEDIA_URL . '/backend/js/jquery.uniform.min.js',
            MEDIA_URL . '/backend/js/jquery.colorbox.min.js',
            MEDIA_URL . '/backend/js/jquery.cleditor.min.js',
            MEDIA_URL . '/backend/js/jquery.noty.js',
            //MEDIA_URL . '/backend/js/jquery.elfinder.min.js',
            MEDIA_URL . '/backend/js/jquery.raty.min.js',
            //MEDIA_URL . '/backend/js/jquery.iphone.toggle.js',
            MEDIA_URL . '/backend/js/jquery.autogrow-textarea.js',
            MEDIA_URL . '/backend/js/jquery.uploadify-3.1.min.js',
            MEDIA_URL . '/backend/js/jquery.history.js',
            MEDIA_URL . '/backend/js/common.js'
            ));
        echo $this->fetch('script');
        echo $this->Session->flash('recruiter_flash');
        ?>
    </body>
</html>