<div>
    <ul class="breadcrumb">
	<li>
	    <a href="#">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="#">Help Section</a>
	</li>
    </ul>
</div>

<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-edit"></i>Edit Help Section</h2>
	    <div class="box-icon">
		<a title="List" href="<?php echo $this->request->webroot; ?>admin/help/" style="width:25px;"><img alt="Add" src="<?php echo $this->request->webroot; ?>alaxos/img/toolbar/list.png"></a>
	    </div>
	</div>


	<div class="box-content"><br/>
            <form class="form-horizontal" name="form" enctype="multipart/form-data" action="#" method="post">
		<fieldset>




		    <div class="control-group">
			<label class="control-label" for="article">Article</label>
			<div class="controls">
			    <input class="input-xlarge focused" id="selectComapny" name="article" type="text" value="<?=$press['help_sections']['article']?>">
			</div>
		    </div>


		    <div class="control-group">
			<label class="control-label" for="details">Details</label>
			<div class="controls">
			    <textarea class="cleditor" id="address" name="details" rows="3"><?=$press['help_sections']['details']?></textarea>
			</div>
		    </div>

                 
                    <div class="control-group">
			<label class="control-label" for="cat">Help Category</label>
                        <div class="controls">
                            <select name="category" id="select">
                                <option value="<?=$helpCategory['help_categories']['id']?>"><?=$helpCategory['help_categories']['category_name']?></option>
                            <?php
                            foreach ($categories as $category):
                            ?>
                            
                                <option value="<?=$category['help_categories']['id']?>"><?=$category['help_categories']['category_name']?></option>
                                
                            
                            <?php endforeach; ?>
                          </select>   
                            
                        </div>
                        </div>

                    <div class="control-group">
			<label class="control-label" for="publish">Publish</label>
			<div class="controls">
			    <select name="publish">
    				<option value="1">Yes</option>
                                <option value="0">No</option>
    				
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





