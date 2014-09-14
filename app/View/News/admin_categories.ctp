<?php
$this->Html->addCrumb(' Dashboard', '/admin');
$this->Html->addCrumb(' News', array('controller' => 'news', 'action' => 'index'));
$this->Html->addCrumb(' Categories', array('controller' => 'news', 'action' => 'categories'));
echo $this->element('Siteadmin/breadcrumb');
?>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> News Categories</h2>
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-plus icon-white')) . " Add", array('controller'=>'news','action' => 'addCategory'), array('class' => 'btn btn-primary span1 pull-right', 'escape' => false)); ?> 
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                    <?php $category_name = htmlspecialchars_decode($category['news_categories']['category'], ENT_NOQUOTES); ?>
                        <tr>
                            <td>
                            <?php echo $category_name; ?>
                            </td>
                            <td class="center" nowrap>
                                <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-edit icon-white')) . " Edit", array('action' => 'editCategory', $category['news_categories']['id']), array('class' => 'btn btn-info', 'escape' => false)); ?> 
                                <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-trash icon-white')) . " Delete", array('action' => 'deleteCategory', $category['news_categories']['id']), array('class' => 'btn btn-danger', 'escape' => false), "Are you sure you wish to delete this category?"); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div><!--/span-->
</div><!--/row-->



