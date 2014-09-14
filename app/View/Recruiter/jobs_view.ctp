<?php echo $this->element('Recruiter/breadcrumb'); ?>
<?php //pr($jobData); ?>
<div class="row-fluid sortable" id="ser">
    <div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-zoom-in"></i> View Job</h2>
			<div class="box-icon">
				<!--a title="Add" href="/recruiter/jobs_add" class="btn btn-small btn-primary" style="width:60px;">Add jobs</a-->
				<a href="/recruiter/jobs" class="btn btn-round"><i class="icon-th-list"></i></a>
				<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
			</div>			
		</div>
		<div class="box-content"><br/>
			<div id="jobTabContent" class="tab-content">
				
				<?php echo $this->Html->Image(JOBS_URL.'/img/company_logos/'.$jobData['Company']['logo'],array('style'=>'width:100px;float:left;margin:10px;border:1px solid #ddd;')); ?>
				<div style="float:left;margin:5px;">
					<h2><?php echo $jobData['Job']['title'] ?></h2>
					<p><?php echo $this->Html->link($jobData['Company']['title'],'#',array('escape'=>false)); ?>&nbsp;-&nbsp;<?php echo $jobData['Job']['city'].'&nbsp;'.$jobData['Country']['name']; ?></p>
					<p><?php echo 'Posted on: '.date('M d Y',strtotime($jobData['Job']['modified'])); ?></p>
					<div class="btn-group" style="float:left;">
						
						<?php
						if($jobData['Job']['status'] == 2){
							echo '<button class="btn btn-info"><i class="icon-star icon-white"></i> Active</button>';
						}else if($jobData['Job']['status'] == 3) {
							echo '<button class="btn btn-warning"><i class="icon-pause icon-white"></i> Hold</button>';
						}elseif ($jobData['Job']['status'] == 4) {
							echo '<button class="btn btn-success"><i class="icon-gift icon-white"></i> Completed</button>';
						}else{
							echo '<button class="btn btn-danger"><i class="icon-remove icon-white"></i> In Active</button>';
						}
						?>
						
						<button class="btn btn-small dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li><a href="#" onclick="jobview(this);" value="2"><i class="icon-star"></i> Active</a></li>
							<li><a href="#" onclick="jobview(this);" value="3"><i class="icon-pause"></i> Hold</a></li>
							<li><a href="#" onclick="jobview(this);" value="4"><i class="icon-gift"></i> Completed</a></li>
							<li class="divider"></li>
							<li><a href="#" onclick="jobview(this);" value="0"><i class="icon-remove"></i> In Active</a></li>
						</ul>
					</div>
                                        &nbsp;
                                        <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-pencil icon-white')) . " Edit", array('action' => 'jobs_edit', $jobData['Job']['id']), array('class' => 'btn btn-primary', 'escape' => false));?>
					<div id="msg"></div>
				</div>
				<div class="clear"></div>
				<div class="box-content">
					<?php 
						$expirydate = date('Y-m-d H:i:s',strtotime($jobData['Job']['expiry_date'])); 
						$today = date('Y-m-d H:i:s');
					?>
					<ul class="dashboard-list" style="border:1px solid #ddd;padding:5px;width:30%;float:left;">
						<?php 
							echo "<li><strong>City : </strong>".$jobData['Job']['city'].',&nbsp;'.$jobData['Country']['name'].'</li>';
							echo "<li><strong>Job Code : </strong>".$jobData['Job']['job_code'].'</li>';
							echo "<li><strong>Experience : </strong>".$jobData['Job']['min_experience']." - ".$jobData['Job']['max_experience']." years".'</li>';
							if($expirydate>$today){
								echo "<li><strong>Expiry Date : </strong>".date('M d Y',strtotime($jobData['Job']['expiry_date'])).'</li>';
							}else{
								echo "<li><strong>Expiry Date : </strong>".date('M d Y',strtotime($jobData['Job']['expiry_date'])).'&nbsp;<span class="label label-danger">Expired!</span>'.'</li>';
							}
						 ?>				   
					</ul>
					<ul class="dashboard-list" style="border:1px solid #ddd;padding:5px;width:50%;float:left;margin-left:10px;">
						<?php 
							echo "<li><strong>Company Title : </strong>".$jobData['Company']['title'].'</li>';
							echo "<li><strong>Company City : </strong>".$jobData['Company']['city'].'</li>';
							echo "<li><strong>Company Address : </strong>".$jobData['Company']['address'].'</li>';
							echo "<li><strong>Company Website : </strong>".$jobData['Company']['weburl'].'</li>';
							

						 ?>				   
					</ul>
					<div style="clear:both;">&nbsp;</div>
					<p style="border:1px solid #ddd;padding:5px;width:100%;"><?php echo $jobData['Job']['description']; ?></p>
			    </div>
				<input type="hidden" value="<?php echo $jobData['Job']['id']; ?>" id="jobid"/>
			 </div>
		
		</div>


    </div>
</div>
<?php echo $this->Html->Script('jquery.min'); ?>
<script type="text/javascript">
	function jobview(e){
		var jobstatus = e.getAttribute("value");
		var jobid = document.getElementById("jobid").value;
		//alert(jobstatus+jobid);
		$("#ser").html("<div class='box-content' style='min-height:400px;'><img src='" + media + "/img/loading.gif' style='margin:200px 0px 0px 400px;' alt='Searching' /></div>");
		$.ajax({
			url     : '/recruiter/jobsStatusChange/',
			type    : 'POST',
			cache: false,
			data    : {jobstatus: jobstatus,jobid:jobid},
			success : function(data){
				$("#ser").html(data);
              },
			 error : function(data) {
			   $("#ser").html("there is error");
			}
          });
    
	}
	
</script>




