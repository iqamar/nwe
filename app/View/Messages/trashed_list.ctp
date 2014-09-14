<?php 
echo $this->Html->script(array(MEDIA_URL.'/js/paging.js'));
$this->Paginator->options(array('update' => '#fragment-1','evalScripts'=>true,'url' => $this->passedArgs,'data'=>http_build_query($this->request->data),'before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false))));?>
<?php if($data){ 

//pr($data);
?>
<style type="text/css">    
.pg-normal {
	
	cursor: pointer;    
}
            
</style>
<div class="heading">
	<div class="email-top-bttns" style="width:240px;">
		<a class="undelete"  href="#Undelete" onclick="undelete(this,'undeleteList');" value="0">UnDelete</a>
		<a class="email_trash_small" onclick="permdelete(this,'deleteList');" value="0" href="#Delete">Delete Permanently</a>
		<input type="checkbox" id="selectall" name="delcheckbox" class="delcheckbox" />
	</div>
	<h1>Trash</h1>

</div>

<div class="clear"></div>
<div id="spinner" style="display: none;">
	<?php echo $this->Html->Image(MEDIA_URL.'/img/loading.gif', array('id' => 'busy-indicator')); ?>
</div>
<?php echo $this->Session->flash('undelete_error'); ?>
<?php echo $this->Session->flash('permdelete_error'); ?>
<table id="results">
<?php 
	$i=0;
	
	foreach($data as $row ){
	
			if($row['Sendto']['id']){
				$FromName = $row['ToProfile']['firstname'].'&nbsp;'.$row['ToProfile']['lastname'];
				$created = date("M j", strtotime($row['msg_sent']['created']));
				
				$message = strip_tags($row['msg_sent']['message'],'');
				$messages=substr($message,0,80);
				
				if($row['ToProfile']['photo']){
					if(file_exists(MEDIA_PATH.'/files/user/icon/'.$row['ToProfile']['photo'])){
						$From_user_pic=MEDIA_URL.'/files/user/icon/'.$row['ToProfile']['photo'];
					}else{
						$From_user_pic=MEDIA_URL.'/img/nologo.jpg';
					}
				}else{
						$From_user_pic=MEDIA_URL.'/img/nologo.jpg';
				}
				$msgid=$row['msg_sent']['id'];
				$subject=$row['msg_sent']['subject'];
				$checkid = $msgid.'-'.'sent';
				$val='sent';
				$to = 'To: ';
								
			}else{
				$FromName = $row['FromProfile']['firstname'].'&nbsp;'.$row['FromProfile']['lastname'];
				$created = date("M j", strtotime($row['msg_inbox']['created']));
				
				$message = strip_tags($row['msg_inbox']['message'],'');
				$messages=substr($message,0,80);
				
				if($row['FromProfile']['photo']){
					if(file_exists(MEDIA_PATH.'/files/user/icon/'.$row['FromProfile']['photo'])){
						$From_user_pic=MEDIA_URL.'/files/user/icon/'.$row['FromProfile']['photo'];
					}else{
						$From_user_pic=MEDIA_URL.'/img/nologo.jpg';
					}
				}else{
						$From_user_pic=MEDIA_URL.'/img/nologo.jpg';
				}
				$msgid=$row['msg_inbox']['id'];
				$subject=$row['msg_inbox']['subject'];
				$checkid = $msgid.'-'.'inbox';
				$val='inbox';
				$to = '';
				if($row['msg_inbox']['unread']==1){
					$unread = 'unread';
				}else{
					$unread = '';
				}
			}
			$listing ="<tr><td><div class='emaillisting ".$unread."'>";
			$listing.="<div class='email-pic'>".$this->Html->link($this->Html->Image($From_user_pic),'#view',array('escape'=>false,'onclick'=>"trash_view(this,'".$val."');",'value'=>$msgid))."</div>";
			$listing.="<div class='email-content'><div class='email-checkbox' >".$created."<input type='checkbox' class='delcheckbox' name='delcheckbox' value='".$checkid."'/> </div><h1>".$to.$this->Html->link($FromName,'#view',array('escape'=>false,'onclick'=>"trash_view(this,'".$val."');",'value'=>$msgid))."</h1>";
			$listing.="<p>".$this->Html->link($subject,'#view',array('escape'=>false,'onclick'=>"trash_view(this,'".$val."');",'value'=>$msgid))."</p>";
			$listing.="<p><span class='postedon'>".$messages."</span></p></div>";
			$listing.="<div class='email-bttns'><a title='Undelete' class='email_undelete' onclick=undelete(this,'undelete'); href='#undelete' value='".$checkid."'></a><a title='Delete' class='email_trash' href='#trash' onclick=permdelete(this,'delete'); value='".$checkid."'></a></div>";
			$listing.="<div class='clear'></div></div></td></tr>";
						
		echo $listing;
		
	}
?>
</table>
<div class="clear">&nbsp;</div>
<div style="background:#EAEAEA;padding:1px;position:absolute;bottom:0px;left:0px;width:100%;">
	<div id="pageNavPosition" class="paging"></div>
</div>
<?php echo $this->Js->writeBuffer();
}else{
	echo "<div class='flash error_msg'> No messages found!</div>";
}
?>
<script type="text/javascript">
$(document).ready(function() {
		
$('#selectall').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.delcheckbox').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.delcheckbox').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    }); 
		
});
</script>
<script type="text/javascript"><!--
        var pager = new Pager('results', 10); 
        pager.init(); 
        pager.showPageNav('pager', 'pageNavPosition'); 
        pager.showPage(1);
    //--></script>