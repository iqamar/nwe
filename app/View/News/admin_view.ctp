<?php 
$this->Html->addCrumb(' Dashboard', '/admin');
$this->Html->addCrumb(' News', array('controller' => 'news', 'action' => 'index'));
$this->Html->addCrumb(' ' . $news['News']['heading'], array('controller' => 'news', 'action' => 'view', $this->request->pass[0]));
echo $this->element('Siteadmin/breadcrumb'); ?>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-list"></i> News</h2>
        </div>
        <div class="box-content well-large">
            
            <h3><?php echo $news['News']['heading'] ?></h3>
            <p>
                <label class="label">Date: <?php echo $news['News']['created'] ?></label>
                <?php if ($news['News']['image_url'] != NULL): ?>
                <img class="thumbnail input-medium pull-right" src="<?= MEDIA_URL . "/files/news/logo/" . $news['News']['image_url'] ?>"/>
                <?php endif; ?>
                <?php echo htmlspecialchars_decode($news['News']['details']); ?>
            </p>
            
            <div class="clear"></div>
        </div>
    </div>
</div>
