(function(b,c){var $=b.jQuery||b.Cowboy||(b.Cowboy={}),a;$.throttle=a=function(e,f,j,i){var h,d=0;if(typeof f!=="boolean"){i=j;j=f;f=c}function g(){var o=this,m=+new Date()-d,n=arguments;function l(){d=+new Date();j.apply(o,n)}function k(){h=c}if(i&&!h){l()}h&&clearTimeout(h);if(i===c&&m>e){l()}else{if(f!==true){h=setTimeout(i?k:l,i===c?e-m:e)}}}if($.guid){g.guid=j.guid=j.guid||$.guid++}return g};$.debounce=function(d,e,f){return f===c?a(d,e,false):a(d,f,e!==false)}})(this);

/*! Keynavigator v.2.1.3 - build 2013-10-14T22:24:49 */
!function(a,b){"object"==typeof exports?module.exports=b(require("jquery")):"function"==typeof a.define&&a.define.amd?define(["jquery"],b):b(a.jQuery||a.Zepto)}(this,function(a){var b={createFrom:function(a){var b=a.position();return{pos:{left:Math.round(b.left),top:Math.round(b.top)},$el:a}}},c=function(a){this.table=this.buildTable(a),this.rows=this.buildRows(),this.columns=this.buildColumns()};c.prototype={buildTable:function(c){return c.map(function(){return b.createFrom(a(this))})},buildColumns:function(){var b={},c=this;return a.each(this.table,function(a,d){b[d.pos.left]=c.getColumnElements(d)}),b},buildRows:function(){var b={},c=this;return a.each(this.table,function(a,d){b[d.pos.top]=c.getRowElements(d)}),b},getRowElements:function(b){var c=this;return a.map(this.table,function(a){return c.isSameRow(a,b)?a:null})},getColumnElements:function(b){var c=this;return a.map(this.table,function(a){return c.isSameColumn(a,b)?a:null})},getCurrent:function(a){var c=b.createFrom(a);return this.findPosition(this.getCell(c))},isSameColumn:function(a,b){if(!b)throw"cell";return a.pos.left===b.pos.left},isSameRow:function(a,b){return a.pos.top===b.pos.top},isSame:function(a,b){return this.isSameColumn(a,b)&&this.isSameRow(a,b)},getCell:function(b){var c=this;return a.map(this.table,function(a){return c.isSame(b,a)?a:null})[0]},findIndex:function(a,b){for(var c=0,d=a.length;d>c;c++)if(b(a[c]))return c;return c},findPosition:function(a){var b=this.getColumnElements(a),c=this.getRowElements(a),d=this.findIndex(b,function(b){return b.pos.top==a.pos.top}),e=this.findIndex(c,function(b){return b.pos.left==a.pos.left});return{colIndex:e,rowIndex:d}}};var d={0:"?",8:"backspace",9:"tab",13:"enter",16:"shift",17:"ctrl",18:"alt",19:"pause_break",20:"caps_lock",27:"escape",33:"page_up",34:"page_down",35:"end",36:"home",37:"left_arrow",38:"up_arrow",39:"right_arrow",40:"down_arrow",45:"insert",46:"delete",48:"0",49:"1",50:"2",51:"3",52:"4",53:"5",54:"6",55:"7",56:"8",57:"9",65:"a",66:"b",67:"c",68:"d",69:"e",70:"f",71:"g",72:"h",73:"i",74:"j",75:"k",76:"l",77:"m",78:"n",79:"o",80:"p",81:"q",82:"r",83:"s",84:"t",85:"u",86:"v",87:"w",88:"x",89:"y",90:"z",91:"left_window_key",92:"right_window_key",93:"select_key",96:"numpad_0",97:"numpad_1",98:"numpad_2",99:"numpad_3",100:"numpad 4",101:"numpad_5",102:"numpad_6",103:"numpad_7",104:"numpad_8",105:"numpad_9",106:"multiply",107:"add",109:"subtract",110:"decimal point",111:"divide",112:"f1",113:"f2",114:"f3",115:"f4",116:"f5",117:"f6",118:"f7",119:"f8",120:"f9",121:"f10",122:"f11",123:"f12",144:"num_lock",145:"scroll_lock",186:";",187:"=",188:",",189:"dash",190:".",191:"/",192:"grave_accent",219:"open_bracket",220:"\\",221:"close_braket",222:"single_quote"},e=function(b,c){var d=c||{};this.options=a.extend({},this.defaults,d),this.options.keys=a.extend({},this.defaults.keys,d.keys),this.$nodes=b,this.$parent=this.options.parent?a(this.options.parent):b.parent(),this.options.removeOutline&&this.$parent.css({outline:"none"}),this.$parent.attr("tabindex")||this.$parent.attr({tabindex:this.options.tabindex||-1})};return e.keys=d,e.prototype={defaults:{useCache:!0,cycle:!0,activateOn:"click",parentFocusOn:"click",activeClass:"active",removeOutline:!0,keys:{up_arrow:"up",down_arrow:"down",left_arrow:"left",right_arrow:"right"},onBeforeActive:a.noop,onAfterActive:a.noop},move:function(a){var b=a.cells[a.cellPosition],c=b[a.index];!c&&this.options.cycle&&(c=b[a.firstIndex?0:b.length-1]),c&&this.setActive(c.$el)},down:function(a,c){a.trigger("down",[a]);var d=this.cellTable.columns;this.move({cellPosition:b.createFrom(a).pos.left,index:c.rowIndex+1,cells:d,firstIndex:!0})},up:function(a,c){a.trigger("up",[a]);var d=this.cellTable.columns;this.move({cellPosition:b.createFrom(a).pos.left,index:c.rowIndex-1,cells:d})},left:function(a,c){a.trigger("left",[a]);var d=this.cellTable.rows;this.move({cellPosition:b.createFrom(a).pos.top,index:c.colIndex-1,cells:d})},right:function(a,c){a.trigger("right",[a]);var d=this.cellTable.rows;this.move({cellPosition:b.createFrom(a).pos.top,index:c.colIndex+1,cells:d,firstIndex:!0})},findCell:function(a){try{return this.cellTable.getCurrent(a)}catch(b){}return this.reBuild(),this.cellTable.getCurrent(a)},handleKeyDown:function(a){var b=this.options.keys[e.keys[a.which]]||this.options.keys[a.which];if(b){a.preventDefault?a.preventDefault():a.returnValue=!1,this.cellTable&&this.options.useCache||this.reBuild();var c=this.$parent.find("."+this.options.activeClass);if(c.length||(c=this.$nodes.first()),c.length){var d=this.findCell(c),f=this[b];return f?f.apply(this,[c,d,a]):(b.apply(this,[c,d,a]),void 0)}}},onBeforeActive:function(a){return this.options.onBeforeActive.apply(this,[a])},onAfterActive:function(a){return this.options.onAfterActive.apply(this,[a])},setActive:function(a){var b=this.onBeforeActive(a);b!==!1&&(this.$nodes.removeClass(this.options.activeClass),a.addClass(this.options.activeClass)),this.onAfterActive(a)},reBuild:function(){var b=this.$parent,d=this;this.options.useCache||(this.$nodes=a(this.$nodes.selector)),b.off("keydown").off(this.options.parentFocusOn).on("keydown",a.proxy(this.handleKeyDown,this)).on(this.options.parentFocusOn,function(){b.focus()});var e=this.$nodes.filter(function(){return!a(this).attr("keynavigator-watched")});e.attr("keynavigator-watched",!0).on(this.options.activateOn,function(){d.setActive(a(this))}),this.cellTable=new c(this.$nodes)}},a.fn.keynavigator=function(b){var c,d=new e(this,b);return a(window).on("resize",function(){clearTimeout(c),c=setTimeout(function(){d.reBuild()},200)}),d.reBuild(),a.extend(this,{keynavigator:d})},a});

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
    
    $("#globalsearchform").submit(function(e) {
        return false;
    });
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
            timeout: 10000,
            success: function(html){
                if(searchbox.length >= 3){
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
        dataType: "html", type: "POST",
        url: NETWORKWE_URL + "/Globalsearch/index/",
        data: data_save,
        timeout: 15000,
        tryCount : 0,
        retryLimit : 3,
        success: function(data) {
            ajaxProcess = false;
            $("#search_container").html(data);
        },
        error: function(xhr, textStatus, errorThrown) {
            if(textStatus === "timeout") {
                var sec = 10;
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    setInterval(function() {
                        sec = sec -1;
                        $("#search_container").html("Request Timedout. Retry in "+ sec +"seconds.");
                    }, 3000);
                    //try again
                    setTimeout(function() {
                        $.ajax(this);
                        return;
                    }, 3000);
                }
            }
            if (xhr.status === 500) {
                //handle error
            } else {
                //handle error
            }
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

function user_Action(action, connect_id,user_id) {
    $.ajax({
        url: baseUrl + "/headers/decline",
        type: "POST",
        cache: false,
        data: {action: action, connect_id: connect_id,user_id:user_id},
        success: function(data) {
            //$("#req_"+connect_id).html(data);
            if (action == -1) {
				$("#req_" + connect_id).hide('slow');
				$("#response_" + connect_id).hide('slow');
                $("#notification-bttns" + connect_id).hide('slow');
				$("#notification_request").html(((parseInt($("#notification_request").html())-1) == 0) ? '' :parseInt($("#notification_request").html())-1);
            }
            else if(action == 1) {
                $("#response_" + connect_id).hide('slow');
                $("#notification-bttns" + connect_id).hide('slow');
                $("#accept_" + connect_id).show('slow');
                $("#notification_request").html(((parseInt($("#notification_request").html())-1) == 0) ? '' :parseInt($("#notification_request").html())-1);
            }
            else if(action == -2) {
                $("#req_" + connect_id).hide('slow');
				$("#notification_request").html(((parseInt($("#notification_request").html())-1) == 0) ? '' :parseInt($("#notification_request").html())-1);
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