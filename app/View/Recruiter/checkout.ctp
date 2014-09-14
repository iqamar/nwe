<?php
//echo "<pre>"; print_r($plans); echo "</pre>";
echo $this->Html->script('jquery-1.9.1.js');
?>

<script type="text/javascript">
$(document).ready(function(){
    
    
    $("#qty").keyup(function(){
        $("#sub_total").html("$" + $("#qty").val() * <?=$price?>);
    });
    
    $("#qty").change(function(){
        $("#sub_total").html("$" + $("#qty").val() * <?=$price?>);
    });
    
    $("#qty").focusout(function(){
        var qty = $("#qty").val();
        if(qty == "" || qty == "0"){
            $("#qty").val('1');
            $("#sub_total").html("$" + $("#qty").val() * <?=$price?>);
        }
    });
    
});


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>

<table height="192" class="table table-striped table-bordered" style="width: 70%;">
  <tr>
    <th height="44" colspan="4" bgcolor="#CCFFCC" style="text-align: left; font-size: 15px;" scope="col">Order Review</th>
  </tr>
  <tr>
    <td width="253" height="27"><strong>Service Name</strong></td>
    <td width="109"><strong>Price</strong></td>
    <td width="45"><strong>QTY</strong></td>
    <td width="239"><strong>Subtotal</strong></td>
  </tr>
  <tr>
    <td height="73"><p>Recruiter <?=$plans[0]['plan_title']?> <?php if($plan_period=='m')echo "Monthly"; if($plan_period=='y') echo "Yearly"; ?> Package</p></td>
    <td><span id="price"><?php if($plan_period=='m')echo "$".$plans[0]['month_price']; if($plan_period=='y')echo "$".$plans[0]['year_price'] ?></span></td>
    <td><input style="width: 50px;" required id='qty' onkeypress="return isNumber(event)" value='1' size="7" maxlength="2"></td>
    <td><span id='sub_total'><?php if($plan_period=='m')echo "$".$plans[0]['month_price']; if($plan_period=='y')echo "$".$plans[0]['year_price'] ?></span></td>
  </tr>
  <tr>
      <td height="36" colspan="4" style="text-align: right"><a href="/recruiter/plans/" class="btn btn-primary" style="width:220px;" >Change Plan</a>&nbsp;&nbsp;
        <a href="#" class="btn btn-success" style="width:220px;">Place Order</a></td>
  </tr>
</table>







  

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

</tr>
    <?php
}
?>
</table>