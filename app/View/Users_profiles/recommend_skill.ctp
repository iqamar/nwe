<?php 
$total_recmmed = sizeof($uers_RecommendedListing);
$strstr ="";

if ($recommendations == 0){
		$strstr .='<span class="recommend" id="userRecommend'. $skillid.'" style="cursor:pointer; display:block;" onclick="removeSkill(\''.$skillid.'\',\'1\',\''.$recommend_idd.'\');">'.
                                        '<a href="javascript:" class="recommendationlink">Recommend</a>'.
                                   '</span>';								   
 } else {	 
	 
	 $strstr .='<span class="recommend" id="recommendedss'.$skillid.'" style="cursor:pointer; display:block;" onclick="removeSkill(\''.$skillid.'\',\'0\',\''.$recommend_idd.'\');">'.
                                        '<a href="javascript:" class="recommended-link">Recommended</a>'.
                                   '</span>';
								   
 }
  
$strstr .="<ul class=\"skill-experties-right\">".
			"<ul class=\"skillspeople-pic\">";
			 if (sizeof($uers_RecommendedListing) !=0) {
				$strstr .="<li><a href='#?' rel='skillbox".$skillid."' onClick='loadPopup(".$skillid.",".$useridd.");' class='poplight see-skill-people'></a></li>";
	}
 foreach ($uers_RecommendedListing as $ajaxUserShow) {
	 	if ($ajaxUserShow['users_profiles']['photo']) {
	 $strstr .="<li>".$this->Html->image(MEDIA_URL.'/files/user/icon/'.$ajaxUserShow['users_profiles']['photo'], array('alt'=>'recommend','style'=>'width:30px; height:27px;'))."</li>";
		}
		else {
	$strstr .="<li>".$this->Html->image(MEDIA_URL.'/img/nophoto.jpg/', array('alt'=>'recommend','style'=>'width:30px; height:27px;'))."</li>";
		}
 }
	  $strstr .="</ul></div>";
echo $total_recmmed."::::".$strstr;?>