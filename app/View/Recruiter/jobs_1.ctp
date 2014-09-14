<?php echo $this->element('Recruiter/breadcrumb'); ?>

<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Jobs Board</h2>
	    <div class="box-icon">
			<!--a title="Add" href="/recruiter/jobs_add" class="btn btn-small btn-primary" style="width:60px;">Add jobs</a-->
			<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
	    </div>
	</div>
	
	<div class="box-content" style="padding-top:10px;">
		
	   <table class="table table-striped table-bordered bootstrap-datatable datatable">
			<thead>
				<tr>
					<th>Job Title</th>
					<th>Employer</th>
					<th>Job Application</th>
					<th>Location</th>
					<th>Experience</th>
					<th>Posted On</th>
					<th>Expiring On</th>			
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php				

			$jobFinal = array();
		//	print_r($jobDataList);
			foreach ($jobDataList as $item2):	
			
				$job_id = $item2['Job']['id'];
				if (isset($jobFinal[$job_id])) {					
					$jobFinal[$job_id]['applications'] = $jobFinal[$job_id]['applications'] + 1; 
				}else{
					$jobFinal[$job_id]['Job'] = $item2['Job'];
					$jobFinal[$job_id]['Company'] = $item2['Company'];
					if(empty($item2['jobs_application']['id'])){	
						$jobFinal[$job_id]['applications'] = 0;
					}else{
						$jobFinal[$job_id]['applications'] = 1;
					}
				}						
				
			
			endforeach; 
			//pr($jobFinal);
			foreach ($jobFinal as $data){	
				
				$expirydate = date('Y-m-d H:i:s',strtotime($data['Job']['expiry_date'])); 
				$today = date('Y-m-d H:i:s');
				if($expirydate<$today){
					
					$expire = '<span class="label label-danger">Expired!</span>';
				}else{
					$expire = " ";
				}
					
			?>
				<tr>
					<td><?php echo "<b>".$data['Job']['title']."</b><br/>".$expire; ?></td>
					<td><?php echo $data['Company']['title']; ?></td>
					<td><?php if($data['applications']!=0){echo $this->Html->link($data['applications'],'/recruiter/jobApplications/'.$data['Job']['id'],array('escape'=>false,'class'=>'btn btn-inverse'));}else{echo $data['applications'];} ?></td>
					<td><?php echo $data['Job']['city']."<br/>".$data['Country']['name']; ?></td>
					<td><?php echo $data['Job']['min_experience']." - ".$data['Job']['max_experience']." years"; ?></td>	
					<td><?php echo date('M d Y',strtotime($data['Job']['start_date'])); ?></td>
					<td><?php echo date('M d Y',strtotime($data['Job']['expiry_date'])); ?></td>                  		
					<td>
						<?php
						if($data['Job']['status'] == 2){
							echo '<button class="btn btn-info"><i class="icon-star icon-white"></i> Active</button>';
						}else if($data['Job']['status'] == 3) {
							echo '<button class="btn btn-warning"><i class="icon-pause icon-white"></i> Hold</button>';
						}elseif ($data['Job']['status'] == 4) {
							echo '<button class="btn btn-success"><i class="icon-gift icon-white"></i> Completed</button>';
						}else{
							echo '<button class="btn btn-danger"><i class="icon-remove icon-white"></i> In Active</button>';
						}
						?>
					</td>
					<td class="center" nowrap>
						<?php
						echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-zoom-in')) . " View", array('controller'=>'recruiter','action' => 'jobs_view/'.$data['Job']['id']), array('class' => 'btn ', 'escape' => false));

						/*echo "&nbsp;";
						echo $this->Html->link(
							$this->Html->tag('i', '', array('class' => 'icon-edit icon-white')) . " Edit", array('action' => 'edit/'.$data['Job']['id']), array('class' => 'btn btn-info', 'escape' => false)
						);

						echo "&nbsp;";
						echo $this->Html->link(
							$this->Html->tag('i', '', array('class' => 'icon-trash icon-white')) . " Delete", array('action' => 'delete/'.$data['Job']['id']), array('class' => 'btn btn-danger', 'escape' => false), "Are you sure you wish to delete this member?"
						);*/
						?>
					</td>
				</tr>
			<?php } ?>

			</tbody>
	    </table>
	</div>
    </div><!--/span-->

</div><!--/row-->

 