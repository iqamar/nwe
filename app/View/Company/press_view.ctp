<div class="wrapper press">
<ol class="breadcrumb">
  <li><?php echo $this->Html->link('Home','/',array('escape'=>false)); ?></li>
  <li><?php echo $this->Html->link('Press Release',array('controller'=>'company','action'=>'press'),array('escape'=>false)); ?></li>
  <li class="active"><?php echo $press['press_release']['headline']; ?></li>
</ol>
<div class="rgtcol">
<div class="box bigheading">
		<div class=" marginbottom10">
        	<h2><?php echo $press['press_release']['headline']; ?></h2>
		</div>
      <div class="linebreakborder">Posted on: <strong><?php echo date("DmY",strtotime($press['press_release']['created'])); ?></strong>, Location: <strong><?php echo $press['press_release']['city'].',&nbsp;'.$press['Country']['name']; ?></strong></div>
      <div>
		<?php echo $press['press_release']['details'];?>
      </div>
      <div>
      <div class="margintop20 marginbottom10">
        <h2>About Company</h2> 
      </div>
		<?php echo $press['press_release']['organization_info'];?>
      </div>
            <div>
      <div class="margintop20 marginbottom10">
        <h2>Contact Details</h2>
      </div>
      	<?php echo $press['press_release']['contact_info'];?>
      </div>
    <div class="clear"></div>
	</div> 
</div> 
<div class="leftcol">
		<?php 
			if($press['press_release']['image_url']){
				echo $this->Html->Image(MEDIA_URL.'/files/press/cover/'.$press['press_release']['image_url'],array('style'=>'max-width:430px;')); 
			}else{
				echo $this->Html->Image(MEDIA_URL.'/img/press_release_nopic.jpg',array('style'=>'max-width:430px;')); 
			}
			?>
		
		
    <div class="clear"></div>
</div>
<div class="clear"></div>
</div>