<div class="tab-container" id="tab-container" data-easytabs="true">
<ul class="etabs">
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/news/userarticles/">Articles</a></li>
			<li class="tab active"><a href="#" class="current active">All Articles</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/news/add_article/">Add Articles</a></li>
		</ul>
<div class="searchpanel">
	<form action="#" method="post" name="news_cats">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="3"><h1>Latest Articles</h1></td>
			</tr>
			<tr>
				<td width="62"><input type="text" placeholder="Search news.." name="data[News][search]" id="search_news" class="textfield width2" /></td>
				<td width="19%">
					
					<select name="news_cat" id="news_cat" onchange="newsOfCategory(this.value);" class="droplist width2">
						<option selected="selected" value="0">All</option>
						<?php foreach ($news_categories as $news_cat_Row) { ?>
						<option value="<?php echo $news_cat_Row['news_categories']['id'];?>"><?php echo $news_cat_Row['news_categories']['category'];?></option>   
						<?php } ?>
					</select>
				</td>
				<td width="19%"><a href="javascript:search_news();" class="current inner-searchbttn">Search</a></td>
			</tr>
			<tr>
				<td colspan="3">
					<ul>
						<li>
							<select name="news_by_date" id="news_by_date" onchange="searchByDate(this.value);" class="droplist">
								<option selected="selected" value="0">Filter by Date</option>
								<option  value="7">Last 7 Days</option>
								<option  value="30">Last 30 Days</option>
								<option  value="90">Last 90 Days</option>
							</select>
						</li>
						<li>
							<select name="news_by_date" id="news_by_date" onchange="searchByCountry(this.value);" class="droplist">
								<option selected="selected" value="0">Filter by Country</option>
								<?php foreach ($country_news as $country__Row) {?>
								<option  value="<?php echo $country__Row['countries']['id'];?>"><?php echo $country__Row['countries']['name'];?></option>
								<?php }?>
							</select>
						</li>
						
					</ul>
				</td>
			</tr>
		</table>
	</form>
</div>
<div class="clear"></div>
<div id="posts_listing">
<?php
	foreach ($news_lists as $news__Row) {
		$newsId = $news__Row['News']['id'];
		$created_date = $news__Row['News']['created'];
		$year = date("Y", strtotime($created_date));
		$month = date("M", strtotime($created_date));
		$day = date("d", strtotime($created_date));
		$time = date("H:i:s", strtotime($created_date));
		$auther_fullname = $news__Row['users_profiles']['firstname']." ".$news__Row['users_profiles']['lastname'];
		$pub_profile = $news__Row['users_profiles']['handler'];
		//$title_url = strtolower($post__Row['posts']['post_title']);
		$title_url = str_replace(" ", "-", strtolower($news__Row['News']['heading']));
		?>
	<div class="blogslisitng" id="<?php echo $newsId;?>">
		<div class="blogdate"> <span><?php echo $day;?></span> <span class="smalltext"><?php echo $month;?></span><br />
		<span class="smalltext"><?php echo $year;?></span> </div>
		
		<div class="blogslisitng-pic">
			<?php 
			if ($news__Row['News']['image_url'] && file_exists(MEDIA_PATH.'/files/news/logo/'.$news__Row['News']['image_url'])) {
				
				echo $this->Html->link($this->Html->Image(MEDIA_URL.'/files/news/logo/'.$news__Row['News']['image_url'],array()),'#',array('class'=>'current','escape'=>false)); 
			} else {
				
				echo $this->Html->link($this->Html->Image(MEDIA_URL.'/img/nologo.jpg',array()),'#',array('class'=>'current','escape'=>false)); 
			  }?>
		</div>
		<div class="blogslisitng-rgt">
			<div class="blogtopdiv1" style="margin:5px 60px 15px 0px;">
				<h1><?php echo $this->Html->link($news__Row['News']['heading'],array('controller'=>'news','action'=>'view',$newsId,$title_url),array('style'=>'text-decoration:none;','class'=>'current'));?></h1>
			</div>
			
			<ul>
				<li><?php echo substr(strip_tags($news__Row['News']['details']),0,250).'...';?></li>
				<li><div class="more"><?php echo $this->Html->link('More',array('controller'=>'news','action'=>'view',$newsId,$title_url),array('class'=>'current more'));?></div></li>
			</ul>
		</div>
		<div class="clear"></div>
		<div>
			<?php
				if($userInfo['users']['id'] == $news__Row['News']['user_id']){
			?>
			<div class="blogby">
				<?php echo $this->Html->link('Edit',array('controller'=>'news','action'=>'edit_article',$newsId,$title_url),array('class'=>'edit_post'));?>
				
				<?php echo $this->Html->link('Delete',array('controller'=>'news','action'=>'delete_article',$newsId,$title_url),array('class'=>'delete_post','onClick'=> 'return confirm("Are you sure?")'));?>
			</div>
			<?php }?>
			<div class="articles-bttns"><?php echo "By ".$auther_fullname;?>
                <?php if ($created_date) { echo "on ".$day." ".$month.", ".$year." at ".$time; }?></div>
			
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<?php } ?>     
	<div class="clear"></div>   
</div>
</div>
<div style="text-align:center;" id="loader">
    <?php echo $this->Html->Image(MEDIA_URL.'/img/networkwe_loading.gif');?>
</div>