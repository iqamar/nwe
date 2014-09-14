<style type="text/css">
.control-group.required .control-label:after {
  content:"*";
  color:red;
}
.top-buffer4 { margin-top:20px; }
.top-buffer1 { margin-top:5px; }
</style>
<?php 
$this->Html->addCrumb(' Dashboard', '/admin');
$this->Html->addCrumb(' News', array('controller' => 'news', 'action' => 'index'));
$this->Html->addCrumb(' Add', array('controller' => 'news', 'action' => 'add'));
echo $this->element('Siteadmin/breadcrumb'); ?>

<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-edit"></i>Add News</h2>
	</div>
	<div class="box-content"><br/>
            <form id="form_admin" class="form-horizontal" enctype="multipart/form-data" method="post" role="form">
		<fieldset>
		    <div class="control-group required">
			<label class="control-label" for="heading">Heading </label>
			<div class="controls">
			    <input class="input-xlarge focused" id="heading" name="heading" type="text" value="" required>
			</div>
		    </div>
		    <div class="control-group required">
			<label class="control-label" for="details">Details </label>
			<div class="controls">
                            <span class="input-group">
			    <textarea class="cleditor" id="details" name="details" rows="3" required></textarea>
                            </span>
			</div>
		    </div>
		    <div class="control-group">
			<label class="control-label" for="logo">Featured Image </label>
			<div class="controls">
                            <span class="input-group">
			    <input type="file" name="logo" id="logo">
                            </span>
			</div>
		    </div>
                    <div class="control-group required">
			<label class="control-label" for="cat">Category </label>
                        <div class="controls">
                            <span class="input-group">
                            <select name="category[]" id="category" multiple="multiple" data-rel="chosen" required="">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?=$category['News_category']['id']?>"><?=$category['News_category']['category']?></option>
                            <?php endforeach; ?>
                            </select>
                            </span>
                        </div>
                        </div>
                    <div class="control-group required">
			<label class="control-label" for="locations">Country </label>
			<div class="controls">
                            <span class="input-group">
			    <select id="country" name="country" data-rel="chosen">
                                <option value="">Select</option>
                                <?php foreach ($countries as $country): ?>
                                <option value="<?php echo $country['Country']['id']; ?>"><?php echo trim($country['Country']['name']); ?></option>
                                <?php endforeach; ?>
			    </select>
                            </span>
			</div>
		    </div>
		    <div class="control-group">
                        <span class="input-group">
			<label class="control-label" for="news_url">Source URL</label>
			<div class="controls">
			    <input class="input-xlarge" id="primary_email" name="news_url" type="text" value="">
			</div>
                        <br/>
			<label class="control-label" for="rss_link">RSS Link</label>
			<div class="controls">
			    <input class="input-xlarge" id="alternative_email" name="rss_link" type="text" value="">
			</div>
                        </span>
		    </div>
                    <div class="control-group">
			<label class="control-label" for="publish">Publish To </label>
			<div class="controls">
                            <span class="input-group">
			    <select name="publish" data-rel="chosen">
    				<option value="1">Yes</option>
                                <option value="2">No</option>
			    </select>
                            </span>
			</div>
		    </div>
		    <div class="control-group">
			<div class="controls">
                            <button type="submit" id="btnSubmit" class="btn btn-primary">Save</button>
			    <button type="reset" class="btn">Cancel</button>
			</div>
		    </div>
		</fieldset>
	    </form>
	</div>
    </div>
</div>
<script type="text/javascript">
$(function() {
    $.validator.setDefaults({
        errorClass: "help-block",
        errorElement: "span",
        ignore: ".ignored,.btn,.chzn-choices input,.default,.search-field input,.chzn-search input",
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element.closest('.control-group').removeClass('error').addClass('success');
        },
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length || element.parent('.cleditorMain').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
        
    $.validator.addMethod("accept", function(value, element, param) {
        var typeParam = typeof param === "string" ? param.replace(/\s/g, "").replace(/,/g, "|") : "image/*",
                optionalValue = this.optional(element),
                i, file;
        if (optionalValue) {
            return optionalValue;
        }
        if ($(element).attr("type") === "file") {
            typeParam = typeParam.replace(/\*/g, ".*");
            if (element.files && element.files.length) {
                for (i = 0; i < element.files.length; i++) {
                    file = element.files[i];
                    if (!file.type.match(new RegExp(".?(" + typeParam + ")$", "i"))) {
                        return false;
                    }
                }
            }
        }
        return true;
    }, $.validator.format("Unsupported file format."));

    $.validator.addMethod("sizelimit", function(val, element) {
        return (element.files.length > 0 && element.files[0].size > 2097152) ? false : true;
    }, "Max file size 2MB.");

    $.validator.addMethod("richtext", function(value, element) {
        value = value.replace(/(<([^>]+)>)/ig,"");
        return (value.length>0) ? true : false;
    }, 'This field is required.');

    var validator = $("#form_admin").validate({
        debug: false,
        rules: {
            heading: { required: true },
            logo: { accept: "jpg|jpeg|gif|png", sizelimit: 2097152 },
            details: { richtext: function(){ return $("#details").val(); } },
            country: { required: true },
            news_url: { url: true },
            rss_link: { url: true }
        }
    });
    $("#category").rules("add", {required:true});
});
</script>




