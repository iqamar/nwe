// JavaScript Document
function showInfo(div) {
$("#"+div).slideToggle('slow');
}
function checkValidate() {

var userid = document.getElementById('user_id').value;
var friendid = document.getElementById('friend_id').value;
if (friendid == userid)
alert("you cant sent reques to itself");
return false;
}
function closeMessage() {
	$("#hideMessage").slideUp('slow');
}
function showProfiles(id,user_id) {
	$.ajax({
	url     : NETWORKWE_URL+"/users_profiles/recommended_profiles",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,id:id},
	success : function(data){	
	//$(this).css('background','none');
	$("#resultDiv_"+id).html(data);
	},
	error : function(data) {
	$("#resultDiv_"+id).html("error");
	}
	});
}

function show_recommendation(id,type) {
	$("#recommendation_result").html('<img src="http://media.networkwe.com/img/loading.gif" style="text-align:center; margin-left:360px;" />');
	$.ajax({
	url     : NETWORKWE_URL+"/users_profiles/show_recommendation",
	type    : "GET",
	cache   : false,
	data    : {type: type,id:id},
	success : function(data){	
	//$(this).css('background','none');
	if (type == 'given') {
		$(".given").css('color','#333');
		$(".received").css('color','#B9B9B9');
	}
	else {
		$(".given").css('color','#B9B9B9');
		$(".received").css('color','#333');
	}
	$("#recommendation_result").html(data);
	},
	error : function(data) {
	$("#recommendation_result").html("error");
	}
	});
}

function hideMessageForm(id) {
document.getElementById('fade').style.display = 'none';
document.getElementById('userSendForm_'+id).style.display = 'none';
}
jQuery(function($) {
$("div#backgroundPopup").click(function() {
disablePopup(); // function close pop up
});
});
function showStarSign(star_id,user_id,star_type) {	
	$.ajax({
	url     : NETWORKWE_URL+"/users_profiles/user_star",
	type    : "GET",
	cache   : false,
	data    : {star_id: star_id,user_id:user_id,star_type:star_type},
	success : function(data){	
	//$(this).css('background','none');
	$("#starbox").fadeIn(0500); // fadein popup div
	$("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
	$("#backgroundPopup").fadeIn(0001);
	$("#starbox").html(data);
	},
	error : function(data) {
	$("#starbox").html("error");
	}
	});	
}
function disablePopup() {
//if(popupStatus == 1) { // if value is 1, close popup
$("#starbox").fadeOut("normal");
$("#backgroundPopup").fadeOut("normal");
//popupStatus = 0; // and set value to 0
//}
}
function hideUserSign() {
}

function unfollowMe (id,status,user_id,following_id,follow_container) {
	$("#followers_result"+user_id).html('<img src="http://networkwe.com/img/loading.gif" style="float:left;" />');
	$.ajax({
	url     : baseUrl+"/users_profiles/user_following",
	type    : "GET",
	cache   : false,
	data    : {id:id,status:status,user_id:user_id,following_id:following_id},
	success : function(data){	
	//$(this).css('background','none');
		if (follow_container == 'following') {
		$("#follow_result"+user_id).html(data);
		}
		else{
			$("#followers_result"+user_id).html(data);
		}
	},
	error : function(data) {
		$("#followers_result"+user_id).html(data);
	}
	});
}
function followers (id,status,user_id,following_id,follow_container) {
	$("#follow_result"+user_id).html('<img src="http://networkwe.com/img/loading.gif" style="float:left;" />');
	$.ajax({
	url     : baseUrl+"/users_profiles/user_followers",
	type    : "GET",
	cache   : false,
	data    : {id:id,status:status,user_id:user_id,following_id:following_id},
	success : function(data){	
	//$(this).css('background','none');
		if (follow_container == 'followers') {
			$("#followers_result"+user_id).html(data);
		}
		else {
			$("#follow_result"+user_id).html(data);
		}
	},
	error : function(data) {
		$("#followers_result"+user_id).html(data);
	}
	});
}

function unfollow(result_id,following_id,user_id,status,company_id) {
	
	$.ajax({
	url     : NETWORKWE_URL+"/users_profiles/companies_follow",
	type    : "POST",
	cache   : false,
	data    : {following_id:following_id,status:status,user_id:user_id,company_id:company_id,result_id:result_id},
	success : function(data){	
	//$(this).css('background','none');
	$("#company_follow_by_user"+following_id).html(data);
	},
	error : function(data) {
	$("#company_follow_by_user"+following_id).html(data);
	}
	});
	
}

function showUnfollow(following_id) {
$("#follow_comp"+following_id).html("Unfollow");
//$("#follow_comp"+following_id).toggleClass("unfollow");
}
function hideUnfollow(following_id) {
$("#follow_comp"+following_id).html("Following");
//$("#follow_comp"+following_id).toggleClass("follow");
}