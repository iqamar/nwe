<div class="rgtcol">
<div id="step1">
  <div class="greybox">
    <div class="greybox-div-heading">
      <h1>Category</h1>
    </div>
    <div class="ulstyle">
      <ul>
		<?php
		foreach($cat as $cats){
			echo "<li>".$this->Html->link($cats['press_categories']['category'],'/company/press/'.$cats['press_categories']['id'],array('escape'=>false))."</li>";
		}
		?>
      </ul>
    </div>
  </div>
</div>
</div>
<div class="leftcol">
<div class="box">
	<div class="boxheading">
		<h1>Press Release</h1>
		<div class="boxheading-arrow"></div>
	</div>
	<?php
				
		foreach ($data as $press__Row) {
			$pressId = $press__Row['press_releases']['id'];
			$created_date = $press__Row['press_releases']['created'];
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
				echo $this->Html->link($this->Html->image(MEDIA_URL.'/files/icon/'.$image,array('style'=>'width:55px; height:55px;')),array('controller'=>'company','action'=>'press_view',$pressId),array('escape'=>false)); 
			}else{
				echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array());
			}
			?>
		</div>
		<ul>
			<li>
				<h1><?php echo $this->Html->link($press__Row['press_releases']['headline'],array('controller'=>'company','action'=>'press_view',$pressId,$title_url),array()); ?></h1>
			</li>
			<li><span class="postedon">Posted On: <?php if ($created_date) { echo " ".$day." ".$month.", ".$year." at ".$time; }?></span></li>
		</ul>
		<div class="clear"></div>
	</div>
<?php } ?>

<!-- DC Pagination:C10 Start -->

<div class="clear"></div>
  </div>
  </div>




