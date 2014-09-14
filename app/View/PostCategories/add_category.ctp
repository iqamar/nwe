<?php foreach ($list_categories as $cat__Row) {
		$cat__id = $cat__Row['post_categories']['id'];
	?>              
	<li><input type="checkbox" value="<?php echo $cat__id;?>" id="cat_<?php echo $cat__id;?>" name="[Blog][cat_<?php echo $cat__id;?>]" /> &nbsp;&nbsp; <?php echo $cat__Row['post_categories']['title'];?></li>
<?php }?>