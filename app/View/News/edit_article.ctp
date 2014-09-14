<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<style>
.error{color:red;}
#result_skill ul li{border:1px solid #ccc;border-top:0;width:675px;padding:7px;}
#result_skill ul li:hover{background:#fafafa;}
.saveB{
	background: none repeat scroll 0 0 #c70000;
    border: 1px solid #b00314;
    border-radius: 3px;
    color: #fff;
    cursor: pointer;
    float: right;
    font-weight: bold;
    padding: 4px 10px;
	margin-left:5px;
	 
}
</style>
<div class="box">
	
	<ul class="etabs">
		<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/news/userarticles/" >Articles</a></li>
		<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/news/">All Articles</a></li>
		<li class="tab active"><a href="<?php echo NETWORKWE_URL;?>/news/add_article/" class="active">Post Articles</a></li>
	</ul>
	<span id="span_post_title" class="error"></span>
	<div class="white-con-box postarticle">
		<div class="page-heading">
			<h1>Post Your Article</h1>
        </div>
		<?php //pr($edit_news);
			
			$title = $edit_news['News']['heading'];
			$details = $edit_news['News']['details'];
			$img = $edit_news['News']['image_url'];
			$country_id = $edit_news['News']['country'];
			$news_url = $edit_news['News']['news_url'];
			$rss_link = $edit_news['News']['rss_link'];
			$publish = $edit_news['News']['publish'];
			$category_edit_id = $category_edit['Category_news']['category_id'];
			$cat_news_id = $category_edit['Category_news']['id'];
			//pr($category_edit_id);
			
		?>
		<form method="post" name="addNews" onsubmit="return chkSize();" enctype="multipart/form-data" id="addNews" action="/news/edit_article/" role="form">
			<label><h1>Title:</h1></label>
			<input type="text" name="heading" id="heading" class="required" value="<?php if($title){echo $title;}?>"/>
			
			<label><h1>Write Text:</h1></label>
			<label>
				<textarea  name="details" class="ckeditor" class="textarea" id="details" rows="" cols="60">
					<?php if ($details) echo $details; ?>
				</textarea>
				<span id="description_error"></span>
			</label>
			<label><h1>Featured Image:</h1></label>
			<label>
				<input type="file" name="image_url" id="image_url" accept="jpg|png|gif|bmp"/>
				<div class="clear"></div>
				<div class="clear"></div>
				<?php if ($img) echo $this->Html->Image(MEDIA_URL.'/files/news/original/'.$img,array('width'=>40,'height'=>40,'style'=>'margin:5px;')); ?>
				<span class="note-text">Images only (2MB maximum)</span>
				
			</label>
			<label><h1>Category:</h1></label>
			<label>
				<select class="droplist required" name="category" id="category">
					<option value="">Select Category</option>
					<?php foreach ($categories as $category): ?>
					<option value="<?=$category['News_category']['id']?>" <?php if($category_edit_id == $category['News_category']['id']) echo 'selected';?>><?=$category['News_category']['category']?></option>
					<?php endforeach; ?>
				</select>
			</label>
			<label><h1>Country:</h1></label>
			<label>
				<select style="width:237px;" class="droplist required" id="country" name="country">
					<option value="">Select</option>
					<?php foreach ($countries as $country): ?>
					<option value="<?php echo $country['Country']['id']; ?>" <?php if($country_id == $country['Country']['id']) echo 'selected';?>><?php echo trim($country['Country']['name']); ?></option>
					<?php endforeach; ?>
				</select>
				
				
			</label>
			<label><h1>Source URL:</h1></label>
			<label><input type="text" value="<?php if($news_url){echo $news_url;}?>" placeholder="http://" name="news_url"  id="news_url" class="url"></label>
			<label><h1>RSS Link:</h1></label>
			<label>
				<input type="text" name="rss_link" class="url" id="rss_link" value="<?php if($rss_link){echo $rss_link;}?>">
			</label>
			 <input type="hidden" name="ids" value="<?php echo $edit_news['News']['id']; ?>" />
			 <input type="hidden" name="cat_news_id" value="<?php echo $cat_news_id; ?>" />
			<label><h1>Publish:</h1></label>
			<label>
				<select style="width:237px;" class="droplist" id="published" name="published">
					<option value="0" <?php if($publish == 0) echo 'selected';?>>No</option>
					<option value="1" <?php if($publish == 1) echo 'selected';?>>Yes</option>
				</select>
				
			</label>
			<div class="clear"></div>
			<div class="postarticle-bttn">
				
				<input type="submit" value="Post Article" class="submitbttn">
				<input type="reset" class="canclebttn" value="Cancel" name="">
			</div>
		</form>
		<div class="clear"></div>
	</div>
	
	
	<!--div class="searchpanel">
	<form method="post" class="addblog" name="addNews" onsubmit="return validateForm();" enctype="multipart/form-data" id="addNews" action="/news/add/">
		<fieldset>
			<label><h1>Title<span class="redcolor">*</span></h1></label>
			<label>				
				<input type="text" name="title" id="title" class="required" value="" />
                <span id="title_error"></span>
			</label>
			<label><h1>Image</h1></label>
			<label>				
				<input type="file" name="image" id="image" accept="jpg|png|gif|bmp"/>
				<div class="clear"></div>
				<span class="note-text">Images only (2MB maximum)</span>
			</label>
           	<label><h1>Details</h1></label>
			<label>
				<textarea type="text" name="description" class="ckeditor" id="description" rows="6" cols="60" style="width:100%; height:170px;">
					<?php /*if ($post_description) echo $post_description; ?>
				</textarea>
                <span id="description_error"></span>
			</label>
					
			<label><h1>Categories</h1></label>
			<div>
				<select name="category[]" id="category" multiple="multiple" data-rel="chosen" required="">
				<?php foreach ($categories as $category): ?>
					<option value="<?=$category['News_category']['id']?>"><?=$category['News_category']['category']?></option>
				<?php endforeach; */?>
				</select>
				
			</div>
			<div>
				<input type="submit"  class="submitbttn" value="Publish Blog"/>
				<input name="" type="reset" value="Cancle"  class="canclebttn"/>
			</div> 
		</fieldset>
		
		
	</form>
	</div-->
<div class="clear"></div>
</div>

