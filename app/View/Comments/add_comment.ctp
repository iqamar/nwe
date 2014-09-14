<?php 	 $strstr ="";
if ($comment_type == 'articles') {
foreach ($userComments as $singleComment) {
?>
<div class="relat-jobmain-div">
  	   <div class="relat-job-div">
   		 <div class="relat-jobcolm">
     		 <div class="relat-jobtxt">
             
        		<h1><?php echo $singleComment['users_profiles']['firstname']." ".$singleComment['users_profiles']['lastname']?></h1>
        			<?php echo $singleComment['comments']['comment_text'];?><br />
                    <!--comment on comment start-->
                    
         <div class="social-sub-div" style="padding:0px 5px">
        	<ul>
            <li><span class="artDate"><span class="txt"><?php echo $singleComment['comments']['comment_date'];?> </span></span></li>
            <li><span class="view like-icon">&nbsp;&nbsp;<span class="txt" style="padding-left:33px;"><?php echo $singleComment[0]['total']?></span></li>
          	<li><span class="view">&nbsp;&nbsp;<span class="txt">
          <a href="Javascript:showReplyForm('<?php echo $singleComment['comments']['id'];?>');" style="text-decoration:none; padding:0px 5px;">
          Reply<?php 
							foreach ($countReplys as $articleReplysOn) { 
							//echo $articleReplysOn['comments']['id'];
								if ($articleReplysOn['comments']['parent'] == $singleComment['comments']['id']) { 
							echo "(".$articleReplysOn[0]['total_reply'].")";
							}}
							?>
          
          </a></span></span></li>
            
            </ul>
        </div> <!--comment on comment end-->
        
        	<!--comment on comment form start-->
                 <div class="comments_field" id="reply_<?php echo $singleComment['comments']['id'];?>" style="display:none; text-align:center; clear:both; width:100%;">   
              		<div class="relat-jobtxt" style="margin:10px 0px 10px 0px; text-align:left;"><h1>Reply:</h1></div>
             <?php echo $this->Html->image('user-icon.png',array('style'=>'width:64px; height:64px; float:left; margin-right:40px; margin-top:10px;'));?>
             		<form id="coment_form" name="coment_form" action="" method="post" style="width:540px; float:left;">
					<input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
					<input type="hidden" name="parent" id="id_<?php echo $singleComment['comments']['id'];?>" value="<?php echo $singleComment['comments']['id'];?>" />
					<input type="hidden" name="comment_type" id="comment_type" value="articles" />
					<input type="hidden" name="content_id" id="content_id_<?php echo $singleComment['comments']['id'];?>" value="<?php echo $content_id;?>" />
					<input type="hidden" name="comment_date" id="comment_date_<?php echo $singleComment['comments']['id'];?>" value="<?php echo $date = date("Y-m-d");?>" />
					<textarea rows="5" cols="55" class="user_coments" placeholder="Put your reply here..." name="comment_text" id="comment_text_<?php echo $singleComment['comments']['id'];?>" style="width:540px; float:left;"></textarea>
                		<span style="float:right;">
             			<a href="Javascript:saveComment('<?php echo $singleComment['comments']['id'];?>');" class="inpt-btn" style="text-decoration:none; margin-top:5px;">Reply</a>
                        </span>	
					</form>
         	 </div>
             <!--comment on comment form end-->     
       			 
                <?php foreach ($userAjaxCommentsOnComments as $ajaxCommentsOnComment) {
						if ($ajaxCommentsOnComment['comments']['parent'] == $singleComment['comments']['id']) {
					?>   
       			 <div class="relat-jobmain-div">
  					<div class="relat-job-div">
  					  <div class="relat-jobcolm">
     					 <div class="relat-jobtxt">
      					  <h1><?php echo $ajaxCommentsOnComment['users_profiles']['firstname']." ".$ajaxCommentsOnComment['users_profiles']['lastname'];?></h1>
       						 <?php echo $ajaxCommentsOnComment['comments']['comment_text'];?> </div>
   						 </div>
  					</div>
  							<div class="relat-job-pht">
							<?php if ($singleComment['users_profiles']['photo']) {
                            echo $this->Html->image('/files/users/'.$ajaxCommentsOnComment['users_profiles']['photo'],array('style'=>'width:50px; height:50px;'));
							}
							else {
							echo $this->Html->image('user-icon.png',array('style'=>'width:50px; height:50px;'));	
							}
							?>
                            </div>
				</div> <!--comment on comment listing end--> 
                <?php }}?>
       		 </div>
   		 </div>
  		</div>
  						    <div class="relat-job-pht">
                            <?php if ($singleComment['users_profiles']['photo']) {
                            echo $this->Html->image('/files/users/'.$singleComment['users_profiles']['photo'],array('style'=>'width:50px; height:50px;'));
							}
							else {
							echo $this->Html->image('user-icon.png',array('style'=>'width:50px; height:50px;'));	
							}
							?>
                            </div>
		</div>
 <?php } } else if ($comment_type == 'updates') { ?>
		<?php 
		foreach ($userComments as $comms) {
			$created_date = $comms['comments']['created'];
			$year = date("Y", strtotime($created_date));
			$month = date("M", strtotime($created_date));
			$day = date("d", strtotime($created_date));
			$time = date("H:i:s", strtotime($created_date));
			$user_id = $comms['comments']['user_id'];
			$commentid = $comms['comments']['id'];
			

 $strstr .= '<div class="comment-listing" id="commentsbox'.$commentid.'">
            <div class="comment-listing-pic">';
                	 if ($comms['users_profiles']['photo'] && file_exists(MEDIA_PATH.'/files/user/icon/'.$comms['users_profiles']['photo'])) {
                        $strstr .= $this->Html->image(MEDIA_URL.'/files/user/icon/'.$comms['users_profiles']['photo'],array('alt'=>'post-img'));
                       }
                       else { 	
                        $strstr .= $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>'width:32px; height:32px;','alt'=>'post-img')); 
                        }
 
 $strstr .= '</div>
            <div class="comment-listing-rgt">
            <ul>
                <li>
                
                <a href="#">'.$comms['users_profiles']['firstname']." ".$comms['users_profiles']['lastname'].'</a>&nbsp;'. $comms['comments']['comment_text'];
				if ($user_id == $uid || $post_admin == $uid) {
                  $strstr .= '<a href="javascript:" onclick="delete_comment('.$commentid.','.$content_id.');" class="comment-close" title="Delete Update"></a>';
                    } 
               $strstr .= '</li>
                <li>
                    <a  class="replycomment">'.$day." ".$month.", ".$year."  @ ".$time.'</a>																	                    <div class="clear"></div>	
                </li>
            </ul>
            </div>
            <div class="clear"></div>
       </div>';
		}
  }
  echo $total_comments_post."::::".$strstr;
 ?>