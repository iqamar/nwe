<ul style="width:280px; padding:0; margin:0; background:none;">
<?php foreach ($search_Result_Groups as $search_group_row) { 
		$userID = $search_group_row['groups']['user_id'];
		$title = $search_group_row['groups']['title'];
		$groupid = $search_group_row['groups']['id'];
		?>
		<li style="cursor:pointer;" onclick="return assignGroup('<?php echo $title;?>','<?php echo $groupid;?>')">
        <?php 
		echo $title;
		?>
        </li>
<?php }?>
</ul>