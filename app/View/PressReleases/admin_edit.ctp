<div>
    <ul class="breadcrumb">
	<li>
	    <a href="#">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="#">Press Releases</a>
	</li>
    </ul>
</div>

<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-edit"></i>Edit Press Releases</h2>
	    <div class="box-icon">
		<a title="List" href="<?php echo $this->request->webroot; ?>admin/press/" style="width:25px;"><img alt="Add" src="<?php echo $this->request->webroot; ?>alaxos/img/toolbar/list.png"></a>
	    </div>
	</div>


	<div class="box-content"><br/>
            <form class="form-horizontal" name="form" enctype="multipart/form-data" action="#" method="post">
		<fieldset>




		    <div class="control-group">
			<label class="control-label" for="heading">Headline</label>
			<div class="controls">
                            <input class="input-xlarge focused" id="selectComapny" name="headline" type="text" value="<?=$data['press_releases']['headline']?>">
			</div>
		    </div>

		    <div class="control-group">
			<label class="control-label" for="details">Details</label>
			<div class="controls">
			    <textarea class="cleditor" id="address" name="details" rows="3"><?=$data['press_releases']['details']?></textarea>
			</div>
		    </div>


		    <div class="control-group">
			<label class="control-label" for="logo">Featured Image</label>
			<div class="controls">
			    <input type="file" name="logo" id="logo">
                            <img src="<?=$imageName?>" height="50" width="50"/>
                            
			</div>
		    </div>

                    
                    

                    <div class="control-group">
			<label class="control-label" for="locations">Country</label>
			<div class="controls">
			    <select id="locations" name="locations" data-rel="chosen">
                                <option value="<?=$country['countries']['id']?>" ><?=$country['countries']['name']?></option>  
				<?php
				foreach ($countries as $country):
				    ?>
    				<option value="<?php echo $country['countries']['id']; ?>">
					<?php echo $country['countries']['name']; ?>
    				</option>
				<?php endforeach; ?>
			    </select>
			</div>
		    </div>
		    
		    
		    <div class="control-group">
			<label class="control-label" for="city">City</label>
                        <div class="controls">
                            <input class="input-xlarge focused" id="selectComapny" name="city" type="text" value="<?=$data['press_releases']['city']?>">
                            
                        </div>
                        </div>



		    <div class="control-group">
			<label class="control-label" for="org_info">Organization Info</label>
			<div class="controls">
			    <textarea class="input-xlarge" id="primary_email" name="org_info"><?=$data['press_releases']['organization_info']?></textarea>
			</div>
                        
			<label class="control-label" for="contact_info">Contact Information</label>
			<div class="controls">
			    <textarea class="input-xlarge" id="alternative_email" name="contact_info"><?=$data['press_releases']['contact_info']?></textarea>
			</div>
		    </div>

		    

                    <div class="control-group">
			<label class="control-label" for="publish">Publish</label>
			<div class="controls">
			    <select name="publish">
			    	<?php
			    	if($data['press_releases']['publish'] == 1){
			    	?>
			    	<option value="1">Yes</option>
			    	<option value="0">No</option>
			    	<?php
					}
					
					else{
						
					?>
					<option value="0">No</option>
					<option value="1">Yes</option>
					<?php
					}
			    	?>
    				
			    </select>
			</div>
		    </div>

		    

		    <div class="control-group">
			<div class="controls">
			    <button type="submit" class="btn btn-primary">Save</button>
			    <button type="reset" class="btn">Cancel</button>
			</div>
		    </div>

		</fieldset>
	    </form>
	</div>


    </div>
</div>