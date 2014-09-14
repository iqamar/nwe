<div class="sortable row-fluid">
    <a data-rel="tooltip" title="<?php echo $total_jobs; ?> new jobs." class="well span3 top-block" href="<?php echo $this->request->base ?>/recruiter/jobs/">
	<div>Total Jobs</div>
	<div><?php echo $total_jobs; ?></div>
	<span class="notification"><?php echo $total_jobs; ?></span>
    </a>

    <a data-rel="tooltip" title="<?php echo $total_company_users; ?> new executives." class="well span3 top-block" href="<?php echo $this->request->base ?>/recruiter/users">
	<div>Total Executives</div>
	<div><?php echo $total_company_users; ?></div>
	<span class="notification green"><?php echo $total_company_users; ?></span>
    </a>
	<?php if($total_applications){ ?>
    <a data-rel="tooltip" title="<?php echo $total_applications; ?> job application" class="well span3 top-block" href="<?php echo $this->request->base ?>/recruiter/jobApplications">
	<div>Job Application</div>
	<div><?php echo $total_applications; ?></div>
	<span class="notification yellow"><?php echo $total_applications; ?></span>
    </a>
	<?php } if($jobs_reffered){ ?>
    <a data-rel="tooltip" title="<?php echo $jobs_reffered; ?> jobs forwarded." class="well span3 top-block" href="<?php echo $this->request->base ?>/recruiter/referredJobs/">
	<div>Jobs Referred</div>
	<div><?php echo $jobs_reffered; ?></div>
	<span class="notification red"><?php echo $jobs_reffered; ?></span>
    </a>
	<?php } ?>
</div>