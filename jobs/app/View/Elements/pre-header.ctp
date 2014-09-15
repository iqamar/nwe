<div id="header-innerpage">
    <div id="header-content">
        <?php echo $this->Html->link('', '/', array('escape' => false, 'id' => 'logo-innerpage', 'title' => 'NetworkWe')); ?>
        <div id='cssmenu'>
            <ul>
                <li class="<?php
                if ($this->params['controller'] == 'home' || $this->params['controller'] == ' ')
                    echo 'has-sub active';
                else
                    echo 'has-sub';
                ?>">
                        <?php echo $this->Html->link('<span>Home</span>', NETWORKWE_URL . '/home/index', array('escape' => false, 'class' => 'active')); ?>
                </li>
                <li class="<?php
                if ($this->params['controller'] && $this->params['controller'] == 'users_profiles')
                    echo 'has-sub active';
                else
                    echo 'has-sub';
                ?>">
                    <?php echo $this->Html->link('<span>Profile</span>', NETWORKWE_URL . '/users_profiles/myprofile', array('escape' => false)); ?>
                    
                     <ul>
                        <li><?php echo $this->Html->link('Edit Profile', NETWORKWE_URL . '/users_profiles/update', array('escape' => false)); ?></li>
                    </ul>
                    </li>
                <li class="<?php
                if ($this->params['controller'] == 'connections' || $this->params['controller'] == 'companies' || $this->params['controller'] == 'groups')
                    echo 'has-sub active';
                else
                    echo 'has-sub';
                ?>">
                        <?php echo $this->Html->link('<span>Connections</span>', NETWORKWE_URL . '/connections', array('escape' => false)); ?>
                    <ul>
                    	<li><?php echo $this->Html->link('Professionals', NETWORKWE_URL . '/connections/professionals', array('escape' => false)); ?></li>
                        <li><?php echo $this->Html->link('Friends', NETWORKWE_URL . '/connections/friends', array('escape' => false)); ?></li>
                        <li><?php echo $this->Html->link('Companies', NETWORKWE_URL . '/companies/', array('escape' => false)); ?></li>
                        <li><?php echo $this->Html->link('Groups', NETWORKWE_URL . '/groups/', array('escape' => false)); ?></li>
                    </ul>
                </li>
                <li class="active <?php if ($this->params['controller'] && $this->params['controller'] == 'jobs')
                            echo 'has-sub active';
                        else
                            echo 'has-sub';
                        ?>">
                <?php echo $this->Html->link('<span>Jobs</span>', 'http://jobs.networkwe.com', array('escape' => false)); ?></li>
                <li class="<?php
                if ($this->params['controller'] && $this->params['controller'] == 'tweets')
                    echo 'has-sub active';
                else
                    echo 'has-sub';
                ?>">
                <?php echo $this->Html->link('<span>Tweets</span>', NETWORKWE_URL . '/tweets', array('escape' => false)); ?></li>
                <li class="<?php
                if ($this->params['controller'] && $this->params['controller'] == 'blogs')
                    echo 'has-sub active';
                else
                    echo 'has-sub';
                ?>">
<?php echo $this->Html->link('<span>Blogs</span>', NETWORKWE_URL . '/blogs', array('escape' => false)); ?></li>
            </ul>
        </div>
        
        <div class="clear"></div>
        <div class="topsearcharea">
            
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>

