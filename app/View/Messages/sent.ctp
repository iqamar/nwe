<?php $this->Paginator->options(array('update' => '#fragment-1','evalScripts'=>true,'url' => $this->passedArgs,'data'=>http_build_query($this->request->data),'before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false))));?>
<?php if($data){ ?>

<div class="heading">
	<div class="email-top-bttns">
		<a class="email_trash_small" onclick="msg_trash(this,'sent');" value="0" href="#Delete">Trash</a>
		<input type="checkbox" id="selectall" name="delcheckbox" class="delcheckbox" />
	</div>
	<h1>Sent</h1>

</div>

<div class="clear"></div>
<div id="spinner" style="display: none;">
	<?php echo $this->Html->Image(MEDIA_URL.'/img/loading.gif', array('id' => 'busy-indicator')); ?>
</div>
<?php echo $this->Session->flash('sent_trash'); ?>
<?php 
	$i=0;
	
	foreach($data as $row){
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
		
		$listing ="<div class='emaillisting'>";
		$listing.="<div class='email-pic'>".$this->Html->link($this->Html->Image($From_user_pic),'#view',array('escape'=>false,'onclick'=>"msg_view(this,'sent');",'value'=>$row['msg_sent']['id']))."</div>";
		$listing.="<div class='email-content'><div class='email-checkbox' >".$created."<input type='checkbox' class='delcheckbox' name='delcheckbox' value='".$row['msg_sent']['id']."'/> </div><h1>".$this->Html->link($FromName,'#view',array('escape'=>false,'onclick'=>"msg_view(this,'sent');",'value'=>$row['msg_sent']['id']))."</h1>";
		$listing.="<p>".$this->Html->link($row['msg_sent']['subject'],'#view',array('escape'=>false,'onclick'=>"msg_view(this,'sent');",'value'=>$row['msg_sent']['id']))."</p>";
		$listing.="<p><span class='postedon'>".$messages."</span></p></div>";
		$listing.="<div class='email-bttns'><a title='Reply' class='email_reply' href='#Reply' onclick=msg_reply(this,'sent'); value='".$row['msg_sent']['id']."'></a>";
		$listing.="<a title='Forward' class='email_forward' href='#Forward' onclick=msg_forward(this,'sent'); value='".$row['msg_sent']['id']."'></a>";
		$listing.="<a title='Delete Mail' class='email_trash' href='#Delete' onclick=msg_trash(this,'sent'); value='".$row['msg_sent']['id']."'></a>";
		$listing.="</div><div class='clear'></div></div>";
				
		echo $listing;
	}
?>
<div class="clear">&nbsp;</div>
<div style="background:#EAEAEA;padding:1px;position:absolute;bottom:0px;left:0px;width:100%;">
	<div class="paging">
		<?php 
			echo $this->Paginator->first(__('<< First', true), array('class' => 'number-first')).'&nbsp;&nbsp;';
			if($this->Paginator->hasPrev()){
				echo $this->Paginator->prev('<< ' . __('Previous', true), array(), null, array('class'=>'disabled')).'&nbsp;&nbsp;';
			}
			echo $this->Paginator->numbers(array('separator' => '&nbsp;&nbsp;','class' => 'numbers', 'first' => false, 'last' => false)).'&nbsp;&nbsp;';
			if($this->Paginator->hasNext()){
				echo $this->Paginator->next(__('Next', true) . ' >>', array(), null, array('class' => 'disabled')).'&nbsp;&nbsp;';
			}
			echo $this->Paginator->last(__('Last >>', true), array('class' => 'number-end'));
		?>
		 
	</div>
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