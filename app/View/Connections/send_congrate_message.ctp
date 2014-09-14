<?php 
	foreach ($whoSendYouCongrats as $cong_Row) {
?>
		<div class="comment-listing" id="commentsbox">
			<div class="comment-listing-pic">
				<a href="#">
					<?php if ($cong_Row['users_profiles']['photo']) {
								echo $this->Html->image(MEDIA_URL.'/files/user/original/'.$cong_Row['users_profiles']['photo'],
																								array('style'=>'width:32px; height:32px;'));
							}
						  else { 	
								echo $this->Html->image(MEDIA_URL.'/img/defaultpic-female.jpg',array('style'=>'width:32px; height:32px;')); 
						}
					?>
				</a> 
			</div>
			<div class="comment-listing-rgt">
				<ul>
					<li>
					<a href="#">
					<?php echo $cong_Row['users_profiles']['firstname']." ".$cong_Row['users_profiles']['lastname'];?>
					</a> 
					<?php echo substr($cong_Row['users_messages']['user_message'],0,350);?>
					 </li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
<?php }?>