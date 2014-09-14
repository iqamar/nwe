<script type="text/javascript" async="" src="<?= $this->request->base ?>/js/tagcloud_plusone.js" gapi_processed="true"></script>
<script src="<?= $this->request->base ?>/js/tagcloud_webfont.js" type="text/javascript" async=""></script>

<style type="text/css">
<!--
/**
 * GeSHi (C) 2004 - 2007 Nigel McNie, 2007 - 2008 Benny Baumann
 * (http://qbnz.com/highlighter/ and http://geshi.org/)
 */
.javascript  {font-family: 'Andale Mono', Consolas, monospace; font-size: 11px}
.javascript .imp {font-weight: bold; color: red;}
.javascript .kw1 {color: #000066; font-weight: bold;}
.javascript .kw2 {color: #003366; font-weight: bold;}
.javascript .kw3 {color: #000066;}
.javascript .kw5 {color: #FF0000;}
.javascript .co1 {color: #006600; font-style: italic;}
.javascript .co2 {color: #009966; font-style: italic;}
.javascript .coMULTI {color: #006600; font-style: italic;}
.javascript .es0 {color: #000099; font-weight: bold;}
.javascript .br0 {color: #009900;}
.javascript .sy0 {color: #339933;}
.javascript .st0 {color: #3366CC;}
.javascript .nu0 {color: #CC0000;}
.javascript .me1 {color: #660066;}
.javascript span.xtra { display:block; }
-->
</style>
<!--[if lt IE 9]><script type="text/javascript" src="excanvas.min.js"></script><![endif]-->
<script src="<?= $this->request->base ?>/js/tagcloud_tagcanvas.min.js" type="text/javascript"></script>

<script type="text/javascript">
var o = { textFont: 'Niconne, sans-serif', maxSpeed: 0.02, fadeIn: 800,
  textColour: '#900', textHeight: 25, outlineMethod: 'colour',
  outlineColour: '#039', outlineOffset: 0, depth: 0.97, minBrightness: 0.2,
  wheelZoom: false, reverse: true, shadowBlur: 2, shuffleTags: true,
  shadowOffset: [1,1], stretchX: 1.7 }, WebFontConfig = {
  google: { families: ['Nosifer::latin', 'Niconne::latin', 'Erica+One::latin',
    'Audiowide::latin', 'Oswald::latin', 'Allerta+Stencil::latin',
    'Bangers::latin', 'Bonbon::latin', 'Boogaloo::latin',
    'Covered+By+Your+Grace::latin' ] },
  active: function() {
    TagCanvas.Start('fontCanvas','gwftags',o)
  }
};
function startCanvas() {TagCanvas.Start('fontCanvas','gwftags',o)};
function gwf(f) {
  o.textFont = f + ', sans-serif';
  startCanvas();
  document.getElementById('fontName').innerHTML = f;
  return false
}
(function() {
  var wf = document.createElement('script');
  wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
    '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
  wf.type = 'text/javascript';
  wf.async = 'true';
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(wf, s);
})();
</script>
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Nosifer%7CNiconne%7CErica+One%7CAudiowide%7COswald%7CAllerta+Stencil%7CBangers%7CBonbon%7CBoogaloo%7CCovered+By+Your+Grace&subset=latin,latin,latin,latin,latin,latin,latin,latin,latin,latin">

<div id="content" >

<div class="centred" style="width: 302px">
<canvas id="fontCanvas" width="380" height="200" style="">
	<p>Example web fonts canvas</p>
</canvas>

<div style="display: none;" id="gwftags">
<a href="#">NetworkWe</a>
<a href="#">Forum International</a>
<!--<a href="#" onclick="return gwf(&#39;Erica One&#39;)">2</a>-->
<a href="#">Professionals Network</a>
<a href="#">Business Network</a>
<a href="#">Groups</a>
<a href="#">Jobs</a>
<a href="#">Share Knowledge</a>
<a href="#">Opportunities</a>
</div>
</div>
</div>