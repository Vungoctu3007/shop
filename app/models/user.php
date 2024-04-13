<?php
class User
{
    private $__conn;

    function __construct()
    {
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
    }

    public function getUserByEmailAndPassword($email, $password)
    {

        $sql = "SELECT * FROM tbl_users WHERE email = ? AND `password` = ?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return $user;
        } else {
            return false;
        }
    }

    public function getUserByGoogle($email)
    {

        $sql = "SELECT * FROM tbl_users WHERE email = ?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return $user;
        } else {
            return false;
        }
    }

    public function getIdUserByEmail($email)
    {
        $sql = 'SELECT id FROM tbl_users WHERE email = ?';
        $stmt = $this->__conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $this->__conn->error);
        }

        $stmt->bind_param('s', $email);

        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addUserByGoogle($name, $email)
    {
        $sql = 'INSERT INTO tbl_users(role_id, name, email) VALUES(?, ?, ?)';
        $stmt = $this->__conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $this->__conn->error);
        }
        $role_id = 2;
        $stmt->bind_param('iss', $role_id, $name, $email);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function addUser($name, $email, $password)
    {
        $sql = 'INSERT INTO tbl_users(role_id, name, email, password) VALUES(?, ?, ?, ?)';
        $stmt = $this->__conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $this->__conn->error);
        }
        $role_id = 2;
        $stmt->bind_param('isss', $role_id, $name, $email, $password);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Hoang Tuan
    public function getAllAccount()
    {
        $listAccount = [];
        $sql = 'SELECT * FROM account';
        $stmt = $this->__conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed : " . $this->__conn->error);
        }

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $listAccount[] = $row;
            }

            $stmt->close();
        } else {
            die("Execute failed : " . $stmt->error);
        }

        return $listAccount;
    }

}
