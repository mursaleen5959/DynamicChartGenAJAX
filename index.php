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
    <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <div class="text-center">
        <h1>Chart</h1>
        <form action="">
            <label for="">X Axis</label>
            <select name="" id="x_labels"></select>
            <label for="">Y Axis</label>
            <select name="" id="y_data"></select>
            <button type="button" id="generateG">Generate Graph</button>
        </form>
        <br><br>
        <div style="width: 600px; margin:auto;" id="canvasContainer">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</body>
<script>
    $(document).ready(function () {        
        $.ajax({
            url: "operations/getcolumns.php",
            type: "POST",
            dataType: 'JSON',
            success: function(result)
            {
                var data = '';
                for(i=0;i<result.length;i++)
                {
                    //console.log(result);
                    data +="<option value='"+i+"'>"+result[i]+"</option>";
                }
                //console.log(data);
                $("#x_labels").html(data);
                $("#y_data").html(data);
            }
        });
        $("#generateG").click(function () {
            var colx = $("#x_labels").val();
            var coly = $("#y_data").val();
            $.ajax({
            url: "operations/getData.php",
            type: "POST",
            data:{columnX:colx,columnY:coly},
            dataType: 'JSON',
            success: function(result)
            {
                //console.log(result);
                generateChart(result['labels'],result['data']);
            }
        }); 
        });
    });

    function generateChart(xLabels,yData) {
        $('#myChart').remove(); // deleting canvas element
        $('#canvasContainer').append('<canvas id="myChart"></canvas>');
        
        
        const ctx = document.getElementById('myChart');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: xLabels,
                datasets: [{
                    label: '#',
                    data: yData,
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
        console.log(chart);
    }
</script>

</html>

<?php
fclose($file);
?>