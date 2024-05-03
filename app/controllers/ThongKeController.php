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
        $thongke = $this->model->getthongke();
        // Đặt dữ liệu và view
        $this->data['content'] = 'blocks/admin/thongkeView';
        $this->data['sub_content'] = ['thongke' => $thongke];
        $this->render('layouts/admin_layout', $this->data);
    }
}