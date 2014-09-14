<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<?php
/*foreach ($edit_posts_dt as $post_dt_Row) {
    $post_title = $post_dt_Row['blogs']['post_title'];
    $post_Id = $post_dt_Row['blogs']['id'];
    $post_description = $post_dt_Row['blogs']['description'];
    $category_id[] = $post_dt_Row['category_posts']['category_id'];
	$blogImage = $post_dt_Row['blogs']['image'];
}*/
//pr($post_dt_Row);
$post_title = $post_dt_Row['blogs']['post_title'];
    $post_Id = $post_dt_Row['blogs']['id'];
    $post_description = $post_dt_Row['blogs']['description'];
    $category_id[] = $post_dt_Row['category_posts']['category_id'];
	$blogImage = $post_dt_Row['blogs']['image'];
	//pr($category_id);
?>
<style>
.error{color:red;}
#result_skill ul li{border:1px solid #ccc;border-top:0;width:675px;padding:7px;}
#result_skill ul li:hover{background:#fafafa;}
</style>
<div class="box">
	<div class="boxheading">
		<h1>Add Blog</h1>
		<div class="boxheading-arrow"></div>
	</div>
	<span id="span_post_title" class="error"></span>
	<form method="post" class="addblog" name="addGroup" onsubmit="return validateForm();" enctype="multipart/form-data" id="addGroup" action="/blogs/add/">
		<fieldset>
			<label><h1>Blog Title<span class="redcolor">*</span></h1></label>
			<label>				
				<input type="text" name="data[Blog][post_title]" id="post_title" class="required" value="<?php if ($post_title) echo $post_title; ?>" />
                <span id="title_error"></span>
			</label>
			<label><h1>Blog Image</h1></label>
			<label>				
				<input type="file" name="data[Blog][post_image]" id="post_image" accept="jpg|png|gif|bmp"/>
				<div class="clear"></div>
				<?php if ($blogImage) echo $this->Html->Image(MEDIA_URL.'/files/blog/original/'.$blogImage,array('width'=>40,'height'=>40,'style'=>'margin:5px;')); ?>
				<span class="note-text">Images only (2MB maximum)</span>
			</label>
           	<label><h1>Blog Description</h1></label>
			<label>
				<textarea type="text" name="data[Blog][description]" class="ckeditor" id="description" rows="6" cols="60" style="width:100%; height:170px;">
					<?php if ($post_description) echo $post_description; ?>
				</textarea>
                <span id="description_error"></span>
			</label>
			<input type="hidden" name="data[Blog][user_id]" value="<?php echo $uid; ?>" />
            <input type="hidden" name="data[Blog][id]" value="<?php echo $post_Id; ?>" />
			
			<label><h1>Categories</h1></label>
			<div>
				<ul>
					<span id="cat_list" style="position:relative;">
					<?php
						foreach ($post_categories as $cat__Row) {
							$cat__id = $cat__Row['post_categories']['id'];
					?>              
					<li>
						<input type="checkbox" value="<?php echo $cat__id; ?>" id="cat_<?php echo $cat__id; ?>" name="cat[]"  /> 
						&nbsp;&nbsp; <?php echo $cat__Row['post_categories']['title']; ?>
					</li>
					<?php } ?>
					</span>
					<li style="display:none;" id="cat_add">
						<input type="text" name="data[Post][title]" id="category_title" placeholder="Add category" style="width:85%; float:left;" />
						<a href="javascript:category_add()" class="redcolor" style="margin-right:7px;">Add</a>
					</li>
				</ul>
			</div>
			<label>
				<h1>Add Tags (<a href="javascript:add_tags()" class="redcolor">Add</a>)</h1>
			</label>
			<label>
				 <input type="text" name="data[Blog][tags]" id="post_tags" placeholder="Add Tags for this Blog" onkeydown="showTotalTags(this.value);" />
				<div id="result_skill"></div>
			</label>
			<label><div id="tag_list" class="checkLIst"></div></label>
            <div class="clear"></div>
			<label>
				
				<input type="hidden" name="data[Blog][user_tags]" id="total_tags" value="<?php if ($edit_posts_tags) {foreach ($edit_posts_tags as $tag__Row) {echo $tag__Row['tags']['post_tag'] . ",";}}?>" />
			</label>
			<div>
				<input type="submit"  class="submitbttn" value="Publish Blog"/>
				<input name="" type="reset" value="Cancel"  class="canclebttn"/>
			</div> 
		</fieldset>
		
		
	</form>
<div class="clear"></div>
</div>
<?php echo $this->Html->Script(MEDIA_URL.'/js/jquery.validate.js');?>
<script type="text/javascript">

    function delMe(ids) {
        var total_tags = document.getElementById('total_tags').value;

        total_tags = total_tags.replace(ids + ',', '');

        $('#' + ids).empty();
        document.getElementById('total_tags').value = total_tags;

        return true;

    }

    function add_category() {

		$("#cat_add").slideToggle('slow');
    }

    function category_add() {

        $("#cat_list").css('opacity', 0.2);

        $('#loadings').show();

        var category_title = document.getElementById('category_title').value;

        //alert(category_title);

        $.ajax({
            url:"/post_categories/add_category",
            type: "POST",
            cache: false,
            data: {category_title: category_title},
            success: function(data) {

         
                $("#cat_list").html(data);

                $("#cat_add").slideUp('slow');

       

            },
            complete: function() {

                $("#cat_list").css('opacity', 1);

                $('#loadings').hide();

            },
            error: function(data) {

                $("#cat_list").html(data);

            }

        });

    }

    function add_tags() {

        var post_tags = document.getElementById('post_tags').value;

        var tags_id = post_tags.replace(" ", "_");

        $("#tag_list").append('<span id=' + tags_id + '><a class="tagblock" onclick="return delMe(\'' + tags_id + '\')">'+ post_tags +'</a></span>');

        document.getElementById('total_tags').value += post_tags + ',';

        document.getElementById('post_tags').value = '';

    }



    function validateForm() {

       // var post_title = document.getElementById('post_title').value;
	   var blog_title = $("#post_title").val();
	   var description = $("#description").val();
	   if (blog_title == '') {
		   $("#title_error").html('<div class="validate_error">Enter the Blog title.</div>');
		   $('html,body').animate({scrollTop: 0}, 'slow');
		   $("#post_title").focus();
		   return false;
		   
	   }
	   else {
		   $("#title_error").html('');
	   }
/*	   if (description == '') {
		   $("#description_error").html('<div class="validate_error">Enter the Blog Description.</div>');
		   $('html,body').animate({scrollTop: 200}, 'slow');
		   $("#description").focus();
		   return false;
		   
	   }
	   else {
		    $("#description_error").html('');
	   }*/
		
		if((Math.round(document.getElementById("post_image").files[0].size)/(1024*1024)) > 1)
		{
				
				$("#span_post_title").html("Maximum file size is restricted to 2MB.Please try again Uploading other image!");
				  return false;
				  
		}
         else {

			$("#span_post_title").html("");

            return true;

        }

    }

    function showTotalTags(search_str) {

        var search_str = document.getElementById('post_tags').value;

        $.ajax({
            url:"/blogs/search_tags",
            type: "GET",
            cache: false,
            data: {search_str: search_str},
            success: function(data) {

                //alert(data);

                // if (search_str !='') {

                $("#result_skill").html(data);

                // }

                // else {

                //$("#result_skill").html("");  

                //}

            },
            error: function(data) {

                $("#result_skill").html("there is error");

            }

        });



    }

    function assignTag(title, tag_id) {

        $("#result_skill").show('slow');

        document.getElementById('post_tags').value = title;

        $("#result_skill").html('');

        return true;

    }
	
$(document).ready(function() {
	 
	$('#addGroup').validate();
		
});

</script>
