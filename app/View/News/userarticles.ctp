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
<div class="tab-container" id="tab-container" data-easytabs="true">
	<ul class="etabs">
		<li class="tab active"><a href="<?php echo NETWORKWE_URL;?>/news/userarticles" class="active">Articles</a></li>
		<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/news/">All Articles</a></li>
		<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/news/add_article/">Add Articles</a></li>
	</ul>
	<?php 
	
		$author_name = $authorInfo['firstname'].' '.$authorInfo['lastname'];
		$imgname = $authorInfo['photo'];
		$author_tags = $authorInfo['tags'];
		$author_id = $authorInfo['user_id'];
	?>
	<div class="tweets-user">
		<div class="tweets-user-pic">
			<?php if(!empty($imgname)&& file_exists(MEDIA_PATH.'/files/user/logo/'.$imgname)){ 
						echo $this->Html->image(MEDIA_URL.'/files/user/logo/'.$imgname,array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$author_id))); 
					}else{ 
						echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('url'=>array('controller'=>'users_profiles','action'=>'userprofile',$author_id))); 
					}  
			?>
		</div>
		<div class="tweets-user-rgt"> 
			
		<?php if(isset($friend_id)){?>
			<!-- User Follow Start-->
			<div id="user_following_btn">
			  <?php 
			  if (sizeof($checkUserFollowings)== 0 ){?>
				<a href="Javascript:userFollow('2');" id="follow_user1" class="buttonrgt margintop10"><?php echo __('Follow');?></a>
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
			<input type="hidden" name="content_type" id="content_type" value="users" />
			<input type="hidden" name="following_id" id="following_id" value="<?php echo $friend_id;?>" />
			<input type="hidden" name="start_date" id="start_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
			<input type="hidden" name="end_date" id="end_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
			<!-- User Follow End-->   
			<?php }else{
			
				echo $this->html->link('Post Article','/news/add_article/',array('class'=>'buttonrgt margintop10','escape'=>false));
			} ?>
			
		  <ul>
			<li>
			  <h1><?php echo $this->Html->link($author_name,array('controller'=>'users_profiles','action'=>'userprofile/'.$author_id));  ?></h1>
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
	
	<div id="posts_listing">
	<?php
	if($news_lists){
	foreach ($news_lists as $news__Row) {
		$newsId = $news__Row['News']['id'];
		$created_date = $news__Row['News']['created'];
		$year = date("Y", strtotime($created_date));
		$month = date("M", strtotime($created_date));
		$day = date("d", strtotime($created_date));
		$time = date("H:i:s", strtotime($created_date));
		$pub_profile = $news__Row['users_profiles']['handler'];
		//$title_url = strtolower($post__Row['posts']['post_title']);
		$title_url = str_replace(" ", "-", strtolower($news__Row['News']['heading']));
		?>
		<div class="blogslisitng" id="<?php echo $newsId;?>">
			<div class="blogdate"> <span><?php echo $day;?></span> <span class="smalltext"><?php echo $month;?></span><br />
			<span class="smalltext"><?php echo $year;?></span> </div>
			
			<div class="blogslisitng-pic">
				<?php 
				if ($news__Row['News']['image_url'] && file_exists(MEDIA_PATH.'/files/news/logo/'.$news__Row['News']['image_url'])) {
					
					echo $this->Html->link($this->Html->Image(MEDIA_URL.'/files/news/logo/'.$news__Row['News']['image_url'],array()),'#',array('escape'=>false)); 
				} else {
					
					echo $this->Html->link($this->Html->Image(MEDIA_URL.'/img/nologo.jpg',array()),'#',array('escape'=>false)); 
				  }?>
			</div>
			<div class="blogslisitng-rgt">
				<div class="blogtopdiv1" style="margin:5px 60px 15px 0px;">
					<h1><?php echo $this->Html->link($news__Row['News']['heading'],array('controller'=>'news','action'=>'view',$newsId,$title_url),array('style'=>'text-decoration:none;'));?></h1>
				</div>
				
				<ul>
					<li><?php echo substr(strip_tags($news__Row['News']['details']),0,250).'...';?></li>
					<li><div class="more"><?php echo $this->Html->link('More',array('controller'=>'news','action'=>'view',$newsId,$friend_id,$title_url),array('class'=>'more'));?></div></li>
				</ul>
			</div>
			<div class="clear"></div>
			<div>
				<?php
				if($userInfo['users']['id'] == $news__Row['News']['user_id']){
				?>
				<div class="blogby">
					<?php echo $this->Html->link('Edit',array('controller'=>'news','action'=>'edit_article',$newsId,$title_url),array('class'=>'edit_post'));?>
					
					<?php echo $this->Html->link('Delete',array('controller'=>'news','action'=>'delete_article',$newsId,$title_url),array('class'=>'delete_post','onClick'=> 'return confirm("Are you sure?")'));?>
				</div>
				<?php }?>
				
				<div class="articles-bttns">
					<?php if ($created_date) { echo "on ".$day." ".$month.", ".$year." at ".$time; }?></div>
				
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	<?php } ?>     
	<div class="clear"></div>   
	
		<div class="paging">
			<?php 
				echo $this->Paginator->first(__('<< First', true), array('class' => 'number-first')).'&nbsp;&nbsp;';
				if($this->Paginator->hasPrev()){
					echo $this->Paginator->prev('<< ' . __('Previous', true), array(), null, array('class'=>'disabled')).'&nbsp;&nbsp;';
				}
				echo $this->Paginator->numbers(array('separator' => '&nbsp;&nbsp;','class' => 'numbers', 'first' => false, 'last' => false)).'&nbsp;&nbsp;';
				if($this->Paginator->hasNext()){
					echo $this->Paginator->next(__('Next', true) . ' >>', array(), null, array('class' => 'disabled')).'&nbsp;&nbsp;';
				}
				echo $this->Paginator->last(__('Last >>', true), array('class' => 'number-end'));
			?>
			 
		</div>
	<?php }else{?>
	
		<div class="blogslisitng">
			No Articles found!
		</div>
	<?php } ?>
	</div>
	
</div>

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