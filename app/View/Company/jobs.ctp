<div class="tab-container" id="tab-container" data-easytabs="true">
	<ul class="etabs">
		<li class="tab active"><a href="#" class="active">Company Page</a></li>
		<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/">Following</a></li>
		<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/search/">Search Company</a></li>
		<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/home/">Companies Updates</a></li>
		<li class="tab"><a href="<?php echo NETWORKWE_URL;?>/companies/validity/">Add Company</a></li>
	</ul>
	<div class="panel-container">
		<div id="tabs1" style="display: block;" class="active"> 
			<?php 
			//echo "<pre>";
			//print_r($companyDetail);
				if ($companyDetail) {
				$companyID = $companyDetail['companies']['id'];
				$companytitle = strtolower($companyDetail['companies']['title']);
				$companytitle = str_replace(' ', '-', $companytitle);
				$company_user = $companyDetail['companies']['user_id'];
			?>
			<!--- company header start -->
			<div>
				<div class="com-rgt">
					<div class="companypage-logo">
					<?php
						if(!empty($companyDetail['companies']['logo'])){
							$file = MEDIA_URL.'/files/company/logo/'.$companyDetail['companies']['logo'];
							$file_headers = @get_headers($file);
							if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
								echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array());
							}else {
								echo $this->Html->image($file,array());
							}
						}else{
							echo $this->Html->image(MEDIA_URL.'/img/nologo.jpg',array());
						}
					?>		
					</div> 
					<div class="button-in-middle">
					
						<span id="company_follow_by_user">
							<?php 
								if ($users_following_thisCompany !=0){
									if ($status == 2) {?>
									<a class="button" href="javascript:unfollow('<?php echo $user_company_id ?>','<?php echo $uid?>','0','<?php echo $companyID?>')">Following</a> 
									<?php } else {?>
										<a class="button" href="javascript:unfollow('<?php echo $user_company_id ?>','<?php echo $uid?>','2','<?php echo $companyID?>')">Follow</a>
									<?php }} else {?>
										<a class="button" href="javascript:unfollow('<?php echo $user_company_id ?>','<?php echo $uid?>','2','<?php echo $companyID?>')">Follow</a>
							<?php }?>
						</span>
						<div class="clear"></div>
					</div>
					<div class="totalfollowers">
							<span id="total_following"><?php  echo $count_following_thisCompany;?> </span> followers </span>						
							
					</div>
					<div class="clear"></div>
				</div>
			 
				<div class="com-lft">
					<div class="com-left-details">
						<ul>
							<li>
								<h1><?php echo $companyDetail['companies']['title'];?></h1>
							</li>
							<li><?php echo $companyDetail['companies']['city']; if ($companyDetail['countries']['name'] && $companyDetail['companies']['city']) { echo ", ";} 
								echo $companyDetail['countries']['name']; ?>
                           </li>
							<li>									
								<a target="_blank" href="<?php echo $companyDetail['companies']['weburl'];?>"><?php echo $companyDetail['companies']['weburl'];?></a>
							</li>
							<li>
								<strong>Industry:</strong> <?php echo $companyDetail['industries']['title'];?>
							</li>
							<li>
								<strong>Founded:</strong> <?php echo $companyDetail['companies']['established'];?> | <strong>Company size:</strong> <?php echo $companyDetail['companies']['company_size'];?> | <strong>Type:</strong> <?php echo $companyDetail['companies_types']['title'];?>
							</li>
                            <li>
								<strong>Public URL:</strong> <?php echo $this->Html->link(NETWORKWE_URL.'/company/page/'.$companyID,NETWORKWE_URL.'/company/page/'.$companyID,array('escape'=>false)); ?>
							</li>
                            <li><strong>Company Page Admin:</strong>
								<?php echo '<a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$company_user.'">'.$admin_info['users_profiles']['firstname']." ".$admin_info['users_profiles']['lastname'].'</a>';?>
                                </li>
						</ul> 
					</div>
					<div class="companypage-nav">
                    	
						<?php echo '<a  href="'.NETWORKWE_URL.'/companies/view/'.$companyID.'/'.$companytitle.'">Home</a>';?>
						<?php echo '<a class="selected"  href="'.NETWORKWE_URL.'/companies/jobs/'.$companyID.'/'.$companytitle.'">Jobs</a>';?>
                        <?php echo '<a  href="'.NETWORKWE_URL.'/companies/followers/'.$companyID.'/'.$companytitle.'">Followers</a>';?>
                        <?php if ($company_user == $uid) {?>
						<?php echo '<a href="'.NETWORKWE_URL.'/companies/add/'.$companyID.'/'.$companytitle.'">Edit Page</a>';?>
                        <?php echo '<a href="'.NETWORKWE_URL.'/companies/delete/'.$companyID.'/'.$companytitle.'">Delete Page</a>';?>
						<?php }?>
						<div class="clear"></div>    
					</div>   
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			<!--- company header end -->
			
			
<?php
	echo $this->Html->script(array(MEDIA_URL.'/js/paging.js'));
?>	
<style type="text/css">    
.pg-normal {
	
	cursor: pointer;    
}
            
</style>		
			<div class="companypage-mainbox">
			<div class="boxheading">
				<h1>Jobs &nbsp;<span class="searchbox-total">(<?php echo count($data); ?>)</span></h1>
				<div class="boxheading-arrow"></div>
			</div>
			<table id="results">
				<?php 
					
					
					$i=0;
					foreach($data as $row){
						$postdate = date("F j, Y", strtotime($row['Job']['modified']));
						if($row['Company']['logo']){
							if (file_exists(MEDIA_PATH.'/files/company/icon/'.$row['Company']['logo'])) {
								$company_logo='/files/company/icon/'.$row['Company']['logo'];
							}
							else {
								$company_logo='/img/nologo.jpg';
							}
						}else{
								$company_logo='/img/nologo.jpg';
						}
					
						$listing ="<tr><td><div class='joblisting'>";
						$listing.="<div class='job-com-logo'>".$this->Html->link($this->Html->Image(MEDIA_URL.$company_logo,array()),JOBS_URL.'/search/jobDetails/'.$row['Job']['id'],array('escape'=>false))."</div>";
						$listing.="<ul style='width:550px'><li><h1>".$this->Html->link($row['Job']['title'],JOBS_URL.'/search/jobDetails/'.$row['Job']['id'],array('escape'=>false))."</h1></li>";
						$listing.="<li>Location: <span class='location'>".$row['Job']['city'].",&nbsp;".$row['Country']['name']."</span></li>";
						$listing.="<li><span class='postedon'>Posted On: ".$postdate."</span>";
						$listing.="<div class='listing-bttns'>";
						
						
						$listing.=$this->Html->link('Apply for Job',JOBS_URL.'/search/jobDetails/'.$row['Job']['id'],array('escape'=>false,'class'=>'apply-bttn'));
						$listing.="</div></li></ul><div class='clear'></div></div></td></tr>";
						
						echo $listing;
					}
				?>
				</table>
				<div class="clear"></div>
				
					<div id="pageNavPosition" class="paging"></div>
				
			</div>          
		
			
			 

	<?php }?>
		<div class="clear">&nbsp;</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
        var pager = new Pager('results', 10); 
        pager.init(); 
        pager.showPageNav('pager', 'pageNavPosition'); 
        pager.showPage(1);
    //--></script>
<script type="text/javascript">

		function showLikes(commentid,like){
		var user_id = document.getElementById('user_id').value;
		var content_type = document.getElementById('content_type').value;
		var content_id = document.getElementById('content_id_'+commentid).value;
		var created = document.getElementById('content_date_'+commentid).value;
		var id = document.getElementById('id_'+commentid).value;
		
		$.ajax({
		url     : baseUrl+"/comments/add_like",
		type    : "GET",
		cache   : false,
		data    : {user_id: user_id,content_type:content_type,content_id:content_id,created:created,like:like,id:id},
		success : function(data){	
		//$(this).css('background','none');
		//$("#alike"+commentid).css('display','none');
		//$("#likediv"+commentid).css('display','block');
		$("#user_like_update_"+commentid).html(data);
		},
		error : function(data) {
		$("#user_like_update_"+commentid).html("there is error");
		}
		});
		}
		
		function saveComment(commentid){
		var user_id = document.getElementById('user_id').value;
		var content_id = document.getElementById('content_id_'+commentid).value;
		var comment_text = document.getElementById('comment_text_'+commentid).value;
			if(comment_text !=''){
			
				$.ajax({
				url     : baseUrl+"/companies/add_comments",
				type    : "POST",
				cache   : false,
				data    : {user_id: user_id,content_id:content_id,comments:comment_text},
				success : function(data){
					//if (share == 1) {
				$("#commentDiv_"+commentid).html(data);
				//$("#comments_"+commentid).slideUp('slow');
				//$("ul li.content_"+commentid).css({'height':'124px'});
					//}
				},
				error : function(data) {
				$("#commentDiv_"+commentid).html(data);
				}
				});
			}else{
				alert('Text field is empty!');
				
			}
		}


function unfollow(user_follow_id,user_id,status,company_id) {
	$("#company_follow_by_user").html('<img src="http://media.networkwe.net/img/loading.gif" />');
	$.ajax({
	url     : baseUrl+"/companies/follow_page",
	type    : "POST",
	cache   : false,
	data    : {status:status,user_id:user_id,company_id:company_id,user_follow_id:user_follow_id},
	success : function(data){	
	//$(this).css('background','none');
	responseArray = data.split("::::");
	$("#total_following").html(responseArray[0]);
	$("#company_follow_by_user").html(responseArray[1]);
	},
	error : function(data) {
	$("#company_follow_by_user").html("error");
	}
	});
	
}

function showShare() {
document.getElementById('status_share_options').style.display='block';
return true;
}



function countChar(val,commentid) {
        var len = val.value.length;
        if (len > 75) {
          val.value = val.value.substring(0, 75);
		  document.getElementById('comment_text_'+commentid).disabled = true;
        } else {
          $('#comment_count_'+commentid).text(75 - len+' characters');
        }
      }
function expandComment(id) {
$('#comment_text_'+id).css({
            'height' : '80px'
        });
}
</script>