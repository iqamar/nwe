<!-- Apply Jobs Start Here -->
<div id="toPopup"> 
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
				<li>Experience : <span class="redcolor"><?php foreach($userExperience as $row){echo $row['Company']['title'].'&nbsp;,&nbsp;';} ?></span></li>
			</ul>
			</div>
			<div class="clear"></div>
		</div>
		<?php echo $this->Form->create('jobsApplication',array('url'=>'/search/jobsApplication/'.$jobDetail['JS']['id'],'id'=>'applyJob','method'=>'post','name'=>'applyJob','enctype'=>'multipart/form-data')); ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>Your Complete profile will be included with your application. if you want to Update your Profile <?php echo $this->Html->link('Click Here',NETWORKWE_URL.'/users_profiles/myprofile',array('escape'=>false)); ?></td>
			</tr>
			<tr>
				<td><strong>Email <span class="note-text">*</span></strong></td>
			</tr>
			<tr>
				<td><?php echo $this->Form->input('email',array('label'=>false,'type'=>'text','class'=>'textfield','size'=>60,'value'=>$userInfo['User']['email'])); ?></td>
			</tr>
			<tr>
				<td><strong>Cover Letter</strong></td>
			</tr>
			<tr>
				<td><?php echo $this->Form->input('cover_letter',array('label'=>'Cover Letter','type'=>'file','class'=>'')); ?></td>
			</tr>
			<tr>
				<td><span class="note-text">MS Word or PDF only (2MB maximum)</span></td>
			</tr>
			<tr>
				<td><strong>Resume <span class="note-text">*</span></strong></td>
			</tr>
			<tr>
				<td><?php echo $this->Form->input('resume',array('label'=>false,'type'=>'file','class'=>'', 'accept'=>'doc|docx|pdf')); ?></td>
			</tr>
			<tr>
				<td><span class="note-text">MS Word or PDF only (2MB maximum)</span></td>
			</tr>
			<tr>
				<td>
				<?php 
					echo $this->Form->hidden('hidden',array('value'=>$jobDetail['JS']['id'],'name'=>'job_id','id'=>'job_id'));
					echo $this->Form->hidden('hidden',array('value'=>$userInfo['Users_profile']['user_id'],'id'=>'user_id','name'=>'user_id'));
					echo $this->Form->input('Apply Now',array('type'=>'submit','name'=>'Apply','class'=>'red-bttn','label'=>false));
				?>
				</td>
			</tr>
		</table>
		<?php echo $this->Form->end(); ?>
	</div> <!--your content end-->
</div>
<!-- Apply Jobs Ends Here -->
