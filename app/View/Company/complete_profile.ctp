<?php
/*
echo "<pre>";
print_r($user);
*/
?> 
 <div class="maincontent">
    <div class="alert_msg"> Before continue to NetworkWe please provide us few of your mandatory details to keep you on priority for searching a Job, building your professional &amp; personal connections and so many other things. </div>
	<?php //echo $this->Session->flash(); ?>
	<div class="login_error_box">
      <div>
        <div class="greybox-div-heading">
          <h1>Welcome, <?php echo $user['firstname'];?> <?php echo $user['lastname'];?></h1>
        </div>
        <div class="smalltext margintop10">Please fill the mandatory fields below to get started immediately</div>
		<form action="/company/complete_profile" method="post">      
			<input type="hidden" name="userid" value="<?php echo $user['id'];?>">
          <table width="100%" border="0" cellspacing="2" cellpadding="1">
            <tr>
              <td><h2>First Name</h2></td>
            </tr>
            <tr>
              <td><input name="firstname" id="firstname" type="text" class="textfield" size="26" value="<?php echo $user['firstname'];?>"/></td>
            </tr>
            <tr>
              <td><h2>Professional Heading</h2></td>
            </tr>
            <tr>
              <td><input name="tags" id="tags" type="text" class="textfield" size="26" value="<?php echo $user['tags'];?>" /></td>
            </tr>
            <tr>
              <td><h2>Country of Residence</h2></td>
            </tr>
            <tr>
              <td><select name="country_id"  id="country_id" class="droplist" style="width:395px;">
				<option value="">Select</option>
             <?php foreach($countries as $data){
					if($data['countries']['id'] == $user['country_id']){
						echo '<option value="'.$data['countries']['id'].'" selected>'.$data['countries']['name'].'</option>';
					}else{
						echo '<option value="'.$data['countries']['id'].'">'.$data['countries']['name'].'</option>';
					}
             }
             ?>
              </select></td>
            </tr>
            <tr>
              <td><input type="submit" name="Submit" value="Done, Continue to NetworkWe" class="red-bttn" /></td>
            </tr>
          </table>
         </form>
      </div>
    </div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
</div>
