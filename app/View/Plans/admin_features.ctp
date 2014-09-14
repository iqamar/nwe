<div>
    <ul class="breadcrumb">
	<li>
	    <a href="#">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="#">Plans</a>
	</li>
    </ul>
</div>
 




<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Plans Features</h2>
	    <div class="box-icon">
		<a title="Add" href="<?php echo $this->request->webroot; ?>admin/plans_features/add" style="width:25px;"><img alt="Add" src="/alaxos/img/toolbar/add.png"></a>
	    </div>
	</div>
	<div class="box-content">
	    <table class="table table-striped table-bordered bootstrap-datatable">
		<thead>
		    <tr>
			
			<th>Feature Name</th>
			 <?php
		   //echo "<pre>";
		    //print_r($plansfeatures);
		    foreach ($plans as $plan):
			?>



			<th>
				<?php echo $plan['plans']['title']; ?><br>
				<?php echo "Price:".$plan['plans']['price']; ?><br>
				<?php echo "Yearly Discount:".$plan['plans']['yearly_discount_percentage']; ?>%
			</th>				
		<?php endforeach; ?>
		    </tr>
		</thead>
		<tbody>


		<?php		  
			$feature_id = "-1";
		    foreach ($features as $feature):
				if($feature_id != $feature['plans_features_masters']['id']){
					if($feature_id != "-1"){	echo "</tr>";}
						echo '<tr>'.									
							'<td>'.$feature['plans_features_masters']['title'].
    						'</td>'.
							'<td>'.
							'<input type="text" name="plans_features_'.$feature['plans_features']['id'].'" value="'.$feature['plans_features']['value'].'">'.				
    						'</td>';
					$feature_id = $feature['plans_features_masters']['id'];
				}else{

					echo '<td>'.
						'<input type="text" name="plans_features_'.$feature['plans_features']['id'].'" value="'.$feature['plans_features']['value'].'">'.				
    					'</td>';
				}
			 endforeach; 
			?>   

 
  		    </tr>




		</tbody>
	    </table>
	</div>
    </div><!--/span-->

</div><!--/row-->



