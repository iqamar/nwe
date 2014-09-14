<div id="loadings" style="position:absolute; z-index:100px; left:50%; top:50%; text-align:center; display:none;"> 
    <?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>	
</div>
<?php 
	foreach ($getTotalUserShared as $cgetuser) {
		$userId = $cgetuser['users_profiles']['user_id'];
?>
	<div class="profile-connections">
		<div class="profile-connections-pic">
			<?php 
	
			if ($cgetuser['users_profiles']['photo']){
				if(file_exists(MEDIA_PATH.'/files/user/icon/'.$cgetuser['users_profiles']['photo'])){
					$ustatus_photo=MEDIA_URL.'/files/user/icon/'.$cgetuser['users_profiles']['photo'];
				}else{
					$ustatus_photo=MEDIA_URL.'/img/nophoto.jpg';
				}
			 }
			 else { 	
					$ustatus_photo=MEDIA_URL.'/img/nophoto.jpg'; 
			 }
			 echo $this->Html->image($ustatus_photo,array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$userId)));
			
			
			
		  ?>
		</div>
		<div class="profile-connections-rgt">
			<ul>
				<li>
					<h1><?php echo $this->Html->link($cgetuser['users_profiles']['firstname']." ".$cgetuser['users_profiles']['lastname'],
																															array(
																												'controller'=>'users_profiles',
																												'action' => 'userprofile',
																												$userId));?></h1>
				</li>
				<li><?php echo substr($cgetuser['users_profiles']['tags'],0,40);?></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
<?php } ?>
                     