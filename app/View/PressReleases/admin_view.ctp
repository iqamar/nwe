<?php
//echo "<pre>";
//print_r($news);
//echo "</pre>";
?>

<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> News Article <?php
if($press[0]['press_releases']['image_url'] != NULL){
?>
                <img height="30" width="30" src="<?=$press[0]['press_releases']['image_url']?>" style="position: absolute; left: 1286px;"/>
        <?php
}
        ?></h2>
            <div class="box-icon" style="position: absolute;">
                <br><br><br>
                Headline: <?=$press[0]['press_releases']['headline']?><br>
                Date: <?=$press[0]['press_releases']['created']?><br>
                Organization Info: <?=$press[0]['press_releases']['organization_info']?><br>
                City:<?=$press[0]['press_releases']['city']?><br>
                Country:<?=$country['countries']['name']?><br>
                Contact Info: <?=$press[0]['press_releases']['contact_info']?><br><br><br>
                <?=$press[0]['press_releases']['details']?><br>
        

            </div>
        </div>
    </div>
</div>