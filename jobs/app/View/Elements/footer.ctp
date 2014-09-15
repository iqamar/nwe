<div class="footer">
    <a href="<?php echo NETWORKWE_URL  ?>/the-company/aboutus/">About NetworkWe</a>   |   
    <a href="<?php echo NETWORKWE_URL ?>/the-company/team/">Meet Our Team</a>   |    
    <a href="<?php echo NETWORKWE_URL ?>/the-company/what/">What's NetworkWe?</a>   |  
    <a href="<?php echo NETWORKWE_URL ?>/the-company/why/">Why NetworkWe?</a>   |
    <a href="<?php echo NETWORKWE_URL ?>/the-company/contactus/">Contact Us</a> | 
<!--    <a href="#">Help Center</a>  | -->
    <a href="<?php echo NETWORKWE_URL ?>/the-company/joinus/">Career</a>
<!--    <a href="#">Advertise with Us</a> |
    <a href="#">Mobile Version</a><br />-->
    <div class="socialnetwork-links"> 
        <ul>
            <li><?= __('Follow us on: ') ?></li>
            <li><?php echo $this->Html->link($this->Html->image(MEDIA_URL . '/img/linkedin.png', array('alt' => 'LinkedIn')), 'http://www.linkedin.com/company/networkwe', array('escapeTitle' => false, 'title' => 'LinkedIn')); ?></li>
            <li><?php echo $this->Html->link($this->Html->image(MEDIA_URL . '/img/twitter.png', array('alt' => 'Twitter')), 'https://twitter.com/networkwe', array('escapeTitle' => false, 'title' => 'Twitter')); ?></li>
            <li><?php echo $this->Html->link($this->Html->image(MEDIA_URL . '/img/facebook.png', array('alt' => 'Facebook')), 'https://www.facebook.com/pages/Networkwe/237158053100688', array('escapeTitle' => false, 'title' => 'Twitter')); ?></li>
            <li><?php echo $this->Html->link($this->Html->image(MEDIA_URL . '/img/google-plus.png', array('alt' => 'Google+')), 'https://plus.google.com/+Networkwe', array('escapeTitle' => false, 'title' => 'Google+')); ?></li>
            <li><?php echo $this->Html->link($this->Html->image(MEDIA_URL . '/img/pinterest.png', array('alt' => 'Pinterest')), 'http://www.pinterest.com/networkwe/', array('escapeTitle' => false, 'title' => 'Pinterest')); ?></li>
        </ul>
    </div>
    <div class="clear"></div>		
    <div class="margintop10"><?php echo $this->Html->Image(MEDIA_URL . '/img/networkwe-logo-small.png', array('width' => 82, 'height' => 18)); ?> &copy; 2014</div>
</div>