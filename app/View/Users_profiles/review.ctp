<?php
echo $this->Html->css(array(MEDIA_URL . '/css/userprofile-tab.css'));

?>
<?php
$options_1 = array('0' => 'Individual Email', '1' => 'Weekly Email', '2' => 'Monthly Email', '3' => 'No Email');
$options_2 = array('0' => 'Your Connections', '1' => 'Your Network', '2' => 'Everyone');
$options_3 = array('0' => 'Your Connections', '1' => 'Your Network', '2' => 'Everyone', '3' => 'Only you');
$options_4 = array('1' => 'Enable', '0' => 'Disable');
$options_5 = array('1' => 'Show', '0' => 'Hide');
$tab_id = 0;
$cuser = $this->Session->read(@$userid);
$uid = $cuser['userid'];
?>
<div class="clear"></div>	  
<div class="box">
    <div class="boxheading">
        <h1>Update Your Profile</h1>
        <div class="boxheading-arrow"></div>
    </div>
    <div id="tabs">
        <ul>
            <?php $icon = FALSE; ?>
            <?php foreach ($SettingsMasterList as $data): ?>
                <li><a id="#link-<?php echo $data['Settings_master']['id']; ?>" href="#fragment-<?php echo $data['Settings_master']['id']; ?>"><img src="<?= MEDIA_URL . '/img/' . $data['Settings_master']['icon'] ?>" width="15" height="16" /> <?= $data['Settings_master']['title'] ?></a></li>
            <?php endforeach; ?>
            <?php $tab_id = $data['Settings_master']['id'] + 1; ?>
            <li><a id="#link-<?php echo $tab_id; ?>" href="#fragment-<?php echo $tab_id; ?>"><img src="<?= MEDIA_URL ?>/img/icon-changepass.png" width="15" height="16" /> Change Password</a></li>
            <?php $tab_id = $tab_id + 1; ?>
            <li><a id="#link-<?php echo $tab_id; ?>" href="#fragment-<?php echo $tab_id; ?>"><img src="<?= MEDIA_URL ?>/img/icon-summary.png" width="15" height="16" /> Profile Handler</a></li>
            <?php $tab_id = $tab_id + 1; ?>
            <li><a id="#link-<?php echo $tab_id; ?>" href="#fragment-<?php echo $tab_id; ?>"><img src="<?= MEDIA_URL ?>/img/icon_deactivate.png" width="15" height="16" /> Deactivate Account</a></li>
        </ul>
        <div class="resp-tabs-container">
            <?php foreach ($SettingsMasterList as $data1): ?>
                <div class="content-<?= $data1['Settings_master']['id'] ?> ui-tabs-panel" id="fragment-<?php echo $data1['Settings_master']['id'] ?>">
                    <?php echo $this->Form->create(null, array('url' => '/users_profiles/review/', 'class' => 'formstyle', 'name' => 'searchform-' . $data1['Settings_master']['id'], 'id' => 'searchform-' . $data1['Settings_master']['id'])); ?>
                    <fieldset>
                        <?php $ShowTitle = TRUE; ?>
                        <?php foreach ($SettingsDetailList as $data): ?>
                            <?php if ($ShowTitle): ?>
                                <div class=""><h1><?= $data1['Settings_master']['title'] ?></h1></div>
                            <?php endif; ?>
                            <?php $ShowTitle = FALSE; ?>
                            <?php if ($data1['Settings_master']['id'] == $data['Settings_detail']['settings_master_id']): ?>
                                <?php
                                $option_id = 'option_' . $data['Settings_detail']['id'];
                                ?>
                                <?php foreach ($UsersSettingList as $datauser) : ?>
                                    <?php
                                    if ($datauser['Users_setting']['option_name'] == $option_id) {
                                        $option_value = $datauser['Users_setting']['user_preference'];
                                        break;
                                    }
                                    ?>
                                <?php endforeach; ?>
                                <?php
                                switch ($data['Settings_detail']['options_type']) {

                                    case 'periodic' : $option_list = $options_1;
                                        break;

                                    case 'yesorno' : $option_list = $options_4;
                                        break;
                                    
                                    case 'showorhide' : $option_list = $options_5;
                                        $option_value = (($option_value != 0))?1:$option_value;
                                        break;

                                    default : $option_list = $options_1;
                                        break;
                                }
                                ?>
                                        <?php echo $this->Form->input($option_id . ' after '.$option_value, array('options' => $option_list, 'id' => $option_id, 'name' => $option_id, 'label' => $data['Settings_detail']['title'], 'div' => FALSE, 'class' => 'droplist label1', 'selected' => $option_value)); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php $ShowTitle = TRUE; ?>

                        <?php
                        echo $this->Form->hidden('settings_form_' . $data1['Settings_master']['id'], array(
                            'value' => '1', 'name' => 'settings_form_' . $data1['Settings_master']['id'], 'id' => '\'settings_form_' . $data1['Settings_master']['id'] . '\''
                        ));
                        ?>
                        <br class="clear"/>
                        <?php echo $this->Form->submit('Save', array('type' => 'button', 'label' => false, 'div' => false, 'id' => 'submit-button', 'onclick' => 'save(\'searchform-' . $data1['Settings_master']['id'] . '\')', 'class' => '')); ?>
                        <?php echo $this->Form->submit('Next', array('type' => 'reset', 'label' => false, 'div' => false, 'class' => 'nexttab')); ?>
                        <?php echo $this->Form->end(); ?>
                </div>
            <?php endforeach; ?>
            <?php $tab_id = $data1['Settings_master']['id'] + 1; ?>
            <div class="content-<?= $tab_id ?>" id="fragment-<?php echo $tab_id ?>">
                <?php echo $this->Form->create(null, array('url' => '/users_profiles/review/', 'class' => 'formstyle', 'name' => 'searchform-' . $tab_id, 'id' => 'searchform-' . $tab_id, 'onsubmit' => 'return checFormValidation()')); ?>
                <fieldset>
                    <div class=""><h1>Change Password</h1></div>
                    <?= $this->Form->input('oldpassword', array('type' => 'password', 'required' => true, 'id' => 'oldpassword', 'name' => 'oldpassword', 'label' => 'Current Password', 'div' => true, 'class' => 'label1')); ?>
                    <?= $this->Form->input('password', array('type' => 'password', 'required' => true, 'id' => 'password', 'name' => 'password', 'label' => 'New Password', 'div' => true, 'class' => 'label1')); ?>
                    <?= $this->Form->input('cpassword', array('type' => 'password', 'required' => true, 'id' => 'cpassword', 'name' => 'cpassword', 'label' => 'Confirm Password', 'div' => true, 'class' => 'label1')); ?>
                </fieldset>
                <?php
                echo $this->Form->hidden('settings_form_' . $tab_id, array(
                    'value' => '1', 'name' => 'settings_form_' . $tab_id, 'id' => '\'settings_form_' . $tab_id . '\''
                ));
                ?>
                <br class="clear"/>
                <?php echo $this->Form->submit('Save', array('type' => 'button', 'label' => false, 'div' => false, 'id' => 'submit-button', 'onclick' => 'savePassword("password",' . $uid . ',\'searchform-' . $tab_id . '\')', 'class' => '')); ?>
                <?php echo $this->Form->submit('Next', array('type' => 'reset', 'label' => false, 'div' => false, 'class' => 'nexttab')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
            <?php $tab_id = $tab_id + 1; ?>
            <div class="content-<?= $tab_id ?>" id="fragment-<?php echo $tab_id ?>">
                <?php echo $this->Form->create(null, array('url' => '/users_profiles/review/', 'class' => 'formstyle', 'name' => 'searchform-' . $tab_id, 'id' => 'searchform-' . $tab_id)); ?>
                <fieldset>
                    <div class=""><h1>Public Profile</h1></div>
                    <?php echo $this->Form->input('handler', array('type' => 'text', 'value' => $handler_value, 'id' => 'handler', 'name' => 'handler', 'label' => 'Public Profile', 'div' => true, 'class' => 'label1')); ?>
                    <?php
                    echo $this->Form->hidden('settings_form_' . $tab_id, array(
                        'value' => '1', 'name' => 'settings_form_' . $tab_id, 'id' => '\'settings_form_' . $tab_id . '\''
                    ));
                    ?>
                    <br class="clear"/>
                    <div class="input text" id="reponse-data">
                        <label1>
                            <a href="<?= !empty($handler_value) ? NETWORKWE_URL . '/pub/' . $handler_value : '#'; ?>">
                                <?= !empty($handler_value) ? NETWORKWE_URL . '/pub/' . $handler_value : 'Public profile not set'; ?>
                            </a>
                        </label1>
                    </div>
                    <br class="clear"/>
                    <?php echo $this->Form->submit('Save', array('type' => 'button', 'label' => false, 'div' => false, 'id' => 'submit-button', 'onclick' => 'saveHandler(' . $uid . ',"handler","handler",\'searchform-' . $tab_id . '\')', 'class' => '')); ?>
                    <?php echo $this->Form->submit('Next', array('type' => 'reset', 'label' => false, 'div' => false, 'class' => 'nexttab')); ?>
                    <?php echo $this->Form->end(); ?>
                    <!--                    <div id="error-effect">
                                            <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
                                                <div style="margin-top:12px;">
                                                    <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
                                                        <strong>Error:</strong> 
                                                        "Please try a different name"
                                                    </p>
                                                </div>
                                            </div>
                                        </div>-->
                </fieldset>
            </div>
            <?php $tab_id = $tab_id + 1; ?>
            <div class="content-<?= $tab_id ?> ui-tabs-panel ui-tabs-hide" id="fragment-<?php echo $tab_id ?>">
                <div class="marginbottom20"><h1>Deactivate Account</h1></div>
                <br/>
                <h2>Press "Deactivate my account" to permanently close your account.</h2>
                <br/>
                <h2>Closing your account means shutting off your profile and removing access to all your <?php echo SITE_TITLE ?> information from our site.</h2>
                <br/>
                <h2>Before you deactivate your only <?php echo SITE_TITLE ?>  account, please note:</h2>
                <br/>
                <h2>You will not have access to your connections or any information you've added to your account.</h2>
                <br/>
                <h2>Your profile will no longer be visible on <?php echo SITE_TITLE ?> .</h2>
                <br/>
                <h2>Search engines like Yahoo!, Bing, and Google may still display your information temporarily due to the way they collect and update their search data.</h2>
                <br class="clear"/>
                <div class="round_grey_box">
                    <?php echo $this->Form->create(null, array('url' => '/users_profiles/user_delete/', 'class' => '', 'name' => 'searchform-' . $tab_id, 'id' => 'searchform-' . $tab_id)); ?>
                    <h3>Please Tell us Why would you like to close your <?php echo SITE_TITLE ?> account?</h3><br class="clear"/>
                    <input type="radio" id="account_close_reason_1" value="I have a duplicate account" name="account_close_reason">
                    <label for="account_close_reason_1">I have a duplicate account</label>
                    <input type="radio" id="account_close_reason_2" value="I am getting too many emails" name="account_close_reason">
                    <label for="account_close_reason_2">I am getting too many emails</label>
                    <input type="radio" id="account_close_reason_3" value="I am not getting any value from my membership" name="account_close_reason">
                    <label for="account_close_reason_3">I am not getting any value from my membership</label>
                    <input type="radio" id="account_close_reason_4" value="I am using a different professional networking service" name="account_close_reason">
                    <label for="account_close_reason_4">I am using a different professional networking service</label>
                    <input type="radio" id="account_close_reason_5" value="Other" name="account_close_reason">
                    <label for="account_close_reason_5">Other</label>
                    <div class="clear"></div>
                    <div id="other-textfield" style="display:none;">
                        <input type="text" style="width: 300px; margin: 5px 0px 1px 20px;" maxlength="300" id="account_close_reason_6" value="" name="account_close_reason_other">
                    </div>
                    <div class="input text" id="reponse-data"></div>
                    <br />
                    <?php echo $this->Form->submit('Deactivate my account', array('type' => 'button', 'label' => false, 'div' => false, 'id' => 'submit-button', 'onclick' => 'deleteAccount(' . $uid . ', \'searchform-' . $tab_id . '\')', 'class' => 'red-bttn')); ?>
                    <?php echo $this->Form->end(); ?>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
