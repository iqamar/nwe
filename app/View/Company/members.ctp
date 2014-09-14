<div >
<div style="float:left;width:68%;" class="teamdiv">
     <h2 class="ttle-abt">People Directory</h2>
<div class="memberdiv">
<ul>


<?php
	$i=0;	
	foreach ($users_data as $member):
			if($i==100){break;}
			$i++;

			if(!empty($member['users_profiles']['photo'])){

				$image_name = "/files/users/".$member['users_profiles']['photo'];

			}else{
					$image_name = "/files/users/default-person.png".$member['users_profiles']['photo'];
			}
	?>
	<li><a href="#"><img style="border: 4px solid #F5F5F5;border-radius: 35px;" width="60" height="60" src="<?php echo $image_name; ?>">
		<b><?php echo $member['users_profiles']['firstname'] ." ". $member['users_profiles']['lastname'] ; ?></b>			
	</a></li>
<?php endforeach; ?>



</ul>
</div> 
</div> 

<div style="float:right;;width:30%">
<div class="rgt-container" style="width:100%;">
									<div class="ttle-bar">NetworkWe Member Directory</div>
<div class="socil-div" style="width:100%;">
		  
		 <div style="background:#FFF;width:96%;padding:2%;">Names starting with AlphaNumeric</div>

<div style="text-align:center;padding:5%;" class="pagingNo">
				    <ul>
						<li style="background-color:transparent;"><a href="#"> A </a></li>
						
						<li style="background-color:transparent;"><a href="#"> B </a></li>
<li style="background-color:transparent;"><a href="#"> C </a></li>
						
						<li style="background-color:transparent;"><a href="#"> D </a></li>
<li style="background-color:transparent;"><a href="#"> E </a></li>
						
						<li style="background-color:transparent;"><a href="#"> F </a></li>
<li style="background-color:transparent;"><a href="#"> G </a></li>
						
						<li style="background-color:transparent;"><a href="#"> H </a></li>
<li style="background-color:transparent;"><a href="#"> I </a></li>
						
						<li style="background-color:transparent;"><a href="#"> J </a></li>
<li style="background-color:transparent;"><a href="#"> K </a></li>
						
						<li style="background-color:transparent;"><a href="#"> L </a></li>
<li style="background-color:transparent;"><a href="#"> M </a></li>
						
						<li style="background-color:transparent;"><a href="#"> N </a></li>
<li style="background-color:transparent;"><a href="#"> O </a></li>
						
						<li style="background-color:transparent;"><a href="#"> P </a></li>
<li style="background-color:transparent;"><a href="#"> Q </a></li>
						
						<li style="background-color:transparent;"><a href="#"> R </a></li>	

<li style="background-color:transparent;"><a href="#"> S </a></li>
<li style="background-color:transparent;"><a href="#"> T </a></li>
						
						<li style="background-color:transparent;"><a href="#"> U </a></li>
<li style="background-color:transparent;"><a href="#"> V </a></li>
						
						<li style="background-color:transparent;"><a href="#"> W </a></li>
<li style="background-color:transparent;"><a href="#"> X </a></li>
						
						<li style="background-color:transparent;"><a href="#"> Y </a></li>
<li style="background-color:transparent;"><a href="#"> Z </a></li>

	<li style="background-color:transparent;"><a href="#"> 0 </a></li>
<li style="background-color:transparent;"><a href="#"> 1 </a></li>
	<li style="background-color:transparent;"><a href="#"> 2 </a></li>
<li style="background-color:transparent;"><a href="#"> 3 </a></li>
	<li style="background-color:transparent;"><a href="#"> 4 </a></li>
<li style="background-color:transparent;"><a href="#"> 5 </a></li>
	<li style="background-color:transparent;"><a href="#"> 6 </a></li>
<li style="background-color:transparent;"><a href="#"> 7 </a></li>
<li style="background-color:transparent;"><a href="#"> 8 </a></li>
<li style="background-color:transparent;"><a href="#"> 9 </a></li>						
										
					
				    </ul>

				</div>

 <div style="background:#FFF;width:96%;padding:2%;">Browse members by country</div>

<div style1="text-align:center;padding:5%;" class="pagingNo">

	<ul style="padding: 0 0 0 5%;">
											<?php
												///$i=0;	
												foreach ($countries as $country):
												///if($i==15){break;}
												///$i++;
										    ?>
						    				<li class1="txt srchtxt-line" style="background-color:transparent;"><a href="#" style="padding: 0 2px;;width:40px;"><img style="vertical-align:middle" src="/<?php echo $this->request->base; ?>images/flags/<?php echo $country['countries']['alpha_2']; ?>.png">
											<?php echo strtoupper($country['countries']['alpha_2']);  //echo substr($country['countries']['name'], 0, 20); ?>					
						    				</a></li>
											<?php endforeach; ?>	   

										<li class="clr"></li>
										
										

									    </ul>

				</div>


        	
</div>
																		    
									
								    </div>
</div>

     </div>