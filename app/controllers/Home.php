<?php

class Home extends Controller
{

    public $data = [], $model = [];

    public function __construct()
    {
        //construct
    }

    public function index()
    {
        $categories = $this->model("categories");
        $dataCategories = $categories->getAllCategories();
        $this->data['content'] = 'home/home';
        $this->data['sub_content']['dataCategories'] = $dataCategories;
        $this->render('layouts/client_layout', $this->data);
    }

}
