<?php echo $this->Html->css(MEDIA_URL.'/css/content-grab.css'); ?>
<div class="box">
	<div class="tab-container" id="tab-container" data-easytabs="true">
		<ul class="etabs">
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/page/">Company Page</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/">Following</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/search/">Search Company</a></li>
			<li class="tab active"><a href="#" class="active">Companies Updates</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/validity/">Add Company</a></li>
		</ul>
		<div class="panel-container">
			<div id="tabs1" style="display: block;" class="active"> 
            <div class="success_msg" id="message_update" style="display:none;">Your Update has been deleted successfully!</div> 
            <div class="success_msg" id="message_comment" style="display:none;">Your Comment has been deleted successfully!</div>  
			<?php if ($this->params['named']['error'] !=''){
					$error = $this->params['named']['error']; 
					echo '<p style="color:#B00000;">'.$error.'</p>';
				 }
		
			$company_date = false;
			if ($company_Updates) {
				
				  foreach ($company_Updates as $company_update_row) { 
				  	 $entity_content_ID = $company_update_row['Entity_update']['entity_id'];
					if (in_array($entity_content_ID,$users_following_com_Array)) {
						$companyID = $company_update_row['companies']['id'];
						$entityID = $company_update_row['Entity_update']['id'];
						$user_liked_ID = $company_update_row['likes']['user_id'];
						$liked_ID = $company_update_row['likes']['id'];
						$companytitle = strtolower($company_update_row['companies']['title']);
						$companytitle = str_replace(' ', '-', $companytitle);
						$month = date('F',strtotime($company_update_row['Entity_update']['created']));
						$day = date('d',strtotime($company_update_row['Entity_update']['created']));
						$year = date('Y',strtotime($company_update_row['Entity_update']['created']));
						$companyAdmin = $company_update_row['companies']['user_id'];
						
						$company_date = true;
		?>

        	<div class="post-wall" id="<?php echo $entityID;?>">
            	<?php if ($company_update_row['Entity_update']['user_id'] == $uid || $companyAdmin == $uid) {?>
    					<a href="javascript:void(o)" onclick="delete_update('<?php echo $entityID;?>');" class="comment-close" title="Delete Update"></a>
        		<?php }?>
						<div class="userpic-post">
                            	<?php echo '<a href="'.NETWORKWE_URL.'/companies/view/'.$companyID.'/'.$companytitle.'">';
									if(!empty($company_update_row['companies']['logo'])){
										if (file_exists(MEDIA_PATH.'/files/company/icon/'.$company_update_row['companies']['logo'])) {
											echo $this->Html->image(MEDIA_URL.'/files/company/icon/'.$company_update_row['companies']['logo'],array('alt'=>'no-img'));
										}
										else {
											echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array('alt'=>'no-img'));
										}
									}
									else{
										echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array('alt'=>'no-img'));
									}
								echo '</a>';
                            ?>
                        </div>
						<div class="post-wall-rgt">
							<ul>
								<li>
                                	<?php 
									echo $this->Html->link($company_update_row['companies']['title'],array('controller'=>'companies','action'=>'view',$companyID,$companytitle));?>	
                                </li>
                                <li><?php echo $company_update_row['Entity_update']['group_title'];?></li>
								<li>
								<div class="post-wall-subcontent">
                                	<div class="post-wall-subcontent-rgt2">	
                                    	<ul>
                                        	<li>								
										<?php if ($company_update_row['Entity_update']['image']) {
                                                        //echo $company_update_row['Entity_update']['image'];
                                                    if ($company_update_row['Entity_update']['entity_type'] == "company") {
                                                        echo '<div class="subcontent2-pic">';
                                                  echo $this->Html->image(MEDIA_URL.'/files/update/original/'.$company_update_row['Entity_update']['image'],array('alt'=>'no-img'));
                                                    echo '</div>';
                                                    }
                                                    else if($company_update_row['Entity_update']['entity_type'] == "news"){
                                                        echo '<div class="subcontent2-pic">';
                                                    echo $this->Html->image(MEDIA_URL.'/files/news/original/'.$company_update_row['Entity_update']['image'],array('alt'=>'no-img'));
                                                        echo '</div>';
                                                    }
                                                    echo $company_update_row['Entity_update']['update_text'];
                                                    //echo $this->Html>link('More..',array('controller'=>'groups','action'=>'view_',$diss_id,$title));
                                            }
                                            else {
                                                if ($company_update_row['Entity_update']['update_text']) {
                                                    echo $company_update_row['Entity_update']['update_text'];
                                                }
                                                //echo $this->Html>link('More..',array('controller'=>'groups','action'=>'view_',$diss_id,$title));
                                            }?>
                                          </li>
                                       </ul>
                                     </div>
								<div class="clear"></div>
								</div>
								
                                <!-- Button comments, like start -->
                                <div>
								    <div class="post-bttns">
                                    	<ul>
                                        	<input type="hidden" name="like_type" id="like_type" value="groups" />
                                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
											<input type="hidden" name="like_date" id="like_date_<?php echo $diss_id;?>" value="<?php echo $date = date("Y-m-d H:i:s");?>" />
                                        	<!-- LIKE START -->
											<li id="user_like_update_<?php echo $entityID;?>">
											<?php 
												$flage = false;
												$total_likes_this = '';
												$total_likes_unmatched = '';
												foreach ($likes_on_Update as $like_update_row)  {
													$user_id = $like_update_row['likes']['user_id'];
													$content_id = $like_update_row['likes']['content_id'];
													$like = $like_update_row['likes']['like'];
													if ($entityID == $content_id && $user_id == $uid && $like == 1) {
														$flage = true;
													}
													if ($entityID == $content_id) {
														$total_likes_unmatched += $like_update_row['likes']['like'];
					
													}
												}
							 					if ($flage == true) { ?>
							 						<a id="alike<?php echo $entityID;?>" href="Javascript:showLikes('<?php echo $entityID;?>','0');">Liked&nbsp;
														<?php  if ($total_likes_unmatched) { echo "<span class='redcolor'>(".$total_likes_unmatched.")</span>"; }?>
                                                    </a> 
											 <?php }?>
											<?php if ($flage == false) {  ?>
													 <span style="display:block;">
                                                     	<a id="alike<?php echo $entityID;?>" href="Javascript:showLikes('<?php echo $entityID;?>','1');">Like&nbsp;
															<?php echo "<span class='totalnumber'>(".$total_likes_unmatched.")</span>";?>
                                                        </a>
                                                     </span>
                                                         
										<?php } ?>

                                            </li>
                                            <!-- LIKE end -->

											<li><a href="#" onClick="showhide('commentsDiv<?php echo $entityID;?>', 'block'); return false" >Comments 
											<?php $chk_comments = 0;
												foreach ($updates_comments_count as $comments_total_row) {
													if ($comments_total_row['entity_comments']['content_id'] == $entityID) {
	 													echo "<a class='totalnumber'>(".'<span id="total_following_'.$entityID.'">'.$comments_total_row[0]['commenttotal'].'</span>'.")</a>";
														$chk_comments = 1;
													}
												  } 
												  if ($chk_comments == 0) {
														echo "<a class='totalnumber'>(".'<span id="total_following_'.$entityID.'">0</span>'.")</a>";
													}
													?>
                                            	</a>
                                            </li>
                                            <li> 
                                             <?php $share_count = 0;
											 	foreach ($shareOnUpdates as $share_row) {
												 	if ($share_row['Entity_update']['share'] == $entityID) {
														$share_count++;
													}
												}
												 ?>
                                            <a href="#?w=500" rel="share_popup<?php echo $entityID;?>" class="poplight sharecontent">Share</a>
                                            <a href="#?w=500" rel="whosharebox<?php echo $entityID;?>" class="poplight sharecontent">
                                            	<span class="redcolor">(<?php echo $share_count;?>)</span>
                                            </a>
                                            </li>
                                           <li><span class="posttime"><?php if ($company_update_row['Entity_update']['created']) { echo $month." ".$day.", ".$year; }?></span>
                                           </li>
                                        </ul>
									 <div class="clear"></div>
                                    </div>
                                   <div id="ajax_res<?php echo $entityID;?>">
								<?php if ($total_likes_unmatched != 0) {?>
                                        <div class="wholike-div">
                                            <div class="icon-like"></div>
                                                <ul>
                                                <?php  $i = 1; $str = ''; $flag_set = false; $you = ''; $andcont = ''; $toltip = '';
                                                foreach ($likesOnUpdates as $like_row) {
                                                    if ($like_row['likes']['content_id'] == $entityID && $i<=6) {
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
                                                             $you = '<li><div class="youtext"><a class="you-text" href="#user'.$user_id.'" onmouseover="tooltip.pop(this, '.$toll_tipID.')">You</a></div></li>';
                                                             $andcont = 'and';
                                                             $flag_set = true;
                                                        } else { 
                                                   $str .= '<li>';
                                                    $str .= '<a href="/users_profiles/userprofile/'.$user_id.'">
                                                    <img src="'.$like_user_photo.'" href="#user'.$user_id.'" onmouseover="tooltip.pop(this, '.$toll_tipID.')" /></a>';
                                                   
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
                                                     $i++;}}
                                                     if ($flag_set == true && $str == '') {
                                                        echo $you.$toltip;
                                                     }
                                                     else if ($flag_set == true && $str != '') {
                                                        echo $you.'<li style="margin-top:5px;">and</li>'.$str.$toltip;
                                                     }
                                                     else {
                                                        echo $str.$toltip; 
                                                     }
                                                     ?> 
                                                    <?php if ($i>=6) {?>   	
                                                    <li><a href="javascript:loadLikesPopup('<?php echo $entityID;?>')" class="poplight totalnumber">
                                                    <strong><?php echo "+".$total_likes_unmatched;?></strong></a></li>
                                                    <?php } $i = 1; $andcont = ''; ?>
                                                </ul>
                
                                                <div class="clear"></div>
                                            </div>
                                         <?php }?>
                                       </div>
                           			
                             		<div class="clear"></div>
									<!--- Main Comment Box for Post ----->
									<div id="commentsDiv<?php echo $entityID;?>" style="display:none" class="commentsbox">
                                    
										<!--- Comment Box ---->
                                        <div id="group_loader<?php echo $entityID?>" style="display:none; text-align:center;">
												<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
										</div>
                                        <span id="span_<?php echo $entityID;?>">
											<?php foreach ($user_comments as $comment__row) {
                                                    $full_name = $comment__row['users_profiles']['firstname']." ".$comment__row['users_profiles']['lastname'];
                                                    $created_date = $comment__row['entity_comments']['created'];
                                                    $year = date("Y", strtotime($created_date));
                                                    $month = date("M", strtotime($created_date));
                                                    $day = date("d", strtotime($created_date));
                                                    $commentid = $comment__row['entity_comments']['id'];
                                                    $time = date("H:i:s", strtotime($created_date));
                                                    $handler = $comment__row['users_profiles']['handler'];
                                                    $user_photo = $comment__row['users_profiles']['photo'];
													$content_id = $comment__row['entity_comments']['content_id'];
                                                    if ($content_id == $entityID) {?>
                                            <div class="comment-listing" id="commentsbox<?php echo $commentid;?>">
                                                <div class="comment-listing-pic">
                                                    <a href="/pub/<?php echo $handler; ?>">
                                                    <?php 
                                                        if ($user_photo) {
															if (file_exists(MEDIA_PATH.'/files/user/icon/'.$user_photo)) {
                                                            	echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$user_photo,array('alt'=>'no photo'));
															}
															else {
																echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'no photo'));
															}
                                                        }
                                                        else {
                                                            echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'no photo'));
                                                        }
                                                    ?>
                                                    </a> 
                                                </div>
                                                <div class="comment-listing-rgt">
                                                <ul>
                                                    <li>
                                                    <a href="/pub/<?php echo $handler; ?>"><?php echo $full_name;?></a> <?php echo $comment__row['entity_comments']['comments'];?>
                                                    	<?php if ($comment__row['entity_comments']['user_id'] == $uid || $companyAdmin == $uid) {?>
    												<a href="javascript:" onclick="delete_comment('<?php echo $commentid;?>','<?php echo $entityID;?>');" class="comment-close" title="Delete Update">
                                                    </a>
        													<?php }?>
                                                    </li>
                                                    <li><span class="posttime"><?php echo $day." ".$month.", ".$year."  @ ".$time; ?></span></li>
                                                </ul>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                            
                                            <?php }}?>
                                            <!--- End Comments Box --->
                                    </span>
                                    	<div class="clear"></div>
										<div class="writecomment">
											<div class="comment-listing-pic">
												<a href="/pub/<?php echo $user_handler; ?>">
                                                	<?php 
														if ($imgname) {
															if (file_exists(MEDIA_PATH.'/files/user/icon/'.$imgname)) {
																echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$imgname,array('alt'=>'no photo'));
															}
															else {
																echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'no photo'));
															}
														}
														else {
															echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'no photo'));
														}
													?>
                                                 </a>
                                            </div>
											<div class="writecomment-rgt">
                                                <?php echo $this->Form->input('user_id' , array('type' => 'hidden', 'id'=>'user_id', 'value' => $uid)); ?>
                                                <?php echo $this->Form->input('company_admin_id' , array('type' => 'hidden', 'id'=>'admin_id', 'value' => $companyAdmin)); ?>
											<?php echo $this->Form->input('comments',array('required'=>false,'div'=>false, 'label'=>false,'id'=>'comment_text_'.$entityID,'placeholder'=>"add comments..",'onkeydown'=>'checkField('.$entityID.');')); ?>
                                           <input type="hidden" name="lcontent_date" id="content_date_<?php echo $entityID;?>" value="<?php echo $date = date("Y-m-d H:i:s");?>" />
                                         <input name="send" type="button" id="send<?php echo $entityID;?>" value="send" style="display:none;" onclick="saveComment('<?php echo $entityID;?>');" class="comment_bttn" />
											</div>
											<div class="clear"></div>
										</div>

									</div>
									<!--- End of Main Comment Box for Post ----->	
								</div>
                               <!-- Button comments, like End -->
                                
							   </li>
							</ul>
						</div>
						<div class="clear"></div>
					</div>
                    
      
         	<!---who share update Box Starts Here --->
            <div id="whosharebox<?php echo $entityID;?>"  class="popup_block">
        <!--your content start-->
              <div class="heading"><h1>People Who Share This Update</h1></div>
                <div class="scroller">
                <?php foreach ($shareOnUpdates as $sharerow) {
                        if ($sharerow['Entity_update']['share'] == $entityID) {
                            $fullname = $sharerow['users_profiles']['firstname']." ".$sharerow['users_profiles']['lastname'];
                    ?>
                    <div class="wholike">
                      <div class="wholike-pic">
                        <?php 
                           
                            if(!empty($sharerow['users_profiles']['photo'])&& file_exists(MEDIA_PATH.'/files/user/icon/'.$sharerow['users_profiles']['photo'])){ 
                                echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$sharerow['users_profiles']['photo'],array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$sharerow['users_profiles']['user_id'])));
                            }else{ 
                                echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$sharerow['users_profiles']['user_id'])));
                            }   
                        ?>
                      
                      </div>
                      <div class="wholike-rgt">
                          <ul>
                              <li>
                                  <h1>
								<?php echo $this->Html->link($fullname,array('controller'=>'users_profile','action'=>'userprofile',$sharerow['users_profiles']['user_id']));?>
                            	  </h1>
                              </li>
                              <li><?php echo $sharerow['users_profiles']['tags']?></li>
                          </ul>
                      </div>
                      
                    <div class="clear"></div>
                  </div>
             <?php }}?> 
          </div>
            <!--your content end-->
        </div>
            <!---who share update Box Starts Here --->
      
                    
     <div id="share_popup<?php echo $entityID;?>" class="popup_block">
    	<div class="greybox-div-heading"><h1>Share</h1></div>
    <!--your content start-->
		
		<div class="userprofile-box">
			<?php if ($company_update_row['Entity_update']['image']){ ?>
			<div class="userprofile-box-pic">
            	<?php 
				if ($company_update_row['Entity_update']['image']){
					if (MEDIA_PATH.'/files/update/icon/'.$company_update_row['Entity_update']['image']) {
                	 	echo $this->Html->image(MEDIA_URL.'/files/update/icon/'.$company_update_row['Entity_update']['image'],
                                                                                                                    array('alt'=>'banner'));
					}
					else {
						echo $this->Html->image(MEDIA_URL.'/imag/nologo.jpg',
                                                                          array('alt'=>'banner'));
					}
				}
				else {
					 echo $this->Html->image(MEDIA_URL.'/imag/nologo.jpg',
                                                                          array('alt'=>'banner'));
				}
                  ?>  
            </div>
			<div class="userprofile-box-rgt">
				<ul>
					<li>
						<h1>
						<?php 
							echo $this->Html->link($company_update_row['users_profiles']['firstname']." ".$company_update_row['users_profiles']['lastname'],
																																				array('controller'=>'users_profile',
																																			'action'=>'userprofile',
																																$company_update_row['users_profiles']['user_id']
																																			));
							?>
                       </h1>
				    </li>
                    <li><span class="postedon">Posted on  : <?php echo $company_update_row['Entity_update']['created']?></span></li>
					<li><?php echo strip_tags($company_update_row['Entity_update']['update_text']); ?> </li>
			    </ul>
		    </div>
		<div class="clear"></div>
		<?php } else{
			
			echo $company_update_row['Entity_update']['update_text'];
		}?>
		<div class="clear"></div>
	  </div>
		<form action="/companies/share/" method="post" class="userprofile-form">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><strong>Add to share</strong></td>
			    </tr>
				<tr>
					<td>
                    	 <input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
       					  <input type="hidden" name="content_type" id="content_type" value="company" />
                         <input type="hidden" name="photo" id="photo" value="<?php echo $company_update_row['Entity_update']['image']?>" />
                          <input type="hidden" name="user_share" id="user_share" value="<?php echo $entityID;?>" />
                          <input type="hidden" name="entity_id" id="entity_id" value="<?php echo $companyID;?>" />
						<textarea name="update_text" style="display:none;" id="update_text"><?php echo $company_update_row['Entity_update']['update_text']; ?></textarea>
     					<input type="hidden" name="share_with" id="share_with" value="1" />
                        <input type="hidden" name="comment_date" id="comment_date" value="<?php echo $date = date('Y-m-d H:i:s');?>" />
                    	<textarea name="share_text" cols="58" rows="7" class="textfield" placeholder="Share updates" ></textarea>
                    </td>
			    </tr>
				<tr>
					<td></td>
			    </tr>
				<tr>
					<td><input type="submit" name="Submit" value="Share" class="red-bttn" /></td>
			    </tr>
		    </table>
	    </form>
	   <!--your content end-->
	</div>
  
	<?php }}}?>
    			<?php if ($company_date == false) {
					echo '<div class="heading"><h1> You are not following a company, Please follow any company to see updates.</h1></div>';
				}?>
				<div class="clear"></div>		
			</div>
		</div>
	</div>
</div>
<div id="backgroundPopup"></div>
<script>
function checkField(commentID) {
	var fieldValue =  document.getElementById('comment_text_'+commentID).value;
		if (fieldValue == ' ') {
			document.getElementById('send'+commentID).style.display = 'none';
		}
	var fieldSize = fieldValue.length;
	if (fieldSize > 0 && fieldSize <= 140) {
		document.getElementById('send'+commentID).style.display = 'block';
	}
	else {
		document.getElementById('send'+commentID).style.display = 'none';
	}
}

function expandComment(id) {
$('#comment_text_'+id).css({
            'height' : '60px'
        });
}
function showhide(divid, state){
document.getElementById(divid).style.display=state;
}
function showLikes(commentid,like){
	$("#user_like_update_"+commentid).html('<img src="http://media.networkwe.com/img/loading.gif" style="float:left;" />');
	var user_id = document.getElementById('user_id').value;
	var content_type = 'company';
	var created = document.getElementById('content_date_'+commentid).value;
	
	$.ajax({
	url     : baseUrl+"/comments/add_like",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,content_type:content_type,content_id:commentid,created:created,like:like},
	success : function(data){	
		responseArray = data.split("::");
		$("#user_like_update_"+commentid).html(responseArray[0]);
		$("#ajax_res"+commentid).html(responseArray[1]);
	},
	error : function(data) {
	$("#user_like_update_"+commentid).html("there is error");
	}
	});
}
	function showComments(commentId) {
	$("#comments_"+commentId).slideDown('slow');
	//$("ul li.content_"+commentId).css({'height':'262px'});
	}
	function closeComment(commentId) {
	$("#comments_"+commentId).slideUp('slow');
	//$("ul li.content_"+commentId).css({'height':'124px'});
	}
	
function saveComment(commentid){
	$('#group_loader'+commentid).show();
	var user_id = document.getElementById('user_id').value;
	var comment_text = document.getElementById('comment_text_'+commentid).value;
	var admin_id = document.getElementById('admin_id').value;
	$.ajax({
	url     : baseUrl+"/companies/add_comments",
	type    : "POST",
	cache   : false,
	data    : {user_id: user_id,content_id:commentid,comments:comment_text,admin_id:admin_id},
	success : function(data){
		//if (share == 1) {
	responseArray = data.split("::::");
	$("#total_following_"+commentid).html(responseArray[0]);
	$("#span_"+commentid).html(responseArray[1]);
	//$("#comments_"+commentid).slideUp('slow');
	//$("ul li.content_"+commentid).css({'height':'124px'});
		//}
	},
	complete: function () {
			$('#group_loader'+commentid).hide();
			document.getElementById('comment_text_'+commentid).value = '';	
	 },
	error : function(data) {
	$("#span_"+commentid).html(data);
	}
	});
}

function shareUpdates(id,share_type) {
//$('#edit_Recs').show();
if (share_type == 'company'){
document.getElementById('fade').style.display = 'block';
document.getElementById('openEditWindow_'+id).style.display = 'block';
}		  
}
function close_EditWindow(id,share_type) {
	if (share_type == 'company'){
document.getElementById('fade').style.display = 'none';
document.getElementById('openEditWindow_'+id).style.display = 'none';
}
}
function countChar(val,commentid) {
        var len = val.value.length;
        if (len > 75) {
          val.value = val.value.substring(0, 75);
		  document.getElementById('comment_text_'+commentid).disabled = true;
        } else {
          $('#comment_count_'+commentid).text(75 - len+' characters');
        }
      }
function delete_update(update_id) {
	var checkstr =  confirm('Are you want to delete this?');
		if(checkstr == true){
  			$.ajax({
					url     : baseUrl+"/companies/delete_update",
					type    : "GET",
					cache   : false,
					data    : {update_id: update_id},
					success : function(data){
						//if (share == 1) {
					//$("#message_update").slideDown('slow');
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$("#message_update").slideDown('slow').delay(1000).fadeOut();
					$("#"+update_id).slideUp('slow');
						//}
					},
					complete: function() {
					$("#"+update_id).css({ opacity: 0.6 });		
					},
					error : function(data) {
					$("#"+update_id).html(data);
					}
			});
		}
		else{
		return false;
		}
}
function delete_comment(comment_id,content_id) {
	var checkstr =  confirm('Are you want to delete this?');
		if(checkstr == true){
  			$.ajax({
					url     : baseUrl+"/companies/delete_comment",
					type    : "GET",
					cache   : false,
					data    : {comment_id: comment_id,content_id:content_id},
					success : function(data){
						//if (share == 1) {
					//$("#message_update").slideDown('slow');
					//$("html, body").animate({ scrollTop: 0 }, "slow");
					//$("#message_comment").slideDown('slow').delay(1000).fadeOut();
					$("#total_following_"+content_id).html(data);
					$("#commentsbox"+comment_id).slideUp('slow');
						//}
					},
					complete: function() {
					$("#commentsbox"+comment_id).css({ opacity: 0.6 });		
					},
					error : function(data) {
					$("#commentsbox"+comment_id).html(data);
					}
			});
		}
		else{
		return false;
		}
}
</script>