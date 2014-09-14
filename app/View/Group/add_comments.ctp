<?php  $strstr ="";
	foreach ($comments_this_groups as $comment__row) {
				$full_name = $comment__row['users_profiles']['firstname']." ".$comment__row['users_profiles']['lastname'];
				$created_date = $comment__row['entity_comments']['created'];
				$year = date("Y", strtotime($created_date));
				$month = date("M", strtotime($created_date));
				$day = date("d", strtotime($created_date));
				$commentid = $comment__row['entity_comments']['id'];
				$time = date("H:i:s", strtotime($created_date));
				$handler = $comment__row['users_profiles']['handler'];
				$user_photo = $comment__row['users_profiles']['photo'];
				$user_id = $comment__row['entity_comments']['user_id'];
	
		$strstr .= '<div class="comment-listing" id="commentsbox'.$commentid.'">
                <div class="comment-listing-pic">
                    <a href="/pub/'.$handler.'">'; 
                        if ($user_photo) {
                           $strstr .= $this->Html->image(MEDIA_URL.'/files/user/icon/'.$user_photo,array('alt'=>'no photo'));
                        }
                        else {
                            $strstr .= $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'no photo'));
                        }

        $strstr .= '</a>
                </div>
                <div class="comment-listing-rgt">
                <ul>
                    <li>
                    <a href="/pub/'.$handler.'">'.$full_name.'</a>&nbsp;&nbsp;'.$comment__row['entity_comments']['comments'];
                    if ($user_id == $uid || $company_admin_id == $uid) {
        $strstr .= '<a href="javascript:" onclick="delete_comment('.$commentid.','.$content_id.');" class="comment-close" title="Delete Update"></a>';
                    }                               
        $strstr .= '</li>
                    <li><span class="posttime">'.$day." ".$month.", ".$year."  @ ".$time.'</span></li>
                </ul>
                </div>
                <div class="clear"></div>
         </div>';
	 }
   echo $total_commentsOnUpdate."::::".$strstr;
 ?>