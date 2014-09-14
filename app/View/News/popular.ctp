<script>
$(document).ready(function(){ 
	$(window).scroll(function(){ 
		var WindowHeight = $(window).height(); 
		if ($(window).scrollTop() == $(document).height() - $(window).height()){ 
			$("#loader").html("<img src='<?php echo $this->base;?>/img/loading_icon.gif' alt='loading'/>"); 
			var LastDiv = $(".as_country_container:last"); 
			var LastId  = $(".as_country_container:last").attr("id"); 
			var ValueToPass = "lastid="+LastId; 
			$.ajax({ 
			type: "POST",
			url: baseUrl+"/news/popular_news_ajax",
			data    : {lastid:LastId},
			cache: false,
				success: function(html){
					$("#loader").html("");
					if(html){
						LastDiv.after(html); 
					}
				}
			});
			return false;
		}
		return false;
	});
});</script>
<div class="clear"></div>
<?php echo $this->Session->flash(); ?>
<div class="clear"></div>
<div id="posts_listing">
	<div class="boxheading">
		<h1>Most Read News</h1>
		<div class="boxheading-arrow"></div>
	</div>
		<?php
		foreach ($get_popular_news as $news__Row) {
			$newsId = $news__Row['news']['id'];
			$created_date = $news__Row['news']['created'];
			$year = date("Y", strtotime($created_date));
			$month = date("M", strtotime($created_date));
			$day = date("d", strtotime($created_date));
			$time = date("H:i:s", strtotime($created_date));
			$auther_fullname = $news__Row['users_profiles']['firstname']." ".$news__Row['users_profiles']['lastname'];
			$pub_profile = $news__Row['users_profiles']['handler'];
			//$title_url = strtolower($post__Row['posts']['post_title']);
			$title_url = str_replace(" ", "-", strtolower($news__Row['news']['heading']));
			?>
		<div class="blogslisitng" id="<?php echo $newsId;?>">
			<div class="blogdate"> <span><?php echo $day;?></span> <span class="smalltext"><?php echo $month;?></span><br />
			<span class="smalltext"><?php echo $year;?></span> </div>
			<div class="blogtopdiv">
				<div class="blogtitle">
				  <h1><?php echo $this->Html->link($news__Row['news']['heading'],array('controller'=>'news','action'=>'view',$newsId,$title_url),array('style'=>'text-decoration:none;'));?></h1>
				</div>
			</div>
			<div class="blogslisitng-pic">
				<?php 
				if ($news__Row['news']['image_url']) {
					
					echo $this->Html->link($this->Html->Image(MEDIA_URL.'/files/news/original/'.$news__Row['news']['image_url'],array('width'=>400)),'#',array('escape'=>false)); 
				} else {
					
					echo $this->Html->link($this->Html->Image(MEDIA_URL.'/img/nologo.jpg',array('width'=>400)),'#',array('escape'=>false)); 
				  }?>
			</div>
			<div class="blogslisitng-rgt">
				<ul>
					<li><?php echo substr($news__Row['news']['details'],0,300);?></li>
					<li><div class="more"><?php echo $this->Html->link('More',array('controller'=>'news','action'=>'view',$newsId,$title_url),array('class'=>'more'));?></div></li>
				</ul>
			</div>
			<div class="clear"></div>
			<div>
				<div class="blogby"><?php echo "By ".$auther_fullname;?>
					<?php if ($created_date) { echo "on ".$day." ".$month.", ".$year." at ".$time; }?></div>
				
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	<?php }?>
    
</div>
<div id="loader" style="position:absolute; z-index:100px; left:36%; top:300px; text-align:center; display:none;"> 
	<?php echo $this->Html->Image(MEDIA_URL.'/img/loading.gif');?>	
</div>