<?php
$this->Html->addCrumb(' Dashboard', '/recruiter');
$this->Html->addCrumb(' Jobs', array('controller' => 'recruiter', 'action' => 'jobs'));
if($this->request->params['pass'][0])
    $this->Html->addCrumb(' ' . Inflector::humanize($this->request->params['pass'][0]), array('controller' => 'recruiter', 'action' => 'jobs', $this->request->params['pass'][0]));
echo $this->element('Recruiter/breadcrumb'); ?>

<?php //echo "<pre>"; print_r($jobs); echo "</pre>";
// echo "<pre>"; print_r($this->Session->read()); echo "</pre>";
//echo $this->Session->read('company_id');
?>
<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Jobs Board</h2>
            <div class="box-icon">
                <a href="<?php echo NETWORKWE_URL?>/recruiter/jobs_add" class="btn span"><i class="icon-plus icon-dark"></i> Add Job</a>
	    </div>
	</div>
	<div class="box-content">
            <?php if($jobs): ?>
	    <table class="table table-striped table-bordered bootstrap-datatable datatable">
		<thead>
		    <tr>
			<th>Job Title</th>
			<th>Experience</th>
			<th>Start Date</th>
			<th>End Date</th>
			<?php if($this->request->params['pass'][0] == 'expired'):?>
                        <th>Status</th>
                        <?php endif; ?>
                        <th>Actions</th>
		    </tr>
		</thead>
		<tbody>
		    <?php  foreach ($jobs as $data): ?>
    		    <tr>
                        <td>
                            <b><?php echo $this->Html->link($data['Job']['title'], array('action' => 'jobs_view', $data['Job']['id'])); ?></b><br/>
                            <span class="muted"><b><?php echo $data['Company']['title']; ?></b> - <?php echo ($data['Job']['city'])? $data['Job']['city']."<br/>":"" . $data['Country']['name']; ?></span>
                        </td>
			<td><?php echo $data['Job']['min_experience']." - ".$data['Job']['max_experience']." years"; ?></td>
			<td><?php  echo date("M d, Y", strtotime($data['Job']['start_date'])); // echo  DateTool :: sql_to_date($data['Job']['start_date']); ?></td>
    			<td><?php echo date("M d, Y", strtotime($data['Job']['expiry_date'])); //echo DateTool :: sql_to_date($data['Job']['expiry_date']); ?></td>
                        <?php if($this->request->params['pass'][0] == 'expired'):?>
    			<td class="center">
                            <?php if ($data['Job']['status'] == 2) {
                                echo '<span class="label label-success">Active</span>';
                            } else if ($data['Job']['status'] == -1) {
                                echo '<span class="label label-important">Deleted</span>';
                            } else if ($data['Job']['status'] == 1) {
                                echo '<span class="label label-warning">Pending</span>';
                            } else {
                                echo '<span class="label">In Active</span>';
                            } ?>
    			</td>
                        <?php endif; ?>
    			<td class="center" nowrap>
                                <div class="btn-group" style="float:left;">
                                    <button class="btn btn-info btn-small dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-th-list icon-white"></i> Options <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-user icon-dark')) . " View Matching Candidates", array('action' => 'candidates', $data['Job']['id']), array('class' => '', 'escape' => false)); ?></li>
                                        <li class="divider"></li>
                                        <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-user icon-dark')) . " View Job Applications", array('action' => 'jobApplications', $data['Job']['id']), array('class' => '', 'escape' => false)); ?></li>
                                    </ul>
                                </div>
				<?php
                                echo "&nbsp;";
				echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-list-alt icon-white')) . " ", array('action' => 'jobs_view', $data['Job']['id']), array('class' => 'btn btn-success', 'escape' => false)
				);
                                if($this->request->params['pass'][0] != 'deleted'){
                                    echo "&nbsp;";
                                    echo $this->Html->link(
                                            $this->Html->tag('i', '', array('class' => 'icon-pencil icon-white')) . " ", array('action' => 'jobs_edit', $data['Job']['id']), array('class' => 'btn btn-info', 'escape' => false)
                                    );
                                    echo "&nbsp;";
                                    echo $this->Html->link(
                                            $this->Html->tag('i', '', array('class' => 'icon-trash icon-white')) . " ", array('action' => 'jobs_delete', $data['Job']['id']), array('class' => 'btn btn-danger', 'escape' => false), "Are you sure you wish to delete this member?"
                                    );
                                }
				?>
    			</td>
    		    </tr>
		    <?php endforeach; ?>
		</tbody>
	    </table>
            <?php else: ?>
            <br/>
            <div class="span22">
                <h3>No jobs found!</h3>
                <p>Cannot find any jobs.</p>
            </div>
            <div class="clear"></div>
            <?php endif; ?>
	</div>
    </div><!--/span-->

</div><!--/row-->