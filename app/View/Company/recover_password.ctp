<style type="text/css">
.contact-form { width: 500px!important; }
.maps { height: 500px; width: 400px; }
html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
.ttle-abt { margin: 15px 0 15px 15px; }
.contact-form ul li { list-style: none!important;}

.flash {
    color: #333333;
    margin: 10px 0 5px;
    padding: 10px;
}
.flash_failure{
 background: none repeat scroll 0 0 #FBE6F2;
    border: 1px solid #D893A1;
}
.flash_success{
 background: none repeat scroll 0 0 #DEFADE;
    border: 1px solid #267726;
}
.error{color:#CE1B18;font-size:12px;}
.flash_warning {
 color: #9F6000;
 background-color: #FEEFB3;
 border: 1px solid #D893A1;
}
.error_message { margin:10px; color:#C10000; font-size:12px;}

</style>
<script>
function validateForm() {
	var password = document.getElementById('password').value;	
	var confirm_password = document.getElementById('confirm_password').value;	
	
	if (password == '') {
		
		$("#span_password").html("Enter your New password");
		$("#password").focus();
		return false;
	}
	else if (confirm_password == '') {
		
		$("#span_confirm_password").html("Enter confirm password");
		$("#confirm_password").focus();
		return false;
	}
	if (password != confirm_password) {
		
		$("#password_mismatch").html("Your passwords does not match!");
		$("#password").focus();
		return false;
	}
	else {
			return true;
	}
}
</script>

<div class="reset_box">
    <div>
        <div class="greybox-div-heading"> 
            <h1>Reset Your Password</h1>
        </div>
        <?php echo $this->Form->create('User', array('url' => '/users/recover_password/','name'=>'myform','id'=>'forgot_form','onsubmit'=>'return validateForm();')); ?>
            <table width="100%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                    <td colspan="2">To verify your new password, please enter it once in each field below.      <br />
                        <br />
                        Passwords are case-sensitive and must be at least 6 characters long. A good password should contain a mix of capital and lower-case letters, numbers and symbols.</td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="28%"><label for="">Enter new password:</label></td>
                    <td width="72%">
                    <?php if ($email) { ?>
                    <?php echo $this->Form->text('email', array('required'=>true,'value'=>$email,'type' => 'hidden','id' => 'email')); ?>
                    <?php }?>
                    <?php echo $this->Form->password('password', array('required'=>true,'type' => 'password', 'placeholder' => 'New Password', 'class' => 'textfield','id' => 'password')); ?>
                    </td>
                </tr>
                <tr>
                    <td><label for="">Re-enter new password:</label>
                    </td>
                    <td>
                    <?php echo $this->Form->password('confirm_password', array('required'=>true,'type' => 'password', 'placeholder' => 'Retype New Password', 'class' => 'textfield','id' => 'confirm_password')); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><?php echo $this->Form->submit('Reset Password',array('class'=>'red-bttn')); ?></td>
                </tr>
            </table>
        <?php echo $this->Form->end(); ?>
    </div>
</div>