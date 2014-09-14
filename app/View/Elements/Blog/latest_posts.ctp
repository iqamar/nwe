<div class="ttle-bar effectX">Latest on NetworkWE</div>
<ul>
	<?php foreach ($get_latest_posts_networkwe as $lates_post__ROW) {
		$postId = $lates_post__ROW['blogs']['id'];
		$full_name = $lates_post__ROW['users_profiles']['firstname']." ".$lates_post__ROW['users_profiles']['lastname'];
		$title_url = str_replace(" ", "-", strtolower($lates_post__ROW['blogs']['post_title']));
		?>
	<li>
 		<div class="relat-jobmain-div" style="margin-top:7px;">
		  <div class="relat-job-div" style="padding-bottom:0px;">
		    <div class="relat-jobcolm" style="margin-left:0px;">
		      	<div class="relat-jobtxt" style="border-bottom:1px dotted gray; margin-bottom:5px;">
        			<h1 style="color: #086A87;width: 100%; font-size:12px;">
					<?php echo $this->Html->link(substr($lates_post__ROW['blogs']['post_title'],0,60),array('controller'=>'blogs','action'=>'view',$postId,$title_url),
																					 array('style'=>' text-decoration:none;'));?></h1>
                    <span style="font-size:13px; color:#909090;"><?php echo "By ".$full_name;?></span>
 				</div>
		   	</div>
  		</div>
		</div>  
	</li>	  
<?php }?>
</ul>