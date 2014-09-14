<style>
.addblog input[type="password"] {
	border: 1px solid #CCCCCC;
    color: #666666;
    font-size: 12px;
    padding: 8px 6px;
    width: 677px;
}
</style>
<script>
$('#submitChallenge').click function() {	  
	alert("show_hide");  
});
</script>
<form action="<?php echo NETWORKWE_URL;?>/contacts/gmail" method="post" class="addblog">

	<label><h1>Before to import contacts, allow access to Gmail Account by click on  </h1>
    <a href="?#" onclick="window.open('https://accounts.google.com/displayunlockcaptcha','popup','width=600,height=600,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0'); return false">Click</a>
    </label> 
    <label></label>
    
    <label><h1>Email</h1></label>  
    <label> <input type="text" name="email" /></label>
    <label><h1>Password</h1></label> 
    <label><input type="password"  name="password" /></label>
    <input type="hidden" name="oauth_provider" value="google" />
    <input type="submit" name="email_submit" class="submitbttn" value="Import" />

</form>

<?php if( isset( $emails ) && count($emails) > 0  ): ?>
	<div class="addblog" style="margin-top:20px;">
    	<ul>
	<?php foreach(  $emails as $email ): ?>
    
    		<li style="float:left; margin-right:25px; width:40%;"><input type="checkbox" name="conttact[]" value="<?=$email['email'];?>" /> <?=$email['email'];?></li>
    
    <?php endforeach;?>
    	</ul>
	</div>
<?php endif; ?>
