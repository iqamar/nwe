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
        	<?php if ($this->params['named']['mesg'] !=''){ ?>
					<div class="success_msg">
							<?php
								$mesg = $this->params['named']['mesg']; 
								echo $mesg;
							?>
					</div>
			<?php  }?>
     
     	
		<?php 
				if ($companyDetail) {
				$companyID = $companyDetail['companies']['id'];
				$companytitle = strtolower($companyDetail['companies']['title']);
				$companytitle = str_replace(' ', '-', $companytitle);
				$company_user = $companyDetail['companies']['user_id'];
				
			?>
			<!--- company header start -->
			<div>
				<div class="com-rgt">
					<div class="companypage-logo">
					<?php
						if(!empty($companyDetail['companies']['logo'])){
							$file = MEDIA_URL.'/files/company/logo/'.$companyDetail['companies']['logo'];
							$file_headers = @get_headers($file);
							if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
								echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array());
							}else {
								echo $this->Html->image($file,array());
							}
						}else{
							echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array());
						}
					?>		
					</div> 
					<div class="button-in-middle">
					
						<span id="company_follow_by_user">
							<?php if($company_user != $uid){
								  if ($users_following_thisCompany !=0){
									if ($status == 2) {?>
									<a class="button" href="javascript:unfollow('<?php echo $user_company_id ?>','<?php echo $uid?>','0','<?php echo $companyID?>')">Following</a> 
									<?php } else {?>
									<a class="button" href="javascript:unfollow('<?php echo $user_company_id ?>','<?php echo $uid?>','2','<?php echo $companyID?>')">Follow</a>
									<?php }} else {?>
									<a class="button" href="javascript:unfollow('<?php echo $user_company_id ?>','<?php echo $uid?>','2','<?php echo $companyID?>')">Follow</a>
							<?php 	}
							     }
							?>
						</span>
						<div class="clear"></div>
					</div>
					<div class="totalfollowers">
							<span id="total_following"><?php  echo $count_following_thisCompany;?> </span> followers </span>						
							
					</div>
					<div class="clear"></div>
				</div>
			 
				<div class="com-lft">
					<div class="com-left-details">
						<ul>
							<li>
								<h1><?php echo $companyDetail['companies']['title'];?></h1>
							</li>
							<li><?php echo $companyDetail['companies']['city']; if ($companyDetail['countries']['name'] && $companyDetail['companies']['city']) { echo ", ";} 
								echo $companyDetail['countries']['name']; ?>
                           </li>
							<li>									
								<a target="_blank" href="<?php echo $companyDetail['companies']['weburl'];?>"><?php echo $companyDetail['companies']['weburl'];?></a>
							</li>
							<li>
								<strong>Industry:</strong> <?php echo $companyDetail['industries']['title'];?>
							</li>
							<li>
								<strong>Founded:</strong> <?php echo $companyDetail['companies']['established'];?> | <strong>Company size:</strong> <?php echo $companyDetail['companies']['company_size'];?> | <strong>Type:</strong> <?php echo $companyDetail['companies_types']['title'];?>
							</li>
                            <li>
								<strong>Public URL:</strong> <?php echo $this->Html->link(NETWORKWE_URL.'/company/page/'.$companyID,NETWORKWE_URL.'/company/page/'.$companyID,array('escape'=>false)); ?>
							</li>
                            <li><strong>Company Page Admin:</strong>
								<?php echo '<a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$company_user.'">'.$admin_info['users_profiles']['firstname']." ".$admin_info['users_profiles']['lastname'].'</a>';?>
                                </li>
						</ul> 
					</div>
					<div class="companypage-nav">
                    	
						<?php echo '<a  href="'.NETWORKWE_URL.'/companies/view/'.$companyID.'/'.$companytitle.'">Home</a>';?>
						<?php echo '<a  href="'.NETWORKWE_URL.'/companies/jobs/'.$companyID.'/'.$companytitle.'">Jobs</a>';?>
                        <?php echo '<a class="selected"  href="'.NETWORKWE_URL.'/companies/followers/'.$companyID.'/'.$companytitle.'">Followers</a>';?>
                        <?php if ($company_user == $uid) {?>
						<?php echo '<a href="'.NETWORKWE_URL.'/companies/add/'.$companyID.'/'.$companytitle.'">Edit Page</a>';?>
                        <?php echo '<a href="'.NETWORKWE_URL.'/companies/delete/'.$companyID.'/'.$companytitle.'">Delete Page</a>';?>
                        <?php }?>
						
						<div class="clear"></div>    
					</div>   
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			<!--- company header end -->
				<div class="heading"><h1>Company Followers</h1></div>
        	<?php foreach ($company_followers as $company_follow_Row) {
					$fullname = $company_follow_Row['users_profiles']['firstname']." ".$company_follow_Row['users_profiles']['lastname'];
					$user_headline = $company_follow_Row['users_profiles']['tags'];
					$user_publiclink = $company_follow_Row['users_profiles']['handler'];
					$today = strtotime(date('Y-m-d H:i:s'));
					$distination = strtotime($company_follow_Row['Users_following']['start_date']);
					$difference = ($today - $distination);
					$days = floor($difference/(60*60*24));
					$hours = floor($difference/(60*60));
					$minutes = floor($difference/(60));
				?>
            
                <div class="connection-listing">
                            <div class="connection"> 
                                <a href="/pub/<?php echo $user_publiclink;?>">
                                    <?php if (!empty($company_follow_Row['users_profiles']['photo'])) {
											if (file_exists(MEDIA_PATH.'/files/user/thumbnail/'.$company_follow_Row['users_profiles']['photo'])) {
                                            	echo $this->Html->image(MEDIA_URL.'/files/user/thumbnail/'.$company_follow_Row['users_profiles']['photo'],array('alt'=>'no-img'));
											}
											else {
												 echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'no-img'));
											}
                                          }
                                          else {
                                            echo $this->Html->image(MEDIA_URL.'/img/nophoto.jpg',array('alt'=>'no-img'));
                                          }?>
                                </a>
                            </div>
                            <div class="connection-listing-rgt">
                              <ul>
                                <li>
                                  <h1><a href="/pub/<?php echo $user_publiclink;?>"><?php echo $fullname;?></a></h1>
                                </li>
                                <li><?php echo $user_headline;?> </li>
                                <li class="posttime" style="margin-left:0px;">
								<?php echo "<strong>Following since  </strong> ";
									if ($days >= 1){
										echo "$days days";
									}else{
										if($hours >=1){
											echo "$hours hours";
										}else{
											echo "$minutes minutes";
										}
									}?>
                                    </li>
                              </ul>
                            </div>
                            <div class="clear"></div>
                   </div>
			<?php }?>
   
    
	<?php }?>
    	<div class="clear"></div>
    	</div>
     </div>
	</div>
</div>
<script type="text/javascript">
function unfollow(user_follow_id,user_id,status,company_id) {
	$("#company_follow_by_user").html('<img src="http://media.networkwe.net/img/loading.gif" />');
	$.ajax({
	url     : baseUrl+"/companies/follow_page",
	type    : "POST",
	cache   : false,
	data    : {status:status,user_id:user_id,company_id:company_id,user_follow_id:user_follow_id},
	success : function(data){	
	//$(this).css('background','none');
	responseArray = data.split("::::");
	$("#total_following").html(responseArray[0]);
	$("#company_follow_by_user").html(responseArray[1]);
	},
	error : function(data) {
	$("#company_follow_by_user").html("error");
	}
	});
	
}

function showShare() {
document.getElementById('status_share_options').style.display='block';
return true;
}

$(document).ready(function(){
	/*
	This function is called when the value of input type='file' changes.
	It further calls previewImage function which sets the image to 'preview_img'
	*/
	$("#myfile").change(function(){
    	previewImage(this);
		
	});
});
function afterSuccess() {
    $('.loading').hide();
	$('.result_txt').show();
}
function previewImage(input) {
	if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.preview_img').attr('src', e.target.result);
			$('.output_div').show();
			$('.result_txt').hide();
        }
		reader.readAsDataURL(input.files[0]);
    }
}

</script>