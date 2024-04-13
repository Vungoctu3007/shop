<?php
class Account extends Controller
{
    public $data = [], $model = [];
    public function __construct()
    {

    }
    public function index($urlAccount = '')
    {
        $account = $this->model('user');
        $dataAccount = $account->getAllAccount();
        $this->data['content'] = 'block/admin/account';
        $this->data['sub_content']['content'] = $dataAccount;
        $this->render('layouts/admin_layout', $this->data);

    }
}
