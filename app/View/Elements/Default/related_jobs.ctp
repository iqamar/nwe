<?php if ($relatedjobs) { ?>
<div class="greybox">
    <div class="greybox-div-heading">
    	<a href="<?php echo JOBS_URL; ?>" class="seeall2">See All Jobs</a>
    	<h1>Related Jobs</h1>
    </div>
           
            <ul id="slider1">
			
            	<?php 
				
                	foreach ($relatedjobs as $jobRow) {
						
						$created_date = $jobRow['Job']['modified'];
							$year = date("Y", strtotime($created_date));
							$month = date("M", strtotime($created_date));
							$day = date("d", strtotime($created_date));
						
				?>
				<li>
                <div class="slide-wrapper">
                    <div class="rgtwidget-listing">
                      <div class="rgtwidget-listing-logo">
                       <?php
    						if($jobRow['companies']['logo']) {
								if(file_exists(MEDIA_PATH.'/files/company/icon/'.$jobRow['companies']['logo'])){
								
									$filename = MEDIA_URL.'/files/company/icon/'.$jobRow['companies']['logo'];
								}else{
									$filename = MEDIA_URL.'/img/nologo.jpg';
								}
    						}
    						else {
    								$filename = MEDIA_URL.'/img/nologo.jpg';
   			 				}
							echo $this->Html->image($filename,array());
    					?>
                      </div>
                      <div class="rgtwidget-listing-rgt">
                      <ul>
                        <li>
                          <h1>
                          	<?php echo $this->Html->link(strip_tags(substr($jobRow['Job']['title'],0,26)),JOBS_URL.'/search/jobDetails/'.$jobRow['Job']['id'],array('target' => '_blank','style'=>'')
																				);
							?>
                          </h1>
                        </li>
                        <li>Location: 
                        	<span class="location">
								<?php echo $jobRow['Job']['city'];?> <?php //if ($jobRow['countries']['name']){echo ", ". $jobRow['countries']['name']; }?>
                            </span> 
                        </li>
                        <li><span class="postedon">Posted On: <?php echo $month." ".$day.", ".$year;?></span>
                        </li>
                      </ul>
                      </div>
                      <div class="clear"></div>
                    </div>
                <div class="clear"></div>
                </div>
				</li>
                <?php 
					}
				?>
            </ul>
           
        </div>
 <!-- greybox end -->
 <?php }?>   