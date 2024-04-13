<<<<<<< HEAD
<?php


class ControllerAdmin extends Controller{

       public $model_home;

       //load homeModel vào controller
       public function __construct()
       {
              //mỗi controller sẽ có thể gọi rất nhiều model và mỗi lần reques xong phải tạo ra  1 đối tượng
              // để tiết kiệm time ta tạo ra 1 model bao gồm 2 việc trên
                 //   $this->model_home = $this->model('HomeModel');
                     //var_dump($this->model_home);
       }


       public function index(){
            $this->render('layouts/admin_layout');
       }
       

    
=======
<?php


class ControllerAdmin extends Controller{

       public $model_home;

       //load homeModel vào controller
       public function __construct()
       {
              //mỗi controller sẽ có thể gọi rất nhiều model và mỗi lần reques xong phải tạo ra  1 đối tượng
              // để tiết kiệm time ta tạo ra 1 model bao gồm 2 việc trên
                 //   $this->model_home = $this->model('HomeModel');
                     //var_dump($this->model_home);
       }




       public function index(){
            $this->render('layouts/admin_layout');
       }
       

    
>>>>>>> f7ce6e5015570c507ce96fc6e9217e5aec2f7dcf
}