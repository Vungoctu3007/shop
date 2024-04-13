<?php
class Admin extends Controller {
    public $data = [], $model = [];

    public function __construct()
    {
        //construct
    }

    public function index() {
        $this->render('blocks/admin/index', $this->data);
    }
}