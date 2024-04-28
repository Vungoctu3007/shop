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
       

        $start_date = $_GET['start_date'] ?? null;
        $end_date = $_GET['end_date'] ?? null;

        if ($start_date && $end_date) {
            // Tìm kiếm hóa đơn trong khoảng thời gian
            $orders = $this->model->getOrdersByDateRange($start_date, $end_date);
        } else {
            // Lấy tất cả hóa đơn nếu không có thông tin tìm kiếm
            $orders = $this->model->getAllorder();
        }

        // Đặt dữ liệu và view
        $this->data['content'] = 'blocks/admin/orderView';
        $this->data['sub_content'] = ['orders' => $orders];
        $this->render('layouts/admin_layout', $this->data);
    }


    // Thêm các phương thức khác nếu cần (ví dụ: xem chi tiết hóa đơn, cập nhật, xóa...)
    // Phương thức xử lý yêu cầu xóa hóa đơn
    public function delete($orderId)
    {
        $result = $this->model->deleteOrder($orderId);
        if ($result) {
            // Xóa thành công, bạn có thể chuyển hướng người dùng hoặc hiển thị thông báo
            header('Location: ' . _WEB_ROOT . '/bill');
        } else {
            // Xử lý khi không thể xóa hóa đơn
            echo "Không thể xóa hóa đơn.";
        }
    }



    // Phương thức xử lý thêm hóa đơn
    public function add()
    {
        $this->data['content'] = 'addOrder';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form
            $customer_id = $_POST['customer_id'];
            $employee_id = $_POST['employee_id'];
            $status_order_id = $_POST['status_order_id'];
            $total = $_POST['total'];
            $date_buy = $_POST['date_buy'];

            // Bạn có thể muốn thêm các bước validate dữ liệu ở đây

            // Chuẩn bị dữ liệu để thêm vào database
            $orderData = [
                'customer_id' => $customer_id,
                'employee_id' => $employee_id,
                'status_order_id' => $status_order_id, // Thêm dòng này
                'total' => $total,
                'date_buy' => $date_buy
            ];

            // Thực hiện thêm hóa đơn thông qua model
            $result = $this->model->addOrder($orderData);

            // Kiểm tra kết quả và phản hồi
            if ($result) {
                // Chuyển hướng đến trang danh sách hóa đơn sau khi thêm thành công
                header('Location: ' . _WEB_ROOT . '/bill');
                exit;
            } else {
                // Hiển thị thông báo lỗi
                echo "Có lỗi khi thêm hóa đơn. Vui lòng thử lại.";
            }
        } else {
            // Nếu không phải POST request, chỉ hiển thị form thêm hóa đơn
            $this->showAddForm();
        }
    }

    // Phương thức hiển thị form thêm hóa đơn
    public function showAddForm()
    {
        // Tạo instance của CustomerModel và EmployeeModel
        $customerModel = $this->model("CustomerModel");
        $employeeModel = $this->model("EmployeeModel");

        // Lấy danh sách khách hàng và nhân viên từ các model
        $customers = $customerModel->getCustomers();
        $employees = $employeeModel->getEmployees();

        // Truyền danh sách khách hàng và nhân viên tới view thông qua mảng data
        $this->data['customers'] = $customers;
        $this->data['employees'] = $employees;

        // Render view addorder với dữ liệu đã truyền
        $this->render('blocks/admin/addorder', $this->data);
    }


    public function edit($orderId)
    {

        $this->data['content'] = 'editOrder';
        // Lấy thông tin khách hàng và nhân viên để hiển thị danh sách lựa chọn
        $customerModel = $this->model("CustomerModel");
        $employeeModel = $this->model("EmployeeModel");


        $orderInfo = $this->model->getOrderById($orderId);
        $customers = $customerModel->getCustomers();
        $employees = $employeeModel->getEmployees();

        $this->data['order_info'] = $orderInfo;
        $this->data['customers'] = $customers;
        $this->data['employees'] = $employees;


        // Render view sử dụng layout của admin
        $this->render('blocks/admin/editOrder', $this->data);
    }

    public function update($orderId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form
            $customer_id = $_POST['customer_id'];
            $employee_id = $_POST['employee_id'];
            $total = $_POST['total'];
            $date_buy = $_POST['date_buy'];
            $status_order_id = $_POST['status_order_id']; // Đảm bảo rằng form gửi lên có trường này

            // Chuẩn bị dữ liệu để cập nhật
            $orderData = [
                'customer_id' => $customer_id,
                'employee_id' => $employee_id,
                'total' => $total,
                'date_buy' => $date_buy,
                'status_order_id' => $status_order_id // Thêm trạng thái vào dữ liệu cập nhật
            ];

            // Thực hiện cập nhật thông qua model
            $result = $this->model->updateOrder($orderId, $orderData);

            if ($result) {
                // Chuyển hướng đến trang danh sách hóa đơn sau khi cập nhật thành công
                header('Location: ' . _WEB_ROOT . '/bill');
                exit;
            } else {
                // Hiển thị thông báo lỗi
                echo "Có lỗi khi cập nhật hóa đơn. Vui lòng thử lại.";
            }
        } else {
            // Trường hợp không phải POST request, có thể xử lý khác hoặc trả về lỗi
            echo "Yêu cầu không hợp lệ.";
        }
    }

    // tiềm kiếm

    public function searchByEmployee()
    {
        $employee_id = $_GET['employee_id'] ?? null;

        if ($employee_id) {
            $orders = $this->model->getOrdersByEmployeeId($employee_id);
        } else {
            $orders = $this->model->getAllOrders();
        }

        // Đặt dữ liệu và view
        $this->data['sub_content']['order'] = $orders;
        $this->render('layouts/orderadmin_layout', $this->data);
    }

    // chi tiết hóa đơn
    public function getOrderProductDetails($orderId)
    {
        $productDetails = $this->model->getOrderDetails($orderId);
    
        // Kiểm tra xem có dữ liệu không
        if (!$productDetails) {
            // Xử lý trường hợp không lấy được dữ liệu
            echo "Không thể lấy chi tiết sản phẩm của hóa đơn.";
            return;
        }
    
        // Nếu có dữ liệu, gán nó vào mảng data và gọi view
        $this->data['product_details'] = $productDetails;
        $this->data['content'] = 'chitietsp'; 

        $this->render('blocks/admin/chitietsp', $this->data);
       // $this->render('layouts/admin_layout', $this->data); // đảm bảo bạn có layout này
    }
    
}
