 <?php if ($currentPostClick != "") {
	 	if ($this->Session->read(@$userid)) {
			$cuser = $this->Session->read(@$userid);
			$uid = $cuser['userid'];
		}
	 		foreach ($currentPostClick as $viewPost) {
	 ?>
 <div class="sub-prof-div" style="clear:both;">
   <div class="sub-profmain-div">
	<div class="profi-div txtcontainer" style="width:100%;">
	<div class="sub-profcolm">
		<div class="sub-proftxt"><h2><?php echo $viewPost['articles']['title'];?></h2>	
		</div>
	</div>	
    		<div class="social-sub-div" style="padding:0px 5px; border:none;">
        	<ul>
            <li><span class="artDate"><span class="txt">2013-11-06 15:27:14 </span></span></li>
            <li><span class="view"><span class="txt"></span></span></li>
            <li><span class="view"><span class="txt"></span></span></span></li>
            <li><span class="view">&nbsp;&nbsp;<span class="txt"></span></span></li>
             <li id="rateThis" style="display:none; text-align:right;">
             <span class="rating">
			 <?php 
			 for ($i=1; $i<=5; $i++) {
				echo $this->Html->image('rating-icon.png',array('style'=>'width:20px; height:20px; margin-right:3px; cursor:pointer','onClick=rateThisPost('.$i.')'));
			}
			
			?></span></li>
            </ul>
        </div>
        	
			<div class="social-sub-div" style="padding:0px 5px">
        	<ul>
            <li>
            <span class="artDate" style="padding:10px 0px 4px 5px;" id="rattingDiv">
            	<!-- check if current user already click ratting-->
            	<?php if ($postUser =='' && $postRatting =='') {?>
				<span style=" vertical-align:top; cursor:pointer;" onclick="showRatting();" id="rateLink">Rate this:&nbsp;&nbsp;</span>
                <?php }?>
				<?php for ($i=1; $i<=5; $i++) {
				if ($i<=$countedRate){
				echo $this->Html->image('golden-star.png',array('style'=>'width:15px; height:15px; margin-right:3px;'));
				}else {
				echo $this->Html->image('star-icon1.png',array('style'=>'width:15px; height:15px; margin-right:3px;'));  }
			}?></span></li>
            <li><span class="view view-icon">&nbsp;&nbsp;<span class="txt" style="padding-left:38px;"><?php if ($setCounters) echo $setCounters; ?></span></span></li>
            <li><span class="view like-icon">&nbsp;&nbsp;
            <?php if ($postLikeUser =='' && $postLikes == '') { ?>
            <span id="spanDiv">
            <a style="cursor:pointer" href="Javascript:likeMe('<?php echo $viewPost['articles']['id']?>','1');" id="doLike">
            <span class="txt" style="padding-left:33px;"><?php echo $totalLikes;?></span></a></span>
            <?php } else  {?>
            <span class="txt" style="padding-left:33px;"><?php echo $totalLikes;?></span>
            <?php }?>
            
            </span></li>
            
            <li><span class="view comments-icon">&nbsp;&nbsp;<a style="cursor:pointer" id="writeComment">
            <span class="txt" style="padding-left:33px;"><?php echo $countComments;?></span></a></span></li>
            
            <li><span class="view followers-icon">&nbsp;&nbsp;<span class="txt" style="padding-left:33px;" id="followDiv"><?php echo $totalFollows;?></span></span></li>
             <li>
             <!-- check if current user already click following-->
             <span class="view" id="follow-Btn">&nbsp;&nbsp;<?php 
			 if ($postFollowUser =='' && $postFollowRatting == '') {
			 echo $this->Html->image('follow-button.png',array('style'=>'width:60px; height:27px; margin:3px 3px 0px 0px; cursor:pointer','onClick="followThisPost('.$viewPost['articles']['id'].')"'));
			 } else {
				
		    echo $this->Html->image('following-button.png',array('style'=>'width:60px; height:27px; margin:3px 3px 0px 0px;'));
			 }
			 ?></span>
             <!-- after clicking follow button change button to following-->
             <span class="view" id="following-Btn" style="display:none;">&nbsp;&nbsp;
			 <?php echo $this->Html->image('following-button.png',array('style'=>'width:60px; height:27px; margin:3px 3px 0px 0px;'));?> </span>
             </li>
            </ul>
        </div>          <?php //$currentDate = date('Y-m-d h:i:s'); ?>
        			<!-- TO GET USER ID , LIKE ID , LIKE DATE AND CONTENT TYPE FOR LIKE TABLE      USEING BY RATING ALSO-->
				<input type="hidden" name="u_id" id="u_id" value="<?php echo $uid;?>" />
				<input type="hidden" name="like_id" id="like_id" value="<?php echo $viewPost['likes']['id'];?>" />
				<input type="hidden" name="content_type" id="content_type" value="articles" />
			 	<input type="hidden" name="post_id" id="post_id" value="<?php echo $viewPost['articles']['id'];?>" />
				<input type="hidden" name="created" id="created" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
                <input type="hidden" name="start_date" id="start_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
                 <input type="hidden" name="end_date" id="end_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
                
                <!-- END -->
                
		<div class="profi-div article_photo" style="text-align:center;">	
        		<?php if ($viewPost['articles']['image']) {
						echo $this->Html->image('/images/'.$viewPost['articles']['image'],array('style'=>'clear:both;'));
						} else {
            			echo $this->Html->image('iOZu8vGd9ijM.jpg',array('style'=>'clear:both;'));
						}
				?>
				<!--<img src="images/iOZu8vGd9ijM.jpg" alt="article-picture" style="float:left;" />-->
			</div>
			<div class="sub-pro-txt">
			<p><?php echo $viewPost['articles']['content'];?></p>
				
				</div>
                <p>&nbsp;</p>
             <div class="comments_field" id="comments_" style="display:block; text-align:center; clear:both; width:100%;"> 
             <div class="relat-jobtxt" style="margin:10px 0px 10px 0px; text-align:left;"><h1>Comments:</h1></div>
             <?php 
			 if ($imgname != "") {
				echo $this->Html->image('/files/users/'.$imgname,array('style'=>'width:64px; height:64px; float:left; margin-right:40px; margin-top:10px;')); 
			 }
			 else {
			 	echo $this->Html->image('user-icon.png',array('style'=>'width:64px; height:64px; float:left; margin-right:40px; margin-top:10px;'));
			 }
			 ?>
             <form id="commentForm" name="coment_form" action="" method="post" style="width:580px; float:left;">
				<input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
				<input type="hidden" name="id" id="id" value="<?php //echo $sharepost['likes']['id'];?>" />
				<input type="hidden" name="comment_type" id="comment_type" value="articles" />
			 <input type="hidden" name="content_id" id="content_id" value="<?php echo $viewPost['articles']['id'];?>" />
				<input type="hidden" name="comment_date" id="comment_date" value="<?php echo $date = date("Y-m-d");?>" />
		  <textarea rows="5" cols="55" class="user_coments" placeholder="Put your comments..." name="comment_text" id="comment_text" style="width:580px; float:left;"></textarea>
				
                <span style="float:right;">
                <a href="Javascript:saveComment('0');" class="inpt-btn" style="text-decoration:none; margin-top:5px;">Comment</a></span>
			</form>
        </div>
        <!-- user comments start here-->
     <div id="userComments">
     	<?php 
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
           				<li><span class="view like-icon">&nbsp;&nbsp;
                        <span id="commentDiv_<?php echo $singleComment['comments']['id'];?>">
                        <?php if ($singleComment['comment_likes']['like']== 0 && $singleComment['comment_likes']['user_id'] != $uid) {?>
                        <a style="cursor:pointer" href="Javascript:likeComment('<?php echo $singleComment['comments']['id']?>','1');" id="doLike">
                        <span class="txt" style="padding-left:33px;"><?php echo $singleComment[0]['total']?></span>
                        </a>
           <?php } else if ($singleComment['comment_likes']['like']== 1 && $singleComment['comment_likes']['user_id'] != $uid) {?>
                        <a style="cursor:pointer" href="Javascript:likeComment('<?php echo $singleComment['comments']['id']?>','1');" id="doLike">
                        <span class="txt" style="padding-left:33px;"><?php echo $singleComment[0]['total']?></span>
                        </a>
                        <?php } else if($singleComment['comment_likes']['like']== 1 && $singleComment['comment_likes']['user_id'] == $uid) { ?>
                        <span class="txt" style="padding-left:33px;"><?php echo $singleComment[0]['total']?></span>
                        <?php }?>
                        </span>
                        <input type="hidden" name="user_id" id="user_idd" value="<?php echo $uid;?>" />
					<input type="hidden" name="parent" id="like_id_<?php echo $singleComment['comments']['id'];?>"
                     value="<?php echo $singleComment['comments']['id'];?>" />
					<input type="hidden" name="comment_type" id="like_type" value="comments" />
					<input type="hidden" name="content_id" id="like_content_id_<?php echo $singleComment['comments']['id'];?>"
                     value="<?php echo $viewPost['articles']['id'];?>" />
					<input type="hidden" name="comment_date" id="created_<?php echo $singleComment['comments']['id'];?>"
                     value="<?php echo $date = date("Y-m-d");?>" />
                        </span></li>
         			 	<li><span class="view">&nbsp;&nbsp;
                     		<span class="txt">
                            <a href="Javascript:showReplyForm('<?php echo $singleComment['comments']['id'];?>');" style="text-decoration:none; padding:0px 5px;"> Reply<?php if ($countReplys) {
							foreach ($countReplys as $articleReplysOn) { 
							//echo $articleReplysOn['comments']['id'];
								if ($articleReplysOn['comments']['parent'] == $singleComment['comments']['id']) { 
							echo "(".$articleReplysOn[0]['total_reply'].")";
							}
							}
							}
							else {
								echo "(0)";
							}
							?>
                            </a>
                            </span></span></li>
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
					<input type="hidden" name="content_id" id="content_id_<?php echo $singleComment['comments']['id'];?>" value="<?php echo $viewPost['articles']['id'];?>" />
					<input type="hidden" name="comment_date" id="comment_date_<?php echo $singleComment['comments']['id'];?>" value="<?php echo $date = date("Y-m-d");?>" />
					<textarea rows="5" cols="55" class="user_coments" placeholder="Put your reply here..." name="comment_text" id="comment_text_<?php echo $singleComment['comments']['id'];?>" style="width:540px; float:left;"></textarea>
                		<span style="float:right;">
             			<a href="Javascript:saveComment('<?php echo $singleComment['comments']['id'];?>');" class="inpt-btn" style="text-decoration:none; margin-top:5px;">Reply</a>
                        </span>	
					</form>
         	 </div><!--comment on comment form end--> 
             
             	<!--comment on comment listing start--> 
                <?php foreach ($userCommentsOnComments as $commentsOnComment) {
						if ($commentsOnComment['comments']['parent'] == $singleComment['comments']['id']) {
					?>   
       			 <div class="relat-jobmain-div">
  					<div class="relat-job-div">
  					  <div class="relat-jobcolm">
     					 <div class="relat-jobtxt">
      					  <h1><?php echo $commentsOnComment['users_profiles']['firstname']." ".$commentsOnComment['users_profiles']['firstname'];?></h1>
       						 <?php echo $commentsOnComment['comments']['comment_text'];?> </div>
   						 </div>
  					</div>
  							<div class="relat-job-pht">
							<?php if ($singleComment['users_profiles']['photo']) {
                            echo $this->Html->image('/files/users/'.$commentsOnComment['users_profiles']['photo'],array('style'=>'width:50px; height:50px;'));
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
 <?php }?>
        </div>
              <!-- user comments end here-->
		</div>
	  </div>
    </div>   
    <?php }}
		else {
			echo "Result not found against this article";	
		}?> 
    <script type="text/javascript">
	$( document ).ready(function() {
	$("#writeComment").click(function() {
     $('html, body').animate({
         scrollTop: $("#commentForm").offset().top
     }, 2000);
		 });
	});
	
	function showRatting() {
		$("#rateThis").slideDown('slow');
	}
	/*POST RATING*/
	function rateThisPost(rate) {
		
	var user_id = document.getElementById('u_id').value;
	var content_type = document.getElementById('content_type').value;
	var content_id = document.getElementById('post_id').value;
	//alert(rate+"and"+content_id+"and"+user_id+"and"+content_type);
	$.ajax({
	url     : baseUrl+"/comments/rateTheArticle",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,content_type:content_type,content_id:content_id,rate:rate},
	success : function(data){	
	//$(this).css('background','none');
	$("#rattingDiv").html(data);
	$("#rateThis").hide('slow');
	$("#rateLink").hide('slow');
	},
	error : function(data) {
	$("#rattingDiv").html("error");
	}
	});
	}
	
	/*POST RATING*/
	function followThisPost(following_id) {
		
	var user_id = document.getElementById('u_id').value;
	var following_type = document.getElementById('content_type').value;
	var content_id = document.getElementById('post_id').value;
	var start_date = document.getElementById('start_date').value;
	//alert(following_id+"and"+start_date+"and"+user_id+"and"+following_type);
	$.ajax({
	url     : baseUrl+"/comments/add_follow",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,following_type:following_type,start_date:start_date,following_id:following_id},
	success : function(data){	
	//$(this).css('background','none');
	$("#followDiv").html(data);
	$("#follow-Btn").css('display','none');
	$("#following-Btn").css('display','block');	
	},
	error : function(data) {
	$("#followDiv").html("error");
	}
	});
	}
	/*likes on the article*/
	function likeMe(postid,like){

	var user_id = document.getElementById('u_id').value;
	var content_type = document.getElementById('content_type').value;
	var content_id = document.getElementById('post_id').value;
	var created = document.getElementById('created').value;
	var id = document.getElementById('like_id').value;
		//return false;
	$.ajax({
	url     : baseUrl+"/comments/add_like",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,content_type:content_type,content_id:content_id,created:created,like:like,id:id},
	success : function(data){	
	//$(this).css('background','none');
	$("#spanDiv").html(data);
	},
	error : function(data) {
	$("#spanDiv").html("error");
	}
	});
	}
	/*likes on the comments*/
	function likeComment(postid,like){
	var user_id = document.getElementById('user_idd').value;
	var content_type = document.getElementById('like_type').value;
	var content_id = document.getElementById('like_content_id_'+postid).value;
	var created = document.getElementById('created_'+postid).value;
	var id = document.getElementById('like_id_'+postid).value;
		//alert(user_id+"and"+content_type+"and"+content_id+"and"+id);
		
		//return false;
	$.ajax({
	url     : baseUrl+"/comments/comment_like",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,content_type:content_type,content_id:content_id,created:created,like:like,id:id,comment_id:postid},
	success : function(data){	
	//$(this).css('background','none');
	$("#commentDiv_"+postid).html(data);
	},
	error : function(data) {
	$("#commentDiv_"+postid).html("error");
	}
	});
	}
	/*comments on the article*/
	function saveComment(parent){
	if (parent == 0) {
	var user_id = document.getElementById('user_id').value;
	var comment_type = document.getElementById('comment_type').value;
	var content_id = document.getElementById('content_id').value;
	var comment_date = document.getElementById('comment_date').value;
	var comment_text = document.getElementById('comment_text').value;
	}
	else if(parent != 0) {
	var user_id = document.getElementById('user_id').value;
	var comment_type = document.getElementById('comment_type').value;
	var content_id = document.getElementById('content_id_'+parent).value;
	var comment_date = document.getElementById('comment_date_'+parent).value;
	var comment_text = document.getElementById('comment_text_'+parent).value;
	}
	//alert(user_id+"and"+comment_type+"and"+content_id+"and"+comment_date+"and"+comment_text);
	//return false;
	$.ajax({
	url     : baseUrl+"/comments/add_comment",
	type    : "POST",
	cache   : false,
	data    : {user_id: user_id,comment_type:comment_type,content_id:content_id,comment_date:comment_date,comment_text:comment_text,parent:parent},
	success : function(data){
	$("#userComments").html(data);
	document.getElementById('comment_text').value = '';
	},
	error : function(data) {
	$("#userComments").html(data);
	}
	});

	}
	function showReplyForm(id) {
		$("#reply_"+id).slideToggle('slow');
	}
	
	</script>