<?php
	$paginator = $this->Paginator;
	?>
<?php if ($uid) {?>
<div class="searchpanel">
	<form action="#" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="3"><h1>Search Blog</h1></td>
			</tr>
           
			<tr>
				<td colspan="3">
					<ul>
					<li><input type="radio" name="posts_select" id="posts_select_all"  checked="checked" value="all" onchange1="showPosts('all')" />&nbsp;All on NetworkWe</li>
                     
						<li><input type="radio" name="posts_select" id="posts_select_con" value="connection" onchange1="showPosts('connection')" />&nbsp;My Connections</li>
						<li><input type="radio" name="posts_select" id="posts_select_your" value="your" onchange1="showPosts('your')" />&nbsp;My Blogs</li>
					</ul>
				</td>
			</tr>
		
			
			<tr>
				<td width="62"><input type="text" placeholder="Search blog.." name="data[Post][search]" id="search_posts" class="textfield" size="73" /></td>
				<td width="19%">
					<!--<select name="post_cat" id="post_cat" onchange1="postsOfCategory(this.value);" class="droplist">
						<option selected="selected" value="0">All</option>
						<?php //foreach ($categories_lists as $post_cat_Row) { ?>
						<option value="<?php //echo $post_cat_Row['post_categories']['id'];?>"><?php //echo $post_cat_Row['post_categories']['title'];?></option>   
						<?php //} ?>
					</select>-->
				</td>
				<td width="19%"><a href="javascript:search_blog();" class="current inner-searchbttn">Search</a></td>
			</tr>			
		</table>
	</form>
</div>
 <?php }?>
 	
<a class="addblog-bttn" href="/blogs/add">Add New Blog Post</a>
<div class="clear"></div>
<?php //echo $this->Session->flash(); ?>
<div id="desolove_message"><?php echo $this->Session->flash('blog_message');?></div>
<div class="clear"></div>
<div id="posts_listing">
<?php foreach ($blog_posts as $post__Row) {
/*echo "<pre>";
print_r($blog_posts);
exit;*/
		$postId = $post__Row['Blog']['id'];
		$created_date = $post__Row['Blog']['created'];
		$year = date("Y", strtotime($created_date));
		$month = date("M", strtotime($created_date));
		$day = date("d", strtotime($created_date));
		$auther_fullname = $post__Row['users_profiles']['firstname']." ".$post__Row['users_profiles']['lastname'];
		$auther_photo = $post__Row['users_profiles']['photo'];
		$blog_user_id = $post__Row['users_profiles']['user_id'];
		$auther_tags = $post__Row['users_profiles']['tags'];
		$pub_profile = $post__Row['users_profiles']['handler'];
		//$title_url = strtolower($post__Row['Blog']['post_title']);
		$title_url = str_replace(" ", "-", strtolower($post__Row['Blog']['post_title']));
		$blogImage = $post__Row['Blog']['image'];
		$desc =  strip_tags($post__Row['Blog']['description'],"<img");
		?>
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
					echo $this->Html->link($this->Html->Image(MEDIA_URL.'/files/user/icon/'.$auther_photo),'#',array('escape'=>false)); 
				}else{
					echo $this->Html->link($this->Html->Image(MEDIA_URL.'/img/nologo.jpg',array('width'=>50)),'#',array('escape'=>false)); 
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
		
		
		
		
		
		<div style="clear:both;"></div>
		<div class="blogslisitng-pic">
			<?php 
				if($blogImage){
					echo $this->Html->link($this->Html->Image(MEDIA_URL.'/files/blog/original/'.$blogImage,array('width'=>400)),'#',array('escape'=>false)); 
				}else{
					echo $this->Html->link($this->Html->Image(MEDIA_URL.'/img/nologo.jpg',array('width'=>400)),'#',array('escape'=>false)); 
				}
				?>
		</div>
		<div class="blogslisitng-rgt">
			<ul>
				<li> <h1><?php echo $this->Html->link($post__Row['Blog']['post_title'],array('controller'=>'blogs','action'=>'view',$postId,$title_url),array('style'=>' text-decoration:none;','class'=>'current'));?></h1></li>
				<li><?php echo substr($desc,0,600);?></li>
				
				
			</ul>
		</div>
		<div class="clear"></div>
		<?php $total_cates = '';
							foreach ($categories_posts as $post_cat_Row) {
								if ($post_cat_Row['category_posts']['post_id'] == $postId) {
									$total_cates .= $post_cat_Row['post_categories']['title'].", ";
								?>
						<?php }} $total_cates = substr_replace($total_cates ,"",-1); ?>
						<h4><b>Category:</b>&nbsp; <?php if ($total_cates) {echo rtrim($total_cates,',');} else echo "Uncategorized";?></h4>
						
		<div>
			<!--<div class="blogby">By: <?php echo $this->Html->link($auther_fullname,array('controller'=>'pub','action'=>$pub_profile),array());?></div>-->
			<?php
				if($userInfo['users']['id'] == $blog_user_id){
			?>
			<div class="blogby">
				<?php echo $this->Html->link('Edit',array('controller'=>'blogs','action'=>'add',$postId,$title_url),array('class'=>'edit_post'));?>
				
				<?php echo $this->Html->link('Delete',array('controller'=>'blogs','action'=>'delete',$postId,$title_url),array('class'=>'delete_post','onClick'=> 'return delete_post('.$postId.')'));?>
			</div>
			<?php }?>
			<div class="blog-bttns">
				<ul>
					<li>
						<?php $total_comment = $post__Row[0]['total_comments'];?>
						<a href="/blogs/view/<?php echo $postId;?>/<?php echo $title_url;?>#names<?php echo $postId;?>">Comments
						<?php if ($total_comment !=0) echo '<span class="redcolor">('.$total_comment.')</span>'; ?></a>
					</li>
					<li><div class="more" style="margin-top:0px;"><?php echo $this->Html->link('More',array('controller'=>'blogs','action'=>'view',$postId,$title_url),array('class'=>'current more'));?></div></li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<?php } ?> 
    <?php 
	
	// pagination section Start
	echo "<div class='paging' style='float:right;'>";
 
		// the 'first' page button
		echo $this->Paginator->first("First",array('tag'=>false));
		 
		// 'prev' page button, 
		// we can check using the paginator hasPrev() method if there's a previous page
		// save with the 'next' page button
		if($paginator->hasPrev()){
			//echo $this->Paginator->prev("Prev",array('tag'=>false));
		}
		 
		// the 'number' page buttons
		//echo $paginator->numbers(array('modulus' => 1));
		echo $this->Paginator->numbers(array('tag'=>false,'separator'=>'&nbsp;&nbsp;'));
		 
		// for the 'next' button
		if($paginator->hasNext()){
			//echo $this->Paginator->next("Next",array('tag'=>false));
		}
		 
		// the 'last' page button
		echo $this->Paginator->last("Last",array('tag'=>false));
	 
	echo "</div>";
	// pagination section End
	?>   
	<div class="clear"></div>   
</div>
<div id="loader" style="position:absolute; z-index:100px; left:36%; top:300px; text-align:center; display:none;"> 
	<?php echo $this->Html->Image(MEDIA_URL.'/img/loading.gif');?>	
</div>
<script>
$( document ).ready(function() {
	$("#desolove_message").slideDown('slow').delay(1000).fadeOut();
});
function postsOfCategory(category__ID) {
$("#posts_listing").css('opacity', 0.2);
	$('#loader').show();
	//alert(category_title);
	$.ajax({
	url     : "/blogs/posts_by_category",
	type    : "POST",
	cache   : false,
	data    : {category__ID: category__ID},
	success : function(data){
	//if (share == 1) {
	$("#posts_listing").html(data);
	//}
	},
	complete: function () {
		$('#loader').hide();
		$("#posts_listing").css('opacity', 1);
     },
	error : function(data) {
	$("#posts_listing").html("there is error in your script.");
	}
	});		
}
function showPosts(post_type) {
	$("#posts_listing").css('opacity', 0.2);
	$('#loader').show();
	//alert(category_title);
	//var post_type =document.getElementById('posts_select').value;
	//var post_type = $('input[name=posts_select]:checked').val();
	$.ajax({
	url     : "/blogs/blog_type",
	type    : "GET",
	cache   : false,
	data    : {post_type: post_type},
	success : function(data){
	//if (share == 1) {
	$("#posts_listing").html(data);
	//}
	},
	complete: function () {
		$('#loader').hide();
		$("#posts_listing").css('opacity', 1);
     },
	error : function(data) {
	$("#posts_listing").html("there is error in your script.");
	}
	});
}
function search_blog() {
	var search_posts = document.getElementById('search_posts').value;
	
	var category = $('input[name=posts_select]:checked').val();
	var posts_select_all = document.getElementById('posts_select_all').checked;
	var posts_select_con = document.getElementById('posts_select_con').checked;
	var posts_select_your = document.getElementById('posts_select_your').checked;
		
		  
	if(posts_select_con){
		post_group = document.getElementById('posts_select_con').value;
	}else if(posts_select_your){
		post_group = document.getElementById('posts_select_your').value;
	}else{
		post_group = document.getElementById('posts_select_all').value;
	}
			
$("#posts_listing").css('opacity', 0.2);
	$('#loader').show();
	//alert(category_title);
	$.ajax({
	url     : "/blogs/search_blog",
	type    : "GET",
	cache   : false,
	data    : {search_posts: search_posts, post_group: post_group, category: category},
	success : function(data){
	//if (share == 1) {	
	$("#posts_listing").html(data);
	//}
	},
	complete: function () {
		$('#loader').hide();
		$("#posts_listing").css('opacity', 1);
     },
	error : function(data) {
	$("#posts_listing").html("there is error in your script.please try again");
	}
	});		
}
</script>
