$(document).ready(function() {
    $(window).scroll(function() {
        var WindowHeight = $(window).height();
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            //$("#loader").html("<img src = '" + media + "/img/networkwe_loading.gif' alt='loading'/>");
            $('#loader').show();
            var LastDiv = $(".blogslisitng:last");
            var LastId = $(".blogslisitng:last").attr("id");
            var ValueToPass = "lastid=" + LastId;
            $.ajax({
                type: "POST",
                url: NETWORKWE_URL + "/news/get_news_ajax",
                data: {lastid: LastId},
                cache: false,
                success: function(html) {
                    //$("#loader").html("");
                    $('#loader').hide();
                    if (html) {
                        LastDiv.after(html);
                    }
                }
            });
            return false;
        }
        return false;
    });
	$('#addNews').validate();
});
function chkSize()
		{
		var resume=document.getElementById("image_url").files[0];
		//var cover_letter=document.getElementById("cover_letter").files[0].size;
		if(resume){
			if((Math.round(resume.size)/(1024*1024)) > 2)
			{
					alert('Maximum file size is restricted to 2MB.Please try again Uploading other document!!');
					  return false;
					  
			}
		}
		
	
}
function newsOfCategory(category__ID) {
    document.getElementById('search_news').value = '';
    $("#posts_listing").css('opacity', 0.2);
    $('#loader').show();
    //alert(category_title);
    $.ajax({
        url: "/news/news_by_category",
        type: "POST",
        cache: false,
        data: {category__ID: category__ID},
        success: function(data) {
            //if (share == 1) {
            $("#posts_listing").html(data);
            //}
        },
        complete: function() {
            $('#loader').hide();
            $("#posts_listing").css('opacity', 1);
        },
        error: function(data) {
            $("#posts_listing").html("<div class='error_msg'>Error loading data!</div>");
        }
    });
}
function searchByCountry(country__ID) {
    document.getElementById('search_news').value = '';
    $("#posts_listing").css('opacity', 0.2);
    $('#loader').show();
    //alert(category_title);
    $.ajax({
        url: "/news/news_by_country",
        type: "POST",
        cache: false,
        data: {country__ID: country__ID},
        success: function(data) {
            //if (share == 1) {
            $("#posts_listing").html(data);
            //}
        },
        complete: function() {
            $('#loader').hide();
            $("#posts_listing").css('opacity', 1);
        },
        error: function(data) {
            $("#posts_listing").html("there is error in your script.");
        }
    });
}
function searchByDate(days) {
    document.getElementById('search_news').value = '';
    $("#posts_listing").css('opacity', 0.2);
    $('#loader').show();
    //alert(category_title);
    $.ajax({
        url: "/news/news_by_date",
        type: "POST",
        cache: false,
        data: {days: days},
        success: function(data) {
            //if (share == 1) {
            $("#posts_listing").html(data);
            //}
        },
        complete: function() {
            $('#loader').hide();
            $("#posts_listing").css('opacity', 1);
        },
        error: function(data) {
            $("#posts_listing").html("there is error in your script.");
        }
    });
}
function showPosts(post_type) {
    $("#posts_listing").css('opacity', 0.2);
    $('#loader').show();
    //alert(category_title);
    document.getElementById('search_posts').value = '';
    $.ajax({
        url: "/blogs/blog_type",
        type: "GET",
        cache: false,
        data: {post_type: post_type},
        success: function(data) {
            //if (share == 1) {
            $("#posts_listing").html(data);
            //}
        },
        complete: function() {
            $('#loader').hide();
            $("#posts_listing").css('opacity', 1);
        },
        error: function(data) {
            $("#posts_listing").html("there is error in your script.");
        }
    });
}
function search_news() {
    var search_news = document.getElementById('search_news').value;
    $("#posts_listing").css('opacity', 0.2);
    $('#loader').show();
    //alert(category_title);
    $.ajax({
        url: "/news/search_news",
        type: "GET",
        cache: false,
        data: {search_news: search_news},
        success: function(data) {
            //if (share == 1) {
            $("#posts_listing").html(data);
            //}
        },
        complete: function() {
            $('#loader').hide();
            $("#posts_listing").css('opacity', 1);
        },
        error: function(data) {
            $("#posts_listing").html("there is error in your script.");
        }
    });
}