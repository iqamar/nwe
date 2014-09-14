<div class="ttle-bar effectX">Recent posts</div>
<ul>
	<?php foreach ($your_latest_posts_networkwe as $your_post__ROW) {
		$postId = $your_post__ROW['blogs']['id'];
		$full_name = $your_post__ROW['users_profiles']['firstname']." ".$your_post__ROW['users_profiles']['lastname'];
		$title_url = str_replace(" ", "-", strtolower($your_post__ROW['blogs']['post_title']));
		?>
	<li>
 		<div class="relat-jobmain-div" style="margin-top:7px;">
		  <div class="relat-job-div" style="padding-bottom:0px;">
		    <div class="relat-jobcolm" style="margin-left:0px;">
		      	<div class="relat-jobtxt" style="border-bottom:1px dotted gray; margin-bottom:5px;">
        			<h1 style="color: #086A87;width: 100%; font-size:12px;">
					<?php echo $this->Html->link(substr($your_post__ROW['blogs']['post_title'],0,60),array('controller'=>'blogs','action'=>'view',$postId,$title_url),
																					 array('style'=>' text-decoration:none;'));?></h1>
                    <span style="font-size:13px; color:#909090;"><?php echo "By You";?></span>
 				</div>
		   	</div>
  		</div>
		</div>  
	</li>	  
<?php }?>
</ul>