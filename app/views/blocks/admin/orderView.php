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

        /* css cho form chi tiết  */
        #orderDetails {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: auto;
            max-width: 600px;
            /* Giới hạn chiều rộng tối đa */
            box-sizing: border-box;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            /* Bo góc cho khung */
            z-index: 1000;
            display: none;
            /* Ẩn div cho đến khi được gọi */

            /* Đặt giá trị này cao hơn các phần tử khác */
            overflow: visible;

            overflow: auto;
            /* cho phép scroll nếu nội dung quá dài */
            padding-top: 30px;
            /* Thêm đủ không gian cho nút đóng */
        }

        #orderDetails>div {
            margin-bottom: 10px;
            /* Khoảng cách giữa các thông tin */
        }

        /* nút xem chi tiết */
        .btn-view {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9rem;
            background-color: #f0ad4e;
            /* Màu cam cho nút Xem Chi Tiết */
            color: #fff;
            margin-left: 8px;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            /* Đảm bảo văn bản trong nút không bị xuống dòng */
        }

        .btn-view:hover {
            background-color: #ec971f;
            /* Màu sẫm hơn khi hover */
        }


        /* nút đóng chi tiết */
        #orderDetails button {
            padding: 5px 10px;
            border: none;
            background-color: #dc3545;
            color: white;
            border-radius: 5px;
            font-size: 0.9rem;
            position: relative;
            /* hoặc `absolute` tùy thuộc vào cấu trúc của bạn */
            z-index: 1001;
            /* Giá trị phải lớn hơn z-index của các phần tử khác */

        }

        #orderDetails button:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <h2>Danh Sách Hóa Đơn</h2>
    <!-- Trong orderView.php -->

    <div class="search-container">
        <form action="<?php echo _WEB_ROOT; ?>/bill" method="get">
            <label for="start_date">Ngày Bắt Đầu:</label>
            <input type="date" id="start_date" name="start_date" required>
            <label for="end_date">Ngày Kết Thúc:</label>
            <input type="date" id="end_date" name="end_date" required>
            <input type="submit" value="Tìm Kiếm">
        </form>
        <!-- <a href="<?php echo _WEB_ROOT; ?>/them-hoa-don" class="btn-add">Thêm Hóa Đơn</a>  -->
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mã Hóa Đơn</th>
                    <th>Mã Khách Hàng</th>
                    <th>Mã Nhân Viên</th>
                    <th>Trạng Thái</th> <!-- Tiêu đề cột mới -->
                    <th>Tổng Cộng</th>
                    <th>Ngày Mua</th>
                    <th class="action-column">Hành động</th>
                </tr>
            </thead>
            <tbody>



                <?php


                $order = (isset($sub_content['orders']) && !empty($sub_content['orders'])) ? $sub_content['orders'] : null;

                // Đảm bảo rằng biến $order được truyền vào từ Controller đúng cách
                if (!empty($order)) {
                    foreach ($order as $row) {
                        $jsonData = htmlspecialchars(json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8');
                        echo "<tr onclick='showDetails($jsonData)'>"; // Thêm sự kiện onclick vào đây
                        echo "<tr>";
                        echo "<td >" . htmlspecialchars($row['order_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['customer_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['employee_id']) . "</td>";
                        // Cột trạng thái
                        echo "<td>";
                        switch ($row['status_order_id']) {
                            case 1:
                                echo 'Chờ Xử Lý';
                                break;
                            case 2:
                                echo 'Đã Xử Lý';
                                break;
                            case 3:
                                echo 'Đã Hủy';
                                break;
                            default:
                                echo 'Không xác định'; // Đối với trạng thái không xác định
                        }
                        echo "</td>";
                        echo "<td>" . htmlspecialchars($row['total']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date_buy']) . "</td>";

                        // Trong file view, thêm vào cột Hành động cho mỗi dòng hóa đơn
                        echo "<td >";
                        // Thêm nút sửa
                        echo "<a href='" . _WEB_ROOT . "/sua-hoa-don/" . $row['order_id'] . "' class='btn-edit'>Sửa</a>";
                        // echo "<a href='" . _WEB_ROOT . "/get-order-products/" . $row['order_id'] . "' class='btn-view'>Xem Sản Phẩm</a>";

                        echo "<a href='" . _WEB_ROOT . "/xoa-hoa-don/" . $row['order_id'] . "' class='btn-delete' >Xóa</a>";
                        echo "<a href='javascript:void(0);' class='btn-view' onclick='showDetails(" . json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . ")'>Chi Tiết</a>";
                        echo "</td>";

                        // Thêm nút sửa

                    }
                } else {
                    echo "<tr><td colspan='6'>Không có hóa đơn nào.</td></tr>";
                }


                ?>

            </tbody>
        </table>

    </div>

    <!---  show chi tiết hóa đơn --->
    <div id="orderDetails" style="display: none; padding: 20px; background-color: white; border: 1px solid #ccc; margin-top: 20px;">
        <!-- Thông tin chi tiết sẽ được thêm vào đây bởi JavaScript -->
        <button onclick="closeDetails()" style="position: absolute; top: 5px; right: 10px; cursor: pointer;">Đóng</button>
        <!-- Trong file view, thêm vào cột Hành động cho mỗi dòng hóa đơn -->
    </div>




</body>


<script>
    var _WEB_ROOT = '<?php echo _WEB_ROOT; ?>';



    function showOrderProducts(orderId) {
        window.location.href = _WEB_ROOT + '/get-order-products/' + orderId;
    }

    function showDetails(orderData) {
        var detailDiv = document.getElementById('orderDetails');
        var detailsHtml = '<div><strong>Mã Hóa Đơn:</strong> ' + orderData.order_id + '</div>' +
            '<div><strong>Mã Khách Hàng:</strong> ' + orderData.customer_id + '</div>' +
            '<div><strong>Mã Nhân Viên:</strong> ' + orderData.employee_id + '</div>' +
            '<div><strong>Tổng Cộng:</strong> ' + orderData.total + '</div>' +
            '<div><strong>Ngày Mua:</strong> ' + orderData.date_buy + '</div>' +
            '<div><strong>Trạng Thái:</strong> ' + getStatusText(orderData.status_order_id) + '</div>';

        // Thêm nút Xem Sản Phẩm
        detailsHtml += '<button onclick="showOrderProducts(' + orderData.order_id + ')">Xem Sản Phẩm</button>';

        detailDiv.innerHTML = detailsHtml;
        detailDiv.style.display = 'block';

        // Đảm bảo nút đóng được thêm vào div chi tiết
        var closeButton = document.createElement('button');
        closeButton.textContent = 'Đóng';
        closeButton.onclick = closeDetails;
        closeButton.style = 'position: absolute; top: 5px; right: 10px; cursor: pointer;';
        detailDiv.appendChild(closeButton);
    }





    // Đảm bảo rằng giá trị trạng thái được xử lý đúng cách
    function getStatusText(statusId) {
        switch (parseInt(statusId)) {
            case 1:
                return 'Chờ Xử Lý';
            case 2:
                return 'Đã Xử Lý';
            case 3:
                return 'Đã Hủy';
            default:
                return 'Không xác định';
        }
    }

    function closeDetails() {
        var detailDiv = document.getElementById('orderDetails');
        detailDiv.style.display = 'none';

      
    }
</script>

</html>