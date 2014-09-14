<?php if($mode == 'pending'): ?>
<a href="javascript:;" class="connect-bttn"> Pending Approval</a>
<?php elseif ($mode == 'removed'): ?>
<!--<a href="javascript:;" onclick="decline('<?php echo $profile_id;?>',0)" class="connect-bttn"> Remove Connection</a>--> <a href="<?php echo $profile_link?$profile_link:'#';?>" class="send-bttn"> Send Message</a> 
<?php endif; ?>
