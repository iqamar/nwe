<?php if ($companyByCountryResult) {
		foreach ($companyByCountryResult as $company) { 
		$companyID = $company['companies']['id'];?>
<div class="con_div" style="width:48.5%; float:left; margin-right:10px; padding:7px; border:1px solid #BFBFBF; margin-bottom:5px;">
<?php if (!empty($company['companies']['logo'])) {?>
<img src="<?php echo $this->base;?>/files/companies_logo/<?php echo $company['companies']['logo'];?>" width="100" height="100" alt="no image" style="padding:5px 5px 5px 5px; float:left;" />
<?php } else {?>
<img src="<?php echo $this->base;?>/img/no-image.png" width="100" height="100" alt="no image" style="padding-right:10px; float:left;" />
<?php }?>
<div class="user-description" style="float:left; padding-left:5px; width:72%; min-height:100px;">
<div style="height:90px; width:100%;">
<strong style="color:#006AD5; font-size:14px; font-weight:bold;"><?php echo $company['companies']['title'];?></strong>
<p style="font-size:11px; color:#404040;"><?php echo $company['companies']['address']." , ".$company['countries']['name'];?></p>
<p style="font-size:11px; color:#404040;"><?php echo $company['companies']['weburl'];?></p>
	</div>
<div style="float:right; display:block;"class="savebtn" id="follow_<?php echo $companyID;?>"><a onclick="return followingTheCompany('<?php echo $companyID?>','1')" style="color:#fff; cursor:pointer;">Follow</a></div>
<div style="float:right; display:none;"class="savebtn" id="following_<?php echo $companyID;?>"><a href="/companies/view" style="color:#fff;">View</a>
</div>
		</div>

			</div>
<?php }}?>
