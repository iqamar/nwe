   	
$(function() {
var $tabs = $('#tabs').tabs();
$(".ui-tabs-panel").each(function(i) {
	var totalSize = $(".ui-tabs-panel").size() - 1;
	 if (i != totalSize) {
		next = i + 2;
		if (next == 2) {
			//msg_sent();
		}
		else if (next == 4) {
			$(this).append("<a href='#' onclick='saveSummary(" + next + ")' class='next-tab mover' rel='" + next + "' id='" + next + "'>Save & Next &#187;</a>");
		}
		else {
			$(this).append("<a href='#' onclick='saveProfile(" + next + ")' class='next-tab mover' rel='" + next + "' id='" + next + "'>Next &#187;</a>");
			$('html,body').animate({scrollTop: 0}, 1000);
		}
	}
	
});

});
  
$(document).ready(function() {
	if (typeof easyResponsiveTabs !== 'undefined' && $.isFunction(easyResponsiveTabs)) {
		$('#horizontalTab').easyResponsiveTabs({
			type: 'default', //Types: default, vertical, accordion
			width: 'auto', //auto or any width like 600px
			fit: true, // 100% fit in a container
			closed: 'accordion', // Start closed if in accordion view
			activate: function(event) { // Callback function if tab is switched
				var $tab = $(this);
				var $info = $('#tabInfo');
				var $name = $('span', $info);
				alert($tab);
				$name.text($tab.text());

				$info.show();
			}
		});

		$('#verticalTab').easyResponsiveTabs({
			type: 'vertical',
			width: 'auto',
			fit: true
		});
	}
	
	msg_inbox();
	
	$("#success_mesg_hide").slideDown('slow').delay(2000).fadeOut();
});
function unreadCount(){
	var page = 1;
		
        $.ajax({
              url     : '/messages/unreadCount',
              type    : 'POST',

			cache: false,
              data    : {page:page},
              success : function(data){

				 $("#unreadCount").html(data);
				 $("#unreadCountHeader").html(data);
				 
              },
			 error : function(data) {
			   $("#unreadCount").html("error");
			}
          });
    
     return false; 

}
function msg_inbox(){

		var page = 1;
		
		$("#fragment-1").html("<div id='content' style='min-height:400px;'><img src='http://media.networkwe.com/img/loading.gif' alt='Searching' /></div>");
        $.ajax({
              url     : '/messages/index',
              type    : 'POST',

			cache: false,
              data    : {page:page},
              success : function(data){
				unreadCount();
				 $("#fragment-1").html(data);
				 
              },
			 error : function(data) {
			   $("#fragment-1").html("there is error");
			}
          });
    
     return false; 
}
function msg_sent(){

		var page = 1;
		
		$("#fragment-1").html("<div id='content' style='min-height:400px;'><img src='http://media.networkwe.com/img/loading.gif' alt='Searching' /></div>");
        $.ajax({
              url     : '/messages/sent',
              type    : 'POST',

			cache: false,
              data    : {page:page},
              success : function(data){
				
				 $("#fragment-1").html(data);
				 
              },
			 error : function(data) {
			   $("#fragment-1").html("there is error");
			}
          });
    
     return false; 
}
function trashed_list(){

		var page = 1;
		
		$("#fragment-1").html("<div id='content' style='min-height:400px;'><img src='http://media.networkwe.com/img/loading.gif' alt='Searching' /></div>");
        $.ajax({
              url     : NETWORKWE_URL + '/messages/trashed_list',
              type    : 'POST',

			cache: false,
              data    : {page:page},
              success : function(data){
				
				 $("#fragment-1").html(data);
				 
              },
			 error : function(data) {
			   $("#fragment-1").html("there is error");
			}
          });
    
     return false; 
}
function msg_view(e,cat){
		msg_id = e.getAttribute("value");
		var cat=cat;
		$("#fragment-1").html("<div id='content' style='min-height:400px;'><img src='http://media.networkwe.com/img/loading.gif' alt='Searching' /></div>");
        $.ajax({
              url     : '/messages/view',
              type    : 'POST',

			cache: false,
              data    : {msg_id:msg_id,cat:cat},
              success : function(data){
				unreadCount();
				 $("#fragment-1").html(data);
				 
              },
			 error : function(data) {
			   $("#fragment-1").html("there is error");
			}
          });
    
     return false; 
}
function trash_view(e,cat){
		msg_id = e.getAttribute("value");
		var cat=cat;
		$("#fragment-1").html("<div id='content' style='min-height:400px;'><img src='http://media.networkwe.com/img/loading.gif' alt='Searching' /></div>");
        $.ajax({
              url     : '/messages/trash_view',
              type    : 'POST',

			cache: false,
              data    : {msg_id:msg_id,cat:cat},
              success : function(data){
				$("#fragment-1").html(data);
				 
				 
              },
			 error : function(data) {
			   $("#fragment-1").html("there is error");
			}
          });
    
     return false; 
}
function msg_compose(){
	$("#fragment-1").html("<div id='content' style='min-height:400px;'><img src='http://media.networkwe.com/img/loading.gif' alt='Searching' /></div>");
        $.ajax({
              url     : '/messages/compose',
              type    : 'POST',

			cache: false,
              data    : {},
              success : function(data){
				
				 $("#fragment-1").html(data);
				 
              },
			 error : function(data) {
			   $("#fragment-1").html("there is error");
			}
          });
    
     return false; 
}
$(document).ready(function()
{
    $('#compose').on('submit', function(e)
    {
        e.preventDefault();
        
        $(this).ajaxSubmit({
        success: function(data){

		},
		complete: function() {
			
		}
        });
    });
	
	$("#keyword").keyup(function(e){
          if (e.keyCode === 13) {
             searchMail();
          }
     }); 
	
});
function msg_send(){
		
		var from_email = document.getElementById("from_email").value;
		var from_id = document.getElementById("from_id").value;
		var to_email = document.getElementsByName("ms4").value;
		//var to_email =document.forms[0].ms4.value;
		
		var subject = document.getElementById("subject").value;
		var fw= $("#fw_content");
		var fww = $('#fw_fw_content');
		//alert(fw.val());
		if((fw.val()!='') || (fww.val()!='')){
			var message = document.getElementById("messaged").value + fw.val() + fww.val();
		}else{
			var message = document.getElementById("messaged").value;
		}
		//var cat=cat;
		$("#fragment-1").html("<div id='content' style='min-height:400px;'><img src='http://media.networkwe.com/img/loading.gif' alt='Searching' /></div>");
        $.ajax({
              url     : '/messages/send',
              type    : 'POST',

			cache: false,
              data    : {from_email:from_email,from_id:from_id,to_email:to_email,message:message,subject:subject},
              success : function(data){
				
				 $("#fragment-1").html(data);
				 
              },
			 error : function(data) {
			   $("#fragment-1").html("there is error");
			}
          });
    
     return false; 
}
function msg_reply(e,cat){
		var cat=cat;
		msg_id = e.getAttribute("value");
		//var cat=cat;
		$("#fragment-1").html("<div id='content' style='min-height:400px;'><img src='http://media.networkwe.com/img/loading.gif' alt='Searching' /></div>");
        $.ajax({
              url     : '/messages/reply',
              type    : 'POST',

			cache: false,
              data    : {msg_id:msg_id,cat:cat},
              success : function(data){
				unreadCount();
				 $("#fragment-1").html(data);
				 
              },
			 error : function(data) {
			   $("#fragment-1").html("there is error");
			}
          });
    
     return false; 
}
function searchMail(){
	var keyword = document.getElementById("keyword").value;
	
	$("#fragment-1").html("<div id='content' style='min-height:400px;'><img src='http://media.networkwe.com/img/loading.gif' alt='Searching' /></div>");
        $.ajax({
              url     : '/messages/searchMail',
              type    : 'POST',

			cache: false,
              data    : {keyword:keyword},
              success : function(data){
				
				 $("#fragment-1").html(data);
				 
              },
			 error : function(data) {
			   $("#fragment-1").html("there is error");
			}
          });
    
     return false; 
	
}


function msg_reply_to(){

		var to_email = document.getElementById("to_email").value;
		var from_email = document.getElementById("from_email").value;
		var To_name = document.getElementById("To_name").value;
		var from_id = document.getElementById("from_id").value;
		var to_id = document.getElementById("to_id").value;
		var msg_id = document.getElementById("msg_id").value;
		var subject = document.getElementById("subject").value;
		var message = document.getElementById("messaged").value;
		$("#fragment-1").html("<div id='content' style='min-height:400px;'><img src='http://media.networkwe.com/img/loading.gif' alt='Searching' /></div>");
        $.ajax({
              url     : '/messages/replyTo',
              type    : 'POST',

			cache: false,
              data    : {to_email:to_email,from_email:from_email,To_name:To_name,from_id:from_id,to_id:to_id,msg_id:msg_id,message:message,subject:subject},
              success : function(data){
				
				 $("#fragment-1").html(data);
				 
              },
			 error : function(data) {
			   $("#fragment-1").html("there is error");
			}
          });
    
     return false; 
}
function msg_trash(e,cat){
	msg_id = e.getAttribute("value");
	var cat=cat;
	
	var chkArray = [];
    $(".delcheckbox:checked").each(function() {
        chkArray.push($(this).val());
    });
     
    var selected;
    selected = chkArray.join(',') + ","+msg_id;
	
    if(chkArray.length < 1 && msg_id < 1){
       alert("Please at least one of the checkbox");  
    }else{
		//alert(selected);
		$("#fragment-1").html("<div id='content' style='min-height:400px;'><img src='http://media.networkwe.com/img/loading.gif' alt='Searching' /></div>");
        $.ajax({
              url     : '/messages/msgtrash',
              type    : 'POST',

			cache: false,
              data    : {delcheckbox:selected,cat:cat},
              success : function(data){
				unreadCount();
				if(cat=='sent'){
					msg_sent();
				}else if(cat=='inbox'){
				 $("#fragment-1").html(data);
				}else if(cat=='trashList'){
					searchMail();
				}
				else{
					trashed_list();
				}
              },
			 error : function(data) {
			   $("#fragment-1").html("there is error");
			}
          });
    }
	return false; 
}
function undelete(e,cat){
	msg_id = e.getAttribute("value");
	var cat=cat;
	
	var chkArray = [];
    $(".delcheckbox:checked").each(function() {
        chkArray.push($(this).val());
    });
     
    var selected;
    selected = chkArray.join(',') + ","+msg_id;
	
   if(chkArray.length < 1 && msg_id < 1){
       alert("Please at least one of the checkbox");  
    }else{
		//alert(selected);
		$("#fragment-1").html("<div id='content' style='min-height:400px;'><img src='http://media.networkwe.com/img/loading.gif' alt='Searching' /></div>");
        $.ajax({
              url     : '/messages/undelete',
              type    : 'POST',

			cache: false,
              data    : {delcheckbox:selected,cat:cat},
              success : function(data){
				unreadCount();
				trashed_list();
              },
			 error : function(data) {
			   $("#fragment-1").html("there is error");
			}
          });
    }
	return false; 
}
function permdelete(e,cat){
	msg_id = e.getAttribute("value");
	var cat=cat;
	
	var chkArray = [];
    $(".delcheckbox:checked").each(function() {
        chkArray.push($(this).val());
    });
     
    var selected;
    selected = chkArray.join(',') + ","+msg_id;
	
    if(chkArray.length < 1 && msg_id < 1){
       alert("Please at least one of the checkbox");  
    }else{
		//alert(selected);
		$("#fragment-1").html("<div id='content' style='min-height:400px;'><img src='http://media.networkwe.com/img/loading.gif' alt='Searching' /></div>");
        $.ajax({
              url     : '/messages/permdelete',
              type    : 'POST',

			cache: false,
              data    : {delcheckbox:selected,cat:cat},
              success : function(data){
			  unreadCount();
				trashed_list();
              },
			 error : function(data) {
			   $("#fragment-1").html("there is error");
			}
          });
    }
	return false; 
}
function msg_forward(e,cat){
		var cat=cat;
		msg_id = e.getAttribute("value");
		//var cat=cat;
		$("#fragment-1").html("<div id='content' style='min-height:400px;'><img src='http://media.networkwe.com/img/loading.gif' alt='Searching' /></div>");
        $.ajax({
              url     : '/messages/forward',
              type    : 'POST',

			cache: false,
              data    : {msg_id:msg_id,cat:cat},
              success : function(data){
				unreadCount();
				 $("#fragment-1").html(data);
				 
              },
			 error : function(data) {
			   $("#fragment-1").html("there is error");
			}
          });
    
     return false; 
}
