<?php 
class CustomerModel
{
    private $conn;
    public function __construct()
    {
        global $db_config;
        $this->conn = Connection::getInstance($db_config);
    }

public function getAllCustomer($page, $pageSize)
{
    $page = (int) $page;
    $pageSize = (int) $pageSize;

    // Calculate the starting row
    $start = ($page - 1) * $pageSize;
    if ($start < 0) {
        $start = 0;
    }

    // Prepare the SQL query with LIMIT clause
    $sql = "SELECT * FROM customer LIMIT ?, ?";
    $stmt = $this->conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute
        $stmt->bind_param("ii", $start, $pageSize);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $stmt->close();

            // Get total records count
            $sql_count = "SELECT COUNT(*) as total_records FROM customer";
            $result_count = $this->conn->query($sql_count);
            $total_records = $result_count->fetch_assoc()['total_records'];

            // Calculate total pages
            $total_pages = ceil($total_records / $pageSize);

            return array("data" => $data, "total_page" => $total_pages);
        } else {
            $stmt->close();
            return false;
        }
    } else {
        // Handle SQL statement preparation error
        return false;
    }
}

    public function getEmployeeById($employee_id)
    {
        $sql = "SELECT * FROM employee e
        JOIN account a ON a.username = e.employee_id
        WHERE employee_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }
    public function insertEmployee($employee_name, $employee_phone, $employee_address, $employee_email)
    {
        $sql = "INSERT INTO employee(employee_name, employee_phone, employee_address, employee_email) VALUES(?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $employee_name, $employee_phone, $employee_address, $employee_email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }
    public function updateEmployee($employee_id, $employee_name, $employee_phone, $employee_address, $employee_email)
    {
        $sql = "UPDATE employee SET employee_name = ?, employee_phone = ?, employee_address = ?, employee_email = ? WHERE employee_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $employee_name, $employee_phone, $employee_address, $employee_email, $employee_id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function searchEmployee($keyword, $page)
    {
        $page = (int) $page;
        $pageSize = (int) 8;

        // Calculate the starting row
        $start = ($page - 1) * $pageSize;
        if ($start < 0) {
            $start = 0;
        }
        $sql = "SELECT * FROM employee e WHERE e.employee_id LIKE '%$keyword%' 
        or e.employee_name LIKE '%$keyword%' 
        or e.employee_phone LIKE '%$keyword%' 
        or e.employee_email LIKE '%$keyword%'
        LIMIT $start, $pageSize
        ";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }

    }
}
?>