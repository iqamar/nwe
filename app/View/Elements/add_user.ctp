<div class="item-list"><h3>Create a new account</h3></div>
		<form action="<?=$this->request->base?>/users/add" method="post">
		<?php 
		echo $this->Form->input('First Name');
		echo $this->Form->input('Last Name');
		echo $this->Form->input('Email Address');
		echo $this->Form->input('Password');
		?>
		<input type="submit" value="<?=__('Login')?>" class="sm-button">
		</form>
		<div class="item-list"><h5>Already on NetworkWe? <a href="#">Sign in</a></h5></div>
       </div>
	</div>