<div class="grid_4">
<?php if ($this->Session->read($userid)) {?>
<?php echo $this->element('Widgets/blog_ads'); ?>
<?php echo $this->element('Widgets/related_jobs'); ?>
<div style="clear:both;"></div>

<?php echo $this->element('Home_page/blogs_networkwe'); ?>
<div style="clear:both;"></div>

<?php echo $this->element('Widgets/profile_performance'); ?>
<div style="clear:both;"></div>

<?php echo $this->element('Widgets/want_to_follow_company'); ?>
<div style="clear:both;"></div>


<?php }?>
</div>

