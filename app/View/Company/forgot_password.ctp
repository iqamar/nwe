<style type="text/css">
.contact-form { width: 500px!important; }
.maps { height: 500px; width: 400px; }
html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
.ttle-abt { margin: 15px 0 15px 15px; }
.contact-form ul li { list-style: none!important;}

.flash {
    color: #333333;
    margin: 10px 0 5px;
    padding: 10px;
}
.flash_failure{
 background: none repeat scroll 0 0 #FBE6F2;
    border: 1px solid #D893A1;
}
.flash_success{
 background: none repeat scroll 0 0 #DEFADE;
    border: 1px solid #267726;
}
.error{color:#CE1B18;font-size:12px;}
.flash_warning {
 color: #9F6000;
 background-color: #FEEFB3;
 border: 1px solid #D893A1;
}

</style>
<div class="pages">
<!--    <div class="ttle-bar">Contact us</div>-->
    <h1 class="ttle-abt">Find your account</h1>
    <div class="fl contact-form">
        <?php //echo $this->Session->flash(); ?>
        <div class="ttle-abt" style="font-size:13px;">Please enter your email address to get password.</div>
        <?php //echo $this->Form->create(null, array('controller'=>'Company','action'=>'contactus','id'=>'myform','name'=>'myform')); ?>
        <?php echo $this->Form->create('User', array('url' => '/users/forgot_password/','name'=>'myform','id'=>'forgot_form')); ?>
        <ul>
   
            <li class="clr"></li>
            <li class="txt">
                <label><?php echo __('Enter your email address')?></label>
            </li>
            <li class="textfield">
                 <?php echo $this->Form->email('email', array('required'=>true,'type' => 'email', 'class' => 'req no-bder no-bg','id' => 'email')); ?>
            </li>
            <li class="clr"></li>
            <li>
            <?php echo $this->Form->submit('Submit',array('class'=>'intbtn-srch boxsize topmrg','style'=>'width:100px;')); ?>
            </li>
            <li class="clr"></li>
        </ul>
       <?php echo $this->Form->end(); ?>
    </div>

    <br class="clr"/><br/>
</div>