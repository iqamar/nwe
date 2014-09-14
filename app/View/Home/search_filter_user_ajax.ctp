<?php if(!empty($datau)): ?>
<?php 
$i=1;
foreach($datau as $row){
    $class='row';
    if($i++ % 2 ==0){
        $class ='altrow';
    }
    if(!empty($row['Users_profile']['firstname']))
        echo "<li class='".$class."'>".$this->Html->image('/files/users/'.$row['Users_profile']['photo'],array('class'=>'compLogo'))."<div class='leftrow'>".$this->Html->link($row['Users_profile']['firstname'],'/users_profiles/userprofile/'.$row['Users_profile']['id'],array('escape'=>false,'class'=>'resultTitle'))."</a><div id='jobsDesc'>".$this->Html->Image('company-icon.png',array('width'=>16))."&nbsp;&nbsp;".$row['Users_profile']['tags']."</div></div><div style='clear:both'></div></li>";
}
?>
<?php endif ?>