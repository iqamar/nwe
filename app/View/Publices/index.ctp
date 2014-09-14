<?php
echo $this->Html->css(array(MEDIA_URL.'/js/webguide/webguide.css'));
echo $this->Html->script(array(MEDIA_URL.'/js/webguide/webguide.js', MEDIA_URL.'/js/webguide/webguide_captions.js'));
?>
<script>
    function showInfo(div) {
        $("#" + div).slideToggle('slow');
    }
    function checkValidate() {
        var userid = document.getElementById('user_id').value;
        var friendid = document.getElementById('friend_id').value;
        if (friendid == userid)
            alert("you cant sent reques to itself");
        return false;
    }
    function closeMessage() {
        $("#hideMessage").slideUp('slow');
    }
    function showProfiles(id, user_id) {
        $.ajax({
            url: baseUrl + "/users_profiles/recommended_profiles",
            type: "GET",
            cache: false,
            data: {user_id: user_id, id: id},
            success: function(data) {
                //$(this).css('background','none');
                $("#resultDiv_" + id).html(data);
            },
            error: function(data) {
                $("#resultDiv_" + id).html("error");
            }
        });
    }
    function hideMessageForm(id) {
        document.getElementById('fade').style.display = 'none';
        document.getElementById('userSendForm_' + id).style.display = 'none';
    }
    function showStarSign(star_id, user_id) {
        $.ajax({
            url: baseUrl + "/users_profiles/user_star",
            type: "GET",
            cache: false,
            data: {star_id: star_id, user_id: user_id},
            success: function(data) {
                $("#starbox").html(data);
            },
            error: function(data) {
                $("#starbox").html("error");
            }
        });
    }
    function hideUserSign() {
    }
</script>
<div class="rgtcol">
    <div id="step1">
        <div class="joinimg"><img src="<?php echo MEDIA_URL ?>/img/join_image.png" width="290" height="74" /></div>
        <div class="greybox">
            <div class="greybox-div-heading"> 
                <h1>Sign Up </h1>
            </div>
            <div><?php echo $this->element('Users/registration_form'); ?></div>
        </div>
    </div>
    <div class="greybox" id="step2">
        <div>
            <div class="greybox-div-heading"> 
                <h1>Sign In</h1>
            </div>
            <?php echo $this->element('Users/login_form'); ?>
        </div>
    </div>
    <!--div id="step3">
    <?php //echo $this->element('Default/widget_search'); ?>
    </div-->
</div>

<div class="leftcol">
    <?php foreach ($userRec as $user_Name) { ?>
        <div class="profile-user userprofile-form">
            <div class="profile-user-pic"><?php
                if ($user_Name['users_profiles']['photo']) {
                    echo $this->Html->image(MEDIA_URL . '/files/user/logo/' . $user_Name['users_profiles']['photo'], array('style' => ''));
                } else {
                    echo $this->Html->image(MEDIA_URL . '/img/nophoto.jpg', array('style' => ''));
                }
                ?></div>
            <div class="profile-user-rgt">
                <ul>
                    <li>
                        <h1><?php echo $user_Name['users_profiles']['firstname'] . " " . $user_Name['users_profiles']['lastname']; ?></h1>
                    </li>
                    <?php if(!empty($user_Name['users_profiles']['tags'])): ?>
                    <li>Current Working as : <strong><?php echo $user_Name['users_profiles']['tags']; ?></strong></li>
                    <?php endif;?>
                    <?php foreach ($lastEducation as $last_Edu) { ?>
                        <li>Education: <strong><?php echo $last_Edu['qualifications']['title']; ?></strong></li>
                    <?php } ?>
                    <?php
                    $i = 1;
                    foreach ($userExperience as $user_Edu) {
                        ?>
                        <li><?php
                            if ($i == 1) {
                                
                            } else {
                                ?>
                                Past Worked with: <strong><?php
                                    echo $user_Edu['companies']['title'];
                                }
                                ?></strong></li>
                        <?php
                        $i++;
                    }
                    ?>
                    <li>
                        <div class="clear"></div>
                    </li> 
                    <li>
                        <div class="clear"></div>
                    </li>
                </ul>
            </div>
            <div class="clear"></div>
            <!-- Activities start -->
            <div class="activities-div">
                <div class="profileuser-activities">
                    <div class="activity-icon">
                        <?php
                        echo $this->Html->image(MEDIA_URL . '/img/big-icon-experties.png', array('style' => 'width:30px; height:30px;'));
                        ?>
                    </div>
                    <ul>
                        <li><strong>Expertise</strong> </li>
                        <li><span class="smalltext"><?php
                                if (sizeof($uSers_exp)) {
                                    foreach ($uSers_exp as $countExp) {
                                        $start_date = $countExp['users_experiences']['start_date'];
                                        $start_date = '01-' . $start_date;
                                        $start_date = new DateTime($start_date);
                                        if ($countExp['users_experiences']['end_date'] != 'Present') {
                                            $end_date = $countExp['users_experiences']['end_date'];
                                            $end_date = '01-' . $end_date;
                                            $end_date = new DateTime($end_date);
                                        } else {
                                            $end_date = new DateTime(date("d-m-Y"));
                                        }
                                        $diff = $start_date->diff($end_date);
                                        $year_diff += $diff->y;
                                        $month_diff += $diff->m;
                                    }
                                    if ($year_diff >= 1) {
                                        echo $year_diff . " Years";
                                    } else {
                                        echo "less than year";
                                    }
                                }
                                ?></span></li>
                    </ul>
                </div>
                <div class="profileuser-activities">
                    <div class="activity-icon">
    <?php echo $this->Html->image(MEDIA_URL . '/img/big-icon-connect.png', array('style' => 'width:30px; height:30px;')); ?>
                    </div>
                    <ul>
                        <li><strong> <?php echo $this->Html->link('Connections', array('controller' => 'connections', 'action' => 'index', $uid), array('style' => '')) ?></strong> </li>
                        <li><span class="smalltext">
                                <?php
                                if ($totalConnections) {
                                    echo $this->Html->link($totalConnections, array('controller' => 'connections', 'action' => 'index', $uid), array('style' => ''));
                                } else {
                                    echo "0";
                                }
                                ?>
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="profileuser-activities">
                    <div class="activity-icon">
    <?php echo $this->Html->image(MEDIA_URL . '/img/big-icon-follow.png', array('style' => 'width:30px; height:30px;')); ?>
                    </div>
                    <ul>
                        <li><strong>Following</strong> </li>
                        <li>
                            <span class="smalltext"><?php echo ($following) ? $following : "0"; ?></span>
                        </li>
                    </ul>
                </div>
                <div class="profileuser-activities">
                    <div class="activity-icon">
    <?php echo $this->Html->image(MEDIA_URL . '/img/big-icon-followers.png', array('style' => 'width:30px; height:30px;')); ?>
                    </div>
                    <ul>
                        <li><strong>Followers</strong> </li>
                        <li><span class="smalltext"><?php echo ($followers) ? $followers : "0"; ?></span></li>
                    </ul>
                </div>
                <div class="profileuser-activities">
                    <?php
                    foreach ($user_starsign_dob as $starsign__Row) {
                        $your_DOB = $user_Name['users_profiles']['birth_date'];
                        $month_day = date("m-d", strtotime($your_DOB));
                        $stdate = $starsign__Row['Star_sign']['start_date'];
                        $endate = $starsign__Row['Star_sign']['end_date'];
                        $stdate = date("m-d", strtotime($stdate));
                        $endate = date("m-d", strtotime($endate));
                        if ($month_day >= $stdate && $month_day <= $endate) {
                            $id = $starsign__Row['Star_sign']['id'];
                            ?>
                            <div class="activity-icon">
            <?php echo $this->Html->image(MEDIA_URL . '/files/starsign/' . $starsign__Row['Star_sign']['icon'], array('onClick' => 'showStarSign(' . $id . ',' . $uid . ')'), array('style' => 'width:30px; height:30px;', 'class' => 'poplight')); ?>
                            </div>
                            <ul>
                                <li><strong>Star Sign</strong> </li>
                                <li>
                                    <span class="smalltext">
                                        <a href="#?" rel="starbox" onclick="showStarSign('<?php echo $id ?>', '<?php echo $uid ?>')" class="poplight">
            <?php echo $starsign__Row['Star_sign']['name']; ?>
                                        </a>
                                    </span>
                                </li>
                            </ul>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="clear"></div>
            </div>
            <!-- Activities start -->
            <div class="clear"></div>
        </div>
<?php } ?>
    <div class="profile-normal-box">

        <h2>Join Networkwe and see <?php echo $user_Name['users_profiles']['firstname'] . " " . $user_Name['users_profiles']['lastname']; ?>'s full profile.</h2>

        <p>Be a member of <strong>Networkwe</strong> and you will join millions of other professionals, you can share your ideas,  get job opportunities, make connections, write tweets and so on.<br />
        </p>
        <div class="login-indicating-arrow"><img src="<?php echo MEDIA_URL ?>/img/login_indicating_arrow.png" width="90" height="33"/></div>
        <a href="javascript:;" onclick="startIntro();" class="viewprofile current">Sign In / Sign Up to View  Full Profile</a>

        <div class="clear"></div>
    </div>
<?php if ($uSerEDU) { ?>
        <!-- education-->
        <div class="profile-box">
            <div class="profile-box-heading">
                <h1> <div class="profile-box-icon">
    <?php echo $this->Html->image(MEDIA_URL . '/img/education-icon.png', array('style' => '')); ?>
                    </div>
                    <div class="heading-text"><?php echo $user_Name['users_profiles']['firstname'] . " " . $user_Name['users_profiles']['lastname']; ?>'s Education</div></h1>
            </div>
    <?php foreach ($uSerEDU as $Uedu) { ?>
                <div class="profile-box-content">
                    <ul>
                        <li>
                            <h1><?php echo $Uedu['institutes']['title']; ?></h1>
                        </li>
                        <li><?php echo $Uedu['qualifications']['title'] . " in " . $Uedu['users_qualifications']['field_study']; ?></li>
                        <li><?php echo $Uedu['users_qualifications']['start_date'] . " - " . $Uedu['users_qualifications']['end_date']; ?></li>
                    </ul>
                </div>
        <?php } ?>
            <div class="clear"></div>
        </div>
<?php } ?>
<?php if ($uSers_exp) { ?>
        <!--  experience-->
        <div class="profile-box">
            <div class="profile-box-heading">
                <h1>
                    <div class="profile-box-icon">
    <?php echo $this->Html->image(MEDIA_URL . '/img/experience-icon.png', array('style' => '')); ?>
                    </div>
                    <div class="heading-text"><?php echo $user_Name['users_profiles']['firstname'] . " " . $user_Name['users_profiles']['lastname']; ?>'s Experience</div></h1>
            </div>
            <?php
            foreach ($uSers_exp as $totalExp) {
                ?>
                <div class="profile-box-content experience">
                        <ul>
                            <li>
                                <h1><?php echo $totalExp['users_experiences']['designation']; ?></h1>
                            </li>
                            <li><?php echo $totalExp['companies']['title']; ?></li>
                            <li><?php echo $totalExp['users_experiences']['start_date'] . " to " . $totalExp['users_experiences']['end_date']; 
                            echo $totalExp['users_experiences']['location'] ? ' - '.$totalExp['users_experiences']['location'] : '';
                            ?> </li>
                        </ul>
                    <div class="clear"></div>
                </div>
        <?php } ?>
            <div class="clear"></div>
        </div>
    <?php } ?>
    <!-- Skill and expertise--> 
<?php if ($userHaveSkills) { ?>
        <div class="profile-box">
            <div class="profile-box-heading">
                <h1>
                    <div class="profile-box-icon">
    <?php echo $this->Html->image(MEDIA_URL . '/img/skills-icon.png', array('style' => '')); ?>
                    </div>
                    <div class="heading-text"><?php echo $user_Name['users_profiles']['firstname'] . " " . $user_Name['users_profiles']['lastname']; ?>'s Skill &amp; Expertise</div>
                </h1>
            </div>
            <div class="editprofile">
                <?php
                if ($userHaveSkills) {
                    $i = 1;
                    foreach ($userHaveSkills as $userListSkill) {
                        $skill_ids = $userListSkill['skills']['id'];
                        ?>
                        <div class="editprofile-skill" id="delete-skill">
                            <a href="javascript:void(0)" class="blockers-number"><?php echo $userListSkill[0]['total_recommendations']; ?></a>
                            <div class="blockers-text"><a href="javascript:;"><?php if ($i != 1) echo ""; echo $userListSkill['skills']['title']; ?></a>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <?php
                    }
                }
                ?>
                <div class="clear"></div>    
            </div>
            <div class="clear"></div>
        </div>
<?php } ?>
    <div class="popup_block" id="starbox" style="position:absolute;">
    </div>
</div>