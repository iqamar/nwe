<div id="content" style="padding:0px;">
	<div id="content-inner">	
		<!-- Post -->
		<article class="is-post is-post-excerpt">
			
			<div style="width:100%;float:left;min-height:800px;">
				<div class="is-calendar-no">
					<div class="innerL-no">
					<?php if(isset($userInfo)){ ?>
						
						<div class="userJobactivitys">
							<?php echo $this->Html->Image($networkWeUrl.'/files/users/'.$userInfo['Users_profile']['photo'],array('class'=>'applyprofileimg','style'=>'margin-right:15px;border:1px solid #ddd;')); ?>
							<div class="userInfo" style="float:left;">
								<h3><?php echo $userInfo['Users_profile']['firstname']."&nbsp;".$userInfo['Users_profile']['lastname']; ?></h3>
								<span><?php echo $userInfo['Users_profile']['tags']; ?></span>
								<p><label>Experience&nbsp;: &nbsp;</label><span><?php foreach($userExperience as $row){echo $row['Company']['title'].'&nbsp;,&nbsp;';} ?></span></p>
								<p><label>Education&nbsp;: &nbsp;</label><span> <?php echo $userQualification['qualification']['title']; ?></span></p>
								<?php echo $this->Html->link('View & Update your profile',$networkWeUrl.'/users_profiles/myprofile',array('escape'=>false)); ?>
							</div>
						</div>
						<div style="clear:both;"></div>
						<hr/>
						<div class="userDashboard">
							<ul class="userTabs">
								<li><?php echo $this->Html->link('Job Application ('.$countJobsapplied.')','#',array('id'=>'jalink','class'=>'md','onclick'=>'showjobapp()')); ?></li>
								<li><?php echo $this->Html->link('Saved Jobs ('.$countsavedJobs.')','#',array('id'=>'sjlink','onclick'=>'showsavedjob()')); ?></li>
								
							</ul>
							<div class="tabContent">
								<div class="clear">&nbsp;</div>
								<div id="jobApplication">
									<div style="float:right;border:2px solid #ddd;border-bottom:0;padding:5px;">Sort by: &nbsp;<?php echo $this->Paginator->sort(__('modified',true),'Jobs applied date'); ?></div><div class="clear"></div>
									<ul class="news-list">
										<?php 
											$i=0;
											foreach($appliedJobs as $row){
												
												if($row['Job']['status']!=0){
													$status = "Open";
												}else{
													$status = "Closed";
												}
												$postdate = date("F j, Y", strtotime($row['jobs_application']['modified']));
												$resume = $this->webroot.'files/resume/'.$row['jobs_application']['cv'];
												$class='joblist';
												if($i++ % 2 ==0){
													$class ='altjoblist';
												}
												echo "<li class='".$class."'>".$this->Html->image('company_logos/'.$row['Job']['Company']['logo'],array('class'=>'compLogo'))."<div class='leftrow'>".$this->Html->link($row['Job']['title'],array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id']),array('escape'=>false))."</a><table id='jobsDesc'><tr><th>".$this->Html->Image('date-icon.png',array('width'=>16))."&nbsp;Applied on:&nbsp;".$postdate."</th><td>".$this->Html->Image('status-icon.png',array('width'=>16))."Status:&nbsp;(".$status.")</td></tr><tr><th>".$this->Html->Image('cv-icon.png',array('width'=>16))."&nbsp;".$this->Html->link('Resume',$resume,array('escape'=>false,'style'=>'font-size:14px;'))."&nbsp;&nbsp;</th><td>".$this->Html->Image('delete-icon.png',array('width'=>16)).'&nbsp;'.$this->Html->link('Unapply',array('controller'=>'search','action'=>'userunapplyjobAction/'.$row['Job']['id']),array('escape'=>false,'style'=>'font-size:14px;'),sprintf('Sure about not applying this job?'))."</td></tr></table></div>".$this->Html->link($this->Html->Image('forward.png'),array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id']),array('escape'=>false,'class'=>'userJobs'))."<div style='clear:both'></div></li>";
											}
										?>
									</ul>
									<div style="clear:both;">&nbsp;</div>
									<div class="paging">
										<?php echo $this->Paginator->numbers();?>
									</div>
								</div>
								<div style="clear:both;"></div>
								<div id="savedJob" style="display:none;">
									<ul class="news-list">
										<?php 
											$i=0;
											foreach($savedJobs as $row){
												if($row['Job']['status']!=0){
													$status = "Open";
												}else{
													$status = "Closed";
												}
												$postdate = date("F j, Y", strtotime($row['jobs_saved']['modified']));
												$class='joblist';
												if($i++ % 2 ==0){
													$class ='altjoblist';
												}
												echo "<li class='".$class."'>".$this->Html->image('company_logos/'.$row['Job']['Company']['logo'],array('class'=>'compLogo'))."<div class='leftrow'>".$this->Html->link($row['Job']['title'],array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id']),array('escape'=>false))."</a><table id='jobsDesc'><tr><th>".$this->Html->Image('company-icon.png',array('width'=>16))."&nbsp;&nbsp;".$row['Job']['Company']['title']."</th><td>".$this->Html->Image('status-icon.png',array('width'=>16))."Status:&nbsp;(".$status.")</td></tr><tr><th>".$this->Html->Image('date-icon.png',array('width'=>16))."&nbsp;Saved on:&nbsp;".$postdate."&nbsp;&nbsp;</th><td>".$this->Html->Image('delete-icon.png',array('width'=>16)).'&nbsp;'.$this->Html->link('Unsave',array('controller'=>'search','action'=>'userunsavejobAction/'.$row['Job']['id']),array('escape'=>false,'style'=>'font-size:12px;'),sprintf('Are you sure about not saving this job?'))."</td></tr></table></div>".$this->Html->link($this->Html->Image('forward.png'),array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id']),array('escape'=>false,'class'=>'userJobs'))."<div style='clear:both'></div></li>";
										
											}
										?>
									</ul>
									<div style="clear:both;">&nbsp;</div>
								</div>
							</div>
						</div>
					<?php } ?>
						
					</div>
				</div>
			</div>
			<div style="clear:both;">&nbsp;</div>
		</article>
	</div>
</div>
<script type="text/javascript">
function showsavedjob()
{
	$("#jobApplication").hide();
	$("#savedJob").show();
	$("#sjlink").addClass("md");
	$("#jalink").removeClass("md");
}
function showjobapp()
{
	$("#jobApplication").show();
	$("#savedJob").hide();
	$("#sjlink").removeClass("md");
	$("#jalink").addClass("md");
}

</script>