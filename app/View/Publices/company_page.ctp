<?php
echo $this->Html->css(array(MEDIA_URL.'/js/webguide/webguide.css'));
echo $this->Html->script(array(MEDIA_URL.'/js/webguide/webguide.js', MEDIA_URL.'/js/webguide/webguide_captions.js'));
?>
<script>
    function showInfo(div) {
        $("#" + div).slideToggle('slow');
    }
    function checkValidate() {
        var userid = document.getElementById('user_id').value;
        var friendid = document.getElementById('friend_id').value;
        if (friendid == userid)
            alert("you cant sent reques to itself");
        return false;
    }
    function closeMessage() {
        $("#hideMessage").slideUp('slow');
    }
    function showProfiles(id, user_id) {
        $.ajax({
            url: baseUrl + "/users_profiles/recommended_profiles",
            type: "GET",
            cache: false,
            data: {user_id: user_id, id: id},
            success: function(data) {
                //$(this).css('background','none');
                $("#resultDiv_" + id).html(data);
            },
            error: function(data) {
                $("#resultDiv_" + id).html("error");
            }
        });
    }
    function hideMessageForm(id) {
        document.getElementById('fade').style.display = 'none';
        document.getElementById('userSendForm_' + id).style.display = 'none';
    }
    
</script>
<div class="rgtcol">
    <div id="step1">
        <div class="joinimg"><img src="<?php echo MEDIA_URL ?>/img/join_image.png" width="290" height="74" /></div>
        <div class="greybox">
            <div class="greybox-div-heading"> 
                <h1>Sign Up </h1>
            </div>
            <div><?php echo $this->element('Users/registration_form'); ?></div>
        </div>
    </div>
    <div class="greybox" id="step2">
        <div>
            <div class="greybox-div-heading"> 
                <h1>Sign In</h1>
            </div>
            <?php echo $this->element('Users/login_form'); ?>
        </div>
    </div>
    <div id="step3">
    <?php echo $this->element('Default/widget_search'); ?>
    </div>
</div>

<div class="leftcol">
	
<div class="tab-container" id="tab-container" data-easytabs="true">
	<ul class="etabs">
		<li class="tab active"><a href="#" class="active">Company Page</a></li>
	</ul>
	<div class="panel-container">
		<div id="tabs1" style="display: block;" class="active"> 
       
      
			<?php 
				if ($companyDetail) {
				$companyID = $companyDetail['companies']['id'];
				$companytitle = strtolower($companyDetail['companies']['title']);
				$companytitle = str_replace(' ', '-', $companytitle);
				$company_user = $companyDetail['companies']['user_id'];
			?>
			<!--- company header start -->
			<div>
				<div class="com-rgt" style="padding:10px 4px 10px 4px; ">
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
					<div class="button-in-middle" style="text-align:center;">
					
						<span id="company_follow_by_user">
						
							<a href="javascript:;" onclick="startIntro();" class="button current">Follow</a>
						</span>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
			 
				<div class="com-lft">
					<div class="com-left-details">
						<ul>
							<li>
								<h1><?php echo $companyDetail['companies']['title'];?></h1>
							</li>
							<li><?php echo $companyDetail['companies']['city'].", ". $companyDetail['countries']['name'];?></li>
							<li>									
								<a target="_blank" href="<?php echo $companyDetail['companies']['weburl'];?>"><?php echo $companyDetail['companies']['weburl'];?></a>
							</li>
							<li>
								<strong>Industry:</strong> <?php echo $companyDetail['industries']['title'];?>
							</li>
							<li>
								<strong>Founded:</strong> <?php echo $companyDetail['companies']['established'];?> | <strong>Company size:</strong> <?php echo $companyDetail['companies']['company_size'];?> | <strong>Type:</strong> <?php echo $companyDetail['companies_types']['title'];?>
							</li>
						</ul> 
					</div>
					<div class="companypage-nav">
						&nbsp;
						
						<div class="clear"></div>    
					</div>  

					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			<!--- company header end -->
			
			
		
<?php }?>
			<div style="padding:10px;">
			<div class="marginbottom10">
				<h1><?php echo "Recent Updates ";?></h1>
			</div>

			<?php 
				if ($company_Updates) { 
				foreach ($company_Updates as $company_update_row) { 
				$companyID = $company_update_row['companies']['id'];
				$entityID = $company_update_row['Entity_update']['id'];
				$user_liked_ID = $company_update_row['likes']['user_id'];
				$liked_ID = $company_update_row['likes']['id'];
				$companytitle = strtolower($company_update_row['companies']['title']);
				$companytitle = str_replace(' ', '-', $companytitle);
				$update_title = strtolower($company_update_row['Entity_update']['group_title']);
				$update_title = str_replace(' ', '-', $update_title);
				$month = date('F',strtotime($company_update_row['Entity_update']['created']));
				$day = date('d',strtotime($company_update_row['Entity_update']['created']));
				$year = date('Y',strtotime($company_update_row['Entity_update']['created']));
				?>
                <div class="post-wall" id="<?php echo $entityID;?>">
						<div class="userpic-post">
                        	<a href="<?php echo NETWORKWE_URL; ?>/company/page/<?php echo $companyID;?>/<?php echo $companytitle;?>">
                            	<?php 
									if (!empty($company_update_row['companies']['logo'])) {
										if (file_exists(MEDIA_PATH.'/files/company/logo/'.$company_update_row['companies']['logo'])) {
											echo $this->Html->image(MEDIA_URL.'/files/company/logo/'.$company_update_row['companies']['logo'],array('alt'=>'no-img'));
										}
										else {
											echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array('alt'=>'no-img'));
										}
									}
									else{
										echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array('alt'=>'no-img'));
									}
								?>
                            </a>
                        </div>
						<div class="post-wall-rgt">
							<ul>
								<li>
                                	<a href="<?php echo NETWORKWE_URL; ?>/company/page/<?php echo $companyID;?>/<?php echo $companytitle;?>" class="postwall-name">
										<?php echo $company_update_row['companies']['title'];?>
                                    </a>	
                                </li>
								<li>
								<div class="post-wall-subcontent">
                                	<div class="post-wall-subcontent-rgt2">
                                    	<ul>
                                        	<li>								
										<?php if ($company_update_row['Entity_update']['image']) {
                                                        
                                                    if ($company_update_row['Entity_update']['entity_type'] == "company") {
														echo '<div class="subcontent2-pic">';
                                                        echo $this->Html->image(MEDIA_URL.'/files/update/original/'.$company_update_row['Entity_update']['image'],
                                                                                                                                                         array('alt'=>'no-img'));
														echo '</div>';
                                                    }
                                                    else if($company_update_row['Entity_update']['entity_type'] == "news"){
														echo '<div class="subcontent2-pic">';
                                                        echo $this->Html->image(MEDIA_URL.'/files/news/original/'.$company_update_row['Entity_update']['image'],array('alt'=>'no-img'));													echo '</div>';
                                                    }
                                                    echo $company_update_row['Entity_update']['update_text'];
                                                   
                                            }
                                            else {
                                                if ($company_update_row['Entity_update']['update_text']) {
                                                    echo $company_update_row['Entity_update']['update_text'];
                                                }
                                               
                                            }?>
                                            </li>
                                         </ul>
                                    </div>
								<div class="clear"></div>
								</div>
							
                                
							   </li>
							</ul>
						</div>
						<div class="clear"></div>
					</div>
					
    
                    
				<?php } ?>
				<div class="clear"></div>
				<div class="paging">
					<?php 
						echo $this->Paginator->first(__('<< First', true), array('class' => 'number-first')).'&nbsp;&nbsp;';
						echo $this->Paginator->numbers(array('separator' => '&nbsp;&nbsp;','class' => 'numbers', 'first' => false, 'last' => false)).'&nbsp;&nbsp;';
						echo $this->Paginator->last(__('Last >>', true), array('class' => 'number-end'));
					?>
				</div>
				
				<?php }?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
	
	
</div>