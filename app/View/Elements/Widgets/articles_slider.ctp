<div id="page-wrap">
<div class="article_section_heading">
	<?php echo $this->Html->link('See more',array('controller'=>'news','action'=>'index'),array('escape'=>false,'class'=>'seemore-tag'));?>
	<div class="article_section_heading">
	  <h3>NetworkWe recommends these articles for you</h3>
	</div>
	<div class="slider-wrap-div">
		<div class="slider-wrap">
			<div id="main-photo-slider" class="csw">
				<div class="panelContainer">
				 <!-- News panel start -->
					<?php $i=1; foreach ($postsSubmittedByUsers as $userPost) {
						$auther_name = $userPost['users_profiles']['firstname']." ".$userPost['users_profiles']['lastname'];
						$news_img = $userPost['news']['image_url'];
						$newsId = $userPost['news']['id'];
						$title_url = substr(str_replace(" ", "-", strtolower($userPost['news']['heading'])),0,25);
						$created_date = $userPost['news']['created'];
						$year = date("Y", strtotime($created_date));
						$month = date("M", strtotime($created_date));
						$day = date("d", strtotime($created_date));
					?>
					<div class="panel" title="Panel <?php echo $i;?>">
						<div class="">
							<div class="article-pic">
							<?php 
						  
							 if ($userPost['news']['image_url']){
								if(file_exists(MEDIA_PATH.'/files/news/logo/'.$userPost['news']['image_url'])){
									$newsimg_photo=MEDIA_URL.'/files/news/logo/'.$news_img;
								}else{
									$newsimg_photo=MEDIA_URL.'/img/nopic_big.jpg';
								}
							}
							else { 	
								$newsimg_photo=MEDIA_URL.'/img/nopic_big.jpg'; 
							}
							echo $this->Html->image($newsimg_photo,array('class'=>'nav-thumb-img','url'=>array('controller'=>'news','action'=>'view',$newsId,$title_url)));
							 ?>
							</div>
							<div class="article-rgt">
								<p><?php echo $this->Html->link($userPost['news']['heading'],array('controller'=>'news','action'=>'view',$newsId,$title_url),array('class'=>'articleby','escape'=>false));?></p>
								<p><?php echo substr(strip_tags($userPost['news']['details']),0,100).' ..'; ?></p>
								<div class="more"><?php echo $this->Html->link('more',array('controller'=>'news','action'=>'view',$newsId,$title_url),array('escape'=>false,'style'=>'color:#C70000;'));?></div>
							</div>	
						</div>
					</div>
					
					<?php $i++; }?>
					<!-- News panel end -->
				</div>
			</div>
			<div id="movers-row">
			<?php $j=1; foreach ($postsSubmittedByUsers as $userNews) { 
					$news_small_img = $userNews['news']['image_url'];
					$newsId = $userNews['news']['id'];
					$title_url = substr(str_replace(" ", "-", strtolower($userNews['news']['heading'])),0,25);
				?>
				
				
				<div>
					<a href="<?php echo NETWORKWE_URL.'/news/view/'.$newsId.'/'.$title_url;?>" class="cross-link active-thumb">
						
						<span class="nav-thumb" alt="temp-thumb">
							<?php 
								 if ($userNews['news']['image_url']){
									if(file_exists(MEDIA_PATH.'/files/news/icon/'.$userNews['news']['image_url'])){
										$newssmall_photo=MEDIA_URL.'/files/news/icon/'.$news_small_img;
									}else{
										$newssmall_photo=MEDIA_URL.'/img/nopic_big.jpg';
									}
									
								}
								else { 	
								   $newssmall_photo=MEDIA_URL.'/img/nopic_big.jpg';
								}
								echo $this->Html->image($newssmall_photo,array('class'=>'nav-thumb-img'));
							?>
						
						<?php
							$news_title=  $userNews['news']['heading'];
							if(strlen($news_title) >=15){
								$news_title_nw=substr ($news_title, 0, 15) . "...";
							}
							else{
								$news_title_nw=$news_title;
							}
							echo $news_title_nw;
						?>
						
						</span>
						
					</a>
				</div>
				<?php $j++; }?>
		</div>
    </div>
     <div class="clear"></div>
	</div>
    <div class="clear"></div>
</div>
 </div>
 <!-- page wrap end -->
 <div class="clear"></div>
