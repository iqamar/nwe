<div class="heading">
	<div class="email-top-bttns" style="width:200px;">
		<?php 
			echo "<a title='Reply' class='email_reply_small' href='#Reply' onclick=msg_reply(this,'sent'); value='".$row['msg_sent']['id']."'>Reply</a>";
			echo "<a title='Forward' class='email_forward_small' href='#Forward' onclick=msg_forward(this,'sent'); value='".$row['msg_sent']['id']."'>Forward</a>";
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
			$sendtoname=$row['FromProfile']['firstname'].' '.$row['FromProfile']['lastname'];
			echo "<a title='Delete' class='email_trash_small' href='#Delete' onclick=msg_trash(this,'sent'); value='".$row['msg_sent']['id']."'>Trash</a>";
						
		?>
		
	</div>
	<h1>Message</h1>
	<div class="clear"></div>
</div>

<?php
		
		$created = date("F j Y g:i a", strtotime($row['msg_sent']['created']));
		
		//$message = strip_tags($row['msg_sent']['message'],'');
		//$messages=substr($message,0,150);
		
	
		$listing ="<div class='emaillisting-viewpage'>";
		$listing.="<div class='email-pic'>".$this->Html->link($this->Html->Image($From_user_pic),array('controller'=>'users_profiles','action'=>'userprofile/'.$userprofileid),array('escape'=>false))."</div>";
		$listing.="<div style='width:400px;float:left;'><h1>".$row['msg_sent']['subject']."</h1>";
		$listing.="<p>".$this->Html->link($FromName,array('controller'=>'users_profiles','action'=>'userprofile/'.$userprofileid),array('escape'=>false))."</p>";
		$listing.="<p><span class='postedon'>".$sendtoname."</span></p>";
		$listing.="<p><span class='postedon'>".$created."</span></p>";
		$listing.="</div><div class='clear'>&nbsp;</div>";
		$listing.="<div><p>".nl2br($row['msg_sent']['message'])."</p></div></div><div class='clear'></div>";
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
		echo '<a href="#" onclick="msg_sent();" class="save-preview">Back</a>';
				
?>

<div class="clear"></div>
