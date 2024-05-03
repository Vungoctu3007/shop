<?php
class ThongkeController extends Controller
{

    public $data = [], $model = [];

    public function __construct()
    {
        $this->model = $this->model("thongkeModel"); 
    }


    public function index()
    {

        $start_date = $_GET['start_date'] ?? null;
        $end_date = $_GET['end_date'] ?? null;

        if ($start_date && $end_date) {
            // Tìm kiếm hóa đơn trong khoảng thời gian
            $thongke = $this->model->timthongke($start_date, $end_date);
        } else {
            // Lấy tất cả hóa đơn nếu không có thông tin tìm kiếm
            $thongke = $this->model->getthongke();
        }

       
        $totalRevenue = $this->model->getTotalRevenue();
        $totalProductsSold = $this->model->getTotalProductsSold();
        $totalSalesStaff = $this->model->getTotalSalesStaff();
        $totalCustomers = $this->model->getTotalCustomers();

        // Đặt dữ liệu và view
        $this->data['content'] = 'blocks/admin/thongke';
        $this->data['sub_content']['datathongke'] = $thongke;
        $this->data['sub_content']['totalRevenue'] = $totalRevenue;
        $this->data['sub_content']['totalProductsSold'] = $totalProductsSold;
        $this->data['sub_content']['totalSalesStaff'] = $totalSalesStaff;
        $this->data['sub_content']['totalCustomers'] = $totalCustomers;

        $this->render('layouts/admin_layout', $this->data);
    }
}