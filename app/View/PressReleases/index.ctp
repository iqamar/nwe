<div class="box" style="min-height:350px;">
	<div class="boxheading">
		<h1>Press Release</h1>
		<div class="boxheading-arrow"></div>
	</div>
	<?php
		foreach ($press_releases as $press__Row) {
			$pressId = $press__Row['press_release']['id'];
			$created_date = $press__Row['press_release']['created'];
			$year = date("Y", strtotime($created_date));
			$month = date("M", strtotime($created_date));
			$day = date("d", strtotime($created_date));
			$time = date("H:i:s", strtotime($created_date));
			
						
			$image = $press__Row['press_releases']['image_url'];
	?>
	<div class="normal-listing">
		<div class="normal-listing-logo">
			<?php 
			if($image){
				echo $this->Html->link($this->Html->image(MEDIA_URL.'/files/icon/'.$image,array('style'=>'width:55px; height:55px;')),array('controller'=>'press_releases','action'=>'view',$pressId),array('escape'=>false)); 
			}else{
				echo $this->Html->image(MEDIA_URL.'/img/no-logo.jpg',array());
			}
			?>
		</div>
		<ul>
			<li>
				<h1><?php echo $this->Html->link($press__Row['press_release']['headline'],array('controller'=>'press_releases','action'=>'view',$pressId,$title_url),array()); ?></h1>
			</li>
			<li><span class="postedon">Posted On: <?php if ($created_date) { echo " ".$day." ".$month.", ".$year." at ".$time; }?></span></li>
		</ul>
		<div class="clear"></div>
	</div>
<?php } ?>

<!-- DC Pagination:C10 Start -->
<div class="paging">
		<?php echo $this->Paginator->numbers(array('separator'=>'&nbsp;&nbsp;'));?>
	</div>
<div class="clear"></div>
  </div>




