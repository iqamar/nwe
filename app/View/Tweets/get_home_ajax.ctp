<?php 
 foreach ($updates_by_ajax as $ustatus) { 
$post_id = $ustatus['statusupdates']['id']; ?>
<li id="<?php echo $ustatus['statusupdates']['id'];?>" class="as_country_container" style="clear:both;">
<?php if ($ustatus['users_profiles']['photo']){?>
<img src="<?php echo $this->base;?>/files/users/<?php echo $ustatus['users_profiles']['photo'];?>" width="60" height="60" align="post-img" />
<?php } else { ?>
<img src="<?php echo $this->base;?>/img/no-image.png" width="60" height="60" align="post-img" />
<?php }?>
<div class="pst-desc">
<h2><?php echo $this->Html->link($ustatus['users_profiles']['firstname']." ".$ustatus['users_profiles']['lastname'],array('controller'=>'users_profiles','action'=>'profile'));?>
</h2>
<div style="width:680px;">
<?php if ($ustatus['statusupdates']['photo']) {?>
<img src="<?php echo $this->base;?>/files/updates/<?php echo $ustatus['statusupdates']['photo'];?>" width="60" height="60" style="float:left; padding-right:5px;  margin-top:10px;"/>
<?php } else {?>
<img src="<?php echo $this->base;?>/img/no-image.png" width="60" height="60" align="post-img" style="float:left; padding-right:5px; margin-top:10px;" />
<?php }?>
<p style="float:left; width:600px; margin-top:5px;"><?php echo substr($ustatus['statusupdates']['user_text'],0,600);?></p>
</div>

<div class="comment-box">
<div class="comment_btn">
<a href="Javascript:showComments('<?php echo $ustatus['statusupdates']['id'];?>');" style="text-decoration:none; color:#858585; font-size:13px; float:left; margin-right:7px;">
Comments
	<?php foreach ($updates_comments_count as $comments_total_row) {
		if ($comments_total_row['comments']['content_id'] == $post_id) {
	 echo "(".$comments_total_row[0]['commenttotal'].")";
		}
	}
	 ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 
 <div id="user_like_update_<?php echo $ustatus['statusupdates']['id'];?>" style="float:left; width:56px; margin-right:7px;">
<?php $flage = false;
	 foreach ($likes_on_Update as $like_update_row)  {
		$user_id = $like_update_row['likes']['user_id'];
		$content_id = $like_update_row['likes']['content_id'];
		if ($ustatus['likes']['like'] == 1 && $user_id == $uid && $ustatus['likes']['content_id'] == $content_id) {?>
		<div class="likedText" style="float:left;">Liked<?php echo "(".$ustatus[0]['total'].")";?></div> 
		<?php $flage = true;
		 }}
		if ($flage == false) {  ?>
		    <a class="like" id="alike<?php echo $ustatus['likes']['content_id'];?>" href="Javascript:showLikes('<?php echo $ustatus['statusupdates']['id'];?>','1');"
         style="padding-left:21px; color:#999; display:block; text-decoration:none; float:left; margin-right:7px;"><?php echo "(".$ustatus[0]['total'].")";?></a>
		<div class="likedText" style="display:none;" id="likediv<?php echo $ustatus['likes']['content_id'];?>">Liked<?php echo "(".$ustatus[0]['total'].")";?></div>     
		<?php } ?>

	</div>
&nbsp;<a href="Javascript:shareUpdates('<?php echo $post_id;?>','updates')" style="text-decoration:none; color:#858585; font-size:13px; margin-right:7px; float:left;">Share</a>
<span id="testing"></span>
</div>
<div class="comments_field" id="comments_<?php echo $ustatus['statusupdates']['id'];?>" style="display:none;">

<form id="coment_form" name="coment_form" action="" method="post">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
<input type="hidden" name="parent" id="parent" value="0" />
<input type="hidden" name="share" id="share" value="0" />
<input type="hidden" name="id" id="id_<?php echo $ustatus['statusupdates']['id'];?>" value="<?php echo $ustatus['likes']['id'];?>" />
<input type="hidden" name="comment_type" id="comment_type" value="updates" />
<input type="hidden" name="content_id" id="content_id_<?php echo $ustatus['statusupdates']['id'];?>" value="<?php echo $ustatus['statusupdates']['id'];?>" />
<input type="hidden" name="comment_date" id="comment_date_<?php echo $ustatus['statusupdates']['id'];?>" value="<?php echo $date = date("Y-m-d");?>" />
<textarea rows="5" cols="55" class="user_coments" name="comment_text" id="comment_text_<?php echo $ustatus['statusupdates']['id'];?>"></textarea>

<div style="width:680px;"><span style="float:left;"><a href="Javascript:closeComment('<?php echo $ustatus['statusupdates']['id'];?>');" class="savebtn">Close</a></span><span style="float:right;"><a href="Javascript:saveComment('<?php echo $ustatus['statusupdates']['id'];?>');" class="savebtn">Comment</a></span></div>
</form>
<div id="span_<?php echo $ustatus['statusupdates']['id'];?>">
<div class="postComments">
	<ul>
		<?php 
	
		foreach ($user_comments as $comm) {
		if ($comm['comments']['content_id'] == $ustatus['statusupdates']['id']) {
		?>
			<li style="clear:both;">
				<?php if ($comm['users_profiles']['photo']) {?>
				<img src="<?php echo $this->base;?>/files/users/<?php echo $comm['users_profiles']['photo'];?>" alt="<?php echo $comm['users_profiles']['firstname'];?>" />
				<?php } else {?>
				<img src="<?php echo $this->base;?>/img/no-image.png" alt="no image" />
				<?php }?>
				<div class="desc">
					<h3 style="font-weight:bold;"><?php echo $comm['users_profiles']['firstname']." ".$comm['users_profiles']['lastname'];?></h3>
					<?php echo substr($comm['comments']['comment_text'],0,350);?> 
				</div>
                 <div style="clear:both;">&nbsp;</div>
			</li>
		<?php } }?>
	</ul>
</div>
</div>
</div>
</div>
</div>
<div style="clear:both;">&nbsp;</div>
</li>
<?php }?>