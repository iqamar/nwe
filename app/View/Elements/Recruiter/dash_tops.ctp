<?php //echo $this->Html->script('jquery.min');     ?>
<?php
$strstr = "";
foreach ($ind as $index) {
    $idata = $index[0]['ind'];
    $ititle = $index['functional_area']['iname'];
    if (strlen($ititle) > 25) {
        $ititle = substr($ititle, 0, 25) . '..';
    }
    $strstr .= '{label:"' . $ititle . '",data:' . $idata . '},';
}
$strstr = trim($strstr, ",");
?>
<script type="text/javascript">
    /*$(document).ready(function() {
     //pie chart
     var data = [<?php echo $strstr; ?>];
     
     if ($("#piechart").length) {
     $.plot($("#piechart"), data, {
     series: {
     pie: {
     show: true
     }
     },
     grid: {
     hoverable: true,
     clickable: true
     },
     legend: {
     show: false
     }
     });
     
     function pieHover(event, pos, obj) {
     if (!obj)
     return;
     percent = parseFloat(obj.series.percent).toFixed(2);
     $("#hover").html('<span style="font-weight: bold; color: ' + obj.series.color + '">' + obj.series.label + ' (' + percent + '%)</span>');
     }
     $("#piechart").bind("plothover", pieHover);
     }
     });*/
</script>
<div class="row-fluid sortable">
    <?php /*<div class="box span4">
        <div class="box-header well" data-original-title>
            <h2><i class="icon icon-color icon-users"></i> Latest Members</h2>
            <div class="box-icon">
                <!--<a href="#" class="btn btn-round"><i class="icon-th-list"></i></a>-->
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">

            <ul class="dashboard-list" style="min-height:280px;">
                <?php
                //pr($topUsers);
                foreach ($topUsers as $key => $rows) {
                    foreach ($rows as $row) {
                        if (!empty($row)) {
                            echo "<li>" . $this->Html->link($this->Html->Image(MEDIA_URL . '/files/user/icon/' . $row['Users_profile']['photo'], array('class' => 'dashboard-avatar')), '#', array('escape' => false)) .
                            $this->Html->link($row['Users_profile']['firstname'] . '&nbsp;' . $row['Users_profile']['lastname'], '#', array('escape' => false)) . "<br/>" .
                            $row['Users_profile']['tags'] . "<br/><strong>City:</strong>" . $row['Users_profile']['city'] .
                            "</li>";
                        }
                    }
                }
                ?>
            </ul>
        </div>
    </div> */?>
    <div class="box span4">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-list-alt"></i> Hot Jobs</h2>
            <div class="box-icon">
                <!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <ul class="dashboard-list">
                <?php foreach ($hot_jobs as $row): ?>
                <?php $percentage = (($row[0]['cnt'] / $total_applications) * 100) / 10; ?>
                <li>
                    <?php echo $this->Html->link($row['Job']['title'], array('controller' => 'recruiter', 'action' => 'jobs_view', $row['Job']['id']), array('escape' => false)); ?>
                    <br/><span class="raty" data-score="<?php echo round($percentage/2, 2); ?>"></span> 
                    <span class="muted"><strong>Company: </strong><?php echo $row['Company']['title']?$row['Company']['title']:'N/A'; ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div id="s1"></div>
    </div>
    <div class="box span4">
        <div class="box-header well" data-original-title>
            <h2><i class="icon icon-color icon-bookmark"></i> Latest Opportunities</h2>
            <div class="box-icon">
                <!--<a href="#" class="btn btn-round"><i class="icon-th-list"></i></a>-->
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <ul class="dashboard-list">
                <?php foreach (array_slice($jobs_list, 0, 4) as $row): ?>
                    <li>
                        <?php echo $this->Html->link($row['Job']['title'], array('controller' => 'recruiter', 'action' => 'jobs_view', $row['Job']['id']), array('escape' => false)); ?>
                        <br/><strong>Location: </strong><?php echo $row['Country']['name']?$row['Country']['name']:'N/A'; ?>
                        <br/>
                        <span class="muted"><b>Validity:</b> <?php echo date("M j, Y", strtotime($row['Job']['start_date'])); ?> till <?php echo date("M j, Y", strtotime($row['Job']['expiry_date'])); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php if (!$user): ?>
        <div class="box span4">
            <div class="box-header well" data-original-title>
                <h2><i class="icon-retweet"></i> Connect to Facebook</h2>
                <div class="box-icon">
                    <!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
                    <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <br/>
                <p class="muted">Click on "Connect to Facebook" to share jobs on Facebook page after posting a new job.</p>
                <a class="btn btn-primary btn-lg" href="<?php echo $loginUrl; ?>">Connect to Facebook</a>
            </div>
            <div id="s1"></div>
        </div>
    <?php endif; ?>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
$(function() {
    $.fn.raty.defaults.path = media +'/backend/img';
    $('.raty').raty({
        score: function() {return $(this).attr('data-score');},
        round : { down: .26, full: .6, up: .76 },
        readOnly: true,
        half: true
    });
});
</script>