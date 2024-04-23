<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản Lý Đơn Hàng</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        .btn-edit,
        .btn-delete {
            cursor: pointer;
            padding: 5px 10px;
            border: none;
            background-color: #f0f0f0;
            margin-right: 5px;
        }

        .btn-delete {
            background-color: #ffcccc;
        }
    </style>
</head>

<body>
    <h2>Danh Sách Hóa Đơn</h2>
    <!-- Trong orderView.php -->

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
         
            <a href="<?php echo _WEB_ROOT; ?>/them-hoa-don">Thêm Hóa Đơn</a>

            <!-- Form tìm kiếm hóa đơn theo mã nhân viên -->
            <form action="<?php echo _WEB_ROOT; ?>/bill" method="get">
                <label for="employee_id">Mã Nhân Viên:</label>
                <input type="text" id="employee_id" name="employee_id" required>
                <input type="submit" value="Tìm Kiếm">
            </form>
        
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

                    echo "<a href='" . _WEB_ROOT . "/xoa-hoa-don/" . $row['order_id'] . "' class='btn-delete'>Xóa</a>";
                    echo "</td>";

                    // Thêm nút sửa

                }
            } else {
                echo "<tr><td colspan='6'>Không có hóa đơn nào.</td></tr>";
            }

            ?>
        </tbody>
    </table>