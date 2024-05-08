<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thống kê</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
        }

        h1,
        h2 {
            text-align: center;
            color: #28527a;
            /* Màu xanh đậm */
            margin-bottom: 20px;
            font-weight: bold;
        }

        .table-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #6c757d;
            /* Màu xám đậm */
            color: #ffffff;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .statistics-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .statistic {
            background: #ffffff;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
            margin: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            width: calc(25% - 20px);
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .statistic:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        #revenueChartContainer {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .btn-edit,
        .btn-delete,
        .btn-add,
        .search-container input[type="submit"] {
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            color: #fff;
            transition: background-color 0.3s ease;
        }

        .btn-edit {
            background-color: #f0ad4e;
        }

        .btn-edit:hover {
            background-color: #ffc107;
        }

        .btn-delete {
            background-color: #d9534f;
        }

        .btn-delete:hover {
            background-color: #c9302c;
        }

        .btn-add {
            background-color: #5cb85c;
        }

        .btn-add:hover {
            background-color: #4cae4c;
        }

        .search-container input[type="text"],
        .search-container input[type="date"] {
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 8px;
        }

        .search-container {
            text-align: right;
            margin-bottom: 20px;
        }

        #revenueChartContainer {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .chartjs-tooltip {
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            border-radius: 3px;
            padding: 10px;
        }

        .chartjs-render-monitor {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* Đảm bảo phông chữ nhất quán */
        }

        /* Tăng độ đậm của nhãn trên các trục */
        .chartjs-render-monitor {
            font-weight: bold;
            /* Đặt độ đậm */
        }


        /*  css bieu do tron */
        #categorySalesChartContainer {
            width: 60%;
            /* Set the width of the pie chart container */
            margin: 20px auto;
            /* Center the container on the page and add some margin above and below */
            padding: 20px;
            background-color: #fff;
            /* White background for the chart */
            border-radius: 8px;
            /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for depth */
        }

        canvas {
            display: block;
            /* Ensures the canvas has no extra space around it */
            max-width: 100%;
            /* Ensures the canvas is responsive and does not overflow its container */
            height: auto;
            /* Maintains aspect ratio */
        }

        /* Container chứa cả sắp xếp và tìm kiếm */
        .controls-container {
            display: flex;
            justify-content: space-between;
            /* Đảm bảo khoảng cách đều giữa các phần tử */
            align-items: center;
            /* Căn giữa theo chiều dọc */
            margin-bottom: 20px;
            padding: 10px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        /* Sắp xếp */
        .sort-container {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }

        .btn-sort-dropdown {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-sort-dropdown:hover {
            background-color: #0056b3;
        }

        .sort-options {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 5px;
            overflow: hidden;
        }

        .sort-options a {
            color: #333;
            padding: 8px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
            transition: background-color 0.3s;
        }

        .sort-options a:hover {
            background-color: #ddd;
        }

        .sort-container:hover .sort-options {
            display: block;
        }

        /* Tìm kiếm */
        .search-container input[type="text"],
        .search-container input[type="date"] {
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 8px;
            margin-right: 10px;
        }

        .search-container input[type="submit"] {
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            color: #fff;
            background-color: #28a745;
            transition: background-color 0.3s ease;
        }

        .search-container input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

</head>

<body>

    <div class="statistics-container">
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
            <h2>Tổng Tài khoản Mua Hàng</h2>
            <p><?= number_format($totalAccounts); ?> Tài khoản</p>
        </div>
    </div>

    <div class="controls-container">
        <div class="sort-container">
            <button class="btn-sort-dropdown">Sắp xếp</button>
            <div class="sort-options">
                <a href="<?= _WEB_ROOT; ?>/thongke?sort=asc" class="btn-sort">Sắp xếp tăng dần</a>
                <a href="<?= _WEB_ROOT; ?>/thongke?sort=desc" class="btn-sort">Sắp xếp giảm dần</a>
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
                        echo "<td>" . htmlspecialchars($row['account_id'] ?? '') . "</td>";
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
        <div class="pagination">
            <?php if ($currentPage > 1) : ?>
                <a href="<?= _WEB_ROOT; ?>/thongke?page=<?= $currentPage - 1 ?>">« Trang Trước</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <a href="<?= _WEB_ROOT; ?>/thongke?page=<?= $i ?>" <?= $i == $currentPage ? 'class="active"' : '' ?>><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages) : ?>
                <a href="<?= _WEB_ROOT; ?>/thongke?page=<?= $currentPage + 1 ?>">Trang Sau »</a>
            <?php endif; ?>
        </div>

    </div>
    <!-- biểu đồ cột -->
    <div id="revenueChartContainer">
        <canvas id="revenueChart"></canvas>
    </div>

    <!-- biểu đồ tròn -->
    <div id="categorySalesChartContainer">
        <canvas id="categorySalesChart"></canvas>
    </div>


    <script>
        var ctx = document.getElementById('revenueChart').getContext('2d');
        var revenueData = <?= json_encode($monthlyRevenue); ?>;
        var revenueChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Doanh thu 2024',
                    data: revenueData,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontColor: '#333', // Màu chữ
                            fontSize: 16, // Kích cỡ font
                            fontWeight: 'bold' // Độ đậm
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            fontColor: '#333', // Màu chữ
                            fontSize: 16, // Kích cỡ font
                            fontWeight: 'bold' // Độ đậm
                        }
                    }]
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                    bodyFontColor: '#000',
                    bodyFontStyle: 'bold',
                    bodyFontSize: 14,
                    titleFontColor: '#000',
                    titleFontSize: 14,
                    titleFontStyle: 'bold',
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1
                }
            }
        });
    </script>

    <script>
        var ctx = document.getElementById('categorySalesChart').getContext('2d');
        var salesData = <?= json_encode($data['salesByCategory']); ?>;
        console.log('Sales Data:', salesData);

        var categories = salesData.map(data => data.category);
        var sales = salesData.map(data => parseInt(data.sales, 10)); // Đảm bảo rằng sales là số nguyên
        var total = sales.reduce((acc, val) => acc + val, 0); // Tổng doanh số

        console.log('Total Sales:', total);

        var categorySalesChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: categories,
                datasets: [{
                    data: sales,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#F7464A', '#BADA55'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                let label = categories[tooltipItem.dataIndex];
                                let value = sales[tooltipItem.dataIndex];
                                let percentage = ((value / total) * 100).toFixed(2); // Tính phần trăm chính xác
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    </script>
    <style>
        .pagination {
            text-align: center;
            margin: 20px 0;
        }

        .pagination a {
            margin: 2px;
            padding: 8px 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            background-color: #f4f4f4;
            color: #007bff;
            cursor: pointer;
        }

        .pagination a.active {
            background-color: #007bff;
            color: #fff;
        }

        .pagination a:hover {
            background-color: #0056b3;
            color: #fff;
        }
    </style>


</body>

</html>