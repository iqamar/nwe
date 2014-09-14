 <?php 
 $strstr ="";
 if ($status == 2) {
	$strstr .= $this->Html->link('Leave','Javascript:unfollow('.$user_follow_id.','.$uid.',0,'.$group_id.')',array('class'=>'button','id'=>'follow_comp'.$group_id,'onMouseOver'=>'showUnfollow('.$group_id.')','onMouseOut'=>'hideUnfollow('.$following_id.')'));
	 }
	 else if($status == 1){
	$strstr .= $this->Html->link('Pending Request','Javascript:unfollow('.$user_follow_id.','.$uid.',1,'.$group_id.')',array('class'=>'button','style'=>'width:97px;','id'=>'unfollow_comp'.$group_id));
    }
	 else{
	$strstr .= $this->Html->link('Member','Javascript:unfollow('.$user_follow_id.','.$uid.',2,'.$group_id.')',array('class'=>'button','id'=>'unfollow_comp'.$group_id));
    }
 echo $total_following_groups."::::".$strstr;
 ?>