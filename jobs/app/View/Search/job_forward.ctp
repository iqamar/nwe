<?php 

if(isset($userInfo))
{
echo $this->Html->css(array('magicsuggest-1.3.1')); 
echo $this->Html->Script(array('magicsuggest-1.3.1','jquery.validate'));

$uid=$userInfo['Users_profile']['user_id'];
$strstr = "";
if(!empty($con)){
foreach ($con as $key=>$index) {

	foreach($index as $users){
		//echo $users['User']['email'];
		$firstname = $users['Users_profile']['firstname'];
		$lastname = $users['Users_profile']['lastname'];
		$id = $users['Users_profile']['user_id'];
		$email = $users['User']['email'];
		//$strstr .= '"{id:'.$id .' ,label:'.$lastname.'}",';
		$strstr .= '{id:"'.$email.'",label:"'.$firstname.'&nbsp;'.$lastname.'"},';
	}
}
$strstr = trim($strstr, ",");
}
}else{
	$strstr = '';
}

//pr($strstr);
?>
<script type="text/javascript">
$(document).ready(function() {
		   
		  // data: [{id:1,label:'one'}, {id:2,label:'two'}, {id:3,label:'three'}],
   var ms4 = $('#ms4').magicSuggest({
		data: [<?php echo $strstr; ?>],
		displayField: 'label',
		
        
		selectionStacked: true
	});
	
	$("#jobForward").validate();

});
</script>

<div id="content">
	<div id="content-inner">
		<article class="is-post is-post-excerpt">
			
			<header>
				<?php echo $this->Html->Image('company_logos/'.$data['Company']['logo'],array('class'=>'applyprofileimg','style'=>'border:1px solid #ddd;')); ?>
				<div style="width:70%;float:left;margin:5px 0px 0px 15px">
					<h2><?php echo $this->Html->link($data['Job']['title'],'#',array('escape'=>false)); ?></h2>
					<span class="byline"><?php echo $this->Html->link($data['Company']['title'],$data['Company']['weburl'],array('escape'=>false)); ?>&nbsp;-&nbsp;<?php echo $data['Job']['city'].",&nbsp;".$data['Country']['name']; ?></span>
					<?php 
						$pdate=date('d-m-Y H:i:s',strtotime($data['Job']['start_date'])); 
					?>
					<p>Posted <?php echo $this->Time->timeAgoInWords($pdate); ?></p>
				</div>
			</header>
			<div style="clear:both;"></div>
			<hr/>
			<?php echo $this->Session->flash(); ?>
			<div style="width:90%;float:left;min-height:600px;">
				<div class="is-calendar">
					<div class="innerL">	
						
						<?php 
						if(isset($userInfo))
						{ //pr($userExperience); 
							$yourEmail = $userInfo['User']['email'];
							$yourName = $userInfo['Users_profile']['firstname']." ".$userInfo['Users_profile']['lastname'];
							//$job_link =$this->webroot.'/search/jobDetails/'.$jobDetail['Job']['id'];
							echo $this->Form->create('jobForward',array('url'=>'/search/jobForward/'.$data['Job']['id'],'id'=>'jobForward','name'=>'jobForward'));
							echo $this->Form->input('yourname',array('label'=>'Your Name','type'=>'text','value'=>$yourName));
							echo $this->Form->input('youremail',array('label'=>'Email','type'=>'text','value'=>$yourEmail));
							echo $this->Form->input('conEmail',array('label'=>'Friends Email','type'=>'text','id'=>'ms4','name'=>'ms4','style'=>'width:610px;','div'=>false));
							?>
							<div style="clear:both;"></div>
							<?php
							echo $this->Form->input('friendsEmail',array('label'=>'Other Emails','name'=>'friendsEmail','type'=>'textarea','rows'=>2,'class'=>''));
							echo "<span style='font-size:12px;'>(add more email ids separated by comma)</span>";
							//echo $this->Form->hidden('hidden',array('value'=>$job_link,'name'=>'job_link','id'=>'job_link'));
							echo $this->Form->input('job_id',array('type'=>'hidden','value'=>$data['Job']['id'],'name'=>'job_id','id'=>'job_id'));
							echo "<br/>";
							echo $this->Form->input('Send Invites',array('type'=>'submit','name'=>'Send','class'=>'button frm','label'=>false,'style'=>'width:100px;'));
							echo $this->Form->end();
							
						}else{
							echo $this->Html->link('Register or Login',$networkWeUrl,array('escape'=>false,'id'=>'fancybox','class'=>'button'));
						}
						?>
					</div>
				</div>
			</div>
			<div style="clear:both;"></div>
			<hr/>
		</article>
		
	</div>
</div>
