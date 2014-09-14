<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=239132809574955";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<?php foreach ($press_detail as $press_single_Row) {
		$auther_fullname = $press_single_Row['users_profiles']['firstname']." ".$press_single_Row['users_profiles']['lastname'];
		$pressId = $press_single_Row['press_releases']['id'];
		$created_date = $press_single_Row['press_releases']['created'];
		$year = date("Y", strtotime($created_date));
		$month = date("M", strtotime($created_date));
		$day = date("d", strtotime($created_date));
		$time = date("H:i:s", strtotime($created_date));
		$pub_profile = $press_single_Row['users_profiles']['handler'];
		$title_url = str_replace(" ", "-", strtolower($press_single_Row['press_releases']['headline']));
	?>
<div class="news_detail">
	<div class="info">
    	<h1><?php echo $press_single_Row['press_releases']['headline'];?></h1>
        <h4><?php echo "By: ".$auther_fullname." on ".$day." ".$month.", ".$year." at ".$time;?></h4>
    </div>
   <?php if ($press_single_Row['press_releases']['image_url']) {
	   		echo $this->Html->image('/files/press_logo/'.$press_single_Row['press_releases']['image_url'],array('style'=>'float:none;'));
   		 }
		 else {
			 echo $this->Html->image('no-image.png',array('style'=>'float:none;'));
		 }
	   ?>
    <div class="detail">
    	<p></p>
        <p><?php echo $press_single_Row['press_releases']['details'];?></p>
        <ul class="related" style=" position:relative; overflow:hidden;">
        	<li>
            <strong>Contact information</strong> <br />
            <a href="mailto:press@networkwe.com">press@networkwe.com</a>
            <p><?php echo $press_single_Row['press_releases']['contact_info'];?></p>
            </li>
        </ul>
        <ul class="related" style=" position:relative; overflow:hidden;">
        	<li>
            <strong>Organization information</strong> <br />
            <p><?php echo $press_single_Row['press_releases']['organization_info'];?></p>
            </li>
        </ul>
        <ul class="related">
        	<li>
                            <a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Tweet</a>
                            </li>
                            <li>
                            <div class="fb-like" data-href="https://dev.networkwe.com/press_releases/view/<?php echo $pressId;?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                            </li>
        	<li style="float:right; width:300px;">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo $this->Html->link('Download Press as PDF',array('action'=>'press_pdf','ext'=>'pdf',$pressId),array('class'=>'savebtn','target'=>'_blank'));?>
            </li>
        </ul>
    </div>
    <div style="clear:both;"></div>
</div>
 
<?php }?>