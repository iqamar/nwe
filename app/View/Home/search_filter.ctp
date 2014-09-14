<?php $this->Paginator->options(array('update' => '#ser','evalScripts'=>true,'url' => $this->passedArgs,'data'=>http_build_query($this->request->data),'before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false))));?>
<?php echo $this->element('Default/search_filter_box'); ?>
<div class="clear"></div>
<div class="box">
<div class="flash flash_success" id="savedJob" style="display:none;"></div>
   <?php if (!empty($datau)): ?>

        <div class="boxheading">
            <h1>
                <div class="searchbox-icons">
                    <?php echo $this->Html->image(MEDIA_URL . '/img/people-icon.png'); ?>
                </div>People
                <!--<span class="searchbox-total">(<?php echo $this->Paginator->counter('{:count}'); ?>)</span>-->
            </h1>
            <div class="boxheading-arrow"></div>
        </div>
        <div class="margintop20">
			<div id="spinner" style="display: none;width:552px;height:316px;position:absolute;padding:210px 0px 0px 450px;background:#f9f9f9;">
			<?php echo $this->Html->Image(MEDIA_URL.'/img/loading.gif', array('id' => 'busy-indicator')); ?>
			</div>
            <?php foreach ($datau as $data): ?>
                <?php
                $profile_id = $data['Users_profile']['handler'];
                $profile_url = NETWORKWE_URL . '/pub/' . $profile_id;
                $fullname = $data[0]['fullname'];
				
                if (empty($data['Users_profile']['photo']) || !file_exists(MEDIA_PATH . '/files/user/icon/' . $data['Users_profile']['photo'])) {
                    $profile_pic = '/img/nophoto.jpg';
                }
                else
                    $profile_pic = '/files/user/icon/' . $data['Users_profile']['photo'];
                ?>

                <div class="searchresult-holder" id="usersResultSet">
                    <div class="resultpic">
                        <?php echo $this->Html->link($this->Html->image(MEDIA_URL . $profile_pic, array('alt' => $data['Users_profile']['fullname'])), $profile_url, array('escapeTitle' => false, 'title' => $data['Users_profile']['fullname'])); ?>
                    </div>
                    <div class="searchresult-rgt-full">
                        <ul>
                            <li>
                                <a href="<?php echo $profile_url ?>">
                                    <?php echo $fullname ?>
                                </a>
                            </li>
                            <li>
                                <div class="listing-bttns" id="ajax_response">
                                    <a href="<?php echo $profile_url ?>" class="send-bttn"> Connect</a>
                                </div>
                                <?php echo $data['Users_profile']['tags'] ? $data['Users_profile']['tags'] : 'No title'; ?></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>

		
            <?php endforeach; ?>
        </div>
		
        <div class="clear"></div>
        <div class="paging">
			<?php 
				echo $this->Paginator->first(__('<< First', true), array('class' => 'number-first')).'&nbsp;&nbsp;';
				echo $this->Paginator->numbers(array('separator' => '&nbsp;&nbsp;','class' => 'numbers', 'first' => false, 'last' => false)).'&nbsp;&nbsp;';
				echo $this->Paginator->last(__('Last >>', true), array('class' => 'number-end'));
			?>
        </div>

    <?php else: ?>
        <div class="error_msg">No Result Found...</div>
    <?php endif; ?>

    <div class="clear">&nbsp;</div>
	
</div>
<?php echo $this->Js->writeBuffer();?>
