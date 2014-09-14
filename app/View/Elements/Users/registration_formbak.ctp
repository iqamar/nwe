<script>
jQuery(document).ready(function(){
	jQuery("#step1Submit").click(function(){
	
		jQuery.post("<?=$this->request->base?>/users/ajax_signup_step1", jQuery("#regForm").serialize(), function(data){
			
			if (data.indexOf('mooError') > 0) {
			
				jQuery("#regError").show();
				jQuery("#regError").html(data);
				
			} else {
			alert("signup called");
				jQuery("#regError").hide();
				
			}
		});
		
	});

});

</script>


<div class="rgt-container">
									<div class="ttle-bar">Create a new account</div>
<!--<div class="socil-div">
		  
		 
        	<ul><li>Register with a social network&nbsp;&rarr;&nbsp;</li>			
            	<li><a href="#"><img src="<?php echo $this->base;?>/images/in-icon.png" alt="Linked in" title="Linked in" height="25" width="25" /></a></li>
                <li><a href="#"><img src="<?php echo $this->base;?>/images/fb-icon.png" alt="Facebook" title="Facebook" height="25" width="25" /></a></li>
                <li><a href="#"><img src="<?php echo $this->base;?>/images/tw-icon.png" alt="Twitter" title="Twitter" height="25" width="25" /></a></li>
                <li><a href="#"><img src="<?php echo $this->base;?>/images/gp-icon.png" alt="Google Plus" title="Google Plus" height="25" width="25" /></a></li>                
            </ul>
			 
        </div>-->
									<div class="contact-form">
									    <style type="text/css">
										input.styled { display: none; } select.styled { position: relative; width: 190px; opacity: 0; filter: alpha(opacity=0); z-index: 5; } .disabled { opacity: 0.5; filter: alpha(opacity=50); }
									    </style>
										<?php 
										echo $this->Form->create("User",array('controller' => 'users', 'action' => 'ajax_signup_step1', 'class' => 'user_reg'));?>
										
									    <ul>
										<li class="txt">
										    <label><?=__('User Type')?></label>
										</li>
										<li class="selectbox textfield">										    
                                            <select name="data[User][role_id]" id="role_id" class="req no-bder no-bg" style="width:100%;">
                                            <?php foreach ($user_Roles as $role_Row) {?>
                                            		<option value="<?php echo $role_Row['roles']['id']?>"><?php echo $role_Row['roles']['alias']?></option>
                                            <?php }?>
                                            </select>
										</li>
									
										
										<li class="clr"></li>
										<li class="txt">
										    <label><?=__('EMAIL ID (USERNAME)')?></label>
										</li>
										<li class="textfield">
												<?php echo $this->Form->email('email', array('required'=>true, 'class' => 'req v-email no-bder no-bg')) ?>										    
										</li>
										<li class="clr"></li>
										<li class="txt">
										    <label><?=__('Password')?></label>
										</li>
										<li class="textfield">
										<?php echo $this->Form->password('password', array('type' => 'password', 'class' => 'req no-bder no-bg')) ?>
										    
										</li>
										<li class="clr"></li>
										<li>
										<input type="submit" value="Register" class="intbtn-srch boxsize topmrg" style1="margin-left:7px;">
										<?php //echo $this->Form->end('', array('class' => 'intbtn-srch boxsize topmrg')); ?>
										</li>
										<li class="clr"></li>
										<li class="txt">
										    <label><a href="#" class="netlink">Already on NetworkWe? Sign in</a></label>
										</li>
										<li class="clr"></li>
										

									    </ul>
										</form>
									</div>
								    </div>
									
		
		<div id="regError"></div>	
				
				</div>