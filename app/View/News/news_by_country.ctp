  <?php foreach ($news_per_country as $news_inCat_Row) {
			$newsId = $news_inCat_Row['news']['id'];
			$created_date = $news_inCat_Row['news']['created'];
			$year = date("Y", strtotime($created_date));
			$month = date("M", strtotime($created_date));
			$day = date("d", strtotime($created_date));
			$time = date("H:i:s", strtotime($created_date));
			$auther_fullname = $news_inCat_Row['users_profiles']['firstname']." ".$news_inCat_Row['users_profiles']['lastname'];
			//$pub_profile = $posts_inCat_Row['users_profiles']['handler'];
			$title_url = str_replace(" ", "-", strtolower($news_inCat_Row['news']['heading']));
			?>
		<div class="blogslisitng" id="<?php echo $newsId;?>">
			<div class="blogdate"> <span><?php echo $day;?></span> <span class="smalltext"><?php echo $month;?></span><br />
			<span class="smalltext"><?php echo $year;?></span> </div>
			
			<div class="blogslisitng-pic">
				<?php 
				if ($news_inCat_Row['news']['image_url']) {
					
					echo $this->Html->link($this->Html->Image(MEDIA_URL.'/files/news/logo/'.$news_inCat_Row['news']['image_url']),'#',array('escape'=>false)); 
				} else {
					
					echo $this->Html->link($this->Html->Image(MEDIA_URL.'/img/nologo.jpg'),'#',array('escape'=>false)); 
				  }?>
			</div>
			<div class="blogslisitng-rgt">
				<div class="blogtopdiv1" style="margin:5px 60px 15px 0px;">
				  <h1><?php echo $this->Html->link($news_inCat_Row['news']['heading'],array('controller'=>'news','action'=>'view',$newsId,$title_url),array('style'=>'text-decoration:none;'));?></h1>
				</div>
				<ul>
					<li><?php echo substr(strip_tags($news_inCat_Row['news']['details']),0,250);?></li>
					<li><div class="more"><?php echo $this->Html->link('More',array('controller'=>'news','action'=>'view',$newsId,$title_url),array('class'=>'more'));?></div></li>
				</ul>
			</div>
			<div class="clear"></div>
			<div>
				<?php
				if($userInfo['users']['id'] == $news_inCat_Row['news']['user_id']){
				?>
				<div class="blogby">
					<?php echo $this->Html->link('Edit',array('controller'=>'news','action'=>'edit_article',$newsId,$title_url),array('class'=>'edit_post'));?>
					
					<?php echo $this->Html->link('Delete',array('controller'=>'news','action'=>'delete_article',$newsId,$title_url),array('class'=>'delete_post','onClick'=> 'return confirm("Are you sure?")'));?>
				</div>
				<?php }?>
				<div class="articles-bttns"><?php echo "By ".$auther_fullname;?>
					<?php if ($created_date) { echo "on ".$day." ".$month.", ".$year." at ".$time; }?></div>
				
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	<?php }?>