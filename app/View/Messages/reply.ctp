<style>
#messaged {
	border:none;
	width:465px;
	min-height:115px;
	
	word-wrap:break-word;
}
</style>
<div class="marginbottom20"><h1>Reply</h1></div>

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
	<form action="#" method="post" class="userprofile-form" id="reply">
		<input type="hidden" name="to_email" id="to_email" value="<?php echo $from_email;?>" />
		<input type="hidden" name="from_email" id="from_email" value="<?php echo $to_email;?>" />
		<input type="hidden" name="To_name" id="To_name" value="<?php echo $FromName;?>" />
		<input type="hidden" id="from_id" value="<?php echo $from_id;?>" />
		<input type="hidden" id="to_id" value="<?php echo $to_id;?>" />
		<input type="hidden" id="msg_id" value="<?php echo $row[$model]['id'];?>" />
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><strong>To :</strong></td>
			</tr>
			<tr>
				<td>
					<input type="text" name="to" class="textfield" value="<?php echo $FromName." (".$from_email.")"; ?>" size="60" disabled/> 
				</td>
			</tr>
			<tr>
				<td><strong>Subject :</strong></td>
			</tr>
			<tr>
				<td><input type="text" name="subject" id="subject" class="textfield" value="Re: <?php echo $row[$model]['subject']; ?>" size="60" />    </td>
			</tr>
			<tr>
				<td><strong>Message :</strong></td>
			</tr>
			<tr>
				<td>
				<div class="textfield" style="width:480px;height:250px;overflow-y:auto;">
<textarea name="message" id="messaged" class="emailtextarea" style='overflow-y:hidden;' onkeyup='this.rows = (this.value.split("\n").length||1);'>




</textarea>
<div class="clear"></div>
<?php 
			$listing ="<div class='joblisting'>";
			$listing.="<p><span class='postedon'>On ".$created." posted:</span></p>";
			$listing.="<div class='clear'>&nbsp;</div>";
			$listing.="<div><p>".$message."</p></div></div>";
			echo $listing;
			
			if($rerow){
				$i=0;
				//pr($rerow);
				foreach($rerow as $rows){
				
				$createds = date("F j Y g:i a", strtotime($rows[$model]['created']));
				
				
			
				$listings ="<div class='joblisting'>";

				$listings.="<p><span class='postedon'>On ".$createds." posted:</span></p>";
				$listings.="<div class='clear'>&nbsp;</div>";
				$listings.="<div><p>".nl2br($rows[$model]['message'])."</p></div></div>";
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
				<td><input type="button" name="Submit" value="Send" class="red-bttn" onclick="msg_reply_to();" />&nbsp; &nbsp;<input type="button" name="Cancel" value="Cancel" class="canclebttn" onclick="msg_inbox();" /></td>
			</tr>
		</table>
	</form>
<div class="clear"></div>
