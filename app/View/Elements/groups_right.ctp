<div class="grid_4">
<?php if ($this->Session->read($userid)) {?>

<?php echo $this->element('Group/user_groups'); ?>
<div style="clear:both;"></div>
<?php echo $this->element('Group/join_group'); ?>
<div style="clear:both;"></div>
<?php }?>

</div>