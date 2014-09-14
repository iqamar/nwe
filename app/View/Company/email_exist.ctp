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
<div class="maincontent">
    <div class="error_msg">The email address you entered is already being used for the NetworkWe Account.</div>
    <div class="login_error_box">
        <div>
            <div class="greybox-div-heading" style="width:200px;float:left;"> 
                <h1>Sign in to Networkwe</h1>				
            </div>
			<div style="margin:15px;width:115px;float:left;">
			or	<a href="<?php echo NETWORKWE_URL ?>">Join Networkwe</a>
			</div>
			<div class="clear"></div>
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
                        <td><?php echo $this->Form->submit('Sign in', array('type' => 'submit', 'label' => false, 'div' => false, 'class' => 'red-bttn')); ?> or 
						
						<?php echo $this->Html->link('Forgot Password?', '#?', array('rel' => 'forgot_password', 'class' => 'poplight', 'escapeTitle' => false, 'title' => '')); ?>
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
        </div>
    </div>
</div>
<div class="clear"></div>
<!--- Login Box Starts Here --->
<div id="forgot_password" class="popup_block" style="width:500px;">
    <div class="popup-heading"><h1>Forgot Password</h1></div>
    <div id="forgot_password_master">
        <form action="" id="forgot_password_form" method="get" class="loginformstyle">
            <fieldset>
                <label style="width:500px;" for="">Please enter your email to reset your password</label>
                <label1 style="width:500px;">
                    <input name="forgot_password_email" type="text" class="required email textfield width1 signin-text" id="forgot_password_email" placeholder="email address"/> 
                    <?php echo $this->Form->submit('Submit', array('type' => 'submit', 'id'=> 'forgot_password_btn','label' => false, 'div' => false,'class' => 'red-bttn')); ?>
<!--                    <input type="submit" id="forgot_password_btn" <?php /*onclick="return sendPassword('forgot_password_form');" */?> value="Submit" />-->
                </label1>
            </fieldset>
        </form>
    </div>
    <div id="forgot_password_error" style="display:none;">
        <h3>The email address you entered is not registered with NetworkWe Account.</h3>
    </div>
    <div id="forgot_password_thankyou" style="display:none;">
        <h3>A password reset email has been sent to </h3>
    </div>
    <div id="forgot_password_invalid" style="display:none;">
        <h3>Not a valid email.</h3>
    </div>
</div>
<!--- Login Box Ends Here --->