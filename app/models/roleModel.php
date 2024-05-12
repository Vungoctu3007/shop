<?php
class roleModel
{
    private $__conn;

    function __construct()
    {
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
    }
    public function getAllRoles()
    {
        $sql = "SELECT * FROM role";
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


    public function getDetailRoleById($role_id)
    {
        $sql = "SELECT role.role_id, role.role_name, task.task_id, task.task_name 
                FROM detail_task_role
                JOIN task ON task.task_id = detail_task_role.task_id
                JOIN role ON role.role_id = detail_task_role.role_id
                WHERE role.role_id = ?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("i", $role_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function getAllTask()
    {
        $sql = "SELECT * FROM task";
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


    public function updateRole($roleId, $tasks)
    {
        $this->__conn->begin_transaction();

        try {
            // Xác định các task_id mới
            $newTaskIds = [];
            foreach ($tasks as $task) {
                $newTaskIds[] = $task['task_id'];
            }

            // Xóa các nhiệm vụ cũ không còn tồn tại trong $tasks
            $deleteSql = "DELETE FROM detail_task_role WHERE role_id = ? AND task_id NOT IN (" . implode(",", $newTaskIds) . ")";
            $deleteStmt = $this->__conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $roleId);
            $deleteStmt->execute();

            // Thêm các nhiệm vụ mới cho vai trò
            $insertSql = "INSERT INTO detail_task_role (role_id, task_id) VALUES (?, ?)";
            $insertStmt = $this->__conn->prepare($insertSql);

            foreach ($tasks as $task) {
                $task_id = $task['task_id'];
                $insertStmt->bind_param("ii", $roleId, $task_id);
                $insertStmt->execute();
            }

            $this->__conn->commit();
            return true;
        } catch (Exception $e) {
            $this->__conn->rollback();
            return false;
        }
    }



    //add role
    public function addRole($roleName, $tasks)
    {
        $this->__conn->begin_transaction();

        try {
            // Thêm vai trò mới vào bảng role
            $insertRoleSql = "INSERT INTO role (role_name) VALUES (?)";
            $insertRoleStmt = $this->__conn->prepare($insertRoleSql);
            $insertRoleStmt->bind_param("s", $roleName);
            $insertRoleStmt->execute();

            // Lấy ID của vai trò mới được thêm vào
            $roleId = $insertRoleStmt->insert_id;

            // Thêm các nhiệm vụ cho vai trò
            $insertDetailSql = "INSERT INTO detail_task_role (role_id, task_id) VALUES (?, ?)";
            $insertDetailStmt = $this->__conn->prepare($insertDetailSql);

            foreach ($tasks as $task) {
                $task_id = $task['task_id'];
                $insertDetailStmt->bind_param("ii", $roleId, $task_id);
                $insertDetailStmt->execute();
            }

            $this->__conn->commit();
            return true;
        } catch (Exception $e) {
            $this->__conn->rollback();
            return false;
        }
    }
    public function deleteRole($role_id){
        $sql = "DELETE FROM role WHERE role_id =?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("i", $role_id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }   
    }
}
