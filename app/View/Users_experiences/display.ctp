<?php dump($exp);?>
<div class="left_p_user">
<ul class="menu accordion">
<li class="section">
<a href="/users/profile" class="section-head">NetworkWe</a>
<ul class="expanded">
<li><?php echo $this->Html->link(__('Profile'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'profile'),array('class'=>'selected')); ?></li>
<li><?php echo $this->Html->link(__('Account Setting'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'account')); ?></li>
<li><?php echo $this->Html->link(__('Experience'), array('plugin' => false, 'admin' => false, 'controller' => 'userexps', 'action' => 'index')); ?></li>
<li><?php echo $this->Html->link(__('Skills'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'skill')); ?></li>
<li><a href="#">Posts</a></li>
</ul>
</li>
</ul>
</div>

<div class="settings-content">
<?php foreach ($exps as $ex) {
//print_r($exps);

?>
<div class="boxed-group">
<h3><?php echo $ex['Users_experience']['company'];?></h3>
<div class="boxed-group-inner" style="height:140px;">
<?php 
echo $this->AlaxosForm->tableHeaders(array('Employer', 'Designation', 'Start Date','End Date'));
echo $this->AlaxosForm->tableCells(array( array($ex['Users_experience']['employer'], array($ex['Users_experience']['designation']) , array($ex['Userexp']['start_date']), $ex['Users_experience']['end_date'])));
?>
</div>
</div>
<?php }?>
</div>