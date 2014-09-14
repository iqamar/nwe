<?php foreach($user_experience as $exp__Row){
		$exp_id = $exp__Row['users_experiences']['id'];
		$start_date = $exp__Row['users_experiences']['start_date'];
		if ($exp__Row['users_experiences']['end_date'] != 'Present') {
			$end_date = $exp__Row['users_experiences']['end_date'];
		}
		else {
			$end_date = $exp__Row['users_experiences']['end_date'];
		}
?>
		 <div class="profile-box-content" id="<?php echo $exp_id;?>">
			<div class="exp-com-logo">
				<?php if ($exp__Row['companies']['logo']) {
                    echo $this->Html->image(MEDIA_URL .'/files/company/original/'.$exp__Row['companies']['logo'],
                                                                                                    array('style'=>'width:60px; height:60px; float:right;'));
                }
                else {
                    echo $this->Html->image(MEDIA_URL .'/img/nologo.jpg',array('style'=>'width:60px; height:60px; float:right;'));	
                }?>
            </div>
            <div class="profile-box-content-rgt">
                <ul>
                    <li>
                        <h1><a href="#"><?php echo $exp__Row['users_experiences']['designation'];?></a></h1>
                    </li>
                    <li>
                        <a href="#"><?php echo $exp__Row['companies']['title'];?></a>
                    </li>
                    <li><?php echo $start_date." - ".$end_date;?> - <?php echo $exp__Row['users_experiences']['location']; ?></li>
                    <li><a href="#?" rel="editExp" onclick="edit_exp('<?php echo $exp_id; ?>')" class="poplight edit">Edit</a> <a href="javascript:;" onclick="delete_exp('<?php echo $exp_id;?>');" class="delete">Remove</a></li>
                </ul>
            </div>
    	<div class="clear"></div>
	</div>
<?php }?>