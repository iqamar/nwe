<form action="<?php echo NETWORKWE_URL;?>/contacts/open_contacts" method="post">

    Email:  <input type="text" name="email" /> <br>
    Password: <input type="password"  name="password" />
    <br>
    <input type="submit" name="email_submit" />

</form>


<?php if( isset( $emails ) && count($emails) > 0  ): ?>
<?php foreach(  $emails as $email ): ?>

<input type="checkbox" name="conttact[]" value="<?=$email['email'];?>" /> <?=$email['email'];?><br>

<?php endforeach;?>

<?php endif; ?>
