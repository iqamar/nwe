<div class="ttle-bar effectX">Latest News</div>
<div class="tabbed">
            <ul class="contents">
               <?php foreach ($get_latest_news as $latest_News_row) {
					$created_date = $latest_News_row['News']['created'];
					$year = date("Y", strtotime($created_date));
					$month = date("M", strtotime($created_date));
					$day = date("d", strtotime($created_date));
					$time = date("H:i:s", strtotime($created_date));
					$newsId = $latest_News_row['News']['id'];
					?>
                <li>
                    <?php if ($latest_News_row['News']['image_url']) {
							echo $this->Html->image('/files/news_logo/'.$latest_News_row['News']['image_url']);
					}
					else {
						echo $this->Html->image('no-image.png');
					}?>
                    <div class="info">
                        <h1><?php echo $this->Html->link(substr($latest_News_row['News']['heading'],0,110),array('controller'=>'news','action'=>'view',$newsId));?></h1>
                        <p style="font-size:11px; color:#999;"><?php if($latest_News_row['News']['created']) { echo "on ".$day." ".$month.", ".$year." at ".$time;}?></p>
                    </div>
                </li>
                <?php }?>
         </ul>
</div>