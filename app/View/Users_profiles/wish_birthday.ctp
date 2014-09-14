<?php foreach ($birthday_messages as $birthday_row) { 
		$user_id = $birthday_row['users_profiles']['user_id'];
		$fullanme = $birthday_row['users_profiles']['firstname']." ".$birthday_row['users_profiles']['lastname'];
		$photo = $birthday_row['users_profiles']['photo'];
		$birth_date = $birthday_row['users_profiles']['birth_date'];
		$date_created = $birthday_row['users_messages']['created'];
		$today = strtotime(date('Y-m-d H:i:s'));
		$distination = strtotime($date_created);
		$difference = ($today - $distination);
		$days = floor($difference/(60*60*24));
		$hours = floor($difference/(60*60));
	?>
	<div class="comment-listing" id="commentsbox">
        	<div class="comment-listing-pic">
            	 <?php if ($photo && file_exists(MEDIA_PATH.'/files/user/icon/'.$photo)) {
									echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$photo,array('alt'=>'post-img'));
							  }
							  else { 	
									echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>'','alt'=>'post-img')); 
							 }
					  ?> 
            </div>
             <div class="comment-listing-rgt">
                <ul>
                    <li>
                    
                    <a href="#"><?php echo $fullanme;?></a> 
                    <?php echo $birthday_row['users_messages']['user_message'];?> 
                    <span class="timecount"><?php if ($days >=1) echo $days."d"; else echo $hours."h"; ?></span>
                    </li>
                </ul>
            </div>
           <div class="clear"></div>
        </div>
<?php } ?>