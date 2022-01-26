<?php

$timezone = "GMT+0530";
$today = date("Y-m-d");
//$endTime = strtotime($today.' 00:00:00 '.$timezone);

//$startTime = strtotime('-1 day', $endTime);


$endTime = strtotime("now");
$startTime = strtotime($today.' 00:00:00 '.$timezone);

echo $timezone ."\n";
echo $today ."\n" ;
echo $endTime ."\n";
echo $startTime ."\n";

echo "Diff:" . ($endTime-$startTime)/3600 ."\n";


echo "now:" . strtotime("now") . "\n";
//echo strtotime("10 September 2000"), "\n";
//echo strtotime("+1 day"), "\n";
//echo strtotime("+1 week"), "\n";
//echo strtotime("+1 week 2 days 4 hours 2 seconds"), "\n";
//echo strtotime("next Thursday"), "\n";
//echo strtotime("last Monday"), "\n";

header("location: wwww.google.co.in");

?>