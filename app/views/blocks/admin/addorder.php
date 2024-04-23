<form action="<?php echo _WEB_ROOT; ?>/xu-ly-them-hoa-don" method="post">

    <label for="customer">Chọn Khách Hàng:</label>
    <select name="customer_id" id="customer_id">
        <?php foreach ($customers as $customer): ?>
            <option value="<?php echo htmlspecialchars($customer['customer_id']); ?>">
                <?php echo htmlspecialchars($customer['customer_id']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <label for="employee">Chọn Nhân Viên:</label>
    <select name="employee_id" id="employee_id">
        <?php foreach ($employees as $employee): ?>
            <option value="<?php echo htmlspecialchars($employee['employee_id']); ?>">
                <?php echo htmlspecialchars($employee['employee_id']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Các trường khác của form... -->
       <!-- Trường nhập tổng cộng -->
       <input type="text" name="total" placeholder="Tổng Cộng" required>
    
    <!-- Trường chọn ngày mua -->
    <label for="date_buy">Ngày Mua:</label>
    <input type="date" id="date_buy" name="date_buy" required>

    <input type="submit" value="Thêm Hóa Đơn">
</form>