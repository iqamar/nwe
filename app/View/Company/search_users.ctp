<ul>
<?php foreach ($userSearchResult as $admin_user_row) { 
		$userID = $admin_user_row['Users_profile']['user_id'];
		if ($userID != $owner_id) {
		?>
		<li>
        <?php if (!empty($admin_user_row['Users_profile']['photo'])) {
        echo $this->Html->image(MEDIA_URL.'/files/user/original/'.$admin_user_row['Users_profile']['photo'],array('style'=>'float:left;width:40px;height:40px;','alt'=>'no-img'));
        }
        else {
		echo $this->Html->image(MEDIA_URL.'/files/user/original/no-image.png',array('style'=>'float:left;width:40px;height:40px;','alt'=>'no-img'));
		}?>
        <?php 
		echo $this->Html->link($admin_user_row['Users_profile']['firstname']." ".$admin_user_row['Users_profile']['lastname'],
																				array('controller'=>'companies','action'=>'add_admin',$userID));
		?>
        <span style="margin-left:50px;folat:right;">
		<?php
		echo $this->Form->Create('Company_user', array('url'=>'/companies/add_admin/','enctype'=>'multipart/form-data'));
		echo $this->Form->input('user_id' , array('type' => 'hidden', 'value' => $userID));
		echo $this->Form->input('company_id' , array('type' => 'hidden', 'value' => $companyid));
		echo $this->Form->submit('Add',array('div'=>false,'class'=>'savebtn','style'=>'float:right;margin-right:20px; padding-top:5px;'));
		echo $this->Form->end();
		?>
        </span>
        </li>
        <li style="clear:both;"></li>
        
<?php }}?>
</ul>
