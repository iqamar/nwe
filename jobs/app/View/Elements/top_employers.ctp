<div class="greybox-div-heading">
	<h1>Job By Clients</h1>
</div>
<div class="carousel-wrap">
	<ul id="joblogos-list" class="clearfix">
	<?php $data = $this->requestAction('/search/companyWidgetHome/'); ?>
		<?php 
			foreach($data as $row){
				$companyName= substr($row['Company']['title'],0,35);
				if($row['Company']['logo']){
					if(file_exists(MEDIA_PATH.'/files/company/icon/'.$row['Company']['logo'])){
						$company_logo=MEDIA_URL.'/files/company/icon/'.$row['Company']['logo'];
					}else{
						$company_logo=MEDIA_URL.'/img/nologo.jpg';
					}
				}else{
						$company_logo=MEDIA_URL.'/img/nologo.jpg';
				}
				?>
		<li>
			<?php
				echo $this->Html->link($this->Html->Image($company_logo).'<div class="context">'.$companyName.'</div>','/search/jobs_by_company/'.$row['Company']['id'].'/'.$row['Company']['title'],array('class'=>'current','escape'=>false));
			
			?>
		</li>
		<?php  } ?>
		
		
	</ul>
 </div>
<!-- @end .carousel-wrap -->

<div class="carousel-nav clearfix">
	<!-- arrows http://findicons.com/icon/235460/forward?id=388672 -->
	<?php echo $this->Html->Image(MEDIA_URL.'/img/prev.png',array('id'=>'prv-joblogos', 'class'=>'prevbtn')); ?>
	<?php echo $this->Html->Image(MEDIA_URL.'/img/next.png',array('id'=>'nxt-joblogos', 'class'=>'nextbtn')); ?> 
</div>

