<?php $str1= '';
if ($reply == 'false') {
    foreach ($comments_this_news as $comment__row) {
        $full_name = $comment__row['users_profiles']['firstname'] . " " . $comment__row['users_profiles']['lastname'];
        $created_date = $comment__row['Comment']['created'];
        $year = date("Y", strtotime($created_date));
        $month = date("M", strtotime($created_date));
        $day = date("d", strtotime($created_date));
        $commentid = $comment__row['Comment']['id'];
		$comment_user = $comment__row['Comment']['user_id'];
        $time = date("H:i:s", strtotime($created_date));
        $handler = $comment__row['users_profiles']['handler'];
        $user_photo = $comment__row['users_profiles']['photo'];
		
   $str1 .= '<div class="as_country_container" id="'.$commentid.'">
            <div class="comment-listing" id="commentsbox">';
			 if ($comment_user == $uid) {
		 $str1 .= '<a href="javascript:void(o)" onclick="delete_comment('.$commentid.','.$content_id.');" class="comment-close" title="Delete Comment"></a>';
                  }
       $str1 .= '<div class="comment-listing-pic">';
                    if ($user_photo && file_exists(MEDIA_PATH . '/files/user/icon/' . $user_photo)) {
                     $str1 .= $this->Html->image(MEDIA_URL . '/files/user/icon/' . $user_photo, array('style' => ''));
                    } else {
                    $str1 .= $this->Html->image(MEDIA_URL . '/img/nophoto.jpg', array('style' => ''));
                    }
     $str1 .= '</div>
                <div class="comment-listing-rgt">
                    <ul>
                        <li> <a href="#">'. $full_name.'</a>'.$comment__row['Comment']['comment_text'].'</li>
                        <li><span class="posttime">'.$day . " " . $month . ", " . $year . "  @ " . $time.'</span></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>';
    }
	echo $comments_on_news.':::'.$str1;
	
} else if ($reply == 'true') {
    foreach ($reply_to_comments as $comment__row) {
        $full_name = $comment__row['users_profiles']['firstname'] . " " . $comment__row['users_profiles']['lastname'];
        $created_date = $comment__row['Comment']['created'];
        $year = date("Y", strtotime($created_date));
        $month = date("M", strtotime($created_date));
        $day = date("d", strtotime($created_date));
        $time = date("H:i:s", strtotime($created_date));
        $commentid = $comment__row['Comment']['id'];
		$comment_user = $comment__row['Comment']['user_id'];
		$parent = $comment__row['Comment']['parent'];
        ?>
        <div class="reply_container" id="<?php echo $commentid; ?>" style="display:none1;">
            <div class="comment-listing-pic2">
                <?php
                if ($comment__row['users_profiles']['photo'] && file_exists(MEDIA_PATH. '/files/user/icon/' . $comment__row['users_profiles']['photo'])) {
                    echo $this->Html->image(MEDIA_URL . '/files/user/icon/' . $comment__row['users_profiles']['photo'], array('style' => ''));
                } else {
                    echo $this->Html->image(MEDIA_URL . '/img/nophoto.jpg', array('style' => ''));
                }
                ?>
            </div>
            <div class="writecomment-rgt">
                <ul>
                	<li>
                    	<?php if ($comment_user == $uid) { ?>
				<a href="javascript:void(o)" onclick="delete_reply('<?php echo $commentid;?>','<?php echo $parent;?>');" class="comment-close" title="Delete Comment"></a>
                 		 <?php } ?>	
                    	<a href="#"><?php echo $full_name; ?></a> <?php echo $comment__row['Comment']['comment_text']; ?>
                        </li></ul>
                <ul><li><span class="posttime"><?php echo $day . " " . $month . ", " . $year . "  @ " . $time; ?></span></li></ul>
            </div>
            <div class="clear"></div>
        </div>
    <?php } ?>
<?php } ?>