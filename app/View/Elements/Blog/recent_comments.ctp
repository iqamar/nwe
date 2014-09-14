<div class="ttle-bar effectX">Recent comments</div>
<ul>
	<?php foreach ($get_latest_posts_comments as $post_comment__ROW) {
		$postId = $post_comment__ROW['blogs']['id'];
		$full_name = $post_comment__ROW['users_profiles']['firstname']." ".$post_comment__ROW['users_profiles']['lastname'];
		$title_url = str_replace(" ", "-", strtolower($post_comment__ROW['blogs']['post_title']));
		$hash = "#names".$postId;
		?>
	<li>
 		<div class="relat-jobmain-div" style="margin-top:7px;">
		  <div class="relat-job-div" style="padding-bottom:0px;">
		    <div class="relat-jobcolm" style="margin-left:0px;">
		      	<div class="relat-jobtxt" style="border-bottom:1px dotted gray; margin-bottom:5px;">
                 <span style="font-size:13px; color:#909090; float:left;"><?php echo $full_name." on  ";?></span>
        			<h1 style="color: #086A87;width: 100%; font-size:12px;">
                    <a href="/blogs/view/<?php echo $postId;?>/<?php echo $title_url.$hash;?>" style="text-decoration:none; margin-left:3px;">
					<?php echo substr($post_comment__ROW['blogs']['post_title'],0,45);?></a></h1>
 				</div>
		   	</div>
  		</div>
		</div>  
	</li>	  
<?php }?>
</ul>