<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thống kê</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #0a0a23;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            table-layout: fixed;
            height: 500px;
            overflow-y: auto;
        }

        tbody {
            display: block;
            max-height: 500px;
            overflow-y: auto;
        }

        thead,
        tbody tr {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        thead {
            width: calc(100% - 1em);
        }

        td {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .btn-edit,
        .btn-delete {
            padding: 5px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #fff;
            margin-right: 8px;
        }

        .btn-delete {
            background-color: #dc3545;
            color: #fff;
            margin-left: 8px;
        }

        .search-container {
            margin-bottom: 20px;
            text-align: right;
        }

        .search-container form {
            display: inline-block;
        }

        .search-container input[type="text"],
        .search-container input[type="date"] {
            padding: 5px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-container input[type="submit"] {
            padding: 5px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .btn-add {
            padding: 5px 15px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            margin-left: 10px;
            text-decoration: none;
        }

        #revenueChartContainer {
            width: 100%;
            margin-top: 20px;
        }

        .statistics-container {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .statistic {
            background: #f4f4f4;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            width: 20%;
            text-align: center;
        }






        canvas {
            width: 100%;
            max-width: 800px;
            /* Adjust as needed */
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <div class="statistics-container">
        <h1>Thống Kê Tổng Quan</h1>
        <div class="statistic">
            <h2>Tổng Doanh Thu</h2>
            <p><?= number_format($totalRevenue); ?> VND</p>
        </div>
        <div class="statistic">
            <h2>Tổng Sản Phẩm Đã Bán</h2>
            <p><?= number_format($totalProductsSold); ?> sản phẩm </p>
        </div>
        <div class="statistic">
            <h2>Tổng Nhân Viên Bán Hàng</h2>
            <p><?= number_format($totalSalesStaff); ?> nhân viên </p>
        </div>
        <div class="statistic">
            <h2>Tổng Khách Hàng</h2>
            <p><?= number_format($totalCustomers); ?> khách hàng</p>
        </div>
    </div>



    <div class="search-container">
        <form action="<?php echo _WEB_ROOT; ?>/thongke" method="get">
            <label for="start_date">Ngày Bắt Đầu:</label>
            <input type="date" id="start_date" name="start_date" required>
            <label for="end_date">Ngày Kết Thúc:</label>
            <input type="date" id="end_date" name="end_date" required>
            <input type="submit" value="Tìm Kiếm">
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mã Hóa Đơn</th>
                    <th>Mã Khách Hàng</th>
                    <th>Mã Nhân Viên</th>
                    <th>Tổng Cộng</th>
                    <th>Ngày Mua</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($datathongke)) {
                    foreach ($datathongke as $row) {
                        echo "<tr>"; // Start of row
                        echo "<td>" . htmlspecialchars($row['order_id'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($row['customer_id'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($row['employee_id'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($row['total'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($row['date_buy'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($row['product_name'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($row['quantity'] ?? '') . "</td>";
                        echo "</tr>"; // End of row


                    }
                } else {
                    echo "<tr><td colspan='7'>Không có dữ liệu</td></tr>";
                }
                ?>



            </tbody>
        </table>
    </div>
    <!-- Container for the revenue chart -->
    <div id="revenueChartContainer">
        <canvas id="revenueChart"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(ctx, {
            type: 'line', // Type of chart: line chart
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], // Full year labels
                datasets: [{
                    label: 'Doanh thu 2024',
                    data: [0,1500000, 1200000, 1800000, 1600000, 2000000, 2100000, 1900000, 2200000, 2050000, 1950000, 2300000, 2500000], // Example data for each month
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 30000000, // Set maximum scale value to 100 million VND
                        ticks: {
                            // Include a dollar sign in the ticks and format numbers with commas for readability
                            callback: function(value, index, values) {
                                return value.toLocaleString() + ' VND';
                            }
                        }
                    }
                }
            }
        });
    </script>


</body>



</html>