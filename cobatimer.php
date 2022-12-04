<?php
$time_start = round(microtime(true) * 1000);
$acak = rand(60,300);
echo $acak."<br>";
echo $time_start."<br>";
$temp = true;
while ($temp) {
    $time_end = round(microtime(true) * 1000);
    echo $time_end."<br>";
    if($time_end>$time_start+$acak){
        echo "done";
        $temp = false;
    }
}
  
$time = $time_end - $time_start;
  
echo "The speed of code = ".$time; 
?>