<?php 
		echo $this->Html->css(array(MEDIA_URL . '/css/webcam.css'));
 		echo $this->Html->script(array(MEDIA_URL . '/js/webcam/webcam.js', MEDIA_URL . '/js/webcam/script.js'));
 ?>
<div id="photos"></div>
<div id="camera">
    <span class="tooltip"></span>
    <span class="camTop">Take Photo</span>
    <div id="screen"></div>
    <div id="buttons">
    <div class="buttonPane">
    <a id="shootButton" href="" class="blueButton">Shoot!</a>
    </div>
    <div class="buttonPane hidden">
    <a id="cancelButton" href="" class="blueButton">Cancel</a> 
    <a id="uploadButton" href="" class="greenButton">Upload!</a>
    </div>
    </div>
    <span class="settings"></span>
</div>