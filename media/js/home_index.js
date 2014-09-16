$(document).ready(function(){
	/*
	This function is called when the value of input type='file' changes.
	It further calls previewImage function which sets the image to 'preview_img'
	*/
	$("#newAvatar").change(function(){
    	previewImage(this);
		$("#share-bttns").show();
		$('#uploadButton').removeClass('over');
		$('#uploadButton').attr("disabled", false);
		
	});
	$("#newAvatar1").change(function(){
		previewImage1(this);
		
  		$('#TW').removeClass('over');
		$('#TW').attr("disabled", false);
	
		
	});
	
	
});

// JavaScript Document

 
 	$(document).ready(function(){ 
			$("#sidebar_loader").html("<img src='"+media+"/img/loading.gif' alt='loading'/>");
					$.get(baseUrl+"/sidebars/user_activities/birthday",
					function(data){
						if (data != "") {
								$("#net_activities").html(data);
						//$(".as_country_container:last").after(data);			
						}
						
			});					   
	});// JavaScript Document 
	
	$(document).ready(function(){ 
					$.get(baseUrl+"/sidebars/related_jobs/job",
					function(data){
						if (data != "") {
								$("#net_jobs").html(data);
						//$(".as_country_container:last").after(data);			
						}
						
			});					   
	});// JavaScript Document
	
	$(document).ready(function(){ 
					$.get(baseUrl+"/sidebars/tweets_networkwe/tweets",
					function(data){
						if (data != "") {
								$("#net_tweets").html(data);
						//$(".as_country_container:last").after(data);			
						}
						
			});					   
	});// JavaScript Document 
	
	$(document).ready(function(){ 
					$.get(baseUrl+"/sidebars/get_latest_posts/blogs",
					function(data){
						if (data != "") {
							
								$("#net_blogs").html(data);
						//$(".as_country_container:last").after(data);	
						$("#sidebar_loader").html('');
						}

			});					   
	});// JavaScript Document 
	
 
function afterSuccess() {
    
	$("#output").hide();
	$('.result_txt').show();
	
}
function previewImage1(input) {
	
	if (input.files && input.files[0]) {
        
		var reader = new FileReader();
		
        reader.onload = function (e) {
            $('.preview_img').show();
			$('.preview_img').attr('src', e.target.result);
			
			$('#div-for-share1').show();
			
			$("#results").hide();
			
        }
		
		reader.readAsDataURL(input.files[0]);
		
    }
}
function previewImage(input) {
	
	if (input.files && input.files[0]) {
        
		var reader = new FileReader();
		
        reader.onload = function (e) {
            $('.preview_img').show();
			$('.preview_img').attr('src', e.target.result);
			
			$('#div-for-share').show();
			$('.result_txt').hide();
			$("textarea#link_content").val('');
			
			$("#results").hide();
			
        }
		
		reader.readAsDataURL(input.files[0]);
		
    }
}

function showhide(divid, state){
document.getElementById(divid).style.display=state;
}

function add_Friend()
{
     document.getElementById("userToConnect").submit();
} 
$(function(){
	
	var getUrl  = $('#get_url'); //url to extract from text field
	
	getUrl.on('input paste keyup',function() { //user types url in text field		
		
		
		var link_content = $('#link_content');
		//var preimg = $('#preimg');
		var match_url = /\b(https?):\/\/([\-A-Z0-9.]+)(\/[\-A-Z0-9+&@#\/%=~_|!:,.;]*)?(\?[A-Z0-9+&@#\/%=~_|!:,.;]*)?/i;
		
			
		if (match_url.test(getUrl.val())) {
				if(link_content.val()==''){
				if($("img#preimg").attr('src')==''){
				$("#results").hide();
				$("#output").show(); 
				$(".attach-file-tweet").hide();
				
				var extracted_url = getUrl.val().match(match_url)[0];
				
				
				$.post('/home/extractProcess',{'url': extracted_url}, function(data){         
               		
					extracted_images = data.images;
					total_images = parseInt(data.images.length-1);
					img_arr_pos = total_images;
					
					
					
					//alert(im);
					if(total_images>0){
						var img = new Image();
						img.src = data.images[img_arr_pos];
						if(img.height != 0){
							inc_image = '<div class="extracted_thumb" id="extracted_thumb"><img src="'+data.images[img_arr_pos]+'" width="100" height="100"/></div>';
							inc_thumb = '<div class="thumb_sel"><span class="prev_thumb" id="thumb_prev">&nbsp;</span><span class="next_thumb" id="thumb_next">&nbsp;</span> </div><span class="small_text" id="total_imgs">'+img_arr_pos+' of '+total_images+'</span><span class="small_text">&nbsp;&nbsp;Choose a Thumbnail</span>';
						}else{
							inc_image ='';
							inc_thumb ='';
						}
					}else{
						inc_image ='';
						inc_thumb ='';
					}
					//content to be loaded in #results element
					var content = '<div class="extracted_url">'+ inc_image +'<div class="extracted_content"><h4><a href="'+extracted_url+'" target="_blank">'+data.title+'</a></h4><p>'+data.content+'</p>'+inc_thumb+'</div></div>';
					var sharedCon = '<div class="extracted_url">'+ inc_image +'<div class="extracted_content"><h4><a href="'+extracted_url+'" target="_blank">'+data.title+'</a></h4><p>'+data.content+'</p></div></div>';
					$("textarea#link_content").val(sharedCon);
					//load results in the element
					$("#results").html(content); //append received data into the element
					$("#results").slideDown(); //show results with slide down effect
					$('#uploadButton').removeClass('over');
					$('#uploadButton').attr("disabled", false);
					
					$('#div-for-share').show();
					
					$("#output").hide(); //hide loading indicator image
					$(".attach-file-tweet").show();
                },'json');
				
				}
				}
		}
		
	});


	//user clicks previous thumbail
	$("body").on("click","#thumb_prev", function(e){		
		if(img_arr_pos>0) 
		{
			img_arr_pos--; //thmubnail array position decrement
			
			//replace with new thumbnail
			$("#extracted_thumb").html('<img src="'+extracted_images[img_arr_pos]+'" width="100" height="100">');
			
			//show thmubnail position
			$("#total_imgs").html((img_arr_pos) +' of '+ total_images);
		}
	});
	
	//user clicks next thumbail
	$("body").on("click","#thumb_next", function(e){		
		if(img_arr_pos<total_images)
		{
			img_arr_pos++; //thmubnail array position increment
			
			//replace with new thumbnail
			$("#extracted_thumb").html('<img src="'+extracted_images[img_arr_pos]+'" width="100" height="100">');
			
			//replace thmubnail position text
			$("#total_imgs").html((img_arr_pos) +' of '+ total_images);
		}
	});
});
$(function(){
	$(".tweettextfield").focus(function(){
		$(this).animate({
			height:'50px'
		},
		"slow"
		);
		$("#tweetbttn").show();
	});
$(".canclebttn").click(function(){
	$(".tweettextfield").animate({
		height:'15px'
		},
		"slow"
		);
	$("#tweetbttn").hide();
	});

	maxCharacters = 140;
	$('#tweet_count').text(maxCharacters);
	$('#twetarea').on('focus keyup', function() {
		var count = $('#tweet_count');
		var characters = $(this).val().length;
		if(characters > 0){
			if (characters > maxCharacters) {
				
				$('#TW').addClass('over');
				$('#TW').attr("disabled", 'true');
			} else {
				$('#TW').removeClass('over');
				$('#TW').attr("disabled", false);
			}
		}else{
			$('#TW').addClass('over');
			$('#TW').attr("disabled", 'true');
		}

		count.text(maxCharacters - characters);
		clearCheckTW();
	});
});
$(function(){
	$("#get_url").focus(function(){
		$(this).animate({
			height:'60px'
		},
		"slow"
		);
	$("#share-bttns").show();
	});
	
	$('#get_url').on('input paste focus keyup', function() {
		clearCheck();
		
	});
	
});

function clearCheck(){

	var link_content = $('#link_content');
	var textfield_url = $('#get_url');
	var results_url = $('#results').text();

	if((link_content.val()!='') || (textfield_url.val()!='') || ($("img#preimg").attr('src')!='') || (results_url!='')){
		$('#uploadButton').removeClass('over');
		$('#uploadButton').attr("disabled", false);
	}else{
		$('#uploadButton').addClass('over');
		$('#uploadButton').attr("disabled", 'true');
	}
}


function clearUpdate(){
	
	//$("#updateUploader")[0].reset();
	document.getElementById('link_content').value="";
	
	$('img#preimg').attr('src', '');
	$('.preview_img').hide();
	$("#results").html('');
	document.getElementById('div-for-share').style.display = 'none';
	clearCheck();
	
}
function clearUpdateTW(){
	
	//$("#updateUploader")[0].reset();
	$('img#preimgTW').attr('src', '');
	$('.preview_img').hide();
	$("#results").html('');
	document.getElementById('div-for-share1').style.display = 'none';
	$('#TW').addClass('over');
	$('#TW').attr("disabled", 'true');
	clearCheckTW();
}
function clearCheckTW(){
	    
	var twetarea =  $('#twetarea').val();
	if(($("img#preimgTW").attr('src')!='') || (twetarea!='')){
		$('#TW').removeClass('over');
		$('#TW').attr("disabled", false);
	}else{
		$('#TW').addClass('over');
		$('#TW').attr("disabled", 'true');
	}
}

$(document).ready( function() {
	$('#tab-container1').easytabs();
	});
$(document).ready( function() {
		
  $('#to_whome_update a').click(function(event) {
        var selected_value = this.id;
		if (selected_value == 0) {
            search_value = 'Public';
        }
        else if (selected_value == 1) {
            search_value = 'Connection';
        }
        else if (selected_value == 2) {
            search_value = 'Only Me';
        }
        document.getElementById('share_with').value = selected_value;
        $("#selected_update").html(search_value);
    });
 });
 

$(document).ready(function()
{
    $('#updateUploader').on('submit', function(e)
    {
        e.preventDefault();
        //$('#uploadButton').attr('disabled', ''); // disable upload button
        //show uploading image
         $("#output").show();
		 var LastDiv = $(".as_country_container:first"); /* get the first div of the dynamic content using ":first" */
		 var LastId  = $(".as_country_container:first").attr("id"); /* get the id of the first div */
		 
        $(this).ajaxSubmit({
        success: function(data){
		 var LastId  = $(".as_country_container:first").attr("id");
			if(LastId) {	
				if(data){
						LastDiv.before(data); 
						}
						
				var LastId  = $(".as_country_container:first").attr("id"); /* get the id of the first div */
				$('html, body').animate({
					scrollTop: $("#"+LastId).offset().top-300
				 }, 2000);
				
			}
			else {
				$("#updates_nt").html(data);
				$('html, body').animate({
					scrollTop: $("#updates_nt").offset().top-300
				 }, 2000);
			}
			},
		complete: function() {
		$("#output").hide();
		clearUpdate();
		$("#updateUploader")[0].reset();
		$('#get_url').val('');
		}
        });
    });
});


function checkField(commentID) {
	var fieldValue =  document.getElementById('comment_text_'+commentID).value;
		if (fieldValue == ' ') {
			document.getElementById('send'+commentID).style.display = 'none';
		}
	var fieldSize = fieldValue.length;
	if (fieldSize > 0 && fieldSize <= 140) {
		document.getElementById('send'+commentID).style.display = 'block';
	}
	else {
		document.getElementById('send'+commentID).style.display = 'none';
	}
}

function addTweet(user_id) {
//$('#edit_Recs').show();

 im = new Image();
    im.src = document.Tweet.photo.value;
if(!im.src)
    im.src = document.getElementById('myfile').value;
    alert(im.src);
	
var tweets = document.getElementById('twetarea').value;
var myfile = document.getElementById('myfile').value;
var status = document.getElementById('status').value;
$.ajax({
              url     :	"/tweets/add_tweet",
              type    : "POST",
              cache   : false,
              data    : {user_id: user_id, myfile:myfile,tweets:tweets,status:status},
              success : function(data){
			  $("#result_from_ajax").html(data);
              },
			  error : function(data) {
           $("#result_from_ajax").html("there is error");
        }
          });	
}

$('#share_category a').click(function(event) {

        var selected_value = this.id;

        var search_value = '';

        if (selected_value == 'Public') {

            search_value = 0;

        }

        else if (selected_value == 'Friends') {

            search_value = 1;

        }

        else if (selected_value == 'Only Me') {

            search_value = 2;

        }

        document.getElementById('Share_with').value = search_value;

        $("#selected_share").html(selected_value);

    });


function show_skill(){
$('#add_skill').slideToggle('slow');
}

function shareUpdates(id,share_type) {
//$('#edit_Recs').show();
if (share_type == 'updates'){
document.getElementById('fade').style.display = 'block';
document.getElementById('openEditWindow_'+id).style.display = 'block';
}
else if (share_type == 'shared'){
document.getElementById('fade').style.display = 'block';
document.getElementById('openShareWindow_'+id).style.display = 'block';
}
/*$.ajax({
              url     : baseUrl+"/users/edit_edu",
              type    : "GET",
              cache   : false,
              data    : {iD: id, counter:count},
              success : function(data){
			  $("#test").html(data);
              },
			  error : function(data) {
           $("#resultDiv_"+count).html("there is error");
        }
          });*/
		  
}
function close_EditWindow(id,share_type) {
	if (share_type == 'updates'){
document.getElementById('fade').style.display = 'none';
document.getElementById('openEditWindow_'+id).style.display = 'none';
}
else if (share_type == 'shared'){
	document.getElementById('fade').style.display = 'none';
document.getElementById('openShareWindow_'+id).style.display = 'none';
}

}
function showCongrates(cong_id) {
$("#congrates_"+cong_id).slideToggle('slow');
}
function send_Congrate_Message(cong_id) {
var user_id = document.getElementById('user_id').value;
var friend_id = document.getElementById('friend_id_'+cong_id).value;
var subject_id = document.getElementById('subject_id_'+cong_id).value;
var subject_type = document.getElementById('subject_type_'+cong_id).value;
var user_message = document.getElementById('user_message_'+cong_id).value;
$("#congrate_loader_"+cong_id).show();
$.ajax({
url     : baseUrl+"/connections/send_congrate_message",
type    : "POST",
cache   : false,
data    : {user_id: user_id,subject_type:subject_type,friend_id:friend_id,subject_id:subject_id,user_message:user_message},
success : function(data){
$("#congrateDIV_"+cong_id).html(data);
document.getElementById("user_message_"+cong_id).value = '';
},
complete: function() {
$("#congrate_loader_"+cong_id).hide();		
},
error : function(data) {
$("#congrateDIV_"+cong_id).html(data);
}
});
}
	
function showLikes(commentid,like){
$("#user_like_update_"+commentid).html('<img src="http://media.networkwe.com/img/loading.gif" style="float:left;" />');
var user_id = document.getElementById('user_id').value;
var content_type = document.getElementById('comment_type').value;
var content_id = document.getElementById('content_id_'+commentid).value;
var created = document.getElementById('comment_date_'+commentid).value;
var id = document.getElementById('id_'+commentid).value;

$.ajax({
url     : baseUrl+"/comments/add_like",
type    : "GET",
cache   : false,
data    : {user_id: user_id,content_type:content_type,content_id:content_id,created:created,like:like,id:id},
success : function(data){	
responseArray = data.split("::");
$("#user_like_update_"+commentid).html(responseArray[0]);
$("#ajax_res"+commentid).html(responseArray[1]);
},
error : function(data) {
$("#user_like_update_"+commentid).html("there is error");
}
});
}


function saveComment(commentid){
var user_id = document.getElementById('user_id').value;
var parent = document.getElementById('parent').value;
var share = document.getElementById('share').value;
var comment_type = document.getElementById('comment_type').value;
var content_id = document.getElementById('content_id_'+commentid).value;
var comment_date = document.getElementById('comment_date_'+commentid).value;
var comment_text = document.getElementById('comment_text_'+commentid).value;
var admin_id = document.getElementById('admin_id'+commentid).value;
//return false;
$("#comment_loader_"+commentid).show();
$.ajax({
url     : baseUrl+"/comments/add_comment",
type    : "POST",
cache   : false,
data    : {user_id: user_id,comment_type:comment_type,content_id:content_id,comment_date:comment_date,comment_text:comment_text,parent:parent,admin_id:admin_id},
success : function(data){
	//if (share == 1) {
responseArray = data.split("::::");
$("#total_comment_"+commentid).html(responseArray[0]);
$("#span_"+commentid).html(responseArray[1]);
$("#span_"+commentid).css({ opacity: 1 });
document.getElementById('comment_text_'+commentid).value = '';
document.getElementById('send'+commentid).style.display = 'none';
	//}
},
complete: function() {
$("#comment_loader_"+commentid).hide();		
},
error : function(data) {
$("#span_"+commentid).html(data);
}
});

	}
	
	
	function more_comments(post_id,admin_id){
		//return false;
		//var admin_id = document.getElementById('admin_id'+post_id).value;
		$("#comment_loader_"+post_id).show();
		$.ajax({
		url     : "/home/view_comments",
		type    : "GET",
		cache   : false,
		data    : {post_id: post_id,admin_id:admin_id},
		success : function(data){
			//if (share == 1) {
		$("#span_"+post_id).html(data);
			//}
		},
		complete: function() {
		$("#comment_loader_"+post_id).hide();		
		},
		error : function(data) {
		$("#span_"+post_id).html(data);
		}
		});

	}

	function showComments(commentId) {
	$("#comments_"+commentId).slideToggle('slow');
	//$("ul li.content_"+commentId).css({'height':'262px'});
	}
	function closeComment(commentId) {
	$("#comments_"+commentId).slideUp('slow');
	//$("ul li.content_"+commentId).css({'height':'124px'});
	}
	



function showOldComments(update_id) {
$("#view_old_comments_"+update_id).slideDown('slow');	
$("#view_link_"+update_id).hide('slow');
}

function delete_update(update_id) {
	var checkstr =  confirm('Are you want to delete this?');
		if(checkstr == true){
  			$.ajax({
					url     : baseUrl+"/home/delete_update",
					type    : "GET",
					cache   : false,
					data    : {update_id: update_id},
					success : function(data){
						//if (share == 1) {
					//$("#message_update").slideDown('slow');
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$("#message_update").slideDown('slow').delay(1000).fadeOut();
					$("#"+update_id).slideUp('slow');
						//}
					},
					complete: function() {
					$("#"+update_id).css({ opacity: 0.6 });		
					},
					error : function(data) {
					$("#"+update_id).html(data);
					}
			});
		}
		else{
		return false;
		}
}

function delete_comment(comment_id,content_id) {
	var checkstr =  confirm('Are you want to delete this?');
		if(checkstr == true){
  			$.ajax({
					url     : baseUrl+"/home/delete_comment",
					type    : "GET",
					cache   : false,
					data    : {comment_id: comment_id,content_id:content_id},
					success : function(data){
						//if (share == 1) {
					//$("#message_update").slideDown('slow');
					//$("html, body").animate({ scrollTop: 0 }, "slow");
					$("#total_comment_"+content_id).html(data);
					//$("#message_comment").slideDown('slow').delay(1000).fadeOut();
					$("#commentsbox"+comment_id).slideUp('slow');
						//}
					},
					complete: function() {
					$("#commentsbox"+comment_id).css({ opacity: 0.6 });		
					},
					error : function(data) {
					$("#commentsbox"+comment_id).html(data);
					}
			});
		}
		else{
		return false;
		}
}


$(document).ready(function() {
            $('.toolid').tooltip();
			 //$('#tooltip2').tooltip();
   }); 