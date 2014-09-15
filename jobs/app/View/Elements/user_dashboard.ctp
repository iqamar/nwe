<div class="clear"></div>
<?php 
$savedJobs = $this->requestAction('/search/user_saved_jobs/'); 
$appliedJobs = $this->requestAction('/search/user_jobs_applied/'); 
//pr($savedJobs);
if(empty($savedJobs)){
	$countSaved='0';
}else{
	$countSaved=$savedJobs[0];
}
?>
<div style="width:32%;float:left;border-right:1px solid #ddd;">
	<div class="is-calendar-no">
		<div class="innerL">												
			<h3><?php echo $userInfo['Users_profile']['firstname']."&nbsp;".$userInfo['Users_profile']['lastname']; ?></h3>
			<div class="userJobactivity">
				<?php echo $this->Html->Image($networkWeUrl.'/files/users/'.$userInfo['Users_profile']['photo']); ?><?php echo $userInfo['Users_profile']['tags']; ?>
			</div>
			
			<?php echo $this->Html->link('View & Update your profile',$networkWeUrl.'/users_profiles/myprofile',array('escape'=>false)); ?>
		</div>
	</div>
</div>
<div style="width:32%;float:left;border-right:1px solid #ddd;margin-left:10px;">
	<div class="is-calendar-no">
		<div class="innerL">
			<h3>Saved Jobs<span style="font-weight:normal;"> (<?php echo $countSaved;?>)</span></h3>
			<?php if(!empty($savedJobs)){ ?>

			<div class="clear"></div>
			<div class="userJobactivity">
				<?php echo $this->Html->Image('company_logos/'.$savedJobs['Job']['Company']['logo']); ?>
				<?php echo $this->Html->link($savedJobs['Job']['title'],array('controller'=>'search','action'=>'jobDetails/'.$savedJobs['Job']['id']),array('escape'=>false)); ?>
				<div class="clear"></div>
				<p style="font-size:12px;">
					<?php echo "Posted:&nbsp;".date("M j, Y", strtotime($savedJobs['Job']['modified'])); ?><br/>
					<?php echo "Location:&nbsp;".$savedJobs['Job']['city'].',&nbsp;'.$savedJobs['Job']['Country']['name']; ?>
				</p>
			</div>
			<?php echo $this->Html->link('See all saved jobs',array('controller'=>'Userdashboard','action'=>'index'),array('escape'=>false)); ?>
			<?php }else{ echo "<div class='userJobactivity'>You have no jobs saved!</div><div class='clear'>&nbsp;</div>"; } ?>
		</div>
	</div>
</div>
<div style="width:32%;float:left;margin-left:10px;">
	<div class="is-calendar-no">
		<div class="innerL">												
			<h3>My Application</h3>
			<div class="userJobactivity">
				You have <strong>(<?php echo $appliedJobs; ?>)</strong> applied jobs
				<p>Review your past job applications here.</p>
			</div>
			<?php echo $this->Html->link('See all applied jobs',array('controller'=>'Userdashboard','action'=>'index'),array('escape'=>false)); ?>
			
			
		</div>
	</div>
</div>
<div class="clear">&nbsp;</div>
