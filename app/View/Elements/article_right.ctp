<div class="grid_4">
<?php if ($this->Session->read(@$userid)) {
	
	?>
<div class="ttle-bar" style="clear:both;">About Auther</div>
<div class="relat-jobmain-div auther">
  <div class="relat-job-div">
    <div class="relat-jobcolm">
      <div class="relat-jobtxt" style="margin-left:17px;">
        <h1><?php echo $userpic['firstname']." ".$userpic['lastname']?></h1>
        <?php echo $userpic['tags'];?> </div>
    </div>
  </div>
  <div class="relat-job-pht"><?php echo $this->Html->image('/files/users/'.$imgname,array('style'=>'width:60px; height:60px; float:left; margin-right:10px;'));?></div>
</div>    
 <!-- current user posts added start-->
 <div class="ttle-bar" style="clear:both; background-color: #F6F6F6; color:#0057AE;"><?php echo $userpic['firstname'];?>'s recently posts</div>
  <?php foreach ($articlesSubmittedByCurrent as $myPost) {?>
 <div class="relat-jobmain-div">
  <div class="relat-job-div">
    <div class="relat-jobcolm">
      <div class="relat-jobtxt">
        <h1 style="font-size:13px;"><?php echo $this->Html->link($myPost['articles']['title'],array('controller'=>'articles','action'=>'detail',$myPost['articles']['id']),array('style'=>'text-decoration:none; color:#333;'));?></h1>
       <span style="float:right; font-size:11px; color:#9B9B9B;"><?php echo $myPost['articles']['created'];?></span> </div>
    </div>
  </div>
  <div class="relat-job-pht"><a href="#"><img src="<?php echo $this->base;?>/img/j2.png" width="50" height="50" /></a></div>
</div>   
<?php }?>    
		<div style="float:right;"><a href="#" style="text-decoration:none;">see all</a></div> 
<!-- current user articles added end-->

<!-- related articles added start-->
<?php 
	if ($this->params['pass']) {
	?>
 <div class="ttle-bar" style="clear:both;">Related articles</div>
 <?php foreach ($postUnderParentId as $postInThisId) {?>
<div class="relat-jobmain-div">
  <div class="relat-job-div">
    <div class="relat-jobcolm">
      <div class="relat-jobtxt">
      	<h1 style="font-size:13px; color:#A3A3A3;"><?php echo $postInThisId['users_profiles']['firstname']." ".$postInThisId['users_profiles']['lastname'];?></h1>
        <h1 style="font-size:13px;"><?php echo $this->Html->link($postInThisId['articles']['title'],array('controller'=>'articles','action'=>'detail',$postInThisId['articles']['id']),array('style'=>'text-decoration:none; color:#333;'));?></h1>
       <span style="float:right; font-size:11px; color:#9B9B9B;"> <?php echo $postInThisId['articles']['created'];?></span> </div>
    </div>
  </div>
  <div class="relat-job-pht"><a href="#"><img src="<?php echo $this->base;?>/img/j3.png" width="50" height="50" /></a></div>
</div>   
<!-- related articles added end-->
<?php }}}?>

</div>