<ul style="width:280px; padding:0; margin:0; background:none;">
<?php foreach ($search_Result_Skills as $search_skill_row) { 
		$userID = $search_skill_row['skills']['user_id'];
		$title = $search_skill_row['skills']['title'];
		$skillid = $search_skill_row['skills']['id'];
		?>
		<li style="cursor:pointer;" onclick="return assignSkill('<?php echo $title;?>','<?php echo $skillid;?>')">
        <?php 
		echo $title;
		?>
        </li>
<?php }?>
</ul>