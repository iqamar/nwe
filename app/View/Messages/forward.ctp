<style>
#messaged {
	border:none;
	width:465px;
	min-height:115px;
	
	word-wrap:break-word;
}
</style>
<div class="marginbottom20"><h1>Forward</h1></div>

<?php 
		//pr($row);
		$model = 'msg_'.$cat;
		
		$created = date("F j g:i a", strtotime($row[$model]['created']));
		
		$message = nl2br($row[$model]['message']);
		if($cat=='sent'){
			$FromName = $row['ToProfile']['firstname'].'&nbsp;'.$row['ToProfile']['lastname'];
			$from_email = $row['Sendto']['email'];
			$to_email = $row['From']['email'];
			$from_id = $row['From']['id'];
			$to_id = $row['Sendto']['id'];
			$ToName = $row['FromProfile']['firstname'].'&nbsp;'.$row['FromProfile']['lastname'];
		}else{
			$FromName = $row['FromProfile']['firstname'].'&nbsp;'.$row['FromProfile']['lastname'];
			$from_email = $row['From']['email'];
			$to_email = $row['Sendto']['email'];
			$from_id = $row['Sendto']['id'];
			$to_id = $row['From']['id'];
			$ToName = $row['ToProfile']['firstname'].'&nbsp;'.$row['ToProfile']['lastname'];
		}
		
?>
	
	<form action="/Messages/send/" method="post" class="userprofile-form" id="compose">
		
		<input type="hidden" name="from_email" id="from_email" value="<?php echo $to_email;?>" />
		<input type="hidden" id="from_name" value="<?php echo $FromName;?>" />
		<input type="hidden" id="from_id" value="<?php echo $from_id;?>" />
		
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
				<td><input type="text" name="subject" id="subject" class="textfield" value="Fw: <?php echo $row[$model]['subject']; ?>" size="60" />    </td>
			</tr>
			<tr>
				<td><strong>Message :</strong></td>
			</tr>
			<tr>
				<td>
				<div class="textfield" style="width:480px;height:250px;overflow-y:auto;">
<textarea name="messaged" id="messaged" class="emailtextarea" style='overflow-y:hidden;' onkeyup='this.rows = (this.value.split("\n").length||1);'>




</textarea>
<div class="clear"></div>
<?php 
			$listing ="<div class='emaillisting-viewpage'>";
			$listing.="<p><span class='postedon'>On ".$created." posted:</span></p>";
			$listing.="<div><p>".$message."</p></div>";
			$listing.="<textarea name='fw_content' id='fw_content' style='display:none'>".$listing."</textarea><div class='clear'></div></div>";
			echo $listing;
			
			
			if($rerow){
				$i=0;
				//pr($rerow);
				foreach($rerow as $rows){
				
				$createds = date("F j Y g:i a", strtotime($rows[$model]['created']));
				
				
			
				$listings ="<div class='emaillisting-viewpage'>";

				$listings.="<p><span class='postedon'>On ".$createds." posted:</span></p>";
				$listings.="<div class='clear'></div>";
				$listings.="<div><p>".nl2br($rows[$model]['message'])."</p></div>";
				$listings.="<textarea name='fw_fw_content' id='fw_fw_content' style='display:none'>".$listings."</textarea><div class='clear'></div></div>";
				echo $listings;
				
				}
			}
?>	

				</div>
					
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
 		
});

</script>