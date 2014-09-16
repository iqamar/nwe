function showShare() {
document.getElementById('status_share_options').style.display='block';
return true;
}

$(document).ready(function(){
	/*
	This function is called when the value of input type='file' changes.
	It further calls previewImage function which sets the image to 'preview_img'
	*/
	$("#myfile").change(function(){
    	previewImage(this);
		
	});
});
function afterSuccess() {
    $('.loading').hide();
	$('.result_txt').show();
}
function previewImage(input) {
	if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.preview_img').attr('src', e.target.result);
			$('.output_div').show();
			$('.result_txt').hide();
        }
		reader.readAsDataURL(input.files[0]);
    }
}
function openTweet() {
$('#twetarea').css({
            'height' : '70px'
        });
$('#tweetbtn').css({
            'display' : 'block'
        });

}
/*function closeTweet() {
$('#twetarea').css({
            'height' : '30px'
        });
$('#tweetbtn').css({
            'display' : 'none'
        });
}*/

function openReplayTweet(tweet_id) {
$('#tweet_reply_'+tweet_id).css({
            'height' : '70px'
        });
$('#tweetReplaybtn_'+tweet_id).css({
            'display' : 'block'
        });
}


function addTweet(user_id) {
//$('#edit_Recs').show();
alert(user_id);
 im = new Image();
    im.src = document.Tweet.photo.value;
if(!im.src)
    im.src = document.getElementById('myfile').value;
    alert(im.src);
	
var tweets = document.getElementById('twetarea').value;
var myfile = document.getElementById('myfile').value;
var status = document.getElementById('status').value;
$.ajax({
              url     : baseUrl+"/tweets/add_tweet",
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
function countChar(val) {
        var len = val.value.length;
        if (len >= 140) {
          val.value = val.value.substring(0, 140);
		  document.getElementById('twetarea').disabled = true;
        } else {
          $('#tweet_count').text(140 - len+' characters');
        }
      }
function countReply(val) {
        var len = val.value.length;
        if (len >= 115) {
          val.value = val.value.substring(0, 115);
		  document.getElementById('tweet_reply').disabled = true;
        } else {
          $('#Reply_tweet_count').text(115 - len+' characters');
        }
      }
function showTweets(tweet_id) {
	$("#expand_tweet_"+tweet_id).slideToggle('slow');
	$("#view_collapse_"+tweet_id).css({
            'display' : 'block'
        });
	$("#view_expand_"+tweet_id).css({
            'display' : 'none'
        });
}
function HideTweets(tweet_id) {
	$("#expand_tweet_"+tweet_id).slideToggle('slow');
	$("#view_expand_"+tweet_id).css({
            'display' : 'block'
        });
	$("#view_collapse_"+tweet_id).css({
            'display' : 'none'
        });
}
function viewPhoto(tweet_id) {
	$('#view_photo_'+tweet_id).css({
            'display' : 'none'
        });
		$('#hide_photo_'+tweet_id).css({
            'display' : 'block'
        });
	$("#expand_tweet_photo_"+tweet_id).slideToggle('slow');
}
function hidePhoto(tweet_id) {
	$('#view_photo_'+tweet_id).css({
            'display' : 'block'
        });
		$('#hide_photo_'+tweet_id).css({
            'display' : 'none'
        });
	$("#expand_tweet_photo_"+tweet_id).slideToggle('slow');
}
function user_tweets(user_id) {
	$('#loadings').show();
	$.ajax({
              url     : baseUrl+"/tweets/user_tweets",
              type    : "GET",
              cache   : false,
              data    : {user_id: user_id},
              success : function(data){
			  $("#result_from_ajax").html(data);
              },
     		 complete: function () {
      		 $('#loadings').hide();
                },
			  error : function(data) {
           $("#result_from_ajax").html("there is error");
        }
          });	
}
function user_following(user_id) {
	$('#loadings').show();
	$.ajax({
              url     : baseUrl+"/tweets/user_following",
              type    : "GET",
              cache   : false,
              data    : {user_id: user_id},
              success : function(data){
			  $("#result_from_ajax").html(data);
              },
     		 complete: function () {
      		 $('#loadings').hide();
                },
			  error : function(data) {
           $("#result_from_ajax").html("there is error");
        }
          });	
}
function user_followers(user_id) {
	$('#loadings').show();
	$.ajax({
              url     : baseUrl+"/tweets/user_followers",
              type    : "GET",
              cache   : false,
              data    : {user_id: user_id},
              success : function(data){
			  $("#result_from_ajax").html(data);
              },
     		 complete: function () {
      		 $('#loadings').hide();
                },
			  error : function(data) {
           $("#result_from_ajax").html("there is error");
        }
          });	
}
function user_favorites(user_id) {
	$('#loadings').show();
	$.ajax({
              url     : baseUrl+"/tweets/user_favorites",
              type    : "GET",
              cache   : false,
              data    : {user_id: user_id},
              success : function(data){
			  $("#result_from_ajax").html(data);
              },
     		 complete: function () {
      		 $('#loadings').hide();
                },
			  error : function(data) {
           $("#result_from_ajax").html("there is error");
        }
          });	
}
function tweet_replay(content_id) {
	var user_id = document.getElementById('user_id').value;
	var comment_type = document.getElementById('comment_type').value;
	var created = document.getElementById('created_'+content_id).value;
	var tweet_reply = document.getElementById('tweet_reply_'+content_id).value;
	$("#comments_loadings"+content_id).show();	
	$.ajax({
		url     : baseUrl+"/tweets/add_tweet_replay",
		type    : "GET",
		cache   : false,
		data    : {user_id: user_id,comment_type:comment_type,content_id:content_id,created:created,tweet_reply:tweet_reply},
		success : function(data){
			//if (share == 1) {
			responseArray = data.split("::::");
			$("#span_"+content_id).html(responseArray[1]);
			$("#total_comment_"+content_id).html(responseArray[0]);
			//$("#expand_tweet_"+content_id).slideUp('slow');
			document.getElementById('tweet_reply_'+content_id).value = '';
			document.getElementById('send'+content_id).style.display = 'none';
			//}
		},
		complete: function () {
			$("#comments_loadings"+content_id).hide();
		},
		error : function(data) {
			$("#span_"+content_id).html(data);
		}
	});
}
function favoriteTweet(tweet_id,favorite) {
	var user_id = document.getElementById('user_id').value;
	$("#user_like_update_"+tweet_id).html('<img src="http://media.networkwe.com/img/loading.gif" style="float:left;" />');
	//alert(tweet_id+"and"+favorite+"and"+user_id);
	$.ajax({
	url     : baseUrl+"/tweets/add_favorite",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,content_id:tweet_id,favorite:favorite},
	success : function(data){	
	//$(this).css('background','none');
	//$("#alike"+commentid).css('display','none');
	//$("#likediv"+commentid).css('display','block');
	$("#user_like_update_"+tweet_id).html('');
	$("#user_like_update_"+tweet_id).html(data);
	},
	error : function(data) {
	$("#user_like_update_"+tweet_id).html("there is error");
	}
	});	
}

function showRetweet(tweet_id) {
$('#loadings').show();
document.getElementById('fade').style.display = 'block';
document.getElementById('openEditWindow_'+tweet_id).style.display = 'block';
 $('#loadings').hide();
}
function close_RetweetWindow(tweet_id) {
document.getElementById('fade').style.display = 'none';
document.getElementById('openEditWindow_'+tweet_id).style.display = 'none';
}

function tweetToRetweet(tweet_id) {
	var user_id = document.getElementById('user_id').value;
	var actor_id = document.getElementById('actor_id').value;
	var photo = document.getElementById('photo_'+tweet_id).value;
	var tweet = document.getElementById('tweet_'+tweet_id).value;
	document.getElementById('retweet_popup'+tweet_id).style.display = 'none';
	document.getElementById('fade').style.display = 'none';
	if (actor_id != '') {
		if (actor_id == user_id) {
			$("html, body").animate({ scrollTop: 0 }, "slow"); 
			$('#loadings').show();
		}
	}
	else {
		
		$("html, body").animate({ scrollTop: 0 }, "slow"); 
		$('#loadings').show();
	}
	$.ajax({
              url     : baseUrl+"/tweets/retweet",
              type    : "POST",
              cache   : false,
              data    : {user_id: user_id,tweet:tweet,photo:photo,parent_id:tweet_id},
              success : function(data){
			  $("#retweet_"+tweet_id).css({
            	'display' : 'none'
       			 });
			  
			  $("#retweeted_"+tweet_id).css({
            	'display' : 'block'
       			 });
			  if (actor_id != '') {
					if (actor_id == user_id) {
						$("#user_add_tweets").html(data);
					}
				}
				else {
					
					$("#user_add_tweets").html(data);
				}
			  
              },
     		 complete: function () {
      		 $('#loadings').hide();
                },
			  error : function(data) {
           $("#retweeted_"+tweet_id).html("there is error");
        }
          });		
}

function backtotweet(tweet_id) {

	//$('#loadings').show();
	$("#retweeted_"+tweet_id).html('<img src="http://media.networkwe.com/img/loading.gif" alt="loading"/>');
	$.ajax({
              url     : baseUrl+"/tweets/back_tweet",
              type    : "POST",
              cache   : false,
              data    : {parent_id:tweet_id},
              success : function(data){
			  $("#"+tweet_id).slideUp('slow');
			  $("html, body").animate({ scrollTop: 0 }, "slow");
			  $("#user_add_tweets").html(data);
              },
     		 complete: function () {
				 $("#retweeted_"+tweet_id).html('');
      		 //$('#loadings').hide();
                },
			  error : function(data) {
           $("#retweet_"+tweet_id).html("there is error");
        }
          });		
}

function close_PopUp_Favorite(tweet_id) {
document.getElementById('fade').style.display = 'none';
document.getElementById('openFavoriteWindow').style.display = 'none';
}
function close_PopUp_Retweet(tweet_id) {
document.getElementById('fade').style.display = 'none';
document.getElementById('openRetweetWindow').style.display = 'none';
}
/*show tweet favorites*/
function showTweetFavorite(tweet_id) {
	$('#loadings').show();
	document.getElementById('fade').style.display = 'block';
	document.getElementById('openFavoriteWindow').style.display = 'block';
	$.ajax({
              url     : baseUrl+"/tweets/tweet_favorite_users",
              type    : "POST",
              cache   : false,
              data    : {tweet_id:tweet_id},
              success : function(data){
			  $("#openFavoriteWindow").html(data);
              },
     		 complete: function () {
      		 $('#loadings').hide();
                },
			  error : function(data) {
           $("#openFavoriteWindow").html("there is error");
        }
          });
}
function showTweetRetweeted(tweet_id) {
	document.getElementById('fade').style.display = 'block';
	document.getElementById('openRetweetWindow').style.display = 'block';
	
	$('#loadings').show();
	$.ajax({
              url     : baseUrl+"/tweets/tweet_retweet_users",
              type    : "POST",
              cache   : false,
              data    : {tweet_id:tweet_id},
              success : function(data){
			  $("#openRetweetWindow").html(data);
              },
     		 complete: function () {
      		 $('#loadings').hide();
                },
			  error : function(data) {
           $("#openRetweetWindow").html("there is error");
        }
          });
}
function delete_tweet(tweet_id,total_tweet) {
  			$.ajax({
					url     : baseUrl+"/tweets/delete_tweet",
					type    : "GET",
					cache   : false,
					data    : {tweet_id: tweet_id,total_tweet:total_tweet},
					success : function(data){
						//if (share == 1) {
					//$("#message_update").slideDown('slow');
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$("#message_tweet").slideDown('slow').delay(1000).fadeOut();
					$("#"+tweet_id).slideUp('slow');
					responseArray = data.split(":::");
					$("#user_add_tweets").html(responseArray[0]);
					$("#total_added_tweets").html(responseArray[1]);
						//}
					},
					complete: function() {
					$("#"+tweet_id).css({ opacity: 0.6 });		
					},
					error : function(data) {
					$("#"+tweet_id).html(data);
					}
			});
}
function delete_comment(comment_id,content_id) {
  			$.ajax({
					url     : baseUrl+"/tweets/delete_comment",
					type    : "GET",
					cache   : false,
					data    : {comment_id: comment_id,content_id:content_id},
					success : function(data){
						//if (share == 1) {
					//$("#message_update").slideDown('slow');
					//$("html, body").animate({ scrollTop: 0 }, "slow");
					//$("#total_comment_"+content_id).html(data);
					$("#message_comment_tweet").slideDown('slow').delay(1000).fadeOut();
					$("#commentsbox"+comment_id).slideUp('slow');
					$("#total_comment_"+content_id).html(data);
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
$(function(){
	$(".tweettextfield").focus(function(){
		$("#tweetbttn").show({
		});
		$(this).animate({
			height:'45px'
		},
		"slow"
		);
	});
$(".canclebutton-small").click(function(){
	$("#tweetbttn").hide({
	});
	$(".tweettextfield").animate({
		height:'15px'
		},
		"slow"
		);
	});
});

function showhide(divid, state){
document.getElementById(divid).style.display=state
}



function loadPopup(ID) {
//if(popupStatus == 0) { // if value is 0, show popup
//closeloading(); // fadeout loading
$("#retweet"+ID).fadeIn(0500); // fadein popup div
$("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
$("#backgroundPopup").fadeIn(0001);
//popupStatus = 1; // and set value to 1
//}
}
function disablePopup(ID) {
//if(popupStatus == 1) { // if value is 1, close popup
$("#retweet"+ID).fadeOut("normal");
$("#backgroundPopup").fadeOut("normal");
//popupStatus = 0; // and set value to 0
//}
}
/************** end: functions. **************/
function delete_user_tweet(tweet_id) {
	var checkstr =  confirm('Are you want to delete this?');
		if(checkstr == true){
  			$.ajax({
					url     : baseUrl+"/tweets/delete_tweet",
					type    : "GET",
					cache   : false,
					data    : {tweet_id: tweet_id},
					success : function(data){
						//if (share == 1) {
					//$("#message_update").slideDown('slow');
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$("#message_user_tweet").slideDown('slow').delay(1000).fadeOut();
					$("#user_"+tweet_id).slideUp('slow');
						//}
					},
					complete: function() {
					$("#user_"+tweet_id).css({ opacity: 0.6 });		
					},
					error : function(data) {
					$("#user_"+tweet_id).html(data);
					}
			});
		}
		else{
		return false;
		}
}

function clickToRetweet(tweet_id) {
	var user_id = document.getElementById('user_id').value;
	var photo = document.getElementById('photo_'+tweet_id).value;
	var tweet = document.getElementById('tweet_'+tweet_id).value;
$('#loadings').show();
	$.ajax({
              url     : baseUrl+"/tweets/retweet",
              type    : "POST",
              cache   : false,
              data    : {user_id: user_id,tweet:tweet,photo:photo,parent_id:tweet_id},
              success : function(data){
			  $("#retweet_"+tweet_id).css({
            	'display' : 'none'
       			 });
			  
			  $("#retweeted_"+tweet_id).css({
            	'display' : 'block'
       			 });
			  
			    $("#retweet"+tweet_id).css({
            	'display' : 'none'
       			 });
				document.getElementById('backgroundPopup').style.display = 'none';
              },
     		 complete: function () {
      		 $('#loadings').hide();
                },
			  error : function(data) {
           $("#retweeted_"+tweet_id).html("there is error");
        }
          });		
}
function checkField(commentID) {
	var fieldValue =  document.getElementById('tweet_reply_'+commentID).value;
		if (fieldValue == ' ') {
			document.getElementById('send'+commentID).style.display = 'none';
		}
	var fieldSize = fieldValue.length;
	if (fieldSize > 0 && fieldSize <= 113) {
		document.getElementById('send'+commentID).style.display = 'block';
	}
	else {
		document.getElementById('send'+commentID).style.display = 'none';
	}
}
