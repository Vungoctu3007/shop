<?php
class OrderController extends Controller
{
    public $data = [], $model = [];

    public function __construct()
    {
        // Khởi tạo model hóa đơn để sử dụng trong toàn bộ controller này
        $this->model = $this->model("orderModel"); // Đảm bảo rằng bạn có model tên là 'hoadonadmin'
    }

    public function index()
    {

        $order = $this->model->getAllorder();

        // Đặt dữ liệu và view cần sử dụng cho danh sách hóa đơn
        $this->data['content'] = 'blocks/admin/orderView'; // Đường dẫn đến file view danh sách hóa đơn trong phần quản trị
        $this->data['sub_content']['order'] = $order;

        // Render view sử dụng layout của admin
        $this->render('layouts/orderadmin_layout', $this->data); // Đường dẫn đến layout của admin
    }

    // Thêm các phương thức khác nếu cần (ví dụ: xem chi tiết hóa đơn, cập nhật, xóa...)
    public function add()
    {
        // Kiểm tra dữ liệu POST và gọi model để thêm đơn hàng
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            // Tiền xử lý dữ liệu $_POST ở đây
            $result = $this->model->addOrder($_POST);
            if ($result) {
                // Handle success (e.g., redirect, set a success message, etc.)
            } else {
                // Handle error
            }
        }

        // Load view để thêm đơn hàng
        // $this->data['content'] = 'path/to/add_order_view';
        // $this->render('layouts/orderadmin_layout', $this->data);
    }

    public function edit($orderId)
    {
        // Kiểm tra dữ liệu POST và gọi model để cập nhật đơn hàng
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            // Tiền xử lý dữ liệu $_POST ở đây
            $result = $this->model->updateOrder($orderId, $_POST);
            if ($result) {
                // Handle success
            } else {
                // Handle error
            }
        }

        // Nạp dữ liệu đơn hàng cần chỉnh sửa để hiển thị lên form
        // $order = $this->model->getOrderById($orderId);
        // $this->data['sub_content']['order'] = $order;

        // Load view để sửa đơn hàng
        // $this->data['content'] = 'path/to/edit_order_view';
        // $this->render('layouts/orderadmin_layout', $this->data);
    }

    public function delete($orderId) {
        // Kiểm tra ID và quyền hạn xóa ở đây
        // Bạn cũng có thể muốn kiểm tra xem người dùng đã đăng nhập và có quyền xóa hay không

        // Gọi phương thức deleteOrder từ model và truyền vào orderId
        $result = $this->model->deleteOrder($orderId);
        
        // Xử lý kết quả
        if ($result) {
            // Xóa thành công
            // Bạn có thể thêm một thông báo thành công vào session flash message ở đây nếu muốn

            // Chuyển hướng người dùng về trang danh sách hóa đơn hoặc thông báo thành công
            header('Location: index.php?route=bill');
            exit();
        } else {
            // Xóa thất bại
            // Bạn có thể thêm một thông báo lỗi vào session flash message ở đây nếu muốn

            // Hiển thị thông báo lỗi hoặc chuyển hướng người dùng về trang lỗi
            // header('Location: index.php?route=errorPage');
            exit();
        }
    }

}
