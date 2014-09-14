
       
<div class="left_p_user">
<ul class="menu accordion">
<li class="section">
<a href="/users/profile" class="section-head">NetworkWe</a>
</li>
</ul>
<ul class="expanded">
<li class="profile"><?php echo $this->Html->link(__('Profile'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'profile'),array('class'=>'selected')); ?></li>
<li class="password"><?php echo $this->Html->link(__('Change Password'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'account')); ?></li>
<li class="exp"><?php echo $this->Html->link(__('Experience'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'display')); ?></li>
<li class="skill"><?php echo $this->Html->link(__('Skills'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'showskills')); ?></li>
<li class="edu"><?php echo $this->Html->link(__('Qualification'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'useredu')); ?></li>
<li class="edu"><?php echo $this->Html->link(__('Connections'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'search')); ?></li>
<li class="edu"><?php echo $this->Html->link(__('Take Photo'), array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'takephoto')); ?></li>
</ul>
</div>
<div id="photos"></div>

<div id="camera">
	<span class="tooltip"></span>
	<span class="camTop"></span>
    
    <div id="screen"></div>
    <div id="buttons">
    	<div class="buttonPane">
        	<a id="shootButton" href="" class="blueButton">Shoot!</a>
        </div>
        <div class="buttonPane hidden">
        	<a id="cancelButton" href="" class="blueButton">Cancel</a> <a id="uploadButton" href="" class="greenButton">Upload!</a>
        </div>
    </div>
    
    <span class="settings"></span>
</div>


