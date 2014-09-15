<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/vertical.news.slider.css?v=1.0" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $this->webroot; ?>js/vertical.news.slider.js"></script>
<strong><caption><?php echo __('latest_jobs',true); ?></caption></strong>
<div class="news-holder cf">
	<?php $data = $this->requestAction('/search/JobsWidget/'); ?>
	<ul class="news-headlines">
	
	<?php 
	$cnt =0;
	foreach($data as $row){
		$postdate = date("F j", strtotime($row['Job']['modified']));
		if($cnt != 0){
			echo "<li>";
		}else{
			echo "<li class='selected'>";
			$cnt++;
		}
		echo $this->Html->link($row['Job']['title'],array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id']),array('escape'=>false))."&nbsp;<span class='num'>(".$postdate.")</span></li>";
	}
	?>
	</ul>
	<div class="news-preview">
	<?php foreach($data as $row){ ?>
	  <div class="news-content top-content">
		<div class="company-info">
			<?php echo $this->Html->image('company_logos/'.$row['Company']['logo'],array('title'=>$row['Company']['title'])); ?>
			<div class="company-text">
				<?php echo $this->Html->link($row['Company']['title'],'#',array('escape'=>false));?>
				<p><?php echo $row['Job']['city'].",&nbsp;".$row['Country']['name']; ?></p>
			</div>
		</div>
		<div class="clear"></div>
		<table>
		<strong>Job Summary</strong>
		<tbody>											
			<tr>
				<td >Expiry Date</td>
				<td><?php echo date('d-m-Y',strtotime($row['Job']['expiry_date'])); ?></td>																											
			</tr>
			<tr>
				<td >Functional Area</td>
				<td>Retail Banking</td>																	
			</tr>
			<tr>
				<td >Job Role</td>
				<td><?php echo $row['Job']['title']; ?></td>																
			</tr>
		</tbody>	
		</table>
		<?php echo $this->Html->link('View',array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id']),array('class'=>'smallButton readMore','escape'=>false));?>
	  </div><!-- .news-content -->
	  <?php } ?>
		
	</div><!-- .news-preview -->
	<div class="clear">&nbsp;</div>
	<?php echo $this->Html->link('More Jobs >>',array('controller'=>'search','action'=>'index'),array('class'=>'readMore')); ?>
  </div><!-- .news-holder -->