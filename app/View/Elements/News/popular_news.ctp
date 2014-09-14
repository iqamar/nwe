<div class="greybox">
	    <div class="greybox-div-heading">
				<h1>Most Read News</h1>
	    </div>
        <?php foreach ($get_popular_news as $popular_News_row) {
					$created_date = $popular_News_row['news']['created'];
					$year = date("Y", strtotime($created_date));
					$month = date("M", strtotime($created_date));
					$day = date("d", strtotime($created_date));
					$time = date("H:i:s", strtotime($created_date));
					$newsId = $popular_News_row['news']['id'];
					$title_url = str_replace(" ", "-", strtolower($popular_News_row['news']['heading']));
					?>
		<div class="rgtwidget-blogs">
            <ul> 
                <li>
				<h1><?php echo $this->Html->link(substr($popular_News_row['news']['heading'],0,110),array('controller'=>'news','action'=>'view',$newsId,$title_url));?></h1>
                    
                </li>
                <li>
               <?php if($popular_News_row['news']['created']) { echo "on ".$day." ".$month.", ".$year." at ".$time;}?>
                </li>
            </ul>
	    </div>
        <?php 
			}
		?>
		<div class="more"><?php echo $this->Html->link('more...',array('controller'=>'news','action'=>'popular'), array('class'=>''));?></div>
 </div>