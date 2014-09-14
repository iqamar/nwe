<div style="height:auto; width:100%;">
	<div style="width:100%; height:35px; margin-bottom:6px;">
		<div class="con_div" style="width:98.2%; float:left; margin-right:10px; padding:10px 38px; border:1px solid #BFBFBF; margin-bottom:5px; background:#fff;">
        <?php echo $this->Html->Image('/files/users/'.$imgname,array('style'=>'width:90px; height:90px; float:left; margin-right:10px;'));?>
        <h2 style="font-size:17px; margin-left:10px; font-weight:bold;">Who send you congrates on your new job.</h2>
        </div>
       </div>
	<div style="clear:both; width:100%; height:auto;" id="result">
    	<div id="search_result">
		<?php 
        if ($whoSendYouCongrats) {
        foreach ($whoSendYouCongrats as $congrate_Row) { 
        $congrateID = $congrate_Row['users_messages']['id'];
		$fullname = $congrate_Row['users_profiles']['firstname']." ".$congrate_Row['users_profiles']['lastname'];
		$user_id = $congrate_Row['users_profiles']['user_id']
		?>
        <div class="con_div" style="width:98.2%; float:left; margin-right:10px; padding:10px 38px; border:1px solid #BFBFBF; margin-bottom:5px; background:#fff;">
        <?php if (!empty($congrate_Row['users_profiles']['photo'])) {
        echo $this->Html->image('/files/users/'.$congrate_Row['users_profiles']['photo'],array('style'=>'padding:5px; float:left; width:75px; height:75px;','alt'=>'no-img'));
        }
        else {
		echo $this->Html->image('user-icon.png',array('style'=>'padding:5px; float:left; width:75px; height:75px;','alt'=>'no-img'));
		}?>
		<div class="user-description" style="float:left; padding-left:22px; width:85%; min-height:100px;">
			<div style="height:75px; width:100%;">
				<strong style="color:#006AD5; font-size:14px; font-weight:bold;">
                <?php echo $this->Html->link($fullname,array('controller'=>'connections','action'=>'index',$user_id),
																				  array('style'=>'text-decoration:none; color:#006AD5;'));?>
                </strong>
                <p style="font-size:12px; color:#404040;"><?php echo $congrate_Row['users_profiles']['tags'];?></p>
				<?php if ($congrate_Row['users_messages']['user_message']) {?>
				<p style="font-size:12px; color:#404040;"><?php echo $congrate_Row['users_messages']['user_message'];?></p>
				<?php }?>
                <p>
            <a href="Javascript:replyToCongrate('<?php echo $congrateID ?>')" class="savebtn" style="color:#0073E6; font-size:13px; text-decoration:none; float:right;">Reply</a>
                </p>
               
			</div>
    		<input type="hidden" name="start_date" id="start_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
    		<input type="hidden" name="end_date" id="end_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
		</div>
	</div>
	<?php }}?>
    </div>
</div>
</div>
<script type="text/javascript">
function replyToCongrate(congrate_id) {
	//alert(companyid+follow);
	//$("#follow_"+companyid).css('display','none');
	//$("#following_"+companyid).css('display','block');
	var start_date = document.getElementById('start_date').value;
	var end_date = document.getElementById('end_date').value;
	$.ajax({
              url     : baseUrl+"/companies/follow_company",
              type    : "GET",
              cache   : false,
              data    : {companyid: companyid,user_id:user_id,start_date:start_date,end_date:end_date,status:status,user_following_id:user_following_id},
              success : function(data){
			 $("#follow_"+companyid).css('display','none');
			 $("#following_"+companyid).css('display','block');	
			  $("#span_"+companyid).html(data);
              },
			  error : function(data) {
           $("#span_"+companyid).html("error in request");
        }
          });
			
}
function removeFollowingTheCompany(status,user_following_id) {
	//alert(companyid+follow);
	var end_date = document.getElementById('end_date').value;
	$.ajax({
              url     : baseUrl+"/companies/follow_company",
              type    : "GET",
              cache   : false,
              data    : {end_date:end_date,status:status,user_following_id:user_following_id},
              success : function(data){
			 location.href = "/companies/search/"
              },
			  error : function(data) {
           $("#span_"+companyid).html("error in request");
        }
          });
			
}
function showCompanies() {
//$('#edit_Recs').show();

var company_title = document.getElementById('company_title').value;
$.ajax({
              url     : baseUrl+"/companies/search_companies",
              type    : "GET",
              cache   : false,
              data    : {company_title: company_title},
              success : function(data){
			  $("#result").html(data);
              },
			  error : function(data) {
           $("#result").html("there is error");
        }
          });
		  
}
</script>