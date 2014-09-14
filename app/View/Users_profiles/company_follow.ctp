 <?php if ($status == 2) {?>
		<?php echo $this->Html->link('Following','Javascript:unfollow('.$result_id.','.$following_id.','.$uid.',0,'.$company_id.')',array('class'=>'follow','id'=>'follow_comp'.$following_id,'onMouseOver'=>'showUnfollow('.$following_id.')','onMouseOut'=>'hideUnfollow('.$following_id.')'));?>
	<?php }
	else {?>
	<?php echo $this->Html->link('Follow','Javascript:unfollow('.$result_id.','.$following_id.','.$uid.',2,'.$company_id.')',array('class'=>'unfollow','id'=>'unfollow_comp'.$following_id));?>
<?php }?>