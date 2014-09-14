<div class="maincontent">
    <div class="success_msg">Reset Password for Networkwe Account.</div>
    <p>A reset password link is sent to your mentioned email.</p>
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
                        <td><?php echo $this->Form->submit('Sign in', array('type' => 'submit', 'label' => false, 'div' => false, 'class' => 'red-bttn')); ?> or <a href="<?php echo NETWORKWE_URL ?>">Join Networkwe</a></td>
                    </tr>
                </table>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<div class="clear"></div>