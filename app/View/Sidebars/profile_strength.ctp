<?php if ($profile_strength_user) {?>
<div class="greybox">
    <div class="greybox-div-heading">
        <h1>Profile Strength</h1>
    </div>
<?php  $total_profile_strength ='';
	//foreach ($profile_strength_user as $strenth_row) {
		$registration = $profile_strength_user['User_profile_strength']['registration'];
		$summary = $profile_strength_user['User_profile_strength']['summary'];
		$handler = $profile_strength_user['User_profile_strength']['handler'];
		$photo = $profile_strength_user['User_profile_strength']['photo'];
		$experience = $profile_strength_user['User_profile_strength']['experience'];
		$skills = $profile_strength_user['User_profile_strength']['skills'];
		$qualification = $profile_strength_user['User_profile_strength']['qualification'];
		$connections = $profile_strength_user['User_profile_strength']['connections'];
		$followers = $profile_strength_user['User_profile_strength']['followers'];
		$following = $profile_strength_user['User_profile_strength']['following'];
		
		if ($registration) {
			$total_profile_strength += $registration; 
		}
		if ($summary) {
			$total_profile_strength += $summary; 
		}
		if ($handler) {
			$total_profile_strength += $handler; 
		}
		if ($photo) {
			$total_profile_strength += $photo; 
		}
		if ($experience) {
			$total_profile_strength += $experience; 
		}
		if ($skills) {
			$total_profile_strength += $skills; 
		}
		if ($qualification) {
			$total_profile_strength += $qualification; 
		}
		if ($connections) {
			$total_profile_strength += $connections; 
		}
		if ($followers) {
			$total_profile_strength += $followers; 
		}
		if ($following) {
			$total_profile_strength += $following; 
		}
		
	?>
    <div>
	<div class="profile_strength_bg">
		<div class="counter-bar">
			<div style="width:<?php echo $total_profile_strength;?>%;">
				<div class="circle-percent"><?php echo $total_profile_strength."%";?></div>
			</div>
		</div>
		<div class="strength-bar">
			<?php if ($total_profile_strength < 100) {?>
			<div class="profile-bar" style="width:<?php echo $total_profile_strength;?>%;"></div>
			<?php } 
			else {?>
   			 <div class="profile-bar" style="width:<?php echo $total_profile_strength;?>%; background:#2D9427;"></div>
   			 <?php }?>
		</div>
	</div>
	<br />
	<sapn style="color:<?php if($total_profile_strength <=20) echo '#C70000'; else echo '#333';?> ;padding:0px 13px;">NEW USER</span> 
	<sapn style="color:<?php if($total_profile_strength > 20 && $total_profile_strength <= 70) echo '#C70000'; else echo '#333';?>;padding:0px 13px;">INTERMEDIATE</span> 
	<sapn style="color:<?php if($total_profile_strength > 70 && $total_profile_strength <= 100) echo '#C70000'; else echo '#333';?>;padding:0px 13px;">EXPERT</span>
	
	</div>
<?php //}?>
</div>
<?php }?>