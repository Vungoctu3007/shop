<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh Sách Hóa Đơn</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Danh Sách Hóa Đơn</h2>
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
           $order = (isset($sub_content['order']) && !empty($sub_content['order'])) ? $sub_content['order'] : null;
            // Lưu ý: Đảm bảo rằng biến $order được truyền vào từ Controller đúng cách
            if (isset($order) && !empty($order)) {
              
                foreach ($order as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['customer_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['employee_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['date_buy']) . "</td>";

                     // Thêm cột Hành Động với các nút thêm, sửa, xóa
                     echo "<td>";
                     echo "<a href='index.php?route=editOrder&id=" . $row['order_id'] . "' class='btn btn-edit'>Sửa</a> ";
                     echo "<a href='index.php?route=deleteOrder&id=" . $row['order_id'] . "' class='btn btn-delete' onclick='return confirm(\"Bạn có chắc chắn muốn xóa không?\")'>Xóa</a>";
                     echo "</td>";

                     
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Không có hóa đơn nào.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
