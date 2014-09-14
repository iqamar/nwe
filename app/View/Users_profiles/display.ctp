<?php echo $this->element('edit_profile_menus'); ?>
<div class="settings-content" style="float: left; width: 70%;">
<div class="boxed-group">
<h3><?php echo $this->Html->image('/img/add.png',array('url'=> array('controller' =>'users_profiles','action'=>'userexp')));?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo 'Add Experience';?></h3>
</div>
<?php foreach ($exps as $ex) {
//print_r($exps);

?>
<div class="boxed-group">
<h3><?php echo $ex['users_experiences']['company'];?></h3>
<div class="boxed-group-inner" style="height:100px;">
<table width="100%" cellpadding="2" cellspacing="2">
<?php 
echo $this->Html->tableHeaders(array('Company' , 'Designation', 'Start Date','End Date','Edit','Delete'), array(), array('class' =>'topheader'));
echo $this->Html->tableCells(array($ex['companies']['title'], $ex['users_experiences']['designation'] , $ex['users_experiences']['start_date'], $ex['users_experiences']['end_date'],$this->Html->image('/img/edit.png',array('url'=> array('controller' =>'users_profiles','action'=>'edit_exp',$ex['users_experiences']['id']))), $this->Html->image(
                '/img/del.png',array('url'=> array('controller' =>'users_experiences','action'=>'delete',$ex['users_experiences']['id'])), array('confirm' => 'Are you sure?'))));



?>
</table>
</div>
</div>
<?php }?>
</div>