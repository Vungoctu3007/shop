<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản Lý Đơn Hàng</title>
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
            /* Add this to maintain column widths */
            height: 500px;
            /* Example default height */
            overflow-y: auto;
            /* Adds a vertical scrollbar to the table body */
        }

        tbody {
            display: block;
            max-height: 500px;
            /* Set max-height to the desired value */
            overflow-y: auto;
            /* Enables scrolling */
        }

        thead,
        tbody tr {
            display: table;
            width: 100%;
            /* Table width is 100% */
            table-layout: fixed;
            /* Table layout is fixed */
        }

        thead {
            width: calc(100% - 1em)
                /* Adjust table header width to account for scrollbar */
        }

        td {
            padding-top: 12px;
            /* Increases padding at the top of the cell */
            padding-bottom: 12px;
            /* Increases padding at the bottom of the cell */
            /* Retain your existing left/right padding if any, or set new values as desired */
            text-align: left;
            /* Ensures content is aligned to the left */
            vertical-align: middle;
            /* Centers content vertically in the cell */
        }

        /* Optional: Add a border or a different background color to alternate rows for better distinction */
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
            margin-right: 8px;
            background-color: #ffc107;
            color: #fff;
        }

        .btn-delete {
            margin-left: 8px;
            background-color: #dc3545;
            color: #fff;
        }

        .search-container {
            margin-bottom: 20px;
            text-align: right;
        }

        .search-container form {
            display: inline-block;
        }

        .search-container input[type="text"] {
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
            display: inline-block;
            text-decoration: none;
            padding: 5px 15px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <h2>Danh Sách Hóa Đơn</h2>
    <!-- Trong orderView.php -->

    <div class="search-container">
        <form action="<?php echo _WEB_ROOT; ?>/bill" method="get">
            <label for="employee_id">Mã Nhân Viên:</label>
            <input type="text" id="employee_id" name="employee_id" required>
            <input type="submit" value="Tìm Kiếm">
        </form>
        <a href="<?php echo _WEB_ROOT; ?>/them-hoa-don" class="btn-add">Thêm Hóa Đơn</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Mã Hóa Đơn</th>
                <th>Mã Khách Hàng</th>
                <th>Mã Nhân Viên</th>
                <th>Tổng Cộng</th>
                <th>Ngày Mua</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>



            <?php


            $order = (isset($sub_content['orders']) && !empty($sub_content['orders'])) ? $sub_content['orders'] : null;

            // Đảm bảo rằng biến $order được truyền vào từ Controller đúng cách
            if (!empty($order)) {
                foreach ($order as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['customer_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['employee_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['date_buy']) . "</td>";

                    // Trong file view, thêm vào cột Hành động cho mỗi dòng hóa đơn
                    echo "<td>";
                    // Thêm nút sửa
                    echo "<a href='" . _WEB_ROOT . "/sua-hoa-don/" . $row['order_id'] . "' class='btn-edit'>Sửa</a>";

                    echo "<a href='" . _WEB_ROOT . "/xoa-hoa-don/" . $row['order_id'] . "' class='btn-delete' >Xóa</a>";
                    echo "</td>";

                    // Thêm nút sửa

                }
            } else {
                echo "<tr><td colspan='6'>Không có hóa đơn nào.</td></tr>";
            }

            ?>
        </tbody>
    </table>

</body>

</html>