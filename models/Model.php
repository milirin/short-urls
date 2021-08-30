<?php

class Model
{
    protected PDO $db;
    protected string $tableName;

    public function __construct()
    {
        $this->db = (new Database())->pdo;

        if ($this->table) {
            $this->tableName = $this->table;
        } else {
            $this->tableName = strtolower(get_called_class()) . 's';
        }
    }

    public function findAll(): array
    {
        $request = $this->db->prepare("SELECT * FROM $this->tableName");
        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        $request = $this->db->prepare("SELECT * FROM $this->tableName WHERE id = $id");
        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    public function store()
    {
        $request = $this->db->prepare("INSERT INTO $this->tableName (`login`, `email`, `password`) VALUES ('{$this->login}', '{$this->email}', '{$this->password}')");
        $request->execute();

        return $this->findAll();
    }

    public function delete(int $id)
    {
        $request = $this->db->prepare("DELETE FROM $this->tableName WHERE id = $id");
        $request->execute();

        return $this->findAll();
    }
}
