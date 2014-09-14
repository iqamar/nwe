<?php
foreach ($user_qualification as $edu__Row) {
    $start_date = $edu__Row['users_qualifications']['start_date'];
    $end_date = $edu__Row['users_qualifications']['end_date'];
    $edu_id = $edu__Row['users_qualifications']['id'];
    ?>
    <div class="profile-box-content" id="<?php echo $edu_id; ?>">
        <ul>
            <li>
                <h1><?php echo $edu__Row['institutes']['title']; ?></h1>
            </li>
            <li><?php echo $edu__Row['qualifications']['title']; ?></li>
            <li><?php echo $start_date . " - " . $end_date; ?></li>
            <li><a href="#?" rel="editEdu" onclick="edit_edu('<?php echo $edu_id; ?>')" class="poplight edit">Edit</a> <a href="javascript:void(0)" onclick="delete_edu('<?php echo $edu_id;?>');" class="delete">Remove Education</a></li>
        </ul>
        <div class="clear"></div> 
        <?php
        /*if ($edu__Row['institutes']['logo']) {
            echo $this->Html->image(MEDIA_URL . '/files/institutes/logo/' . $edu__Row['institutes']['logo'], array('style' => 'width:60px; height:60px; float:right;'));
        } else {
            echo $this->Html->image(MEDIA_URL . '/img/nologo.jpg', array('style' => 'width:60px; height:60px; float:right;'));
        }*/
        ?> 
    </div>
<?php
}?>