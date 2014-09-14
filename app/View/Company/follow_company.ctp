<?php if ($user_following_id != '') {
	if ($status == 0) {
	?>
<div style="float:right; display:block;" id="follow_<?php echo $companyID;?>">
    <a href="Javascript:followingTheCompany('<?php echo $companyID?>','<?php echo $uid?>','2','<?php echo $user_following_id?>')" class="button">Follow</a>
</div>
<?php } else {?>
<div style="float:right; display:block;" id="follow_<?php echo $companyID;?>">
    <a href="Javascript:followingTheCompany('<?php echo $companyID?>','<?php echo $uid?>','0','<?php echo $user_following_id?>')" class="button">Following</a>
</div>
<?php } } 
else {?>
<div style="float:right; display:block;" id="following_<?php echo $companyID;?>">
     <a href="/companies/view/<?php echo $companyID?>" class="button">View</a>
</div>
<?php }?>
