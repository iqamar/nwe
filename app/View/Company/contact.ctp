<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<?php
$options = array(
    '0' => 'General inquiries',
    '1' => 'Technical issues',
    '2' => 'Sales and advertising'
);
?>
<script type="text/javascript">
    function validateForm() {
        var fullname = document.getElementById('fullname').value;
        var email = document.getElementById('email').value;
        var message = document.getElementById('message').value;
        if (fullname == '') {
            $("#span_fullname").html("Enter your name");
            $("#fullname").focus();
            return false;
        }
        else if (email == '') {
            $("#span_email").html("Enter your email");
            $("#email").focus();
            return false;
        }
        else if (message == '') {
            $("#span_message").html("Enter enter something to me..");
            $("#message").focus();
            return false;
        }
        else {
            return true;
        }
    }
</script>
<style type="text/css">
    .maps { height: 350px; width: 600px; }
    html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
    }
</style>
<div class="maincontent">
    <div class="boxheading">
        <h1>Let's keep in touch</h1>
        <div class="boxheading-arrow"></div>
    </div>
    
    <div class="post-wall">
        <div class="contactlft">
            <?php echo $this->Form->create(null, array('url' => '/companies/contact/', 'name' => 'myform', 'id' => 'myform', 'class' => 'formstyle', 'onsubmit' => 'return validateForm();')); ?>
                <fieldset>
                    <label for="">Enquiry <span class="redcolor">*</span></label>
                    <label1><?php echo $this->Form->input($option_id, array('options' => $options, 'id' => 'department', 'name' => 'department', 'label' => FALSE, 'div' => FALSE, 'class' => 'droplist', 'default' => '0')); ?></label1>
                    <label for="">Full Name <span class="redcolor">*</span></label>
                    <label1><input name="fullname" type="text" required/></label1>
                    <label for="">Email <span class="redcolor">*</span></label>
                    <label1><input type="text" name="email" required /></label1>
                    <label for="">Subject <span class="redcolor">*</span></label>
                    <label1>
                        <input name="subject" type="text" required/>
                    </label1>
                    <label>Message</label>
                    <label1>
                        <textarea name="" cols="" rows=""></textarea>
                    </label1>
                    <div class="clear">
                        <label1>
                            <?php echo $this->Form->submit('Send', array('class' => '','div' => FALSE)); ?>
                            <input name="" type="reset" value="Cancel" />
                        </label1>
                    </div>
                </fieldset>
            <?php echo $this->Form->end(); ?>
			<div class="clear"></div>
			<div class="margintop15">
                	<div class="office_locations">
						<div class="heading">
                        <h2>Head Office</h2>
                        </div>
						 Suite 403, Jumeirah Bay, Tower X2 Jumeirah Lakes Towers,
						  <br />
						  Sh. Zayed Road, Dubai, UAE <br />
						  <strong>Tel:</strong> +971 4 4179600 <strong>Fax:</strong> +971 4 4179610 <br />
						  <strong>P.O.Box</strong> 31372, Dubai, UAE <br />
						  <strong>eMail:</strong> <a href="mailto:info@networkwe.com">info@NetworkWE.com</a><br />
               	  </div>
                <div class="office_locations">
						<div class="heading">
                        <h2>Egypt</h2>
                        </div>
                        45 Mosadek Street, Dokki,
                        6th floor, EFG Hermes Building,
                        Cairo, Egypt
                        <br />
                  <strong>Tel</strong>: +202 3 336 9661<strong> Fax:</strong> +202 3 336 9622 </div>
                <div class="office_locations">
						<div class="heading">
                        <h2>Bahrain</h2>      
                        </div>             
                        73 Al Rossais Tower - Diplomatic Area, Manama, Bahrain
                        <br />
                  <strong>Tel:</strong> +973 17 535396<strong> Fax:</strong> +973 17 536676<br />
                  <strong>P.O.Box</strong> 5043 </div>
                </div>
        </div>
		<div class="clear">&nbsp;</div>
        <div class="contactrgt">
            <div class="marginbottom15">
                <h1>Find us on Google Map</h1>
            </div>
    <div class="fr maps">
        <div id="map-canvas">
            <script type="text/javascript">
                //<![CDATA[
                var locations = [
                    ['Office Location', 25.080624, 55.153136, 1]
                ];

                var map = new google.maps.Map(document.getElementById('map-canvas'), {
                    zoom: 12,
                    center: new google.maps.LatLng(25.080624, 55.153136),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                var infowindow = new google.maps.InfoWindow();

                var marker, i;

                for (i = 0; i < locations.length; i++) {
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map
                    });

                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            infowindow.setContent(locations[i][0]);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                }
                //]]>
            </script>
        </div>
    </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>
