<ul class="breadcrumb">
    <li>
        <a href="<?php echo NETWORKWE_URL?>/">Home</a> <span class="divider">/</span>
    </li>
    <li>
        <a href="<?php echo NETWORKWE_URL?>/recruiter">Dashboard</a> <span class="divider">/</span>
    </li>
    <li>
        <a href="<?php echo NETWORKWE_URL?>/recruiter/jobs">Jobs</a> <span class="divider">/</span>
    </li>
    <li class="active">Matching Profiles</li>
</ul>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> Matching profiles for <?php echo $candidate[0]['Job']['title']; ?></h2>
        </div>
        <div class="box-content">
            <?php if((sizeof($candidate) > 0)): ?>
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Current Role</th>
                        <th>Availability</th>
                        <th>Profile</th>
                    </tr>
                </thead>
                <tbody>                    
                    <?php foreach ($candidate as $data): ?>
                        <tr>
                            <td>
                                <?php echo $data['Users_profile']['title'] . " " . $data['Users_profile']['firstname'] . " " . $data['Users_profile']['lastname']; ?>
                            </td>
                            <td>
                                <?php echo $data['Users_profile']['tags']; ?>
                            </td>
                            <td><?php echo ($data['Users_profile']['hiring'] == 1)?'<span class="label label-success">Available</span>':'<span class="label">Not Available</span>'; ?></td>
                            <td class="center" nowrap>
                                <!--<a href="/recruiter/view_user/<?= $data['Users_profile']['user_id'] ?>" class="btn btn-success"><i class="icon-zoom-in icon-white"></i> View Profile</a>-->
                                <?php
                                echo $this->Html->link(
					$this->Html->tag('i', '', array('class' => 'icon-user icon-white')) . " View", array('action' => 'view_user', $data['Users_profile']['user_id']), array('class' => 'btn btn-success', 'escape' => false)
				);
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="span18">
                    <h3>No matching profiles!</h3>
                    <p>Cannot find any matching profiles for this job.</p>
                </div>
            <?php endif; ?>
        </div>
    </div><!--/span-->
</div><!--/row-->