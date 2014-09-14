<div class="heading">
	<div class="email-top-bttns" style="width:240px;">
	
	
		<?php 
		if($cat=='sent'){
			echo "<a title='UnDelete' class='email_trash_small' href='#UnDelete' onclick=undelete(this,'undelete'); value='".$row['msg_sent']['id']."-inbox'>UnDelete</a>";
			echo "<a title='Delete' class='email_trash_small' href='#Delete' onclick=permdelete(this,'delete'); value='".$row['msg_sent']['id']."-inbox'>Delete Permanently</a>";
		}elseif($cat=='inbox'){
			echo "<a title='UnDelete' class='email_trash_small' href='#UnDelete' onclick=undelete(this,'undelete'); value='".$row['msg_inbox']['id']."-inbox'>UnDelete</a>";
			echo "<a title='Delete' class='email_trash_small' href='#Delete' onclick=permdelete(this,'delete'); value='".$row['msg_inbox']['id']."-inbox'>Delete Permanently</a>";
		}
?>
</div>
	<h1>Message</h1>
	<div class="clear"></div>
</div>
<?php 
		if($cat=='sent'){
			$FromName = $row['ToProfile']['firstname'].'&nbsp;'.$row['ToProfile']['lastname'];
			if($row['ToProfile']['photo']){
				if(file_exists(MEDIA_PATH.'/files/user/icon/'.$row['ToProfile']['photo'])){
					$From_user_pic=MEDIA_URL.'/files/user/icon/'.$row['ToProfile']['photo'];
				}else{
					$From_user_pic=MEDIA_URL.'/img/nologo.jpg';
				}
			}else{
					$From_user_pic=MEDIA_URL.'/img/nologo.jpg';
			}
			$userprofileid = $row['ToProfile']['user_id'];

			$created = date("F j Y g:i a", strtotime($row['msg_sent']['created']));
			$messages=nl2br($row['msg_sent']['message']);
			$subject=$row['msg_sent']['subject'];
			$listing ="<div class='emaillisting-viewpage'>";
			$listing.="<div class='email-pic'>".$this->Html->link($this->Html->Image($From_user_pic),array('controller'=>'users_profiles','action'=>'userprofile/'.$userprofileid),array('escape'=>false))."</div>";
			$listing.="<div style='width:400px;float:left;'><h1>".$subject."</h1>";
			$listing.="<p>To:".$this->Html->link($FromName,array('controller'=>'users_profiles','action'=>'userprofile/'.$userprofileid),array('escape'=>false))."</p>";
			
			$listing.="<p><span class='postedon'>".$created."</span></p>";
			$listing.="</div><div class='clear'>&nbsp;</div>";
			$listing.="<div><p>".$messages."</p></div></div><div class='clear'></div>";
			echo $listing;
			
			
			if($rerow){
				$i=0;
				//pr($rerow);
				foreach($rerow as $rows){
				
				$createds = date("F j Y g:i a", strtotime($rows['msg_sent']['created']));
				
				
			
				$listings ="<div class='emaillisting-viewpage'>";

				$listings.="<p><span class='postedon'>On ".$createds." posted:</span></p>";
				$listings.="<div class='clear'>&nbsp;</div>";
				$listings.="<div><p>".nl2br($rows['msg_sent']['message'])."</p></div></div>";
				echo $listings;
				}
			}
			
		}elseif($cat=='inbox'){
			
			
			$FromName = $row['FromProfile']['firstname'].'&nbsp;'.$row['FromProfile']['lastname'];
			if($row['FromProfile']['photo']){
				if(file_exists(MEDIA_PATH.'/files/user/icon/'.$row['FromProfile']['photo'])){
					$From_user_pic=MEDIA_URL.'/files/user/icon/'.$row['FromProfile']['photo'];
				}else{
					$From_user_pic=MEDIA_URL.'/img/nologo.jpg';
				}
			}else{
					$From_user_pic=MEDIA_URL.'/img/nologo.jpg';
			}
			$userprofileid = $row['FromProfile']['user_id'];
			
			$created = date("F j Y g:i a", strtotime($row['msg_inbox']['created']));
			$messages=nl2br($row['msg_inbox']['message']);
			$subject=$row['msg_inbox']['subject'];
			$listing ="<div class='emaillisting-viewpage'>";
			$listing.="<div class='email-pic'>".$this->Html->link($this->Html->Image($From_user_pic),array('controller'=>'users_profiles','action'=>'userprofile/'.$userprofileid),array('escape'=>false))."</div>";
			$listing.="<div style='width:400px;float:left;'><h1>".$subject."</h1>";
			$listing.="<p>From:".$this->Html->link($FromName,array('controller'=>'users_profiles','action'=>'userprofile/'.$userprofileid),array('escape'=>false))."</p>";
			
			$listing.="<p><span class='postedon'>".$created."</span></p>";
			$listing.="</div><div class='clear'>&nbsp;</div>";
			$listing.="<div><p>".$messages."</p></div></div><div class='clear'></div>";
			echo $listing;
			
			
			if($rerow){
				$i=0;
				//pr($rerow);
				foreach($rerow as $rows){
				
				$createds = date("F j Y g:i a", strtotime($rows['msg_inbox']['created']));
				
				
			
				$listings ="<div class='emaillisting-viewpage'>";

				$listings.="<p><span class='postedon'>On ".$createds." posted:</span></p>";
				$listings.="<div class='clear'>&nbsp;</div>";
				$listings.="<div><p>".nl2br($rows['msg_inbox']['message'])."</p></div></div>";
				echo $listings;
				}
			}
		}
		echo '<a href="#" onclick="trashed_list();" class="save-preview">Back to trash list</a>';		
		?>

<div class="clear"></div>
