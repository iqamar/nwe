<div class="user_status">
<?php if ($this->params['named']['mesg'] !=''){ ?>
	<div id="global-error" style="margin-bottom:0px;">
    	<div class="alert success">
        	<p>
					<?php
					$mesg = $this->params['named']['mesg']; 
					echo $mesg;
			?>
            </p>
          </div>
     </div>
     <?php  }?>
	<div class="top_blog">
		<div class="post_search" style="float:left; width:47%;">
        	<input type="radio" name="posts_select" id="posts_select" checked="checked" value="all" onchange="showPosts('all')" />&nbsp;All on NetworkWe
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="posts_select" id="posts_select" value="connection" onchange="showPosts('connection')" />&nbsp;My Connections
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="posts_select" id="posts_select" value="your" onchange="showPosts('your')" />&nbsp;My Blogs
        </div>
        <div class="post_search" style="position:relative;">
        <a href="javascript:search_blog();" class="savebtn" style="margin:0px 5px 0px 2px;">Go</a>
            	<input type="text" placeholder="Search blog.." name="data[Post][search]" id="search_posts" />
        	<form name="blog_cats" method="post" action="">
            	<select name="post_cat" id="post_cat" onchange="postsOfCategory(this.value);">
                	<option selected="selected" value="0">All</option>
                     <?php foreach ($categories_lists as $post_cat_Row) { ?>
                    <option value="<?php echo $post_cat_Row['post_categories']['id'];?>"><?php echo $post_cat_Row['post_categories']['title'];?></option>   
					<?php } ?>
                </select>
            </form>
                
        </div>
    </div>
         
    <div id="loader" style="position:absolute; z-index:100px; left:36%; top:113px; text-align:center; display:none;"> 
         <?php echo $this->Html->image('loading.gif');?>	
    </div>
	<ul id="posts_listing">
    
   <!-- User Posts Start-->
   <?php //print_r($blog_posts); exit;?>
		<?php foreach ($blog_posts as $post__Row) {
			$postId = $post__Row['blogs']['id'];
			$created_date = $post__Row['blogs']['created'];
			$year = date("Y", strtotime($created_date));
			$month = date("M", strtotime($created_date));
			$day = date("d", strtotime($created_date));
			$auther_fullname = $post__Row['users_profiles']['firstname']." ".$post__Row['users_profiles']['lastname'];
			$pub_profile = $post__Row['users_profiles']['handler'];
			//$title_url = strtolower($post__Row['blogs']['post_title']);
			$title_url = str_replace(" ", "-", strtolower($post__Row['blogs']['post_title']));
			?>
		<li id="" class="as_country_container" style="clear:both; padding:0px;">
        	<div style="padding:10px;">
			<p class="post_date">
               <span class="month"><?php echo $month;?></span>
               <span class="day"><?php echo $day;?></span>
               <span class="year"><?php echo $year;?></span>     
            </p>
			<div class="pst-desc" style="float:left; width:91%;">
				<h2 style="font-weight:bold; font-size:13px; margin-bottom:8px;">
                <?php echo $this->Html->link($post__Row['blogs']['post_title'],array('controller'=>'blogs','action'=>'view',$postId,$title_url),
																					 array('style'=>' text-decoration:none;'));?>
				</h2>
				<div style="float:left; margin-bottom:10px;">
					<?php echo substr($post__Row['blogs']['description'],0,600);?>
                    <?php echo $this->Html->link('More..',array('controller'=>'blogs','action'=>'view',$postId,$title_url),array('style'=>' float:right; text-decoration:none;'));?>
				</div>
                <div style="clear:both;"></div>
			</div>
            </div>
            <div class="post_author">
            	<a style="margin-right:2px;">By:</a><?php echo $this->Html->link($auther_fullname,array('controller'=>'pub','action'=>$pub_profile),array('style'=>'text-decoration:none;'));?>
                <?php $total_cates = '';
					foreach ($categories_posts as $post_cat_Row) {
						if ($post_cat_Row['category_posts']['post_id'] == $postId) {
							$total_cates .= $post_cat_Row['post_categories']['title'].", ";
							?>
                
                <?php }}
					$total_cates = substr_replace($total_cates ,"",-1);
				?>
                <a style=" margin-left:10px; float:right;">Category:&nbsp; <?php if ($total_cates) {echo rtrim($total_cates,',');} else echo "Uncategorized";?></a>
                <?php //echo $this->Html->link('Comments',array('controller'=>'blogs','action'=>'view'),array('style'=>''));?>
                <?php //$total_comment = $blog_posts[0][0];
					  $total_comment = $post__Row[0]['total_comments'];?>
                <a href="/blogs/view/<?php echo $postId;?>/<?php echo $title_url;?>#names<?php echo $postId;?>" style=" margin-left:10px; float:right;">Comments
                <?php if ($total_comment !=0) echo '('.$total_comment.')'; ?></a>
            </div>
		</li>
	<?php }?>
	</ul>
</div> 
<script>
function postsOfCategory(category__ID) {
$("#posts_listing").css('opacity', 0.2);
	$('#loader').show();
	//alert(category_title);
	$.ajax({
	url     : baseUrl+"/blogs/posts_by_category",
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
	document.getElementById('search_posts').value = '';
	$.ajax({
	url     : baseUrl+"/blogs/blog_type",
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
$("#posts_listing").css('opacity', 0.2);
	$('#loader').show();
	//alert(category_title);
	$.ajax({
	url     : baseUrl+"/blogs/search_blog",
	type    : "GET",
	cache   : false,
	data    : {search_posts: search_posts},
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
</script>