<div class="row-fluid sortable" id="ser">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Job Applications</h2>
	    <div class="box-icon">
			<a href="/recruiter/jobApplications" class="btn btn-round"><i class="icon-th-list"></i></a>
			<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
	    </div>
	</div>
	
	<div class="box-content" style="padding-top:10px;">
		<div id="jobTabContent" class="tab-content">
				
				<?php echo $this->Html->Image('/files/users/'.$jobData['Users_profile']['photo'],array('style'=>'width:100px;float:left;margin:10px;border:1px solid #ddd;')); ?>
				<div style="float:left;margin:5px;">
					<h2><?php echo $jobData['Users_profile']['firstname'].'&nbsp;'.$jobData['Users_profile']['lastname'] ?></h2>
					<p><?php echo $jobData['Users_profile']['tags']; ?></p>
					<div style="float:left;width:170px;">
						<?php 
							$url = JOBS_URL.'/files/resume/'.$jobData['jobs_application']['cv'];
							$datafile=file_get_contents($url);
							if(!empty($jobData['jobs_application']['cv'])){
							if($datafile)
								echo $this->Html->link(
									$this->Html->tag('i', '', array('class' => 'icon-download-alt')) . " Download CV", '/recruiter/downloadcv/'.$jobData['jobs_application']['cv'], array('class' => 'btn', 'escape' => false)
								);
							}else{
								echo 'CV Not Found!';
							}
						?>
					</div>
					<div class="btn-group" style="float:left;">
						
						<?php
						if ($jobData['jobs_application']['status'] == 3) {
							echo '<button class="btn btn-info"><i class="icon-flag icon-white"></i> Short listed</button>';
						} else if ($jobData['jobs_application']['status'] == 4) {
							echo '<button class="btn btn-inverse"><i class="icon-eye-open icon-white"></i> Interviewed</button>';
						} else if ($jobData['jobs_application']['status'] == 5) {
							echo '<button class="btn btn-success"><i class="icon-gift icon-white"></i> Offered</button>';
						}
						else if ($jobData['jobs_application']['status'] == 6) {
							echo '<button class="btn btn-danger"><i class="icon-thumbs-down icon-white"></i> Rejected</button>';
						}else {
							echo '<button class="btn btn-info"><i class="icon-star icon-white"></i> No Action Taken</button>';
						}
						?>
						
						<button class="btn btn-small dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li><a href="#" onclick="jobview(this);" value="2"><i class="icon-star"></i> Active</a></li>
							<li><a href="#" onclick="jobview(this);" value="3"><i class="icon-flag"></i> Shortlisted</a></li>
							<li><a href="#" onclick="jobview(this);" value="4"><i class="icon-eye-open"></i> Interviewed</a></li>
							<li><a href="#" onclick="jobview(this);" value="5"><i class="icon-gift"></i> Offered</a></li>
							<li class="divider"></li>
							<li><a href="#" onclick="jobview(this);" value="6"><i class="icon-thumbs-down"></i> Rejected</a></li>
						</ul>
					</div>
				</div>
				<div class="clear"></div>
				<div class="box-content">
					
					<ul class="dashboard-list" style="border:1px solid #ddd;padding:5px;width:30%;float:left;">
						<?php 
							echo "<li><strong>User Email : </strong>".$jobData['User']['email'].'</li>';
							echo "<li><strong>User Mobile : </strong>".$jobData['Users_profile']['mobile'].'</li>';
							echo "<li><strong>User City : </strong>".$jobData['Users_profile']['city'].'</li>';
							echo '<li><strong>User Availability : </strong><span class="label">'.$jobData['Users_profile']['availability_type'].'</span></li>';
						 ?>				   
					</ul>
					<ul class="dashboard-list" style="border:1px solid #ddd;padding:5px;width:30%;float:left;margin-left:10px;">
						<?php 
							echo "<li><strong>Job Title : </strong>".$jobData['Job']['title'].'</li>';
							echo "<li><strong>Job Code : </strong>".$jobData['Job']['job_code'].'</li>';
							echo "<li><strong>Job City : </strong>".$jobData['Job']['city'].'&nbsp;'.$jobData['Country']['name'].'</li>';
							echo "<li><strong>Job Expiring : </strong>".date('M d Y',strtotime($jobData['Job']['expiry_date'])).'</li>';					
						 ?>				   
					</ul>
					<div style="clear:both;">&nbsp;</div>
					<p style="border:1px solid #ddd;padding:5px;width:100%;">
						<strong>Cover Letter </strong><br/>
						<?php echo $jobData['jobs_application']['cover_letter']; ?>
					</p>
					
					<div style="border:1px solid #ddd;padding:5px;width:100%;">
						<strong>Summary </strong><br/>
						<?php echo $jobData['Users_profile']['summary']; ?>
						<div style="clear:both;"></div>
					</div>
			    </div>
				<input type="hidden" value="<?php echo $jobData['jobs_application']['id']; ?>" id="appid"/>
			 </div>
	</div>
    </div><!--/span-->

</div><!--/row-->
<?php echo $this->Html->Script('jquery.min'); ?>
<script type="text/javascript">
	function jobview(e){

		var appid = document.getElementById("appid").value;
		var appstatus = e.getAttribute("value");
		
		//alert(appid);
		$("#ser").html("<div class='box-content' style='min-height:400px;'><img src='../../ajax-loader.gif' style='margin:200px 0px 0px 400px;' alt='Searching' /></div>");
		$.ajax({
			url     : '/recruiter/jobApplicationView',
			type    : 'POST',
			cache: false,
			data    : {appstatus: appstatus,appid: appid},
			success : function(data){
				
				 $("#ser").html(data);
              },
			 error : function(data) {
			   $("#ser").html("there is error");
			}
          });
    
		
	}
	
</script>


 