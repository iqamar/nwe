
<script>
function show_skill(){
$('#add_skill').slideToggle('slow');
}
function showEdit(id,count) {
//$('#edit_Recs').show();
document.getElementById('fade').style.display = 'block';
document.getElementById('openEditWindow').style.display = 'block';
$.ajax({
              url     : baseUrl+"/users_profiles/edit_edu",
              type    : "GET",
              cache   : false,
              data    : {iD: id, counter:count},
              success : function(data){
			  $("#test").html(data);
              },
			  error : function(data) {
           $("#resultDiv_"+count).html("there is error");
        }
          });
		  
}
		function close_EditWindow(id) {
		document.getElementById('fade').style.display = 'none';
		document.getElementById('openEditWindow').style.display = 'none';
		}
	function hideEdit(cnt){
	//alert(cnt);
	document.getElementById('edit_Recs').style.display = 'none';
    document.getElementById('edu_'+cnt).style.display = 'block';
	return true;
//$('#edu_'+cnt).slideDown('slow');
//$('#edit_Recs').slideUp('slow');
}
function close_EditWindow(id) {
document.getElementById('fade').style.display = 'none';
document.getElementById('openEditWindow').style.display = 'none';
}
</script>
<script type="text/javascript">
	$(document).ready(function() {
	$.noConflict();
		$("#stdate").datepicker();
		$("#endate").datepicker();
		
	});

	</script>
<style>

datalist option .optionList {font-weight:bold;color:red;}
datalist option .childList{ padding-left:10px;}
.boxed-group h3 a{ color:#222;}
.boxed-group h3 a:hover{ color:#222;}
</style>
<?php echo $this->element('edit_profile_menus'); ?>

<div class="settings-content"  style="float: left; width: 70%;">
<div class="boxed-group">
<h3><?php echo $this->Html->image('/img/add.png',array('onclick'=> 'show_skill();', 'style'=>'cursor:pointer;'));?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo 'Add Education';?></h3>
</div>
<!--edit-->
<div class="referel_pop" id="openEditWindow" style="display:none;">
<div class="close_icon_row">
<div class="close_icon_row_left">Update Education</div><div class="close_icon" onclick="close_EditWindow('openEditWindow' , 'fade')"></div>
</div>
<div id="test"></div>

</div>

<!--add-->
<div class="boxed-group" id="add_skill" style="display:none;">
<h3>Education</h3>
<div class="boxed-group-inner">
<?php echo $this->Form->create("Users_profile",array('controller' => 'users_profiles', 'action' => 'user_edu'));?>
<?php $cuser = $this->Session->read($userid);?>
<?php echo $this->Form->input('user_id' , array('type' => 'hidden', 'value' => $cuser['userid'])) ?>
<dl class="form"><dt><label>School/University/Institute Name</label></dt>
<dd>
<!--
<select name="data[Users_profile][institute_id]">
<?php  foreach ($Institue_List as $institueRow) { ?>
	<option value="<?php echo $institueRow['institutes']['id']; ?>"><?php echo $institueRow['institutes']['title']; ?></option>
<?php }?>
</select>-->
<?php echo $this->Form->text('weburl',array('required'=>true,'id'=>'institute_name','name'=>'institute_name','value'=>'')) ?>
</dd></dl>
<!--<dl class="form"><dt><label>Link</label></dt>
<dd><?php echo $this->Form->text('weburl',array('required'=>true,'id'=>'weburl','value'=>'http://')) ?>
</dd></dl>-->
<dl class="form"><dt><label>Major</label></dt>
<dd>
<!--
<select name="data[Users_profile][qualification_id]">
<?php  foreach ($qualifications_List as $qualificationsRow) { ?>
	<option value="<?php echo $qualificationsRow['qualifications']['id']; ?>"><?php echo $qualificationsRow['qualifications']['title']; ?></option>
<?php }?>
</select>-->
<?php echo $this->Form->text('Major',array('required'=>true,'name'=>'qualification','id'=>'qualification')) ?>
</dd></dl>
<dl class="form"><dt><label>Field of study</label></dt>
<dd><?php echo $this->Form->text('field_study',array('required'=>true,'id'=>'field_study')) ?>
</dd></dl>
<!--<dl class="form"><dt><label>Grade</label></dt>
<dd><?php echo $this->Form->text('grade',array('required'=>true,'id'=>'grade')) ?>
</dd></dl>-->

<dl class="form"><dt><label><b>Attended period</b></label></dt><dd> 
<?php echo $this->Form->text('start_date',array('required'=>true,'id'=>'stdate', style=>"width:150px")) ?>
<?php echo $this->Form->text('end_date',array('required'=>true,'id'=>'endate', style => "width:150px")) ?></dd></dl>
<dl class="form" style="clear:both;"><dd><?php echo $this->Form->Submit('Add', array('div'=>false,'class'=>'inpt-btn','style'=>'float:right; margin-top:5px;')); ?>
<?php echo $this->Form->end(); ?>
</dd></dl>
</div>
</div>


<!--listing-->
<?php 
$i=1;
foreach ($edus as $edu) {
$edu['users_qualifications']['start_date'];
//$timestamp = strtotime($orig);
$start_date = date("M Y",strtotime($edu['users_qualifications']['start_date']));
$end_date = date("M Y",strtotime($edu['users_qualifications']['end_date']));
?>
<div class="boxed-group" id="edu_<?php echo $i?>">
<h3><?php echo $this->Html->link('',array('url'=> $edu['institutes']['weburl']));?><?php echo $edu['institutes']['title'];?>
<span style="float:right;"><a href="<?php echo $edu['institutes']['weburl'];?>" target="_blank"><?php echo $edu['institutes']['weburl'];?></a></span>
</h3>
<div class="boxed-group-inner" style="min-height:100px;">
<div style="float:left; width:100%;">
<div style="float:left; width:90%;">
<p style="font-weight:bold;"><?php echo $edu['qualifications']['title'];?></p>
<p><?php echo $edu['users_qualifications']['field_study']."  ,   ".$edu['users_qualifications']['grade'];?></p>
<p><?php echo $start_date." &nbsp;&nbsp; to &nbsp;&nbsp; ".$end_date;?></p>
</div>
<div style="float:right; width:10%; margin-top:20px;">
<?php echo $this->Html->image('/img/edit.png',array('onclick'=>'javascript:showEdit('.$edu['users_qualifications']['id'].','.$i.')','style'=>'cursor:pointer'));?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->Html->image('/img/del.png',array('url'=>array('controller'=>'users_profiles','action'=>'delete_edu',$edu['users_qualifications']['id'])));?>
</div>

</div>
</div>
</div>
<div id="resultDiv_<?php echo $i;?>"></div>
<?php $i++;}?>

</div>