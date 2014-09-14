<div class="marginbottom20"><h1>Compose</h1></div>

	<form action="/Messages/send/" method="post" class="userprofile-form" id="compose">
	
		<input type="hidden" name="from_email" id="from_email" value="<?php echo $data['From']['email'];?>" />
		<input type="hidden" id="from_id" value="<?php echo $data['From']['id'];?>" />
		<input type="hidden" id="from_name" value="<?php echo $data['Users_profile']['firstname'].' '.$data['Users_profile']['lastname'];?>" />

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><strong>To :</strong></td>
			</tr>
			<tr>
				<td>
					<input type="text" name="ms4" id="ms4" class="required textfield" size="60" /> 
					
				</td>
			</tr>
			<tr>
				<td><strong>Subject :</strong></td>
			</tr>
			<tr>
				<td><input type="text" name="subject" id="subject" class="required textfield" size="60" />    </td>
			</tr>
			<tr>
				<td><strong>Message :</strong></td>
			</tr>
			<tr>
				<td>
<textarea name="messaged" id="messaged" cols="58" rows="16" class="textfield" ></textarea>
					
					
				</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td><input type="submit" name="Submit" value="Send" class="red-bttn" />&nbsp; &nbsp;<input type="button" name="Cancel" value="Cancel" class="canclebttn" onclick="msg_inbox();" /></td>
				
			</tr>
		</table>
	</form>
<div class="clear"></div>
<?php 

$strstr = "";
if(!empty($con)){

foreach ($con as $key=>$index) {

	foreach($index as $users){
		//echo $users['User']['email'];
		$firstname = $users['Users_profile']['firstname'];
		$lastname = $users['Users_profile']['lastname'];
		$id = $users['Users_profile']['user_id'];
		$email = $users['users']['email'];
		//$strstr .= '"{id:'.$id .' ,label:'.$lastname.'}",';
		$strstr .= '{id:"'.$id.'",label:"'.$firstname.'&nbsp;'.$lastname.'"},';
	}
}
$strstr = trim($strstr, ",");
}

?>

<script type="text/javascript">
$(document).ready(function() {
		
		$('#ms4').magicSuggest({
			
		
		displayField: 'label',
		autoSelect: false,
		allowFreeEntries: false,
		useTabKey: true,
		required: true,
		sortDir: 'asc',
		sortOrder: 'label',
		data: [<?php echo $strstr; ?>],
		selectionStacked: true
		});
	
	
	 
	 
	$('#compose').validate();
	 
	 
		
});

</script>
<style>
.error {color:red;padding-left:2px;}
</style>