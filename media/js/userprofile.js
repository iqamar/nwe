function cancelRequest() {
	$("#approval").css({ display: 'none'});	
	$("#request").css({ display: 'block'});	
}
function showApproval() {
	$("#approval").css({ display: 'block'});	
	$("#request").css({ display: 'none'});	
}

function cancelAjaxRequest() {
	$("#ajax_approval").css({ display: 'none'});	
	$("#ajax_request").css({ display: 'block'});	
}
function showAjaxApproval() {
	$("#ajax_approval").css({ display: 'block'});	
	$("#ajax_request").css({ display: 'none'});	
}


function seemore(total_company) {

	for (var i=1; i<=total_company; i++) {
		if (i > 11) {
			$("#pbox"+i).removeClass("hidden-class");
		}
	}
	$("#more_result").hide();
	$("#less_result").show();
}

function seeless(total_company) {

	for (var i=1; i<=total_company; i++) {
		if (i > 11) {
			$("#pbox"+i).addClass("hidden-class");
		}
	}
	$("#less_result").hide();
	$("#more_result").show();
}


function seemoreGroup(total_group) {

	for (var i=1; i<=total_group; i++) {
		if (i > 11) {
			$("#groupbox"+i).removeClass("hidden-class");
		}
	}
	$("#more_group").hide();
	$("#less_group").show();
}

function seelessGroup(total_group) {

	for (var i=1; i<=total_group; i++) {
		if (i > 11) {
			$("#groupbox"+i).addClass("hidden-class");
		}
	}
	$("#less_group").hide();
	$("#more_group").show();
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

function showhide(divid, state){
document.getElementById(divid).style.display=state
}

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
function showProfiles(id,user_id) {
	$.ajax({
	url     : baseUrl+"/users_profiles/recommended_profiles",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,id:id},
	success : function(data){	
	//$(this).css('background','none');
	$("#resultsDiv_"+id).html(data);
	},
	error : function(data) {
	$("#resultsDiv_"+id).html(data);
	}
	});
}

function closeMessageForm(id) {
document.getElementById('fade').style.display = 'none';
document.getElementById('userSendForm_'+id).style.display = 'none';
}
function inviteUserChat() {
var userid = document.getElementById('user_id').value;
var recommends = document.getElementById('friend_id').value;

var status = document.getElementById('status').value;
$.ajax({
              url     : baseUrl+"/users_profiles/recommend_skill",
              type    : "POST",
              cache   : false,
              data    : {userid: userid,recommends:recommends,skill:skill,status:status,recommendation:recommendation},
              success : function(data){
			  $("#spanid_"+skillID).html(data);
			  $("#recommend"+skillID).css('display','none');
			  $("#recommended"+skillID).css('display','none');
              },
			  error : function(data) {
           $("#span_"+skillID).html("there is error");
        }
          });
}
function recommendSkill(skillID,recommendation) {
var userid = document.getElementById('friend_user_id').value;
var recommends = document.getElementById('recommends').value;
var skill = document.getElementById('skill_id_'+skillID).value;
var status = document.getElementById('status').value;
var start_date = document.getElementById('start_date').value;
var end_date = document.getElementById('end_date').value;

$.ajax({
              url     : baseUrl+"/users_profiles/recommend_skill",
              type    : "POST",
              cache   : false,
              data    : {userid: userid,recommends:recommends,skill:skill,status:status,recommendation:recommendation,end_date:end_date,start_date:start_date},
              success : function(data){
				  responseArray = data.split("::::");
			  $("#skill_counter_"+skillID).html(responseArray[0]);
			  $("#count_people_"+skillID).html(responseArray[0]);
			  $("#spanid_"+skillID).html(responseArray[1]);
			  $("#recommend"+skillID).css('display','none');
			  $("#recommended"+skillID).css('display','none');
              },
			  error : function(data) {
           $("#span_"+skillID).html("there is error");
        }
          });
}
function removeSkill(skillID,recommendation,recommend_id) {
var userid = document.getElementById('friend_user_id').value;
var recommends = document.getElementById('recommends').value;
var skill = document.getElementById('skill_id_'+skillID).value;
var status = document.getElementById('status').value;
var start_date = document.getElementById('start_date').value;
var end_date = document.getElementById('end_date').value;
//alert(start_date+"and"+end_date);

$.ajax({
              url     : baseUrl+"/users_profiles/recommend_skill",
              type    : "POST",
              cache   : false,
              data    : {userid: userid,recommends:recommends,skill:skill,status:status,recommendation:recommendation,recommend_id:recommend_id,end_date:end_date,start_date:start_date},
              success : function(data){
			$("#recommend"+skillID).css('display','none');
			  $("#recommended"+skillID).css('display','none');
			  //$("#spanid_"+skillID).html(data);
			  responseArray = data.split("::::");
			  $("#skill_counter_"+skillID).html(responseArray[0]);
			  $("#count_people_"+skillID).html(responseArray[0]);
			  $("#spanid_"+skillID).html(responseArray[1]);
              },
			  error : function(data) {
           $("#spanid_"+skillID).html("there is error");
        }
          });
}

function userFollow(status,id) {
		
	var user_id = document.getElementById('u_id').value;
	var following_type = document.getElementById('content_type').value;
	var following_id = document.getElementById('following_id').value;
	var start_date = document.getElementById('start_date').value;
	var end_date = document.getElementById('end_date').value;
	//alert(following_id+"and"+start_date+"and"+user_id+"and"+following_type);
	$.ajax({
	url     : baseUrl+"/comments/add_follow",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,following_type:following_type,start_date:start_date,following_id:following_id,end_date:end_date,status:status,id:id},
	success : function(data){	
	responseArrays = data.split("-");
	//alert(responseArrays);
	$("#resultantDiv").html(responseArrays[0]);
	$("#user_following_btn").html(responseArrays[1]);
	},
	error : function(data) {
	$("#resultantDiv").html("error");
	}
	});
}
function show_recommendations() {
	$("#recommend_form").slideToggle('slow');
}
function add_recommendation(user_id,friend_id) {
	$("#recommend_btn").slideUp('slow');
	var recommended_text = document.getElementById('recommended_text').value;
	var created = document.getElementById('created_date').value;
	var modified = document.getElementById('modified_date').value;
	//alert(user_id+"and"+friend_id+"and"+recommended_text+"and"+created);
	$('#loading').show();
	$.ajax({
	url     : baseUrl+"/users_profiles/add_recommendation_text",
	type    : "POST",
	cache   : false,
	data    : {user_id: user_id,friend_id:friend_id,created:created,modified:modified,recommended_text:recommended_text},
	success : function(data){	
	$("#users_recommended_text_for_user").html(data);
	$("#profile_box_id").slideUp('slow');
	document.getElementById('recommended_text').value = '';
	},
     complete: function () {
                    $('#loading').hide();
                },
	error : function(data) {
	$("#users_recommended_text_for_user").html(data);
	}
	});
}


function show_recommendation(id,type) {
	$("#users_recommended_text_for_user").html('<img src="http://media.networkwe.com/img/loading.gif" style="text-align:center; margin-left:360px;" />');
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
	$("#users_recommended_text_for_user").html(data);
	},
	error : function(data) {
	$("#users_recommended_text_for_user").html("error");
	}
	});
}


function loadPopup(ID,user_id) {
//if(popupStatus == 0) { // if value is 0, show popup
//closeloading(); // fadeout loading
$("#profile_popup_ajax"+ID).fadeIn(0500); // fadein popup div
$("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
$("#backgroundPopup").fadeIn(0001);
//popupStatus = 1; // and set value to 1
$.ajax({
	url     : baseUrl+"/users_profiles/recommended_profiles",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,id:ID},
	success : function(data){	
	//$(this).css('background','none');
	$("#popupContent_"+ID).html(data);
	},
	error : function(data) {
	$("#popupContent_"+ID).html(data);
	}
	});

//}
}

function disablePopup(ID) {
//if(popupStatus == 1) { // if value is 1, close popup
$("#profile_popup_ajax"+ID).fadeOut("normal");
$("#backgroundPopup").fadeOut("normal");
//popupStatus = 0; // and set value to 0
//}
}
/************** end: functions. **************/

function sharedConnection(user_id,friend_id,type) {
	$('#loadings').show();
	$.ajax({
	url     : baseUrl+"/connections/shared_connections",
	type    : "GET",
	cache   : false,
	data    : {user_id: user_id,friend_id:friend_id,type:type},
	success : function(data){	
	$("#users_shared_connection").html(data);
	},
     complete: function () {
       $('#loadings').hide();
                },
	error : function(data) {
	$("#users_shared_connection").html(data);
	}
	});
}

function showMessageForm() {
document.getElementById('fade').style.display = 'block';
document.getElementById('userSendForm').style.display = 'block';
}
function hideMessageForm() {
document.getElementById('fade').style.display = 'none';
document.getElementById('userSendForm').style.display = 'none';
}
function unfollow(result_id,following_id,user_id,status,company_id) {
	
	$.ajax({
	url     : baseUrl+"/users_profiles/companies_follow",
	type    : "POST",
	cache   : false,
	data    : {following_id:following_id,status:status,user_id:user_id,company_id:company_id,result_id:result_id},
	success : function(data){	
	//$(this).css('background','none');
	$("#company_follow_by_user"+result_id).html(data);
	},
	error : function(data) {
	$("#company_follow_by_user"+result_id).html(data);
	}
	});
	
}
function showUnfollow(following_id) {
$("#follow_comp"+following_id).html("Unfollow");
}
function hideUnfollow(following_id) {
$("#follow_comp"+following_id).html("Following");
}
jQuery(function($) {
$("div#backgroundPopup").click(function() {
disablePopup(); // function close pop up
});
});

function showStarSign(star_id,user_id,star_type) {
	$.ajax({
	url     : baseUrl+"/users_profiles/user_star",
	type    : "GET",
	cache   : false,
	data    : {star_id: star_id,user_id:user_id,star_type:star_type},
	success : function(data){	
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
document.getElementById('fade').style.display = 'none';
document.getElementById('user_sign').style.display = 'none';
}

function call_Connection() {
	document.getElementById("userConnection").submit();
}
function chat_Connection() {
	document.getElementById("chat_connect").submit();
}


function add_ajax_user(user_id,friend_id){
	$("#connectUser_"+friend_id).html('<img src="http://media.networkwe.com/img/loading.gif" style="float:left;" />');
	var request_from = 'usersprofile';
	var connection_type = '';
	if (document.getElementById('friend').checked) {
  		connection_type = document.getElementById('friend').value;
	}
	else if (document.getElementById('professional').checked) {
		connection_type = document.getElementById('professional').value;
	}
	else if (document.getElementById('both').checked) {
		connection_type = document.getElementById('both').value;
	}
	if (connection_type == '') {
		connection_type = 'Friend';
	}
		$.ajax({
		url     : baseUrl+"/connections/add_connect_ajax",
		type    : "POST",
		cache   : false,
		data    : {user_id: user_id,friend_id:friend_id,connection_type:connection_type,request_from:request_from},
		success : function(data){
		$("#connectUser_"+friend_id).hide();
		$("#connect_user").hide();
		$("#approval_pending_ajax").show();
		$("#approval_pending_ajax").html(data);
		
		},
		complete: function() {
		//$("#request_loader").hide();
		},
		error : function(data) {
		$("#connectUser_"+friend_id).html(data);
		}
		});

}

function remove_contact(contact_id,contact_type,action_from) {
	$("#approval_pending_ajax").html('<img src="http://media.networkwe.com/img/loading.gif" style="float:left;" />');
  			$.ajax({
					url     : baseUrl+"/connections/remove_contact",
					type    : "GET",
					cache   : false,
					data    : {contact_id: contact_id,contact_type:contact_type},
					success : function(data){
						if (action_from == 'remove_connection') {
						$("#message_remove_connection").slideDown('slow').delay(800).fadeOut();
						}
						else {
						$("#message_remove_request").slideDown('slow').delay(800).fadeOut();	
						}
						$("#"+action_from).slideUp('slow');
						$("#approval_pending_ajax").hide();
						$("#connect_user").slideDown('slow');
						$(".modal-backdrop").hide();
					},
					complete: function() {
					$("#"+action_from).css({ opacity: 0.6 });		
					},
					error : function(data) {
					$("#"+action_from).html(data);
					}
			});
}

function scrollToElement(selector, time, verticalOffset) {
    time = typeof(time) != 'undefined' ? time : 1000;
    verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
    element = $(selector);
    offset = element.offset();
    offsetTop = offset.top + verticalOffset;
    $('html, body').animate({
        scrollTop: offsetTop
    }, time);
}
$(document).ready(function () {
	$('#go_recommendation').click(function () {
    scrollToElement("#users_recommended_text_for_user",500,-200);
	//$("#users_recommended_text_for_user").animate({ scrollTop: $("#users_recommended_text_for_user").attr("scrollHeight") - $('#users_recommended_text_for_user').height() }, 3000);
	});
});