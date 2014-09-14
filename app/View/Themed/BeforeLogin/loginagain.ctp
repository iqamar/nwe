<div class="maincontent">
    <div class="error_msg">Your session has been expired. Please login again to continue.</div>
    <div class="login_error_box">
        <div>
            <div class="greybox-div-heading"> 
                <h1>Sign in to Networkwe</h1>
            </div>
            <?php echo $this->Form->create("User", array('controller' => 'users', 'method' => 'post', 'action' => 'login', 'class' => 'login_form')); ?>
                <table width="100%" border="0" cellspacing="2" cellpadding="1">
                    <tr>
                        <td>
                        <?php echo $this->Form->input('email', array('required' => true, 'type' => 'email', 'label' => false, 'div' => false, 'placeholder' => 'User ID', 'class' => 'textfield signin-text', 'size' => '26')); ?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                        <?php echo $this->Form->input('password', array('required' => true, 'type' => 'password', 'label' => false, 'div' => false, 'placeholder' => 'Password', 'class' => 'textfield signin-text', 'size' => '26')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $this->Form->submit('Sign In', array('type' => 'submit', 'label' => false, 'div' => false, 'class' => 'red-bttn')); ?> or <a href="<?php echo NETWORKWE_URL ?>">Join Networkwe</a></td>
                    </tr>
					<tr>
						<td colspan="2">
							<div class="margintop10">
								<?php echo $this->Form->input('remember_me', array('type' => 'checkbox','id'=>'remember_me','value'=>'1','label' => false, 'div' => false)); ?>&nbsp;Keep me Logged in
							</div>
						</td>
					</tr>
                </table>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<div class="clear"></div>
