$(document).ready(function(){
	/*
	This function is called when the value of input type='file' changes.
	It further calls previewImage function which sets the image to 'preview_img'
	*/
	$("#myfile").change(function(){
	
    	previewImage(this);
		$("#share-bttns").show();
		$('#uploadButton').removeClass('over');
		$('#uploadButton').attr("disabled", false);
		
	});
	
});
function afterSuccess() {
    
	$("#output").hide();
	$('.result_txt').show();
	clearUpdate();
}
function previewImage(input) {
	if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.preview_img').show();
			$('.preview_img').attr('src', e.target.result);
			
			$('#div-for-share').show();
			$("textarea#link_content").val('');
			$('.result_txt').hide();
        }
		reader.readAsDataURL(input.files[0]);
    }
}
function showhide(divid, state){
document.getElementById(divid).style.display=state;
}

$(document).ready(function() {

	var getUrl  = $('#get_url'); //url to extract from text field
	
	getUrl.on('input paste keyup',function() { //user types url in text field		
		var link_content = $('#link_content');
		
		var match_url = /\b(https?):\/\/([\-A-Z0-9.]+)(\/[\-A-Z0-9+&@#\/%=~_|!:,.;]*)?(\?[A-Z0-9+&@#\/%=~_|!:,.;]*)?/i;
		
		if (match_url.test(getUrl.val())) {
			if(link_content.val()==''){
			if($("img#preimg").attr('src')==''){
				$("#results").hide();
				$("#output").show(); 
				
				var extracted_url = getUrl.val().match(match_url)[0];
				
				
				$.post('/companies/extractProcess',{'url': extracted_url}, function(data){         
               		
					extracted_images = data.images;
					total_images = parseInt(data.images.length-1);
					img_arr_pos = total_images;
					
					if(total_images>0){
						inc_image = '<div class="extracted_thumb" id="extracted_thumb"><img src="'+data.images[img_arr_pos]+'" width="100" height="100"></div>';
						inc_thumb = '<div class="thumb_sel"><span class="prev_thumb" id="thumb_prev">&nbsp;</span><span class="next_thumb" id="thumb_next">&nbsp;</span> </div><span class="small_text" id="total_imgs">'+img_arr_pos+' of '+total_images+'</span><span class="small_text">&nbsp;&nbsp;Choose a Thumbnail</span>';
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
					//$("textarea#get_url").val('');
					$('#div-for-share').show();
					$("#output").hide(); //hide loading indicator image
					$(".attach-file-tweet").hide();
					
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
	
$(".canclebttn").click(function(){
	$(".tweettextfield").animate({
		height:'15px'
		},
		"slow"
		);
	$("#tweetbttn").hide(0)({
	});
	});
});
$(function(){
	$(".shareupdate-field").focus(function(){
		$(this).animate({
			height:'50px'
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
	
	$("#updateUploader")[0].reset();
	$('.preview_img').attr('src', '');
	$('.preview_img').hide();
	$("#results").html('');
	document.getElementById('div-for-share').style.display = 'none';
	$(".attach-file-tweet").show();
	clearCheck();
	
}
$( document ).ready(function() {
  $("#success_mesg_hide").slideDown('slow').delay(300).fadeOut();
});
/*drop down jquery*/



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
		
		function showLikes(commentid,like){
		$("#user_like_update_"+commentid).html('<img src="http://media.networkwe.com/img/loading.gif" style="float:left;" />');
		var user_id = document.getElementById('user_id').value;
		var content_type = 'company';
		var created = document.getElementById('content_date_'+commentid).value;
		
		$.ajax({
		url     : NETWORKWE_URL+"/comments/add_like",
		type    : "GET",
		cache   : false,
		data    : {user_id: user_id,content_type:content_type,content_id:commentid,created:created,like:like},
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
			$('#group_loader'+commentid).show();
		var user_id = document.getElementById('user_id').value;
		var admin_id = document.getElementById('admin_id').value;
		var content_id = document.getElementById('content_id_'+commentid).value;
		var comment_text = document.getElementById('comment_text_'+commentid).value;
			if(comment_text !=''){
			
				$.ajax({
				url     : NETWORKWE_URL+"/companies/add_comments",
				type    : "POST",
				cache   : false,
				data    : {user_id: user_id,content_id:content_id,comments:comment_text,admin_id:admin_id},
				success : function(data){
					responseArray = data.split("::::");
					$("#total_following_"+commentid).html(responseArray[0]);
					$("#commentDiv_"+commentid).html(responseArray[1]);

					//if (share == 1) {
				//$("#commentDiv_"+commentid).html(data);
				//$("#comments_"+commentid).slideUp('slow');
				//$("ul li.content_"+commentid).css({'height':'124px'});
					//}
				},
				complete: function () {
					$('#group_loader'+commentid).hide();
					document.getElementById('comment_text_'+commentid).value = '';	
				 },
				error : function(data) {
				$("#commentDiv_"+commentid).html(data);
				}
				});
			}else{
				alert('Text field is empty!');
				
			}
		}


function unfollow(user_follow_id,user_id,status,company_id) {
	$("#company_follow_by_user").html('<img src="http://media.networkwe.com/img/loading.gif" />');
	$.ajax({
	url     : NETWORKWE_URL+"/companies/follow_page",
	type    : "POST",
	cache   : false,
	data    : {status:status,user_id:user_id,company_id:company_id,user_follow_id:user_follow_id},
	success : function(data){	
	//$(this).css('background','none');
	responseArray = data.split("::::");
	$("#total_following").html(responseArray[0]);
	$("#company_follow_by_user").html(responseArray[1]);
	if (status == 2) {
	document.getElementById('company_upt_form').style.display='block';
	}
	else {
	document.getElementById('company_upt_form').style.display='none';
	}
	},
	complete: function() {
		//$("#company_follow_by_user").html('');		
	},
	error : function(data) {
	$("#company_follow_by_user").html("error");
	}
	});
	
}

function showShare() {
document.getElementById('status_share_options').style.display='block';
return true;
}



function countChar(val,commentid) {
        var len = val.value.length;
        if (len > 75) {
          val.value = val.value.substring(0, 75);
		  document.getElementById('comment_text_'+commentid).disabled = true;
        } else {
          $('#comment_count_'+commentid).text(75 - len+' characters');
        }
      }
function expandComment(id) {
$('#comment_text_'+id).css({
            'height' : '80px'
        });
}
function delete_update(update_id) {
	var checkstr =  confirm('Are you want to delete this?');
		if(checkstr == true){
  			$.ajax({
					url     : NETWORKWE_URL+"/companies/delete_update",
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
					url     : NETWORKWE_URL+"/companies/delete_comment",
					type    : "GET",
					cache   : false,
					data    : {comment_id: comment_id,content_id:content_id},
					success : function(data){
						//if (share == 1) {
					//$("#message_update").slideDown('slow');
					//$("html, body").animate({ scrollTop: 0 }, "slow");
					$("#total_following_"+content_id).html(data);
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
