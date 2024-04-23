<?php
// Đảm bảo rằng các biến này đã được định nghĩa và có dữ liệu từ controller
//var_dump($order_info);
//var_dump($customers);
//var_dump($employees);
?>

<form action="<?php echo _WEB_ROOT; ?>/cap-nhat-hoa-don/<?php echo $order_info['order_id']; ?>" method="post">
    
    <!-- Trường chọn Khách Hàng -->
    <label for="customer_id">Chọn Khách Hàng:</label>
    <select name="customer_id" id="customer_id">
        <?php foreach ($customers as $customer): ?>
            <option value="<?php echo htmlspecialchars($customer['customer_id']); ?>"
                <?php echo ($customer['customer_id'] == $order_info['customer_id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($customer['customer_id']); // Sử dụng tên hoặc thông tin đặc trưng khác của khách hàng ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Trường chọn Nhân Viên -->
    <label for="employee_id">Chọn Nhân Viên:</label>
    <select name="employee_id" id="employee_id">
        <?php foreach ($employees as $employee): ?>
            <option value="<?php echo htmlspecialchars($employee['employee_id']); ?>"
                <?php echo ($employee['employee_id'] == $order_info['employee_id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($employee['employee_id']); // Sử dụng tên hoặc thông tin đặc trưng khác của nhân viên ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Trường nhập Tổng Cộng -->
    <label for="total">Tổng Cộng:</label>
    <input type="text" id="total" name="total" value="<?php echo htmlspecialchars((string)$order_info['total']); ?>" required>

    <!-- Trường nhập Ngày Mua -->
    <label for="date_buy">Ngày Mua:</label>
    <?php
    $formatted_date = date('Y-m-d', strtotime($order_info['date_buy']));
   
    ?>
    <input type="date" id="date_buy" name="date_buy" value="<?php echo htmlspecialchars($formatted_date); ?>" required>

    <input type="submit" value="Cập Nhật Hóa Đơn">
</form>

<!-- Kết thúc của file editOrder.php -->