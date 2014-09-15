<div class="clear">&nbsp;</div>
<?php $this->Paginator->options(array('update' => '#ser','evalScripts'=>true,'url' => $this->passedArgs,'data'=>http_build_query($this->request->data),'method'=>'POST','before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false))));?>
<div class="flash flash_success" id="savedJob" style="display:none;"></div>
<div class="box">
	<div class="boxheading">
		<h1>Search Job Result &nbsp; <span class="searchbox-total">(<?= $this->Paginator->counter('{:count}'); ?>)</span></h1>
		
		<div class="boxheading-arrow"></div>
		
	</div>

	<?php 
	$jobsSaved = $this->requestAction('/search/checkSavedJob/'); 
	if(!empty($data)){
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
			$listing.="<ul><li><h1>".$this->Html->link($row['Job']['title'],array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id'].'/'.$jobtitle),array('escape'=>false))."</h1></li>";
			$listing.="<li>".$this->Html->link($row['Company']['title'],NETWORKWE_URL.'/companies/view/'.$row['Company']['id'].'/'.$row['Company']['title'],array('escape'=>false))."&nbsp;&nbsp;<span class='location'>(".$row['Job']['city'].",&nbsp;".$row['Country']['name'].")</span></li>";
			$listing.="<li><span class='postedon'>Start Date: ".$startdate."&nbsp;-&nbsp;Expiry Date: ".$enddate."</span>";
			$listing.="<div class='job-listing-bttns'><span id='sj_".$row['Job']['id']."'>";
			if(in_array($row['Job']['id'],$jobsSaved)){
				$listing.="<a href='#' onclick='jobunsave(this);' value=".$row['Job']['id']." class='jobunsave-bttn' id='savejob_".$row['Job']['id']."'>Unsave</a>&nbsp;";
			}else{
				$listing.="<a href='#' onclick='jobsave(this);' value=".$row['Job']['id']." class='jobsave-bttn' id='savejob_".$row['Job']['id']."'>Save</a>&nbsp;";
			}
			$listing.="</span>&nbsp;<input type='hidden' id='user_id' value='".$userInfo['users']['id']."' />";
			$listing.=$this->Html->link('View Job Details',array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id'].'/'.$row['Job']['title']),array('escape'=>false,'class'=>'jobapply-bttn'));
			$listing.="</div></li></ul><div class='clear'></div></div>";
			
			echo $listing;
		}
	}else{
		
		
		echo "<div class='error_msg'>Your search did not match any jobs !</div>";
		echo "<h3>Suggestions:</h3>";
		echo "<ul><li>Make sure all words are spelled correctly</li><li>Try changing filters on the left</li><li>Try more general keywords</li><li>Replace abbreviations with the entire word</li></ul>";
		echo "<br/><div class='boxheading'>".$this->Html->link('See All Jobs',array('controller'=>'search','action'=>'index'),array('escape'=>false,'class'=>'seeall'))."<h1>Suggested Jobs</h1><div class='boxheading-arrow'></div></div>";
		$userJob = $this->requestAction('/search/userJobwidget/');
		$i=0;
		
		foreach($userJob as $rows){
			if($i<4){
			$jobtitle = str_replace(' ', '-', $rows['Job']['title']);
			$startdate = date("d-m-Y", strtotime($rows['Job']['start_date']));
			$enddate = date("d-m-Y", strtotime($rows['Job']['expiry_date']));
			if($rows['Company']['logo']){
				if(file_exists(MEDIA_PATH.'/files/company/icon/'.$rows['Company']['logo'])){
					$company_logo=MEDIA_URL.'/files/company/icon/'.$rows['Company']['logo'];
				}else{
					$company_logo=MEDIA_URL.'/img/nologo.jpg';
				}
			}else{
					$company_logo=MEDIA_URL.'/img/nologo.jpg';
			}
		
			$listings ="<div class='joblisting'>";
			$listings.="<div class='job-com-logo'>".$this->Html->link($this->Html->Image($company_logo,array()),array('controller'=>'search','action'=>'jobDetails/'.$rows['Job']['id'].'/'.$jobtitle),array('escape'=>false))."</div>";
			$listings.="<ul><li><h1>".$this->Html->link($rows['Job']['title'],array('controller'=>'search','action'=>'jobDetails/'.$rows['Job']['id'].'/'.$jobtitle),array('escape'=>false))."</h1></li>";
			$listings.="<li>".$this->Html->link($rows['Company']['title'],NETWORKWE_URL.'/companies/view/'.$rows['Company']['id'].'/'.$rows['Company']['title'],array('escape'=>false))."&nbsp;&nbsp;<span class='location'>(".$rows['Job']['city'].",&nbsp;".$rows['Country']['name'].")</span></li>";
			$listings.="<li><span class='postedon'>Start Date: ".$startdate."&nbsp;-&nbsp;Expiry Date: ".$enddate."</span>";
			$listings.="<div class='job-listing-bttns'><span id='sj_".$rows['Job']['id']."'>";
			if(in_array($rows['Job']['id'],$jobsSaved)){
				$listings.="<a href='#' onclick='jobunsave(this);' value=".$rows['Job']['id']." class='jobunsave-bttn' id='savejob_".$rows['Job']['id']."'>Unsave</a>&nbsp;";
			}else{
				$listings.="<a href='#' onclick='jobsave(this);' value=".$rows['Job']['id']." class='jobsave-bttn' id='savejob_".$rows['Job']['id']."'>Save</a>&nbsp;";
			}
			$listings.="</span>&nbsp;<input type='hidden' id='user_id' value='".$userInfo['users']['id']."' />";
			$listings.=$this->Html->link('View Job Details',array('controller'=>'search','action'=>'jobDetails/'.$rows['Job']['id'].'/'.$rows['Job']['title']),array('escape'=>false,'class'=>'jobapply-bttn'));
			$listings.="</div></li></ul><div class='clear'></div></div>";
			$i++;
			echo $listings;
			}
		}
	}
	?>
	<div class="clear"></div>
	<div id="spinner" style="display: none;">
		<?php echo $this->Html->Image(MEDIA_URL.'/img/loading.gif', array('id' => 'busy-indicator')); ?>
	</div>
	<div class="paging">
		<?php echo $this->Paginator->numbers(array('separator'=>'&nbsp;&nbsp;'));?>
	</div>
	
	<?php echo $this->Js->writeBuffer();?>
</div>

