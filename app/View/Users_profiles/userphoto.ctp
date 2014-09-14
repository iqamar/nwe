<?php if ($imageName) {?>
    <div style="float:left;width:60px;">
    <img src="<?php echo MEDIA_URL .'/files/user/icon/'.$imageName?>" width="50" height="50" />
    </div>
    <div style="float:left;width:110px;">
    <img src="<?php echo MEDIA_URL .'/files/user/thumbnail/'.$imageName?>" width="100" height="100" />
    </div>
    
    <div style="float:left;width:169px;height:169px;">
    <img src="<?php echo MEDIA_URL .'/files/user/logo/'.$imageName?>" width="165" height="165" />
    </div>
    <?php } else {?>
    <img src="<?php echo MEDIA_URL .'img/defaultpic-male.jpg'?>" width="50" height="50" />
    </div>
    <div style="float:left;width:110px;">
    <img src="<?php echo MEDIA_URL .'img/defaultpic-male.jpg'?>" width="100" height="100" />
    </div>
    
    <div style="float:left;width:169px;height:169px;">
    <img src="<?php echo MEDIA_URL .'img/defaultpic-male.jpg'?>" width="165" height="165" />
    </div>
<?php }?>