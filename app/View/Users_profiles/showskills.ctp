<script>
function show_skill(){
$('#add_skill').slideToggle('slow');
}
function showEdit(id) {
document.getElementById('fade').style.display = 'block';
document.getElementById('openEditWindow').style.display = 'block';
$.ajax({
              url     : baseUrl+"/users_profiles/edit_skill",
              type    : "GET",
              cache   : false,
              data    : {childskill: id},
              success : function(data){
			  $("#test").html(data);
              },
			  error : function(data) {
           $("#test").html("there is error");
        }
          });
}
function close_EditWindow(id) {
document.getElementById('fade').style.display = 'none';
document.getElementById('openEditWindow').style.display = 'none';
}

function validateForm() {
	var start_date = document.getElementById('stdate').value;
	var end_date = document.getElementById('endate').value;
	alert(start_date+"and"+end_date);
	if (start_date >= end_date) {
		return true;
	}
	else {
		return false;
	}
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
</style>
<?php echo $this->element('edit_profile_menus'); ?>
<div class="settings-content" style="float: left; width: 70%;">
<div class="boxed-group">
<h3><?php echo $this->Html->image('/img/add.png',array('onclick'=> 'show_skill();', 'style'=>'cursor:pointer;'));?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo 'Add Skill';?></h3>
</div>

<!--edit-->
<div class="referel_pop" id="openEditWindow" style="display:none;">
<div class="close_icon_row">
<div class="close_icon_row_left">Update your skill</div><div class="close_icon" onclick="close_EditWindow('openEditWindow' , 'fade')"></div>
</div>
<div id="test"></div>

</div>

<!--add-->
<div class="boxed-group" id="add_skill" style="display:none;">
<h3>Key Skills</h3>
<div class="boxed-group-inner">
<?php echo $this->Form->create("Users_profile",array('controller' => 'users_profiles', 'action' => 'user_skill'));?>
<?php $cuser = $this->Session->read($userid);?>
<?php echo $this->Form->input('user_id' , array('type' => 'hidden', 'value' => $cuser['userid'])) ?>
<dl class="form"><dt><label>Key Skill</label></dt>
<dd>
<?php echo $this->Form->text('skill_id',array('type'=>'hidden','required'=>true,'id'=>'skill_id')) ?>
<?php echo $this->Form->text('skillid',array('required'=>true,'id'=>'skillid','onkeydown'=>'showTotalSkills(this.value);')) ?>
</dd>
<div id="result_skill" style="width:280px;">
                        
</div> 
</dl>
<dl class="form"><dt><label>Start Date</label></dt><dd><?php echo $this->Form->text('start_date',array('required'=>true,'id'=>'stdate')) ?></dd></dl>
<dl class="form"><dt><label>End Date</label></dt><dd><?php echo $this->Form->text('end_date',array('required'=>true,'id'=>'endate')) ?></dd></dl>
<dl class="form" style="clear:both;"><dd>
<?php echo $this->Form->Submit('Add', array('div'=>false,'class'=>'inpt-btn','style'=>'float:right; margin-top:5px;')); ?>
<?php echo $this->Form->end(); ?>
</dd></dl>
</div>
</div>


<!--listing-->
<?php 
if ($sub) {
//foreach ($exps as $ex) {
?>
<div class="boxed-group">
<h3><?php //echo $ex['skills_categories']['title'];?></h3>
<div class="boxed-group-inner" style="min-height:150px;">
<div style="float:left; width:140px; font-weight:bold; color:#8FCE51;">Skill</div><div style="float:left; width:140px; font-weight:bold; color:#8FCE51;">Start Date</div><div style="float:left; width:140px; font-weight:bold; color:#8FCE51;">End Date</div><div style="float:left; width:80px;"></div>
<?php  foreach ($sub as $sb) {
//if ($sb['skills']['skills_category_id'] == $ex['skills_categories']['id']){
?>
<div style="float:left; width:503px; margin:2px 0px; font-size:12px; line-height:17px;">
<div style="float:left; width:140px;"><?php echo $sb['skills']['title'];?></div>
<div style="float:left; width:140px;"><?php echo $sb['users_skills']['start_date'];?></div>
<div style="float:left; width:140px;"><?php echo $sb['users_skills']['end_date'];?></div>
<div style="float:left; width:80px;"><?php echo $this->Html->image('/img/edit.png',array('onclick'=>'showEdit('.$sb['users_skills']['id'].')'));?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->Html->image('/img/del.png',array('url'=>array('controller'=>'users_profiles','action'=>'delete_skill',$sb['users_skills']['id'])));?>
</div>
</div>
<?php }}?>


</div>
</div>
<?php //}}?>
</div>
<script type="text/javascript"> 

function showTotalSkills(search_str) {
	var search_str = document.getElementById('skillid').value;
	$.ajax({
              url     : baseUrl+"/users_profiles/search_skill",
              type    : "GET",
              cache   : false,
              data    : {search_str: search_str},
              success : function(data){
				  //alert(data);
				 // if (search_str !='') {
			  		$("#result_skill").html(data);
				 // }
				 // else {
					//$("#result_skill").html("");  
				  //}
              },
			  error : function(data) {
           $("#result_skill").html("there is error");
        }
          });
		  
	}
	
	function assignSkill(title,skillid) {
		$("#result_skill").show('slow');
		document.getElementById('skillid').value = title;
		document.getElementById('skill_id').value = skillid;
		$("#result_skill").html('');
		return true;
	}
</script>