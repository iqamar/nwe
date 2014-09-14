<div class="left_p_user">
<ul class="menu accordion">
<li class="section">
<a  class="section-head">Update your profile</a>
</li>
</ul>  
<ul class="expanded">
<!--<li class="profile"><?php echo $this->Html->link(__('Profile'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'myprofile'),array('class'=>'selected')); ?></li>-->
<li class="profile"><?php echo $this->Html->link(__('Edit Profile'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'profile'),array('class'=>'selected')); ?></li>
<li class="profile"><?php echo $this->Html->link(__('Photo'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'userphoto')); ?></li>
<li class="profile"><?php echo $this->Html->link(__('Summary'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'profile_summary')); ?></li>
<li class="edu"><?php echo $this->Html->link(__('Education '), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'useredu')); ?></li>
 
<li class="exp"><?php echo $this->Html->link(__('Experience'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'display')); ?></li>

<li class="exp"><?php echo $this->Html->link(__('Short Courses'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'display')); ?></li>
<li class="exp"><?php echo $this->Html->link(__('Trainings/Awards'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'display')); ?></li>


<li class="skill"><?php echo $this->Html->link(__('Professional Skills'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'showskills')); ?></li>

<li class="skill"><?php echo $this->Html->link(__('Voluntary work'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'showskills')); ?></li>
<li class="skill"><?php echo $this->Html->link(__('Alumni/ memberships'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'showskills')); ?></li>

<li class="skill"><?php echo $this->Html->link(__('Hobbies'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'showskills')); ?></li>

<!--<li class="profile"><?php echo $this->Html->link(__('Profile Handler'), array('plugin' => false, 'admin' => false, 'controller' => 'publices', 'action' => 'public_profile')); ?>
</li>-->
<li class="profile"><?php echo $this->Html->link(__('Availability Status'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'hire_status')); ?>
</li>
<!--<li class="password"><?php echo $this->Html->link(__('Change Password'), array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'account')); ?></li>
-->
</ul>
</div>
