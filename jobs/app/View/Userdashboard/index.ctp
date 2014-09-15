<style>

.joblisting ul{width:600px;}
.tab1.active{background:#FFFFFF;}
.tab-container1 .panel-container1 {background:#FFFFFF;}
</style>
<?php echo $this->Html->script(MEDIA_URL.'/js/easyResponsiveTabs.js'); ?>
<script type="text/javascript">
	$(document).ready( function() {
	$('#tab-container1').easytabs();
	});
</script>
<div class="clear">&nbsp;</div>
<div class="box">
	<?php echo $this->Session->flash(); ?>
	<div id="tab-container1" class='tab-container1'>
		<ul class='etabs'>
			<li class='tab1'><a href="#jobapp">Job Application (<?php echo $countJobsapplied; ?>)</a></li>
			<li class='tab1'><a href="#savejob">Saved Jobs (<?php echo $countsavedJobs; ?>)</a></li>
			<li class='tab1'><a href="#reffer">Referred Job (<?php echo $countrefferjob; ?>)</a></li>
		</ul>
		<div class='panel-container1'>
			<div id="jobapp">
				<div class="sharepost-user">
					<?php if(!empty($appliedJobs)): ?>
				
					<?php 
					
					$i=0;
					foreach($appliedJobs as $row){
						if($row['Job']['status']!=0){
							$status = "Open";
						}else{
							$status = "Closed";
						}
						$postdate = date("F j, Y", strtotime($row['jobs_application']['modified']));
						$resume = MEDIA_URL.'/files/resume/'.$row['jobs_application']['cv'];
						
						if($row['Job']['Company']['logo']){
							if(file_exists(MEDIA_PATH.'/files/company/icon/'.$row['Job']['Company']['logo'])){
								$company_logo=MEDIA_URL.'/files/company/icon/'.$row['Job']['Company']['logo'];
							}else{
								$company_logo=MEDIA_URL.'/img/nologo.jpg';
							}
						}else{
								$company_logo=MEDIA_URL.'/img/nologo.jpg';
						}
					
						$listing ="<div class='joblisting'>";
						$listing.="<div class='job-com-logo'>".$this->Html->link($this->Html->Image($company_logo),array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id'].'/'.$row['Job']['title']),array('escape'=>false))."</div>";
						$listing.="<ul><li><h1>".$this->Html->link($row['Job']['title'],array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id'].'/'.$row['Job']['title']),array('escape'=>false))."</h1></li>";
						
						$listing.="<li>".$this->Html->link($row['Job']['Company']['title'],NETWORKWE_URL.'/companies/view/'.$row['Job']['Company']['id'].'/'.$row['Job']['Company']['title'],array('escape'=>false))."&nbsp;&nbsp;<span class='location'>(".$row['Job']['city'].",&nbsp;".$row['Job']['Country']['name'].")</span></li>";
						$listing.="<li><span class='postedon'>Applied On: ".$postdate."</span>";
						$listing.="<span class='postedon'>&nbsp;&nbsp;&nbsp;Status: ".$status."</span>";
						$listing.="<div class='job-listing-bttns'>";
						//$listing.=$this->Html->link('Resume',$resume,array('escape'=>false,'class'=>'jobapply-bttn'));
						$listing.="<span>&nbsp</span>".$this->Html->link('Unapply',array('controller'=>'Userdashboard','action'=>'userunapplyjobAction/'.$row['Job']['id']),array('escape'=>false,'class'=>'jobunsave-bttn'),sprintf('Sure about not applying this job?'));
						$listing.="</div></li></ul><div class='clear'></div></div>";
						
						echo $listing;
					}
						
					?>
				
				<div class="clear">&nbsp;</div>
				<?php echo $this->Html->link('See all job applications',array('controller'=>'Userdashboard','action'=>'allJobApplication'),array('escape'=>false,'style'=>'float:right;')); ?>
				<?php else: ?>
				<h3>You havn't applied to any jobs yet!</h3>
				<?php endif ?>
				
					<div class="clear"></div>
				</div>
			</div>
			<div id="savejob">
				<div class="sharepost-user">
					<?php if(!empty($savedJobs)): ?>
					<?php 
					$i=0;
					foreach($savedJobs as $row){
						if($row['Job']['status']!=0){
							$status = "Open";
						}else{
							$status = "Closed";
						}
						$postdate = date("F j, Y", strtotime($row['jobs_saved']['modified']));
						if($row['Job']['Company']['logo']){
							if(file_exists(MEDIA_PATH.'/files/company/icon/'.$row['Job']['Company']['logo'])){
								$company_logo=MEDIA_URL.'/files/company/icon/'.$row['Job']['Company']['logo'];
							}else{
								$company_logo=MEDIA_URL.'/img/nologo.jpg';
							}
						}else{
								$company_logo=MEDIA_URL.'/img/nologo.jpg';
						}
						$listing ="<div class='joblisting'>";
						$listing.="<div class='job-com-logo'>".$this->Html->link($this->Html->Image($company_logo),array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id'].'/'.$row['Job']['title']),array('escape'=>false))."</div>";
						$listing.="<ul><li><h1>".$this->Html->link($row['Job']['title'],array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id'].'/'.$row['Job']['title']),array('escape'=>false))."</h1></li>";
						$listing.="<li>".$this->Html->link($row['Job']['Company']['title'],NETWORKWE_URL.'/companies/view/'.$row['Job']['Company']['id'].'/'.$row['Job']['Company']['title'],array('escape'=>false))."&nbsp;&nbsp;<span class='location'>(".$row['Job']['city'].",&nbsp;".$row['Job']['Country']['name'].")</span></li>";
						$listing.="<li><span class='postedon'>Saved On: ".$postdate."</span>";
						$listing.="<span class='postedon'>&nbsp;&nbsp;&nbsp;Status: ".$status."</span>";
						$listing.="<div class='job-listing-bttns'>";
						$listing.=$this->Html->link('Unsave',array('controller'=>'Userdashboard','action'=>'userunsavejobAction/'.$row['Job']['id']),array('escape'=>false,'class'=>'jobunsave-bttn'),sprintf('Sure about not saving this job?'));
						$listing.="</div></li></ul><div class='clear'></div></div>";
					
						echo $listing;
					}
					?>
				
				<div class="clear">&nbsp;</div>
				<?php echo $this->Html->link('See all saved jobs',array('controller'=>'Userdashboard','action'=>'allJobSaved'),array('escape'=>false,'style'=>'float:right;')); ?>
				<?php else: ?>
				<h3>No job has been saved by you!</h3>
				<?php endif ?>
					<div class="clear"></div>
				</div>
			</div>
			<div id="reffer">
				<div class="sharepost-user">
					<?php if(!empty($refferedJob)): ?>
				
					<?php 
						//pr($refferedJob);
						$i=0;
						foreach($refferedJob as $row){
							if($row['Job']['status']!=0){
								$status = "Open";
							}else{
								$status = "Closed";
							}
							$referredBy = $row['Users_profile']['firstname'].'&nbsp;'.$row['Users_profile']['lastname'];
							$postdate = date("F j, Y", strtotime($row['jobs_referral']['modified']));
							if($row['Job']['Company']['logo']){
								if(file_exists(MEDIA_PATH.'/files/company/icon/'.$row['Job']['Company']['logo'])){
									$company_logo=MEDIA_URL.'/files/company/icon/'.$row['Job']['Company']['logo'];
								}else{
									$company_logo=MEDIA_URL.'/img/nologo.jpg';
								}
							}else{
									$company_logo=MEDIA_URL.'/img/nologo.jpg';
							}
							$listing ="<div class='joblisting'>";
							$listing.="<div class='job-com-logo'>".$this->Html->link($this->Html->Image($company_logo),array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id'].'/'.$row['Job']['title']),array('escape'=>false))."</div>";
							$listing.="<ul><li><h1>".$this->Html->link($row['Job']['title'],array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id'].'/'.$row['Job']['title']),array('escape'=>false))."</h1></li>";
							$listing.="<li>".$this->Html->link($row['Job']['Company']['title'],NETWORKWE_URL.'/companies/view/'.$row['Job']['Company']['id'].'/'.$row['Job']['Company']['title'],array('escape'=>false))."&nbsp;&nbsp;<span class='location'>(".$row['Job']['city'].",&nbsp;".$row['Job']['Country']['name'].")</span></li>";
							$listing.="<li>Reffered By: <span class='location'>".$referredBy."</span></li>";
							$listing.="<li><span class='postedon'>Reffered On: ".$postdate."</span>";
							$listing.="<span class='postedon'>&nbsp;&nbsp;&nbsp;Status: ".$status."</span>";
							$listing.="<div class='job-listing-bttns'>";
							$listing.=$this->Html->link('Remove',array('controller'=>'Userdashboard','action'=>'referredJobDelete/'.$row['Job']['id']),array('escape'=>false,'class'=>'jobunsave-bttn'),sprintf('Sure about not removing this job?'));
							$listing.="</div></li></ul><div class='clear'></div></div>";
						
							echo $listing;
							//echo "<li class='".$class."'>".$this->Html->image('company_logos/'.$row['Job']['Company']['logo'],array('class'=>'compLogo'))."<div class='leftrow'>".$this->Html->link($row['Job']['title'],array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id']),array('escape'=>false))."</a><table id='jobsDesc'><tr><th>".$this->Html->Image('company-icon.png',array('width'=>16))."&nbsp;&nbsp;".$row['Job']['Company']['title']."</th><td>".$this->Html->Image('status-icon.png',array('width'=>16))."Status:&nbsp;(".$status.")</td></tr><tr><th>".$this->Html->Image('date-icon.png',array('width'=>16))."&nbsp;Referred on:&nbsp;".$postdate."&nbsp;&nbsp;</th><td>".$this->Html->Image('delete-icon.png',array('width'=>16)).'&nbsp;'.$this->Html->link('Remove',array('controller'=>'Userdashboard','action'=>'referredJobDelete/'.$row['Job']['id']),array('escape'=>false,'style'=>'font-size:12px;'),sprintf('Are you sure about not saving this job?'))."</td></tr><tr><th>".$this->Html->Image('sendby-icon.png',array('width'=>16))."&nbsp;Referred By:&nbsp;".$this->Html->link($referredBy,$networkWeUrl.'/users_profiles/userprofile/'.$row['Users_profile']['user_id'],array('escape'=>false,'style'=>'font-size:12px;'))."</th><td>&nbsp;</td></tr></table></div>".$this->Html->link($this->Html->Image('forward.png'),array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id']),array('escape'=>false,'class'=>'userJobs'))."<div style='clear:both'></div></li>";
					
						}
					?>
				
				<div class="clear">&nbsp;</div>
				<?php echo $this->Html->link('See all referred jobs',array('controller'=>'Userdashboard','action'=>'allJobReferred'),array('escape'=>false,'style'=>'float:right;')); ?>
				<?php else: ?>
				<h3>No job has been forwarded to you!</h3>
				<?php endif ?>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
	

</div>
