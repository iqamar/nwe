 <?php 
 $strstr ="";
 if ($status == 2) {
	$strstr .= $this->Html->link('Following','Javascript:unfollow('.$user_follow_id.','.$uid.',0,'.$company_id.')',array('class'=>'button','id'=>'follow_comp'.$company_id,'onMouseOver'=>'showUnfollow('.$company_id.')','onMouseOut'=>'hideUnfollow('.$following_id.')'));
	 }
	 else{
	$strstr .= $this->Html->link('Follow','Javascript:unfollow('.$user_follow_id.','.$uid.',2,'.$company_id.')',array('class'=>'button','id'=>'unfollow_comp'.$company_id));
 }
 echo $total_following_companies."::::".$strstr;
 ?>