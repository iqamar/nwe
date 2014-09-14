<div class="connections">
<?php if ($user_you_may_know) { 
		$arr = $this->params['pass']; 
		$message_received = $arr[0];
		if ($message_received == 'invitation sent') { ?>
		<div class="dialog-title" id="hideMessage" style="margin-bottom:10px;">
        <button onclick="closeMessage();" class="dialog-close"></button>
        <h3 class="title" style="font-weight:bold;"><?php echo __('Invitation has been sent.');?> </h3>
        </div> 
        
		<?php }	$i=1;
		echo '<h1>People You May Know</h1>';
		 foreach ($user_you_may_know as $user_you_know_row) {
		 	if ($i%2==0) {?>
			<div class="con_div" style="margin-bottom:15px;">
			<?php } else {?>
				<div class="con_div" style="margin-right:10px; margin-bottom:10px;">
				<?php }?>
			<?php if (!empty($user_you_know_row['users_profiles']['photo'])) {
					echo $this->Html->image('/files/users/'.$user_you_know_row['users_profiles']['photo'],array('alt'=>'no image','style'=>'width:100px; height:100px;padding:5px 5px 5px 5px; float:left;'));
				 } else {
	 					echo $this->Html->image('user-icon.png',array('alt'=>'no image','style'=>'width:100px; height:100px;padding:5px 5px 5px 5px; float:left;'));
				}?>
			<div class="connection-description">
					<strong>
				<?php echo $this->Html->link(__($user_you_know_row['users_profiles']['firstname']." ".$user_you_know_row['users_profiles']['lastname']), array('plugin' => false, 'admin' => false, 'controller' => 'connections', 'action' => 'connection_profile',$myConnections['users_profiles']['user_id'])); ?>
<!--<a href="/users/Users_profile/<?php //echo $myConnections['users']['id'];?>" style="color:#0062C4;"><?php //echo $myConnections['users']['firstname']." ".$myConnections['users']['lastname'];?></a>--></strong>
				<p><?php echo $user_you_know_row['users_profiles']['tags']?></p>
				<p><?php echo $user_you_know_row['users_profiles']['address1'];
				if ($user_you_know_row['users_profiles']['city']) {
" at ".$user_you_know_row['users_profiles']['city']; }?></p>
				<form method="post" name="userConnection" action="/connections/add_connection" >
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $uid;?>" id="user_id" />
                <input type="hidden" name="friend_id" id="friend_id" value="<?php echo $user_you_know_row['users_profiles']['user_id'];?>" id="friend_id" />
                <input type="hidden" name="request_date" value="<?php echo $dt = date('Y-m-d');?>" />
                <input type="hidden" name="start_date" id="start_date" value="<?php echo $dt = date('Y-m-d h:i:s');?>" />
                <input type="hidden" name="connection_type" value="connection" />
                <input type="submit" name="connect" value="Connect"  style="float:left; color: #086A87; border:none; background:none;" />
                </form>
		</div>
	</div>
<?php $i++;}}?>


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
function closeMessage() {
	$("#hideMessage").slideUp('slow');
}
</script>