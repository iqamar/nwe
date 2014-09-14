<div class="left_p_user">
<ul class="menu accordion">
<li class="section">
<a href="/users/profile" class="section-head">NetworkWe</a>
<ul class="expanded">
<li><?php echo $this->Html->link(__('Profile'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'profile')); ?></li>
<li><?php echo $this->Html->link(__('Account Setting'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'account')); ?></li>
<li><?php echo $this->Html->link(__('Experience'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'userexp'),array('class'=>'selected')); ?></li>
<li><?php echo $this->Html->link(__('Skills'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'skill')); ?></li>
<li><a href="#">Posts</a></li>
</ul>
</li>
</ul>
</div>