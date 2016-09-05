<?php

$colquery = "select a.$field2, count(a.$field2) from ($gquery) a group by 1";

$result = mysqli_query($link, $colquery);
mysqli_data_seek($result, 0);
$countquery = "";
if ($field2 != "TOTAL") {
    while ($row = mysqli_fetch_row($result)) {
        $countquery = $countquery . (strlen($countquery) > 0 ? ", " : "") . "sum(case when a.$field2='$row[0]' then 1 else 0 end) as `$row[0]`";
    }
} else {
    $countquery = "count(*) as `TOTAL`";
}

$crossquery = "select a.$field1, $countquery from ($gquery) a group by 1 order by 1";

$result = mysqli_query($link, $crossquery);
$field_cnt = mysqli_num_fields($result);
mysqli_data_seek($result, 0);
$data = "[[";
while ($property = mysqli_fetch_field($result)) {
    $data = $data . "'$property->name',";
}

mysqli_data_seek($result, 0);
while ($row = mysqli_fetch_row($result)) {
    $data = substr($data, 0, strlen($data) - 1) . "],[";
    for ($i = 0; $i <= $field_cnt - 1; $i++) {
        $data = $data . "'$row[$i]',";
    }
}
$data = substr($data, 0, strlen($data) - 1) . "]]";

//echo $data;
$m = strlen($field1) + 4;
$groups = "[" . substr($data, $m + 1, strpos($data, '],') - $m);

?>            