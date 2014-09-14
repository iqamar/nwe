    <div class="close" onclick="disablePopup()"></div>
    <?php if ($star_type == 'starsign') {?>
        <div class="greybox-div-heading">
            <h1><?php echo $firstname." ".$lastname." Star sign";?></h1>
        </div>
        <div id="tab-star" class="tab-container" data-easytabs="true" style="height:500px; overflow:auto; width:600px;">
            
            <div class='panel-container'>
                    <div class="starsign">
    
                    <div>

                        <ul style="width:auto;">
                            <li><a href="#"><strong><?php echo $user_star_detail['Star_sign']['name']." : "?></strong> </a>
                                <span>
                                <?php 
                                    echo $this->Html->image(MEDIA_URL.'/files/starsign/'.$user_star_detail['Star_sign']['icon'],
                                                                                                array('style'=>'float:left;width:29px;margin-left:5px;;margin-top:0px;'));?>
                               </span>
                            </li>
                            <li><strong><?php echo "Element:"?></strong><span><?php echo $user_star_detail['Star_sign']['element'];?></span></li>
                            <li><strong><?php echo "Ruling planets:"?></strong><span><?php echo $user_star_detail['Star_sign']['ruling_planets'];?></span></li>
                            <li><strong><?php echo "Symbol:"?></strong><span><?php echo $user_star_detail['Star_sign']['Symbol'];?></span></li>
                            <li><strong><?php echo "Stone:"?></strong><span><?php echo $user_star_detail['Star_sign']['stone'];?></span></li>
                            <li><strong><?php echo "Life pursuit:"?></strong><span><?php echo $user_star_detail['Star_sign']['life_pursuit'];?></span></li>
                            <li><strong><?php echo "Vibration:"?></strong><span><?php echo $user_star_detail['Star_sign']['vibration'];?></span></li>
                            <li><strong><?php echo $user_star_detail['Star_sign']['name']." Secret Desire:"?></strong>
                                <span><?php echo $user_star_detail['Star_sign']['secret_desire'];?></span>
                            </li>
                            <li><?php echo strip_tags($user_star_detail['Star_sign']['description']);?></li>
                               
                    </ul>
                    
                     </div>
        </div>
        <div class="clear"></div>
    </div>
<?php }?>
<?php if ($star_type == 'dailysign') {?>
       <div class="greybox-div-heading">
            <h1><?php echo $firstname." ".$lastname." Daily Horoscope";?></h1>
        </div>
        <div id="tab-star" class="tab-container" data-easytabs="true" style="min-height:160px; overflow:auto; width:600px;">
            
            <div class='panel-container'>
                    <div class="starsign">
    
                    <div>
                          
                               <?php foreach ($user_last_stars as $last_star_row) {?>
                                	<?php echo strip_tags($last_star_row['daily_horoscopes'][$star_name]);?>
                               <?php }?>
                           </div>
            </div>
            <div class="clear"></div>
        </div>
  <?php }?>          
               