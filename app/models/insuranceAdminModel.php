<?php

class InsuranceAdminModel
{
    private $conn;
    public function __construct()
    {
        global $db_config;
        $this->conn = Connection::getInstance($db_config);
    }

    public function getAllInsurance($page, $pageSize)
    {
        // Convert $page and $pageSize to integers
        $page = (int) $page;
        $pageSize = (int) $pageSize;

        // Calculate the starting row
        $start = ($page - 1) * $pageSize;
        if ($start < 0) {
            $start = 0;
        }

        $sql = "SELECT COUNT(*) as total_records FROM insurance";
        $result = $this->conn->query($sql);
        $total_records = $result->fetch_assoc()['total_records'];
        $total_page = ceil($total_records / $pageSize);

        $sql = "SELECT * FROM insurance JOIN employee ON insurance.insurance_id = employee.employee_id JOIN customer ON customer.customer_id = insurance.customer_id LIMIT $start, $pageSize";
        $result = $this->conn->query($sql);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return array("data" => $data, "total_page" => $total_page);
        }
        return false;
    }
}


?>