<?php echo $this->element('Recruiter/breadcrumb'); ?>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i>Employer</h2>
            <div class="box-icon">
                <!--a title="Add" href="/recruiter/jobs_add" class="btn btn-small btn-primary" style="width:60px;">Add jobs</a-->
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>

        <div class="box-content" style="padding-top:10px;">

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Email</th>
                        <th>Contact Info</th>
                        <th>Location</th>
                        <th>Company Size</th>
                        <!--<th>Status</th>-->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($company) : ?>
                       <?php foreach ($company as $data) : ?>
                            <tr>
                                <td><?php echo "<b>" . $data['Company']['title'] . "</b>"; ?></td>
                                <td><?php echo $data['Company']['primary_email']; ?></td>
                                <td><?php echo $data['Company']['contact_name'] . "<br/>" . $data['Company']['designation']; ?></td>
                                <td><?php echo $data['Company']['city']; ?></td>
                                <td><?php echo $data['Company']['company_size']; ?></td>
                                <!--<td>
                                <?php //if ($data['Company']['status'] == 2) echo '<button class="btn btn-info"><i class="icon-star icon-white"></i> Active</button>';
                                //else echo '<button class="btn btn-danger"><i class="icon-remove icon-white"></i> In Active</button>'; ?>
                                </td>-->
                                <td class="center" nowrap>
                                <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-edit')) . " Edit", array('controller' => 'recruiter', 'action' => 'employer_edit/' . $data['Company']['id']), array('class' => 'btn ', 'escape' => false)); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                   <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div><!--/span-->
</div><!--/row-->