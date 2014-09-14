<?php
//echo $industry;
//print_r($company);
//echo $company['Companies']['title'];
?>

<div>
    <ul class="breadcrumb">
	<li>
	    <a href="#">Home</a> <span class="divider">/</span>
	</li>
	<li>
	    <a href="#">Employers</a>
	</li>
    </ul>
</div>

<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-edit"></i> Edit Employer</h2>
	    <div class="box-icon">
		<a title="List" href="<?php echo $this->request->webroot;?>admin/employers/" style="width:25px;"><img alt="Add" src="/alaxos/img/toolbar/list.png"></a>
	    </div>
	</div>


	<div class="box-content"><br/>
	    <form class="form-horizontal" enctype="multipart/form-data" action="#" method="post">
		<fieldset>




		    <div class="control-group">
			<label class="control-label" for="selectComapny">Employer Name</label>
			<div class="controls">
			    <input class="input-xlarge focused" id="selectComapny" name="selectCompany" type="text" value="<?=$company['Companies']['title']?>">
			</div>
		    </div>

		    <div class="control-group">
			<label class="control-label" for="logo">Logo Upload</label>
			<div class="controls">
			    <input type="file" name="logo" id="logo">
			</div>
		    </div>

			<div class="control-group">
			<label class="control-label" for="established">Established In</label>
			<div class="controls">
			    <input class="input-xlarge focused" id="established" name="established" type="text" value="<?=$company['Companies']['established']?>">
			</div>
		    </div>

 			<div class="control-group">
			<label class="control-label" for="companies_types">Employer Type</label>
			<div class="controls">
			    <select id="companies_types" name="companies_types" >
				<?php
				foreach ($companies_types as $type):
				    ?>
    				<option value="<?php echo $type['companies_types']['id']; ?>">
					<?php echo $type['companies_types']['title']; ?>
    				</option>
				<?php endforeach; ?>
			    </select>
			</div>
		    </div>

		<div class="control-group">
			<label class="control-label" for="industries">Industry</label>
			<div class="controls">
			    <select id="industries" name="industries" >
				<?php
				foreach ($industries as $industry):
				    ?>
    				<option value="<?php echo $industry['industries']['id']; ?>">
					<?php echo $industry['industries']['title']; ?>
    				</option>
				<?php endforeach; ?>
			    </select>
			</div>
		    </div>



		    <div class="control-group">
			<label class="control-label" for="address">address</label>
			<div class="controls">
			    <textarea id="address" name="address" rows="3"><?=$company['Companies']['address']?></textarea>
			</div>
		    </div>

		    <div class="control-group">
			<label class="control-label" for="primary_email">Primary Email</label>
			<div class="controls">
			    <input class="input-xlarge" id="primary_email" name="primary_email" type="text" value="<?=$company['Companies']['primary_email']?>">
			</div>
			<label class="control-label" for="alternative_email">Alternative Email</label>
			<div class="controls">
			    <input class="input-xlarge" id="alternative_email" name="alternative_email" type="text" value="<?=$company['Companies']['alternative_email']?>">
			</div>
		    </div>

		    <div class="control-group">
			<label class="control-label" for="contact_name">Contact Person</label>
			<div class="controls">
			    <input class="input-xlarge" id="contact_name" name="contact_name" type="text" value="<?=$company['Companies']['contact_name']?>">
			</div>
		    </div>

		    <div class="control-group">
			<label class="control-label" for="design">Designation</label>
			<div class="controls">
			    <input class="input-xlarge" id="design" name="design" type="text" value="<?=$company['Companies']['designation']?>">
			</div>
		    </div>



		    <div class="control-group">
			<label class="control-label" for="fax1">Fax 1</label>
			<div class="controls">
			    <input class="input-xlarge" id="fax1" name="fax1" type="text" value="<?=$company['Companies']['fax1']?>">
			</div>
			<label class="control-label" for="fax2">Fax 2</label>
			<div class="controls">
			    <input class="input-xlarge" id="fax2" name="fax2" type="text" value="<?=$company['Companies']['fax2']?>">
			</div>
		    </div>

		    <div class="control-group">
			<label class="control-label" for="mobile">Mobile</label>
			<div class="controls">
			    <input class="input-xlarge" id="mobile" name="mobile" type="text" value="<?=$company['Companies']['mobile']?>">
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
			<label class="control-label" for="state">State</label>
			<div class="controls">
			    <input class="input-xlarge" id="state" name="state" type="text" value="<?=$company['Companies']['state']?>">
			</div>
		    </div>

		    <div class="control-group">
			<label class="control-label" for="city">City</label>
			<div class="controls">
			    <input class="input-xlarge" id="city" name="city" type="text" value="<?=$company['Companies']['city']?>">
			</div>
		    </div>

		    <div class="control-group">
			<label class="control-label" for="weburl">Web Site</label>
			<div class="controls">
			    <input class="input-xlarge" id="weburl" name="weburl" type="text" value="<?=$company['Companies']['weburl']?>">
			</div>
		    </div>




			 <div class="control-group">
			<label class="control-label" for="featured_employer">Featured Employer?</label>
			<div class="controls">
                            <input class="input-xlarge" id="featured_employer" name="featured_employer" type="checkbox" value="<?=$company['Companies']['featured_display']?>" <?php if ($company['Companies']['featured_display'] == 1) echo 'checked';?>>
			</div>
		    </div>


			 <div class="control-group">
			<label class="control-label" for="top_employer_display">Top Employer?</label>
			<div class="controls">
			    <input class="input-xlarge" id="top_employer_display" name="top_employer_display" type="checkbox" value="<?=$company['Companies']['featured_display']?>" <?php if ($company['Companies']['top_employer_display'] == 1) echo 'checked';?>">
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

<?php
echo $this->element('sql_dump');
?>