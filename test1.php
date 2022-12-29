<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$file = fopen("vermont-history.csv", "r");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>

    </style>
    <title>Document</title>
</head>

<body>
    <div class="text-center">
        <h1>Chart</h1>
        <br><br>
        <div style="width: 600px; margin:auto;">
            <canvas id="myChart"></canvas>
        </div>
    </div>



</body>
<script>
    <?php
    $skip_num = 1;
    $labels = array();
    $deaths = array();
    while (!feof($file)) {
        if ($skip_num == 1) {
            fgetcsv($file);
            $skip_num = 0;
            continue;
        } else {
            $data = fgetcsv($file);
            // echo $data[0];
            //print_r($data);
            array_push($labels, $data[0]);
            array_push($deaths, $data[2]);
        }
    }
    ?>


    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?=json_encode($labels)?>,
            datasets: [{
                label: '# of Deaths',
                data: <?=json_encode($deaths)?>,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</html>

<?php
fclose($file);
?>