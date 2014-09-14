<?php foreach ($user_starsign_detail_ajax as $starsign__Row) {?>
   	<div class="dialog-mask">
    	<div class="dialog-window">
        	<div class="dialog-title" style="background:#333;">
            	<button class="dialog-close" onclick="hideUserSign();"></button>
            	<h3 class="title"><?php echo $firstname." ".$lastname." Star sign";?> </h3>
            </div>
            <div class="dialog-body">
            	<div class="dialog-content">
                	<div class="send-message-dialog">
                		<ul style="padding:0; margin:0">
                        	<li>
                            	<label style="width:154px; text-align:left;"><?php echo $starsign__Row['Star_sign']['name']." : "?></label>
                                <div class="elem" style="width:650px;">
								<?php echo $this->Html->image('starsign/'.$starsign__Row['Star_sign']['icon'],array('style'=>'float:left;width:29px;margin-left:5px;;margin-top:0px;'));?></div>
                            </li>
                            <li>
                            	<label style="width:154px; text-align:left;"><?php echo "Element:"?></label>
                                <div class="elem" style="width:650px;">
								<?php echo $starsign__Row['Star_sign']['element'];?></div>
                            </li>
                             <li>
                            	<label style="width:154px; text-align:left;"><?php echo "Ruling planets:"?></label>
                                <div class="elem" style="width:650px;">
								<?php echo $starsign__Row['Star_sign']['ruling_planets'];?></div>
                            </li>
                             <li>
                            	<label style="width:154px; text-align:left;"><?php echo "Symbol:"?></label>
                                <div class="elem" style="width:650px;">
								<?php echo $starsign__Row['Star_sign']['Symbol'];?></div>
                            </li>
                             <li>
                            	<label style="width:154px; text-align:left;"><?php echo "Stone:"?></label>
                                <div class="elem" style="width:650px;">
								<?php echo $starsign__Row['Star_sign']['stone'];?></div>
                            </li>
                            <li>
                            	<label style="width:154px; text-align:left;"><?php echo "Life pursuit:"?></label>
                                <div class="elem" style="width:650px;">
								<?php echo $starsign__Row['Star_sign']['life_pursuit'];?></div>
                            </li>
                            <li>
                            	<label style="width:154px; text-align:left;"><?php echo "Vibration:"?></label>
                                <div class="elem" style="width:650px;">
								<?php echo $starsign__Row['Star_sign']['vibration'];?></div>
                            </li>
                            
                             <li>
                            	<label style="width:154px; text-align:left;"><?php echo $starsign__Row['Star_sign']['name']." Secret Desire:"?></label>
                                <div class="elem" style="width:650px;">
								<?php echo $starsign__Row['Star_sign']['secret_desire'];?></div>
                            </li>
                            
                            <li>
                            	<label style="width:154px; text-align:left;"><?php echo "Description:"?></label>
                                <div class="elem" style="width:650px;">
								<?php echo $starsign__Row['Star_sign']['description'];?></div>
                            </li>
                           
                        </ul>
                           
                </div>
               </div>
            </div>
        </div>
    </div>
   <?php }?>