<?php if ($userInfo) {?>
<div class="greybox">
	<div class="ulstyle1">
		<?php 
		$savedJobs = $this->requestAction('/search/user_saved_jobs/'); 
		$appliedJobs = $this->requestAction('/search/user_jobs_applied/'); 
		$allJobReferred = $this->requestAction('/Userdashboard/allJobReferred/'); 
		
		//pr($savedJobs);
		if(empty($savedJobs)){
			$countSaved='0';
		}else{
			$countSaved=$savedJobs[0];
		}
		?>
		<ul>
			<li><a href="/Userdashboard/index#jobapp"><span class="application-icon"></span>Your Applications <span class="totalnumber">(<?php echo $appliedJobs; ?>)</span></a></li>
			<li><a href="/Userdashboard/index#savejob"><span class="saved-icon"></span>Saved Jobs <span class="totalnumber">(<span id="refreshSave"><?php echo $countSaved;?></span>)</span></a></li>
			<li><a href="/Userdashboard/index#reffer"><span class="application-icon"></span>Referred Jobs <span class="totalnumber">(<?php echo $allJobReferred;?>)</span></a></li>
			
		</ul>
	</div>
</div>
<?php }?>
<?php 
	
	if(@$sjobs){
	
?>
<div class="greybox">
	<div class="greybox-div-heading">
		<h1>Similar Jobs </h1>
	</div>
	<div class="searchbylocation">
		<ul>
		<?php 
			
			$i=0;
			foreach($sjobs as $row){
				//$startdate = date("d-m-Y", strtotime($row['Job']['start_date']));
				//$enddate = date("d-m-Y", strtotime($row['Job']['expiry_date']));
				if($row['Company']['logo']){
					if(file_exists(MEDIA_PATH.'/files/company/icon/'.$row['Company']['logo'])){
						$company_logo=MEDIA_URL.'/files/company/icon/'.$row['Company']['logo'];
					}else{
						$company_logo=MEDIA_URL.'/img/nologo.jpg';
					}
				}else{
						$company_logo=MEDIA_URL.'/img/nologo.jpg';
				}
				
				//echo "<li>".$this->Html->link($row['Job']['title'],'#',array('escape'=>false))."</li>";
				echo "<li>".$this->Html->link('<span class="flagimg">'.$this->Html->Image($company_logo,array('width'=>32,'height'=>32)).'</span><span class="countryname">'.substr($row['Job']['title'],0,35).'&nbsp;</span>',array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id'].'/'.$row['Job']['title']),array('class'=>'current','escape'=>false))."</li>";
				
			}
		?>
		</ul>
	<div class="more"><?php echo $this->Html->link('More',array('controller'=>'search','action'=>'index/'.$urlid['Job']['id'].'/'.$urlid['Job']['title']),array('class'=>'current','escape'=>false)); ?></div>
	</div>
</div>
<?php }else{ ?>
<div class="greybox">
	<div class="greybox-div-heading">
		<h1>Jobs By Location </h1>
	</div>
	<div class="searchbylocation">
		<ul>
		<?php 
			$data1 = $this->requestAction('/search/searchByLocation/');
			$i=0;
			foreach($data1 as $row){
				if($i <6)

				echo "<li>".$this->Html->link('<span class="flagimg">'.$this->Html->Image(MEDIA_URL.'/files/flags/'.$row['JFA']['alpha_3'].'.png').'</span><span class="countryname">'.$row['JFA']['name'].'&nbsp;</span><span class="totalnumber">('.$row[0]['COUNT(FA.id)'].')</span>',array('controller'=>'search','action'=>'jobsByLocation/'.$row['JFA']['id'].'-'.$row['JFA']['name']),array('class'=>'current','escape'=>false))."</li>";
				$i++;
			}
		?>
		</ul>
	<div class="more"><?php echo $this->Html->link('More',array('controller'=>'search','action'=>'searchByLocation'),array('class'=>'current','escape'=>false)); ?></div>
	</div>
</div>
<?php } ?>

<div class="greybox">
	<div class="greybox-div-heading">
		<h1>Jobs By Function </h1>
	</div>
	<div class="ulstyle">
		<ul>
		<?php 
			$data = $this->requestAction('/search/searchByFunction/');
			//pr($data);exit;
			$i=0;
			foreach($data as $row){
				if($i <6)
				echo "<li>".$this->Html->link($row['J']['title'].'&nbsp;<span class="totalnumber">('.$row[0]['COUNT(FA.id)'].')</span>',array('controller'=>'search','action'=>'jobsByFunction/'.$row['J']['id'].'-'.$row['J']['title']),array('class'=>'current','escape'=>false))."</li>";
				$i++;
			}
		?>	
		</ul>
	</div>
  <div class="more"><?php echo $this->Html->link('More',array('controller'=>'search','action'=>'searchByFunction'),array('class'=>'current','escape'=>false)); ?></div>
</div>

<div class="greybox">
	<div class="greybox-div-heading">
		<h1>Jobs By Industry </h1>
	</div>
	<div class="ulstyle">
		<ul>
		<?php 
			$data = $this->requestAction('/search/searchByIndustry/');
			//pr($data);exit;
			$i=0;
			foreach($data as $row){
				if($i <6)
				echo "<li>".$this->Html->link($row['IND']['title'].'&nbsp;<span class="totalnumber">('.$row[0]['COUNT(J.id)'].')</span>',array('controller'=>'search','action'=>'jobsByIndustry/'.$row['IND']['id'].'-'.$row['IND']['title']),array('class'=>'current','escape'=>false))."</li>";
				$i++;
			}
		?>	
		</ul>
	</div>
  <div class="more"><?php echo $this->Html->link('More',array('controller'=>'search','action'=>'searchByIndustry'),array('class'=>'current','escape'=>false)); ?></div>
</div>