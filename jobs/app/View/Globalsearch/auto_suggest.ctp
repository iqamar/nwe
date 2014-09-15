<?php if (!empty($datauser)): ?>
    <div class="display-heading">People</div>
    <?php foreach ($datauser as $data): ?>
        <?php
        $FullName = $data[0]['fullname'];
        $profile_url = NETWORKWE_URL . '/users_profiles/userprofile/' . $data['Users_profile']['user_id'];
        if (empty($data['Users_profile']['photo']) || !file_exists(MEDIA_PATH.'/files/user/icon/'.$data['Users_profile']['photo']) ) {
            $profile_pic = '/img/nophoto.jpg';
        }
        else
            $profile_pic = '/files/user/icon/' . $data['Users_profile']['photo'];
        ?>
        <a href="<?php echo $profile_url ?>">
        <div class="display_box">
            <div class="display-pic"><?php echo $this->Html->image(MEDIA_URL . $profile_pic, array('alt' => $FullName, 'width'=>'32')); ?></div>
            <ul class="display-userdetails">
                <li><?php echo (strlen($FullName) > 31) ? substr($FullName, 0, 29).'...' : $FullName ?></li>
            </ul>
        </div>
        </a>
    <?php endforeach; ?>
<?php endif; ?>
<?php if (!empty($datajobs)): ?>
    <div class="display-heading">Jobs</div>
    <?php foreach ($datajobs as $data): ?>
        <?php 
        if (empty($data['Company']['logo']) || !file_exists(MEDIA_PATH.'/files/company/icon/'.$data['Company']['logo']) ) {
            $comp_logo = '/img/nologo.jpg';
        } else {
            $comp_logo = '/files/company/icon/' . $data['Company']['logo'];
        }
        $title = $data['Job']['title']?$data['Job']['title']:'Invalid Title';
        ?>
        <a href="<?php echo JOBS_URL . '/search/jobDetails/' . $data['Job']['id'] ?>">
        <div class="display_box" align="left">
            <div class="display-pic"><?php echo $this->Html->image(MEDIA_URL . $comp_logo, array('alt' => $job_title, 'width'=>'32')); ?></div>
            <ul class="display-userdetails">
                <li><?php echo (strlen($title) > 31) ? substr($title, 0, 29).'...' : $title ?></li>
            </ul>
        </div>
        </a>
    <?php endforeach; ?>
<?php endif; ?>
<?php if (!empty($datacompany)): ?>
    <div class="display-heading">Company</div>
    <?php foreach ($datacompany as $data): ?>
        <?php 
        if (empty($data['Company']['logo']) || !file_exists(MEDIA_PATH.'/files/company/icon/'.$data['Company']['logo']) ) {
            $comp_logo = '/img/nologo.jpg';
        } else {
            $comp_logo = '/files/company/icon/' . $data['Company']['logo'];
        }
        $title = $data['Company']['title']?$data['Company']['title']:'Invalid Title';
        ?>
        <a href="<?php echo NETWORKWE_URL ?>/companies/view/<?php echo $data['Company']['id'] ?>">
        <div class="display_box" align="left">
            <div class="display-pic"><?php echo $this->Html->image(MEDIA_URL . $comp_logo, array('alt' => $title, 'width'=>'32')); ?></div>
            <ul class="display-userdetails">
                <li><?php echo (strlen($title) > 31) ? substr($title, 0, 29).'...' : $title ?></li>
            </ul>
        </div>
        </a>
    <?php endforeach; ?>
<?php endif; ?>
<?php if (!empty($datagroups)): ?>
    <div class="display-heading">Groups</div>
    <?php foreach ($datagroups as $data): ?>
        <?php 
        if (empty($data['Group']['logo']) || !file_exists(MEDIA_PATH.'/files/group/icon/'.$data['Group']['logo']) ) {
            $group_logo = '/img/nologo.jpg';
        } else {
            $group_logo = '/files/group/icon/' . $data['Group']['logo'];
        }
        $title = $data['Group']['title']?$data['Group']['title']:'Invalid Title';
        ?>
        <a href="<?php echo NETWORKWE_URL ?>/groups/view/<?php echo $data['Group']['id'] ?>">
        <div class="display_box" align="left">
            <div class="display-pic"><?php echo $this->Html->image(MEDIA_URL . $group_logo, array('alt' => $title, 'width'=>'32')); ?></div>
            <ul class="display-userdetails">
                <li><?php echo (strlen($title) > 31) ? substr($title, 0, 29).'...' : $title ?></li>
            </ul>
        </div>
        </a>
    <?php endforeach; ?>
<?php endif; ?>