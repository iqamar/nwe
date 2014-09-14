<?php
print_r($groups);
?>

<div>
    <ul class="breadcrumb">
	<li>
	    <a href="#">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="#">Groups</a>
	</li>
    </ul>
</div>

<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-edit"></i> Edit Group</h2>
	    <div class="box-icon">
		<a title="List" href="<?php echo $this->request->webroot; ?>admin/groups/" style="width:25px;"><img alt="Add" src="/alaxos/img/toolbar/list.png"></a>
	    </div>
	</div>


	<div class="box-content"><br/>
	    <form class="form-horizontal" enctype="multipart/form-data" action="#" method="post">
		<fieldset>
		    <div class="control-group">
			<label class="control-label" for="selectInstitutes">Groups Name</label>
			<div class="controls">
			    <input class="input-xlarge focused" id="selectGroup" name="selectGroup" type="text" value="<?=$groups['groups']['title']?>">
			</div>
		    </div>

		    <div class="control-group">
			<label class="control-label" for="logo">Logo Upload</label>
			<div class="controls">
			    <input type="file" name="logo" id="logo">
			</div>
		    </div>		


 			<div class="control-group">
			<label class="control-label" for="groups_types">Groups Type</label>
			<div class="controls">
			    <select id="groups_types" name="groups_types" >
				<?php
				foreach ($groups_types as $type):
				    ?>
    				<option value="<?php echo $type['groups_types']['id']; ?>">
					<?php echo $type['groups_types']['title']; ?>
    				</option>
				<?php endforeach; ?>
			    </select>
			</div>
		    </div>
	

			<div class="control-group">
			<label class="control-label" for="summary">Summary</label>
			
		   		   <div class="controls">
			    <textarea id="summary" name="summary" ><?=$groups['groups']['summary']?></textarea>
			</div>
		    </div>



			<div class="control-group">
			<label class="control-label" for="description">Description</label>
			
		   		   <div class="controls">
			    <textarea class="cleditor" id="description" name="description" rows="3"><?=$groups['groups']['description']?></textarea>
			</div>
		    </div>



		    <div class="control-group">
			<label class="control-label" for="weburl">Web Site</label>
			<div class="controls">
			    <input class="input-xlarge" id="weburl" name="weburl" type="text" value="<?=$groups['groups']['weburl']?>">
			</div>
		    </div>



		
 
			<div class="control-group">
				
				<label class="control-label" style1="float:right;"><b>User Access</b></label>
			<div class="controls" style="float:left;margin-left:0px;margin-top:10px;">											
				<input id="user_access_approval_yes" name="user_access" style="float:left;" type="radio" value="1"><br/><br/>
				<input id="user_access_approval_no" name="user_access" style="float:left;" type="radio" value="0">
			</div>

			<div class="controls" style="float:left;margin-left:0px;margin-top:14px;">														
				<label style="float:left;" for="user_access_approval_yes">Users must request to join this group and be approved by a manage</label><br/><br/>
				<label style="float:left;margin-top:2px;" for="user_access_approval_no">Any member may join this group without requiring approval from a manager.</label>				
			</div>
		
		    </div>		


			 <div class="control-group">
			<label class="control-label" for="featured_group">Featured Group?</label>
			<div class="controls">
			    <input class="input-xlarge" id="featured_group" name="featured_group" type="checkbox" value="1">
			</div>
		    </div>



			 

			 <div class="control-group">
			<label class="control-label" for="top_groups">Top Groups?</label>
			<div class="controls">
			    <input class="input-xlarge" id="top_groups" name="top_groups" type="checkbox" value="1">
			</div> 
		    </div>


		    <div class="control-group">
			<div class="controls">
			    <button type="submit" class="btn btn-primary" name="create" value="Open" id="createOpen">Create an Open Group</button>
				<button type="submit" class="btn btn-primary" name="create" value="Members-Only" id="createMembersOnly">Create a Members-Only Group</button>
			    <button type="reset" class="btn">Cancel</button>
			</div>
		    </div>

		</fieldset>
	    </form>
	</div>


    </div>
</div>





