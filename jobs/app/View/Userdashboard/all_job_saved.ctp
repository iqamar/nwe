<div class="clear">&nbsp;</div>
<div class="box">
	<div class="boxheading">
		<?php echo $this->Html->link('Go Back',array('controller'=>'Userdashboard','action'=>'index'),array('escape'=>false,'class'=>'seeall')); ?>
		<h1>Saved Job<span style="font-weight:normal;"> (<?php echo $countsavedJobs;?>)</span></h1>
		<div class="boxheading-arrow"></div>
	</div>

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
	<div class="paging">
		<?php echo $this->Paginator->numbers();?>
	</div>
	
<?php else: ?>
<div class="error">You havn't saved any jobs yet!</div>
<?php endif ?>
	<div class="clear"></div>
</div>
