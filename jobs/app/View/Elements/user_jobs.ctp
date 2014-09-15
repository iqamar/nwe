<strong><caption><?php echo __('Jobs you may be interested in',true); ?></caption></strong>
							
<ul class="news-list">
	<?php $data = $this->requestAction('/search/userJobwidget/'); ?>
	<?php 
	//pr($this->params['pass']);
		$i=0;
		foreach($data as $row){
			$jobexp = $row['Job']['min_experience'].'&nbsp;-&nbsp;'.$row['Job']['max_experience'];
			$postdate = date("F j, Y", strtotime($row['Job']['modified']));
			$class='joblist';
			if($i++ % 2 ==0){
				$class ='altjoblist';
			}
			echo "<li class='".$class."'>".$this->Html->image('company_logos/'.$row['Company']['logo'],array('class'=>'compLogo'))."<div class='leftrow'>".$this->Html->link($row['Job']['title'],array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id']),array('escape'=>false))."</a><table id='jobsDesc'><tr><th>".$this->Html->Image('company-icon.png',array('width'=>16))."&nbsp;&nbsp;".$row['Company']['title']."</th><td>".$this->Html->Image('experience-icon.png',array('width'=>16))."&nbsp;Experience: ".$jobexp."</td></tr><tr><th>".$this->Html->Image('location-icon.png',array('width'=>16)).$row['Job']['city']."&nbsp;,&nbsp;".$row['Country']['name']."&nbsp;&nbsp;</th><td>&nbsp;&nbsp;".$this->Html->Image('date-icon.png',array('width'=>16))."&nbsp;&nbsp;".$postdate."</td></tr></table></div>".$this->Html->link($this->Html->Image('forward.png'),array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id']),array('escape'=>false,'class'=>'userJobs'))."<div style='clear:both'></div></li>";
			
		}
	?>
	
</ul>
<div style="clear:both;">&nbsp;</div>
<?php echo $this->Html->link('More jobs for you >>',array('controller'=>'search','action'=>'index'),array('class'=>'readMore')); ?>
