<div class="clear">&nbsp;</div>
<div class="box searchbox">
    <div class="boxheading">
        <h1>
            <div class="searchbox-icons"><?php echo $this->Html->image(MEDIA_URL . '/img/people-icon.png'); ?></div>People
<!--                <span class="searchbox-total">(1,290)</span>-->
        </h1>
        <div class="boxheading-arrow"></div>
    </div>
    <div class="margintop20">
        <?php if (!empty($datauser)): ?>
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
                <div class="searchresult-holder">
                    <div class="resultpic">
						<?php echo $this->Html->link($this->Html->image(MEDIA_URL . $profile_pic, array('alt' => $FullName)), $profile_url, array('escapeTitle' => false, 'title' => $FullName)); ?>
					</div>
                    <div class="searchresult-rgt">
                        <a href="<?= $profile_url ?>"><?= (strlen($FullName) > 31) ? substr($FullName, 0, 29).'...' : $FullName ?></a>
					</div>
                    <div class="clear"></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="error_msg">No Result Found...</div>
        <?php endif; ?>
    </div>
    <div class="clear"></div>
</div>
<div class="box searchbox">
    <div class="boxheading">
        <h1>
            <div class="searchbox-icons"><?php echo $this->Html->image(MEDIA_URL . '/img/jobs-icon.png'); ?></div>Jobs
<!--            <span class="searchbox-total">(1,290)</span>-->
        </h1>
        <div class="boxheading-arrow"></div>
    </div>
    <div class="margintop20">
        <?php if (!empty($datajobs)): ?>
            <?php foreach ($datajobs as $data): ?>
                <?php 
                if (empty($data['Company']['logo']) || !file_exists(MEDIA_PATH.'/files/company/icon/'.$data['Company']['logo']) ) {
                    $comp_logo = '/img/nologo.jpg';
                } else {
                    $comp_logo = '/files/company/icon/' . $data['Company']['logo'];
                }
                //$comp_logo = (!empty($data['Company']['logo']) || !file_exists(MEDIA_PATH.'/files/company/icon/'.$data['Company']['logo'])) ? '/files/company/icon/' . $data['Company']['logo'] : '/img/nologo.jpg'; ?>
                <?php $alt = $data['Company']['title'] . ' - ' . $data['Job']['city'] . ' - ' . $data['Country']['name']; ?>
                <div class="searchresult-holder">
                    <div class="resultpic"><a href="<?= JOBS_URL . '/search/jobDetails/' . $data['Job']['id'] ?>"><?php echo $this->Html->image(MEDIA_URL . $comp_logo, array('alt' => '', 'width' => '55', 'height' => '50', 'border' => '0')) ?></a></div>
                    <div class="searchresult-rgt">
                        <a href="<?= JOBS_URL . '/search/jobDetails/' . $data['Job']['id'] ?>">
                            <?php $data['Job']['title'] = $data['Job']['title'] ? $data['Job']['title'] : 'N/A'; ?>
                            <?= (strlen($data['Job']['title']) > 28) ? substr($data['Job']['title'], 0, 27).'...' : $data['Job']['title'] ?>
                        </a></div>
                    <div class="clear"></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="error_msg">No Result Found...</div>
<?php endif; ?>
    </div>
    <div class="clear"></div>
</div>

<div class="box searchbox">
    <div class="boxheading">
        <h1>
            <div class="searchbox-icons"><?php echo $this->Html->image(MEDIA_URL . '/img/companies-icon.png'); ?>
            </div>Companies
<!--            <span class="searchbox-total">(1,290)</span>-->
        </h1>
        <div class="boxheading-arrow"></div>
    </div>
    <div class="margintop20">
        <?php if (!empty($datacompany)): ?>
            <?php foreach ($datacompany as $data): ?>
        <?php 
        if (empty($data['Company']['logo']) || !file_exists(MEDIA_PATH.'/files/company/icon/'.$data['Company']['logo']) ) {
            $comp_logo = '/img/nologo.jpg';
        } else {
            $comp_logo = '/files/company/icon/' . $data['Company']['logo'];
        }
        //$comp_logo = !empty($data['Company']['logo']) || file_exists(MEDIA_PATH.'/files/user/icon/'.$data['Company']['logo']) ? '/files/company/icon/' . $data['Company']['logo'] : '/img/nologo.jpg'; ?>
                <div class="searchresult-holder">
                    <div class="resultpic"><a href="<?= NETWORKWE_URL ?>/companies/view/<?= $data['Company']['id'] ?>"><?php echo $this->Html->image(MEDIA_URL . $comp_logo, array('alt' => '', 'width' => '55', 'height' => '50', 'border' => '0')) ?></a></div>
                    <div class="searchresult-rgt">
                        <a href="<?= NETWORKWE_URL ?>/companies/view/<?= $data['Company']['id'] ?>">
                            <?php $data['Company']['title'] = $data['Company']['title'] ? $data['Company']['title'] : 'N/A'; ?>
                            <?= (strlen($data['Company']['title']) > 31) ? substr($data['Company']['title'], 0, 29).'...' : $data['Company']['title'] ?>
                        </a>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="error_msg">No Result Found...</div>
<?php endif; ?>
    </div>
    <div class="clear"></div>
</div>

<div class="box searchbox">
    <div class="boxheading">
        <h1>
            <div class="searchbox-icons"><?php echo $this->Html->image(MEDIA_URL . '/img/group-icon.png'); ?>
            </div>Groups
<!--            <span class="searchbox-total">(1,290)</span>-->
        </h1>
        <div class="boxheading-arrow"></div>
    </div>
    <div class="margintop20">
        <?php if (!empty($datagroups)): ?>
            <?php foreach ($datagroups as $data): ?>
        <?php 
        if (empty($data['Group']['logo']) || !file_exists(MEDIA_PATH.'/files/group/icon/'.$data['Group']['logo']) ) {
            $group_logo = '/img/nologo.jpg';
        } else {
            $group_logo = '/files/group/icon/' . $data['Group']['logo'];
        }
        //$group_logo = !empty($data['Group']['logo']) ? '/files/group/icon/' . $data['Group']['logo'] : '/img/nologo.jpg'; ?>
                <div class="searchresult-holder">
                    <div class="resultpic"><a href="<?= NETWORKWE_URL ?>/groups/view/<?= $data['Group']['id'] ?>"><?php echo $this->Html->image(MEDIA_URL . $group_logo, array('alt' => '', 'width' => '55', 'height' => '50', 'border' => '0')) ?></a></div>
                    <div class="searchresult-rgt">
                        <a href="<?= NETWORKWE_URL ?>/groups/view/<?= $data['Group']['id'] ?>">
                            <?php $data['Group']['title'] = $data['Group']['title'] ? $data['Group']['title'] : 'N/A'; ?>
                            <?= (strlen($data['Group']['title']) > 31) ? substr($data['Group']['title'], 0, 29).'...' : $data['Group']['title'] ?>
                        </a>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="error_msg">No Result Found...</div>
<?php endif; ?>        
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>
