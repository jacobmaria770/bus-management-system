<?php
class User {
    protected $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function create($data) {
        $query = "INSERT INTO users (name, email, password, phone, role, status, address) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [$data['name'], $data['email'], Security::hashPassword($data['password']), $data['phone'] ?? null, $data['role'] ?? ROLE_PASSENGER, STATUS_ACTIVE, $data['address'] ?? null];
        $user_id = $this->db->insert($query, $params, 'sssssss');
        if ($user_id) Security::logEvent('User created', 'info', ['user_id' => $user_id, 'role' => $data['role']]);
        return $user_id;
    }

    public function findByEmail($email) {
        return $this->db->fetchOne("SELECT * FROM users WHERE email = ? AND status = ?", [$email, STATUS_ACTIVE], 'ss');
    }

    public function findById($id) {
        return $this->db->fetchOne("SELECT * FROM users WHERE id = ?", [$id], 'i');
    }

    public function findByRole($role) {
        return $this->db->fetchAll("SELECT * FROM users WHERE role = ? AND status = ?", [$role, STATUS_ACTIVE], 'ss');
    }

    public function update($id, $data) {
        $allowed_fields = ['name', 'phone', 'address', 'status'];
        $set_parts = [];
        $params = [];
        $types = '';
        
        foreach ($data as $key => $value) {
            if (in_array($key, $allowed_fields)) {
                $set_parts[] = "$key = ?";
                $params[] = $value;
                $types .= is_int($value) ? 'i' : 's';
            }
        }
        
        if (empty($set_parts)) return false;
        $params[] = $id;
        $types .= 'i';
        
        $query = "UPDATE users SET " . implode(', ', $set_parts) . " WHERE id = ?";
        $this->db->query($query, $params, $types);
        
        if ($this->db->affectedRows() > 0) {
            Security::logEvent('User updated', 'info', ['user_id' => $id]);
            return true;
        }
        return false;
    }

    public function updatePassword($id, $password) {
        $query = "UPDATE users SET password = ? WHERE id = ?";
        $this->db->query($query, [Security::hashPassword($password), $id], 'si');
        if ($this->db->affectedRows() > 0) {
            Security::logEvent('Password changed', 'info', ['user_id' => $id]);
            return true;
        }
        return false;
    }

    public function deactivate($id) {
        $query = "UPDATE users SET status = ? WHERE id = ?";
        $this->db->query($query, [STATUS_INACTIVE, $id], 'si');
        if ($this->db->affectedRows() > 0) {
            Security::logEvent('User deactivated', 'warning', ['user_id' => $id]);
            return true;
        }
        return false;
    }

    public function getAll($filters = []) {
        $query = "SELECT id, name, email, phone, role, status, created_at FROM users WHERE 1=1";
        $params = [];
        $types = '';
        
        if (!empty($filters['role'])) {
            $query .= " AND role = ?";
            $params[] = $filters['role'];
            $types .= 's';
        }
        if (!empty($filters['status'])) {
            $query .= " AND status = ?";
            $params[] = $filters['status'];
            $types .= 's';
        }
        
        $query .= " ORDER BY created_at DESC";
        return $this->db->fetchAll($query, $params, $types);
    }

    public function verify($email, $password) {
        $user = $this->findByEmail($email);
        if (!$user) return false;
        
        if (!Security::verifyPassword($password, $user['password'])) {
            Security::logEvent('Failed login attempt', 'warning', ['email' => $email]);
            return false;
        }
        
        if (Security::needsRehash($user['password'])) {
            $this->updatePassword($user['id'], $password);
        }
        
        Security::logEvent('User logged in', 'info', ['user_id' => $user['id']]);
        return $user;
    }

    public function emailExists($email, $exclude_id = null) {
        $query = "SELECT id FROM users WHERE email = ?";
        $params = [$email];
        $types = 's';
        
        if ($exclude_id) {
            $query .= " AND id != ?";
            $params[] = $exclude_id;
            $types .= 'i';
        }
        
        return $this->db->fetchOne($query, $params, $types) !== null;
    }

    public function countByRole() {
        return $this->db->fetchAll("SELECT role, COUNT(*) as count FROM users WHERE status = ? GROUP BY role", [STATUS_ACTIVE], 's');
    }
}
?>