<?php

class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->pdo;
    }

    public function findAll(): array
    {
        if ($this->tableName) {
            $tableName = $this->tableName;
        } else {
            $tableName = strtolower(get_called_class()) . 's';
        }
        $request = $this->db->prepare("SELECT * FROM $tableName");
        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        if ($this->tableName) {
            $tableName = $this->tableName;
        } else {
            $tableName = strtolower(get_called_class()) . 's';
        }
        $request = $this->db->prepare("SELECT * FROM $tableName WHERE id = $id");
        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    public function store()
    {
        if ($this->tableName) {
            $tableName = $this->tableName;
        } else {
            $tableName = strtolower(get_called_class()) . 's';
        }
        $request = $this->db->prepare("INSERT INTO $tableName (`login`, `email`, `password`) VALUES ('{$this->login}', '{$this->email}', '{$this->password}')");
        $request->execute();

        return $this->findAll();
    }

    public function delete(int $id)
    {
        if ($this->tableName) {
            $tableName = $this->tableName;
        } else {
            $tableName = strtolower(get_called_class()) . 's';
        }
        $request = $this->db->prepare("DELETE FROM $tableName WHERE id = $id");
        $request->execute();

        return $this->findAll();
    }
}
