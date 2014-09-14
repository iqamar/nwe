<?php
/*****************************************/
/*
STANDS AS A SAMPLE (NOT TESTED, HAS TO BE ADAPTED TO YOUR NEEDS)
*/
/*****************************************/
class InvitersController extends AppController {
	var $uses = array('users_contacts_invites');
	var $helpers = array('Html', 'Form', 'Session');

	function beforeFilter(){
		parent::beforeFilter();
	$this->Auth->allow();
	switch ($this->request->params['action']) {
	    case 'index':
	    case 'admin_index':
	    // $this->Security->validatePost = false;
	}
		
		}

	function beforeRender(){}
 
function gmail_login()
{

}

function inviter(){
  
include('inviter/openinviter.php');
$inviter=new OpenInviter();
$oi_services=$inviter->getPlugins();
echo "testeddd";
function ers($ers)
	{
	if (!empty($ers))
		{
		$contents="<table cellspacing='0' cellpadding='0' style='border:1px solid red;' align='center' class='tbErrorMsgGrad'><tr><td valign='middle' style='padding:3px' valign='middle' class='tbErrorMsg'><img src='/images/ers.gif'></td><td valign='middle' style='color:red;padding:5px;'>";
		foreach ($ers as $key=>$error)
			$contents.="{$error}<br >";
		$contents.="</td></tr></table><br >";
		return $contents;
		}
	}
	
function oks($oks)
	{

		
	if (!empty($oks))
		{
		$contents="<table border='0' cellspacing='0' cellpadding='10' style='border:1px solid #5897FE;' align='center' class='tbInfoMsgGrad'><tr><td valign='middle' valign='middle' class='tbInfoMsg'><img src='/images/oks.gif' ></td><td valign='middle' style='color:#5897FE;padding:5px;'>	";
		foreach ($oks as $key=>$msg)
			$contents.="{$msg}<br >";
		$contents.="</td></tr></table><br >";
		return $contents;
		}
	}

if (!empty($_POST['step'])) $step=$_POST['step'];
else $step='get_contacts';

$ers=array();$oks=array();$import_ok=false;$done=false;
if ($_SERVER['REQUEST_METHOD']=='POST')
	{
	if ($step=='get_contacts')
		{
		if (empty($_POST['email_box']))
			$ers['email']="Email missing";
		if (empty($_POST['password_box']))
			$ers['password']="Password missing";
		if (empty($_POST['provider_box']))
			$ers['provider']="Provider missing";
		if (count($ers)==0)
			{
			$inviter->startPlugin($_POST['provider_box']);
			$internal=$inviter->getInternalError();
			if ($internal)
				$ers['inviter']=$internal;
			elseif (!$inviter->login($_POST['email_box'],$_POST['password_box']))
				{
				$internal=$inviter->getInternalError();
				$ers['login']=($internal?$internal:"Login failed. Please check the email and password you have provided and try again later");
				}
			elseif (false===$contacts=$inviter->getMyContacts())
				$ers['contacts']="Unable to get contacts.";
			else
				{
				$import_ok=true;
				$step='send_invites';
				$inviter->stopPlugin(true);
				$_POST['cookie_file']=$inviter->plugin->cookie;
				$_POST['message_box']='';
				}
			}
		}
	elseif ($step=='send_invites')
		{
		if (empty($_POST['provider_box'])) $ers['provider']='Provider missing';
		else
			{
			$inviter->startPlugin($_POST['provider_box']);
			if (empty($_POST['email_box'])) $ers['inviter']='Inviter information missing';
			if (empty($_POST['cookie_file'])) $ers['cookie']='Could not find cookie file';
			if (empty($_POST['message_box'])) $ers['message_body']='Message missing';
			else $_POST['message_box']=strip_tags($_POST['message_box']);
			$selected_contacts=array();$contacts=array();
			$message=array('subject'=>$inviter->settings['message_subject'],'body'=>$inviter->settings['message_body'],'attachment'=>"\n\rAttached message: \n\nr".$_POST['message_box']);
			if ($inviter->showContacts())
				{
				foreach ($_POST as $key=>$val)
					if (strpos($key,'check_')!==false)
						$selected_contacts[$_POST['email_'.$val]]=$_POST['name_'.$val];
					elseif (strpos($key,'email_')!==false)
						{
						$temp=explode('_',$key);$counter=$temp[1];
						if (is_numeric($temp[1])) $contacts[$val]=$_POST['name_'.$temp[1]];
						}
				if (count($selected_contacts)==0) $ers['contacts']="You haven't selected any contacts to invite";
				}
			}
		if (count($ers)==0)
			{
			$sendMessage=$inviter->sendMessage($_POST['cookie_file'],$message,$selected_contacts);
			$inviter->logout();
			if ($sendMessage===-1)
				{
				$message_footer="\r\n\r\nThis invite was sent using OpenInviter technology.";
				$message_subject=$_POST['email_box'].$message['subject'];
				$message_body=$message['body'].$message['attachment'].$message_footer; 
				$headers="From: {$_POST['email_box']}";
				foreach ($selected_contacts as $email=>$name)
					mail($email,$message_subject,$message_body,$headers);
				$oks['mails']="Mails sent successfully";
				}
			elseif ($sendMessage===false)
				$ers['internal']="There were errors while sending your invites.<br>Please try again later!";
			else $oks['internal']="Invites sent successfully!";
			$done=true;
			}
		}
	}
else
	{
	$_POST['email_box']='';
	$_POST['password_box']='';
	$_POST['provider_box']='';
	$_POST['code_box']='';
	}

$contents="<script type='text/javascript'>
	function toggleAll(element) 
	{
	var form = document.forms.openinviter, z = 0;
	for(z=0; z<form.length;z++)
		{
		if(form[z].type == 'checkbox')
			form[z].checked = element.checked;
	   	}
	}
</script>";
$contents.="<form action='' method='POST' name='openinviter'>".ers($ers).oks($oks);
if (!$done)
	{
	if ($step=='get_contacts')
		{
		$contents.="<table align='center' class='thTable' cellspacing='0' cellpadding='0' style='border:none;'>
			<tr class='thTableRow'><td align='right'><label for='email_box'>Email</label></td><td><input class='thTextbox' type='text' name='email_box' value='{$_POST['email_box']}'></td></tr>
			<tr class='thTableRow'><td align='right'><label for='password_box'>Password</label></td><td><input class='thTextbox' type='password' name='password_box' value='{$_POST['password_box']}'></td></tr>
			<tr class='thTableRow'><td align='right'><label for='provider_box'>Email provider</label></td><td><select class='thSelect' name='provider_box'><option value=''></option>";
		foreach ($oi_services as $type=>$providers)	
			{
			$contents.="<option disabled>".$inviter->pluginTypes[$type]."</option>";
			foreach ($providers as $provider=>$details)
				$contents.="<option value='{$provider}'".($_POST['provider_box']==$provider?' selected':'').">{$details['name']}</option>";
			}
		$contents.="</select></td></tr>
			<tr class='thTableImportantRow'><td colspan='2' align='center'><input class='thButton' type='submit' name='import' value='Import Contacts'></td></tr>
		</table><input type='hidden' name='step' value='get_contacts'>";
		}
	
	}
//$contents.="<center><a href='http://openinviter.com/'><img src='http://openinviter.com/images/banners/banner_blue_1.gif' border='0' alt='Powered by OpenInviter.com' title='Powered by OpenInviter.com'></a></center>";
if (!$done)
	{
	if ($step=='send_invites')
		{
		if ($inviter->showContacts())
                    
			{
                    ?>
<div class="emails" style="position: relative; left: 450px;">
<form action="inviter_post" method="post">
<?php
                    foreach ($contacts as $email => $name) {
                       if (strpos($name, "@")){
                     ?>
    <input type="checkbox" name="email[]" value="<?=$name?>" style=" -webkit-appearance: checkbox;"/><?=$name?>
                <?php
                       }
                        
                    }
                    echo "<input type='submit'>";
                    echo "</form></div>";
                    
                }
                
                        }
	}
//$contents.="</form>";
//echo $contents;
        $this->set('contents', $contents);
    
}

function inviter_post(){
  //  App::uses('CakeEmail', 'Network/Email');
   // $sendmail = new CakeEmail();
    if (!empty($_POST['email'])){
        $this->set('email', $this->request->data('email'));
        
        foreach ($this->request->data('email') as $mail){
            $this->users_contacts_invites->create();
            $this->users_contacts_invites->save(array(
                'initiator_user_id' => 1,
                'friend_user_id' => $mail,
                'status' => 1,
                'contact_source' => 'GMail'
                ));
            
            // The Email Properties
            //$sendmail->to($mail);
           // $sendmail->subject('test subject');
           // $sendmail->send('test email');
           mail($mail, 'test subject', 'test message');
            
            //End Email Properties  
       
	}

}

}

}
?>