<?php
namespace App\Models;

class Author
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM tacgia ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tacgia WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function searchByName($keyword)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tacgia WHERE tentacgia LIKE ?");
        $stmt->execute(['%' . $keyword . '%']);
        return $stmt->fetchAll();
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO tacgia (tentacgia, tieusu) VALUES (?, ?)");
        return $stmt->execute([
            $data['tentacgia'],
            $data['tieusu'] ?? null,
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE tacgia SET tentacgia = ?, tieusu = ? WHERE id = ?");
        return $stmt->execute([
            $data['tentacgia'],
            $data['tieusu'] ?? null,
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM tacgia WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
