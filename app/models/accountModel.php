<?php
class accountModel
{
    private $__conn;

    function __construct()
    {
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
    }

    public function getAccountLimit($limit)
    {
        $sql = "SELECT * FROM account LIMIT $limit";
        $result = $this->__conn->query($sql);
        if ($result->num_rows > 0) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }


    public function getAllAccount($rowsPerPage, $offset)
    {
        $sql = "SELECT * FROM account WHERE status_account = 1 LIMIT ?, ?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("ii", $offset, $rowsPerPage);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getAccountById($accountId)
    {
        $sql = "SELECT * FROM account  WHERE account_id = ?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("i", $accountId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }
    public function getTotalQuantityAccount()
    {
        $sql = "SELECT COUNT(*) AS total FROM account WHERE status_account = 1";
        $result = $this->__conn->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }
        return false;
    }
    public function getAllRoleId()
    {
        $sql = "SELECT role_id FROM role";
        $result = $this->__conn->query($sql);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getAllCustomerId()
    {
        $sql = "SELECT customer.customer_id FROM customer";
        $result = $this->__conn->query($sql);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getAllEmployeeId()
    {
        $sql = "SELECT employee.employee_id 
        FROM employee 
        LEFT JOIN account ON employee.employee_id = account.username 
        WHERE account.username IS NULL         
        ";
        $result = $this->__conn->query($sql);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllEmployee()
    {
        $sql = "SELECT employee.employee_id 
        FROM employee       
        ";
        $result = $this->__conn->query($sql);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }


    public function updateAccountStatusById($accountId)
    {
        $sql = "UPDATE account SET status_account = 0 WHERE account_id = ?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("i", $accountId);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }


    public function updateAccount($accountId, $username, $password, $roleId)
    {
        $sql = "UPDATE account SET username = ?, password = ?, role_id = ? WHERE account_id = ?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("ssii", $username, $password, $roleId, $accountId);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }
    public function addAccount($username, $password, $roleId)
    {
        $sql = "INSERT INTO account (username, password, role_id, status_account) VALUES (?, ?, ?, 1)";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("ssi", $username, $password, $roleId);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }
    public function searchAccount($keyword)
    {
        // Thực hiện tìm kiếm account với từ khóa
        $sql = "SELECT * FROM account WHERE account_id LIKE ? OR username LIKE ?";
        $stmt = $this->__conn->prepare($sql);
        // Định dạng keyword để tìm kiếm các từ khóa tương tự
        $keywordLike = "%" . $keyword . "%";
        $stmt->bind_param("ss", $keywordLike, $keywordLike);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
}
