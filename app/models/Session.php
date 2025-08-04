<?php
namespace app\models;

use app\config\Database;
use PDO;

class Session {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function create($userId, $token, $ip, $userAgent) {
        $expiresAt = date('Y-m-d H:i:s', time() + Database::SESSION_TIMEOUT);
        
        $stmt = $this->db->prepare("
            INSERT INTO sessions (user_id, token, ip_address, user_agent, expires_at)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$userId, $token, $ip, $userAgent, $expiresAt]);
    }

    public function findByToken($token) {
        // Verifica tanto o token quanto a validade
        $stmt = $this->db->prepare("
            SELECT s.*, u.name, u.email 
            FROM sessions s
            JOIN users u ON s.user_id = u.id
            WHERE s.token = ? AND s.expires_at > NOW()
        ");
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    public function delete($token) {
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE token = ?");
        return $stmt->execute([$token]);
    }

    public function renew($token) {
        $newExpires = date('Y-m-d H:i:s', time() + Database::SESSION_TIMEOUT);
        $stmt = $this->db->prepare("
            UPDATE sessions 
            SET expires_at = ? 
            WHERE token = ?
        ");
        return $stmt->execute([$newExpires, $token]);
    }

    public function cleanupExpired() {
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE expires_at <= NOW()");
        return $stmt->execute();
    }

    public function countActiveSessions($userId = null) {
        $sql = "SELECT COUNT(*) as count FROM sessions WHERE expires_at > NOW()";
        $params = [];
        
        if ($userId) {
            $sql .= " AND user_id = ?";
            $params[] = $userId;
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        
        return $result['count'] ?? 0;
    }
}