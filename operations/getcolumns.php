<?php
$file = fopen("../vermont-history.csv", "r");
echo json_encode(fgetcsv($file));
fclose($file);