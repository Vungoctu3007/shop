<?php
class Insurance_Admin extends Controller
{
    public $data = [], $model = [];
    public function __construct()
    {

    }
    public function index()
    {
        $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 8;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $insurance = $this->model("InsuranceAdminModel");
        $Insurance = $insurance->getAllInsurance($page, $pageSize);
        $this->data['content'] = 'blocks/admin/insurance';
        $this->data['sub_content']['dataInsurance'] = $Insurance;
        $this->render('layouts/admin_layout', $this->data);
    }
    public function loadData()
    {
        $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 8;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $insurance = $this->model("InsuranceAdminModel");
        $Insurance = $insurance->getAllInsurances($page, $pageSize);
        header('Content-Type: application/json');
        echo json_encode($Insurance, $page);
    }
}

?>