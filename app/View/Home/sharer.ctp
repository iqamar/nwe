<?php echo $this->Html->css(MEDIA_URL.'/css/content-grab.css'); ?>

		<div id="share">
			<div class="sharepost-user">
				<div class="greybox" style="padding-bottom:60px;">
					<?php 
						if ($this->Session->read(@$userid)) {
							$cuser = $this->Session->read(@$userid);
							$logged_user = $cuser['Auth']['User'];
							$uid = $cuser['userid'];
							
						?>
					

					<?php echo $this->Form->create('Statusupdate', array('url'=>'/home/sharer/','enctype'=>'multipart/form-data','onsubmit'=>'return validateForms();','id'=>'updateUploader','class'=>'sharepost'));?>
					
					<label>
						<h1>Share on NetworkWE:</h1> 
						<?php echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $uid)); ?>
						<?php echo $this->Form->input('share_with' , array('type' => 'hidden', 'id' => 'share_with')); ?>
						<?php echo $this->Form->input('share_image' , array('type' => 'hidden', 'id' => 'share_image','value' => $crowlJSON['images'][0])); ?>
						<?php echo $this->Form->input('share_title' , array('type' => 'hidden', 'id' => 'share_title','value' =>  $crowlJSON['title'])); ?>
						<?php echo $this->Form->input('share_url' , array('type' => 'hidden', 'id' => 'share_url','value' => $share_url)); ?>
						
						 <?php echo $this->Form->input('share_source' , array('type' => 'hidden', 'id' => 'share_url','value' => $share_source)); ?>
						<?php echo $this->Form->input('share_content' , array('type' => 'hidden', 'id' => 'share_content','value' =>  $crowlJSON['content'])); ?>
						<?php echo $this->Form->textarea('user_text',array('required'=>false,'placeholder'=>'Say something about this','id'=>'get_url','class'=>'shareupdate-field')); ?>
					</label>
					
					<div class="div-for-share" id="div-for-share" stylei1="display:none;">
						<a href="javascript:void(0)" onclick="clearUpdate();" class="comment-close"></a>
						<div id="results"></div>
						<?php
                                                        if(!empty($crowlJSON['images'][0])){
                                                                echo '<img class="preview_img" src="'.$crowlJSON['images'][0].'" alt="No Image Found" width="150" height="100" id="preimg"/>';
                                                        }
                                                ?>

						<div class='result_txt' style="width:470px;float:right">
							<b><?php echo $crowlJSON['title'];?></b><br/>
							<?php echo $crowlJSON['content'];?>
						</div>
						<div class="clear"></div>
						<?php echo $this->Form->textarea('link_content',array('required'=>false,'id'=>'link_content','style'=>'display:none;')); ?>
						
					</div>
					<div id="output" style="display:none; text-align:center;">
						<?php echo $this->Html->image(MEDIA_URL.'/img/ajax-loader.gif',array());?>
					</div>
					<div id="share-bttns" style1="display:none;">
						<?php echo $this->Form->submit('Share',array('div'=>false,'id'=>'uploadButton','class'=>'sharepostbttn_fix')); ?>
						<select name="data[Statusupdate][share_with]" class="default" tabindex="3" style="width:410px;">
                            <option value="0" class="" selected>Public</option>
                            <option value="1" class="">Connection</option>
                            <option value="2" class="">Only Me</option>
						</select>
					</div>
					
					<?php echo $this->Form->end();?>
					<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div>		
