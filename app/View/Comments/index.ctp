
<div class="connections" style="width:100%;">
<?php if ($AllConnections)
		foreach ($AllConnections as $myConnections) {?>
<div class="con_div" style="width:47.5%; float:left; margin-right:20px;">
<?php if (!empty($myConnections['users']['pic'])) {?>
<img src="<?php echo $this->base;?>/files/users/<?php echo $myConnections['users']['pic'];?>" width="100" height="100" alt="no image" style="padding:5px 5px 5px 5px; float:left;" />
<?php } else {?>
<img src="<?php echo $this->base;?>/img/no-image.png" width="100" height="100" alt="no image" style="padding-right:10px;" />
<?php }?>
<div class="user-description" style="float:left; padding-left:20px;">
<strong style="color:#006AD5; font-size:16px; font-weight:bold;"><?php echo $myConnections['users']['firstname']." ".$myConnections['users']['lastname'];?></strong>
<p style="font-size:13px; color:#404040;"><?php echo $myConnections['userexps']['designation']." at ".$myConnections['userexps']['company']." ,".$myConnections['userexps']['location']?></p>
</div>
</div>
<?php }?>


</div>

