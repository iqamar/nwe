<?php
echo $this->Html->script('jquery-1.9.1.js');
?>

<script type="text/javascript">
$(document).ready(function(){
    
    <?php
    foreach ($plans as $plan){
        ?>
              /* $("#features_<?=$plan['plan_id']?>").hide();
             $("#plan_<?=$plan['plan_id']?>").click(function(){
                 $("#features_<?=$plan['plan_id']?>").toggle('slow');
             });   */
    <?php
    }
    ?>
    
});
</script>


<div class="box-content" style="padding-top:10px;">
		
	  

<table>
<?php
//static $i = 0;
/*
echo "<pre>";
print_r($plans);
*/
foreach ($plans as $plan) {
?>
    <tr class="well top-block"><td valign="top" style="padding-right:20px;">
      <h2>      
    <?=$plan['plan_title']?>    
	</h2>      
            </td>
    <td style="background:#F1F1F1;">
            
            <table class="table table-striped table-bordered" style="margin-bottom:0px;">
                
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
    
</td>
<td valign="center" style="padding-left:20px;text-align:left">
            
    
    <a href="/recruiter/checkout/m/<?=$plan['plan_id']?>/" class="btn btn-primary" style="width:220px;" >Buy <?=$plan['plan_title']?> monthly for USD <?=$plan['month_price']?></a><br/>
    <a href="/recruiter/checkout/y/<?=$plan['plan_id']?>/" class="btn btn-success" style="margin-top:10px;width:220px;">Buy <?=$plan['plan_title']?> yearly for USD <?=$plan['year_price']?></a>

            </td>
</tr>
    <?php
}
?>
</table>