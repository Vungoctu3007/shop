<?php
class Admin extends Controller {
    public $data = [], $model = [];

    public function __construct()
    {
        //construct
    }

    public function index() {
        $this->render('layouts/admin_layout', $this->data);
    }
}