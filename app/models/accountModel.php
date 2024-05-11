<?php

class AccountModel {
    protected $db;

    private $__conn;

    function __construct()
    {
        global $db_config;
        // Sử dụng thông tin cấu hình cơ sở dữ liệu để kết nối
        $this->__conn = Connection::getInstance($db_config);
    }

    public function getAccounts() {
        $sql = "SELECT account_id, username FROM account";
        $result = $this->__conn->query($sql);
        $customers = [];
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
        return $customers;
    }
}


?>

