<ul style="width:280px; padding:0; margin:0; background:none;">
<?php foreach ($search_Result_Tags as $search_tag_row) { 
		$tag_id = $search_tag_row['tags']['id'];
		$post_tag = $search_tag_row['tags']['post_tag'];
		?>
		<li style="cursor:pointer;" onclick="return assignTag('<?php echo $post_tag;?>','<?php echo $tag_id;?>')">
        <?php 
		echo $post_tag;
		?>
        </li>
<?php }?>
</ul>