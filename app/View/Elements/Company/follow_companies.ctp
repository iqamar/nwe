<?php if ($user_related_companies) {?>
<div class="ttle-bar effectX">Companies you may want to follow</div>
<ul>
		<?php foreach ($user_related_companies as $company__Row) {
			 $companyID = $company__Row['companies']['id'];
			$companytitle = strtolower($company__Row['companies']['title']);
			$companytitle = str_replace(' ', '-', $companytitle);
			?>
	<li>
 		<div class="relat-jobmain-div">
		  <div class="relat-job-div" style="border-bottom:1px dotted gray;">
		    <div class="relat-jobcolm">
		      	<div class="relat-jobtxt">
        			<h1 style="color: #086A87;width: 270px;">
					<?php echo $this->Html->link($company__Row['companies']['title'],array('controller'=>'companies','action'=>'view',$companyID,$companytitle),
																				  array('style'=>'text-decoration:none; color:#006AD5;'));?>
						<span style="color:#c1c1c1;font-size:0.8em;"><?php echo $company__Row['industries']['title'];?></span>
					</h1>
 				</div>
		   	</div>
  		</div>
 	  	<div class="relat-job-pht" style="background:none;">
        <?php if ($company__Row['companies']['logo']) {
			echo $this->Html->image('/files/companies_logo/'.$company__Row['companies']['logo'],array('style'=>'width:50px; height:50px;'));
		}
		else {
			
			echo $this->Html->image('no-image.png',array('style'=>'width:50px; height:50px;'));
		}
		?>
        </div>
		<!--<div style="float:right;padding-right:10px;margin-top:-70px"><a onclick="">x</a></div>-->
		</div>  
	</li>
   <?php }?> 
</ul>	
<?php }?>