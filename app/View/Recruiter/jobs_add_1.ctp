<?php echo $this->element('Recruiter/breadcrumb'); ?>
<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-edit"></i> Add New Job</h2>

	    <div class="box-icon">
			<a title="List" href="/recruiter/jobs/" style="width:25px;"><img alt="Add" src="/alaxos/img/toolbar/list.png"></a>
	    </div>
	</div>


<div class="box-content"><br/>

<!--
	<div class="progress progress-info progress-striped" style="width:60%;">
			<div class="bar" style="width: 20%">20% Completed</div>
			</div>-->

		<ul class="nav nav-tabs" id="jobTab">
			<li class="active"><a href="#step_1" id="job_step_1">Job Information</a></li>
			<li><a href="#step_2" id="job_step_2">Candidate Requirements</a></li>
			<li><a href="#step_3" id="job_step_3">Job Settings</a></li>
			<li><a href="#step_4" id="job_step_4">"Application Received" Email Settings</a></li>
			<li><a href="#step_5" id="job_step_5">Contact Information</a></li>					
	    </ul>		

		 <div id="jobTabContent" class="tab-content">
 			<?php echo $this->element('Recruiter/add_step_1'); ?>
		    <?php echo $this->element('Recruiter/add_step_2'); ?>
			<?php echo $this->element('Recruiter/add_step_3'); ?>
			<?php echo $this->element('Recruiter/add_step_4'); ?>
			<?php echo $this->element('Recruiter/add_step_5'); ?>
		 </div>
		<input type="hidden" id="job_id" value="0">
		<input type="hidden" id="current_tab" value="job_step_1">
	    
	</div>


    </div>
</div>





