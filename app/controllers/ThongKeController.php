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
        $limit = 10; // Số mục mỗi trang
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($currentPage - 1) * $limit;

        // Lấy giá trị sắp xếp
        $sort = $_GET['sort'] ?? null;

        // Lựa chọn truy vấn dữ liệu theo giá trị sắp xếp
        if ($sort === 'asc') {
            // Sắp xếp tăng dần
            $datathongke = $this->model->getThongKeAscPaginated($offset, $limit);
        } elseif ($sort === 'desc') {
            // Sắp xếp giảm dần
            $datathongke = $this->model->getThongKeDescPaginated($offset, $limit);
        } else {
            // Mặc định hiển thị theo thứ tự trong cơ sở dữ liệu
            $datathongke = $this->model->getthongkePaginated($offset, $limit);
        }

        // Tổng số bản ghi
        $totalRecords = $this->model->countThongkeRecords();
        $totalPages = ceil($totalRecords / $limit);

        // Lấy các dữ liệu khác như doanh thu, biểu đồ
        $monthlyRevenue = $this->model->getMonthlyRevenue();
        $salesByCategory = $this->model->getSalesByCategory();

        $totalRevenue = $this->model->getTotalRevenue();
        $totalProductsSold = $this->model->getTotalProductsSold();
        $totalSalesStaff = $this->model->getTotalSalesStaff();
        $totalAccounts = $this->model->getTotalAccounts();

        // Đặt dữ liệu và view
        $this->data['content'] = 'blocks/admin/thongke';
        $this->data['sub_content']['datathongke'] = $datathongke;
        $this->data['sub_content']['totalRevenue'] = $totalRevenue;
        $this->data['sub_content']['totalProductsSold'] = $totalProductsSold;
        $this->data['sub_content']['totalSalesStaff'] = $totalSalesStaff;
        $this->data['sub_content']['totalAccounts'] = $totalAccounts;
        $this->data['sub_content']['monthlyRevenue'] = $monthlyRevenue;
        $this->data['sub_content']['salesByCategory'] = $salesByCategory;
        $this->data['sub_content']['totalPages'] = $totalPages;
        $this->data['sub_content']['currentPage'] = $currentPage;

        $this->render('layouts/admin_layout', $this->data);
    }
}
