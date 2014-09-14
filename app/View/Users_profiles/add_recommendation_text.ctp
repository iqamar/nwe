<?php foreach ($user_commendations_text_ajax as $rcommendations_text_Row) {
		$created_date = $rcommendations_text_Row['Users_recommendation']['created'];
		$year = date("Y", strtotime($created_date));
		$month = date("M", strtotime($created_date));
		$day = date("d", strtotime($created_date));
	?>
       <div class="recommendations">
    	<div class="profile-box-content">
    	<div class="exp-com-logo">
        	<?php 
			if ($rcommendations_text_Row['users_profiles']['photo'] && file_exists(MEDIA_PATH.'/files/user/thumbnail/'.$rcommendations_text_Row['users_profiles']['photo'])) {
				echo $this->Html->image(MEDIA_URL.'/files/user/thumbnail/'.$rcommendations_text_Row['users_profiles']['photo'],array('style'=>''));
			}
			else {
				echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>''));	

			}
			?>
        </div>
		<div class="profile-box-content-rgt">
        <ul>
            <li>
              <h1><?php echo $rcommendations_text_Row['users_profiles']['firstname']." ".$rcommendations_text_Row['users_profiles']['lastname'];?></h1>
            </li>
            <li><strong><?php echo $rcommendations_text_Row['users_profiles']['tags'];?></strong></li>
            <li>Recommendation on: <?php echo $month." ".$day.", ".$year; ?></li>
            <li>
                <?php echo $this->Html->image(MEDIA_URL.'/img/quotes1.png',array('style'=>'width:10px; height:10px;'));?>
				<?php echo $rcommendations_text_Row['Users_recommendation']['recommended_text'];?>
				 <?php echo $this->Html->image(MEDIA_URL.'/img/quotes2.png',array('style'=>'width:10px; height:10px;'));?>
			</li>
        </ul>
        </div>
		<div class="clear"></div>
	</div>
    </div>
  <?php }?>