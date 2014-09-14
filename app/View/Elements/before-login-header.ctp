<div id="header-innerpage">
    <div id="header-content">
		<div id="header-left-content">
		<div class="header-logo-area">
			<?php echo $this->Html->link('', '/', array('escape' => false, 'id' => 'logo-innerpage', 'title' => 'NetworkWe','class'=>'current')); ?>
			<div class="findus-icons">
				<ul>
					
					<li><a href="https://www.facebook.com/NetworkWe" target="_blank" class="fb"></a></li>
					<li><a href="https://twitter.com/networkwe" target="_blank" class="twitter"></a></li>
					<li><a href="https://plus.google.com/+Networkwe" target="_blank" class="gplus"></a></li>
					<li><a href="http://www.linkedin.com/company/networkwe" rel="publisher" target="_blank" class="linkedin"></a></li>
					<li><a href="http://www.pinterest.com/networkwe/" rel="publisher" target="_blank" class="pinterest"></a></li>
					<li><a href="http://instagram.com/network_we" rel="publisher" target="_blank" class="instagram"></a></li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
		<div class="header-mid-area">
        <div id='cssmenu'>
            <ul>
                <li class="<?php
                if ($this->params['controller'] == 'home' || $this->params['controller'] == ' ')
                    echo 'has-sub active';
                else
                    echo 'has-sub';
                ?>">
                        <?php echo $this->Html->link('<span>Home</span>', NETWORKWE_URL . '/', array('escape' => false, 'class' => 'current active')); ?>
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
                <li class="<?php if ($this->params['controller'] && $this->params['controller'] == 'jobs')
                            echo 'has-sub active';
                        else
                            echo 'has-sub';
                        ?>">
                <?php echo $this->Html->link('<span>Jobs</span>', JOBS_URL, array('class'=>'current','escape' => false)); ?></li>
                <li class="<?php
                if ($this->params['controller'] && $this->params['controller'] == 'tweets')
                    echo 'has-sub active';
                else
                    echo 'has-sub';
                ?>">
                <?php echo $this->Html->link('<span>Tweets</span>', NETWORKWE_URL . '/tweets', array('class'=>'current','escape' => false)); ?></li>
                <li class="<?php
                if ($this->params['controller'] && $this->params['controller'] == 'blogs')
                    echo 'has-sub active';
                else
                    echo 'has-sub';
                ?>">
				<?php echo $this->Html->link('<span>Blogs</span>', NETWORKWE_URL . '/blogs', array('class'=>'current','escape' => false)); ?></li>
            </ul>
        </div>
		<?php //print_r($countryList); ?>
		 <div class="topsearcharea">
            <div class="topsearch">
                <table width="200" border="0" cellspacing="0" cellpadding="0">
                    <tr>
						
						<?php echo $this->Form->create('searchFilter',array('id'=>'myform','name'=>'myform')); ?>
                        <td>
                           <input type="text" class="srh-icon ui-autocomplete-input textfield width2 search" name="keyword" placeholder=" Search by member name" id="keyword" />
						   
                        </td>
                        <td>
							<?php echo $this->Form->input('location',array('type'=>'select','options'=>array(''=>'In All Locations',$countryList),'default' => 0,'id'=>'location','class'=>'default','style'=>'width:145px;padding:6px;margin:2px;','label'=>false,'div'=>false)); ?>
                              
                        </td>
                        <td>
							<input type="submit" value="" id="submit_btn" class="headersearchbutton">
                        </td>
						<?php echo $this->Form->end(); ?>
                    </tr>
                </table>
            </div>
			<div id="display"></div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
		</div>
		</div>
        <div id="header-innerpage-rgt">
            <div class="userpic">
				
			</div>
            <div class="signout">
				<div id='userarea'>
					<ul>
						<li class='has-sub'><a href='#' class="myaccount">Register</a></li>
						<?php echo $this->Html->link('Sign In', array('controller' => 'users', 'action' => 'login'), array('class'=>'signout','escape' => false)); ?>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
			<div class="header-small-links">
				<ul>
					<li><a href="<?php echo NETWORKWE_URL  ?>/the-company/aboutus/" class="current">About Us</a></li>
					<li><a href="<?php echo NETWORKWE_URL ?>/the-company/contactus/" class="current">Contact Us</a></li>
					<li><a href="#" onclick="showChat(this);" value="1" id="chdiv">Chat</a></li>
				</ul>
			</div>
        </div>
        <div class="clear"></div>
       
    </div>
</div>
<div class="clear"></div>
<script>
	$(function() {
	
	$("#keyword").keypress(function(e) {

         if(e.which == 13) {
             e.preventDefault();
             $("#submit_btn").click();
          }
    });
	
      $('#submit_btn').click(function(event){
		var keyword = document.getElementById("keyword").value;
		var country = document.getElementById("location").value;
		var page = 1;
 
		var dataString = 'query:' + keyword + '/scope:' + country;
			
		$("#ser").html("<img src='http://media.networkwe.com/img/loading.gif' style='margin:200px 0px 0px 450px;' alt='Networkwe' />");
        $.ajax({
              url     : '/home/searchFilter/'+dataString,
              type    : 'GET',

			cache: false,
              //data    : {keyword: keyword,country:country,page:page},
              success : function(data){
				
				 $("#ser").html(data);
				 
              },
			 error : function(data) {
			   $("#ser").html("there is error");
			}
          });
    
     return false;  
     });
	 
	 });

</script>
