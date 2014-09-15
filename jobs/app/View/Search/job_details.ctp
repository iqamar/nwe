<style>
.error{color:red;}

.jobunsave-bttn {
    background: url("<?php echo MEDIA_URL;?>/img/icon-unsave.png") no-repeat scroll left center #6DA462;
    color: #FFFFFF;
    float: left;
    font-size: 13px;
    font-weight: bold;
    margin-left: 6px;
    padding: 5px 12px 5px 22px;
}

.jobsave-bttn {
	background: url("<?php echo MEDIA_URL;?>/img/icon-save.png") no-repeat scroll left center #C70000 !important;
	color: #FFFFFF !important;
	float: left !important;
	font-size: 13px !important;
	font-weight: bold !important;
	margin-left: 6px !important;
	padding: 5px 12px 5px 22px !important;
}
</style>
<?php
echo $this->Html->css(array(MEDIA_URL . '/css/jquery.share.css'));
echo $this->Html->script(array(MEDIA_URL . '/js/jquery.share.js',MEDIA_URL . '/js/jquery.validate.js'));
?>
<?php 
	if (empty($userInfo)) {
		$userInfo['users']['id'] = '';
	}
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
                
        echo $this->Html->meta(array('property' => 'og:image', 'content' => MEDIA_URL . '/files/company/original/' . $company_logo),'',array('inline'=>false));
        echo $this->Html->meta(array('property' => 'og:title', 'content' => $jobDetail['JS']['title']),'',array('inline'=>false));
        echo $this->Html->meta(array('property' => 'og:type', 'content' => 'article'),'',array('inline'=>false));
        echo $this->Html->meta(array('property' => 'og:article:author', 'content' => 'www.networkwe.com'),'',array('inline'=>false));
        echo $this->Html->meta(array('property' => 'og:article:published_time', 'content' => $this->Time->timeAgoInWords($pdate)),'',array('inline'=>false));
        echo $this->Html->meta(array('property' => 'og:description', 'content' => strip_tags($jobDetail['JS']['description'])),'',array('inline'=>false));
	?>
	<script>
		$(function() {
			$('#social_share').share({
				networks: ['facebook','twitter','linkedin','pinterest','tumblr','googleplus','digg','stumbleupon','email'],
				orientation: 'vertical',
				affix: 'left center',
				pageTitle: '<?=$jobDetail['JS']['title']?>',
				theme: 'square'
			});
		});
	</script>
	<div id="social_share"></div>
	<div class="flash flash_success" id="savedJob" style="display:none;"><?php echo $this->Session->flash(); ?></div>
	
	<?php $jobsSaved = $this->requestAction('/search/checkSavedJob/');  ?>
	

	<div class="box">
		<div class="jobdetails">
			<div class="jobdetails-bttn" > 
				
				<?php if($jobDetail['JS']['remote_website_url']){ ?>
					<a target="blank" href="<?php echo $jobDetail['JS']['remote_website_url']; ?>" class="apply">Apply on company website</a>
				<?php }else{ ?>
					<a href="#?" rel="applyforjob" class="poplight apply">Apply for Job</a>
				<?php } ?>
				<a href="#?" rel="sendtofriend" class="poplight sendtofriend">Send To Friend</a>
				 <?php 
					$listing ="&nbsp;&nbsp;<span id='sj_".$jobDetail['JS']['id']."'>";
					if(in_array($jobDetail['JS']['id'],$jobsSaved)){
						$listing.="<a href='#' onclick='jobunsave(this);' value=".$jobDetail['JS']['id']." class='jobunsave-bttn' id='savejob_".$jobDetail['JS']['id']."'>Unsave</a>&nbsp;";
					}else{
						$listing.="<a href='#' onclick='jobsave(this);' value=".$jobDetail['JS']['id']." class='jobsave-bttn' id='savejob_".$jobDetail['JS']['id']."'>Save</a>&nbsp;";
					}
					$listing.="</span>&nbsp;<input type='hidden' id='user_id' value='".$userInfo['users']['id']."' />";
					echo $listing;
					$currentUrl=$this->Html->url(null, true);
				 ?>
				 <div id="jobshare"> 
					<ul>
						<li class="has-sub"> 
							<a class="sharejob" href="">Share</a>
							<ul>
								<li><a href="#" value="<?php echo $jobDetail['JS']['id']; ?>" onclick="shareJob(this);"><span class="jobshare_networkwe"></span>Share on NetworkWE</a></li>
								<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $currentUrl; ?>" target="blank"><span class="jobshare_fb"></span>Share on Facebook</a></li>
								<li><a href="https://twitter.com/share" data-via="networkwe" target="blank"><span class="jobshare_twitter"></span>Share on Twitter</a></li>	
								<li><?php echo "<a href='http://www.linkedin.com/shareArticle?mini=true&url=".$currentUrl."&title=".$jobDetail['JS']['title']."&summary=&source=Networkwe' target='blank' rel='nofollow'><span class='jobshare_linkedin'></span>Share on Linkedin</a>"; ?></li>	
								<li><a href="http://pinterest.com/pin/create/button/?url=<?php echo $currentUrl; ?>" target="blank"><span class="jobshare_pinterest"></span>Share on Pinterest</a></li>
								<li><a href="http://www.tumblr.com/share?v=3&u=<?php echo $currentUrl; ?>" target="blank"><span class="jobshare_tumblr"></span>Share on Tumblr</a></li>
								<li><a href="https://plusone.google.com/_/+1/confirm?hl=en&url=<?php echo $currentUrl; ?>" target="blank"><span class="jobshare_gplus"></span>Share on Google+</a></li>
								<li><a href="http://digg.com/submit?url=<?php echo $currentUrl; ?>"><span class="jobshare_digg" target="blank"></span>Share on Digg</a></li>
								<li><a href="http://www.stumbleupon.com/submit?url=<?php echo $currentUrl; ?>" target="blank"><span class="jobshare_stumbleupon"></span>Share on Stumbleupon</a></li>
							</ul>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


						  </li>
					</ul>
				   </div>
				<div id="joboption">
					<ul>
						<li class="has-sub"> 
							<a href="">More Options</a>
							<ul>
								<li><?php echo $this->Html->link('Similar Jobs',array('controller'=>'search','action'=>'index/'.$urlid['Job']['id'].'/'.$urlid['Job']['title']),array('escape'=>false)); ?></li>
								<li><?php echo $this->Html->link('Jobs by this Recruiter',array('controller'=>'search','action'=>'jobs_by_company/'.$jobDetail['CO']['id'].'/'.$jobDetail['CO']['title']),array('escape'=>false)); ?></li>
							</ul>
					  </li>
					</ul>
				</div>
				
		   </div>
			<div class="clear"></div>
			<div class="jobdetail-toparea">
				<div class="jobdetails-logo">
					<?php echo $this->Html->link($this->Html->Image($company_logo),NETWORKWE_URL.'/companies/view/'.$jobDetail['CO']['id'],array('escape'=>false)); ?>
				</div>
				<ul>
					<li>
						<h1><?php echo $this->Html->link($jobDetail['JS']['title'],'#',array('escape'=>false)); ?></h1>
					</li>
					<li>Location: <span class="location"><?php echo $jobDetail['JS']['city']."&nbsp;".$jobDetail['COU']['name']; ?></span> </li>
					<li><span class="postedon">Posted On: <?php echo $this->Time->timeAgoInWords($pdate); ?></span></li>
				</ul>
				<div class="clear"></div>
			</div>
			<div class="jobdetails-box jobdetails-style">
				<div class="greybox-div-heading">
					<h1>Job Specification</h1>
				</div>
				<div>
					<ul class="lft">
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
						?>					
					</ul>
					<ul class="rgt">
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
						?>
				   </ul>
				</div>
				<div class="clear"></div>
			</div>
			<div class="jobdetails-box jobdetails-style">
				<div class="greybox-div-heading">
					<h1>Job Summary </h1>
				</div>
				<div>
					<ul class="lft">
						<?php 
						if($jobDetail['FA']['title']){ 
							echo "<li><strong>Functional Area</strong>: <span>".$jobDetail['FA']['title']."</span></li>";
						}
						if($jobDetail['JS']['title']){
							echo "<li><strong>Job Role</strong>: <span>".$jobDetail['JS']['title']."</span></li>";
						}						
						?>
					</ul>
					<ul class="rgt">
						<?php 
						if($jobDetail['NA']['name']){ 
							echo "<li><strong>Nationality</strong>: <span>".$jobDetail['NA']['name']."</span></li>";
						}
						?>
						<li><strong>Location</strong>: <span><?php echo $jobDetail['JS']['city']."&nbsp;".$jobDetail['COU']['name']; ?></span></li>
					</ul>
				</div>
				<div class="clear"></div>
			</div>
			<div class="jobdetails-box">
				<div class="greybox-div-heading">
					<h1>Job Description </h1>
				</div>
				<div>
					<div itemprop="description">
						<?php echo $jobDetail['JS']['description']; ?>
						<div class="clear"></div>
					</div>
				</div>
				<div class="clear"></div>
			</div> 
			<div class="clear"></div>
			<div id="footer-jobbttns">
			<div class="jobdetails-bttn"> 
				<?php if($jobDetail['JS']['remote_website_url']){ ?>
					<a target="blank" href="<?php echo $jobDetail['JS']['remote_website_url']; ?>" class="apply">Apply on company website</a>
				<?php }else{ ?>
					<a href="#?" rel="applyforjob" class="poplight apply">Apply for Job</a>
				<?php } ?>
				<a href="#?" rel="sendtofriend" class="poplight sendtofriend">Send To Friend</a>
				<?php 
					$listing ="&nbsp;&nbsp;<span id='sj_".$jobDetail['JS']['id']."'>";
					if(in_array($jobDetail['JS']['id'],$jobsSaved)){
						$listing.="<a href='#' onclick='jobunsave(this);' value=".$jobDetail['JS']['id']." class='jobunsave-bttn' id='savejob_".$jobDetail['JS']['id']."'>Unsave</a>&nbsp;";
					}else{
						$listing.="<a href='#' onclick='jobsave(this);' value=".$jobDetail['JS']['id']." class='jobsave-bttn' id='savejob_".$jobDetail['JS']['id']."'>Save</a>&nbsp;";
					}
					$listing.="</span>&nbsp;<input type='hidden' id='user_id' value='".$userInfo['users']['id']."' />";
					echo $listing;
				?>
				<div id="jobshare"> 
					<ul>
						<li class="has-sub"> 
							<a class="sharejob" href="">Share</a>
							<ul>
								<li><a href="#" value="<?php echo $jobDetail['JS']['id']; ?>" onclick="shareJob(this);"><span class="jobshare_networkwe"></span>Share on NetworkWE</a></li>
								<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $currentUrl; ?>" target="blank"><span class="jobshare_fb"></span>Share on Facebook</a></li>
								<li><a href="https://twitter.com/share" data-via="networkwe" target="blank"><span class="jobshare_twitter"></span>Share on Twitter</a></li>	
								<li><?php echo "<a href='http://www.linkedin.com/shareArticle?mini=true&url=".$currentUrl."&title=".$jobDetail['JS']['title']."&summary=&source=Networkwe' target='blank' rel='nofollow'><span class='jobshare_linkedin'></span>Share on Linkedin</a>"; ?></li>	
								<li><a href="http://pinterest.com/pin/create/button/?url=<?php echo $currentUrl; ?>" target="blank"><span class="jobshare_pinterest"></span>Share on Pinterest</a></li>
								<li><a href="http://www.tumblr.com/share?v=3&u=<?php echo $currentUrl; ?>" target="blank"><span class="jobshare_tumblr"></span>Share on Tumblr</a></li>
								<li><a href="https://plusone.google.com/_/+1/confirm?hl=en&url=<?php echo $currentUrl; ?>" target="blank"><span class="jobshare_gplus"></span>Share on Google+</a></li>
								<li><a href="http://digg.com/submit?url=<?php echo $currentUrl; ?>"><span class="jobshare_digg" target="blank"></span>Share on Digg</a></li>
								<li><a href="http://www.stumbleupon.com/submit?url=<?php echo $currentUrl; ?>" target="blank"><span class="jobshare_stumbleupon"></span>Share on Stumbleupon</a></li>
							</ul>
						  </li>
					</ul>
				   </div>
				<div id="joboption">
					<ul>
						<li class="has-sub"> 
							<a href="">More Options</a>
							<ul>
								<li><?php echo $this->Html->link('Similar Jobs',array('controller'=>'search','action'=>'index/'.$urlid['Job']['id'].'/'.$urlid['Job']['title']),array('escape'=>false)); ?></li>
								<li><?php echo $this->Html->link('Jobs by this Recruiter',array('controller'=>'search','action'=>'jobs_by_company/'.$jobDetail['CO']['id'].'/'.$jobDetail['CO']['title']),array('escape'=>false)); ?></li>
							</ul>
					  </li>
					</ul>
				</div>
				
			</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>

	<!-- Apply Jobs Start Here -->
	<div id="applyforjob" class="popup_block">
		<div class="userprofile-box">
			<div class="userprofile-box-pic">
				<?php 
					if($userInfo['users_profiles']['photo']){
						if(file_exists(MEDIA_PATH.'/files/user/thumbnail/'.$userInfo['users_profiles']['photo'])){
							$user_pic=MEDIA_URL.'/files/user/thumbnail/'.$userInfo['users_profiles']['photo'];
						}else{
							$user_pic=MEDIA_URL.'/img/nologo.jpg';
						}
					}else{
							$user_pic=MEDIA_URL.'/img/nologo.jpg';
					}
				echo $this->Html->Image($user_pic,array('class'=>'applyprofileimg')); ?>
			</div>
			<div class="userprofile-box-rgt">
				<ul>
					<li>
						<h1><?php echo $userInfo['users_profiles']['firstname']."&nbsp;".$userInfo['users_profiles']['lastname']; ?></h1>
					</li>
					<li><?php echo $userInfo['users_profiles']['tags']; ?></li>
					<?php if($userExperience){ ?>
						<li>Experience : <span class="redcolor"><?php foreach($userExperience as $row){echo $row['Company']['title'].'&nbsp;,&nbsp;';} ?></span></li>
					<?php } ?>
					
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		<?php echo $this->Form->create('jobsApplication',array('url'=>'/search/jobsApplication/'.$jobDetail['JS']['id'],'id'=>'applyJob','class'=>'userprofile-form','onSubmit'=>'return chkSize()','name'=>'applyJob','enctype'=>'multipart/form-data')); ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>Your Complete profile will be included with your application. if you want to Update your Profile <?php echo $this->Html->link('Click Here',NETWORKWE_URL.'/users_profiles/myprofile',array('escape'=>false)); ?></td>
			</tr>
			<tr>
				<td><strong>Email <span class="note-text">*</span></strong></td>
			</tr>
			<tr>
				<td><?php echo $this->Form->input('email',array('label'=>false,'type'=>'text','class'=>'textfield','size'=>60,' disabled','value'=>$userInfo['users']['email'])); ?></td>
			</tr>
			<tr>
				<td><strong>Cover Letter</strong></td>
			</tr>
			<tr>
				<td><?php echo $this->Form->input('cover_letter',array('label'=>false,'type'=>'file','id'=>'cover_letter','accept'=>'doc|docx|pdf')); ?></td>
			</tr>
			<tr>
				<td><span class="note-text">MS Word or PDF only (2MB maximum)</span></td>
			</tr>
			<tr>
				<td><strong>Resume <span class="note-text">*</span></strong></td>
			</tr>
			<tr>
				<td><?php echo $this->Form->input('resume',array('label'=>false,'type'=>'file','id'=>'resume','class'=>'required','accept'=>'doc|docx|pdf', 'div'=>false)); ?></td>
			</tr>
			<tr>
				<td><span class="note-text">MS Word or PDF only (2MB maximum)</span></td>
			</tr>
			<tr>
				<td>
				<?php 
					echo $this->Form->hidden('hidden',array('value'=>$jobDetail['JS']['id'],'name'=>'job_id','id'=>'job_id'));
					echo $this->Form->hidden('hidden',array('value'=>$userInfo['users']['id'],'id'=>'user_id','name'=>'user_id'));
					echo $this->Form->input('Apply Now',array('type'=>'submit','name'=>'Apply','class'=>'red-bttn','label'=>false));
				?>
				</td>
			</tr>
		</table>
		<?php echo $this->Form->end(); ?>
	
</div>
<!-- Apply Jobs Ends Here -->



<!-- Forward Jobs Start Here -->

<div id="sendtofriend" class="popup_block"><!--your content start-->
	
		<div class="userprofile-box">
			<div class="userprofile-box-pic">
				<?php 
					echo $this->Html->Image($company_logo); ?>
			</div>
			<div class="userprofile-box-rgt">
			<ul>
				<li>
					<h1><?php echo $jobDetail['JS']['title']; ?></h1>
				</li>
				<li>Location: <span class="location"><?php echo $jobDetail['JS']['city']."&nbsp;".$jobDetail['COU']['name']; ?></span> </li>
				<li><span class="postedon">Posted On: <?php echo $this->Time->timeAgoInWords($pdate); ?></span></li>
			</ul>
			</div>
			<div class="clear"></div>
		</div>
		<?php
		$yourEmail = $userInfo['users']['email'];
		$yourName = $userInfo['users_profiles']['firstname']." ".$userInfo['users_profiles']['lastname'];
		
		echo $this->Form->create('jobForward',array('url'=>'/search/jobForward/'.$jobDetail['JS']['id'],'id'=>'jobForward','name'=>'jobForward','class'=>'userprofile-form'));
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><strong>Your Name</strong></td>
			</tr>
			<tr>
				<td><?php echo $this->Form->input('yourname',array('label'=>false,'type'=>'text','class'=>'textfield','disabled','size'=>60,'value'=>$yourName)); ?></td>
			</tr>
			<tr>
				<td><strong>Email</strong></td>
			</tr>
			<tr>
				<td><?php  echo $this->Form->input('youremail',array('label'=>false,'class'=>'textfield','size'=>60,'disabled','type'=>'text','value'=>$yourEmail)); ?></td>
			</tr>
			<tr>
				<td><strong>Friend's Email</strong></td>
			</tr>
			<tr>
				<td><?php echo $this->Form->input('conEmail',array('label'=>false,'type'=>'text','id'=>'ms4','name'=>'ms4','style'=>'width:400px;','div'=>false)); ?></td>
			</tr>
			<tr>
				<td><strong>Other Emails</strong></td>
			</tr>
			<tr>
				<td><?php echo $this->Form->input('friendsEmail',array('label'=>false,'name'=>'friendsEmail','type'=>'textarea','cols'=>58,'rows'=>7,'class'=>'textfield')); ?></td>
			</tr>
			<tr>
				<td><span class="note-text">(add more email ids separated by comma)</span></td>
			</tr>
			<tr>
				<td>
				<?php 
					echo $this->Form->input('job_id',array('type'=>'hidden','value'=>$jobDetail['JS']['id'],'name'=>'job_id','id'=>'job_id'));
					echo $this->Form->input('Send Invites',array('type'=>'submit','name'=>'Send','class'=>'red-bttn','label'=>false));
					
				?>
				</td>
			</tr>
		</table>
		<?php echo $this->Form->end(); ?>
	
</div> <!--your content end-->

<!-- Forward Jobs Ends Here -->
<?php 
if(isset($userInfo))
{


$strstr = "";
if(!empty($con)){

foreach ($con as $key=>$index) {

	foreach($index as $users){
		//echo $users['User']['email'];
		$firstname = $users['Users_profile']['firstname'];
		$lastname = $users['Users_profile']['lastname'];
		$id = $users['Users_profile']['user_id'];
		$email = $users['User']['email'];
		//$strstr .= '"{id:'.$id .' ,label:'.$lastname.'}",';
		$strstr .= '{id:"'.$email.'",label:"'.$firstname.'&nbsp;'.$lastname.'"},';
	}
}
$strstr = trim($strstr, ",");
}
}else{
	$strstr = '';
}
?>
<script type="text/javascript">
$(document).ready(function() {
		
		var ms4 = $('#ms4').magicSuggest({
			
		data: [<?php echo $strstr; ?>],
		displayField: 'label',
		
		
		selectionStacked: true
		});
	
	
	 
	 
	$('#applyJob').validate();
	 
	 
		
});
function chkSize()
		{
		var resume=document.getElementById("resume").files[0];
		//var cover_letter=document.getElementById("cover_letter").files[0].size;
		if(resume){
			if((Math.round(resume.size)/(1024*1024)) > 2)
			{
					alert('Maximum file size is restricted to 2MB.Please try again Uploading other document!!');
					  return false;
					  
			}
		}
		var cover_letter=document.getElementById("cover_letter").files[0];
		if(cover_letter){
			if((Math.round(cover_letter.size)/(1024*1024)) > 2)
			{
				alert('Maximum file size is restricted to 2MB.Please try again Uploading other document!!');
				  return false;
				  
			}
		}
	
}
function shareJob(e){
		job_id = e.getAttribute("value");
		var user_id = document.getElementById("user_id").value;
		
		$("#savedJob").show();
		$("#savedJob").html("<img src='<?php echo MEDIA_URL?>/img/loading.gif' style='' alt='Saving' />");
		$.ajax({
			url     : '/search/shareJob/',
			type    : 'POST',
			cache: false,
			data    : {user_id: user_id,job_id:job_id},
			success : function(data){
			
				$("#savedJob").html(data);
				$(".flash").slideDown('slow').delay(2000).fadeOut();
              },
			 error : function(data) {
			   $("#savedJob").html("there is error");
			}
          });
    
	}
</script>

<?php endforeach;  ?>