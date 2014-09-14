<?php 
if ($user_following_id != '') {
	if ($status == 1) {
	?>
<span id="follow_<?php echo $groupid;?>">
    <a class="waiting_approval">Approval Pending</a>
</span>
<?php } else {?>
<span id="follow_<?php echo $groupid;?>">
    <!--<a href="Javascript:followingTheGroup('<?php //echo $groupid?>','<?php //echo $uid?>','0','<?php //echo $user_following_id?>')" class="join">Joined</a>-->
    <a href="/groups/view/<?php echo $groupid; ?>" class="join">View</a>
</span>
<?php } } 
else {
	if ($status == 1) {
	?>
    <span id="follow_<?php echo $groupid;?>">
    <a class="waiting_approval">Approval Pending</a>
	</span>
    <?php }
	else if ($status == 2) {?>
	<span id="following_<?php echo $groupid;?>">
     <a href="/groups/view/<?php echo $groupid; ?>" class="join">View</a>
	</span>
<?php }}?>