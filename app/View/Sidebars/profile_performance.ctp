<div class="greybox">
		  <div class="greybox-div-heading">
				<h1>Profile Performance</h1>
			</div>
            	<?php if ($get_total_view_profile) {?>
            	<span>
               		<strong><?php echo $get_total_view_profile;?> people</strong> have viewed your profile 
                </span>
                <?php }?>
				<div>
                <?php echo $this->Html->image(MEDIA_URL.'/img/whovisitprofile.png');?>
                <span><!--With a Premium Account you can see who has viewed your profile. <a href="#">Upgrade Now</a>--></span>
                </div>
</div>