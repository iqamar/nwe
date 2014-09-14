<div class="grid_4">
<?php if ($this->Session->read($userid)) {?>

<?php echo $this->element('Company/user_companies'); ?>
<div style="clear:both;"></div>
<?php echo $this->element('Company/follow_companies'); ?>
<div style="clear:both;"></div>

<?php //echo $this->element('Company/find_company'); ?>
<div style="clear:both;"></div>


<?php }?>

</div>