<?php echo $this->element('Recruiter/breadcrumb'); ?>
<style>
	#exportApp {
		float:left;
		height:18px;
		margin:-1px 2px 0;
	}
</style>
<div class="row-fluid sortable" id="ser">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Job Applications</h2>
	    <div class="box-icon">
			<form action="/recruiter/jobApplications/" name="exportApp" id="exportApp" method="POST">
				<input type="submit" name="submit" value="Export List" class="btn btn-small btn-primary" />
			</form>
			<a href="/recruiter/jobs" class="btn btn-round"><i class="icon-th-list"></i></a>
			<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
	    </div>
	</div>
	
	<div class="box-content" style="padding-top:10px;">
		
	   <table class="table table-striped table-bordered bootstrap-datatable datatable">
			<thead>
				<tr>
					<th>Applied By</th>
					<th>Application Date</th>
					<th>Job Title</th>
					<th>Job Code</th>
					<th>Job Expiry Date</th>
					<th>Employer</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php				

			
			foreach ($jobApp as $data):	
				$expirydate = date('Y-m-d H:i:s',strtotime($data['JS']['expiry_date'])); 
				$today = date('Y-m-d H:i:s');
				if($expirydate<$today){
					
					$expire = '<span class="label label-danger">Expired!</span>';
				}else{
					$expire = " ";
				}
			?>
				<tr>
					<td><?php echo $this->Html->link($data['UP']['firstname'].'&nbsp;'.$data['UP']['lastname'],'/users_profiles/userprofile/'.$data['JA']['user_id'],array('escape'=>false,'target'=>'blank'))."<br/>".$data['UP']['city']."&nbsp;".$data['UPCY']['name']; ?></td>
					<td><?php echo date('M d Y',strtotime($data['JA']['modified'])); ?></td>
					<td><?php echo "<b>".$data['JS']['title']."</b><br/>".$data['JS']['city']."&nbsp;".$data['JSCY']['name']; ?></td>
					<td><?php echo $data['JS']['job_code']; ?></td>
					<td><?php echo date('M d Y',strtotime($data['JS']['expiry_date']))."<br/>".$expire; ?></td>
					<td><?php echo $this->Html->link($data['EMP']['title'],'/companies/view/'.$data['EMP']['id'],array('escape'=>false,'target'=>'blank')); ?></td>
					<td class="center">
						
						<?php
						if ($data['JA']['status'] == 3) {
							echo '<button class="btn btn-info"><i class="icon-flag icon-white"></i> Short listed</button>';
						} else if ($data['JA']['status'] == 4) {
							echo '<button class="btn btn-inverse"><i class="icon-eye-open icon-white"></i> Interviewed</button>';
						} else if ($data['JA']['status'] == 5) {
							echo '<button class="btn btn-success"><i class="icon-gift icon-white"></i> Offered</button>';
						}
						else if ($data['JA']['status'] == 6) {
							echo '<button class="btn btn-danger"><i class="icon-thumbs-down icon-white"></i> Rejected</button>';
						}else {
							echo '<button class="btn btn-info"><i class="icon-star icon-white"></i> No Action Taken</button>';
						}
						?>
						
					</td>
					<td class="center" nowrap>
						<?php
						echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-zoom-in')) . " View", '#', array('onclick'=>'jobview(this);','value'=>$data['JA']['id'],'class' => 'btn btn', 'escape' => false));
						echo "&nbsp;";
						$url = JOBS_URL.'/files/resume/'.$data['JA']['cv'];
						$datafile=file_get_contents($url);
						if(!empty($data['JA']['cv'])){
						if($datafile)
							echo $this->Html->link(
								$this->Html->tag('i', '', array('class' => 'icon-download-alt')) . " Download CV", '/recruiter/downloadcv/'.$data['JA']['cv'], array('class' => 'btn', 'escape' => false)
							);
						}else{
							echo 'CV Not Found!';
						}
						?>
					</td>
				</tr>
			<?php endforeach; ?>

			</tbody>
	    </table>
	</div>
    </div><!--/span-->

</div><!--/row-->
<?php echo $this->Html->Script('jquery.min'); ?>
<script type="text/javascript">
	function jobview(e){
		var appid = e.getAttribute("value");
		
		$("#ser").html("<div class='box-content' style='min-height:400px;'><img src='../../ajax-loader.gif' style='margin:200px 0px 0px 400px;' alt='Searching' /></div>");
		$.ajax({
			url     : '/recruiter/jobApplicationView',
			type    : 'POST',
			cache: false,
			data    : {appid: appid},
			success : function(data){
				
				 $("#ser").html(data);
              },
			 error : function(data) {
			   $("#ser").html("there is error");
			}
          });
    
    
	}
	
	
</script>



 