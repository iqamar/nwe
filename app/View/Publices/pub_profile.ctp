<script>
function showInfo(div) {
$("#"+div).slideToggle('slow');
}
function checkValidate() {

var userid = document.getElementById('user_id').value;
var friendid = document.getElementById('friend_id').value;
if (friendid == userid)
alert("you cant sent reques to itself");
return false;
}
function closeMessage() {
	$("#hideMessage").slideUp('slow');
}
</script>
<?php if ($this->Session->read(@$userid)) {$uidd = $this->Session->read(@$userid); $uid = $uidd['userid'];}?>

		<div class="dialog-title" id="hideMessage">
        <button onclick="closeMessage();" class="dialog-close"></button>
        <h3 class="title" style="font-weight:bold;"><?php echo __('Your message has been sent.');?> </h3>
        </div>
	
	<div class="prof-div">
    	<div class="profmain-div">


<div class="profi-div">
<div class="profcolm">

</div>
<div class="sub-pro-txt">
<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
</div>
</div>
</div>
    </div>

<div class="col-pan-div">
			<div class="main-coldiv">
				<a class="opn-col-btn">
					<span style="padding:10px;" class="effectX">Contact information</span></a>
<!--            	<a class="opn-col-btn">Contact information</a>-->
                <div class="col-bot-div cnct-info">
                	<ul>
                    
                    	<li> <span>Email</span><a href="#"><?php echo "farmi799@gmail.com";?></a></li>
                        <li> <span>Mobile</span><?php echo "055-6991805";?></li>
                        
                    </ul>
                </div>
            </div>
</div>
	<div class="col-pan-div">
			<div class="main-coldiv">
				<a class="opn-col-btn">
					<span style="padding:10px;" class="effectX">Summary</span></a>
<!--            	<a class="opn-col-btn">Contact information</a>-->
                <div class="col-bot-div cnct-info">
                	<div class="sub-pro-txt">
					
					</div>
                </div>
            </div>
	</div>
    <div class="col-pan-div">
        	<div class="main-coldiv">
        		<a class="opn-col-btn"><span style="padding:10px;" class="effectX">Experience</span></a>
                
        		<div class="expi-main-div">
       			  <div class="expi-div" style="border-bottom:none;">
        			<div class="expi-colm">
        				<div class="expi-txt">
                       
       				 </div>
       			 </div>
       		 </div>
        <div class="expi-pht"><img src="<?php echo $this->base;?>/img/no-image.png" width="60" height="60" alt="no image" style="border-radius:5px;" /></div>  
      </div>
     
    </div>
  </div>

<div class="col-pan-div">
                    <div class="main-coldiv">
                        <a class="opn-col-btn"><span style="padding:10px;" class="effectX">Education</span></a>
                        
                            
                            	
       				 </div>
       			 </div>
       		 </div>
                                <
                           
                       
                      
                    </div>
        </div>

 <div class="col-pan-div">
                    <div class="main-coldiv">
                        <a class="opn-col-btn"><span style="padding:10px;" class="effectX">Skills & Experties</span></a>
                         <div class="col-bot-div cnct-info">
                       
				
                        </div>
              		</div>
                </div>

<div class="col-pan-div">
                    <div class="main-coldiv">
                        <a class="opn-col-btn"><span style="padding:10px;" class="effectX">Connections</span></a>
                        <div class="col-bot-div cone-info">
                            
                        </div>
                        
                    </div>
        </div>