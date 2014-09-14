<script>
$( document ).ready(function() {
  $("#success_mesg_hide").slideDown('slow').delay(300).fadeOut();
});
</script>
<?php $paginator = $this->Paginator;?>
<div class="box">
	<div class="tab-container" id="tab-container" data-easytabs="true">
		<ul class="etabs">
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/page/" >Company Page</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/">Following</a></li>
			<li class="tab active"><a href="#" class="active">Search Company</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/home/">Companies Updates</a></li>
			<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/validity/">Add Company</a></li>
		</ul>
		<div class="panel-container">
			<div id="tabs1" style="display: block;" class="active"> 
                <div class="connection-search">
                                <form action="" method="post">
                                    <fieldset>
                                        <label>
                                          <input name="company_title" type="text"  class="textfield width2"  onfocus="if(this.value=='Search Companies') this.value='';" onblur="if(this.value=='') this.value='Search Companies';" value="Search Companies" id="company_title" onkeypress="showCompanies();" />
                                        </label>
                                        <label>
                                            <input type="button" class="submitbttn" onclick="showCompanies();" value="Search" />
                                        </label>
                                    </fieldset>
                                </form>
                    </div>
              <?php echo $this->Session->flash();?> 
              <div id="serach_output"> 	
		<?php 
        if ($companyListing) {
			foreach ($companyListing as $company) { 
				$companyID = $company['Company']['id'];
				$users_following_id = $company['users_followings']['id'];
				$companytitle = strtolower($company['Company']['title']);
				$companytitle = str_replace(' ', '-', $companytitle);
				$company_owner = $company['Company']['user_id'];
				
				
		?>
		
				<div class="connection-listing">
						<div class="connection">							
							<?php
							echo '<a href="'.NETWORKWE_URL.'/companies/view/'.$companyID.'/'.$companytitle.'">';	
							if(!empty($company['Company']['logo'])){
								$file = MEDIA_URL.'/files/company/icon/'.$company['Company']['logo'];
								$file_headers = @get_headers($file);
								if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
									echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array());
								}else {
									echo $this->Html->image(MEDIA_URL.'/files/company/icon/'.$company['Company']['logo'],array());
								}
							}else{
								echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array());
							}

							 echo "</a>";
							?>
						</div>
						<div class="connection-listing-rgt">
							<ul>
								<li>
								  <h1>
								   <?php echo $this->Html->link($company['Company']['title'],array('controller'=>'companies','action'=>'view',$companyID,$companytitle));?>
								  </h1>
								</li>
								<li>
									<?php echo $company['industries']['title'];?><br/>
									<?php echo $company['countries']['name']." ".$company['Company']['city'];
										if ($company['Company']['address']) { " , ".$company['Company']['address']; }?><br/>
									<a href="<?php echo $company['Company']['weburl'];?>"><?php echo $company['Company']['weburl'];?></a>
								</li>
								<li>
								
								 <?php foreach ($companies_followed_by_user as $row_Company) {
					$users_following_id = $row_Company['users_followings']['id'];
					$users_f_id = $row_Company['users_followings']['following_id'];
					?>
                <?php 
				if ($users_f_id == $companyID) {
				if ($row_Company['users_followings']['status']==2 && $row_Company['users_followings']['user_id']==$uid) {?>
                <p>
            <!--<a href="Javascript:removeFollowingTheCompany('0','<?php //echo $users_following_id ?>')"style="color:#0073E6; font-size:13px; text-decoration:none;">Following</a>-->
                </p>
                <?php }}}?>
              
              
              <?php if ($company_owner != $uid) {?>  
              <div id="span_<?php echo $companyID?>">
           		 <?php $flag = false;             
					foreach ($loggeduers_following_companies as $logged_user_company) {
							$my_following_id = $logged_user_company['users_followings']['following_id'];
							$my_user_follow_id = $logged_user_company['users_followings']['id'];
							if ($companyID == $my_following_id) {
							?>
            				<?php if ($logged_user_company['users_followings']['status']== 0 && $logged_user_company['users_followings']['user_id']==$uid) {?>
									<div style="float:right; display:block;" id="follow_<?php echo $companyID;?>">
            			<a href="Javascript:followingTheCompany('<?php echo $companyID?>','<?php echo $uid?>','2','<?php echo $my_user_follow_id ?>')" class="button">Follow</a>
            						</div>
									<?php  $flag = true; break;
									}?>
            				<?php if ($logged_user_company['users_followings']['status']==2 && $logged_user_company['users_followings']['user_id']==$uid) { ?>
							<div style="float:right; display:block;">
            	 			<?php echo $this->Html->link('View',array('controller'=>'companies','action'=>'view',$companyID,$companytitle),
																				  array('class'=>'button'));?>
							</div>
            				<?php $flag = true; break; }?>
            		<?php }
						}
					?>
                    
            		<?php if ($flag == false) { ?>
							<div style="float:right; display:block;" id="follow_<?php echo $companyID;?>">
            					<a href="Javascript:followingTheCompany('<?php echo $companyID?>','<?php echo $uid?>','2','')" class="button">Follow</a>
            				</div>
						<?php }?>

           	 </div>
				<?php }?>				  
          </li>
		</ul>
	</div>
	<div class="clear"></div>
	</div>   
		
	<?php }}?>
	  </div>
      <div class="clear"></div>				
	</div>
    <?php // pagination section Start
			echo "<div class='paging' style='float:right;'>";
		 
				// the 'first' page button
				echo $paginator->first("First");
				 
				// 'prev' page button, 
				// we can check using the paginator hasPrev() method if there's a previous page
				// save with the 'next' page button
				if($paginator->hasPrev()){
					echo $paginator->prev("Prev");
				}
				 
				// the 'number' page buttons
				//echo $paginator->numbers(array('modulus' => 1));
				echo $paginator->numbers();
				 
				// for the 'next' button
				if($paginator->hasNext()){
					echo $paginator->next("Next");
				}
				 
				// the 'last' page button
				echo $paginator->last("Last");
			 
			echo "</div>";
			// pagination section End
			?>
				<div class="clear"></div>		
   </div>
 </div>
</div>



     <input type="hidden" name="start_date" id="start_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
    <input type="hidden" name="end_date" id="end_date" value="<?php echo $date = date("Y-m-d h:i:s");?>" />
    		
<script type="text/javascript">

function followingTheCompany(companyid,user_id,status,user_following_id) {
	//alert(companyid+follow);
	//$("#follow_"+companyid).css('display','none');
	//$("#following_"+companyid).css('display','block');
	$("#span_"+companyid).html('<img src="http://media.networkwe.com/img/loading.gif" style="float:right;" />');
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
			  $("#serach_output").html(data);
              },
			  error : function(data) {
           $("#serach_output").html("there is error");
        }
          });
		  
}
</script>
