<?php
class ThongKeController extends Controller{

    public $data = [], $model = [];

    public function __construct()
    {
        // Khởi tạo model hóa đơn để sử dụng trong toàn bộ controller này
        $this->model = $this->model("thongkeModel"); // Đảm bảo rằng bạn có model tên là 'hoadonadmin'
    }

    public function index()
    {
               
        $this->data['content'] = 'blocks/admin/thongke';

        // Gọi đến layout chính của admin và truyền mảng data
        $this->render('layouts/admin_layout', $this->data);
    }
}