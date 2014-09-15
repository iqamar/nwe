<?php $this->Paginator->options(array('update' => '#search_container', 'evalScripts' => true, 'url' => $this->passedArgs, 'data' => http_build_query($this->request->data), 'method' => 'POST', 'before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)), 'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false)))); ?>
<div class="box">
    <?php if (!empty($datauser)): ?>
        <div class="boxheading">
            <h1>
                <div class="searchbox-icons">
                    <?php echo $this->Html->image(MEDIA_URL . '/img/people-icon.png'); ?>
                </div>People
               <!-- <span class="searchbox-total">(<?= $this->Paginator->counter('{:count}'); ?>)</span>-->
            </h1>
            <div class="boxheading-arrow"></div>
        </div>
        <div class="margintop20">
            <?php foreach ($datauser as $data): ?>
                <?php
                $profile_id = $data['Users_profile']['user_id'];
                $profile_url = NETWORKWE_URL . '/users_profiles/userprofile/' . $profile_id;
                $fullname = $data[0]['fullname'];
                if (empty($data['Users_profile']['photo']) || !file_exists(MEDIA_PATH . '/files/user/icon/' . $data['Users_profile']['photo'])) {
                    $profile_pic = '/img/nophoto.jpg';
                }
                else
                    $profile_pic = '/files/user/icon/' . $data['Users_profile']['photo'];
                $tags = $data['Users_profile']['tags'] ? $data['Users_profile']['tags'] : 'No title';
                ?>
                <?php echo $this->Form->create(null, array('name' => 'form-' . $profile_id, 'id' => 'form-' . $profile_id)); ?>
                <div class="searchresult-holder">
                    <div class="resultpic">
                        <?php echo $this->Html->link($this->Html->image(MEDIA_URL . $profile_pic, array('alt' => $fullname)), $profile_url, array('escapeTitle' => false, 'title' => $fullname)); ?>
                    </div>
                    <div class="searchresult-rgt-full">
                        <ul>
                            <li>
                                <a href="<?php echo $profile_url ?>">
                                    <?php echo (!empty($fullname)) ? (strlen($fullname) > 31) ? substr($fullname, 0, 32) : $fullname  : 'No name' ?>
                                </a>
                            </li>
                            <li>
                                <div class="listing-bttns" id="ajax_response">		
                                    <?php if ($data[0]['cnt'] >= 1 && $data[0]['request'] == 1): ?>
                                        <a href="<?php echo $profile_url ?>">View Profile</a>
                                        <?php /* <a href="javascript:;" onclick="connect_user('<?php echo $profile_id;?>','-1')" class="connect-bttn"> Remove Connection</a> <a href="#" class="send-bttn"> Send Message</a> */ ?>
                                    <?php elseif ($data[0]['cnt'] >= 1 && $data[0]['request'] == 0): ?>
                                        <a href="javascript:;" class="connect-bttn"> Pending Approval</a>
                                    <?php else: ?>
                                        <a href="#"  class="connect-bttn" data-toggle="modal" data-target="#popup-<?php echo $profile_id ?>">Connect</a>
                                        <?php /* <a href="javascript:;" onclick="connect_user('<?php echo $data['Users_profile']['user_id'];?>','0')" class="connect-bttn"> Connect</a> */ ?>
                                    <?php endif; ?>
                                </div>
                                <?php echo $tags ?></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
            
                <div class="modal fade middlepopup-bigimg" id="popup-<?php echo $profile_id ?>" tabindex="-1" role="dialog" aria-labelledby="popup-bigimg" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <form action="" method="post">
                                <div class="modal-header">
                                    <a class="popupclose" data-dismiss="modal" aria-hidden="true"></a>
                                    <h1 class="modal-title" id="myModalLabel">Send Connection Request</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="popup-listing">
                                        <div class="popup-listing-logo"><?php echo $this->Html->image(MEDIA_URL . $profile_pic, array('alt' => $fullname));?></div>
                                        <div class="popup-listing-rgt">
                                            <ul>
                                                <li>
                                                    <h1><?php echo $fullname; ?></h1>
                                                </li>
                                                <li><?php echo $tags ?></li>
                                            </ul>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="popup-checkbox">
                                        Connect as: 
                                        <input name="connection_type" type="radio" value="Professional" checked="checked"/> <label> Professional</label> 
                                        <input name="connection_type" type="radio" value="Friend"/><label> Friend</label>
                                        <input name="connection_type" type="radio" value="Both" /><label>  Both</label>
                                    </div>
                                    <span class="redcolor" id="connection_error"></span>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="connect_btn" class="btn submitbttn" data-dismiss="modal" onclick="connect_user('<?php echo $data['Users_profile']['user_id'];?>','0')">Connect</button>
                                    <button type="button" class="btn canclebttn" data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php //echo $this->Form->hidden('settings_form_'.$tab_id,array('value' => '1','name'=>'settings_form_'.$tab_id,'id'=>'\'settings_form_'.$tab_id.'\''));  ?>
                <?php echo $this->Form->end(); ?>
            <?php endforeach; ?>
        </div>
    <?php elseif ($SearchScope == 1 && empty($datauser)): ?>
        <div class="error_msg">No Result Found...</div>
    <?php endif; ?>

    <?php if (!empty($datajobs)): ?>
        <div class="boxheading">
            <h1>
                <div class="searchbox-icons">
                    <?php echo $this->Html->image(MEDIA_URL . '/img/jobs-icon.png'); ?>
                </div>Jobs
          <!--      <span class="searchbox-total">(<?= $this->Paginator->counter('{:count}'); ?>)</span>-->
            </h1>
            <div class="boxheading-arrow"></div>
        </div>
        <div class="margintop20">
            <?php foreach ($datajobs as $data): ?>
                <?php
                if (empty($data['Company']['logo']) || !file_exists(MEDIA_PATH . '/files/company/icon/' . $data['Company']['logo'])) {
                    $comp_logo = '/img/nologo.jpg';
                } else {
                    $comp_logo = '/files/company/icon/' . $data['Company']['logo'];
                }
                //$comp_logo = !empty($data['Company']['logo']) ? '/files/company/icon/' . $data['Company']['logo'] : '/img/nologo.jpg'; 
                ?>
                <div class="searchresult-holder">
                    <div class="resultpic">
                        <?php echo $this->Html->image(MEDIA_URL . $comp_logo, array('alt' => '', 'width' => '55', 'height' => '50', 'border' => '0')) ?>
                    </div>
                    <div class="searchresult-rgt-full">
                        <ul>
                            <li><a href="<?= JOBS_URL . '/search/jobDetails/' . $data['Job']['id'] ?>"><?= $data['Job']['title'] ? $data['Job']['title'] : 'N/A' ?></a></li>
                            <li>
                                <div class="listing-bttns"> 
        <!--                                    <a href="<?= JOBS_URL . '/search/jobDetails/' . $data['Job']['id'] ?>" class="save-bttn">Save Job</a>
                                    <a href="<?= JOBS_URL . '/search/jobDetails/' . $data['Job']['id'] ?>" class="apply-bttn">Apply for Job</a>-->
                                </div>
                                <?php echo $data['Company']['title']; ?> - <?php echo $data['Job']['city']; ?> - <?php echo $data['Country']['name']; ?>
                            </li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif ($SearchScope == 2 && empty($datajobs)): ?>
        <div class="error_msg">No Result Found...</div>
    <?php endif; ?>

    <?php if (!empty($datacompany)): ?>
        <div class="boxheading">
            <h1>
                <div class="searchbox-icons">
                    <?php echo $this->Html->image(MEDIA_URL . '/img/companies-icon.png'); ?>
                </div>Companies
<!--                <span class="searchbox-total">(<?= $this->Paginator->counter('{:count}'); ?>)</span>-->
            </h1>
            <div class="boxheading-arrow"></div>
        </div>
        <div class="margintop20">
            <?php foreach ($datacompany as $data): ?>
                <?php
                if (empty($data['Company']['logo']) || !file_exists(MEDIA_PATH . '/files/company/icon/' . $data['Company']['logo'])) {
                    $comp_logo = '/img/nologo.jpg';
                } else {
                    $comp_logo = '/files/company/icon/' . $data['Company']['logo'];
                }
                //$comp_logo = !empty($data['Company']['logo']) ? '/files/company/icon/' . $data['Company']['logo'] : '/img/nologo.jpg'; 
                ?>
                <div class="searchresult-holder">
                    <div class="resultpic">
        <?php echo $this->Html->link($this->Html->image(MEDIA_URL . $comp_logo, array('alt' => '')), NETWORKWE_URL . '/companies/view/' . $data['Company']['id'], array('escapeTitle' => false, 'title' => $data['Company']['title'])); ?>
                    </div>
                    <div class="searchresult-rgt-full">
                        <ul>
                            <li>
                                <a href="<?= NETWORKWE_URL ?>/companies/view/<?= $data['Company']['id'] ?>">
                                    <?php $data['Company']['title'] = $data['Company']['title'] ? $data['Company']['title'] : 'N/A'; ?>
        <?= (strlen($data['Company']['title']) > 31) ? substr($data['Company']['title'], 0, 32) : $data['Company']['title'] ?>
                                </a>
                            </li>
                            <li>
                                <div class="listing-bttns"> 
        <!--                                    <a href="<?= NETWORKWE_URL ?>/companies/view/<?= $data['Company']['id'] ?>" class="follow-bttn"> Follow</a>-->
                                </div>
        <?= $data['Country']['name'] ? $data['Country']['name'] : 'N/A'; ?></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
        <?php endforeach; ?>
        </div>
    <?php elseif ($SearchScope == 3 && empty($datacompany)): ?>
        <div class="error_msg">No Result Found...</div>
    <?php endif; ?>
<?php if (!empty($datagroups)): ?>
        <div class="boxheading">
            <h1>
                <div class="searchbox-icons">
    <?php echo $this->Html->image(MEDIA_URL . '/img/group-icon.png'); ?>
                </div>Groups
<!--                <span class="searchbox-total">(<?= $this->Paginator->counter('{:count}'); ?>)</span>-->
            </h1>
            <div class="boxheading-arrow"></div>
        </div>
        <div class="margintop20">
            <?php foreach ($datagroups as $data): ?>
                <?php
                if (empty($data['Group']['logo']) || !file_exists(MEDIA_PATH . '/files/group/icon/' . $data['Group']['logo'])) {
                    $group_logo = '/img/nologo.jpg';
                } else {
                    $group_logo = '/files/group/icon/' . $data['Group']['logo'];
                }
                //$group_logo = !empty($data['Group']['logo']) ? '/files/group/icon/' . $data['Group']['logo'] : '/img/nologo.jpg'; 
                ?>
                <div class="searchresult-holder">
                    <div class="resultpic">
        <?php echo $this->Html->link($this->Html->image(MEDIA_URL . $group_logo, array('alt' => '')), NETWORKWE_URL . '/groups/view/' . $data['Group']['id'], array('escapeTitle' => false, 'title' => $data['Group']['title'])); ?>
                    </div>
                    <div class="searchresult-rgt-full">
                        <ul>
                            <li>
                                <a href="<?= NETWORKWE_URL ?>/groups/view/<?= $data['Group']['id'] ?>">
        <?php echo $data['Group']['title'] = $data['Group']['title'] ? $data['Group']['title'] : 'N/A'; ?>
                                </a>
                            </li>
                            <li>
                                <div class="listing-bttns"> 
        <!--                                    <a href="<?= NETWORKWE_URL ?>/groups/view/<?= $data['Group']['id'] ?>" class="join-bttn"> Join</a>-->
                                </div>
        <?= $data['groups_types']['title'] ?></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
        <?php endforeach; ?>
        </div>
    <?php elseif ($SearchScope == 4 && empty($datagroups)): ?>
        <div class="error_msg">No Result Found...</div>
<?php endif; ?>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<div id="spinner" style="display: none;">
    <?php echo $this->Html->Image(MEDIA_URL . '/img/loading.gif', array('id' => 'busy-indicator')); ?>
</div>
<ul class="tsc_pagination tsc_paginationC tsc_paginationC10">
    <?php
    echo $this->Paginator->numbers(array(
        'first' => 'First',
        'last' => 'Last',
        'separator' => '',
        'currentClass' => '',
        'tag' => 'li',
        'currentTag' => 'a class="current"'
    ));
    ?>
</ul>
<?php echo $this->Js->writeBuffer(); ?>
<?php
//echo $this->element('sql_dump'); ?>
