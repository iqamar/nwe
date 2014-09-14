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
foreach ($news_detail as $news__Row) {
	$created_date = $news__Row['News']['created'];
		$year = date("Y", strtotime($created_date));
		$month = date("M", strtotime($created_date));
		$day = date("d", strtotime($created_date));
		$time = date("H:i:s", strtotime($created_date));
		//echo $news__Row['News']['image_url'];
	$MessagePdf .= '<div class="doc_logo"><img src="http://demo.networkwe.com/images/nt-logo.png" /></div>
	<div class="header_row"><strong>'.$news__Row['News']['heading'].' </strong></div>
	<div class="auther">
		<span> <strong>By:&nbsp;</strong></span>'.$news__Row['users_profiles']['firstname'].' &nbsp;, '.$day." ".$month.", ".$year." at ".$time.'.</div>
	<div class="detail"><img src="http://dev.networkwe.com/files/news_logo/'.$news__Row['News']['image_url'].'" />'.$news__Row['News']['details'].'</div>';
}
$MessagePdf .='</div>';
echo $MessagePdf;
?>