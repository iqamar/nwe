<div class="clear">&nbsp;</div>
<div class="box">
	<div class="boxheading">
		<?php echo $this->Html->link('Go Back',array('controller'=>'Userdashboard','action'=>'index'),array('escape'=>false,'class'=>'seeall')); ?>
		<h1>Referred Jobs<span style="font-weight:normal;"> (<?php echo $countrefferjob;?>)</span></h1>
		<div class="boxheading-arrow"></div>
	</div>

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
	
		}
	?>

	<div class="clear">&nbsp;</div>
	<div class="paging">
		<?php echo $this->Paginator->numbers();?>
	</div>
	
<?php else: ?>
<div class="error">No job has been forwarded to you!</div>
<?php endif ?>
	<div class="clear"></div>
</div>

