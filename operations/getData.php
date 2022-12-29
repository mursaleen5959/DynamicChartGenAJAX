<?php
$file = fopen("../vermont-history.csv", "r");

$x = $_POST['columnX'];
$y = $_POST['columnY'];

$skip_num = 1;
$labels = array();
$data = array();
$response = array();

while (!feof($file)) {
    if ($skip_num == 1) {
        fgetcsv($file);
        $skip_num = 0;
        continue;
    } else {
        $buffer = fgetcsv($file);
        array_push($labels, $buffer[$x]);
        array_push($data, $buffer[$y]);
    }
}

$response['labels'] = $labels;
$response['data'] = $data;

echo json_encode($response);
fclose($file);
