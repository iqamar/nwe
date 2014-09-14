<?php echo $this->element('Recruiter/breadcrumb'); ?>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> Referred Jobs</h2>
            <div class="box-icon">
                <a href="#" class="btn btn-round"><i class="icon-th-list"></i></a>
            </div>
        </div>
        <div class="box-content" style="padding-top:10px;">
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Refer By</th>
                        <th>Refer To</th>
                        <th>Refer To Other</th>
                        <!--<th>Location</th>-->
                        <th>Referred at</th>
                        <!--<th>Start Date</th>
                        <th>End Date</th>-->
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($jobsReferred as $data):
                        ?>
                        <tr>
                            <td><?php echo $this->Html->link("<b>" . $data['Job']['job_title'] . "</b>", NETWORKWE_URL . '/recruiter/jobs_view/' . $data['Job']['JID'], array('escape' => false, 'target' => 'blank')); ?></td>
                            <td><?php echo $this->Html->link($data[0]['refered_by'], '/recruiter/view_user/' . $data['Jobs_referral']['user_id'], array('escape' => false, 'target' => 'blank')); ?></td>
                            <td><?php echo (!empty($data['Jobs_referral']['friend_id']))?$this->Html->link($data[0]['refered_to'], '/recruiter/view_user/' . $data['Jobs_referral']['friend_id'], array('escape' => false, 'target' => 'blank')):''; ?></td>
                            <td><?php echo $data['Jobs_referral']['email']; ?></td>
                            <td><?php echo $data['Jobs_referral']['created'] ?></td>
                            <td class="center">
                            <?php
                            if ($data['Job']['status'] == 2) {
                                echo '<button class="btn btn-info"><i class="icon-star icon-white"></i> Active</button>';
                            } else if ($data['Job']['status'] == 3) {
                                echo '<button class="btn btn-warning"><i class="icon-pause icon-white"></i> Hold</button>';
                            } elseif ($data['Job']['status'] == 4) {
                                echo '<button class="btn btn-success"><i class="icon-gift icon-white"></i> Completed</button>';
                            } else {
                                echo '<button class="btn btn-danger"><i class="icon-remove icon-white"></i> In Active</button>';
                            }
                            ?>
                            </td>
                        </tr>
                    <?php endforeach; //pr($jobsReferred); ?>
                </tbody>
            </table>
        </div>
    </div><!--/span-->
</div><!--/row-->