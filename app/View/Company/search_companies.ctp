		<?php 
        if ($comResult) {
			foreach ($comResult as $company) { 
				$companyID = $company['companies']['id'];
				$users_following_id = $company['users_followings']['id'];
				$companytitle = strtolower($company['companies']['title']);
				$companytitle = str_replace(' ', '-', $companytitle);
				$company_owner = $company['companies']['user_id'];
				
				
		?>
				<div class="connection-listing">
						<div class="connection">							
							<?php
							echo '<a href="'.NETWORKWE_URL.'/companies/view/'.$companyID.'/'.$companytitle.'">';	
							if(!empty($company['companies']['logo'])){
								$file = MEDIA_URL.'/files/company/icon/'.$company['companies']['logo'];
								$file_headers = @get_headers($file);
								if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
									echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array());
								}else {
									echo $this->Html->image(MEDIA_URL.'/files/company/icon/'.$company['companies']['logo'],array());
								}
							}else{
								echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array());
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
								<li>
								
								 <?php foreach ($companies_followed_by_user as $row_Company) {
					$users_following_id = $row_Company['users_followings']['id'];
					$users_f_id = $row_Company['users_followings']['following_id'];
					?>
                <?php 
				if ($users_f_id == $companyID) {
				if ($row_Company['users_followings']['status']==2 && $row_Company['users_followings']['user_id']==$uid) {?>
                <p>
            <!--<a href="Javascript:removeFollowingTheCompany('0','<?php //echo $users_following_id ?>')"style="color:#0073E6; font-size:13px; text-decoration:none;">Following</a>-->
                </p>
                <?php }}}?>
              
              
              <?php if ($company_owner != $uid) {?>  
              <div id="span_<?php echo $companyID?>">
           		 <?php $flag = false;             
					foreach ($loggeduers_following_companies as $logged_user_company) {
							$my_following_id = $logged_user_company['users_followings']['following_id'];
							$my_user_follow_id = $logged_user_company['users_followings']['id'];
							if ($companyID == $my_following_id) {
							?>
            				<?php if ($logged_user_company['users_followings']['status']== 0 && $logged_user_company['users_followings']['user_id']==$uid) {?>
									<div style="float:right; display:block;" id="follow_<?php echo $companyID;?>">
            			<a href="Javascript:followingTheCompany('<?php echo $companyID?>','<?php echo $uid?>','2','<?php echo $my_user_follow_id ?>')" class="button">Follow</a>
            						</div>
									<?php  $flag = true; break;
									}?>
            				<?php if ($logged_user_company['users_followings']['status']==2 && $logged_user_company['users_followings']['user_id']==$uid) { ?>
							<div style="float:right; display:block;">
            	 			<?php echo $this->Html->link('View',array('controller'=>'companies','action'=>'view',$companyID,$companytitle),
																				  array('class'=>'button'));?>
							</div>
            				<?php $flag = true; break; }?>
            		<?php }
						}
					?>
                    
            		<?php if ($flag == false) { ?>
							<div style="float:right; display:block;" id="follow_<?php echo $companyID;?>">
            					<a href="Javascript:followingTheCompany('<?php echo $companyID?>','<?php echo $uid?>','2','')" class="button">Follow</a>
            				</div>
						<?php }?>

           	 </div>
				<?php }?>				  
          </li>
		</ul>
	</div>
	<div class="clear"></div>
	</div>   
		
	<?php }}?>