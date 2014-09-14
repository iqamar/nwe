<?php
//echo $this->Html->css(array(MEDIA_URL . '/css/jquery.share.css', null, array('inline' => false)));
//echo $this->Html->script(array(MEDIA_URL . '/js/jquery.share.js', null, array('inline' => false)));
echo $this->Html->css(array(MEDIA_URL . '/css/jquery.share.css'));
echo $this->Html->script(array(MEDIA_URL . '/js/jquery.share.js'));
?>
<div class="clear"></div>
<a class="addblog-bttn" href="/blogs/add">Add New Blog Post</a>
<a class="current view_all_blog" href="/blogs/">View All Blogs</a>
<div class="clear"></div>

<div class="box margintop15">
	<?php 
	
	foreach ($posts_Detail as $post__Detail_Row) {
		$postId = $post__Detail_Row['blogs']['id'];
		$blog_admin = $post__Detail_Row['blogs']['user_id'];
		$created_date = $post__Detail_Row['blogs']['created'];
		$count = $post__Detail_Row['blogs']['parent'];
		$year = date("Y", strtotime($created_date));
		$month = date("M", strtotime($created_date));
		$day = date("d", strtotime($created_date));
		$blogImage = $post__Detail_Row['blogs']['image'];
		$auther_fullname = $post__Detail_Row['users_profiles']['firstname']." ".$post__Detail_Row['users_profiles']['lastname'];
		$auther_photo = $post__Detail_Row['users_profiles']['photo'];
		$blog_user_id = $post__Detail_Row['users_profiles']['user_id'];
		$auther_tags = $post__Detail_Row['users_profiles']['tags'];
		//$title_url = strtolower($post__Row['blogs']['post_title']);
		$desc =  strip_tags($post__Detail_Row['blogs']['description'],"<img");
                echo $this->Html->meta(array('property' => 'og:title', 'content' => $post__Detail_Row['blogs']['post_title']),'',array('inline'=>false));
                echo $this->Html->meta(array('property' => 'og:type', 'content' => 'article'),'',array('inline'=>false));
                echo $this->Html->meta(array('property' => 'og:article:author', 'content' => $auther_fullname),'',array('inline'=>false));
                echo $this->Html->meta(array('property' => 'og:article:published_time', 'content' => date("d:m:Y H:i:s", strtotime($created_date))),'',array('inline'=>false));
                echo $this->Html->meta(array('property' => 'og:description', 'content' => strip_tags($news_single_Row['News']['details'])),'',array('inline'=>false));
	?>
            <script type="text/javascript">
                $(function() {
                    $('#social_share').share({
                        networks: ['facebook','twitter','linkedin','pinterest','tumblr','googleplus','digg','stumbleupon','email'],
                        pageTitle: '<?=htmlentities($post__Detail_Row['blogs']['post_title'], ENT_QUOTES)?>',
                        orientation: 'vertical',
                        affix: 'left center',
                        theme: 'square'
                    });
                });
            </script>
	<div class="blogslisitng">
		
		<div class="blog_top_area">
        	<div class="blogdate"> 
            	<span><?php echo $day; ?></span> <span class="smalltext"><?php echo $month; ?></span><br>
        		<span class="smalltext"><?php echo $year; ?></span>
			</div>
       		<div class="blog_top_left">
       		  <div class="blog_owner">
                	 
                <?php 
				if($auther_photo){
					if (file_exists(MEDIA_PATH.'/files/user/icon/'.$auther_photo)) {
						echo $this->Html->link($this->Html->Image(MEDIA_URL.'/files/user/icon/'.$auther_photo),'#',array('escape'=>false)); 
					}
					else {
						echo $this->Html->link($this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('width'=>50)),'#',array('escape'=>false)); 
					}
				}else{
					echo $this->Html->link($this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('width'=>50)),'#',array('escape'=>false)); 
				}
				?>
                   
        		</div>
        	<div class="blogtitle"> 
        		<h1><?php echo $this->Html->link($auther_fullname,array('controller'=>'pub','action'=>$pub_profile),array());?></h1>
        		<?php echo $auther_tags; ?>
        	</div>
			</div>
			<div class="clear"></div>
		</div>
		
	
		
        <div id="social_share"></div>
		<div class="marginbottom15">
			<div class="blogslisitng-pic1" style="text-align:center;">
				<h1 style="text-align:left; margin-bottom:15px;"><a style="text-align:left; font-weight:bold; font-size:16px;"><?php echo $post__Detail_Row['blogs']['post_title'];?></a></h1>
				<?php 
				if($blogImage){
					echo $this->Html->Image(MEDIA_URL.'/files/blog/original/'.$blogImage,array('style'=>'max-width:677px;text-align:center;')); 
                                        echo $this->Html->meta(array('property' => 'og:image', 'content' => MEDIA_URL . '/files/blog/original/' . $blogImage),'',array('inline'=>false));
				}else{
					echo $this->Html->Image(MEDIA_URL.'/img/nologo.jpg',array('style'=>'max-width:650px;'));
				}
				?>
			</div>
			
			<div class="clear">&nbsp;</div>
			<?php echo $this->Html->css(array('/js/ckeditor/contents.css','/js/ckeditor/skins/moono/editor_gecko.css?t=DBAA')); ?>
			
			<?php echo $post__Detail_Row['blogs']['description'];?>
		</div> 
		<div>
			<div class="blogby">
				<span class="redcolor">
					<?php foreach ($post_Have_Tags as $tag_for_Post) {
							if ($tag_for_Post['post_tags']['id'] = $postId) {
								if ($tag_for_Post['tags']['post_tag']) {
								echo '<a class="tagblock">'.$tag_for_Post['tags']['post_tag'].'</a>';
								}
							}}?>
				</span>
			</div>
			<div class="blog-bttns">
				<ul>
					<li>
						<span id="spanDiv">
						<?php if($uid == $user_like && $like == 1) {?>
							<a class="poplight" href="javascript:likePost('<?php echo $postId?>','0');">Liked&nbsp;<?php if($total_like_on_post) echo '<span class="redcolor">('.$total_like_on_post.')</span>';?></a>
						<?php } else {?>
							<a class="poplight" href="javascript:likePost('<?php echo $postId?>','1');">Like&nbsp;<?php if($total_like_on_post) echo '<span class="redcolor">('.$total_like_on_post.')</span>';?></a>
						<?php } ?>
						</span>
                        
                        
                        
       <!--LIKE BOX start-->                 
     <div id="wholikebox<?php echo $postId;?>"  class="share_popup_ajax" style="width:500px;">
            <div class="close" onclick="disablePopup('<?php echo $postId;?>','like')"></div>
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
 		<!--LIKE BOX END-->   
					</li>
					<li>
                    <?php if($uid) {?>
						<a class="poplight" href="#?" rel="sharecontent">Share</a>
                     <?php } else {?>
                     <a class="poplight" href="javascript:loadSharePopup('<?php echo $postId;?>')">Share</a>
                     <?php }?>
                        <a class="totalnumber" href="javascript:loadLikesPopup('<?php echo $postId;?>','share')"><span class="redcolor"><?php echo '('.$count.')';?></span></a>
                        
                         <!--SHARE BOX start-->                 
     					<div id="whosharebox<?php echo $postId;?>"  class="share_popup_ajax" style="width:500px;">
                            <div class="close" onclick="disablePopup('<?php echo $postId;?>','share')"></div>
                    <!--your content start-->
                          <div class="heading"><h1>People Who Share This Blog</h1></div>
                            <div class="scroller">
                            <?php foreach ($whoshareBlogs as $share_user) {
                                        $fullname = $share_user['users_profiles']['firstname']." ".$share_user['users_profiles']['lastname'];
                                ?>
                                <div class="wholike">
                                  <div class="wholike-pic">
                                    <?php 
                                        if(!empty($share_user['users_profiles']['photo'])&& file_exists(MEDIA_PATH.'/files/user/icon/'.$share_user['users_profiles']['photo'])){ 
                                            echo $this->Html->Image(MEDIA_URL.'/files/user/icon/'.$share_user['users_profiles']['photo'],array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$share_user['users_profiles']['user_id'])));
                                        }else{ 
                                            echo $this->Html->Image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$share_user['users_profiles']['user_id'])));
                                        }	
                                    ?>
                                  
                                  </div>
                                  <div class="wholike-rgt">
                                      <ul>
                                          <li style="list-style:none; padding:2px 0px; background:none; margin:0px; float:none;">
                                              <h1><?php echo $this->Html->link($fullname,array('controller'=>'users_profile','action'=>'userprofile',$share_user['users_profiles']['user_id']));?></h1>
                                          </li>
                                          <li style="list-style:none; padding:2px 0px; background:none; margin:0px;"><?php echo $share_user['users_profiles']['tags']?></li>
                                      </ul>
                                  </div>
                                  
                                <div class="clear"></div>
                              </div>
                         <?php }?> 
                      </div>
                        <!--your content end-->
                    </div>
 							<!--SHARE BOX END--> 
					</li>
				</ul>
				<div class="clear"></div>
				<input type="hidden" id="date_created" value="<?php echo $created = date('Y-m-d H:i:s');?>" />
                <input type="hidden" id="u_id" value="<?php echo $uid;?>" />
                <input type="hidden" id="content_type" value="blog" />
			</div>
			<div class="clear"></div>
		</div>
		<div id="ajax_res">
			<?php if ($total_like_on_post != 0) {?>
            <div class="wholike-div">
                <div class="icon-like"></div>
                    <ul>
                    <?php  $i = 1; $str = ''; $flag_set = false; $you = ''; $andcont = ''; $toltip = '';
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
                                 $you = '<li><div class="youtext"><a class="you-text" href="#user'.$user_id.'" onmouseover="tooltip.pop(this, '.$toll_tipID.')">You</a></div></li>';
                                 $andcont = 'and';
                                 $flag_set = true;
                            } else { 
                       $str .= '<li>';
                        $str .= '<a href="/users_profiles/userprofile/'.$user_id.'">
                        <img src="'.$like_user_photo.'" href="#user'.$user_id.'" onmouseover="tooltip.pop(this, '.$toll_tipID.')" /></a>';
                        // $str .= $this->Html->image($like_user_photo,array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$user_id)));
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
                        <li><a class="totalnumber" href="javascript:loadLikesPopup('<?php echo $postId;?>,'like')">
                        <strong><?php echo "+".$total_like_on_post;?></strong></a></li>
                        <?php } $i = 1; $andcont = ''; ?>
                    </ul>

                    <div class="clear"></div>
                </div>
             <?php }?>
           </div> 
                           
         <div class="clear"></div>
        <div><!-- Start -->
			<div class="heading">
			  <h2>Comments <?php  echo '&nbsp;(<span id="total_comments">'.sizeof($comments_on_post).'</span>)';?></h2>
			</div>
			<div class="clear"></div>
			
			<!--- Main Comment Box for Post ----->
			<div id="commentsDiv" style="display:none1" class="blogbox">
             <div id="blog_loader" style="display:none; text-align:center;">
				<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
		     </div>
			<div class="clear"></div>
            <span id="post_comments">
				<?php foreach ($comments_on_post as $comment_post_row) {
							$full_name = $comment_post_row['users_profiles']['firstname']." ".$comment_post_row['users_profiles']['lastname'];
							$created_date = $comment_post_row['Comment']['created'];
							$year = date("Y", strtotime($created_date));
							$month = date("M", strtotime($created_date));
							$day = date("d", strtotime($created_date));
							$time = date("H:i:s", strtotime($created_date));
							$comment_id = $comment_post_row['Comment']['id'];
						?>
				<!--- Comment Box ---->
				<div class="as_country_container" id="<?php echo $comment_id;?>">
				<div class="comment-listing" id="commentsbox">
					<div class="comment-listing-pic"> 
						
						<?php if ($comment_post_row['users_profiles']['photo']) {
								if (file_exists(MEDIA_PATH.'/files/user/icon/'.$comment_post_row['users_profiles']['photo'])) {
									echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$comment_post_row['users_profiles']['photo'],array());
								}
								else {
									echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array());
								}
						}
						else {
							echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array());
						}?>
					</div>
					
					<div class="comment-listing-rgt">
						<ul>
							<li> <a href="#"><?php echo $full_name; ?></a> <?php echo $comment_post_row['Comment']['comment_text'];?> 
                            	 <?php if ($comment_post_row['Comment']['user_id'] == $uid || $blog_admin == $uid) {?>
                                <a href="javascript:" onclick="delete_comment('<?php echo $comment_id;?>','<?php echo $postId;?>');" class="comment-close" title="Delete Update">
                                </a>
        						<?php }?>
                            </li>
							<li class="posttime"><?php echo $day." ".$month.", ".$year."  @ ".$time; ?></li>
							<li>
								
								<a href="javascript:replyToComment('<?php echo $comment_id;?>');" id="reply<?php echo $comment_id;?>" class="replycomment">Reply</a>
								<div class="clear"></div>
								<div id="blog_reply_loader<?php echo $comment_id?>" style="display:none; text-align:center;">
									<?php echo $this->Html->image(MEDIA_URL.'/img/loading.gif');?>
		    					</div>
								<span id="reply_comments<?php echo $comment_id;?>"> 
								<?php foreach ($reply_to_comments as $reply__Row) {
										$full_name = $reply__Row['users_profiles']['firstname']." ".$reply__Row['users_profiles']['lastname'];
										$created_dates = $reply__Row['Comment']['created'];
										$year = date("Y", strtotime($created_dates));
										$month = date("M", strtotime($created_dates));
										$day = date("d", strtotime($created_dates));
										$time = date("H:i:s", strtotime($created_dates));
										$reply_id = $reply__Row['Comment']['id'];
											if ($reply__Row['Comment']['parent'] == $comment_id) {
										  ?>
								
								
								<div class="reply_container" id="<?php echo $reply_id;?>" style="display:none1;">
									<div class="comment-listing-pic2"> 
										<?php if ($reply__Row['users_profiles']['photo']) {
												if (file_exists(MEDIA_PATH.'/files/user/icon/'.$reply__Row['users_profiles']['photo'])) {
													echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$reply__Row['users_profiles']['photo'],array('style'=>'width:32px;'));
												}
												else {
													echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>'width:32px;'));
												}
											}
											else {
												echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('style'=>'width:32px;'));
											}?>
										
									</div>
                                    
									<div class="writecomment-rgt">
										<ul><li><a href="#"><?php echo $full_name; ?></a> <?php echo $reply__Row['Comment']['comment_text'];?>
                                        <?php if ($reply__Row['Comment']['user_id'] == $uid || $blog_admin == $uid || $comment_post_row['Comment']['user_id'] == $uid) {?>
                                <a href="javascript:" onclick="delete_reply('<?php echo $reply_id;?>','<?php echo $comment_id;?>');" class="comment-close" title="Delete Update">
                                </a>
        						<?php }?>
                                        </li></ul>
										<ul><li class="posttime"><?php echo $day." ".$month.", ".$year."  @ ".$time; ?></li></ul>
									</div>
									<div class="clear"></div>
								</div>
								 <?php }}?>   
								</span> 
								<div style="display:none;" id="reply_form<?php echo $comment_id;?>">
									
									<div class="comment-listing-pic2"> 
										<?php 
										if ($imgname) {
												if(file_exists(MEDIA_PATH.'/files/user/icon/'.$imgname)) {
													echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$imgname,array());
												}
												else {
													echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array());
												}
											}
											else {
												echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array());
											}
										?>
										
									</div>
									<div class="writecomment-rgt">
										<?php 
											echo $this->Form->textarea('user_comment',array('id'=>'user_comment_'.$comment_id,'class'=>'required','placeholder'=>"Your reply of maximum 75 characters...",'onclick'=>'expandComment('.$comment_id.');','onkeyup'=>'countChar(this,'.$comment_id.');','onkeydown'=>'checkField('.$comment_id.');'));
											echo $this->Form->input('user_id' , array('type' => 'hidden', 'value' => $uid,'id'=>'user_id'));
											echo $this->Form->input('admin_id' , array('type' => 'hidden', 'value' => $blog_admin,'id'=>'admin_id'));
											echo $this->Form->input('comment_admin_id' , array('type' => 'hidden', 'value' => $comment_id,'id'=>'comment_admin_id'));
											echo $this->Form->input('post_id' , array('type' => 'hidden', 'value' => $postId,'id'=>'post_id_'.$comment_id));
											echo $this->Form->input('parent_id' , array('type' => 'hidden', 'value' => $comment_id,'id'=>'parent_id_'.$comment_id));
											
										?>
										
										<div class="comments-bttn">
											<input name="send" type="button" id="send<?php echo $comment_id;?>" value="Reply" onClick="reply_to_comment(<?php echo $comment_id ?>);"  style="display:none; float:left; margin-right:5px;"/>
											<span id="comment_count_<?php echo $comment_id;?>">(75 characters)</span>
											
											<a href="javascript:close_reply('<?php echo $comment_id;?>');" id="cancel<?php echo $comment_id;?>" class="canclebutton-small">Cancel</a>
										</div>
									</div>
									<div class="clear"></div>
								</div>
							</li>
						</ul>
					</div>
					<div class="clear"></div>
				</div></div><?php  } ?>
			</span>
				<div class="clear"></div>
				<!--- End Comments Box --->
			<?php if ($uid) {?>
				<div class="writecomment">
					<div class="comment-listing-pic"> 
						
						<?php 
						if ($imgname) {
								if(file_exists(MEDIA_PATH.'/files/user/icon/'.$imgname)) {
									echo $this->Html->image(MEDIA_URL.'/files/user/icon/'.$imgname,array());
								}
								else {
									echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array());
								}
							}
					else {
						echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array());
					}
						?>
					</div>
                   
					<div class="writecomment-rgt">
						<?php 
							echo $this->Form->textarea('user_comment',array('id'=>'user_comment','placeholder'=>"Your comments maximum 75 characters...",'onclick'=>'expandForm();','onkeyup'=>'commentChar(this);','required'=>false));
							echo $this->Form->input('user_id' , array('type' => 'hidden', 'value' => $uid,'id'=>'user_id'));
							echo $this->Form->input('admin_id' , array('type' => 'hidden', 'value' => $blog_admin,'id'=>'admin_id'));
							echo $this->Form->input('post_id' , array('type' => 'hidden', 'value' => $postId,'id'=>'post_id'));
							echo $this->Form->input('parent' , array('type' => 'hidden', 'value' => 0,'id'=>'parent'));
							
						?>
						<br /> 
						<input name="send" type="button" id="send" value="Post Comment" onClick="add_post_comment();" />&nbsp; <span id="total_count">(75 characters)</span>
					</div>
                
					<div class="clear"></div>
				</div>
                 <?php }?>
				<!--- End Comments Box --->
				<div class="clear"></div>
			
			</div>
        	<!--- End of Main Comment Box for Post ----->
			<div class="clear"></div>
			
		</div><!-- End -->
			
<div id="sharecontent" class="popup_block" style="width:600px;"> <!--your content start-->
	<div class="heading">
		<h1>Share <?php echo '"'.$post__Detail_Row['blogs']['post_title'].'" on NetworkWE';?></h1>
	</div>
	<div class="clear"></div>
	<div class="marginbottom15">
		<div class="blogslisitng-pic">
			
			<?php 
			if($blogImage){
				echo $this->Html->Image(MEDIA_URL.'/files/blog/original/'.$blogImage,array('style'=>'max-width:650px;text-align:center;')); 
			}else{
				echo $this->Html->Image(MEDIA_URL.'/img/nologo.jpg',array('style'=>'max-width:650px;'));
			}
			?>
		</div>
		<?php echo substr($desc,0,600);?>
		
		
	</div> 
	<div class="clear"></div>
	<form id="share_form" name="share_form" action="/blogs/add" method="post">
		<div class="mini-form">
			<input type="hidden" name="data[Blog][user_id]" id="user_id" value="<?php echo $uid;?>" />
			<input type="hidden" name="data[Blog][parent]" id="parent" value="<?php echo $post__Detail_Row['blogs']['id'];?>" />
		</div>
		<input type="submit" class="red-bttn rgt" value="Share" name="share" />
	</form>
</div><!--- Share Box Ends Here --->
			
	</div>
	<?php } ?>
		<div class="clear"></div>
		 <div id="loader" style="position:absolute; z-index:100px; left:36%; top:300px; text-align:center; display:none;"> 
			<?php echo $this->Html->Image(MEDIA_URL.'/img/loading.gif');?>	
		</div>
</div><!-- End of top div -->
<div id="backgroundPopup"></div>

<script>
	function checkField(commentID) {
		var fieldValue =  document.getElementById('user_comment_'+commentID).value;
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
function empty(data)
{	
	  if(typeof(data) == 'number' || typeof(data) == 'boolean')
	  {
		return false;
	  }
	  if(typeof(data) == 'undefined' || data === null)
	  {
		return true;
	  }
	  if(typeof(data.length) != 'undefined')
	  {
		 if (data.trim().length == 0) {
			return true;
		} 	    
		return data.length == 0;
	  }
	 
	
	  var count = 0;
	  for(var i in data)
	  {
		if(data.hasOwnProperty(i))
		{
		  count ++;
		}
	  }
	  return count == 0;
}

function add_post_comment() {
	$('#blog_loader').show();
	var user_comment = document.getElementById('user_comment').value;
	var admin_id = document.getElementById('admin_id').value;
	if(empty(user_comment)){
			alert("Please enter valid comment text");
			$('#blog_loader').hide();
			return false;
	}
	
	document.getElementById('send').disabled = true;
	//alert(category_title);
	var user_id = document.getElementById('user_id').value;
	var post_id = document.getElementById('post_id').value;
	
	//alert(user_id+"and"+post_id+"and"+user_comment);
	var LastDiv = $(".as_country_container:last"); /* get the first div of the dynamic content using ":first" */
	var LastId  = $(".as_country_container:last").attr("id"); /* get the id of the first div */
	$.ajax({
	url     : "/blogs/add_comments",
	type    : "POST",
	cache   : false,
	data    : {user_id: user_id,post_id:post_id,user_comment:user_comment,admin_id:admin_id},
	success : function(data){
		responseArray = data.split("::::");
		if(LastId){
			if(responseArray[1]){
					LastDiv.after(responseArray[1]); 
			}
		}
		else {
		$('#post_comments').html(responseArray[1]);	
		}
		$("#total_comments").html(responseArray[0]);
		document.getElementById('send').disabled = false;
	},
	complete: function () {
		$('#blog_loader').hide();
		document.getElementById('user_comment').value = '';
		$("#total_count").html('(75 characters)');
     },
	error : function(data) {
	$("#post_comments").html("there is error in your script.");
	}
	});		
}

function reply_to_comment(comment_id) {
	$('#blog_reply_loader'+comment_id).show();
$("#reply_comments"+comment_id).css('opacity', 0.2);

	var user_id = document.getElementById('user_id').value;
	var admin_id = document.getElementById('admin_id').value;
	var post_id = document.getElementById('post_id_'+comment_id).value;
	var user_comment = document.getElementById('user_comment_'+comment_id).value;
	//alert(user_id+"and"+post_id+"and"+user_comment);
	var ReplyDiv = $(".reply_container:last"); /* get the first div of the dynamic content using ":first" */
	var ReplyId  = $(".reply_container:last").attr("id"); /* get the id of the first div */
	
	$.ajax({
	url     : "/blogs/reply_to_comments",
	type    : "POST",
	cache   : false,
	data    : {user_id: user_id,post_id:post_id,user_comment:user_comment,parent:comment_id,admin_id:admin_id},
	success : function(data){
		//if(ReplyId){
		//if(data){
			//	ReplyDiv.after(data); 
		//}
		//}
		//else {
		$('#reply_comments'+comment_id).html(data);	
		//}
		$("#reply_form"+comment_id).slideUp('slow');
		$("#reply"+comment_id).show('slow');
		$("#cancel"+comment_id).hide('slow');
	},
	complete: function () {
		$('#blog_reply_loader'+comment_id).hide();
		document.getElementById('user_comment_'+comment_id).value = '';
		$("#comment_count_"+comment_id).html('(75 characters)');
		$("#reply_comments"+comment_id).css('opacity', 1);
		
     },
	error : function(data) {
	$("#reply_comments"+comment_id).html("there is error in your script.");
	}
	});		
}
function replyToComment(comment_id) {
	$("#reply"+comment_id).hide('slow');
	$("#cancel"+comment_id).show('slow');
	$("#reply_form"+comment_id).slideDown('slow');
}
function close_reply(comment_id) {
	$("#reply"+comment_id).show('slow');
	$("#cancel"+comment_id).hide('slow');
	$("#reply_form"+comment_id).slideUp('slow');
}

	/*likes on the article*/
function likePost(postid,like){

	var user_id = document.getElementById('u_id').value;
	var content_type = document.getElementById('content_type').value;
	var created = document.getElementById('date_created').value;
	var id = 0;
	$("#spanDiv").html('<img src="http://media.networkwe.com/img/loading.gif" />');
		//return false;
	$.ajax({
	url     : "/comments/add_like",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,content_type:content_type,content_id:postid,created:created,like:like,id:id},
	success : function(data){	
	responseArray = data.split("::");
		$("#spanDiv").html(responseArray[0]);
		$("#ajax_res").html(responseArray[1]);
	},
	error : function(data) {
	$("#spanDiv").html("error");
	}
	});
	}
	function expandComment(id) {
	$('#user_comment_'+id).css({
				'height' : '60px'
			});
}
function countChar(val,commentid) {
        var len = val.value.length;
        if (len > 75) {
          val.value = val.value.substring(0, 75);
		  document.getElementById('user_comment_'+commentid).disabled = true;
        } else {
          $('#comment_count_'+commentid).text(75 - len+' characters');
        }
 }
 
 function expandForm() {
$('#user_comment').css({
            'height' : '60px'
        });
}
function commentChar(val) {
        var len = val.value.length;
        if (len > 75) {
          val.value = val.value.substring(0, 75);
		  //document.getElementById('user_comment').disabled = true;
		  document.getElementById('send').disabled = true;
        } else {
          $('#total_count').text(75 - len+' characters');
          document.getElementById('send').disabled = false;
        }
 }
 
 function delete_comment(comment_id,content_id) {
	 $('#blog_loader').show();
	var checkstr =  confirm('Are you want to delete this?');
		if(checkstr == true){
  			$.ajax({
					url     : baseUrl+"/blogs/delete_comment",
					type    : "GET",
					cache   : false,
					data    : {comment_id: comment_id,content_id:content_id},
					success : function(data){
						//if (share == 1) {
					//$("#message_update").slideDown('slow');
					//$("html, body").animate({ scrollTop: 0 }, "slow");
					$("#total_comments").html(data);
					//$("#message_comment").slideDown('slow').delay(1000).fadeOut();
					$("#"+comment_id).slideUp('slow');
						//}
					},
					complete: function() {
					$('#blog_loader').hide();
					$("#"+comment_id).css({ opacity: 0.6 });		
					},
					error : function(data) {
					$("#"+comment_id).html(data);
					}
			});
		}
		else{
		return false;
		}
}

function delete_reply(comment_id,content_id) {
	$('#blog_loader').show();
	var checkstr =  confirm('Are you want to delete this?');
		if(checkstr == true){
  			$.ajax({
					url     : baseUrl+"/blogs/delete_reply",
					type    : "GET",
					cache   : false,
					data    : {comment_id: comment_id,content_id:content_id},
					success : function(data){
						//if (share == 1) {
					//$("#message_update").slideDown('slow');
					//$("html, body").animate({ scrollTop: 0 }, "slow");
					//$("#message_comment").slideDown('slow').delay(1000).fadeOut();
					$("#"+comment_id).slideUp('slow');
						//}
					},
					complete: function() {
					$('#blog_loader').hide();
					$("#"+comment_id).css({ opacity: 0.6 });		
					},
					error : function(data) {
					$("#"+comment_id).html(data);
					}
			});
		}
		else{
		return false;
		}
}
</script>
    
<script>
function loadLikesPopup(ID,type) {
	if (type == 'like') {
		$("#wholikebox"+ID).fadeIn(0500); // fadein popup div
	}
	else {
		$("#whosharebox"+ID).fadeIn(0500); // fadein popup div	
	}
	$("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
	$("#backgroundPopup").fadeIn(0001);
}
function disablePopup(ID,type) {
	if (type == 'like') {
		$("#wholikebox"+ID).fadeOut("normal");
	}
	else {
		$("#whosharebox"+ID).fadeOut("normal");
	}
$("#backgroundPopup").fadeOut("normal");
}
</script>