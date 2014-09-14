<?php
echo $this->Html->script('jquery-1.9.1.js');
?>
<br><br><br><br><br><br>
<center><h1>
        <?=$this->Session->flash();?> <br>
        <a class="btn btn-success btn-primary" href="/admin/jobs/add">Yes</a>&nbsp;&nbsp;<a class="btn btn-primary" href="/admin/jobs">No</a>
</h1></center>