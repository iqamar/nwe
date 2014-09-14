<div class="news">
   <div class="top_blog" style="background:#EEE; margin-bottom:12px; border:none; height:75px;">
   <h1 style="font-size:16px; color:#FF0000; font-weight:bold; padding-bottom:5px;">NetworkWE Press Center</h1>
        
    </div>
         
    <div id="loader" style="position:absolute; z-index:100px; left:36%; top:113px; text-align:center; display:none;"> 
         <?php echo $this->Html->image('loading.gif');?>	
    </div>
	<ul id="posts_listing" class="news-list">
    
   <!-- User News Start-->
		<?php
		foreach ($press_ as $press__Row) {
			echo $pressId = $press__Row['press_releases']['id'];
			$created_date = $press__Row['press_releases']['created'];
			$year = date("Y", strtotime($created_date));
			$month = date("M", strtotime($created_date));
			$day = date("d", strtotime($created_date));
			$time = date("H:i:s", strtotime($created_date));
			//$auther_fullname = $press__Row['users_profiles']['firstname']." ".$press__Row['users_profiles']['lastname'];
			//$pub_profile = $press__Row['users_profiles']['handler'];
			//$title_url = strtolower($post__Row['posts']['post_title']);
			$title_url = str_replace(" ", "-", strtolower($press__Row['News']['heading']));
			?>
		<li class="as_country_container" id="<?php echo $pressId;?>">
        	<div style="float:left;">
        		<a href="#">
            		<div class="artwork">
                		<?php 
						if ($press__Row['press_releases']['image_url']) {
							echo $this->Html->image('/files/press_logo/'.$press__Row['press_releases']['image_url'],array('style'=>'width:120px;'));
						} else {
                			echo $this->Html->image('no-image.png',array('style'=>'width:120px; height:120px;')); 
                   		  }?>
                	</div>
           		 </a>
            	
           	</div>
            <div class="info">
            	<h1><?php echo $this->Html->link($press__Row['press_releases']['headline'],array('controller'=>'press','action'=>'view',$pressId,$title_url),
																					 array('style'=>'text-decoration:none;'));?></h1>
                <h4><?php //echo "By ".$auther_fullname;?>
                <?php if ($created_date) { echo "on ".$day." ".$month.", ".$year." at ".$time; }?></h4>
                <div class="news_dt">
                	<p><?php echo substr($press__Row['press_releases']['details'],0,300);?></p>
                </div>
                <?php echo $this->Html->link('Ream More..',array('controller'=>'press','action'=>'view',$pressId,$title_url),array('class'=>'more'));?>
            </div>
		</li>
	<?php }?>
    <div id="loader" style="text-align:center;"></div>
	</ul>
   </div>