<?php
//echo "<pre>";
//print_r($news);
//echo "</pre>";
?>

<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Feedbacks</h2>
            <div class="box-icon" style="position: absolute;">
                <br><br><br>      
First Name: <?=$feedback['feedbacks']['firstname']?><br><br>
Last Name: <?=$feedback['feedbacks']['lastname']?><br><br>
Email:         <?=$feedback['feedbacks']['email']?><br><br>
Subject: <?=$feedback['feedbacks']['subject']?><br><br>
User ID: <?=$feedback['feedbacks']['user_id']?><br><br>
Date:         <?=$feedback['feedbacks']['created']?><br><br><br>
Description: <br><br>
<p1 style="font-size: 15px;"><?=$feedback['feedbacks']['description']?></p1><br>
        

                
            </div>
        </div>
    </div>
</div>