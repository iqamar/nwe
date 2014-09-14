<?php 
 foreach ($get_popular_news_ajax as $news__Row) { 
		$newsId = $news__Row['news']['id']; 
		$created_date = $news__Row['news']['created'];
		$year = date("Y", strtotime($created_date));
		$month = date("M", strtotime($created_date));
		$day = date("d", strtotime($created_date));
		$time = date("H:i:s", strtotime($created_date));
		$auther_fullname = $news__Row['users_profiles']['firstname']." ".$news__Row['users_profiles']['lastname'];
		$pub_profile = $news__Row['users_profiles']['handler'];
		$title_url = str_replace(" ", "-", strtolower($news__Row['news']['heading']));
	?>
			<li class="as_country_container" id="<?php echo $newsId;?>">
        	<div style="float:left;">
        		<a href="#">
            		<div class="artwork">
                		<?php 
						if ($news__Row['news']['image_url']) {
							echo $this->Html->image('/files/news_logo/'.$news__Row['news']['image_url'],array('style'=>'width:150px;'));
						} else {
                			echo $this->Html->image('no-image.png',array('style'=>'width:150px; height:150px;')); 
                   		  }?>
                	</div>
           		 </a>
            	
           	</div>
            <div class="info">
            	<h1><?php echo $this->Html->link($news__Row['news']['heading'],array('controller'=>'news','action'=>'view',$newsId,$title_url),
																					 array('style'=>'text-decoration:none;'));?></h1>
                <h4><?php echo "By ".$auther_fullname;?>
                <?php if ($created_date) { echo "on ".$day." ".$month.", ".$year." at ".$time; }?></h4>
                <div class="news_dt">
                	<!--<p><?php //echo substr($news__Row['News']['details'],0,300);?></p>-->
                </div>
                <?php echo $this->Html->link('Ream More..',array('controller'=>'news','action'=>'view',$newsId,$title_url),array('class'=>'more'));?>
            </div>
		</li>
<?php }?>