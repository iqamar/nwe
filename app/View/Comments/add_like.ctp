<?php 	$str1 = ''; $str2 = '';
if ($content_type == 'news') {
	if ($like == 1) {
	
	 $str1 .= '<a class="like" href="javascript:likePost('.$content_id.',0);">Liked&nbsp;<span class="redcolor">('.$total_Liked.')</span></a>';
		} else { 
	 $str1 .= '<a class="like" href="javascript:likePost('.$content_id.',1);">Like&nbsp;<span class="redcolor">('.$total_Liked.')</span></a>';	
		} ?>
<?php } 
else if ($content_type == 'updates') {

	if ($like == 1) {
	$str1 .='<a href="Javascript:showLikes('.$content_id.',0);" class="like">Liked ('.$total_Liked.')</a>';
  		} else {
    $str1 .= '<a href="Javascript:showLikes('.$content_id.',1);" class="like">Like ('.$total_Liked.')</a>';
	 } 
  } 
else if ($content_type == 'company') {

	if ($like == 1) {

	 $str1 .= '<a class="like" href="javascript:showLikes('.$content_id.',0);">Liked&nbsp;<span class="redcolor">('.$total_Liked.')</span></a>';
	} 
 	else { 
 $str1 .= '<a class="like" href="javascript:showLikes('.$content_id.',1);">Like&nbsp;<span class="redcolor">('.$total_Liked.')</span></a>';	
	}
 } 
else if ($content_type == 'groups') {

	if ($like == 1) {

	 $str1 .= '<a class="like" href="javascript:showLikes('.$content_id.',0);">Liked&nbsp;<span class="redcolor">('.$total_Liked.')</span></a>';
	} 
 	else { 
 $str1 .= '<a class="like" href="javascript:showLikes('.$content_id.',1);">Like&nbsp;<span class="redcolor">('.$total_Liked.')</span></a>';	
	}

 } 
else if ($content_type == 'blog') {
	if ($like == 1) {

 $str1 .= '<a class="like" href="javascript:likePost('.$content_id.',0);">Liked&nbsp;<span class="redcolor">('.$total_Liked.')</span></a>';
	} else { 
 $str1 .= '<a class="like" href="javascript:likePost('.$content_id.',1);">Like</a>&nbsp;<span class="totalnumber" href="javascript:ajaxLikesPopup('.$content_id.')">
 			<span class="redcolor">('.$total_Liked.')</span></a>';	
	}
	
 }
 
 
 if ($total_Liked != 0) {
 $str2 .= '<div class="wholike-div">
    <div class="icon-like"></div>
        <ul>';
       $i = 1; $str = ''; $flag_set = false; $you = ''; $andcont = ''; $toltip = '';
        foreach ($likesOnUpdates as $like_row) {
            if ($i<=6) {
                $fullname = $like_row['users_profiles']['firstname']." ".$like_row['users_profiles']['lastname'];
				$tag = $like_row['users_profiles']['tags'];
                $like_photo = $like_row['users_profiles']['photo'];
				if ($like_photo && file_exists(MEDIA_PATH.'/files/user/icon/'.$like_photo)) {
					$like_user_photo=MEDIA_URL.'/files/user/icon/'.$like_photo;
				}
				else {
					$like_user_photo=MEDIA_URL.'/img/nophoto.jpg';
				}
                $user_id = $like_row['likes']['user_id'];
				$toll_tipID = "'".'#user'.$user_id.''."'";
                if ($user_id == $uid) {

			   $you =  '<li><div class="youtext"><a class="you-text" href="#user'.$user_id.'" onmouseover="tooltip.pop(this, '.$toll_tipID.')">You</a></div></li>';
							 $andcont = 'and';  $flag_set = true; 
				  } 
				  else { 
						//if ($andcont != '') { //$str .= '<li style="margin-top:5px;">'.$andcont.'</li>';}
			   $str .=  '<li>';
			   			$str .= '<a href="/users_profiles/userprofile/'.$user_id.'">
						<img src="'.$like_user_photo.'" href="#user'.$user_id.'" onmouseover="tooltip.pop(this, '.$toll_tipID.')" /></a>';
						 //$str .= $this->Html->image($like_user_photo,array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$user_id)));
				$str .= '</li>';
						   $andcont = '';
						   } 
					$toltip .= '<div style="display:none;">
										<div id="user'.$user_id.'"> 
											<div class="userlikes">
												<div class="userlikes-pic">
													<a href="/users_profiles/userprofile/'.$user_id.'"><img src="'.$like_user_photo.'" alt=""/></a>
												</div>
												<div class="userlikes-rgt">
													<ul>
														<li>
															<h1><a href="/users_profiles/userprofile/'.$user_id.'">'.$fullname.'</a></h1>
														</li>
														<li>'.$tag.'</li>
													</ul>
												</div>
												<div class="clear"></div>
											</div>
										</div>
								</div>';
						$i++;
						}
				 } // loop end 
				if ($flag_set == true && $str == '') {
					$str2 .= $you.$toltip;
				 }
				 else if ($flag_set == true && $str != '') {
					$str2 .= $you.'<li style="margin-top:5px;">and</li>'.$str.$toltip;
				 }
				 else {
					$str2 .= $str.$toltip; 
				 }
						 if ($i>=6) { 	
			   $str2 .= '<li><a href="javascript:ajaxLikesPopup('.$content_id.')" class="poplight totalnumber">
						<strong>+'.$total_Liked.'</strong></a></li>';
						 } $i = 1; $andcont = '';
				$str2 .= '</ul>
					<div class="clear"></div>
			  </div>'; 
 }
  echo $str1.'::'.$str2;
 
 
   ?>
   <div id="wholikeboxajax<?php echo $content_id;?>"  class="share_popup_ajax" style="width:500px;">
    	<div class="close" onclick="disableAjaxPopup('<?php echo $content_id;?>')"></div>
<!--your content start-->
      <div class="heading"><h1>People Who Like This</h1></div>
        <div class="scroller">
        <?php foreach ($likesOnUpdates as $like_row) {
                    $fullname = $like_row['users_profiles']['firstname']." ".$like_row['users_profiles']['lastname'];
            ?>
            <div class="wholike">
              <div class="wholike-pic">
                <?php 
                   
					if(!empty($like_row['users_profiles']['photo'])&& file_exists(MEDIA_PATH.'/files/user/icon/'.$like_row['users_profiles']['photo'])){ 
						echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$like_row['users_profiles']['photo'],array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$like_row['users_profiles']['user_id'])));
					}else{ 
						echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$like_row['users_profiles']['user_id'])));
					}	
                ?>
              
              </div>
              <div class="wholike-rgt">
                  <ul>
                      <li style="list-style:none; padding:2px 0px; background:none; margin:0px; float:none;">
                          <h1><?php echo $this->Html->link($fullname,array('controller'=>'users_profile','action'=>'userprofile',$like_row['users_profiles']['user_id']));?></h1>
                      </li>
                      <li style="list-style:none; padding:2px 0px; background:none; margin:0px;"><?php echo $like_row['users_profiles']['tags']?></li>
                  </ul>
              </div>
              
            <div class="clear"></div>
          </div>
     <?php }?> 
  </div>
	<!--your content end-->
</div>
    
    
<script>
function ajaxLikesPopup(ID) {
$("#wholikeboxajax"+ID).fadeIn(0500); // fadein popup div
$("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
$("#backgroundPopup").fadeIn(0001);
}
function disableAjaxPopup(ID) {
$("#wholikeboxajax"+ID).fadeOut("normal");
$("#backgroundPopup").fadeOut("normal");
}
</script>