 $(document).ready(function() {
        $(function() {
            var $tabs = $('#tabs').tabs();
            $(".ui-tabs-panel").each(function(i) {
                var totalSize = $(".ui-tabs-panel").size() - 1;
                if (i != totalSize) {
                    next = i + 2;
                    if (next == 2) {
                        //$(this).append("<a href='#' onclick='saveProfile(" + next + ")' class='next-tab mover' rel='" + next + "' id='" + next + "'>Save & Next &#187;</a>");
                        $('html,body').animate({scrollTop: 0}, 1000);
                    }
                    else if (next == 4) {
                        //$(this).append("<a href='javascript:document.summaryUploader.submit()' class='next-tab mover' rel='" + next + "' id='" + next + "'>Save & Next &#187;</a>");
                    }
                    else {
                        //$(this).append("<a href='#' onclick='saveProfile(" + next + ")' class='next-tab mover' rel='" + next + "' id='" + next + "'>Next &#187;</a>");
                        $('html,body').animate({scrollTop: 0}, 1000);
                    }
                }
            });
            $(".nexttab").click(function() {
                var selected = $("#tabs").tabs("option", "selected");
                $("#tabs").tabs("option", "selected", selected + 1);
            });
            
            $('input[type="radio"]').click(function() {
                if($(this).attr('id') == 'account_close_reason_5') {
                     $('#other-textfield').show();           
                }
                else {
                     $('#other-textfield').hide();   
                }
            });
        });
        
        $('#account_close_reason_6').focus(function() {
            $('#account_close_reason_5').prop('checked', true);
        });
        
    });

    var ajaxProcess = false;
    function save(formid) {
        if (ajaxProcess)
            return false;
        ajaxProcess = true;
        var data;
        $.ajaxSetup({
            beforeSend: function() {
                $("#" + formid + " #submit-button").val('Saving data...');
            },
            complete: function() {
                $("#" + formid + " #submit-button").val('Save');
            }
        });
        $.ajax({
            dataType: "html", type: "POST", evalScripts: true,
            url: NETWORKWE_URL+"/users_profiles/review/",
            data: $("#" + formid).serialize(),
            success: function(data, textStatus) {
                ajaxProcess = false;
            }
        });
    }

    function saveHandler(uid, fieldid, field, formid) {
        if (ajaxProcess)
            return false;
        ajaxProcess = true;
        $.ajaxSetup({
            beforeSend: function() {
                $("#" + formid + " #submit-button").val('Saving data...');
            },
            complete: function() {
                $("#" + formid + " #submit-button").val('Save');
            }
        });
        $.ajax({
            url: NETWORKWE_URL+"/publices/public_profile",
            type: "post",
            dataType: "json",
            cache: false,
            data: $("#" + formid).serialize(),
            success: function(data) {
                ajaxProcess = false;
                if (data.status == 'error') {
                    $("#" + formid + " #reponse-data").hide().html('<label1><div class="' + data.status + '_msg">' + data.message + '</div></lable1>').fadeIn('slow').delay(5000).fadeOut();
                } else if (data.status == 'success') {
                    $("#" + formid + " #reponse-data").hide().html('<label1><a href="' + data.url + '">' + data.url + '</a><div class="' + data.status + '_msg">' + data.message + '</div></div></lable1>').fadeIn('slow');
                    $("#" + formid + " #reponse-data ." + data.status + "_msg").delay(5000).fadeOut();
                } else if (data.status == 'duplicate') {
                    $("#" + formid + " #reponse-data").hide().html('<label1><a href="' + data.url + '">' + data.url + '</a><div class="error_msg">' + data.message + '</div></lable1>').fadeIn('slow');
                    $("#" + formid + " #reponse-data .error_msg").delay(5000).fadeOut();
                }
            },
            error: function(data) {
                ajaxProcess = false;
                $("#" + formid + " #reponse-data").hide().html('<label1><div class="error_msg">' + data.message + '</div></lable1>').fadeIn('slow');
            }
        });
    }

    function savePassword(field, uid, formid) {
        if (ajaxProcess)
            return false;
        ajaxProcess = true;
        $.ajaxSetup({
            beforeSend: function() {
                $("#" + formid + " #submit-button").val('Saving data...');
            },
            complete: function() {
                $("#" + formid + " #submit-button").val('Save');
            }
        });

        $.ajax({
            url: NETWORKWE_URL+"/users_profiles/change_password/",
            type: "POST",
            cache: false,
            data: $("#" + formid).serialize(),
            success: function(data, formid) {
                $("#" + formid + " #error-effect").hide();
                ajaxProcess = false;
            },
            error: function(data, formid) {
                $("#" + formid + " #error-effect").show();
                ajaxProcess = false;
            }
        });
    }

    function checFormValidation() {
        var newpass = document.getElementById('UserPassword').value;
        var cnewpass = document.getElementById('UserCpassword').value;
        if (newpass != cnewpass) {
            document.getElementById('con_div').innerHTML = "Your password not confirmed";
            return false;
        }
        else {
            return true;
        }
    }

    function autoSaveField(uid, fieldid, field) {
        var fieldVal = document.getElementById(fieldid).value;
        $.ajax({
            url: NETWORKWE_URL+"/publices/public_profile",
            type: "POST",
            cache: false,
            data: {cuserid: uid, fieldnew: fieldVal, field: field},
            success: function(data) {
                $("#span_" + field).html(data);
            },
            error: function(data) {
                $("#span_" + field).html(data);
            }
        });
    }
    
    function deleteAccount(uid, formid) {
        if($('#account_close_reason_1').is(':checked') || $('#account_close_reason_2').is(':checked') || $('#account_close_reason_3').is(':checked') || $('#account_close_reason_4').is(':checked') || $('#account_close_reason_6').val() ){
            $("#" + formid).submit();
          /*if (ajaxProcess)
                return false;
            ajaxProcess = true;
            $.ajaxSetup({
                beforeSend: function() {
                    $("#" + formid + " #submit-button").val('Please wait...');
                },
                complete: function() {
                    $("#" + formid + " #submit-button").remove();
                }
            });
            $.ajax({
                url: NETWORKWE_URL+"/users_profiles/user_delete",
                type: "post",
                dataType: "json",
                cache: false,
                data: $("#" + formid).serialize(),
                success: function(data) {
                    ajaxProcess = false;
                    if (data.status == 'error') {
                        $("#" + formid + " #reponse-data").hide().html('<div class="' + data.status + '_msg">' + data.message + '</div>').fadeIn('slow').delay(5000).fadeOut();
                    } else if (data.status == 'success') {
                        $("#" + formid + " #reponse-data").hide().html('<div class="' + data.status + '_msg">' + data.message + '</div>').fadeIn('slow');
                        $("#" + formid + " #reponse-data ." + data.status + "_msg").delay(5000).fadeOut();
                        window.location.href = NETWORKWE_URL+'/users/logout';
                    }
                },
                error: function(data) {
                    ajaxProcess = false;
                    $("#" + formid + " #reponse-data").hide().html('<div class="error_msg">' + data.message + '</div>').fadeIn('slow');
                }
            });*/
        }else {
            if ($('#msg').length < 1)
                $('#account_close_reason_1').parent().before('<div id="msg"></div>');
            $("#msg").removeClass("success_msg").addClass("error_msg").slideDown('slow').delay(2000).fadeOut().html('Please select reason to close.');
        }
    }
