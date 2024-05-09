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

        // Kiểm tra xem có bộ lọc ngày bắt đầu và kết thúc không
        $start_date = $_GET['start_date'] ?? null;
        $end_date = $_GET['end_date'] ?? null;

        $datathongke = $this->model->getthongke($offset, $limit);

        if ($start_date && $end_date) {
            // Gọi hàm lọc với ngày bắt đầu và kết thúc
            $datathongke = $this->model->timthongke($start_date, $end_date, $offset, $limit);
        } else {
            // Lựa chọn truy vấn dữ liệu theo giá trị sắp xếp
            if ($sort === 'asc') {
                // Sắp xếp tăng dần
                $datathongke = $this->model->getThongKeAscPaginated($offset, $limit);
            } elseif ($sort === 'desc') {
                // Sắp xếp giảm dần
                $datathongke = $this->model->getThongKeDescPaginated($offset, $limit);
            } else {
                // Mặc định hiển thị theo thứ tự trong cơ sở dữ liệu
                $datathongke = $this->model->getthongke($offset, $limit);
            }
        }

        // Lấy danh sách các năm từ model
        $years = $this->model->getAvailableYears();
        // Lấy doanh thu hàng tháng cho mỗi năm
        $yearlyRevenue = [];
        foreach ($years as $year) {
            $yearlyRevenue[$year] = $this->model->getMonthlyRevenueByYear($year);
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

        $this->data['sub_content']['years'] = $years;
        $this->data['sub_content']['yearlyRevenue'] = $yearlyRevenue;

        $this->render('layouts/admin_layout', $this->data);
    }
}
