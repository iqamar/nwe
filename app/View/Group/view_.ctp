<div style="height:auto; width:100%;">
	<div style="clear:both; width:100%; height:auto;">
		<?php 
        if ($discussion_detail) {
        foreach ($discussion_detail as $groupRow) { 
        $groupID = $groupRow['groups']['id'];
		$grouptitle = strtolower($groupRow['groups']['title']);
		$grouptitle = str_replace(' ', '-', $grouptitle);
		$discussion__ID = $groupRow['entity_updates']['id'];
		?>
        <div class="con_div" style="width:98.2%; float:left; padding:20px 20px; border:1px solid #BFBFBF; margin-bottom:5px; background:#fff;">
        <?php if (!empty($groupRow['groups']['logo'])) {
        echo $this->Html->image('/files/groups_logo/'.$groupRow['groups']['logo'],array('style'=>'padding:5px; float:left; width:120px; height:75px;','alt'=>'no-img'));
        }
        else {
		echo $this->Html->image('no-image.png',array('style'=>'padding:5px; float:left; width:100px; height:75px;','alt'=>'no-img'));
		}?>
		<div class="user-description" style="float:left; padding-left:20px; width:83%;">
			<div style="float:left; width:75%;">
				<strong style="color:#006AD5; font-size:17px; font-weight:bold;"><?php echo $groupRow['groups']['title'];?></strong>
			</div>	
            <div style="width:25%; float:right; margin-bottom:10px;">
		&nbsp;<br />
            <span style="float:left;color:#333; font-size:12px; vertical-align:middle;">
			<span id="total_following"><?php  echo $count_following_thisGroup;?> </span> members </span>
            </div>
            
            <div class="page_menus">
        	<ul>
            	<li><?php echo $this->Html->link('Discussion',array('controller'=>'groups','action'=>'view',$groupID,$grouptitle),array('style'=>'color:#359AFF;'));?></li>
                <li><?php echo $this->Html->link('Jobs',array('controller'=>'groups','action'=>'jobs',$groupID,$grouptitle));?></li>
                <li><?php echo $this->Html->link('Members',array('controller'=>'groups','action'=>'members',$groupID,$grouptitle));?></li>
            </ul>
        </div>
            
		</div>
        
	</div>
 
    	<div class="con_div" style="width:98.2%; float:left; padding:20px 20px; border:1px solid #BFBFBF; margin-bottom:5px; background:#fff;">
		 <?php if (!empty($groupRow['users_profiles']['photo'])) {
       		echo $this->Html->image('/files/users/'.$groupRow['users_profiles']['photo'],array('style'=>'padding:5px; float:left; width:200px; height:200px;','alt'=>'no-image'));
        		}
        		else {
					echo $this->Html->image('no-image.png',array('style'=>'padding:5px; float:left; width:200px; height:200px;','alt'=>'no-banner'));
				}?>
               <div style="float:left; padding:5px; width:72%;">
               	<h1 style="color:#333; font-size:16px; font-weight:bold;"><?php echo $groupRow['entity_updates']['group_title'];?></h1>
                <p style=" color:#409FFF;"><?php echo $groupRow['users_profiles']['firstname']." ".$groupRow['users_profiles']['lastname'];?></p>
                <p><?php echo $groupRow['users_profiles']['tags']; ?></p>
                <p><?php echo $groupRow['entity_updates']['update_text'];?></p>
               </div>
       </div>
	<?php }}?>
    <div class="con_div news_comments" style="width:98.2%; float:left; padding:20px 20px; border:1px solid #BFBFBF; margin-bottom:5px; background:#fff;">
    	<h2><?php echo "Comments:"; if (sizeof($comments_this_groups)>0) echo "(".sizeof($comments_this_groups).")"; else echo " &nbsp;&nbsp;&nbsp; Be first to comment";?></h2>
     <ul id="group_comments">
        	<?php foreach ($comments_this_groups as $comment__row) {
				$full_name = $comment__row['users_profiles']['firstname']." ".$comment__row['users_profiles']['lastname'];
				$created_date = $comment__row['entity_comments']['created'];
				$year = date("Y", strtotime($created_date));
				$month = date("M", strtotime($created_date));
				$day = date("d", strtotime($created_date));
				$commentid = $comment__row['entity_comments']['id'];
				$time = date("H:i:s", strtotime($created_date));
				$handler = $comment__row['users_profiles']['handler'];
				$user_photo = $comment__row['users_profiles']['photo'];
				?>
        	<li id="<?php echo $commentid;?>">
				<?php if ($user_photo) {
						echo $this->Html->image('/files/users/'.$user_photo,array('url'=>array('controller'=>'pub','action'=>$handler),'style'=>'width:30px; height:30px;'));
						}
						else {
						echo $this->Html->image('user-icon.png',array('url'=>array('controller'=>'pub','action'=>$handler),'style'=>'width:30px; height:30px;'));	
						}?>
				<div class="dt"><strong><?php echo $full_name;?></strong>
                <?php echo $this->Html->link('@'.$handler,array('controller'=>'pub','action'=>$handler),array('style'=>'color:#006FDD; text-decoration:none;')); ?>
                <br />
                <span><?php echo $day." ".$month.", ".$year."  @ ".$time; ?></span>
					<br />
					<?php echo $comment__row['entity_comments']['comments'];?>
				</div>
			</li>
			<?php }?>
        </ul>
     
     </div>
    
    <div class="con_div" style="width:98.2%; float:left; padding:20px 20px; border:1px solid #BFBFBF; margin-bottom:5px; background:#fff;">
    <?php echo $this->Html->image('/files/users/'.$imgname,array('style'=>'margin-right:25px; float:left; width:60px; height:60px;','alt'=>'no-image'));?>
    <div style="position:relative;">
    
			<?php echo $this->Form->input('user_id' , array('type' => 'hidden', 'id'=>'user_id', 'value' => $uid)); ?>
            <?php echo $this->Form->input('content_id' , array('type' => 'hidden', 'id'=>'content_id', 'value' => $discussion__ID)); ?>
			<?php echo $this->Form->textarea('comments',array('required'=>true,'id'=>'comments','style'=>array('width:70%; height:60px; padding:6px;border:1px solid #222;'),'placeholder'=>"add comments..")); ?>

			<div class="cont-inptbtn">
			<?php //echo $this->Html->link('Add Comment','javascript'=>'add_group_comment();',array('class'=>'savebtn')); ?>
            <a href="javascript:add_group_comment();" class="savebtn">Add Comment</a>
			</div>
          </div>
    
    </div>

</div>
</div>
<script type="text/javascript">
function add_group_comment() {
$("#group_comments").css('opacity', 0.2);
	$('#loader').show();
	//alert(category_title);
	var user_id = document.getElementById('user_id').value;
	var content_id = document.getElementById('content_id').value;
	var comments = document.getElementById('comments').value;
	$.ajax({
	url     : baseUrl+"/groups/add_comments",
	type    : "POST",
	cache   : false,
	data    : {user_id: user_id,content_id:content_id,comments:comments},
	success : function(data){
		$("#group_comments").css('opacity', 1);
		$('#group_comments').html(data);	
	},
	complete: function () {
		$('#loader').hide();
		
		document.getElementById('comments').value = '';
		$("#group_comments").css('opacity', 1);
		
     },
	error : function(data) {
	$("#group_comments").html("there is error in your script.");
	}
	});		
}
</script>