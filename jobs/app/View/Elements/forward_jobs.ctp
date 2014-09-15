<!-- Forward Jobs Start Here -->
<?php 
echo $this->Html->css(array(MEDIA_URL.'/css/magicsuggest-1.3.1')); 
echo $this->Html->Script(array(MEDIA_URL.'/img/magicsuggest-1.3.1'));	
?>
<div id="tosend"> 
	<div class="close"></div>
	<span class="ecs_tooltip">Press Esc to close <span class="arrow"></span></span>
	<div id="popup_content"> <!--your content start-->
		<div class="userprofile-box">
			<div class="userprofile-box-pic">
				<?php echo $this->Html->Image(MEDIA_URL.'/files/users/'.$userInfo['Users_profile']['photo'],array('class'=>'applyprofileimg')); ?>
			</div>
			<div class="userprofile-box-rgt">
			<ul>
				<li>
					<h1><?php echo $userInfo['Users_profile']['firstname']."&nbsp;".$userInfo['Users_profile']['lastname']; ?></h1>
				</li>
				<li> <?php echo $userInfo['Users_profile']['tags']; ?></li>
				<li><strong>Location</strong>: <span><?php echo $jobDetail['JS']['city'].",&nbsp;".$jobDetail['COU']['name']; ?></span></li>
			</ul>
			</div>
			<div class="clear"></div>
		</div>
		<?php
		$yourEmail = $userInfo['User']['email'];
		$yourName = $userInfo['Users_profile']['firstname']." ".$userInfo['Users_profile']['lastname'];
		
		echo $this->Form->create('jobForward',array('url'=>'/search/jobForward/'.$jobDetail['Job']['id'],'id'=>'jobForward','name'=>'jobForward'));
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><strong>Your Name</strong></td>
			</tr>
			<tr>
				<td><?php echo $this->Form->input('yourname',array('label'=>false,'type'=>'text','class'=>'textfield','size'=>60,'value'=>$yourName)); ?></td>
			</tr>
			<tr>
				<td><strong>Email</strong></td>
			</tr>
			<tr>
				<td><?php  echo $this->Form->input('youremail',array('label'=>false,'class'=>'textfield','size'=>60,'type'=>'text','value'=>$yourEmail)); ?></td>
			</tr>
			<tr>
				<td><strong>Friend's Email</strong></td>
			</tr>
			<tr>
				<td><?php echo $this->Form->input('conEmail',array('label'=>false,'type'=>'text','id'=>'ms4','name'=>'ms4','size'=>60,'class'=>'textfield')); ?><div style="clear:both;"></div></td>
			</tr>
			<tr>
				<td><strong>Other Emails</strong></td>
			</tr>
			<tr>
				<td><?php echo $this->Form->input('friendsEmail',array('label'=>false,'name'=>'friendsEmail','type'=>'textarea','cols'=>58,'rows'=>7,'class'=>'textfield')); ?></td>
			</tr>
			<tr>
				<td><span class="note-text">(add more email ids separated by comma)</span></td>
			</tr>
			<tr>
				<td>
				<?php 
					echo $this->Form->input('job_id',array('type'=>'hidden','value'=>$jobDetail['JS']['id'],'name'=>'job_id','id'=>'job_id'));
					echo $this->Form->input('Send Invites',array('type'=>'submit','name'=>'Send','class'=>'red-bttn','label'=>false));
					
				?>
				</td>
			</tr>
		</table>
		<?php echo $this->Form->end(); ?>
	</div> <!--your content end-->
</div>
<!-- Forward Jobs Ends Here -->