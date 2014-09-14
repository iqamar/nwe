<script>
function expandComment() {
$('#comments').css({
            'height' : '70px'
        });
$('#comments').css({
            'display' : 'block'
        });
}
</script>
<?php echo "fadfar"; exit;
    foreach ($news_InDetail as $news_single_Row) {
		$auther_fullname = $news_single_Row['users_profiles']['firstname']." ".$news_single_Row['users_profiles']['lastname'];
		$newsId = $news_single_Row['News']['id'];
		$created_date = $news_single_Row['News']['created'];
		$year = date("Y", strtotime($created_date));
		$month = date("M", strtotime($created_date));
		$day = date("d", strtotime($created_date));
		$time = date("H:i:s", strtotime($created_date));
		$pub_profile = $news_single_Row['users_profiles']['handler'];
		$title_url = str_replace(" ", "-", strtolower($news_single_Row['News']['heading']));
	?>
<div class="news_detail">
	<div class="info">
    	<h1><?php echo $news_single_Row['News']['heading'];?></h1>
        <h4><?php echo "By: ".$auther_fullname." on ".$day." ".$month.", ".$year." at ".$time;?></h4>
    </div>
    <div class="widgets">
    <?php echo "Category => ";?>
    <?php 
			foreach ($news_categories as $news_cat_row) {
				if ($news_cat_row['Category_news']['news_id'] == $newsId) {
					echo $news_cat_row['news_categories']['category'].", ";
				}
			}?>
           
    </div>
   <?php if ($news_single_Row['News']['image_url']) {
	   		echo $this->Html->image('/files/news_logo/'.$news_single_Row['News']['image_url'],array('style'=>'float:none;'));
   		 }
		 else {
			 echo $this->Html->image('no-image.png',array('style'=>'float:none;'));
		 }
	   ?>
    <div class="detail">
    	<p></p>
        <p><?php echo $news_single_Row['News']['details'];?></p>
        
    </div>
    
    <!-- Comments for news start-->
    <div class="news_comments">
    	<h2><?php echo "Comments ".sizeof($comments_on_Onenews);?></h2>
        <ul id="news_comments">
        	<?php foreach ($comments_on_Onenews as $comment__Row) {
					$user_photo = $comment__Row['users_profiles']['photo'];
					$handler = $comment__Row['users_profiles']['handler'];
					$full_name = $comment__Row['users_profiles']['firstname']." ".$comment__Row['users_profiles']['lastname'];
					$created_date = $comment__Row['Comment']['created'];
					$year = date("Y", strtotime($created_date));
					$month = date("M", strtotime($created_date));
					$day = date("d", strtotime($created_date));
					$commentid = $comment__Row['Comment']['id'];
					$time = date("H:i:s", strtotime($created_date));
				?>
        	<li id="<?php echo $commentid;?>">
            	<?php if ($user_photo) {
						echo $this->Html->image('/files/users/'.$user_photo,array('url'=>array('controller'=>'pub','action'=>$handler),'style'=>'width:30px; height:30px;'));
						}
						else {
						echo $this->Html->image('user-icon.png',array('url'=>array('controller'=>'pub','action'=>$handler),'style'=>'width:30px; height:30px;'));	
						}?>
                <div class="dt"><strong><?php echo $full_name;?></strong>
                <?php echo $this->Html->link('@'.$handler,array('controller'=>'pub','action'=>$handler),array('style'=>'color:#006FDD; text-decoration:none;'));  ?>
                 <br />
                <span><?php echo $day." ".$month.", ".$year."  @ ".$time; ?></span>
                <br />
                <?php echo $comment__Row['Comment']['comment_text'];?></div>
                <div style="clear:both;"></div>
            </li>
            <?php }?>
        </ul>
        <div class="comment_form">
        <div style="width:100%;">
        <input type="hidden" id="user_id" value="<?php echo $uid;?>" />
        <textarea rows="4" cols="95" class="comment_area" name="data[Comment][message]" id="comments" placeholder="Add comment" onclick="expandComment();"></textarea>
        </div>
        <a href="javascript:add_news_comment('<?php echo $newsId;?>');" class="savebtn" style="float:left; clear:both;">Add Comment</a>
        <div style="clear:both;"></div>
        </div>
    </div>
    <!-- Comments for news end-->
    
    <div style="clear:both;"></div>
</div>

<script>
function add_news_comment(news_id) {
$("#news_comments").css('opacity', 0.2);
	$('#loader').show();
	//alert(category_title);
	var user_id = document.getElementById('user_id').value;
	var user_comment = document.getElementById('comments').value;
	$.ajax({
	url     : NETWORKWE_URL+"/news/add_comments",
	type    : "POST",
	cache   : false,
	data    : {user_id: user_id,news_id:news_id,user_comment:user_comment},
	success : function(data){
		$("#news_comments").css('opacity', 1);
		$('#news_comments').html(data);	
	},
	complete: function () {
		$('#loader').hide();
		
		document.getElementById('comments').value = '';
		$("#news_comments").css('opacity', 1);
		
     },
	error : function(data) {
	$("#news_comments").html("there is error in your script.");
	}
	});		
}
</script>