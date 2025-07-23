<?php
require_once __DIR__ . '/../../config/database.php';

class BorrowDetail {
    public static function create($data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO chitietmuon 
            (id_phieumuon, id_sach, soluong, giaphat) 
            VALUES (:id_phieumuon, :id_sach, :soluong, :giaphat)");
        
        $stmt->bindValue(':id_phieumuon', $data['id_phieumuon']);
        $stmt->bindValue(':id_sach', $data['id_sach']);
        $stmt->bindValue(':soluong', $data['soluong']);
        $stmt->bindValue(':giaphat', $data['giaphat'] ?? 0);
        
        return $stmt->execute();
    }
    
    public static function getByBorrowId($borrowId) {
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT cm.*, s.tensach, s.anhbia 
                FROM chitietmuon cm
                JOIN sach s ON cm.id_sach = s.id
                WHERE cm.id_phieumuon = ?";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$borrowId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>