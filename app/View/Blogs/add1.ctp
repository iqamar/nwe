<?php  echo $this->Html->script('ckeditor/ckeditor');?>
<?php 
	foreach ($edit_posts_dt as $post_dt_Row) {
		
		$post_title = $post_dt_Row['posts']['post_title'];
		$post_Id = $post_dt_Row['posts']['id'];
		$post_description = $post_dt_Row['posts']['description'];
		$category_id[] = $post_dt_Row['category_posts']['category_id'];
	}

?>
<form method="post" name="addGroup" onsubmit="return validateForm();" id="addGroup" action="/blogs/add/">
    	<div class="com_right" style="width:67%; margin-right:10px;">
        <div class="ttle-bar effectX">Add Post</div>
   		 <div class="fieldgroup">
   			 <label>Post Title</label>
      		 <input type="text" name="data[Post][post_title]" id="post_title" value="<?php if($post_title) echo $post_title;?>" />
             <div id="span_post_title" style="color:#B00;"></div>
             <input type="hidden" name="data[Post][user_id]" value="<?php echo $uid; ?>" />
             <input type="hidden" name="data[Post][id]" value="<?php echo $post_Id; ?>" />
       		<label>Description</label>
            <div id="span_description" style="color:#B00;"></div>
            <?php //echo $this->Form->textarea('content',array('class'=>'ckeditor'))?>
            <textarea type="text" name="data[Post][description]" class="ckeditor" id="description" rows="6" cols="60" style="width:100%; height:170px;">
            <?php if($post_description) echo $post_description;?>
            </textarea>  
       </div>
       </div>
	<div id="extra" class="com_right" style="width:32%;">
        <div class="ttle-bar effectX">Publish</div>
        	<fieldset>
            	<label>Categories</label>
            	<div class="fieldgroup" style="position:relative;">
					<ul>
                    	<span id="cat_list" style="position:relative;">
                        <div id="loadings" style="position:absolute; z-index:100px; left:70%; top:70%; text-align:center; display:none;"> 
                        	<?php echo $this->Html->image('loading.gif');?>	
                        </div>
                   		<?php foreach ($post_categories as $cat__Row) {
							$cat__id = $cat__Row['post_categories']['id'];
						?>              
					<li>
  		<input type="checkbox" value="<?php echo $cat__id;?>" id="cat_<?php echo $cat__id;?>" name="cat[]"  /> 
   	&nbsp;&nbsp; <?php echo $cat__Row['post_categories']['title'];?></li>
						<?php }?>
                        </span>
                        <!--<li><a href="javascript:add_category()" style="text-decoration:none; color:#0076EC; font-weight:bold;">+ category</a></li>-->
                        <li style="display:none;" id="cat_add">
                        <input type="text" name="data[Post][title]" id="category_title" placeholder="Add category" style="width:85%; float:left;" />
                        <a href="javascript:category_add()" class="savebtn" style="margin-right:7px;">Add</a></li>
                      </ul>  
                 <label style="float:left; clear:both; margin-left:8px;">Tags <span style="font-size:10px;"></span></label>
                 	<input type="hidden" name="data[Post][user_tags]" id="total_tags" value="<?php if($edit_posts_tags) {
					foreach ($edit_posts_tags as $tag__Row) { echo $tag__Row['tags']['post_tag'].","; }}?>" />
            	<input type="text" name="data[Post][tags]" id="post_tags" placeholder="Post tags" style="width:83%; float:left; clear:both; margin-left:8px;" onkeydown="showTotalTags(this.value);" />
                    <a href="javascript:add_tags()" class="savebtn" style="margin-right:7px;">Add</a>
                   
                    <div id="result_skill" style="width:280px; margin-left:10px; top:370px;">
                        
					</div>
                    <div id="tag_list" class="checkLIst">
                    
                    </div>
           		 </div>
            
            <input type="submit" value="Publish" class="pub_btn" />
             <input type="submit" value="Cancel" class="pub_btn" />
             </fieldset>
        </div>
</form>

<style type="text/css">
#addCompany label.error {
    color: #FB3A3A;
    display: inline-block;
    margin: 4px 0 5px 125px;
    padding: 0;
    text-align: left;
    width: 220px;
}
</style>
<script type="text/javascript">
function delMe(ids) {
	var total_tags = document.getElementById('total_tags').value;
	total_tags = total_tags.replace(ids+',', '');
    $('#'+ids).empty();
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
	url     : baseUrl+"/post_categories/add_category",
	type    : "POST",
	cache   : false,
	data    : {category_title: category_title},
	success : function(data){
	//if (share == 1) {
	$("#cat_list").html(data);
	$("#cat_add").slideUp('slow');
	//}
	},
	complete: function () {
		$("#cat_list").css('opacity', 1);
       $('#loadings').hide();
     },
	error : function(data) {
	$("#cat_list").html(data);
	}
	});	
}
function add_tags() {
	var post_tags = document.getElementById('post_tags').value;
	var tags_id = post_tags.replace(" ","_");
	$("#tag_list").append('<span id='+tags_id+'><a class="del_icon" onclick="return delMe(\''+tags_id+'\')"></a>'+post_tags+'</span>');
	document.getElementById('total_tags').value += post_tags+',';
	document.getElementById('post_tags').value = '';
}

function validateForm() {
	var post_title = document.getElementById('post_title').value;
	if (post_title == '') {
		$("#span_post_title").html("Enter the Title");
		$("#post_title").focus();
		return false;
	}
	else if(post_title != '') {
		$("#span_post_title").html("");
		return true;
	}
	else  {

	return true;	
	}
}
function showTotalTags(search_str) {
	var search_str = document.getElementById('post_tags').value;
	$.ajax({
              url     : baseUrl+"/blogs/search_tags",
              type    : "GET",
              cache   : false,
              data    : {search_str: search_str},
              success : function(data){
				  //alert(data);
				 // if (search_str !='') {
			  		$("#result_skill").html(data);
				 // }
				 // else {
					//$("#result_skill").html("");  
				  //}
              },
			  error : function(data) {
           $("#result_skill").html("there is error");
        }
          });
		  
	}
function assignTag(title,tag_id) {
		$("#result_skill").show('slow');
		document.getElementById('post_tags').value = title;
		$("#result_skill").html('');
		return true;
	}
</script>