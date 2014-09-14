<?php if ($status == 2) {?>
		<input name="Connect" type="button" id="Connect" value="Following" class="red-bttn" onclick="unfollowMe('<?php echo $follow_id;?>','0','<?php echo $user_id;?>','<?php echo $following_id;?>','followers')">
<?php
		}
		else {
	?>
    <input name="Connect" type="button" id="Connect" value="Follow" class="red-bttn" onclick="unfollowMe('<?php echo $follow_id;?>','2','<?php echo $user_id;?>','<?php echo $following_id;?>','followers')">
	<?php }?>