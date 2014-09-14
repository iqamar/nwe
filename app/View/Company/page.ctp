<script>
$( document ).ready(function() {
  $("#success_mesg_hide").slideDown('slow').delay(300).fadeOut();
});
</script>
<div class="box">
	<div class="tab-container" id="tab-container" data-easytabs="true">
		<ul class="etabs">
			<li class="tab active"><a href="#" class="active">Company Page</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/">Following</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/search/">Search Company</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/home/">Companies Updates</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/validity/">Add Company</a></li>
		</ul>
		<div class="panel-container">
			<div id="tabs1" style="display: block;" class="active"> 
            <?php 
				echo $this->Session->flash(); 
			 
			if ($companyPagesBYuser) {
				foreach ($companyPagesBYuser as $company) { 
					$companyID = $company['companies']['id'];
					$companytitle = strtolower($company['companies']['title']);
					$companytitle = str_replace(' ', '-', $companytitle);
		?>
        
       
		
	
		
				<div class="connection-listing">
						<div class="connection">
							<?php
							echo '<a href="'.NETWORKWE_URL.'/companies/view/'.$companyID.'/'.$companytitle.'">';	
							if(!empty($company['companies']['logo'])){
								$file = MEDIA_URL.'/files/company/icon/'.$company['companies']['logo'];
								$file_headers = @get_headers($file);
								if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
									echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array(style=>'border:0px;'));
								}else {
									echo $this->Html->image(MEDIA_URL.'/files/company/icon/'.$company['companies']['logo'],array(style=>'border:0px;'));
								}
							}else{
								echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array(style=>'border:0px;'));
							}

							 echo "</a>";
							?>
						</div>
						<div class="connection-listing-rgt">
							<ul>
								<li>
								  <h1>
								   <?php echo $this->Html->link($company['companies']['title'],array('controller'=>'companies','action'=>'view',$companyID,$companytitle));?>
								  </h1>
								</li>
								<li>
									<?php echo $company['industries']['title'];?><br/>
									<?php echo $company['countries']['name']." ".$company['companies']['city']." , ".$company['companies']['address'];?><br/>
									<a href="<?php echo $company['companies']['weburl'];?>"><?php echo $company['companies']['weburl'];?></a>
								</li>
								
								
								
							</ul>
						</div>
						<div class="clear"></div>
				 </div>   
		
	<?php }}?>
						
			</div>
		</div>
	</div>
</div>



