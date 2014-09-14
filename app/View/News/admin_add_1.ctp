<div>
    <ul class="breadcrumb">
	<li>
	    <a href="#">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="#">News</a>
	</li>
    </ul>
</div>

<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-edit"></i>Add News</h2>
	    <div class="box-icon">
		<a title="List" href="<?php echo $this->request->webroot; ?>admin/employers/" style="width:25px;"><img alt="Add" src="<?php echo $this->request->webroot; ?>alaxos/img/toolbar/list.png"></a>
	    </div>
	</div>


	<div class="box-content"><br/>
            <form class="form-horizontal" name="form" enctype="multipart/form-data" action="#" method="post">
		<fieldset>




		    <div class="control-group">
			<label class="control-label" for="heading">Heading</label>
			<div class="controls">
			    <input class="input-xlarge focused" id="selectComapny" name="heading" type="text" value="">
			</div>
		    </div>


		    <div class="control-group">
			<label class="control-label" for="details">Details</label>
			<div class="controls">
			    <textarea class="cleditor" id="address" name="details" rows="3"></textarea>
			</div>
		    </div>


		    <div class="control-group">
			<label class="control-label" for="logo">Featured Image</label>
			<div class="controls">
			    <input type="file" name="logo" id="logo">
			</div>
		    </div>

                    
                    <div class="control-group">
			<label class="control-label" for="cat">Category</label>
                        <div class="controls">
                            <select id="select" multiple data-rel="chosen">
                            <?php
                            foreach ($categories as $category):
                            ?>
                            
         <option>Option 1</option>
                                
                            
                            <?php endforeach; ?>
                          </select>   
                            
                        </div>
                        </div>

                    <div class="control-group">
			<label class="control-label" for="locations">Country</label>
			<div class="controls">
			    <select id="locations" name="locations" data-rel="chosen">
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
			<label class="control-label" for="news_url">News URL</label>
			<div class="controls">
			    <input class="input-xlarge" id="primary_email" name="news_url" type="text" value="">
			</div>
                        
			<label class="control-label" for="rss_link">RSS Link</label>
			<div class="controls">
			    <input class="input-xlarge" id="alternative_email" name="rss_link" type="text" value="">
			</div>
		    </div>

		    

                    <div class="control-group">
			<label class="control-label" for="publish">Publish To</label>
			<div class="controls">
			    <select name="publish" data-rel="chosen">
    				<option value="1">Yes</option>
                                <option value="2">No</option>
    				
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





