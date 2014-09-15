<div class="info">
	<!--
		Note: The date should be formatted exactly as it's shown below. In particular, the
		"least significant" characters of the month should be encapsulated in a <span>
		element to denote what gets dropped in 1200px mode (eg. the "uary" in "January").
		Oh, and if you don't need a date for a particular page or post you can simply delete
		the entire "date" element.
		2013-09-09
	-->
	<?php 
		$start_month=date('M',strtotime($jobDetail['Job']['start_date']));  
		$start_day=date('d',strtotime($jobDetail['Job']['start_date'])); 
		
		$end_month=date('M',strtotime($jobDetail['Job']['expiry_date']));  
		$end_day=date('d',strtotime($jobDetail['Job']['expiry_date'])); 
	?>
	<span class="date"><span class="month"><?php echo $start_month; ?><span>ember</span></span> <span class="day"><?php echo $start_day; ?></span><span class="year">, 2013</span></span>
	<!--
		Note: You can change the number of list items in "stats" to whatever you want.
	-->
	<ul class="stats">
		<li><a id="fancybox" href="#inline" class="button next" style="color:#fff;">Apply</a></li>
		<li><a id="fancybox1" href="#inline1" class="button" style="color:#fff;">Forword To Friend</a></li>
		<li><a href="#" class="link-icon24 link-icon24-1">16</a></li>
		<li><a href="#" class="link-icon24 link-icon24-2">32</a></li>
		<li><a href="#" class="link-icon24 link-icon24-3">64</a></li>
		<li><a href="#" class="link-icon24 link-icon24-4">128</a></li>
	</ul>										
	<span class="date" style="border:0px solid #DDDDDD;padding: 1em 0 0;margin: 0.75em 0 0 0;border-top:1px solid #DDDDDD;"><span class="month"><?php echo $end_month;?><span>ember</span></span> <span class="day"><?php echo $end_day; ?></span><span class="year">, 2013</span></span>
</div>