<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Summary Dashboard</title>
    <!-- Link to Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        h2, h4 {
            font-family: 'Arial', sans-serif;
            font-weight: 700;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 40px;
        }

        /* Styling for the cards */
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            padding: 30px;
            text-align: center;
        }

        .card-title {
            font-size: 1.6rem;
            color: #1abc9c;
            font-weight: 600;
        }

        .card-text {
            font-size: 1.4rem;
            font-weight: bold;
            color: #34495e;
        }

        .table th {
            background-color: #16a085;
            color: white;
            font-weight: bold;
            text-align: center;
            font-size: 1.1rem;
        }

        .table td {
            text-align: center;
            font-size: 1.1rem;
            color: #34495e;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #ecf0f1;
        }

        .table-striped tbody tr:hover {
            background-color: #95a5a6;
            color: white;
        }

        .list-group-item {
            background-color: #ecf0f1;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .list-group-item:hover {
            background-color: #16a085;
            color: white;
            cursor: pointer;
        }

        footer {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            font-size: 1rem;
            text-align: center;
            margin-top: 40px;
        }

        footer p {
            margin-bottom: 0;
        }

        .col-md-4 {
            margin-bottom: 30px;
        }

        /* List-group item hover */
        .col-md-4 .card-body {
            padding: 40px 30px;
        }

        /* Responsive card design */
        @media (max-width: 768px) {
            .card-body {
                padding: 20px 10px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Sensor Summary Dashboard</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Max Temperature</h5>
                    <p class="card-text" id="max-temp">Loading...</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Min Temperature</h5>
                    <p class="card-text" id="min-temp">Loading...</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Avg Temperature</h5>
                    <p class="card-text" id="avg-temp">Loading...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Max Temperature and Max Humidity Details -->
    <div class="row mt-4">
        <div class="col-12">
            <h4>Max Temperature and Max Humidity Records</h4>
            <table class="table table-striped table-bordered mt-2" id="max-humidity-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Timestamp</th>
                        <th>Temperature (°C)</th>
                        <th>Humidity (%)</th>
                        <th>Brightness (Lux)</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be inserted here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Max Temp Month-Year Records -->
    <div class="row mt-4">
        <div class="col-12">
            <h4>Month-Year Records for Max Temperature</h4>
            <ul class="list-group mt-2" id="month-year-list">
                <!-- Data will be inserted here -->
            </ul>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <p></p>
</footer>

<!-- Bootstrap 5 JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<!-- JS to Fetch Data from API and Display it -->
<script>
    // Fetch data from the API
    fetch('http://localhost/uts_iot/api/sensor_summary')
        .then(response => response.json())
        .then(data => {
            // Update Max, Min, and Avg Temperature
            document.getElementById('max-temp').textContent = data.suhumax + ' °C';
            document.getElementById('min-temp').textContent = data.suhumin + ' °C';
            document.getElementById('avg-temp').textContent = data.suhurata + ' °C';

            // Populate Max Temperature and Max Humidity Records Table
            const tableBody = document.getElementById('max-humidity-table').getElementsByTagName('tbody')[0];
            data.nilai_suhu_max_humid_max.forEach(row => {
                const newRow = tableBody.insertRow();
                newRow.innerHTML = `
                    <td>${row.idx}</td>
                    <td>${row.timestamp}</td>
                    <td>${row.suhun} °C</td>
                    <td>${row.humid} %</td>
                    <td>${row.kecerahan} Lux</td>
                `;
            });

            // Populate Month-Year Records List
            const monthYearList = document.getElementById('month-year-list');
            data.month_year_max.forEach(record => {
                const listItem = document.createElement('li');
                listItem.classList.add('list-group-item');
                listItem.textContent = record.month_year;
                monthYearList.appendChild(listItem);
            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
</script>

</body>
</html>
