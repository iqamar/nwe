(function(b,c){var $=b.jQuery||b.Cowboy||(b.Cowboy={}),a;$.throttle=a=function(e,f,j,i){var h,d=0;if(typeof f!=="boolean"){i=j;j=f;f=c}function g(){var o=this,m=+new Date()-d,n=arguments;function l(){d=+new Date();j.apply(o,n)}function k(){h=c}if(i&&!h){l()}h&&clearTimeout(h);if(i===c&&m>e){l()}else{if(f!==true){h=setTimeout(i?k:l,i===c?e-m:e)}}}if($.guid){g.guid=j.guid=j.guid||$.guid++}return g};$.debounce=function(d,e,f){return f===c?a(d,e,false):a(d,f,e!==false)}})(this);

$(document).ready(function(){
    $('.default').dropkick();

    $('body').on('click',function(event) {
        if($(event.target).parents('#display').length === 0 ) {
            $('#display').hide();
        }
    });
    
    $("#search_str").keyup( $.debounce( 900, function(e){
        auto_suggest(e);
        return false;
    }));
        
    $("#SearchScope").change( $.debounce( 200, function(e){
        auto_suggest(e);
        return false;
    }));
});
    
function auto_suggest(e){
    var key = e.keyCode;
    if (e.which === 13) {
        e.preventDefault();
        hide_auto_suggest();
        $("#globalsearchform #submit-button").click();
        return false;
    } else if (e.which === 40) {
        return false;
    } else if (e.which === 38) {
        return false;
    }
    
    var searchbox = $("#search_str").val();
    if(searchbox.length < 1){
        hide_auto_suggest();
    }
    var dataString = 'query:' + searchbox + '/scope:' + $("#SearchScope").val();
    if (searchbox !== '' && searchbox.length >= 3){

        $.ajaxSetup({
            beforeSend: function() {
                $("#search_str").css("background", "#fff url(" + media + "/img/loading.gif) no-repeat center right");
            }
        });            
        $.ajax({
            type: "GET",
            url: NETWORKWE_URL + "/Globalsearch/auto_suggest/" + dataString,
            cache: false,
            timeout: 3500,
            success: function(html){
                if(searchbox.length >= 1){
                    $("#display").html(html).show();
                }
                $("#search_str").css("background", "#fff");
            },
            error: function(x, t, m) {
                if(t==="timeout") {
                    $("#search_str").css("background", "#fff");
                    /*if ($('#msg').length < 1)
                        $('#display').before('<div id="msg"></div>');
                    $("#msg").removeClass("success_msg").addClass("error_msg").slideDown('slow').delay(1000).fadeOut().html('Server is a bit busy now, Sorry :P');*/
                }
            }
        });
    }
    /*else if (key === 40){
        $('#display ul a.current').parent().next().find('a').click();
    }*/
}
    
function hide_auto_suggest(){
    if($('#display').is(':visible'))
        $('#display').hide();
}

var ajaxProcess = false;
/*$("#globalsearchform #search_str").keypress(function(e) {
    if (e.which == 13) {
        e.preventDefault();
        hide_auto_suggest();
        $("#globalsearchform #submit-button").click();
    }
});*/
$("#globalsearchform").submit(function(e) {
    return false;
});

function get_Search(formid) {
    if (ajaxProcess)
        return false;
    ajaxProcess = true;
    var data_save = $("#" + formid).serializeArray();
    data_save.push({name: "SearchScope", value: $("#SearchScope").val()});
    $.ajaxSetup({
        beforeSend: function() {
            hide_auto_suggest();
            $("#search_container").html("<img src='" + media + "/img/loading.gif'>");
        }
    });
    $.ajax({
        dataType: "html", type: "POST", evalScripts: true,
        url: NETWORKWE_URL + "/Globalsearch/index/",
        data: data_save,
        success: function(data) {
            ajaxProcess = false;
            $("#search_container").html(data);
        }
    });
}

function connect_user(id) {
    if (ajaxProcess)
        return false;
    ajaxProcess = true;
    var data_save = $("#" + formid).serializeArray();
    var formid = "#form-" + id;
    data_save.push({name: "friend_id", value: id});
    data_save.push({name: "action", value: 0});
    if($(formid + ' input:radio[name=connection_type]').length > 0)
        data_save.push({name: "connection_type", value: $(formid + " input:radio[name=connection_type]:checked").val()});
    $.ajaxSetup({
        beforeSend: function() {
            $(formid + " #ajax_response").html("<img src='"+media+"/img/loading.gif' />");
        }
    });
    $.ajax({
        dataType: "html", type: "POST", evalScripts: true,
        url: NETWORKWE_URL+"/Globalsearch/add_connection_ajax/",
        data: data_save,
        success: function(data) {
            ajaxProcess = false;
            $(formid + " #ajax_response").html(data);
        },
        error: function(data) {
            ajaxProcess = false;
            $(formid + " #ajax_response").html('Error saving data!');
        }
    });
}

$('.dropdown a').click(function(event) {
    var selected_value = this.id;
    var search_value = '';
    if (selected_value == 'All') {
        search_value = 0;
    }
    else if (selected_value == 'People') {
        search_value = 1;
    }
    else if (selected_value == 'Jobs') {
        search_value = 2;
    }
    else if (selected_value == 'Companies') {
        search_value = 3;
    }
    else if (selected_value == 'Groups') {
        search_value = 4;
    }
    document.getElementById('SearchScope').value = search_value;
    $("#selected").html(selected_value);
});

function user_Accept() {
    //document.userConfirm.submit();
    document.getElementById("userConfirm").submit();
}

function user_Action(action, connect_id) {
    $.ajax({
        url: baseUrl + "/headers/decline",
        type: "POST",
        cache: false,
        data: {action: action, connect_id: connect_id},
        success: function(data) {
            //$("#req_"+connect_id).html(data);
            if (action == -1) {
                $("#req_" + connect_id).hide('slow');
            }
            else if(action == 1) {
                $("#response_" + connect_id).hide('slow');
                $("#notification-bttns" + connect_id).hide('slow');
                $("#accept_" + connect_id).show('slow');
                $(".notification-number").html(((parseInt($(".notification-number").html())-1) == 0) ? '' :parseInt($(".notification-number").html())-1);
            }
            else if(action == -2) {
                $("#req_" + connect_id).hide('slow');
            }
        },
        error: function(data) {
            $("#req_" + connect_id).html("there is error in your script.");
        }
    });
}

function chat_Action(action, chat_id) {
    $.ajax({
        url: baseUrl + "/headers/chat_request",
        type: "POST",
        cache: false,
        data: {action: action, chat_id: chat_id},
        success: function(data) {
            //$("#req_"+connect_id).html(data);
            if (action == -1) {
                $("#chat_" + chat_id).hide('slow');
            }
            else {
                $(".notification-number").html(((parseInt($(".notification-number").html())-1) == 0) ? '' :parseInt($(".notification-number").html())-1);
                $("#chat_response_" + chat_id).hide('slow');
                $("#chat_invite_" + chat_id).hide('slow');
                $("#chat_accept_" + chat_id).show('slow');
            }
        },
        error: function(data) {
            $("#chat_" + connect_id).html("there is error in your script.");
        }
    });
}