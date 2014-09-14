<?php if(!empty($data)): ?>
<?php 
$i=1;
foreach($data as $row){
    $class='row';
    if($i++ % 2 ==0){
        $class ='altrow';
    }
    if(!empty($row['Job']['title']))
        echo "<li class='".$class."'>".$this->Html->image($jobsite.'/img/company_logos/'.$row['Company']['logo'],array('class'=>'compLogo'))."<div class='leftrow'>".$this->Html->link($row['Job']['title'],'http://jobs.localhost.com/search/jobDetails/'.$row['Job']['id'],array('escape'=>false,'class'=>'resultTitle'))."</a><div id='jobsDesc'>".$this->Html->Image('company-icon.png',array('width'=>16))."&nbsp;&nbsp;".$row['Company']['title']."</div></div><div style='clear:both'></div></li>";
}
?>
<?php endif ?>