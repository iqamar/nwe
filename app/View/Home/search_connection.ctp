<div id="loadings" style="position:absolute; z-index:100px; left:50%; top:50%; text-align:center; display:none;"> 
                        	<?php echo $this->Html->image('loading.gif');?>	
                        </div>
<ul style="width:300px; padding:0; margin:0; background:none;">
<?php foreach ($search_Result_People as $search_people_row) { 
		$userEmail = $search_people_row['users']['email'];
		$firstname = $search_people_row['Users_profile']['firstname'];
		$fullname = $search_people_row[0]['fullname'];
		
		?>
		<li style="cursor:pointer;" onclick="return assignConnection('<?php echo $fullname;?>','<?php echo $userEmail;?>')">
        <?php if ($search_people_row['Users_profile']['photo']) {
        echo $this->Html->image('/files/users/'.$search_people_row['Users_profile']['photo'],array('style'=>'float:left;','alt'=>'no-img'));
        }
        else {
		echo $this->Html->image('no-image.png',array('style'=>'float:left;','alt'=>'no-img'));
		}?>
        <?php 
		echo $fullname;
		?>
        </li>
<?php }?>
</ul>