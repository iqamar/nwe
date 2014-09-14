<!--<script src="/js/jquery-1.9.1.js"></script>
<script src="/js/jquery.validate.min.js"></script>-->
<?php
echo $this->Html->script('jquery-1.9.1.js');
echo $this->Html->script('jquery.validate.min.js');
?>
<script type="text/javascript">
/**
  * Basic jQuery Validation Form Demo Code
  * Copyright Sam Deering 2012
  * Licence: http://www.jquery4u.com/license/
  */
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#frmFeedback").validate({
                rules: {
                    firstname: "required",
                    lastname: "required",
                    description: "required",
                    subject: "required",
                    email: {
                        required: true,
                        email: true
                    }
                    
                },
                messages: {
                    firstname: "Please enter your firstname",
                    lastname: "Please enter your lastname",
                    email: "Please enter a valid email address",
                    subject: "Please enter the feedback subject",
                    description: "Please enter feedback description"
                    
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);
</script>


<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
            
	    <h2><i class="icon-edit"></i>Feedback</h2>
	    
	</div>


	<div class="box-content"><br/>
            <form class="form-horizontal" id="frmFeedback" name="form" enctype="multipart/form-data" action="#" method="post">
		<fieldset>


<?php 
echo $this->Session->flash();
?>

		    <div class="control-group">
			<label class="control-label" for="firstname">Firstname</label>
			<div class="controls">
			    <input class="input-xlarge focused" id="firstname" name="firstname" type="text" value="">
			</div>
		    </div>
                    
                    <div class="control-group">
			<label class="control-label" for="lastname">Lastname</label>
			<div class="controls">
			    <input class="input-xlarge focused" id="lastname" name="lastname" type="text" value="">
			</div>
		    </div>
                    
                    <div class="control-group">
			<label class="control-label" for="email">Email</label>
			<div class="controls">
			    <input class="input-xlarge focused" id="email" name="email" type="text" value="">
			</div>
		    </div>
                    
                    <div class="control-group">
			<label class="control-label" for="subject">Subject</label>
			<div class="controls">
			    <input class="input-xlarge focused" id="subject" name="subject" type="text" value="">
			</div>
		    </div>
                    
            

		    <div class="control-group">
			<label class="control-label" for="description">Description</label>
			<div class="controls">
			    <textarea class="cleditor" id="description" name="description" rows="3"></textarea>
			</div>
		    </div>
		   

		    <div class="control-group">
			<div class="controls">
                            <button type="submit" class="btn btn-primary" id="save">Save</button>
			    <button type="reset" class="btn">Cancel</button>
			</div>
		    </div>

		</fieldset>
	    </form>
	</div>


    </div>
</div>





