<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="http://chat.networkwe.com/cometchatcss.php" /> 
<script type="text/javascript" src="http://chat.networkwe.com/cometchatjs.php" charset="utf-8"></script> 
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('Alaxos.alaxos.generic');
		echo $this->Html->css('website');
		echo $this->Html->script('jquery.tinycircleslider.js');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
<script type="text/javascript">
		$(document).ready(function(){
			$('#rotatescroll').tinycircleslider({ interval: true, snaptodots: false});			
		});
	</script>
		
</head>
<body>
	<div id="container" style="width:90%;border-radius:0px;margin:0px auto;padding:0px;min-height: 450px;">
		<div id="header" style="border-radius:0px;">
			<div style="float:left;">
			<h1 style="margin:0px 20px;padding:0px;">
			<img src="/img/logo.png" style="vertical-align:middle;">&nbsp;&nbsp;<?php echo $this->Html->link(___('NetworkWe'), '/'); ?></h1>
			</div>
			<div style="float:right;padding:30px;">
			
				
<?php
	if($this->Session->check('Auth.User'))
			{
			    echo $this->Html->link(__('logout'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'logout'));
			}
			else
			{
				echo $this->Html->link(__('What is NetworkWe?'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'login'));
			    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				echo $this->Html->link(__('Join Today'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'login'));
				echo "&nbsp;&nbsp;&nbsp;";
				echo $this->Html->link(__('Sign In'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'login'));
			}
?>
			</div>
		</div>
		<div id="content" style="padding:20px;">
						
			<?php
/*
			echo '<div style="text-align:right;">';
			if($this->Session->check('Auth.User'))
			{
			    echo $this->Html->link(__('logout'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'logout'));
			}
			else
			{
			    echo $this->Html->link(__('login'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'login'));
			}
			echo '</div>';
			
			echo '<div>';
    			echo $this->Html->link(__('users'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'index'));
    			echo ' | ';
    			echo $this->Html->link(__('roles'), array('plugin' => false, 'admin' => false, 'controller' => 'roles', 'action' => 'index'));
    			echo ' | ';
    			echo $this->Html->link(__('posts'), array('plugin' => false, 'admin' => false, 'controller' => 'posts', 'action' => 'index'));
			echo '<div>';
			echo '<div>';
    			echo $this->Html->link(__('users'), array('plugin' => false, 'admin' => true, 'controller' => 'users', 'action' => 'index'));
    			echo ' | ';
    			echo $this->Html->link(__('roles'), array('plugin' => false, 'admin' => true, 'controller' => 'roles', 'action' => 'index'));
    			echo ' | ';
    			echo $this->Html->link(__('posts'), array('plugin' => false, 'admin' => true, 'controller' => 'posts', 'action' => 'index'));
    			echo ' | ';
    			echo $this->Html->link(__('ACL'), array('plugin' => 'acl', 'admin' => true, 'controller' => 'aros', 'action' => 'index'));
			echo '<div>';
*/
			?>
			
	        <?php echo $this->Session->flash('auth', array('element' => 'flash_error', 'params' => array('plugin' => 'alaxos'))); ?>
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		</div>
		<div id="footer" style="text-align:left;background: gray; color: #008000; border: 1px solid gray;height: 220px; margin: 0 auto; padding: 0; width: 90%;">   
		 
		    <div style="margin:20px;float:left;width:30%">
        		<h4>Head Office: UAE</h4>
		        <p><Suite 403, Jumeirah Bay,<br>Tower X2 Jumeirah Lakes Towers,<br>Sh. Zayed Road, Dubai, UAE<br>Tel : +971 4 4179600<br>Fax : +971 4 4179610<br>P.O.Box 31372, Dubai, UAE<br>support@GulfBankers.com<br><a target="_blank" href="/download.php">Click here to see location map</a></p>
		    </div>
		    <div style="margin:20px;float:left;width:30%">
        		<h4>Egypt:</h4>
				<p>45 Mosadek Street, Dokki,<br>6th floor, EFG Hermes Building,<br>Cairo, Egypt<br>Tel: +202 3 336 9661<br>Fax: +202 3 336 9622</p>
        		<h4>Bahrain:</h4>
				<p>73 Al Rossais Tower - Diplomatic Area<br>P.O.Box 5043, Manama, Bahrain<br>Tel: +973 17 535396<br>Fax: +973 17 536676</p>
        	</div>
		    <div style="margin:20px;float:left;width:30%">
<ul>
            <li><a href="/index.php">Home</a></li>
                        <li><a href="/aboutcompany-2-about-us.html">About us</a></li>
                        <li><a href="/aboutcompany-4-our-terms.html">Our Terms</a></li>
                        <li><a href="/aboutcompany-16-contact-us.html">Contact us</a></li>
                        <li><a href="/aboutcompany-17-executive-search-retained.html">Executive Search Retained</a></li>
                        <li><a href="/aboutcompany-19-track-record.html">Track Record</a></li>
                        <li><a href="/aboutcompany-20-executive-search-contingency.html">Executive Search Contingency</a></li>
                        <li><a href="/aboutcompany-21-profile-assessments.html">Profile Assessments</a></li>
                        <li><a href="/aboutcompany-22-hr-consultancy-practice.html">HR Consultancy Practice</a></li>
                        <li><a href="/aboutcompany-23-our-managment-team.html">Our Managment Team</a></li>
                        <li><a href="/aboutcompany-25-join-us.html">Join Us</a></li>
                    </ul>
    	    
       
    </div>




<div style="clear:both;"></div>
<div style=" box-shadow: 50px 50px 50px 50px gray;padding: 20px 0 10px 20px;">Powered by <a href="http://www.forumintl.com" target="_blank" title="Powered by Forum International &reg;">Forum International &reg;</a><br>Copyright 2013 &COPY; GulfBankers.com</div>



		</div>
	</div>

</body>
</html>
