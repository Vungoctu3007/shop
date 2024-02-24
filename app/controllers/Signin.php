<?php

class Signin extends Controller {

    public $data = [], $model = [];

    public function __construct() {

    }

    public function login() {
        $this->render('blocks/clients/signin', $this->data);
    }

    public function processLogin() {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $response = Array();
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            if(empty($email)) {
                $response += [
                    'error_message_email' => 'Vui lòng nhập vào trường này'
                ];
            }

            if(!isset($response['error_message_email'])) {
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $response += [
                        'error_message_email' => 'Email không đúng định dạng'
                    ];
                }
            }

            if(empty($password)) {
                $response += [
                    'error_message_password' => 'Vui lòng nhập vào trường này'
                ];
            }
            $authenticated = $this->authenticate_user($email, $password);

            if($authenticated) {
                if($authenticated['role_id'] == 2) {
                    Session::data('user', $authenticated);
                    $response += [
                        'success' => true,
                        'redirect_url' => 'http://localhost/shop'
                    ];
                } else {
                    $response += [
                        'success' => true,
                        'redirect_url' => 'http://localhost/shop/admin/index'
                    ];
                }
            } else {
                $response += [
                    'success' => false,
                    'error_message_password' => 'Email hoặc mật khẩu không đúng'
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    public function processSignUp() {
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            http_response_code(403);
            exit('Access denied');
        }
    
        $response = [
            'success' => false,
            'error_messages' => [],
        ];

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        if (empty($name)) {
            $response['error_messages']['name'] = 'Vui lòng nhập tên của bạn.';
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        if (empty($email)) {
            $response['error_messages']['email'] = 'Vui lòng nhập email.';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['error_messages']['email'] = 'Email không đúng định dạng.';
        } else if ($this->isEmailExist($email)) {
            $response['error_messages']['email'] = 'Email đã tồn tại.';
        }

        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        if (empty($password)) {
            $response['error_messages']['password'] = 'Vui lòng nhập mật khẩu.';
        } else if (strlen($password) < 8) {
            $response['error_messages']['password'] = 'Mật khẩu phải có ít nhất 8 ký tự.';
        }

        if (empty($response['error_messages'])) {
            try {
                $user = $this->model('user');
                $user->addUser($name, $email, $password); 
                $response['success'] = true;
                $response['redirect_url'] = 'http://localhost/shop/dang-nhap';
            } catch (Exception $e) {
                $response['error_messages'][] = 'Đã có lỗi trong quá trình đăng ký: ' . $e->getMessage();
            }
        }
    
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    

    public function authenticate_user($email, $password) {
        $user = $this->model('user');
        $dataUser = $user->getUserByEmailAndPassword($email, $password);
        return $dataUser;
    }

    public function isEmailExist($email) {
        $user = $this->model('user');
        $result = $user->getIdUserByEmail($email);
        return $result;
    }

    public function logout() {
        Session::delete('user');
        $response = new Response();
        $response->redirect('dang-nhap');
    }
}




