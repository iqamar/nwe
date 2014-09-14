<?php 
$MessagePdf = '
	<html>
	<head>
	<style type="text/css">
	.con_mydep_decs{ float:left; width:100%; margin:2px 10px; padding:2px 0px;    }
	.con_mydep_dec{ float:left; width:730px; margin:2px 2px; font-size:12px; padding:4px 0px 3px 0px; background:url(images/stock_w_desc.jpg) repeat-x bottom; }
	.sep{ height:2px; margin:8px 7px; clear:both; border-bottom:#e0e0e0 1px solid; border-top:#e0e0e0 1px solid; margin-left:2px;}
	.timesheetbg{ margin:2px; color:#1d1160; font-weight:lighter; }
	.timesheetbg .timesheet3{ float:left; width:420px; padding:3px 5px; line-height:30px; }
	.timesheetbg .timesheet4{ float:left; min-width:40px; padding:3px 5px; margin-left:7px}
	.select_inp{ float:left; min-width:50px; margin:2px 4px; }
	.sep2{  text-align:right; margin:2px 7px; }
	.header_row{ color:#006AD5; font-weight:bold; font-size:14px; }
	.text_row{ color:#333; font-size:12px; }
	.detail {color:#333; font-size:12px; text-align:justify; margin-top:10px;}
	.auther {color:#858585; font-weight:bold; font-size:12px; margin-right:15px;}
	.doc_logo { width:100%; padding-bottom:10px; border-bottom:1px solid #ccc; margin-bottom:10px;}
	</style>
	</head>
	<body>
	<div class="con_mydep_decs" width="100%" style="margin:2px;">';
foreach ($press_detail_pdf as $press__Row) {
	$created_date = $press__Row['press_releases']['created'];
		$year = date("Y", strtotime($created_date));
		$month = date("M", strtotime($created_date));
		$day = date("d", strtotime($created_date));
		$time = date("H:i:s", strtotime($created_date));
		$today_date = date('Y-m-d H:i:s');
		$t_year = date("Y", strtotime($today_date));
		$t_month = date("M", strtotime($today_date));
		$t_day = date("d", strtotime($today_date));
		$t_time = date("H:i:s", strtotime($today_date));
		//echo $news__Row['News']['image_url'];
	$MessagePdf .= '<div class="doc_logo"><img src="http://demo.networkwe.com/images/nt-logo.png" /></div>
	<div class="auther"><strong>Download on,&nbsp;'.$t_day." ".$t_month.", ".$t_year." at ".$t_time.' </strong></div>
		<div class="auther">
		<span> <strong>Published on &nbsp;, </strong></span> '.$day." ".$month.", ".$year." at ".$time.'.</div>
	<div class="header_row"><strong>'.$press__Row['press_releases']['headline'].' </strong></div>
	<div class="detail"><img src="http://dev.networkwe.com/files/press_logo/'.$press__Row['press_releases']['image_url'].'" />'.$press__Row['press_releases']['details'].'</div>
	<div class="detail"><strong>Contact Information</strong><br /><strong>Email:</strong>press@networkwe.com<br />'.$press__Row['press_releases']['contact_info'].'</div>
	<div class="detail"><strong>Organization Information</strong><br />'.$press__Row['press_releases']['organization_info'].'</div>';
}
$MessagePdf .='</div>';
echo $MessagePdf;
?>