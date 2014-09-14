<div class="mid-txt">
		    <div class="lft-div">
			<div class="mid-img-div">
			    <div class="mngr-div">
				<ul class="bxslider">
				    <li>
					<div style="background-color:#fff;width:100%;">
					    <div class="home_slider_img">
						<img src="<?= $this->request->base ?>images/adel.jpg" height="100" width="100" />
					    </div>
					    <div class="home_slider_desc">
						<h1 class="home_slider_name" >Adel Al Alawi</h1>
						<div class="home_slider_title">Chief Executive Officer at Gulfbankers Executive Search</div>
						<div class="home_slider_country">Dubai - UAE</div>
					    </div>
					</div>
					<div style="clear:both"></div>
				    </li>

				    <li>
					<div style="background-color:#fff;width:100%;">
					    <div class="home_slider_img">
						<img src="<?= $this->request->base ?>images/deepak.jpg" height="100" width="100" />
					    </div>
					    <div class="home_slider_desc">
						<h1 class="home_slider_name" >Deepak Patil</h1>
						<div class="home_slider_title">IT Manager at GulfBankers Executive Search</div>
						<div class="home_slider_country">Dubai - UAE</div>
					    </div>
					</div>
					<div style="clear:both"></div>
				    </li>

				    <li>
					<div style="background-color:#fff;width:100%;">
					    <div class="home_slider_img">
						<img src="<?= $this->request->base ?>images/radha-eapen.jpg" height="100" width="100" />
					    </div>
					    <div class="home_slider_desc">
						<h1 class="home_slider_name" >Radha Eapen</h1>
						<div class="home_slider_title">Country Managing Partner - UAE at GulfBankers Executive Search</div>
						<div class="home_slider_country">Dubai - UAE</div>
					    </div>
					</div>
					<div style="clear:both"></div>
				    </li>


				    <li>
					<div style="background-color:#fff;width:100%;">
					    <div class="home_slider_img">
						<img src="<?= $this->request->base ?>images/meena-kaul.jpg" height="100" width="100" />
					    </div>
					    <div class="home_slider_desc">
						<h1 class="home_slider_name" >Meena Kaul</h1>
						<div class="home_slider_title">Managing Partner - Bahrain at GulfBankers Executive Search</div>
						<div class="home_slider_country">Bahrain</div>
					    </div>
					</div>
					<div style="clear:both"></div>
				    </li>

				    <li>
					<div style="background-color:#fff;width:100%;">
					    <div class="home_slider_img">
						<img src="<?= $this->request->base ?>images/paul-o-flynn.jpg" height="100" width="100" />
					    </div>
					    <div class="home_slider_desc">
						<h1 class="home_slider_name" >Paul O'Flynn</h1>
						<div class="home_slider_title">Associate Director at GulfBankers Executive Search</div>
						<div class="home_slider_country">Bahrain</div>
					    </div>
					</div>
					<div style="clear:both"></div>
				    </li>

				    <li>
					<div style="background-color:#fff;width:100%;">
					    <div class="home_slider_img">
						<img src="<?= $this->request->base ?>/images/nariman-maher.jpg" height="100" width="100" />
					    </div>
					    <div class="home_slider_desc">
						<h1 class="home_slider_name" >Nariman Maher</h1>
						<div class="home_slider_title">Team leader - Covering GCC & MENA Region at GulfBankers Executive Search</div>
						<div class="home_slider_country">Egypt</div>
					    </div>
					</div>
					<div style="clear:both"></div>
				    </li>
				</ul>
			    </div>
			</div>
			<div class="lftmain">
				<div class="lft-container" style="padding:0px;">
					<div style="float:left;">
				  
						<?php echo $this->element('Default/tagcloud'); ?>





					</div>

					<div class="pagingNo" style="float:right;">
				    <ul>
						<li style="float:none"><a href="#">&rarr; Networkwe Member Directory</a></li>
						<li class="clr"></li>
						<li style="float:none"><a href="#">&rarr; Search Members by Country</a></li>						
					
				    </ul>
				</div>

				</div>
			</div>

			<div class="lftmain">
			   
			    <div >
					<div id="imapbuilder_div">
									<script src="<?= $this->request->base ?>/js/imap5core.js" type="application/javascript"></script>
									<script type="application/javascript">imap5.init({usermap:52075166,local:true,base:"<?= $this->request->base ?>/js/"});</script>
								</div>
			    
								
								    </div>
								</div>

								</div>

								<div class="rgt-div">								   	    
									<?php echo $this->element('Users/registration_form'); ?>	    
								    
								   <?php echo $this->element('Default/widget_search'); ?>

								</div>
								


								<div class="mid-txt">
									<div class="ttle-bar">Search Members by Country</div>
									<div class="contact-form pagingNo" style="width:100%">
									    <style type="text/css">
										input.styled { display: none; } select.styled { position: relative; width: 190px; opacity: 0; filter: alpha(opacity=0); z-index: 5; } .disabled { opacity: 0.5; filter: alpha(opacity=50); }
									    </style>
										<ul>
											<?php
												$i=0;	
												foreach ($countries as $country):
												if($i==15){break;}
												$i++;
										    ?>
						    				<li class="txt srchtxt-line" style="width:170px;"><a href="#"><img style="vertical-align:middle" src="<?php echo $this->request->base; ?>images/flags/<?php echo $country['countries']['alpha_2']; ?>.png">
											<?php echo substr($country['countries']['name'], 0, 20); ?>					
						    				</a></li>
											<?php endforeach; ?>	   

										<li class="clr"></li>
										
										

									    </ul>
<div class="srchbylinkmore" style="padding-right:30px;padding-bottom:30px;"><a href="#">More</a></div>
									</div>
								 </div>

</div>
