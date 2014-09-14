<?php 
$this->Html->addCrumb(' Dashboard', '/recruiter');
$this->Html->addCrumb(' Employer', array('controller' => 'recruiter', 'action' => 'employer'));
$this->Html->addCrumb(' Edit employer', array('controller' => 'recruiter', 'action' => 'employer_edit'));
echo $this->element('Recruiter/breadcrumb'); ?>
<style type="text/css">
    .control-group.required .control-label:after {
        content:"*";
        color:red;
    }
</style>

<div class="row-fluid sortable" id="ser">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-zoom-in"></i> Edit Employer</h2>
        </div>
        <div class="box-content" style="padding-top:10px;" id="cen">
            <form class="form-horizontal" enctype="multipart/form-data" id="companyAdd" method="post">
                <fieldset  style="float:left;width:50%;">
                    <h3 class="title">Company Details</h3>

                    <div class="control-group required">
                        <label class="control-label" for="title">Employer Name </label>
                        <div class="controls">
                            <input class="input-xlarge focused" id="title" name="title" type="text" value="<?php echo $company['Company']['title']; ?>" required>
                        </div>
                    </div>
                    <div class="control-group required">
                        <label class="control-label" for="primary_email">Primary Email </label>
                        <div class="controls">
                            <input class="input-xlarge" id="primary_email" name="primary_email" type="email" value="<?php echo $primary_email?>" readonly>
                        </div>

                    </div>
                    <div class="control-group">
                        <label class="control-label" for="alternative_email">Alternative Email</label>
                        <div class="controls">
                            <input class="input-xlarge" id="alternative_email" name="alternative_email" type="email" value="<?php echo $company['Company']['alternative_email']; ?>">
                        </div>
                    </div>
                    <div class="control-group required">
                        <label class="control-label" for="logo">Logo Upload </label>
                        <div class="controls">
                            <?php if($company['Company']['logo']):?>
                            <img class="thumbnail span3" src="<?php echo MEDIA_URL . '/files/company/icon/' . $company['Company']['logo']; ?>" />
                            <div class="clear"></div>
                            <?php endif;?>
                            <input type="file" name="logo" id="logo">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="image">Banner Upload</label>
                        <div class="controls">
                            <?php if($company['Company']['image']):?>
                            <img class="thumbnail span8" src="<?php echo MEDIA_URL . '/files/company/cover/' . $company['Company']['image']; ?>" />
                            <div class="clear"></div>
                            <?php endif;?>
                            <input type="file" name="image" id="image">
                        </div>
                    </div>

                    <div class="control-group required">
                        <label class="control-label" for="established">Established In </label>
                        <div class="controls">
                            <select id="established" name="established" required>
                                <option>select</option>
                                <?php for($i=1900; $i<=date('Y') ; $i++): ?>
                                <option value="<?php echo $i;?>" <?php echo ($company['Company']['established'] == $i)?'selected':''; ?> ><?php echo $i;?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="control-group required">
                        <label class="control-label" for="company_type_id">Employer Type </label>
                        <div class="controls">
                            <?php echo $this->Form->input('company_type_id', array('type' => 'select', 'options' => array('' => 'select', $company_type), 'selected' => $company['Company']['company_type_id'], 'id' => 'company_type_id', 'label' => false)); ?>
                        </div>
                    </div>

                    <div class="control-group required">
                        <label class="control-label" for="industry_id">Industry </label>
                        <div class="controls">
                            <?php echo $this->Form->input('industry_id', array('type' => 'select', 'options' => array('' => 'select', $industries), 'default' => $company['Company']['industry_id'], 'id' => 'industry_id', 'label' => false)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="description">Description </label>
                        <div class="controls">
                            <textarea id="description" name="description"><?php echo $company['Company']['description']; ?></textarea>
                        </div>
                    </div>
                    <div class="control-group required">
                        <label class="control-label" for="company_operating_status">Company Size </label>
                        <div class="controls">
                            <?php echo $this->Form->input('company_size', array('type' => 'select', 'options' => array('' => 'select','2-10' => '2-10', '11-50' => '11-50', '51-200' => '51-200', '200-500' => '200-500', '500-1000' => '500-1000', '1000' => '5000', '5000+' => '5000+'), 'selected' => $company['Company']['company_size'], 'id' => 'company_size', 'label' => false)); ?>
                        </div>
                    </div>

                    <div class="control-group required">
                        <label class="control-label" for="company_operating_status">Company Status </label>
                        <div class="controls">
                            <?php echo $this->Form->input('company_operating_status', array('type' => 'select', 'options' => array('' => 'select', '1' => 'Operating', '2' => 'Operating Subsidiary', '3' => 'Reorganizing', '4' => 'Out of Business', '5' => 'Acquired'), 'selected' => $company['Company']['company_operating_status'], 'id' => 'company_operating_status', 'label' => false)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="contact_name">Contact Person </label>
                        <div class="controls">
                            <input class="input-xlarge" id="contact_name" name="contact_name" type="text" value="<?php echo $company['Company']['contact_name']; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="designation">Designation </label>
                        <div class="controls">
                            <input class="input-xlarge" id="designation" name="designation" type="text" value="<?php echo $company['Company']['designation']; ?>">
                        </div>
                    </div>
                </fieldset>
                <fieldset  style="float:left;width:50%;">
                    <h3 class="title">Company Contact</h3>
                    <div class="control-group required">
                        <label class="control-label" for="address">Address </label>
                        <div class="controls">
                            <input class="input-xlarge" id="address" name="address" type="text" value="<?php echo $company['Company']['address']; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="address2">Address 2 </label>
                        <div class="controls">
                            <input class="input-xlarge" id="address2" name="address2" type="text" value="<?php echo $company['Company']['address2']; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="address3">Address 3 </label>
                        <div class="controls">
                            <input class="input-xlarge" id="address3" name="address3" type="text" value="<?php echo $company['Company']['address3']; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="fax1">Fax 1 </label>
                        <div class="controls">
                            <input class="input-xlarge" id="fax1" name="fax1" type="text" value="<?php echo $company['Company']['fax1']; ?>" placeholder="Example: +971 4 417 9610">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="fax2">Fax 2 </label>
                        <div class="controls">
                            <input class="input-xlarge" id="fax2" name="fax2" type="text" value="<?php echo $company['Company']['fax2']; ?>" placeholder="Example: +971 4 417 9610">
                        </div>
                    </div>
                    <div class="control-group required">
                        <label class="control-label" for="mobile">Mobile </label>
                        <div class="controls">
                            <input class="input-xlarge" id="mobile" name="mobile" type="text" value="<?php echo $company['Company']['mobile']; ?>" placeholder="Example: +971 4 417 9600">
                        </div>
                    </div>
                    <div class="control-group required">
                        <label class="control-label" for="country_id">Country </label>
                        <div class="controls">
                            <?php echo $this->Form->input('country_id', array('type' => 'select', 'options' => array('' => 'select', $countries), 'selected' => $company['Company']['country_id'], 'id' => 'country_id', 'label' => false)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="state">State </label>
                        <div class="controls">
                            <input class="input-xlarge" id="state" name="state" type="text" value="<?php echo $company['Company']['state']; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="city">City </label>
                        <div class="controls">
                            <input class="input-xlarge" id="city" name="city" type="text" value="<?php echo $company['Company']['city']; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="weburl">Web Site </label>
                        <div class="controls">
                            <input class="input-xlarge" id="weburl" name="weburl" type="text" value="<?php echo $company['Company']['weburl']; ?>" placeholder="http://www.networkwe.com/">
                        </div>
                    </div>
                    <div class="control-group hidden">
                        <label class="control-label" for="featured_display">Featured Employer? </label>
                        <div class="controls">
                            <input class="input-xlarge" id="featured_display" name="featured_display" type="checkbox" value="1" <?php if ($company['Company']['featured_display'] == 1) {
                                echo 'checked';
                            } ?>>
                        </div>
                    </div>
                    <div class="control-group hidden">
                        <label class="control-label" for="top_employer_display">Top Employer? </label>
                        <div class="controls">
                            <input class="input-xlarge" id="top_employer_display" name="top_employer_display" type="checkbox" value="1" <?php if ($company['Company']['top_employer_display'] == 1) {
                                echo 'checked';
                            } ?>>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $company['Company']['id']; ?>" id="id"/>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary" id="submit">Save</button>
                            <button type="reset" class="btn">Cancel</button>
                        </div>
                    </div>
                </fieldset>
                <div style="clear:both"></div>
            </form>
        </div>
    </div><!--/span-->

</div><!--/row-->
<div style="clear:both">&nbsp;</div>
<script type="text/javascript">
    $(function() {
        $.validator.setDefaults({
            errorClass: "help-block",
            errorElement: "span",
            ignore: ".ignored, .btn",
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
        
        $('input[type=text],input[type=email],input[type=file],,select,textarea').addClass('span8');

        $.validator.addMethod('phone', function(value) {
            var numbers = value.split(/\d/).length - 1;
            if (numbers)
                return (10 <= numbers && numbers <= 20 && value.match(/^(\+){0,1}(\d|\s|\(|\)){10,20}$/));
            else
                return true;
        }, 'Invalid Phone/Fax format');

        /*jQuery.validator.addMethod("alphanumeric", function(value, element) {
         return this.optional(element) || /^\w+$/i.test(value);
         }, "Letters, numbers, and underscores only please");*/

        /*jQuery.validator.addMethod("extension", function(value, element, param) {
         param = typeof param === "string" ? param.replace(/,/g, "|") : "png|jpe?g|gif";
         return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
         }, jQuery.validator.format("Unsupported file format."));*/

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
        
        $.validator.addMethod('validemail', function (emailAddress) {
            var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
            return pattern.test(emailAddress);
        },'Invalid email.');

        $('#companyAdd').validate({
            debug: false,
            errorClass: "help-block",
            errorElement: "span",
            rules: {
                title: {minlength: 2, maxlength: 50, required: true},
                primary_email: {required: true/*, email: true, maxlength: 50,
                    remote: {
                        url: "<?php echo NETWORKWE_URL ?>/recruiter/chkemail/",
                        type: "get",
                        async: true,
                        data: {
                            primary_email: function() {
                                return $('#primary_email').val();
                            }
                        }
                    }*/
                },
                alternative_email: {minlength: 2, maxlength: 50, validemail: true},
                mobile: {minlength: 2, maxlength: 50, required: true, phone: true},
                logo: {accept: "jpg|jpeg|gif|png", sizelimit: 2097152},
                image: {accept: "jpg|jpeg|gif|png", sizelimit: 2097152},
                fax1: {minlength: 2, maxlength: 50, phone: true},
                fax2: {minlength: 2, maxlength: 50, phone: true},
                weburl: {url: true},
                established: {required: true, digits: true}
            },
            messages: {
                primary_email: {
                    required: "Email required",
                    email: "Invalid email",
                    maxlength: "Max 50"/*,
                    remote: "Domain already exists, Please use a different one."*/
                }
            }
        });
        
        /*$('#logo').change(function(){
            var path = $('#logo').val();
            $('#logo').closest("div").children("img").attr("src",path);
        });*/

    });
</script>