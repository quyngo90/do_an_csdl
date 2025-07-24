<?php

namespace App\Models;

class Category
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM theloai ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM theloai WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function searchByName($keyword)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM theloai WHERE tentheloai LIKE ?");
        $stmt->execute(['%' . $keyword . '%']);
        return $stmt->fetchAll();
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO theloai (tentheloai) VALUES (?)");
        return $stmt->execute([
            $data['tentheloai'],
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE theloai SET tentheloai = ? WHERE id = ?");
        return $stmt->execute([
            $data['tentheloai'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM theloai WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
