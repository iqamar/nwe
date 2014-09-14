<?php
$mysqli = new mysqli("localhost","nwe_db_agent","hh#MWN?2]94GPjq","networkwe_jupiter");
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = "SELECT email FROM users_old limit 0,10000";
$result = $mysqli->query($query);

$output = fopen("php://output",'w') or die("Can't open php://output");
header("Content-Type:application/csv"); 
header("Content-Disposition:attachment;filename=nwecsv_10k.csv"); 
fputcsv($output, array('email'));
while($row = $result->fetch_array(MYSQLI_BOTH)){
//$rows[]=$row[0];
fputcsv($output, array($row[0]));
}

fclose($output) or die("Can't close php://output");
//echo "<pre>";
//print_r($rows);
?>
