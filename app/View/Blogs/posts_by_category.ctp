<?php 
	if(!empty($posts_per_category)){
		foreach ($posts_per_category as $posts_inCat_Row) {
			$postId = $posts_inCat_Row['blogs']['id'];
			$created_date = $posts_inCat_Row['blogs']['created'];
			$year = date("Y", strtotime($created_date));
			$month = date("M", strtotime($created_date));
			$day = date("d", strtotime($created_date));
			$auther_fullname = $posts_inCat_Row['users_profiles']['firstname']." ".$posts_inCat_Row['users_profiles']['lastname'];
			$pub_profile = $posts_inCat_Row['users_profiles']['handler'];
			$title_url = str_replace(" ", "-", strtolower($posts_inCat_Row['blogs']['post_title']));
			$blogImage = $posts_inCat_Row['blogs']['image'];
			$desc =  strip_tags($posts_inCat_Row['blogs']['description'],"<img");
?>
	<div class="blogslisitng">
		<div class="blogdate"> <span><?php echo $day;?></span> <span class="smalltext"><?php echo $month;?></span><br />
		<span class="smalltext"><?php echo $year;?></span> </div>
		<div class="blogtopdiv">
			<div class="blogtitle">
			  <h1><?php echo $this->Html->link($posts_inCat_Row['blogs']['post_title'],array('controller'=>'blogs','action'=>'view',$postId,$title_url),array('style'=>' text-decoration:none;'));?></h1>
			</div>
		</div>
		<div class="blogslisitng-pic">
			<?php 
				if($blogImage){
					echo $this->Html->link($this->Html->Image(MEDIA_URL.'/files/blog/original/'.$blogImage,array('width'=>400)),'#',array('escape'=>false)); 
				}else{
					echo $this->Html->link($this->Html->Image(MEDIA_URL.'/img/nologo.jpg',array('width'=>400)),'#',array('escape'=>false)); 
				}
				?>
		</div>
		<div class="blogslisitng-rgt">
			<ul>
				<li><?php echo substr($desc,0,600);?></li>
				<li><div class="more"><?php echo $this->Html->link('More',array('controller'=>'blogs','action'=>'view',$postId,$title_url),array('class'=>'more'));?></div></li>
			</ul>
		</div>
		<div class="clear"></div>
		<div>
			<div class="blogby">By: <?php echo $this->Html->link($auther_fullname,array('controller'=>'pub','action'=>$pub_profile),array());?></div>
			<div class="blog-bttns">
				<ul>
					<li>
						<?php $total_comment = $posts_inCat_Row[0]['total_comments'];?>
						<a href="/blogs/view/<?php echo $postId;?>/<?php echo $title_url;?>#names<?php echo $postId;?>">Comments
						<?php if ($total_comment !=0) echo '<span class="redcolor">('.$total_comment.')</span>'; ?></a>
					</li>
					<li>
						<?php $total_cates = '';
							foreach ($categories_posts as $post_cat_Row) {
								if ($post_cat_Row['category_posts']['post_id'] == $postId) {
									$total_cates .= $post_cat_Row['post_categories']['title'].", ";
								?>
						<?php }} $total_cates = substr_replace($total_cates ,"",-1); ?>
						<a href="#">Category:&nbsp; <?php if ($total_cates) {echo rtrim($total_cates,',');} else echo "Uncategorized";?></a>
					</li>
					
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
		
<?php }	?>
<?php }else{ echo "<div class='error_msg'>No Blog Found in this category!</div>";} ?>