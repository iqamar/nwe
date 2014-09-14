<?php
$contstr ="";
if ($connection != '') {
	if ($status == 2) {
        $contstr .= '<a href="Javascript:userFollow(\'0\',\''.$id.'\',\''.$contact_id.'\');" class ="unfollow" id="following_user" style="display:block;">Following</a>';
                  } else{
         $contstr .= '<a href="Javascript:userFollow(\'2\',\''.$id.'\',\''.$contact_id.'\');" class ="follow" id="follow_user" style="display:block;">Follow</a>';
                  }
		echo $totalFollows.'-'.$contstr;	
}
else if ($following_type == 'users'){
	if ($status == 2) {
       		 $contstr .= '<a href="Javascript:userFollow(\'0\',\''.$id.'\');" class ="unfollow" id="following_user" style="display:block;">Following</a>';
     } else{
         	$contstr .= '<a href="Javascript:userFollow(\'2\',\''.$id.'\');" class ="follow" id="follow_user" style="display:block;">Follow</a>';
       }
		echo $totalFollows.'-'.$contstr;	
}
else {
echo $totalFollows;
}
?>