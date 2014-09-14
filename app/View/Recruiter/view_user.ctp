<?php 
$this->Html->addCrumb(' Dashboard', '/recruiter');
$this->Html->addCrumb(' Users', array('controller' => 'recruiter', 'action' => 'users'));
$this->Html->addCrumb(' View User Profile', array('controller' => 'recruiter', 'action' => 'view_user', $this->request->params['pass'][0]));
echo $this->element('Recruiter/breadcrumb'); ?>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> Users Profile</h2>
        </div>
        <div class="box-content">
            <?php
                if (empty($profile[0]['Users_profile']['photo']) || !file_exists(MEDIA_PATH . '/files/user/logo/' . $profile[0]['Users_profile']['photo'])) {
                    $profile_pic = '/img/nophoto.jpg';
                }
                else
                    $profile_pic = '/files/user/logo/' . $profile[0]['Users_profile']['photo'];
            ?>
            <br/>
            <div>
                <div class="span2 pull-left"><img src="<?php echo MEDIA_URL . $profile_pic;?>" /></div>
                <div class="span10 pull-left">
                    <h1>
                        <?php
                        $fullname = $profile[0]['Users_profile']['firstname'] . ' ' . $profile[0]['Users_profile']['lastname'];
                        echo (!empty($profile[0]['Users_profile']['title'])) ? $profile[0]['Users_profile']['title'] . '. ' : '';
                        echo $fullname?$fullname:'<span class="muted">None</span>';
                        ?>
                    </h1>
                    <dl class="dl-horizontal">
                        <dt>Job Title</dt>
                            <dd><?php echo !empty($profile[0]['Users_profile']['tags'])? $profile[0]['Users_profile']['tags']: '<span class="muted">None</span>'; ?></dd>
                        <dt>Total Experience</dt>
                        <?php
                        foreach ($experience as $e){
                            $total_days += $e[0]['days'];
                            $total_years += $e[0]['years'];
                            $total_months += $e[0]['months'];
                        }
                        if($total_days > 30) {
                            $total_months += 1;
                            $total_days -= 30;
                        }
                        if($total_months > 12) {
                            $total_years += 1;
                            $total_months -= 12;
                        }
                        ?>
                            <dd><b><?php echo $total_years ?> years <?php echo $total_months ?> months and <?php echo $total_days ?> days</b></dd>
                        <dt>Education</dt>
                            <dd><?php echo $education[0]['Qualification']['title']?$education[0]['Qualification']['title']:'<span class="muted">None</span>'; ?></dd>
                            <dd><?php echo $education[0]['Institute']['title']?$education[0]['Institute']['title']:'<span class="muted">None</span>'; ?></dd>
                    </dl>
                </div>
            </div>
            <div class="clear"></div>

            <br/>
            <h2>Work Experience</h2>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Employer</th>
                        <th>Location</th>
                        <th>Position</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($experience as $e) :?>
                    <tr>
                        <td>
                            <?php echo $this->Html->link(
                                    $e['Company']['title'],
                                    NETWORKWE_URL . '/company/view/' . $e['Company']['id'] . '/' . $e['Company']['title']
                                    ); ?>
                        </td>
                        <td>
                            <?php echo $e['Users_experience']['location']?$e['Users_experience']['location']:'<span class="muted">None</span>'; ?>
                        </td>
                        <td>
                            <?php echo $e['Users_experience']['designation']?$e['Users_experience']['designation']:'<span class="muted">None</span>'; ?>
                        </td>
                        <td>
                            <?php echo $e['Users_experience']['start_date']?$e['Users_experience']['start_date']:'<span class="muted">None</span>'; ?>
                        </td>
                        <td>
                            <?php echo $e['Users_experience']['end_date']?$e['Users_experience']['end_date']:'<span class="muted">None</span>'; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <br/>
            <h2>Skills</h2>
            <div class="">
            <?php foreach ($skills as $s) :?>
            
            <button class="btn btn-small btn-primary">
                <?php echo $s['Skill']['title']; ?> <span class="label label-info"><?php echo $s[0]['total_recommendations']?></span>
            </button>
            <?php endforeach; ?>
            </div>
            <br/>
            <br/>
            <h2>Education</h2>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Institute Name</th>
                        <th>Majors</th>
                        <th>Passing Year</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($education as $e) :?>
                    <tr>
                        <td>
                            <?php echo $e['Qualification']['title']?$e['Qualification']['title']:'<span class="muted">None</span>'; ?>
                        </td>
                        <td>
                            <?php echo $this->Html->link(
                                    $e['Institute']['title'],
                                    '#' . $e['Institute']['id'] . '-' . $e['Institute']['title']
                                    ); ?>
                        </td>
                        <td>
                            <?php echo $e['Users_qualification']['field_study']?$e['Users_qualification']['field_study']:'<span class="muted">None</span>'; ?>
                        </td>
                        <td>
                            <?php echo $e['Users_qualification']['end_date']?$e['Users_qualification']['end_date']:'<span class="muted">None</span>'; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br/>

        </div>
    </div>
</div>