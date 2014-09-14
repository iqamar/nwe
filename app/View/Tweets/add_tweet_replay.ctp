<?php 	 $strstr ="";
		foreach ($user_tweet_comments as $comms) {
				$comment_user = $comms['Tweet_comment']['user_id'];
				$comment_id = $comms['Tweet_comment']['id'];
				$created_date = $comms['Tweet_comment']['created'];
				$day = date("d",strtotime($created_date));
				$month = date("m",strtotime($created_date));
				$year = date("Y",strtotime($created_date));
				$time = date("H:i:s",strtotime($created_date));
		
$strstr .='<div class="comment-listing" id="commentsbox'.$comment_id.'">
                <div class="comment-listing-pic">
                	<a href="/users_profiles/userprofile/'.$comms['users_profiles']['user_id'].'">';
					    if ($comms['users_profiles']['photo']) {
                            if (file_exists(MEDIA_PATH.'/files/user/icon/'.$comms['users_profiles']['photo'])) {
                            $strstr .= $this->Html->image(MEDIA_URL.'/files/user/icon/'.$comms['users_profiles']['photo'],array('style'=>''));
							}
							else {
							$strstr .= $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>''));
							}
                        }
                        else {
                           $strstr .= $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>''));
                        }
 	 $strstr .= '</a> 
                </div>
				<div class="comment-listing-rgt">
                    <ul>
                       <li><a href="/users_profiles/userprofile/'.$comms['users_profiles']['user_id'].'">'
					   .$comms['users_profiles']['firstname']." ".$comms['users_profiles']['lastname'].'</a>:&nbsp;'.$comms['Tweet_comment']['tweet_comment'];
                              if ($comment_user == $uid || $tweet_admin == $uid) {
                    $strstr .= '<a href="#" class="comment-close" data-toggle="modal" data-target="#deleteAjaxbox'.$comment_id.'"></a>
                                </a>';
							  }
           $strstr .= '</li>
                       <li><span class="posttime">'.$day." ".$month.", ".$year."  @ ".$time.'</span></li>
					</ul>
               </div>
              <div class="clear"></div>
          </div>
        <div class="modal fade middlepopup" id="deleteAjaxbox'.$comment_id.'" tabindex="-1" role="dialog" aria-labelledby="deletebox" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <a class="popupclose" data-dismiss="modal" aria-hidden="true"></a>
                    <h1 class="modal-title" id="myModalLabel">Delete</h1>
                  </div>
                  <div class="modal-body">
                    <h2>Are You sure want to delete ?</h2>
                  </div>
                  <div class="modal-footer">
                   <button type="button" onclick="delete_comment('.$comment_id.','.$content_id.');" class="btn submitbttn" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn canclebttn" data-dismiss="modal">No</button>
                  </div>
                </div>
              </div>
        </div>';
		}
		$total_reply = sizeof($user_tweet_comments);
	 echo $total_reply."::::".$strstr;	
		?>