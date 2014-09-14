<?php
echo $this->Html->script('jquery-1.9.1.js');
?>

<script type="text/javascript">
$(document).ready(function(){
    
    <?php
    foreach ($plans as $plan){
        ?>
                $("#features_<?=$plan['plan_id']?>").hide();
             $("#plan_<?=$plan['plan_id']?>").click(function(){
                 $("#features_<?=$plan['plan_id']?>").toggle('slow');
             });   
    <?php
    }
    ?>
    
});
</script>



<table>
<?php
//static $i = 0;
foreach ($plans as $plan) {
?>
    <tr><td>
            <div class="well span3 top-block" style="width: 400px;" id="plan_<?=$plan['plan_id']?>">
    <?=$plan['plan_title']?><br>
    <a href="#" class="btn btn-primary">Monthly: <?=$plan['month_price']?></a>
    <a href="#" class="btn btn-primary">Yearly: <?=$plan['year_price']?></a>
</div>
            </td>
    <td> 
        <div class="well span3 top-block" style="width: 400px;" id="features_<?=$plan['plan_id']?>">
            
            <table>
                
<?php
    foreach ($plan['features'] as $feature){
        
        ?>

                    <tr>
                    <td><?php echo ucfirst($feature['feature_title'])?></td>
                    <td><?php if($feature['value'] != null) echo "<font color='blue'>". ucfirst($feature['value']) . "</font>"; else echo "<font color='blue'>No</font>";?></td>
                    </tr> 

        <?php
    }
    
    ?>
                    
            </table>  
    </div>
</td>
    <?php
}
?>
</table>