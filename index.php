<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<body>
    <div class="sidebar">
        <h4>Admin Dashboard</h4>
        <hr>
        <a href="#Dashboard">Dashboard</a>
        <a href="categories.php" style="padding-top: 10px;">Categories</a>
        <a href="products.php" style="padding-top: 10px;">Products</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Dashboard</h2>
        <hr>
        <div style="padding-top:15px; padding-bottom: 15px;" class="d-flex justify-content-around">
             <div class="card">
                <div class="card-title">Number of Categories</div>
                <div class="card-number">   <?php
                    require_once 'login.php';
                    $conn = new mysqli($hn, $un, $pw, $db);
                    if ($conn->connect_error) die($conn->connect_error);
                      $query = "SELECT * FROM categories";
                    $result = $conn->query($query);
                    if (!$result) die ("Database access failed: " . $conn->error);
                    $rows = $result->num_rows;
                    echo $rows;
                ?></div>
            </div>
            <div class="card">
                <div class="card-title">Number of products</div>
                <div class="card-number">   <?php
                    require_once 'login.php';
                    $conn = new mysqli($hn, $un, $pw, $db);
                    if ($conn->connect_error) die($conn->connect_error);
                    $query = "SELECT * FROM products";
                    $result = $conn->query($query);
                    if (!$result) die ("Database access failed: " . $conn->error);
                    $rows = $result->num_rows;
                    echo $rows;
                ?></div>
            </div>
        </div>
        <hr>
        <div style="padding-top:20px;" class="d-flex justify-content-center">
            <div id="piechart" style="width:100%;max-width:480px"></div>
            <!-- <canvas id="myChart1" style="width:100%;max-width:480px"></canvas> -->
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS"
        crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        // Load google charts
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);

        // Draw the chart and set the chart values
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Category', 'Number of product per categories'],
                <?php
                    require_once 'login.php';
                    $conn = new mysqli($hn, $un, $pw, $db);
                    if ($conn->connect_error) die($conn->connect_error);
                    $query = "SELECT c.name AS category_name, COUNT(p.id) AS product_count FROM categories c JOIN products p ON c.id = p.categories_id GROUP BY c.name";
                    $result = $conn->query($query);
                    if (!$result) die ("Database access failed: " . $conn->error);
                    $rows = $result->num_rows;
                    for ($j = 0; $j < $rows; ++$j) {
                    $result -> data_seek($j);
                    $row = $result -> fetch_array(MYSQLI_NUM);
                    echo "['".$row[0]."',".$row[1]."],";
                    }
                ?>
            ]);

            // Optional; add a title and set the width and height of the chart
            var options = { 'title': 'Number of product per categories', 'width': 550, 'height': 400 };

            // Display the chart inside the <div> element with id="piechart"
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    </script>
    <script>
        var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
        var yValues = [55, 49, 44, 24, 15];
        var barColors = ["red", "green", "blue", "orange", "brown"];

        new Chart("myChart1", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                legend: { display: false },
                title: {
                    display: true,
                    text: "World Wine Production 2018"
                }
            }
        });
    </script>
</body>

</html>