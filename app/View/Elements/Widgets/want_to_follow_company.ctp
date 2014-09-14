<?php if ($user_related_companies) { ?>
<div class="greybox">
	    <div class="greybox-div-heading">
				<h1>Companies To Follow</h1>
		</div> 
	    	<ul class="followcompany">
            <?php $i = 1; 
				foreach ($your_following_company as $your_company) {
							 $your_company_id[] = $your_company['users_followings']['following_id'];
						
					}
				foreach ($user_related_companies as $related_company_Row) {
					$companyID = $related_company_Row['companies']['id'];
					$companytitle = strtolower($related_company_Row['companies']['title']);
					$companytitle = str_replace(' ', '-', $companytitle);
					$company_followingID = $related_company_Row['users_followings']['following_id'];
					$flag = false;
					
					
				if (in_array($companyID,$your_company_id)) {
				}
				else {
				?>
           	  <li>
              	<?php 
					if ($related_company_Row['companies']['logo']) {
						if (file_exists(MEDIA_PATH.'/files/company/logo/'.$related_company_Row['companies']['logo'])) {
							echo $this->Html->image(MEDIA_URL.'/files/company/logo/'.$related_company_Row['companies']['logo'],
																											 array('url'=>array('controller'=>'companies','action'=>'view',
																																$companyID,$companytitle),
																												   'alt'=>'no image',
																												   'style'=>''
																												   )
																											 );
						}
						else {
							echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',
												array('url'=>array('controller'=>'companies','action'=>'view',
																   $companyID,$companytitle),
													  'alt'=>'no image',
													  'style'=>''
													  )
												);
						}
					}
					else {
						echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',
												array('url'=>array('controller'=>'companies','action'=>'view',
																   $companyID,$companytitle),
													  'alt'=>'no image',
													  'style'=>''
													  )
												);
						
					}
				}
				?>
              </li>
              <?php }?>
            <div class="clear"></div>
            </ul>
        <div class="more">
        	<?php echo $this->Html->link('More...',array('controller'=>'companies','action'=>'search'));?>
        </div>
</div>
<?php }?>