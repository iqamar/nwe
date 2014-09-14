<div class="maincontent">
    <?php if(!empty($status) && $status ==  'sent'): ?>
    <div class="success_msg">Please check your inbox and confirm your email.</div>
    <?php elseif(!empty($status) && $status ==  'confirmed'): ?>
    <div class="success_msg">Email already confirmed.</div>
    <?php elseif(!empty($status) && $status ==  'invalid'): ?>
    <div class="success_msg">Email not registered with <?php echo SITE_TITLE?>.</div>
    <?php endif;?>
    <h3>If you need us to resend your verification email, please select "Resend"s below. A verification message will be sent to the email address you provided in your application profile. If you do not receive the verification email, make sure to check your SPAM folder!</h3>
    <div class="login_error_box">
        <div>
            <div class="greybox-div-heading"> 
                <h1>Resend confirmation mail</h1>
            </div>
            <?php echo $this->Form->create("User", array('type' => 'post', 'controller' => 'users', 'action' => 'resend_verification', 'class' => 'resend_confirmation')); ?>
                <table width="100%" border="0" cellspacing="2" cellpadding="1">
                    <tr>
                        <td><?php echo $this->Form->input('email', array('required' => true, 'name'=>'n', 'type' => 'email', 'label' => false, 'div' => false, 'placeholder' => 'Email', 'class' => 'textfield signin-text', 'size' => '26')); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $this->Form->submit('Resend', array('type' => 'submit', 'label' => false, 'div' => false, 'class' => 'red-bttn')); ?></td>
                    </tr>
                </table>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<div class="clear"></div>