<?php echo $this->Html->script(array(MEDIA_URL.'/js/jquery.validate.js', MEDIA_URL.'/js/jquery.form.js')); ?>

<script type="text/javascript">
	
    var ajaxProcess = false;
    $(document).ready(function() {
		           
        $('#forgot_password_form').submit(function(e) {
            e.preventDefault();
            formStatus = $('#forgot_password_form').validate({
                rules: { forgot_password_email: { required: true, minlength: 10 ,email: true } },
                messages: { forgot_password_email: { email: "Please check email address", required: "We need your email address to contact you", minlength: jQuery.format("At least {0} characters required!") } },
                onkeyup: false,
                onclick: false,
                onfocusout: false,
                errorClass: 'error_msg',
                errorElement:'div',
                errorPlacement: function(error, element) {
                    if($(element).attr("name")=="forgot_password_email"){
                        error.insertAfter("#forgot_password_btn");
                    }
                    else
                        error.insertAfter(element);
                },
                highlight: function(element) { $(element).removeClass("error_msg"); }
            }).form();
            if(formStatus && !ajaxProcess){
                ajaxProcess = true;
                $.ajaxSetup({
                    beforeSend: function(){
                        $('#forgot_password_btn').val('Please wait...');
                    },
                    complete: function() {
                        $('#forgot_password_btn').val('Submit');
                    }
                });
                $.ajax({
                    dataType: "html", type: "POST", evalScripts: true,
                    url: "<?php echo NETWORKWE_URL ?>/users/forgot_password/",
                    data: $("#forgot_password_form").serialize(),
                    success: function(data) {
                        ajaxProcess = false;
                        if (data == 1) {
                            $("#forgot_password_thankyou h3").append($("#forgot_password_email").val());
                            $("#forgot_password_master").hide();
                            $("#forgot_password_error").hide();
                            $("#forgot_password_thankyou").fadeIn('slow').delay(5000).fadeOut();
                            $("#forgot_password_master").delay(6000).fadeIn('slow');
                        } else if (data == 0) {
                            $("#forgot_password_master").hide();
                            $("#forgot_password_thankyou").hide();
                            $("#forgot_password_error").fadeIn('slow').delay(5000).fadeOut();
                            $("#forgot_password_master").delay(6000).fadeIn('slow');
                            //alert("The email address you entered is not registered with NetworkWe Account.")
                        } else {
                            alert("Error occured. Please try again.")
                        }
                    }
                });
            }
            else {
                ajaxProcess = false;
            }
        });
    });
</script>
<?php echo $this->Form->create("User", array('controller' => 'users', 'method' => 'post', 'action' => 'login', 'class' => 'login_form')); ?>
<table width="100%" border="0" cellspacing="2" cellpadding="1">
    <tr>
        <td colspan="2">
            <?php echo $this->Form->input('email', array('required' => true, 'type' => 'email', 'label' => false, 'div' => false, 'placeholder' => 'User ID', 'class' => 'textfield width1 signin-text', 'size' => '26')); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $this->Form->input('password', array('required' => true, 'type' => 'password', 'label' => false, 'div' => false, 'placeholder' => 'Password', 'class' => 'textfield width1 signin-text', 'size' => '26')); ?>
        </td>
    </tr>
    <tr>
        <td width="36%">
            <?php echo $this->Form->submit('Sign in', array('type' => 'submit', 'label' => false, 'class' => 'red-bttn')); ?>
        </td>
        <td width="64%" align="right">
            <?php echo $this->Html->link('Forgot Password?', '#?', array('rel' => 'forgot_password', 'class' => 'poplight current', 'escapeTitle' => false, 'id' => 'np')); ?>
        </td>
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

