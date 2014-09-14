<div class="ttle-bar effectX">Categories</div>
<ul>
	<?php foreach ($get_total_blog_categories as $blog_category__ROW) {
		$catId = $blog_category__ROW['post_categories']['id'];
		$title_url = str_replace(" ", "-", strtolower($blog_category__ROW['post_categories']['title']));
		?>
	<li>
 		<div class="relat-jobmain-div" style="margin-top:7px;">
		  <div class="relat-job-div" style="padding-bottom:0px;">
		    <div class="relat-jobcolm" style="margin-left:0px;">
		      	<div class="relat-jobtxt" style="border-bottom:1px dotted gray; margin-bottom:5px;">
        			<h1 style="color: #086A87;width: 100%; font-size:12px;">
					<?php echo $this->Html->link($blog_category__ROW['post_categories']['title'],array('controller'=>'blogs','action'=>'category_posts',$catId,$title_url),
																					 array('style'=>' text-decoration:none;'));?></h1>
 				</div>
		   	</div>
  		</div>
		</div>  
	</li>	  
<?php }?>
</ul>