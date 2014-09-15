<div class="clear">&nbsp;</div>
<div class="flash flash_success" id="savedJob" style="display:none;"></div>
<div class="box">
	<div class="boxheading">
		<h1><?= $sectionTitle; ?> &nbsp; <span class="searchbox-total">(<?= $this->Paginator->counter('{:count}'); ?>)</span></h1>
		<div class="boxheading-arrow"></div>
	</div>

	<?php 
	if (empty($userInfo)) {
		$userInfo['users']['id'] = '';
	}
		$jobsSaved = $this->requestAction('/search/checkSavedJob/'); 
		$i=0;
		foreach($data as $row){
			$jobtitle = str_replace(' ', '-', $row['Job']['title']);
			$startdate = date("d-m-Y", strtotime($row['Job']['start_date']));
			$enddate = date("d-m-Y", strtotime($row['Job']['expiry_date']));
			
			if($row['Company']['logo']){
				if(file_exists(MEDIA_PATH.'/files/company/icon/'.$row['Company']['logo'])){
					$company_logo=MEDIA_URL.'/files/company/icon/'.$row['Company']['logo'];
				}else{
					$company_logo=MEDIA_URL.'/img/nologo.jpg';
				}
			}else{
					$company_logo=MEDIA_URL.'/img/nologo.jpg';
			}
			$listing ="<div class='joblisting'>";
			$listing.="<div class='job-com-logo'>".$this->Html->link($this->Html->Image($company_logo),array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id'].'/'.$jobtitle),array('escape'=>false))."</div>";
			$listing.="<ul><li><h1>".$this->Html->link($row['Job']['title'],array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id'].'/'.$jobtitle),array('class'=>'current','escape'=>false))."</h1></li>";
			$listing.="<li>".$this->Html->link($row['Company']['title'],NETWORKWE_URL.'/companies/view/'.$row['Company']['id'].'/'.$row['Company']['title'],array('class'=>'current','escape'=>false))."&nbsp;&nbsp;<span class='location'>(".$row['Job']['city'].",&nbsp;".$row['Country']['name'].")</span></li>";
			$listing.="<li><span class='postedon'>Start Date: ".$startdate."&nbsp;-&nbsp;Expiry Date: ".$enddate."</span>";
			$listing.="<div class='job-listing-bttns'><span id='sj_".$row['Job']['id']."'>";
			if(in_array($row['Job']['id'],$jobsSaved)){
				$listing.="<a href='#' onclick='jobunsave(this);' value=".$row['Job']['id']." class='jobunsave-bttn' id='savejob_".$row['Job']['id']."'>Unsave</a>&nbsp;";
			}else{
				$listing.="<a href='#' onclick='jobsave(this);' value=".$row['Job']['id']." class='jobsave-bttn' id='savejob_".$row['Job']['id']."'>Save</a>&nbsp;";
			}
			$listing.="</span>&nbsp;<input type='hidden' id='user_id' value='".$userInfo['users']['id']."' />";
			$listing.=$this->Html->link('View Job Details',array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id'].'/'.$row['Job']['title']),array('escape'=>false,'class'=>'current jobapply-bttn'));
			$listing.="</div></li></ul><div class='clear'></div></div>";
			
			echo $listing;
		}
	?>
	<div class="clear"></div>
	<div class="paging">
		<?php echo $this->Paginator->numbers(array('tag'=>false,'separator'=>'&nbsp;&nbsp;'));?>
	</div>
	
</div>


