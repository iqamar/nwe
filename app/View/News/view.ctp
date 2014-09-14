<style>
a.follow,a.unfollow {
    background: none repeat scroll 0 0 #c70000;
    border: 1px solid #b00314;
    border-radius: 3px;
    color: #fff;
    cursor: pointer;
    float: right;
    font-weight: bold;
    padding: 4px 15px;
	 margin-top: 5px;
	 
}
a.unfollow:hover,a.follow:hover {
    background: none repeat scroll 0 0 #c70000;
    border: 1px solid #b00314;
    border-radius: 3px;
    color: #fff;
    cursor: pointer;
    float: right;
    font-weight: bold;
    padding: 4px 15px;
	 margin-top: 5px;
	 
}


</style>
<script type="text/javascript">
     function add_post_comment() {
        //$("#post_comments").html('<img src="http://media.networkwe.com/img/loading.gif" style="text-align:center;" />');
        $('#loader').show();
        var user_id = $('#user_id').val();
        var post_id = $('#post_id').val();
        var user_comment = $('#user_comment').val();
        ;
        var LastDiv = $(".as_country_container:last"); /* get the first div of the dynamic content using ":first" */
        var LastId = $(".as_country_container:last").attr("id"); /* get the id of the first div */
        $.ajax({
            url: "/news/add_comments",
            type: "POST",
            cache: false,
            data: {user_id: user_id, news_id: post_id, user_comment: user_comment},
            success: function(data) {
				responseArray = data.split(":::");
                if (LastId) {
                    if (data) {
						$("#total_comments").html(responseArray[0]);
                        LastDiv.after(responseArray[1]);
						
                    }
                }
                else {
					$("#total_comments").html(responseArray[0]);
                    $('#post_comments').html(responseArray[1]);
					
                }
            },
            complete: function() {
                $('#loader').hide();
                $('#user_comment').val('');
				$('#total_count').html('(75 characters))');
                //$("#post_comments").css('opacity', 1);
            },
            error: function(data) {
                $("#post_comments").html("there is error in your script.");
            }
        });
    }

    function reply_to_comment(comment_id) {
        //$("#reply_comments" + comment_id).css('opacity', 0.2);
        $('#loader').show();
        var user_id = $('#user_id').val();
        var post_id = $('#post_id_' + comment_id).val();
        var user_comment = $('#user_comment_' + comment_id).val();
        var ReplyDiv = $(".reply_container:last"); /* get the first div of the dynamic content using ":first" */
        var ReplyId = $(".reply_container:last").attr("id"); /* get the id of the first div */

        $.ajax({
            url: "/news/add_comments/reply",
            type: "POST",
            cache: false,
            data: {user_id: user_id, news_id: post_id, user_comment: user_comment, parent: comment_id},
            success: function(data) {
                $('#reply_comments' + comment_id).html(data);
                $("#reply_form" + comment_id).slideUp('slow');
                $("#reply" + comment_id).show('slow');
                $("#cancel" + comment_id).hide('slow');
            },
            complete: function() {
                $('#loader').hide();
                $('#user_comment_'+ comment_id).val('');
				$('#comment_count_'+ comment_id).html('(75 characters))');
               // $("#reply_comments" + comment_id).css('opacity', 1);
            },
            error: function(data) {
                $("#reply_comments" + comment_id).html("there is error in your script.");
            }
        });
    }

    function countChar(val, commentid) {
        var len = val.value.length;
        if (len > 75) {
            val.value = val.value.substring(0, 75);
            document.getElementById('user_comment_' + commentid).disabled = true;
        } else {
            $('#comment_count_' + commentid).text(75 - len + ' characters');
        }
    }

    function commentChar(val) {
        var len = val.value.length;
        if (len > 75) {
            val.value = val.value.substring(0, 75);
            document.getElementById('user_comment').disabled = true;
        } else {
            $('#total_count').text(75 - len + ' characters');
        }
    }

    function expandComment(id) {
        $('#user_comment_' + id).css({
            'height': '60px',
			'color': '#333'
        });
    }

    function expandForm() {
        $('#user_comment').css({
            'height': '60px',
			'color': '#333'
        });
    }

    function replyToComment(comment_id) {
        $("#reply" + comment_id).hide('slow');
        $("#cancel" + comment_id).show('slow');
        $("#reply_form" + comment_id).slideDown('slow');
    }

    function close_reply(comment_id) {
        $("#reply" + comment_id).show('slow');
        $("#cancel" + comment_id).hide('slow');
        $("#reply_form" + comment_id).slideUp('slow');
    }
	
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
<?php
echo $this->Html->css(array(MEDIA_URL . '/css/jquery.share.css'),'',array('inline'=>false));
echo $this->Html->script(array(MEDIA_URL . '/js/jquery.share.js'),'',array('inline'=>false));
?>
<div class="clear"></div>
<div class="box margintop15">
    <?php
    foreach ($news_detail as $news_single_Row) {
        $auther_fullname = $news_single_Row['users_profiles']['firstname'] . " " . $news_single_Row['users_profiles']['lastname'];
        $newsId = $news_single_Row['News']['id'];
        $created_date = $news_single_Row['News']['created'];
        $year = date("Y", strtotime($created_date));
        $month = date("M", strtotime($created_date));
        $day = date("d", strtotime($created_date));
        $time = date("H:i:s", strtotime($created_date));
        $pub_profile = $news_single_Row['users_profiles']['handler'];
		$count = $news_single_Row['News']['share'];
        $title_url = str_replace(" ", "-", strtolower($news_single_Row['News']['heading']));
        $news_url = $news_single_Row['News']['news_url'];
		$rss_link = $news_single_Row['News']['rss_link'];
        echo $this->Html->meta(array('property' => 'og:title', 'content' => $news_single_Row['News']['heading']),'',array('inline'=>false));
        echo $this->Html->meta(array('property' => 'og:type', 'content' => 'article'),'',array('inline'=>false));
        echo $this->Html->meta(array('property' => 'og:article:author', 'content' => $auther_fullname),'',array('inline'=>false));
        echo $this->Html->meta(array('property' => 'og:article:published_time', 'content' => date("d:m:Y H:i:s", strtotime($created_date))),'',array('inline'=>false));
        echo $this->Html->meta(array('property' => 'og:description', 'content' => strip_tags($news_single_Row['News']['details'])),'',array('inline'=>false));
        //echo $this->Html->meta(array('property' => 'og:url', 'content' => NETWORKWE_URL . $this->here),'',array('inline'=>false));
        ?>
            <script>
				if (typeof jQuery != 'undefined') {  
				// jQuery is loaded => print the version
				
				 jQuery(document).ready(function() {
                    jQuery('#social_share').share({
                        networks: ['facebook','twitter','linkedin','pinterest','tumblr','googleplus','digg','stumbleupon','email'],
                        orientation: 'vertical',
                        affix: 'left center',
                        pageTitle: '<?= htmlentities($news_single_Row['News']['heading'], ENT_QUOTES)?>',
                        theme: 'square'
                    });
                });
				  
				  }
                
            </script>
			<ul class="etabs">
				<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/news/userarticles">Articles</a></li>
				<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/news/" class="current">All Articles</a></li>
				<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/news/add_article/">Add Articles</a></li>
			</ul>
			<?php 
	
		$author_name = $news_single_Row['users_profiles']['firstname'].' '.$news_single_Row['users_profiles']['lastname'];
		$imgname = $news_single_Row['users_profiles']['photo'];
		$author_tags = $news_single_Row['users_profiles']['tags'];
		$user_id= $news_single_Row['users_profiles']['user_id'];
	?>
	<div class="tweets-user">
		<div class="tweets-user-pic">
			<?php if(!empty($imgname)&& file_exists(MEDIA_PATH.'/files/user/logo/'.$imgname)){ 
						echo $this->Html->image(MEDIA_URL.'/files/user/logo/'.$imgname,array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$user_id))); 
					}else{ 
						echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$user_id))); 
					}  
			?>
		</div>
		<div class="tweets-user-rgt"> 
			
		<?php if($friend_id!=$uid){?>
			<!-- User Follow Start-->
			<div id="user_following_btn">
			  <?php 
			  if (sizeof($checkUserFollowings)== 0 ){?>
				<a href="Javascript:userFollow('2');" id="follow_user1" class="current buttonrgt margintop10"><?php echo __('Follow');?></a>
			  <?php } 
			  else {
					if ($following_status == 2) {
				?>
					 <a href="Javascript:userFollow('0',<?php echo $following_id ?>);" id="following_user1" class="buttonrgt margintop10"><?php echo __('Following');?></a>
			  <?php }
					else {
					?>
					<a href="Javascript:userFollow('2',<?php echo $following_id ?>);" id="follow_user1" class="buttonrgt margintop10">Unfollow</a>
			  <?php }}?>
			</div>
			<input type="hidden" name="u_id" id="u_id" value="<?php echo $uid;?>" />
			<input type="hidden" name="content_type" id="content_type" value="news" />
			<input type="hidden" name="following_id" id="following_id" value="<?php echo $friend_id;?>" />
			<input type="hidden" name="start_date" id="start_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
			<input type="hidden" name="end_date" id="end_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
			<!-- User Follow End-->   
			<?php }else{
				
				if ($uid) {
					echo $this->html->link('Post Article','/news/add_article/',array('class'=>'buttonrgt margintop10','escape'=>false));
				}
				else {	
					echo '<a href="#" class="buttonrgt margintop10">Post Article</a>';
				}
			} ?>
			
		  <ul>
			<li>
			  <h1><?php echo $this->Html->link($author_name,array('controller'=>'users_profiles','action'=>'userprofile/'.$user_id));  ?></h1>
			</li>
			<li><?php echo $author_tags; ?></li>
			<li>
			  <div class="tweetactivities-div"> 
			  <?php echo $articlesCount; ?><strong> Articles </strong>
			  
				<div class="clear"></div>
			  </div>
			</li>
		  </ul>
		</div>
		<div class="clear"></div>
	</div>
        <div class="blogslisitng">
            <div class="blogdate">
                <span><?php echo $day; ?></span>
                <span class="smalltext"><?php echo $month; ?></span><br/>
                <span class="smalltext"><?php echo $year; ?></span>
            </div>
            <div class="blogtopdiv">
                <div class="blogtopdiv1" style="margin:5px 60px 15px 0px;">
                    <h1><?php echo htmlspecialchars_decode($news_single_Row['News']['heading'], ENT_NOQUOTES); ?></h1>
                </div>
                <div class="clear"></div>
				<div id="social_share"></div>
            
            </div>
            <div class="clear">&nbsp;</div>
            <div class="marginbottom15">
                <div class="blogslisitng-pic1" style="text-align:center;">
                    <?php
                    if ($news_single_Row['News']['image_url'] && file_exists(MEDIA_PATH . '/files/news/original/' . $news_single_Row['News']['image_url'])) {
                        echo $this->Html->Image(MEDIA_URL . '/files/news/original/' . $news_single_Row['News']['image_url'], array('style' => 'max-width:677px;text-align:center;'));
                        echo $this->Html->meta(array('property' => 'og:image', 'content' => MEDIA_URL . '/files/news/logo/' . $news_single_Row['News']['image_url']),'',array('inline'=>false));
                        ?>  <?php
                    } else {
                        echo $this->Html->Image(MEDIA_URL . '/img/nologo.jpg', array('style' => 'max-width:650px;'));
                    }
                    ?>
                </div>
                <div class="clear">&nbsp;</div>
                <p style="text-align:start"><?php echo htmlspecialchars_decode($news_single_Row['News']['details']); ?></p>
				<div class="clear">&nbsp;</div>
				
				<?php if($news_url){echo 'Source URL: '.$this->html->link($news_url,$news_url,array('escape'=>false));} ?><br/>
				
				<?php if($rss_link){echo 'RSS Link: '.$this->html->link($rss_link,$rss_link,array('escape'=>false));} ?>
				
            </div>
            
			<div class="clear"></div>
            <div><!-- Start -->
            
            
            <div class="blog-bttns">
				<ul>
					<li>
						<span id="spanDiv">
						<?php if($uid == $user_like && $like == 1) {?>
							<a class="poplight" href="javascript:likePost('<?php echo $newsId?>','0');">Liked&nbsp;<?php if($total_like_on_post) echo '<a class="totalnumber" href="javascript:loadLikesPopup('.$newsId.','."'like'".')"><span class="redcolor">('.$total_like_on_post.')</span></a>';?></a>
						<?php } else {?>
							<a class="poplight" href="javascript:likePost('<?php echo $newsId?>','1');">Like&nbsp;<?php if($total_like_on_post) echo '<a class="totalnumber" href="javascript:loadLikesPopup('.$newsId.','."'like'".')"><span class="redcolor">('.$total_like_on_post.')</span></a>';?></a>
						<?php } ?>
						</span>
                   <!--LIKE BOX start-->                 
                     <div id="wholikebox<?php echo $newsId;?>"  class="share_popup_ajax" style="width:500px;">
                        <div class="close" onclick="disablePopup('<?php echo $newsId;?>','like')"></div>
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
						<a href="#?" rel="sharecontent" class="poplight">Share</a>
                        <a class="totalnumber" href="javascript:loadLikesPopup('<?php echo $newsId;?>','share')"><span class="redcolor"><?php echo '('.$count.')';?></span></a>
                        
                         <!--SHARE BOX start-->                 
     					<div id="whosharebox<?php echo $newsId;?>"  class="share_popup_ajax" style="width:500px;">
                            <div class="close" onclick="disablePopup('<?php echo $newsId;?>','share')"></div>
                    <!--your content start-->
                          <div class="heading"><h1>People Who Share This News</h1></div>
                            <div class="scroller">
                            <?php foreach ($whoshareNews as $share_user) {
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
                <div id="backgroundPopup"></div>
				<div class="clear"></div>
				<input type="hidden" id="date_created" value="<?php echo $created = date('Y-m-d H:i:s');?>" />
                <input type="hidden" id="u_id" value="<?php echo $uid;?>" />
                <input type="hidden" id="content_type" value="news" />
			</div>
            
            
                <div class="heading">
                    <h2><?php echo 'Comments (<span id="total_comments">' . sizeof($comments_on_news).'</span>)'; ?></h2>
                </div>
                <div class="clear"></div>
                
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
                                <li><a class="totalnumber" href="javascript:loadLikesPopup('<?php echo $newsId;?>','like')">
                                <strong><?php echo "+".$total_like_on_post;?></strong></a></li>
                                <?php } $i = 1; $andcont = ''; ?>
                            </ul>

                            <div class="clear"></div>
                        </div>
                     <?php }?>
                   </div> 
                           
                <div class="clear"></div>
                <!--- Main Comment Box for Post----->
                <div id="commentsDiv" style="display:none1" class="blogbox">
                    <div class="clear"></div>
                    <!--- Comment Box---->
                    <div id="loader" style="text-align:center; display:none;">
						<?php echo $this->Html->image(MEDIA_URL . '/img/loading.gif'); ?>
    				</div>
                    <div id="post_comments">
                    <?php
                    foreach ($comments_on_news as $comment__Row) {
                        $user_photo = $comment__Row['users_profiles']['photo'];
                        $handler = $comment__Row['users_profiles']['handler'];
                        $full_name = $comment__Row['users_profiles']['firstname'] . " " . $comment__Row['users_profiles']['lastname'];
                        $created_date = $comment__Row['Comment']['created'];
                        $year = date("Y", strtotime($created_date));
                        $month = date("M", strtotime($created_date));
                        $day = date("d", strtotime($created_date));
                        $commentid = $comment__Row['Comment']['id'];
                        $time = date("H:i:s", strtotime($created_date));
						$comment_user = $comment__Row['Comment']['user_id'];
                        ?>
                        <div class="as_country_container" id="<?php echo $commentid; ?>">
                            <div class="comment-listing" id="commentsbox">
                            <?php if ($comment_user == $uid) {?>
								<a href="javascript:void(o)" onclick="delete_comment('<?php echo $commentid;?>','<?php echo $newsId?>');" class="comment-close" title="Delete Comment"></a>
                            <?php }?>
                                <div class="comment-listing-pic">
                                    <?php                                    
									if ($user_photo){
										if(file_exists(MEDIA_PATH.'/files/user/icon/'.$user_photo)){
											$comm_photo=MEDIA_URL.'/files/user/icon/'.$user_photo;
										}else{
											$comm_photo=MEDIA_URL.'/img/nophoto.jpg';
										}
									}
									else { 	
										$comm_photo=MEDIA_URL.'/img/nophoto.jpg'; 
									}
									echo $this->Html->image($comm_photo);
										
                                    ?>
                                </div>
                                <div class="comment-listing-rgt">
                                    <ul>
                                        <li><?php echo $this->Html->link($full_name, NETWORKWE_URL . '/pub/' . $comment__Row['users_profiles']['handler']); ?> <?php echo $comment__Row['Comment']['comment_text']; ?>
                                        </li>
                                        <li><span class="posttime"><?php echo $day . " " . $month . ", " . $year . "  @ " . $time; ?></span></li>
                                        <li>
                                            <a href="javascript:replyToComment('<?php echo $commentid; ?>');" id="reply<?php echo $commentid; ?>" class="replycomment">Reply</a>
                                            <div class="clear"></div>
                                            <span id="reply_comments<?php echo $commentid; ?>">
                                                <?php
                                                foreach ($reply_to_comments as $reply__Row) { 
                                                    $full_name = $reply__Row['users_profiles']['firstname'] . " " . $reply__Row['users_profiles']['lastname'];
                                                    $created_dates = $reply__Row['Comment']['created'];
                                                    $year = date("Y", strtotime($created_dates));
                                                    $month = date("M", strtotime($created_dates));
                                                    $day = date("d", strtotime($created_dates));
                                                    $time = date("H:i:s", strtotime($created_dates));
                                                    $reply_id = $reply__Row['Comment']['id'];
													$reply_user = $reply__Row['Comment']['user_id'];
                                                    if ($reply__Row['Comment']['parent'] == $commentid) {
                                                        ?>
                                                        <div class="reply_container" id="<?php echo $reply_id; ?>" style="display:none1;">
                                                            <div class="comment-listing-pic2"> 
                                                                <?php
																if ($reply__Row['users_profiles']['photo']){
																	if(file_exists(MEDIA_PATH.'/files/user/icon/'.$reply__Row['users_profiles']['photo'])){
																		$comm_photo=MEDIA_URL.'/files/user/icon/'.$reply__Row['users_profiles']['photo'];
																	}else{
																		$comm_photo=MEDIA_URL.'/img/nophoto.jpg';
																	}
																}
																else { 	
																	$comm_photo=MEDIA_URL.'/img/nophoto.jpg'; 
																}
																echo $this->Html->image($comm_photo,array('style' => 'width:32px;'));
																
                                                                ?>
                                                            </div>
                                                            <div class="writecomment-rgt">
                                                                <ul>
																<li>
                                                                <?php if ($reply_user == $uid) {?>
								<a href="javascript:void(o)" onclick="delete_reply('<?php echo $reply_id;?>','<?php echo $commentid?>');" class="comment-close" title="Delete Comment"></a>
                            								<?php }?>
																<?php 
																echo $this->Html->link($full_name, NETWORKWE_URL . '/pub/' . $reply__Row['users_profiles']['handler']); ?> 
																<?php echo $reply__Row['Comment']['comment_text']; ?></li>
                                                                </ul>
                                                                <ul>
                                                               	 	<li><span class="posttime"><?php echo $day . " " . $month . ", " . $year . "  @ " . $time; ?></span>
                                                                	</li>
                                                                </ul>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                    <?php }
                                                }
                                                ?> 
                                            </span>
                                            <div style="display:none;" id="reply_form<?php echo $commentid; ?>">
                                                <div class="comment-listing-pic2">
                                                    <?php
													if ($imgname){
														if(file_exists(MEDIA_PATH.'/files/user/icon/'.$imgname)){
															$comm_photo=MEDIA_URL.'/files/user/icon/'.$imgname;
														}else{
															$comm_photo=MEDIA_URL.'/img/nophoto.jpg';
														}
													}
													else { 	
														$comm_photo=MEDIA_URL.'/img/nophoto.jpg'; 
													}
													echo $this->Html->image($comm_photo);
                                                    
                                                    ?>
                                                </div>
                                                <div class="writecomment-rgt">
                                                    <?php
                                                    echo $this->Form->textarea('user_comment', array('id' => 'user_comment_' . $commentid, 'class' => 'required', 'placeholder' => "Your reply of maximum 75 characters...", 'onclick' => 'expandComment(' . $commentid . ');', 'onkeyup' => 'countChar(this,' . $commentid . ');'));
                                                    echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $uid, 'id' => 'user_id'));
                                                    echo $this->Form->input('post_id', array('type' => 'hidden', 'value' => $newsId, 'id' => 'post_id_' . $commentid));
                                                    echo $this->Form->input('parent_id', array('type' => 'hidden', 'value' => $commentid, 'id' => 'parent_id_' . $commentid));
                                                    ?>
                                                    <div class="comments-bttn">
                                                        <input name="send" type="button" id="send" value="Reply" onClick="reply_to_comment(<?php echo $commentid ?>);"/>
                                                        <span id="comment_count_<?php echo $commentid; ?>">(75 characters)</span>
                                                 <a href="javascript:close_reply('<?php echo $commentid; ?>');" id="cancel<?php echo $commentid; ?>" class="canclebutton-small" style="float:right;">Cancel</a>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
   				 <?php } ?>
                 </div><!--- End Post Comment ID--->
                 
                    <!--- End Comments Box--->
                    <div class="clear"></div>
                    <?php if ($uid) {?>
                    <div class="writecomment">
                        <div class="comment-listing-pic">
                            <?php
                           if ($imgname){
								if(file_exists(MEDIA_PATH.'/files/user/icon/'.$imgname)){
									$comm_photo=MEDIA_URL.'/files/user/icon/'.$imgname;
								}else{
									$comm_photo=MEDIA_URL.'/img/nophoto.jpg';
								}
							}
							else { 	
								$comm_photo=MEDIA_URL.'/img/nophoto.jpg'; 
							}
							echo $this->Html->image($comm_photo);
                            ?>
                        </div>
                        <div class="writecomment-rgt">
                            <?php
                            echo $this->Form->textarea('user_comment', array('id' => 'user_comment', 'placeholder' => "Your comments maximum 75 characters...", 'onclick' => 'expandForm();', 'onkeyup' => 'commentChar(this);'));
                            echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $uid, 'id' => 'user_id'));
                            echo $this->Form->input('post_id', array('type' => 'hidden', 'value' => $newsId, 'id' => 'post_id'));
                            echo $this->Form->input('parent', array('type' => 'hidden', 'value' => 0, 'id' => 'parent'));
                            ?>
                            <br />
                            <input name="send" type="button" id="send" value="Post Comment" onClick="add_post_comment(0);" />&nbsp;
                            	<span id="total_count">(75 characters)</span>
                        </div>
                        <div class="clear"></div>
                    </div>
                  <?php }?>
                    <div class="clear"></div>
                </div>
                <!--- End of Main Comment Box for Post----->
                <div class="clear"></div>
            </div><!--End-->
        </div>
        
        
        <div id="sharecontent" class="popup_block" style="width:600px;"> <!--your content start-->
            <div class="heading">
                <h1>Share <?php echo '"'.$news_single_Row['News']['heading'].'" on NetworkWE';?></h1>
            </div>
            <div class="clear"></div>
            <div class="marginbottom15">
                <div class="blogslisitng-pic">
                    
                    <?php 
						$news_img = $news_single_Row['News']['image_url'];
                    if ($news_img && file_exists(MEDIA_PATH.'/files/news/logo/'.$news_img)) {
                        echo $this->Html->Image(MEDIA_URL.'/files/news/logo/'.$news_img,array('style'=>'max-width:650px;text-align:center;')); 
                    }else{
                        echo $this->Html->Image(MEDIA_URL.'/img/nologo.jpg',array('style'=>'max-width:650px;'));
                    }
                    ?>
                </div>
                <?php echo substr($news_single_Row['News']['details'],0,600);?>
                
                
            </div> 
            <div class="clear"></div>
            <form id="share_form" name="share_form" action="<?php echo NETWORKWE_URL;?>/news/add" method="post">
                <div class="mini-form">
                    <input type="hidden" name="data[News][user_id]" id="user_id" value="<?php echo $uid;?>" />
                    <input type="hidden" name="data[News][parent]" id="parent" value="<?php echo $news_single_Row['News']['id'];?>" />
                </div>
                <input type="submit" class="red-bttn rgt" value="Share" name="share" />
            </form>
        </div>
		<!--- Share Box Ends Here --->
        
        <?php
    }
    ?>
    <div class="clear"></div>
    
</div>
<script>
function delete_comment(comment_id,content_id) {
	$('#loader').show();
	var checkstr =  confirm('Are you want to delete this?');
		if(checkstr == true){
  			$.ajax({
					url     : baseUrl+"/news/delete_comment",
					type    : "GET",
					cache   : false,
					data    : {comment_id: comment_id,content_id:content_id},
					success : function(data){
						//if (share == 1) {
					//$("#message_update").slideDown('slow');
					//$("html, body").animate({ scrollTop: 0 }, "slow");
					//$("#message_tweet").slideDown('slow').delay(1000).fadeOut();
					$("#"+comment_id).slideUp('slow');
					responseArray = data.split(":::");
					$("#total_comments").html(data);
					//$("#total_added_tweets").html(responseArray[1]);
						//}
					},
					complete: function() {
					$('#loader').hide();
					$("#"+comment_id).css({ opacity: 0.6 });		
					},
					error : function(data) {
					$("#"+comment_id).html(data);
					}
			});
		}
		else {
			$('#loader').hide();
			return false;
		}
}

function delete_reply(reply_id,comment_id) {
	$('#loader').show();
	var checkstr =  confirm('Are you want to delete this?');
		if(checkstr == true){
  			$.ajax({
					url     : baseUrl+"/news/delete_reply",
					type    : "GET",
					cache   : false,
					data    : {reply_id: reply_id,comment_id:comment_id},
					success : function(data){
					$("#"+reply_id).slideUp('slow');
					},
					complete: function() {
					$('#loader').hide();
					$("#"+reply_id).css({ opacity: 0.6 });		
					},
					error : function(data) {
					$("#"+reply_id).html(data);
					}
			});
		}
		else {
			$('#loader').hide();
			return false;
		}
}
</script>
<script>
function userFollow(status,id) {
		
	var user_id = document.getElementById('u_id').value;
	var following_type = document.getElementById('content_type').value;
	var following_id = document.getElementById('following_id').value;
	var start_date = document.getElementById('start_date').value;
	var end_date = document.getElementById('end_date').value;
	//alert(following_id+"and"+start_date+"and"+user_id+"and"+following_type);
	$.ajax({
	url     : baseUrl+"/comments/add_follow",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,following_type:following_type,start_date:start_date,following_id:following_id,end_date:end_date,status:status,id:id},
	success : function(data){	
	responseArrays = data.split("-");
	//alert(responseArrays);
	$("#resultantDiv").html(responseArrays[0]);
	$("#user_following_btn").html(responseArrays[1]);
	},
	error : function(data) {
	$("#resultantDiv").html("error");
	}
	});
}
</script>