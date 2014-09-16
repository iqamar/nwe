$(function(){
  // vars for joblogoss carousel
  var $txtcarousel = $('#joblogos-list');
  var txtcount = $txtcarousel.children().length;
  var wrapwidth = (txtcount * 690) + 690; // 400px width for each joblogos item
  $txtcarousel.css('width',wrapwidth);
  var animtime = 750; // milliseconds for clients carousel
 
  // prev & next btns for joblogoss
  $('#prv-joblogos').on('click', function(){
    var $last = $('#joblogos-list li:last');
    $last.remove().css({ 'margin-left': '-690px' });
    $('#joblogos-list li:first').before($last);
    $last.animate({ 'margin-left': '0px' }, animtime); 
  });
  
  $('#nxt-joblogos').on('click', function(){
    var $first = $('#joblogos-list li:first');
    $first.animate({ 'margin-left': '-690px' }, animtime, function() {
      $first.remove().css({ 'margin-left': '0px' });
      $('#joblogos-list li:last').after($first);
    });  
  });


  // vars for clients list carousel
  // http://stackoverflow.com/questions/6759494/jquery-function-definition-in-a-carousel-script
  var $clientcarousel = $('#clients-list');
  var clients = $clientcarousel.children().length;
  var clientwidth = (clients * 140); // 140px width for each client item 
  $clientcarousel.css('width',clientwidth);
  
  var rotating = true;
  var clientspeed = 1800;
  var seeclients = setInterval(rotateClients, clientspeed);
  
  $(document).on({
    mouseenter: function(){
      rotating = false; // turn off rotation when hovering
    },
    mouseleave: function(){
      rotating = true;
    }
  }, '#clients');
  
  function rotateClients() {
    if(rotating != false) {
      var $first = $('#clients-list li:first');
      $first.animate({ 'margin-left': '-140px' }, 600, function() {
        $first.remove().css({ 'margin-left': '0px' });
        $('#clients-list li:last').after($first);
      });
    }
  }
});