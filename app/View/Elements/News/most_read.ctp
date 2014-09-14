<?php echo $this->Html->script(array('jquery-1.10.2.js','jquery-ui-1.10.4.custom.js'));?>
<script type="text/javascript" src="/js/jquery.bxslider.min.js"></script>
<script>
	$(function() {
		
		$( "#tabs" ).tabs();


	});
	</script>
    <style>

	</style>
<div class="ttle-bar effectX">Most Read News</div>
<div class="tabbed">
	<div id="tabs">
        <ul class="tabs">
            <li class="active">
                <a href="#tabs-1" class="active">7 Days</a>
            </li>
            <li>
                <a href="#tabs-2">30 Days</a>
            </li>
            <li class="last">
                <a href="#tabs-3">90 Days</a>
            </li>
        </ul>
    	<div id="tabs-1">
            <ul class="contents">
            	<?php foreach ($get_one_week_news as $week_News_row) {
					$created_date = $week_News_row['news']['created'];
					$year = date("Y", strtotime($created_date));
					$month = date("M", strtotime($created_date));
					$day = date("d", strtotime($created_date));
					$time = date("H:i:s", strtotime($created_date));
					$newsId = $week_News_row['news']['id'];
					$title_url = str_replace(" ", "-", strtolower($week_News_row['news']['heading']));
					?>
                <li>
                    <?php if ($week_News_row['news']['image_url']) {
							echo $this->Html->image('/files/news_logo/'.$week_News_row['news']['image_url'],array('url'=>array(
																													'controller'=>'news','action'=>'view',$newsId,$title_url)));
					}
					else {
						echo $this->Html->image('no-image.png',array('url'=>array('controller'=>'news','action'=>'view',$newsId)));
					}?>
                    <div class="info">
                        <h1><?php echo $this->Html->link(substr($week_News_row['news']['heading'],0,110),array('controller'=>'news','action'=>'view',$newsId));?></h1>
                        <p style="font-size:11px; color:#999;"><?php if($week_News_row['news']['created']) { echo "on ".$day." ".$month.", ".$year." at ".$time;}?></p>
                    </div>
                </li>
                <?php }?>
            </ul>
   	   </div>
       <div id="tabs-2">
            <ul class="contents">
                <?php foreach ($get_one_month_news as $month_News_row) {
					$created_date = $month_News_row['news']['created'];
					$year = date("Y", strtotime($created_date));
					$month = date("M", strtotime($created_date));
					$day = date("d", strtotime($created_date));
					$time = date("H:i:s", strtotime($created_date));
					$newsId = $month_News_row['news']['id'];
					$title_url = str_replace(" ", "-", strtolower($month_News_row['news']['heading']));
					?>
                <li>
                    <?php if ($month_News_row['news']['image_url']) {
							echo $this->Html->image('/files/news_logo/'.$month_News_row['news']['image_url']);
					}
					else {
						echo $this->Html->image('no-image.png');
					}?>
                    <div class="info">
                        <h1><?php echo $this->Html->link(substr($month_News_row['news']['heading'],0,110),array('controller'=>'news','action'=>'view',$newsId,
																												$title_url));?></h1>
                        <p style="font-size:11px; color:#999;"><?php if($month_News_row['news']['created']) { echo "on ".$day." ".$month.", ".$year." at ".$time;}?></p>
                    </div>
                </li>
                <?php }?>
            </ul>
   	   </div>
       <div id="tabs-3">
            <ul class="contents">
               <?php foreach ($get_three_month_news as $threemonth_News_row) {
					$created_date = $threemonth_News_row['news']['created'];
					$year = date("Y", strtotime($created_date));
					$month = date("M", strtotime($created_date));
					$day = date("d", strtotime($created_date));
					$time = date("H:i:s", strtotime($created_date));
					$newsId = $threemonth_News_row['news']['id'];
					$title_url = str_replace(" ", "-", strtolower($threemonth_News_row['news']['heading']));
					?>
                <li>
                    <?php if ($threemonth_News_row['news']['image_url']) {
							echo $this->Html->image('/files/news_logo/'.$threemonth_News_row['news']['image_url']);
					}
					else {
						echo $this->Html->image('no-image.png');
					}?>
                    <div class="info">
                        <h1><?php echo $this->Html->link(substr($threemonth_News_row['news']['heading'],0,110),array('controller'=>'news','action'=>'view',$newsId,
																													 $title_url));?></h1>
                        <p style="font-size:11px; color:#999;"><?php if($threemonth_News_row['news']['created']) { echo "on ".$day." ".$month.", ".$year." at ".$time;}?></p>
                    </div>
                </li>
                <?php }?>
            </ul>
   	   </div>
    </div>
</div>