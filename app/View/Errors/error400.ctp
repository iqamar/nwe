<?php
$this->layout = 'error';
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
 * @package       Cake.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="wrapper">
  <table width="100%" border="0" cellspacing="2" cellpadding="1">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
		
		<?php echo $this->Html->image(MEDIA_URL.'/img/404.png',array('width'=>826,'height'=>432));?>
	</td>
  </tr>
  <tr>
    <td><a class="back_button" href="javascript: history.go(-1)"><?php echo $this->Html->image(MEDIA_URL.'/img/back_icon_arrow.png',array('width'=>12,'height'=>10));?> Go Back</a></td>
  </tr>
</table>
<div class="clear"></div>
</div>
<div class="clear"></div>
<?php
if (Configure::read('debug') > 0 ):
	echo $this->element('exception_stack_trace');
endif;
?>
