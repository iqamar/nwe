<?php 
/*$action = $this->params->action;
if ($this->params->admin) {
    $action = str_replace('admin_', '', $action);
}
if ($action == 'index') {
    $options = array('class' => 'current');
} else {
    $options = null;
}
$this->Html->addCrumb(
        Inflector::humanize($this->params->controller), array('controller' => $this->params->controller, 'action' => 'index'), $options
);
if ($action !== 'index') {
    $this->Html->addCrumb(
            Inflector::humanize($action), array('action' => $action, 'admin' => (bool) $this->params->admin), array('class' => 'active')
    );
}*/
    $bread_crumbs = $this->Html->getCrumbList(
        array('class' => 'breadcrumb', 'lastClass' => 'active', 'separator' => '<span class="divider">/</span>'), 
        array('text' => '<i class="icon-home"></i> Home','escape' => false)
        ); 
    echo $bread_crumbs;
?>