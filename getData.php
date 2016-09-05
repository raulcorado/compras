<?php
include 'conection.php';

$query = "select paguesea, count(1) from pagos group by 1";


$result = mysqli_query($link, $query);
 
$str1='{
"cols": [
            {"id":"","label":"UP","pattern":"","type":"string"},
            {"id":"","label":"TOTAL", "pattern":"","type":"number"}
        ],
"rows": [';

$i=0; 

mysqli_data_seek($result, 0);
while ($row = mysqli_fetch_row($result)) {
    $str1.=($i++>0?',':'');
    $str1.='{"c":[{"v":"'.$row[0].'", "f":null},{"v":'.$row[1].',"f":null}]}';
}
$str1.=']}';

echo $str1;

?>