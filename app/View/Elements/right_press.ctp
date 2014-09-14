<div class="grid_4">
<div class="mpubox">
<a href="http://rakbank.ae/wps/portal/home" target="_blank">
<img src="http://media.networkwe.net/img/rakbank.gif">
</a>
</div>
<?php if ($this->Session->read($userid)) {?>
<h1>
<a class="twitter-timeline" data-tweet-limit="5" style="padding:0px 10px;" data-chrome="nofooter transparent" href="https://twitter.com/networkwe" data-widget-id="384298448570175488">Tweets by @networkwe</a></h1>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<?php }?>
</div>
