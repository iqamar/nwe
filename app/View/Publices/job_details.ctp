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
		<li class="tab active"><a href="#" class="active">Job Summary</a></li>
	</ul>
	<div class="panel-container">
		<div id="tabs1" style="display: block;" class="active"> 
       
      
			<?php 
			foreach($jobDetail as $jobDetail):
				if($jobDetail['CO']['logo']){
					if(file_exists(MEDIA_PATH.'/files/company/logo/'.$jobDetail['CO']['logo'])){
						$company_logo=MEDIA_URL.'/files/company/logo/'.$jobDetail['CO']['logo'];
					}else{
						$company_logo=MEDIA_URL.'/img/nologo.jpg';
					}
				}else{
					$company_logo=MEDIA_URL.'/img/nologo.jpg';
				}
				
				if($jobDetail['JS']['salary_mode']=2){
					$salary = $jobDetail['JS']['hourly_salary'];
				}elseif($jobDetail['JS']['salary_mode']=1){
					$salary = $jobDetail['JS']['min_salary'].' to '.$jobDetail['JS']['max_salary'];;
				}else{
					$salary = 'Confidential';
				}
				$pdate=date('M d, Y',strtotime($jobDetail['JS']['modified']));
				
			?>
			<!--- company header start -->
			<div>
				<div class="com-rgt" style="float:left;padding:5px 4px 5px 4px; ">
					<div class="companypage-logo">
					<?php
						echo $this->Html->Image($company_logo);
					?>		
					</div> 
					
					<div class="clear"></div>
				</div>
			 
				<div class="com-lft" style="float:right;">
					<div class="com-left-details">
						<ul>
							<li>
								<h1><?php echo $jobDetail['JS']['title'];?></h1>
							</li>
							<li><strong>Location:</strong> <span class="location"><?php echo $jobDetail['JS']['city']."&nbsp;".$jobDetail['COU']['name']; ?></span></li>
							<li>
								<strong>Posted On:</strong> <?php echo $this->Time->timeAgoInWords($pdate); ?>
							</li>
							
						</ul> 
					</div>
					<div class="companypage-nav">
						&nbsp;
						
						<div class="clear"></div>    
					</div>  

					<div class="clear"></div>
				</div>
				
			</div>
			<div class="clear">&nbsp;</div>
			<div class="profile-normal-box">
				<p>Be a member of <strong>Networkwe</strong> and you will find lots of job opportunities, make connections, write tweets and so on.
				</p>
				<div class="login-indicating-arrow"><img src="<?php echo MEDIA_URL ?>/img/login_indicating_arrow.png" width="90" height="33"/></div>
				<a href="javascript:;" onclick="startIntro();" class="viewprofile current">Apply</a>

				<div class="clear"></div>
			</div>
			
			<div style="padding:10px;">
				<div class="marginbottom10">
					<h1><?php echo "Job Specification ";?></h1>
				</div>
				<div class="post-wall">
					<ul class="lft" style="float:left;width:300px;">
						<?php 
						if($jobDetail['JS']['vacancies']){ 
							echo "<li><strong>Number of Vacancies</strong>: <span>".$jobDetail['JS']['vacancies']."</span></li>";
						}
						if($jobDetail['JT']['type']){
							echo "<li><strong>Job Type</strong>: <span>".$jobDetail['JT']['type']."</span></li>";
						}
						if(($jobDetail['JS']['min_experience']) || ($jobDetail['JS']['max_experience'])){
							echo "<li><strong>Experience</strong>: <span>".$jobDetail['JS']['min_experience']." to ".$jobDetail['JS']['max_experience']." years</span></li>";
						}
						if($jobDetail['FA']['title']){ 
							echo "<li><strong>Functional Area</strong>: <span>".$jobDetail['FA']['title']."</span></li>";
						}
						if($jobDetail['JS']['title']){
							echo "<li><strong>Job Role</strong>: <span>".$jobDetail['JS']['title']."</span></li>";
						}
						?>					
					</ul>
					<ul class="rgt"  style="float:right;width:300px;">
						<?php 
						if($jobDetail['JS']['qualifications']){ 
							echo "<li><strong>Qualification</strong>: <span>".$jobDetail['JS']['qualifications']."</span></li>";
						}
						if($salary){
							echo "<li><strong>Offered Salary</strong>: <span>".$salary."</span></li>";
						}
						if($jobDetail['JS']['expiry_date']){
							echo "<li><strong>Expiry Date</strong>: <span>".date('M d, Y',strtotime($jobDetail['JS']['expiry_date']))."</span></li>";
						}
						if($jobDetail['NA']['name']){ 
							echo "<li><strong>Nationality</strong>: <span>".$jobDetail['NA']['name']."</span></li>";
						}
						?>
						<li><strong>Location</strong>: <span><?php echo $jobDetail['JS']['city']."&nbsp;".$jobDetail['COU']['name']; ?></span></li>
				   </ul>
						
					<div class="clear"></div>
				</div>
				<div class="marginbottom10">
					<h1><?php echo "Job Description ";?></h1>
				</div>
				<div class="post-wall">
					<?php echo $jobDetail['JS']['description']; ?>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
		<?php endforeach;  ?>
		</div>
	</div>
</div>
	
	
</div>