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
    
    
    


}
