
 <div class="whitebox ulstyle ul-black">
	<div class="greybox-div-heading">
		<h1>My Articles Details</h1>
	</div>
	<div class="margintop15"><h3>Drafts (<?php echo $count_draft; ?>)</h3></div>
		<ul>
			<?php
			foreach ($news_draft as $draft) {
				$news_title = substr($draft['News']['heading'],0,40);
				$news_id = $draft['News']['id'];
			?>
			<li>
				<strong><?php echo $this->Html->link($news_title,array('controller'=>'news','action'=>'edit_article',$news_id,$news_title),array('escape'=>false)); ?></strong>
			</li>
			<?php 
			}
			?>
		</ul>
	<div class="margintop15"><h3>Published (<?php echo $count_published; ?>)</h3></div>
		<ul>
			<?php
			foreach ($news_lists as $row) {
				$news_title = substr($row['News']['heading'],0,40);
				$news_id = $row['News']['id'];
			?>
			<li>
				<strong><?php echo $this->Html->link($news_title,array('controller'=>'news','action'=>'view',$news_id,$news_title),array('escape'=>false)); ?></strong>
			</li>
			<?php 
			}
			?>
		</ul>
		
</div>
<?php if($topviewednews): ?>
<div class="whitebox ulstyle ul-black">
	<div class="greybox-div-heading">
		<h1>Most Viewed</h1>
	</div>
	
		<ul>
			<?php
			
			foreach ($topviewednews as $toprow) {
				$topnews_title = substr($toprow['topnews']['heading'],0,40);
				$topnews_id = $toprow['topnews']['id'];
			?>
			<li>
				<strong><?php echo $this->Html->link($topnews_title,array('controller'=>'news','action'=>'view',$topnews_id,$topnews_title),array('escape'=>false)); ?></strong>
			</li>
			<?php 
			}
			?>
		</ul>
</div>
<?php endif; ?>