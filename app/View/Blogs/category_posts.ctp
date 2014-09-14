  <?php foreach ($posts_in_category as $posts_inCat_Row) {
			$postId = $posts_inCat_Row['blogs']['id'];
			$created_date = $posts_inCat_Row['blogs']['created'];
			$year = date("Y", strtotime($created_date));
			$month = date("M", strtotime($created_date));
			$day = date("d", strtotime($created_date));
			$auther_fullname = $posts_inCat_Row['users_profiles']['firstname']." ".$posts_inCat_Row['users_profiles']['lastname'];
			$title_url = str_replace(" ", "-", strtolower($posts_inCat_Row['posts']['post_title']));
			?>
		<li id="" class="as_country_container" style="clear:both; padding:0px;">
        	<div style="padding:10px;">
			<p class="post_date">
               <span class="month"><?php echo $month;?></span>
               <span class="day"><?php echo $day;?></span>
               <span class="year"><?php echo $year;?></span>     
            </p>
			<div class="pst-desc" style="float:left; width:91%;">
				<h2 style="font-weight:bold; font-size:13px; margin-bottom:8px;">
                <?php echo $this->Html->link($posts_inCat_Row['blogs']['post_title'],array('controller'=>'blogs','action'=>'view',$postId,$title_url),
																					 array('style'=>' text-decoration:none;'));?>
				</h2>
				<div style="float:left; margin-bottom:10px;">
					<?php echo substr($posts_inCat_Row['blogs']['description'],0,600);?>
                   <?php echo $this->Html->link('More..',array('controller'=>'blogs','action'=>'view',$postId,$title_url),array('style'=>' float:right; text-decoration:none;'));?>
				</div>
                <div style="clear:both;"></div>
			</div>
            </div>
            <div class="post_author">
            	<a>By: <?php echo $auther_fullname;?></a>
                <a style=" margin-left:24px; float:right;">Category:&nbsp; <?php echo $posts_inCat_Row['post_categories']['title'];?></a>
                <a href="/blogs/view/<?php echo $postId;?>/<?php echo $title_url;?>#names<?php echo $postId;?>" style=" margin-left:24px; float:right;">Comments</a>
            </div>

		</li>
	<?php }?>