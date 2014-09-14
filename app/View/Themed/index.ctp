<div class="connections" style="width:100%;">	
	<?php echo '<h1>People You have connection</h1>'; ?>
	<div class="say-congrate">
    	<ul class="items">
        <?php $i=1; foreach ($uers_get_new_job as $user_New_Job_Row) {
			$fullname =	$user_New_Job_Row['users_profiles']['firstname']." ".$user_New_Job_Row['users_profiles']['lastname'];
			$exp_id = $user_New_Job_Row['users_experiences']['id'];
			if ($i%2==0) {
			?>
        	<li style="margin-left:10px; margin-right:0px;">
            	<div class="say-congrate-left">
                	<?php if (!empty($user_New_Job_Row['users_profiles']['photo'])) {
						echo $this->Html->image("/files/users/".$user_New_Job_Row['users_profiles']['photo'],array('style'=>'float:left;','alt'=>'no image'));
						 }
						else {
							echo $this->Html->image("user-icon.png",array('style'=>'float:left;'));
 						}?>
                </div>
                <div class="say-congrate-right">
                	<div class="header"><strong><?php echo $fullname;?></strong> <?php echo $user_New_Job_Row['users_profiles']['tags'];?></div>
                    <p class="content"> has new job </p>
                    <div class="say-congrate-action-container">
                    	<a href="#">Say congrate</a>
                    </div>
                </div>
            </li>
            <?php } else {?>
           	<li style="margin-left:0px; margin-right:0px;">
            	<div class="say-congrate-left">
                	<?php if (!empty($user_New_Job_Row['users_profiles']['photo'])) {
						echo $this->Html->image("/files/users/".$user_New_Job_Row['users_profiles']['photo'],array('style'=>'float:left;','alt'=>'no image'));
						 }
						else {
							echo $this->Html->image("user-icon.png",array('style'=>'float:left;'));
 						}?>
                </div>
                <div class="say-congrate-right">
                	<div class="header"><strong><?php echo $fullname;?></strong> <?php echo $user_New_Job_Row['users_profiles']['tags'];?></div>
                    <p class="content"> has new job </p>
                    <div class="say-congrate-action-container">
                    	<a href="javascript:sendCongrate('<?php echo $exp_id;?>');">Say congrate</a>
                    </div>
                </div>
            </li>
            <?php } ?> 
			
			<!-- --share form for updates post start-->
	<div class="referel_pop" id="openEditWindow_<?php echo $exp_id;?>" style="display:none; padding-bottom:15px; top:200px; position:fixed;">
		<div class="close_icon_row" style="width:480px;">
			<div class="close_icon_row_left" style="width:460px;">Share</div><div class="close_icon" style="float:right;" onclick="close_EditWindow('<?php echo $exp_id;?>')">
			</div>
		</div>
    <div id="loader" style="text-align:center;"></div>
 	<form id="share_form" name="share_form" action="/home/share" method="post">
 		<div class="mini-form">
 			<input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" />
 			<input type="hidden" name="content_type" id="content_type" value="updates" />
 			<input type="hidden" name="friend_id" id="friend_id_<?php $exp_id;?>" value="<?php echo $user_New_Job_Row['users_profiles']['user_id'];?>" />
 			<input type="hidden" name="subject_id" id="subject_id_<?php $exp_id;?>" value="<?php echo $exp_id;?>" />
 			<input type="hidden" name="subject_type" id="subject_type_<?php $exp_id;?>" value="<?php echo "congrates";?>" />
 			<textarea rows="4" cols="40" name="user_message" id="user_message_<?php $exp_id;?>" style="padding:8px; width:452px; height:70px; margin-bottom:0px;"></textarea>
 		</div>
 	
 		<div class="view">
		 <?php if ($user_New_Job_Row['users_profiles']['photo']){?>
 			<img src="<?php echo $this->base;?>/files/updates/<?php echo $user_New_Job_Row['users_profiles']['photo'];?>" alt="IMAGE" width="40" height="40" style="float:left; padding-left:4px;"  />
 		<?php } else { ?>
				<img src="<?php echo $this->base;?>/img/user-icon.png" width="40" height="40" align="post-img" style="float:left; padding-right:4px;" />
			<?php }?>
		<div style="width:440px; float:left;">
			<h3 class="title"><?php echo $fullname;?></h3>
    		<p class="meta"></p>
    		<p class="summary"><?php echo $user_New_Job_Row['users_profiles']['tags'];?></p>
	   </div>
       <input type="submit" class="savebtn" value="Send" name="share" />
	</div>
	<div id="test"></div>
</form>
</div>
			<!-- --share form for shared post end-->
			<?php $i++; }?>
        </ul>
    </div>
 </div>
<div class="connections" style="width:100%; background:#fff; padding-top:5px; padding-left:5px;">
	<div style="font-size:14px; color:#333; font-weight:bold;">Your Contacts</div>	
<?php if ($AllConnections) {

		$i=1;
	  foreach ($AllConnections as $myConnections) {
		  if ($i%2==0) {
		  ?>
	<div class="con_div" style="margin-bottom:15px;">
<?php } else {?>
	<div class="con_div" style="margin-right:10px; margin-bottom:10px;">
<?php }?>
<?php if (!empty($myConnections['users_profiles']['photo'])) {
	echo $this->Html->image("/files/users/".$myConnections['users_profiles']['photo'],array('style'=>'width:100px; height:100px; float:left; padding:5px;','alt'=>'no image'));
	}
	else {
		echo $this->Html->image("no-image.png",array('style'=>'width:100px; height:100px; float:left; padding:5px;'));
 }?>
		<div class="connection-description">
			<strong>
<?php echo $this->Html->link(__($myConnections['users_profiles']['firstname']." ".$myConnections['users_profiles']['lastname']), array('plugin' => false, 'admin' => false, 'controller' => 'connections', 'action' => 'connection_profile',$myConnections['users_profiles']['user_id'])); ?>
<!--<a href="/users/Users_profile/<?php //echo $myConnections['users']['id'];?>" style="color:#0062C4;"><?php //echo $myConnections['users']['firstname']." ".$myConnections['users']['lastname'];?></a>--></strong>
			<p><?php echo $myConnections['users_profiles']['tags']?></p>

			<p><?php echo $myConnections['users_profiles']['address1'];
if ($myConnections['users_profiles']['city']) {
" at ".$myConnections['users_profiles']['city']; }?></p>
		</div>
        
	</div>
<?php $i++;}}?>

<div style="clear:both;"></div>
</div>

<link type="text/css" rel="stylesheet" media="all" href="/css/chat.css" />
<script type="text/javascript" src="/js/chat.js"></script>


<div class="bottom-box">

</div>



<div id="chatbox_firendlist" class="chatbox" style="bottom: 0px; right: 0px; display: block;">
	<div class="chatboxhead" style="background-color: #086A87; border-left: 1px solid #086A87; border-right: 1px solid #086A87;">
		<div class="chatboxtitle">Who's Online</div>
			<div class="chatboxoptions">
				<a onclick="javascript:toggleChatBoxGrowth('firendlist')" href="javascript:void(0)">-</a> 				
			</div>
			<br clear="all">
	</div>
	<div class="chatboxcontent">

<?php 

if ($AllConnections) {

	  foreach ($AllConnections as $myConnections) {
		

$friendName = $myConnections['users_profiles']['firstname']." ".$myConnections['users_profiles']['lastname'];


echo "<a href=\"javascript:void(0)\" onclick=\"javascript:chatWith('".$myConnections['users_profiles']['user_id']."');\" id=\"friend_chat_".$myConnections['users_profiles']['user_id']."\" style=\"color: #086A87;text-decoration: none;\">".$friendName."</a><br/>";

	
 }}?>


		<!--<a href="javascript:void(0)" onclick="javascript:chatWith('deepak')" id="friend_chat_deepak" style="color: #086A87;text-decoration: none;">Deepak patil</a><br/>-->
		<!--<a href="javascript:void(0)" onclick="javascript:chatWith('babydoe')" id="friend_chat_babydoe" style="color: #086A87;text-decoration: none;">Baby Doe</a>-->
	</div>
</div>
<script>
function sendCongrate(id) {

document.getElementById('fade').style.display = 'block';
document.getElementById('openEditWindow_'+id).style.display = 'block';		  
}
function close_EditWindow(id) {
document.getElementById('fade').style.display = 'none';
document.getElementById('openShareWindow_'+id).style.display = 'none';

}
</script>