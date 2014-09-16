$(document).ready(function(){
	
	var camera = $('#camera'),
		photos = $('#photos'),
		screen =  $('#screen');

	var template = '<a href="uploads/original/{src}" rel="cam" '
		+'style="background-image:url(uploads/thumbs/{src})"></a>';

	/*----------------------------------
		Setting up the web camera
	----------------------------------*/


	webcam.set_swf_url('/js/webcam/webcam.swf');
	webcam.set_api_url('/users_profiles/upload');	// The upload script
	webcam.set_quality(80);				// JPEG Photo Quality
	webcam.set_shutter_sound(true, '/js/webcam/shutter.mp3');

	// Generating the embed code and adding it to the page:	
	screen.html(
		webcam.get_html(screen.width(), screen.height())
	);

	/*----------------------------------
		Binding event listeners
	----------------------------------*/


	var shootEnabled = false;
		
	$('#shootButton').click(function(){
		
		if(!shootEnabled){
			alert("not");
			return false;
		}
		
		webcam.freeze();
		togglePane();
		return false;
	});
	
	$('#cancelButton').click(function(){
		webcam.reset();
		togglePane();
		return false;
	});
	
	$('#uploadButton').click(function(){
		$("#output").show('fast');							  
		webcam.upload();
		togglePane();
		webcam.reset();
		
		//setTimeout(function(){window.location.href="http://demo.networkwe.com/users_profiles/update/#fragment-2";},2000);
		return false;
		
	});

	camera.find('.settings').click(function(){
		if(!shootEnabled){
			return false;
		}
		
		webcam.configure('camera');
	});

	// Showing and hiding the camera panel:
	
	var shown = false;
	$('.camTop').click(function(){
		
		$('.tooltip').fadeOut('fast');
		
		if(shown){
			camera.animate({
				bottom:-466
			});
		}
		else {
			camera.animate({
				bottom:-5
			},{easing:'easeOutExpo',duration:'slow'});
		}
		
		shown = !shown;
	});

	$('.tooltip').mouseenter(function(){
		$(this).fadeOut('fast');
	});


	/*---------------------- 
		Callbacks
	----------------------*/
	
	
	webcam.set_hook('onLoad',function(){
		// When the flash loads, enable
		// the Shoot and settings buttons:
		shootEnabled = true;
	});
	
	webcam.set_hook('onComplete', function(msg){
		//alert(msg);
		// This response is returned by upload.php
		// and it holds the name of the image in a
		// JSON object format:
		//alert(msg);
		//window.location.replace("http://demo.networkwe.com/users_profiles/myprofile");	
		//window.location="http://demo.networkwe.com/users_profiles/update/#fragment-2";
		msg = $.parseJSON(msg);
		//alert(msg.filename);
		if(msg.error){
			alert(msg.message);
			return false;
		}
		 
			// Adding it to the page;
		filename = 'http://media.networkwe.com/files/user/original/'+ msg.filename;
		
		document.getElementById("photo_style_1").src=filename;
		document.getElementById("photo_style_2").src=filename;
		document.getElementById("photo_style_3").src=filename;
		
		document.getElementById("profile_pic").src=filename; 
		document.getElementById('camera').style.display = 'none';
		document.getElementById('output').style.display = 'none';
		//camera.hide();	
		document.getElementById("fade").style.display = 'none';
			//$("#photo_style_2").attr('src', filename);
			//$("#photo_style_3").attr('src', filename);
			//photos.prepend(templateReplace(template,{src:msg.filename}));
			
			//initFancyBox();
			
		
	});
	
	webcam.set_hook('onError',function(e){
		screen.html(e);
	});
	
	
	/*-------------------------------------
		Populating the page with images
	-------------------------------------*/
	
	var start = '';
	
/*	function loadPics(){
	
		// This is true when loadPics is called
		// as an event handler for the LoadMore button:
		
		if(this != window){
			if($(this).html() == 'Loading..'){
				// Preventing more than one click
				return false;
			}
			$(this).html('Loading..');
		}
		
		// Issuing an AJAX request. The start parameter
		// is either empty or holds the name of the first
		// image to be displayed. Useful for pagination:
		
		$.getJSON('/users_profiles/browse',{'start':start},function(r){
			
			photos.find('a').show();
			var loadMore = $('#loadMore').detach();
			
			if(!loadMore.length){
				loadMore = $('<span>',{
					id			: 'loadMore',
					html		: 'Load More',
					click		: loadPics
				});
			}
			
			$.each(r.files,function(i,filename){
				photos.append(templateReplace(template,{src:filename}));
			});

			// If there is a next page with images:			
			if(r.nextStart){
				
				// r.nextStart holds the name of the image
				// that comes after the last one shown currently.
				
				start = r.nextStart;
				photos.find('a:last').hide();
				photos.append(loadMore.html('Load More'));
			}
			
			// We have to re-initialize fancybox every
			// time we add new photos to the page:
			
			initFancyBox();
		});
		
		return false;
	}

	// Automatically calling loadPics to
	// populate the page onload:
	
	loadPics();*/
	

	/*----------------------
		Helper functions
	------------------------*/

	
	// This function initializes the
	// fancybox lightbox script.
	
	function initFancyBox(filename){
		photos.find('a:visible').fancybox({
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
			'overlayColor'	: '#111'
		});
	}


	// This function toggles the two
	// .buttonPane divs into visibility:
	
	function togglePane(){
		var visible = $('#camera .buttonPane:visible:first');
		var hidden = $('#camera .buttonPane:hidden:first');
		
		visible.fadeOut('fast',function(){
			hidden.show();
		});
	}
	
	
	// Helper function for replacing "{KEYWORD}" with
	// the respectful values of an object:
	
	function templateReplace(template,data){
		return template.replace(/{([^}]+)}/g,function(match,group){
			return data[group.toLowerCase()];
		});
	}
	
	
	
});
